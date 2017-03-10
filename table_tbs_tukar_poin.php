<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$session_id = session_id();
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

	0 =>'kode_barang', 
	1 =>'nama_barang', 
	2 =>'satuan',
	3 =>'jumlah_barang', 
	4 =>'poin', 
	5 => 'subtotal',
	6 => 'hapus',
	7=> 'id'

);

// getting total number records without any search
$sql = "SELECT s.nama , ttp.kode_barang,ttp.nama_barang,ttp.jumlah_barang,ttp.poin,ttp.subtotal_poin ,ttp.id ";
$sql.=" FROM tbs_tukar_poin ttp LEFT JOIN satuan s ON ttp.satuan = s.id WHERE ttp.session_id = '$session_id' AND ttp.no_faktur IS NULL ";
$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



// getting total number records without any search
$sql = "SELECT s.nama , ttp.kode_barang,ttp.nama_barang,ttp.jumlah_barang,ttp.poin,ttp.subtotal_poin ,ttp.id ";
$sql.=" FROM tbs_tukar_poin ttp LEFT JOIN satuan s ON ttp.satuan = s.id WHERE ttp.session_id = '$session_id' AND ttp.no_faktur IS NULL ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( ttp.kode_barang LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR ttp.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY ttp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eeror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 


						$nestedData[] = "<p style='font-size:15px;'>". $row['kode_barang'] ."</p>";
						$nestedData[] = "<p style='font-size:15px;'>". $row['nama_barang'] ."</p>";
						$nestedData[] = "<p style='font-size:15px'>". $row['nama'] ."</p>";
						$nestedData[] = "<p style='font-size:15px' class='edit-jumlah' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> </p> 
						<input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' 
						data-kode='".$row['kode_barang']."' data-poin='".$row['poin']."' data-jumlah='".$row['jumlah_barang']."' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'>";


						$nestedData[] = "<p style='font-size:15px' >". rp($row['poin']) ."</p>";
						$nestedData[] = "<p style='font-size:15px'><span id='text-subtotal-".$row['id']."'>". rp($row['subtotal_poin']) ."</span></p>";
						$nestedData[] = "<p style='font-size:15px'> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='btn-hapus-".$row['id']."' data-id='". $row['id'] ."' data-nama_barang='". $row['nama_barang'] ."' >Hapus</button> </p>";
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

