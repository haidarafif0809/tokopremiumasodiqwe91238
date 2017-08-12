<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';

$kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
$no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'id_produk', 
    1=>'nama',
    2=>'harga_konversi',
    3=>'no_faktur',
    4=>'tanggal',
    5=>'kode_barang', 
    6=>'nama_barang',
    7=>'jumlah_barang',
    8=>'satuan',
    9=>'harga',
    10=>'subtotal', 
    11=>'potongan',
    12=>'tax',
    13=>'status',
    14=>'sisa', 
    15=>'kode_pelanggan',
    16=>'nama_pelanggan',
    17=>'asal_satuan',
    18=>'sisa_barang',
    19=>'id',


);
// getting total number records without any search
$sql =" SELECT b.id AS id_produk , ss.nama AS satuan_asal ,dp.harga_konversi,dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, dp.sisa, p.kode_pelanggan, pl.nama_pelanggan, dp.asal_satuan, SUM(hk.sisa_barang) as sisa_barang ,s.nama ";
$sql.=" FROM detail_penjualan dp INNER JOIN hpp_keluar hk ON dp.no_faktur = hk.no_faktur AND dp.kode_barang = hk.kode_barang INNER JOIN penjualan p ON dp.no_faktur = p.no_faktur INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id INNER JOIN satuan s ON dp.satuan = s.id
      INNER JOIN satuan ss ON dp.asal_satuan = ss.id  INNER JOIN barang b ON dp.kode_barang = b.kode_barang ";
$sql.=" WHERE hk.sisa_barang > '0' AND p.kode_pelanggan = '$kode_pelanggan' GROUP BY dp.no_faktur, dp.kode_barang ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT b.id AS id_produk , ss.nama AS satuan_asal ,dp.harga_konversi,dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, dp.sisa, p.kode_pelanggan, pl.nama_pelanggan, dp.asal_satuan, SUM(hk.sisa_barang) as sisa_barang ,s.nama ";
$sql.=" FROM detail_penjualan dp INNER JOIN hpp_keluar hk ON dp.no_faktur = hk.no_faktur AND dp.kode_barang = hk.kode_barang INNER JOIN penjualan p ON dp.no_faktur = p.no_faktur INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id INNER JOIN satuan s ON dp.satuan = s.id
      INNER JOIN satuan ss ON dp.asal_satuan = ss.id  INNER JOIN barang b ON dp.kode_barang = b.kode_barang ";
$sql.=" WHERE hk.sisa_barang > '0' AND p.kode_pelanggan = '$kode_pelanggan' GROUP BY dp.no_faktur, dp.kode_barang ";

    $sql.=" AND ( dp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR dp.no_faktur LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' ) ";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY dp.kode_barang DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

    $konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$row[satuan]' AND kode_produk = '$row[kode_barang]'");
    $data_konversi = mysqli_fetch_array($konversi);
    $num_rows = mysqli_num_rows($konversi);

    if ($num_rows > 0) {
        $sisa = $row['sisa_barang'] % $data_konversi['konversi'];
        $harga = $row['harga_konversi'];
    }
    else{
        $sisa = $row['sisa_barang'];
        $harga = $row['harga'];
    }

    if ($sisa == 0) {
        $harga = rp($harga);
        $konversi = $row['sisa_barang'] / $data_konversi['konversi']." ".$row['nama'];
        $satuan = $row['satuan'];
    }
    else{
        $harga = rp($row['harga']);
        $konversi = koma($row['sisa_barang'],2)." ".$row['satuan_asal'];
        $satuan = $row['asal_satuan'];
    }

    $nestedData=array(); 

        $nestedData[] = $row["no_faktur"];
        $nestedData[] = $row["kode_barang"];
        $nestedData[] = $row["nama_barang"];
        $nestedData[] = $row["nama"];
        $nestedData[] = $harga;
        $nestedData[] = koma($row["potongan"],2);
        $nestedData[] = koma($row["tax"],2);
        $nestedData[] = koma($row["subtotal"],2);
        $nestedData[] = $konversi;
        $nestedData[] = rp($row['harga']);
        $nestedData[] = $row['asal_satuan'];
        $nestedData[] = $satuan;
        $nestedData[] = $row['jumlah_barang'];
        $nestedData[] = $row['id_produk'];
        $nestedData[] = $sisa;
    
    $data[] = $nestedData;
        
}



$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

 ?>