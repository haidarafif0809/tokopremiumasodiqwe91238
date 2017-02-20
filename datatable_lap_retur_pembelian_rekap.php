<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$perintah1 = $db->query("SELECT * FROM detail_retur_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek = mysqli_fetch_array($perintah1);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id',
	 1=>'no_faktur_retur',
	 2=>'total',
	 3=>'nama_suplier',
	 4=>'tunai',
	 5=>'tanggal',
	 6=>'jam',
	 7=>'user_buat',
	 8=>'potongan',
	 9=> 'tax',
	 10=> 'sisa',
	 11=>'nama'
);

// getting total number records without any search
$sql ="SELECT p.id,p.no_faktur_retur,p.total,p.nama_suplier,p.tunai,p.tanggal,p.jam,p.user_buat,p.potongan,p.tax,p.sisa,s.nama  ";
$sql.="FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_retur_penjualan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT p.id,p.no_faktur_retur,p.total,p.nama_suplier,p.tunai,p.tanggal,p.jam,p.user_buat,p.potongan,p.tax,p.sisa,s.nama  ";
$sql.="FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( p.no_faktur_retur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_retur_penjualan.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.id ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			
				//menampilkan data
			$nestedData[] = $row['no_faktur_retur'] ;
			$nestedData[] = $row['tanggal'] ;
			$nestedData[] = $row['nama'] ;
			$nestedData[] = $cek['jumlah_retur'] ;
			$nestedData[] = rp($row['total']) ;
			$nestedData[] = rp($row['potongan']) ;
			$nestedData[] = rp($row['tax']) ;
			$nestedData[] = rp($row['tunai']) ;
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
