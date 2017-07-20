<?php
include 'db.php';
include 'sanitasi.php';

$no_faktur = $_POST['no_faktur'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
    
    0=>'no_faktur', 
    1=>'kode_barang',
    2=>'nama_barang',
    3=>'jumlah_barang',
    4=>'satuan',
    5=>'harga', 
    6=>'subtotal',
    7=>'potongan',
    8=>'tax',
    9=>'id'

);

// getting total number records without any search

    $sql = "SELECT sk.konversi,dp.id, dp.kode_barang, dp.nama_barang, dp.jumlah_barang / IFNULL( sk.konversi,0) AS jumlah_produk, 
    dp.jumlah_barang, dp.satuan, dp.harga * IFNULL( sk.konversi,0) AS harga_produk, dp.harga,dp.potongan, dp.subtotal, dp.tax, sk.id_satuan, s.nama AS satuan_konversi, sa.nama AS satuan_dasar ";
    $sql.=" FROM detail_penjualan_order dp LEFT JOIN satuan_konversi sk ON dp.kode_barang = sk.kode_produk AND dp.satuan = sk.id_satuan "; 
    $sql.="  LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN satuan sa ON dp.asal_satuan = sa.id WHERE dp.no_faktur_order = '$no_faktur' ";

    $query=mysqli_query($conn, $sql) or die("1: Eror ");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( dp.kode_barang LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ) ";
} 

 $query=mysqli_query($conn, $sql) or die("2: Eror 2");
 $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


 $sql.=" ORDER BY dp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("3: Eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

    $nestedData=array(); 
    
    $nestedData[] = $no_faktur;
    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];

    if ($row["konversi"] != 0) {
    
    $nestedData[] = "<p align='right'>".koma($row["jumlah_produk"],3)."</p>";
    $nestedData[] = $row["satuan_konversi"];
    $nestedData[] = "<p align='right'>".koma($row["harga_produk"],2)."</p>";

    }
    else{

    $nestedData[] = "<p align='right'>".koma($row["jumlah_barang"],3)."</p>";
    $nestedData[] = $row["satuan_dasar"];
    $nestedData[] = "<p align='right'>".koma($row["harga"],2)."</p>";
    }

    $nestedData[] = "<p align='right'>".koma($row["potongan"],2)."</p>";
    $nestedData[] = "<p align='right'>".koma($row["tax"],2)."</p>";
    $nestedData[] = "<p align='right'>".koma($row["subtotal"],2)."</p>";

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