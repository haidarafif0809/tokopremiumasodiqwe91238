<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */

$pilih_akses_kas_mutasi = $db->query("SELECT * FROM otoritas_kas_mutasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$kas_mutasi = mysqli_fetch_array($pilih_akses_kas_mutasi);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	 
	0 => 'no_faktur',
	1 => 'keterangan',
	2 => 'nama_daftar_akun',
	3 => 'jumlah',
	4 => 'tanggal',
	5 => 'jam',
	6 => 'user',
	7 => 'user_edit',
	8 => 'waktu_edit',
	9 => 'id'
);

// getting total number records without any search
$sql = "SELECT km.user_edit,km.waktu_edit,km.id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun,da.kode_daftar_akun ";
$sql.=" FROM kas_mutasi km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun ";
$query=mysqli_query($conn, $sql) or die("datatabble_kas_mutasi.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT km.user_edit,km.waktu_edit,km.id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun,da.kode_daftar_akun ";
$sql.=" FROM kas_mutasi km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun WHERE 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR  keterangan LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR  ke_akun LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR  dari_akun LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatableee_kas_mutasi.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY km.id DESC ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$perintah10 = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM daftar_akun da INNER JOIN kas_mutasi km ON da.kode_daftar_akun = km.dari_akun WHERE da.kode_daftar_akun = '$row[dari_akun]'");
	$data1 = mysqli_fetch_array($perintah10);


	$nestedData[] = "<a href='cetak_kas_mutasi.php?id=".$row['id']."' target='blank' class='btn btn-primary' data-target='blank'> <i class='fa fa-print'></i> Cetak </a>";

	$nestedData[] = $row["no_faktur"];
	$nestedData[] = $row["keterangan"];
	$nestedData[] = $data1["nama_daftar_akun"];
	$nestedData[] = $row["nama_daftar_akun"];
	$nestedData[] = $row["jumlah"];
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam"];
	$nestedData[] = $row["user"];
	$nestedData[] = $row["user_edit"];
	$nestedData[] = $row["waktu_edit"];

	if ($kas_mutasi['kas_mutasi_hapus'] > 0) {

		
			$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur'] ."'> <i class='fa fa-trash'></i> Hapus </button>";
		}


if ($kas_mutasi['kas_mutasi_edit'] > 0) {

			$nestedData[] = "<button class='btn btn-info btn-edit' data-jumlah='". $row['jumlah'] ."' data-ket='". $row['keterangan'] ."' data-id='". $row['id'] ."' data-dari-akun='". $row['dari_akun'] ."' data-ke-akun='". $row['ke_akun'] ."' data-jumlah='". $row['jumlah'] ."' data-tanggal='". $row['tanggal'] ."' data-faktur='". $row['no_faktur'] ."'> <i class='fa fa-edit'></i> Edit </button>";
			}
		else{
			$nestedData[] = "you can't be edited.";
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
