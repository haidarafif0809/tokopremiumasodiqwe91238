<?php
include 'db.php';
include 'sanitasi.php';

// hitung bulan sebelumnya
$bulan = date('m') - 1;
 if ($bulan == 0)
 {
 	echo $bulan = 12;
 }

$bulan_sekarang = date('m');

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	
	0 => 'kode_barang',
	1 => 'nama_barang',
	2 => 'satuan',
	3 => 'jumlah'

);

// getting total number records without any search
$tes = $db->query("SELECT kode_barang FROM detail_penjualan WHERE 
	MONTH(tanggal) = '$bulan_sekarang' GROUP BY kode_barang");
 while($out = mysqli_fetch_array($tes))
 {
  $kode_now = $out['kode_barang'];
	
$sql = "SELECT p.kode_barang, SUM(p.jumlah_barang) AS jumlah, s.nama, p.nama_barang";
$sql.=" FROM detail_penjualan p LEFT JOIN satuan s ON p.satuan = s.id WHERE MONTH(p.tanggal) = '$bulan' AND p.kode_barang != '$kode_now' GROUP BY p.kode_barang";

$query=mysqli_query($conn, $sql) or die("1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT p.kode_barang,SUM(p.jumlah_barang) AS jumlah,s.nama, p.nama_barang";
$sql.=" FROM detail_penjualan p LEFT JOIN satuan s ON p.satuan = s.id WHERE MONTH(p.tanggal) = '$bulan' AND p.kode_barang != '$kode_now'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( p.kode_barang LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%'  ";
	$sql.=" OR p.nama_barang LIKE '".$requestData['search']['value']."%' )  ";
} 

 $sql.=" GROUP BY p.kode_barang";

 $query=mysqli_query($conn, $sql) or die("2: get employees");
 $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 



 $sql.=" ORDER BY p.kode_barang ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

	$nestedData=array(); 
	
	$nestedData[] = $row["kode_barang"];
	$nestedData[] = $row["nama_barang"];
	$nestedData[] = $row["nama"];	
	$nestedData[] = rp($row["jumlah"]);	 

	$data[] = $nestedData;

	
	}
}
		 	 


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>