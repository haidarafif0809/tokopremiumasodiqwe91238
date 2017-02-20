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
	0 =>'kode_pelanggan',
	 1=>'nama_pelanggan',
	 2=>'tanggal',
	 3=>'no_faktur',
	 4=>'kode_pelanggan',
	 5=>'total',
	 6=>'jam',
	 7=>'user',
	 8=>'status,',
	 9=>'potongan',
	 10=>'tax',
	 11=>'tunai',
	 12=>'kredit',
	 13=>'id'
);

// getting total number records without any search
$sql ="SELECT pel.kode_pelanggan,pel.nama_pelanggan,dp.id,dp.tanggal,dp.no_faktur,dp.kode_pelanggan,dp.total,dp.jam,dp.user,dp.status,dp.potongan,dp.tax,dp.tunai,dp.kredit ";
$sql.="FROM penjualan dp INNER JOIN pelanggan pel ON dp.kode_pelanggan = pel.kode_pelanggan WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND dp.kredit != 0 ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT pel.kode_pelanggan,pel.nama_pelanggan,dp.id,dp.tanggal,dp.no_faktur,dp.kode_pelanggan,dp.total,dp.jam,dp.user,dp.status,dp.potongan,dp.tax,dp.tunai,dp.kredit ";
$sql.="FROM penjualan dp INNER JOIN pelanggan pel ON dp.kode_pelanggan = pel.kode_pelanggan WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND dp.kredit != 0 AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( dp.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.tanggal_jt LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pel.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pel.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.jam LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY dp.id ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

				$nestedData[] = $row['tanggal'];
				$nestedData[] = $row['no_faktur'];
				$nestedData[] = $row['kode_pelanggan'] ." - ". $row['nama_pelanggan'];
				$nestedData[] = rp($row['total']);
				$nestedData[] = $row['jam'];
				$nestedData[] = $row['user'];
				$nestedData[] = $row['status'];
				$nestedData[] = rp($row['potongan']);
				$nestedData[] = rp($row['tax']);
				$nestedData[] = rp($row['tunai']);
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
