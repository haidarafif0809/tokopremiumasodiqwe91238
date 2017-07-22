<?php 
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id_produk']);
$kode_barang = stringdoang($_POST['kode_barang']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

	0 =>'tanggal', 
	1 => 'suplier',
	2=> 'no_faktur',
	3 => 'harga_beli',
	4=> 'juml'


);
// data yang akan di tampilkan di table


// getting total number records without any search
$sql = "SELECT dp.tanggal,ss.nama AS nama_suplier,dp.no_faktur,dp.harga,dp.jumlah_barang FROM pembelian pb LEFT JOIN detail_pembelian dp ON pb.no_faktur = dp.no_faktur LEFT JOIN suplier ss ON pb.suplier = ss.id WHERE dp.kode_barang = '$kode_barang' AND dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT dp.tanggal,ss.nama AS nama_suplier,dp.no_faktur,dp.harga,dp.jumlah_barang FROM pembelian pb LEFT JOIN detail_pembelian dp ON pb.no_faktur = dp.no_faktur LEFT JOIN suplier ss ON pb.suplier = ss.id WHERE dp.kode_barang = '$kode_barang' AND dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal'  ";
if( !empty($requestData['search']['value']) ) { 
  // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND (dp.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR nama_suplier LIKE '".$requestData['search']['value']."%')   ";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
 $sql.=" ORDER BY CONCAT(dp.tanggal,' ',dp.jam) ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";
 /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query= mysqli_query($conn, $sql) or die("eror 3");

$data = array();


while($row = mysqli_fetch_array($query))
	{

$nestedData=array();
				$nestedData[] = $row['tanggal'] ;
				$nestedData[] = $row['nama_suplier'] ;
				$nestedData[] = $row['no_faktur'] ;
				$nestedData[] = "<p style='text-align:right'>".rp($row['harga'])."</p>";
				$nestedData[] = "<p style='text-align:right'>".rp($row['jumlah_barang'])."</p>";
				$data[] = $nestedData;	
} // end while

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format
?>


