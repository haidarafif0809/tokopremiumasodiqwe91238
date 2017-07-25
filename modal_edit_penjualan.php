<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';

/* Database connection end */
$no_faktur = stringdoang($_POST['no_faktur']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

   0=>'kode_barang', 
    1=>'nama_barang',
    2=>'harga_jual',
    3=>'harga_jual2',
    4=>'harga_jual3',
    5=>'harga_jual4', 
    6=>'harga_jual5',
    7=>'harga_jual6',
    8=>'harga_jual7',
    9=>'jumlah_barang', 
    10=>'nama',
    11=>'kategori',
    12=>'suplier',
    13=>'limit_stok', 
    14=>'berkaitan_dgn_stok',
    15=>'satuan',
    16=>'tipe_barang',
    17=>'status',
    18=>'id'

);

// getting total number records without any search
$sql = "SELECT s.nama,b.kode_barang,b.tipe_barang,b.nama_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.kategori,b.status,b.suplier,b.limit_stok,b.satuan ,b.id,b.berkaitan_dgn_stok, k.nama_kategori";
$sql.=" FROM barang b LEFT JOIN satuan s ON b.satuan = s.id LEFT JOIN kategori k ON b.kategori = k.id ";
$sql.=" ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT s.nama,b.kode_barang,b.tipe_barang,b.nama_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.kategori,b.status,b.suplier,b.limit_stok,b.satuan,b.id,b.berkaitan_dgn_stok, k.nama_kategori";
$sql.=" FROM barang b LEFT JOIN satuan s ON b.satuan = s.id LEFT JOIN kategori k ON b.kategori = k.id ";
$sql.=" WHERE ";

    $sql.=" b.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.berkaitan_dgn_stok LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR b.satuan LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR k.nama_kategori LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.suplier LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.limit_stok LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR b.tipe_barang LIKE '".$requestData['search']['value']."%' ";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

            $stok_barang = cekStokHpp($row['kode_barang']);

// select detail penjualan dan tbs_penjualan
            $queryyy = $db->query("SELECT dp.jumlah_barang AS jumlah_detail ,tp.jumlah_barang AS jumlah_tbs, dp.satuan  FROM detail_penjualan dp LEFT JOIN tbs_penjualan tp ON dp.no_faktur = tp.no_faktur WHERE dp.kode_barang = '$row[kode_barang]' AND dp.no_faktur = '$no_faktur' ");
            $data000 = mysqli_fetch_array($queryyy);



            $konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$data000[satuan]' AND kode_produk = '$row[kode_barang]'");
            $data_konversi = mysqli_fetch_array($konversi);
            

             $jumlah_tbs = $data000['jumlah_tbs'] * $data_konversi['konversi'];

            $sisa_barang = ($stok_barang + $data000['jumlah_detail']) - $jumlah_tbs;

            $harga1 = $row['harga_jual'];
            if ($harga1 == '') {
                $harga1 =0;
            }
            $harga2 = $row['harga_jual2'];
            if ($harga2 == '') {
                $harga2 =0;
            }
            $harga3 = $row['harga_jual3'];
            if ($harga3 == '') {
                $harga3 =0;
            }
            $harga4 = $row['harga_jual4'];
            if ($harga4 == '') {
                $harga4 =0;
            }
            $harga5 = $row['harga_jual5'];
            if ($harga5 == '') {
                $harga5 =0;
            }
            $harga6 = $row['harga_jual6'];
            if ($harga6 == '') {
                $harga6 =0;
            }
            $harga7 = $row['harga_jual7'];
            if ($harga7 == '') {
                $harga7 =0;
            }

    $nestedData=array(); 

    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = $row["harga_jual"];
    $nestedData[] = $row["harga_jual2"];
    $nestedData[] = $row["harga_jual3"];
    $nestedData[] = $row["harga_jual4"];
    $nestedData[] = $row["harga_jual5"];
    $nestedData[] = $row["harga_jual6"];
    $nestedData[] = $row["harga_jual7"];

    if ($row["berkaitan_dgn_stok"] == "Jasa") {
        $nestedData[] = "0";
        }
    else{
        if($row["nama"] == 'KG'){
           $nestedData[] = koma(cekStokHpp($row["kode_barang"]),3);
        }
        else{
            $nestedData[] = hapus_koma(cekStokHpp($row["kode_barang"]));
        }
        }

    $nestedData[] = $row["nama"];
    $nestedData[] = $row["nama_kategori"];
    $nestedData[] = $row["suplier"];
    $nestedData[] = $row["limit_stok"];
    $nestedData[] = $row["berkaitan_dgn_stok"];
    $nestedData[] = $row["satuan"];
    $nestedData[] = $row["tipe_barang"];
    $nestedData[] = $row["status"];
    $nestedData[] = $row["id"];
    
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