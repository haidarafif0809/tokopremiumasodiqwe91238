<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';

/* Database connection end */

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
    12=>'status',
    13=>'suplier',
    14=>'limit_stok', 
    15=>'berkaitan_dgn_stok',
    16=>'tipe_barang',
    17=>'satuan',
    18=>'id',


);

// getting total number records without any search
$sql = "SELECT s.nama,b.kode_barang,b.tipe_barang,b.nama_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.kategori,b.status,b.suplier,b.limit_stok,b.satuan,b.id,b.berkaitan_dgn_stok";
$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id ";
$sql.=" ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT s.nama,b.kode_barang,b.tipe_barang,b.nama_barang,b.harga_beli,b.harga_jual,b.harga_jual2,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.kategori,b.status,b.suplier,b.limit_stok,b.satuan,b.id,b.berkaitan_dgn_stok";
$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id ";
$sql.=" WHERE ";

    $sql.=" b.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.berkaitan_dgn_stok LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR b.satuan LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.kategori LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.suplier LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.limit_stok LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR b.tipe_barang LIKE '".$requestData['search']['value']."%' ";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY b.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {



            $harga1 = koma($row['harga_jual'],2);
            if ($harga1 == '') {
                $harga1 =0;
            }
            $harga2 = koma($row['harga_jual2'],2);
            if ($harga2 == '') {
                $harga2 =0;
            }
            $harga3 = koma($row['harga_jual3'],2);
            if ($harga3 == '') {
                $harga3 =0;
            }
            $harga4 = koma($row['harga_jual4'],2);
            if ($harga4 == '') {
                $harga4 =0;
            }
            $harga5 = koma($row['harga_jual5'],2);
            if ($harga5 == '') {
                $harga5 =0;
            }
            $harga6 = koma($row['harga_jual6'],2);
            if ($harga6 == '') {
                $harga6 =0;
            }
            $harga7 = koma($row['harga_jual7'],2);
            if ($harga7 == '') {
                $harga7 =0;
            }

    $nestedData=array(); 

    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = koma($row["harga_jual"],2);
    $nestedData[] = koma($row["harga_jual2"],2);
    $nestedData[] = koma($row["harga_jual3"],2);
    $nestedData[] = koma($row["harga_jual4"],2);
    $nestedData[] = koma($row["harga_jual5"],2);
    $nestedData[] = koma($row["harga_jual6"],2);
    $nestedData[] = koma($row["harga_jual7"],2);

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
    $nestedData[] = $row["kategori"];
    $nestedData[] = $row["suplier"];
    $nestedData[] = $row["limit_stok"];
    $nestedData[] = $row["berkaitan_dgn_stok"];
    $nestedData[] = $row["tipe_barang"];
    $nestedData[] = $row["status"];
    $nestedData[] = $row["satuan"];
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