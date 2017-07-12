<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$query_sum_detail_pembaelian = $db->query("SELECT SUM(jumlah_barang) as sum_jumlah,SUM(subtotal) as sum_subtotal,SUM(potongan) AS sum_potongan,SUM(tax) AS sum_tax,SUM(sisa) AS sum_sisa  FROM detail_pembelian  WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$data_sum_dari_detail_pembaelian = mysqli_fetch_array($query_sum_detail_pembaelian);
$total_akhir = $data_sum_dari_detail_pembaelian['sum_subtotal'];
$total_jumlah = $data_sum_dari_detail_pembaelian['sum_jumlah'];
$total_potongan = $data_sum_dari_detail_pembaelian['sum_potongan'];
$total_tax = $data_sum_dari_detail_pembaelian['sum_tax'];


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	 0 =>'nama',
	 1=>'no_faktur',
	 2=>'kode_barang',
	 3=>'nama_barang',
	 4=>'jumlah_barang',
	 5=>'satuan',
	 6=>'harga',
	 7=>'subtotal',
	 8=>'potongan',
	 9=>'tax',
	 10=>'sisa',
	 11=>'nama',
	 12=>'id'
);

// getting total number records without any search
$sql ="SELECT s.nama,dp.id,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.sisa, ss.nama AS asal_satuan ";
$sql.=" FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT s.nama,dp.id,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.sisa, ss.nama AS asal_satuan ";
$sql.=" FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( dp.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.kode_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY dp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

				$pilih_konversi = $db->query("SELECT $row[jumlah_barang] / sk.konversi AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$row[satuan]' AND sk.kode_produk = '$row[kode_barang]'");
					      $data_konversi = mysqli_fetch_array($pilih_konversi);

					      if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
					        
					         $jumlah_barang = $data_konversi['jumlah_konversi'];
					      }
					      else{
					        $jumlah_barang = $row['jumlah_barang'];
					      }
					$sisa = cekStokHppProduk($row['kode_barang'], $row['no_faktur']);

					//menampilkan data
					$nestedData[] = $row['no_faktur'];
					$nestedData[] = $row['kode_barang'];
					$nestedData[] = $row['nama_barang'];
					$nestedData[] = "<p  align='right'>".$jumlah_barang ." ". $row['nama']." </p>";
					$nestedData[] = "<p  align='right'>".rp($row['harga'])." </p>";
					$nestedData[] = "<p  align='right'>".rp($row['potongan'])." </p>";
					$nestedData[] = "<p  align='right'>".rp($row['tax'])." </p>";
					$nestedData[] = "<p  align='right'>".rp($row['subtotal'])." </p>";
					$nestedData[] = "<p  align='right'>".rp($sisa) ." ". $row['asal_satuan']." </p>";
				$nestedData[] = $row["id"];
				$data[] = $nestedData;
			}


	$nestedData=array();      

      $nestedData[] = "<p style='color:red'> TOTAL </p>";
      $nestedData[] = "<p style='color:red'> </p>";
      $nestedData[] = "<p style='color:red'> </p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($total_jumlah)." </p>";
      $nestedData[] = "<p style='color:red' align='right'> - </p>";
      $nestedData[] = "<p style='color:red' align='right'>".rp($total_potongan)." </p>";
      $nestedData[] = "<p style='color:red' align='right'>".rp($total_tax)." </p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($total_akhir)." </p>";
      $nestedData[] = "<p style='color:red' align='right'>- </p>";
	
	$data[] = $nestedData;



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
