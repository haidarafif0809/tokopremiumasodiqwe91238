<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'kode_barang', 
	1 => 'nama_barang',
	2 => 'kategori',
	3=> 'berkaitan_dgn_stok',
	4=> 'harga_jual',
	5=> 'harga_jual2',
	6=> 'harga_jual3',
	7=> 'harga_jual4',
	8=> 'harga_jual5',
	9=> 'harga_jual6',
	10=> 'harga_jual7',
	11=> 'stok_barang',
	12=> 'id'
);


// getting total number records without any search
$sql = "SELECT b.id,b.kode_barang,b.nama_barang,b.kategori,b.berkaitan_dgn_stok,b.harga_jual,b.harga_jual2,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.stok_barang,s.nama ";
$sql.="FROM barang b LEFT JOIN  satuan s ON b.satuan = s.id WHERE b.status = 'Aktif'";
$query=mysqli_query($conn, $sql) or die("datatable_khusus.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT b.id,b.kode_barang,b.nama_barang,b.kategori,b.berkaitan_dgn_stok,b.harga_jual,b.harga_jual2,b.harga_jual3,b.harga_jual4,b.harga_jual5,b.harga_jual6,b.harga_jual7,b.stok_barang,s.nama ";
$sql.="FROM barang b LEFT JOIN  satuan s ON b.satuan = s.id WHERE b.status = 'Aktif' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( b.kode_barang LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.kategori LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_cari_barang.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
			$select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
            $ambil_sisa = mysqli_fetch_array($select);
    	//menampilkan data
			$nestedData[] = $row['kode_barang'];
			$nestedData[] = $row['nama_barang'];
			$nestedData[] = $row['harga_jual'];
			$nestedData[] = $row['harga_jual2'];
			$nestedData[] = $row['harga_jual3'];
			$nestedData[] = $row['harga_jual4'];
			$nestedData[] = $row['harga_jual5'];
			$nestedData[] = $row['harga_jual6'];
			$nestedData[] = $row['harga_jual7'];
			$nestedData[] = $ambil_sisa['jumlah_barang'];
			$nestedData[] = $row['nama'];
			$nestedData[] = $row['berkaitan_dgn_stok'];
			$nestedData[] = $row['kategori'];
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

