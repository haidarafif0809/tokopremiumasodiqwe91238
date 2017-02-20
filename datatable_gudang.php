<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
  0 => 'id'
);


// getting total number records without any search
$sql = "SELECT *";
$sql.="FROM gudang ";
$query=mysqli_query($conn, $sql) or die("datatable_fee_faktur.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT *";
$sql.="FROM gudang WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


  $sql.=" AND ( nama LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR kode_gudang LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_fee_faktur.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      //menampilkan data
      $nestedData[] = $row['kode_gudang'];
      $nestedData[] ="<p class='edit-nama' data-id='".$row['id']."'><span id='text-nama-".$row['id']."'>". $row['nama_gudang'] ."</span> <input type='hidden' id='input-nama-".$row['id']."' value='".$row['nama_gudang']."' class='input_nama' data-id='".$row['id']."' autofocus='' > </p>";

$pilih_akses_otoritas = $db->query("SELECT gudang_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND gudang_hapus = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-gudang='". $row['kode_gudang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
      }
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

