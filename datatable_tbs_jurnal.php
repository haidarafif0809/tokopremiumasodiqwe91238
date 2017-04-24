<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


$session_id = session_id();


$pilih_akses_akuntansi = $db->query("SELECT * FROM otoritas_laporan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$akuntansi = mysqli_fetch_array($pilih_akses_akuntansi);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

  0 =>'kode_akun', 
  1 => 'nama_akun',
  2 => 'debit', 
  3 => 'kredit',
  4 => 'hapus',
  5  => 'id'

);

// getting total number records without any search
$sql = "SELECT *  ";
$sql.= "FROM tbs_jurnal WHERE session_id = '$session_id' ";
$query=mysqli_query($conn, $sql) or die("datatable_stok_awal.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = " SELECT * ";
$sql.= " FROM tbs_jurnal WHERE 1=1 AND session_id = '$session_id' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( kode_akun_jurnal LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR nama_akun_jurnal LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR kredit LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR debit LIKE '".$requestData['search']['value']."%' )";
}
$query= mysqli_query($conn, $sql) or die("datatable_stok_awal.php2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.="ORDER BY id  ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

    $nestedData[] =   $row['kode_akun_jurnal'];
    $nestedData[] =   $row['nama_akun_jurnal'];


if ($row['debit'] == 0) {
     $nestedData[] = rp($row['debit']);
} 

else {
     $nestedData[] = "<p class='edit-debit' data-id='".$row['id']."'> <span id='text-debit-".$row['id']."'> ". rp($row['debit']) ." </span> <input type='hidden' id='input-debit-".$row['id']."' value='".$row['debit']."' class='input-debit' data-id='".$row['id']."' data-debit='".$row['debit']."' autofocus=''> </p>"; 
}

  
if ($row['kredit'] == 0) {
      $nestedData[] = rp($row['kredit']);
} 

else {
       $nestedData[] = "<p class='edit-kredit' data-id='".$row['id']."'> <span id='text-kredit-".$row['id']."'> ". rp($row['kredit']) ." </span> 
       <input type='hidden' id='input-kredit-".$row['id']."' value='".$row['kredit']."' class='input-kredit' data-id='".$row['id']."' data-kredit='".$row['kredit']."' autofocus=''> </p>"; 
}



    $nestedData[] = "<button class='btn btn-danger btn-hapus-tbs btn-sm' data-id='". $row['id'] ."' data-kode-akun='". $row['kode_akun_jurnal'] ."' data-nama='". $row['nama_akun_jurnal'] ."' ><span class='glyphicon glyphicon-trash '> </span> Hapus </button>";

    $nestedData[] = $row['id'];

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


