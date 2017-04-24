<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = stringdoang($_POST['session_id']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'jumlah',
    3=>'satuan',
    4=>'harga',
    5=>'subtotal',
    9=>'id'
);

// getting total number records without any search
$sql =" SELECT im.no_faktur, im.kode_barang, im.nama_barang, im.jumlah, im.satuan, im.harga, im.subtotal, im.id, s.nama AS nama_satuan ";
$sql.=" FROM tbs_item_masuk im INNER JOIN satuan s ON im.satuan = s.id";
$sql.=" WHERE im.session_id = '$session_id' AND im.no_faktur IS NULL ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT im.no_faktur, im.kode_barang, im.nama_barang, im.jumlah, im.satuan, im.harga, im.subtotal, im.id, s.nama AS nama_satuan ";
$sql.=" FROM tbs_item_masuk im INNER JOIN satuan s ON im.satuan = s.id";
$sql.=" WHERE im.session_id = '$session_id' AND im.no_faktur IS NULL ";

    $sql.=" AND (im.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR im.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY im.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


        $nestedData[] = $row["kode_barang"];
        $nestedData[] = $row["nama_barang"];     


        $nestedData[] = "<p class='edit-jumlah' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-subtotal='".$row['subtotal']."' data-harga='".$row['harga']."' data-faktur='".$row['no_faktur']."' data-kode='".$row['kode_barang']."' > </p>";

        $nestedData[] = $row["nama_satuan"];

        $nestedData[] = "<p align='right'>".rp($row["harga"])."</p>";
        $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-subtotal-".$row['id']."'> ".rp($row["subtotal"])." </span> </p>";

        $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus' id='btn-hapus-".$row['id']."' data-id='". $row['id'] ."' data-nama-barang='". $row['nama_barang'] ."' data-subtotal='". $row['subtotal'] ."' > <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
          

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