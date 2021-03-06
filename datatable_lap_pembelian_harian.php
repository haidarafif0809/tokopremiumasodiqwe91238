<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

	$query_row = $db->query("SELECT tanggal FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
	$jumlah_row = mysqli_num_rows($query_row);

	$query_sum = $db->query("SELECT SUM(total) AS t_total, SUM(nilai_kredit) AS t_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
	$data_sum = mysqli_fetch_array($query_sum);
	$total_sum = $data_sum['t_total'];
	$kredit_sum = $data_sum['t_kredit'];

	$bayar_sum = $total_sum - $kredit_sum;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'tanggal',
	 1=>'id'
);

// getting total number records without any search
$sql ="SELECT id,tanggal ";
$sql.="FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY tanggal ";
$query=mysqli_query($conn, $sql) or die("ADASD.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT id,tanggal ";
$sql.="FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'";
$sql.="GROUP BY tanggal";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( tanggal LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY tanggal DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();
		//menampilkan data
		$perintah1 = $db->query("SELECT tanggal FROM pembelian WHERE tanggal = '$row[tanggal]'");
		$data1 = mysqli_num_rows($perintah1);

		$perintah2 = $db->query("SELECT SUM(total) AS t_total, SUM(nilai_kredit) AS t_kredit FROM pembelian WHERE tanggal = '$row[tanggal]'");
		$data2 = mysqli_fetch_array($perintah2);
		$t_total = $data2['t_total'];
		$t_kredit = $data2['t_kredit'];
		$t_bayar = $t_total - $t_kredit;

		$nestedData[] = $row['tanggal'];
		$nestedData[] = "$data1";
		$nestedData[] = rp($t_total);
		$nestedData[] = rp($t_bayar);
		$nestedData[] = rp($t_kredit);
		$nestedData[] = $row["id"];
	$data[] = $nestedData;
}

	$nestedData=array();
		//menampilkan data
		$perintah1 = $db->query("SELECT tanggal FROM pembelian WHERE tanggal = '$row[tanggal]'");
		$data1 = mysqli_num_rows($perintah1);

		$perintah2 = $db->query("SELECT SUM(total) AS t_total, SUM(nilai_kredit) AS t_kredit FROM pembelian WHERE tanggal = '$row[tanggal]'");
		$data2 = mysqli_fetch_array($perintah2);
		$t_total = $data2['t_total'];
		$t_kredit = $data2['t_kredit'];
		$t_bayar = $t_total - $t_kredit;

		$nestedData[] = "<p style='color:red'> TOTAL</p>";
		$nestedData[] = "<p style='color:red'> ".$jumlah_row."</p>";
		$nestedData[] = "<p style='color:red'> ".rp($total_sum)."</p>";
		$nestedData[] = "<p style='color:red'> ".rp($bayar_sum)."</p>";
		$nestedData[] = "<p style='color:red'> ".rp($kredit_sum)."</p>";
		$nestedData[] = "<p style='color:red'> - </p>";
	$data[] = $nestedData;


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

