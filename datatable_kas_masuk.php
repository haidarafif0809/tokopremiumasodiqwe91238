<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur',
	 1=>'keterangan',
	 2=>'ke_akun',
	 3=>'jumlah',
	 4=>'tanggal',
	 5=>'jam',
	 6=>'user',
	 7=>'nama_daftar_akun',
	 8=>'id'
);

// getting total number records without any search
$sql ="SELECT km.id, km.no_faktur, km.keterangan, km.ke_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun ";
$sql.="FROM kas_masuk km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT km.id, km.no_faktur, km.keterangan, km.ke_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun ";
$sql.="FROM kas_masuk km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( km.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR km.ke_akun LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR km.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR km.jam LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR da.nama_daftar_akun LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY km.id ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			$pilih_akses_kas_masuk = $db->query("SELECT * FROM otoritas_kas_masuk WHERE id_otoritas = '$_SESSION[otoritas_id]'");
		$kas_masuk = mysqli_fetch_array($pilih_akses_kas_masuk);

			//menampilkan data
			$nestedData[] = $row['no_faktur'];			
			$nestedData[] = $row['nama_daftar_akun'];
			$nestedData[] = rp($row['jumlah']);			
			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['jam'];
			$nestedData[] = $row['user'];
			


			$nestedData[] = "<button class=' btn btn-info detail' no_faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

if ($kas_masuk['kas_masuk_edit'] > 0) {

			$nestedData[] = "<a href='proses_edit_data_kas_masuk.php?no_faktur=". $row['no_faktur']."&nama_daftar_akun=". $row['nama_daftar_akun']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";
		}

if ($kas_masuk['kas_masuk_hapus'] > 0) {
			$nestedData[] = "<button class=' btn btn-danger btn-hapus' data-id='". $row['id'] ."' no-faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
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
