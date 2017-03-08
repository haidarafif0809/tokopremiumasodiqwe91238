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
	0 =>'nama_pelanggan', 
	1 => 'tanggal',
	2 => 'no_faktur',
	3=> 'kode_pelanggan',
	4=> 'total',
	5=> 'jam',
	6=> 'user',
	7=> 'status',
	8=> 'potongan',
	9=> 'tax',
	10=> 'sisa',
	11=> 'kredit',
	12=> 'id'
);

// getting total number records without any search
$sql = " SELECT pel.nama_pelanggan,pel.kode_pelanggan AS code_card,p.id,p.tanggal,p.no_faktur,p.kode_pelanggan,p.total,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit ";
$sql.="FROM penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_penjualan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT pel.nama_pelanggan,pel.kode_pelanggan AS code_card,p.id,p.tanggal,p.no_faktur,p.kode_pelanggan,p.total,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit ";
$sql.=" FROM penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( pel.nama_pelanggan LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pel.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_penjualan.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.no_faktur DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

				//menampilkan data
				$nestedData[] = $row['tanggal'];
				$nestedData[] = $row['no_faktur'];
			$nestedData[] = $row['code_card'] ." - ". $row['nama_pelanggan'];
				$nestedData[] = rp($row['total']);
				$nestedData[] = $row['jam'];
				$nestedData[] = $row['user'];
				$nestedData[] = $row['status'];
				$nestedData[] = rp($row['potongan']);
				$nestedData[] = rp($row['tax']);
				$nestedData[] = rp($row['sisa']);
				$nestedData[] = rp($row['kredit']);
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

