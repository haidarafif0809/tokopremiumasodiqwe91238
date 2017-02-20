<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'nama_pelanggan',
	 1=>'no_faktur_retur',
	 2=>'tanggal',
	 3=>'kode_pelanggan',
	 4=>'total',
	 5=>'potongan',
	 6=>'tax',
	 7=>'tunai',
	 8=>'id'
);

// getting total number records without any search
$sql ="SELECT pel.kode_pelanggan,pel.nama_pelanggan,p.id,p.no_faktur_retur,p.tanggal,p.kode_pelanggan,p.total,p.potongan,p.tax,p.tunai ";
$sql.="FROM retur_penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.kode_pelanggan ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_retur_penjualan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT pel.kode_pelanggan,pel.nama_pelanggan,p.id,p.no_faktur_retur,p.tanggal,p.kode_pelanggan,p.total,p.potongan,p.tax,p.tunai ";
$sql.="FROM retur_penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.kode_pelanggan AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( pel.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pel.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.no_faktur_retur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_retur_penjualan.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.id ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			$perintah1 = $db->query("SELECT jumlah_retur FROM detail_retur_penjualan WHERE no_faktur_retur = '$row[no_faktur_retur]'");
				$cek = mysqli_fetch_array($perintah1);
				$jumlah_retur = $cek['jumlah_retur'];
				//menampilkan data
			$nestedData[] = $row['no_faktur_retur'];
			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['kode_pelanggan'] ." - ".$row['nama_pelanggan'];
			$nestedData[] = "$jumlah_retur";
			$nestedData[] = rp($row['total']);
			$nestedData[] = rp($row['potongan']);
			$nestedData[] = rp($row['tax']);
			$nestedData[] = rp($row['tunai']);
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
