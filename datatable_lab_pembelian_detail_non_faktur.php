<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

  $query_sum_detail_pembaelian = $db->query("SELECT SUM(jumlah_barang) as sum_jumlah,SUM(subtotal) as sum_subtotal,SUM(potongan) AS sum_potongan,SUM(tax) AS sum_tax,SUM(sisa) AS sum_sisa  FROM detail_pembelian  WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$data_sum_dari_detail_pembaelian = mysqli_fetch_array($query_sum_detail_pembaelian);
$total_akhir = $data_sum_dari_detail_pembaelian['sum_subtotal'];
$total_jumlah = $data_sum_dari_detail_pembaelian['sum_jumlah'];


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	 0 =>'nama',
	 1=>'kode_barang',
	 2=>'nama_barang',
	 3=>'jumlah_barang',
	 4=>'potongan',
	 6=>'tax',
	 7=>'sisa',
	 8=>'id',
	 9=>'id'
);

// getting total number records without any search
$sql ="SELECT SUM(dp.jumlah_barang) as sum_jumlah,s.nama,dp.id,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,SUM(dp.subtotal) as sum_subtotal,SUM(dp.potongan) AS sum_potongan,SUM(dp.tax) AS sum_tax,SUM(dp.sisa) AS sum_sisa, ss.nama AS asal_satuan ";
$sql.=" FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT SUM(dp.jumlah_barang) as sum_jumlah,s.nama,dp.id,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,SUM(dp.subtotal) as sum_subtotal,SUM(dp.potongan) AS sum_potongan,SUM(dp.tax) AS sum_tax,SUM(dp.sisa) AS sum_sisa, ss.nama AS asal_satuan ";
$sql.=" FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( dp.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.kode_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ) ";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " GROUP BY dp.kode_barang ORDER BY dp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	

					//menampilkan data
					$nestedData[] = $row['kode_barang'];
					$nestedData[] = $row['nama_barang'];
					$nestedData[] = "<p align='right'>".$row['sum_jumlah']." ". $row['asal_satuan']." </p>";
					$nestedData[] = "<p align='right'>".rp($row['sum_subtotal'])." </p>";
					$nestedData[] = rp($row['sum_potongan']);
					$nestedData[] = rp($row['sum_tax']);
					$nestedData[] = $row["id"];
				$data[] = $nestedData;
			}


$nestedData=array();      

      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($total_jumlah)." </p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($total_akhir)." </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
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
