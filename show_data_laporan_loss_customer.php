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
$totalData = 0;
$totalFiltered = 0;



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	
	0 => 'kode_pelanggan',
	1 => 'nama_pelanggan',
	2 => 'no_telp',
	3 => 'jumlah'

);


$sql = "SELECT pl.kode_pelanggan AS pelanggan,p.kode_pelanggan,SUM(p.total) AS jumlah,pl.nama_pelanggan,pl.no_telp";
$sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE MONTH(p.tanggal) = '$bulan'";

$query=mysqli_query($conn, $sql) or die("1: get employees");


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ) ";
} 
 $sql.=" GROUP BY p.kode_pelanggan";

 $query=mysqli_query($conn, $sql) or die("2: get employees");
 $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


 $sql.=" ORDER BY p.id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

	$query_penjualan = $db->query("SELECT COUNT(kode_pelanggan) AS jumlah_data FROM penjualan WHERE  MONTH(tanggal) = '$bulan_sekarang' AND kode_pelanggan = '$row[kode_pelanggan]' ");
	$data_penjualan = mysqli_fetch_array($query_penjualan);

		if ($data_penjualan['jumlah_data'] == 0) {
				
				$nestedData=array();
				$totalData = $totalData + 1;
				$totalFiltered = $totalData; 
				
				$nestedData[] = $row["pelanggan"];
				$nestedData[] = $row["nama_pelanggan"];
				$nestedData[] = $row["no_telp"];
				$nestedData[] = rp($row["jumlah"]);	 

				$data[] = $nestedData;
		}else{

		}
	}



	if ($totalData == 0) {
		
		echo '{"draw":1,"recordsTotal":0,"recordsFiltered":0,"data":[]}';
	}else{

		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array
					);

		echo json_encode($json_data);  // send data as json format
	}







?>