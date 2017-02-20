<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id',
	 1=>'nama_daftar_akun',
	 2=>'no_faktur_pembayaran',
	 3=>'tanggal',
	 4=>'nama_suplier',
	 5=>'dari_kas',
	 6=>'total',
	 7=>'nama'
);

// getting total number records without any search
$sql ="SELECT da.nama_daftar_akun,p.id, p.no_faktur_pembayaran,p.tanggal,p.nama_suplier,p.dari_kas,p.total,s.nama ";
$sql.="FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembayaran_piutang.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT da.nama_daftar_akun,p.id, p.no_faktur_pembayaran,p.tanggal,p.nama_suplier,p.dari_kas,p.total,s.nama ";
$sql.="FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( da.nama_daftar_akun LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.no_faktur_pembayaran LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembayaran_piutang.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.id ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			
				//menampilkan data
			$perintah0 = $db->query("SELECT * FROM detail_pembayaran_hutang WHERE no_faktur_pembayaran = '$row[no_faktur_pembayaran]'");
				$cek = mysqli_fetch_array($perintah0);
			$nestedData[] = $row['no_faktur_pembayaran'];
			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['nama'];
			$nestedData[] = $row['nama_daftar_akun'];
			$nestedData[] = $cek['potongan'];
			$nestedData[] = rp($row['total']);
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
