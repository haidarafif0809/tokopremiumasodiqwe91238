<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$pilih_akses_akuntansi = $db->query("SELECT transaksi_jurnal_manual_hapus,
transaksi_jurnal_manual_edit FROM otoritas_laporan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$akuntansi = mysqli_fetch_array($pilih_akses_akuntansi);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

	0 =>'no_faktur', 
	1 => 'jenis_transaksi',
	2 =>'no_faktur', 
	3 => 'jenis_transaksi',
	4 => 'user_buat',
	5 => 'user_edit',
	6 => 'waktu_jurnal',
	7  => 'keterangan_jurnal',
	8  => 'id'

);

// getting total number records without any search
$sql = " SELECT *  ";
$sql.= " FROM jurnal_trans WHERE jenis_transaksi = 'Jurnal Manual' GROUP BY no_faktur ";
$query=mysqli_query($conn, $sql) or die("datatable_stok_awal.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = " SELECT * ";
$sql.= " FROM jurnal_trans WHERE 1=1 AND  jenis_transaksi = 'Jurnal Manual'  ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR jenis_transaksi LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR user_buat LIKE '".$requestData['search']['value']."%' )";
}

$sql.="GROUP BY no_faktur";
$query=mysqli_query($conn, $sql) or die("datatable_stok_awal.php2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id  ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

if ($akuntansi['transaksi_jurnal_manual_hapus'] > 0) {

			$nestedData[] = "<button class='btn btn-danger btn-hapus btn-sm' data-id='". $row['id'] ."' data-jurnal='". $row['jenis_transaksi'] ."' data-faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
		}


if ($akuntansi['transaksi_jurnal_manual_edit'] > 0) {
			$nestedData[] = "<a href='proses_edit_jurnal_manual.php?no_faktur=". $row['no_faktur']."' class='btn btn-success btn-sm'> <span class='glyphicon glyphicon-edit'></span> Edit </a>";
}


		$nestedData[] = $row['no_faktur'];
		$nestedData[] = $row['jenis_transaksi'];
		$nestedData[] = $row['user_buat'];
		$nestedData[] = $row['user_edit'];
		$nestedData[] = $row['waktu_jurnal'];
		$nestedData[] = $row['keterangan_jurnal'];
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


