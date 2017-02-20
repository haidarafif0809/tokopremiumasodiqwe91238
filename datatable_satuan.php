<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'nama',
	 1=>'id'
);

// getting total number records without any search
$sql ="SELECT * ";
$sql.="FROM satuan ";
$query=mysqli_query($conn, $sql) or die("datatable_satuan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT * ";
$sql.="FROM satuan WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( nama  LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_satuan.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			//menampilkan data
			$nestedData[] = $row['nama'] ."</td>";



$pilih_akses_satuan_hapus = $db->query("SELECT satuan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_hapus = '1'");
$satuan_hapus = mysqli_num_rows($pilih_akses_satuan_hapus);


    if ($satuan_hapus > 0){
			$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-satuan='". $row['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}


$pilih_akses_satuan_edit = $db->query("SELECT satuan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_edit = '1'");
$satuan_edit = mysqli_num_rows($pilih_akses_satuan_edit);


    if ($satuan_edit > 0){
			

			$nestedData[] = "<button class='btn btn-success btn-edit' data-satuan='". $row['nama'] ."' data-id='". $row['id'] ."' > <span class='glyphicon glyphicon-edit'> </span> Edit </button>";
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
