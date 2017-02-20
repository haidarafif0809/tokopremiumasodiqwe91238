<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id'
);


// getting total number records without any search
$sql = "SELECT id,nama ";
$sql.="FROM hak_otoritas ";
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT id,nama ";
$sql.="FROM hak_otoritas WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( nama LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	//menampilkan data
			$nestedData[] = $row['nama'];

$pilih_akses_otoritas_lihat = $db->query("SELECT hak_otoritas_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_lihat = '1'");
$otoritas_lihat = mysqli_num_rows($pilih_akses_otoritas_lihat);

    if ($otoritas_lihat > 0) {		

			$nestedData[] = "<a href='form_hak_akses.php?nama=".$row['nama']."&id=".$row['id']."' class='btn btn-primary'> <span class='	glyphicon glyphicon-new-window'> </span> Hak Akses </a>";
		}


$pilih_akses_otoritas_hapus = $db->query("SELECT hak_otoritas_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_hapus = '1'");
$otoritas_hapus = mysqli_num_rows($pilih_akses_otoritas_hapus);

    if ($otoritas_hapus > 0) {
			$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-otoritas='". $row['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
	}

$pilih_akses_otoritas_edit = $db->query("SELECT hak_otoritas_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_edit = '1'");
$otoritas_edit = mysqli_num_rows($pilih_akses_otoritas_edit);

    if ($otoritas_edit > 0) {
			$nestedData[] = "<button class='btn btn-success btn-edit' data-otoritas='". $row['nama'] ."' data-id='". $row['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button>";
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

