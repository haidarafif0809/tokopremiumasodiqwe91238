<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

      
      $sum_subtotal_detail_penjualan = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
      $cek_sum_sub = mysqli_fetch_array($sum_subtotal_detail_penjualan);
      
      $sum_pajak_penjualan = $db->query("SELECT SUM(tax) AS pajak, SUM(potongan) AS diskon FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
      $cek_sum_pajak = mysqli_fetch_array($sum_pajak_penjualan);
      
      $subtotal = $cek_sum_sub['subtotal'] + $cek_sum_pajak['pajak'];
      
      $sum_hpp_penjualan = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
      $cek_sum_hpp = mysqli_fetch_array($sum_hpp_penjualan);
      
      $laba_kotor = $subtotal - $cek_sum_hpp['total_hpp'];
      
      $laba_jual = $laba_kotor - $cek_sum_pajak['diskon'];
      
      $total_subtotal = $subtotal;
      $total_total_pokok = $cek_sum_hpp['total_hpp'];
      $total_laba_kotor = $laba_kotor;
      $total_diskon = $cek_sum_pajak['diskon'];
      $total_laba_jual = $laba_jual;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur', 
	1 => 'kode_barang',
	2 => 'nama_barang',
	3 => 'jumlah_barang',
	4 => 'satuan',
	5 => 'harga',
	6 => 'subtotal',
	7 => 'potongan',
	8 => 'tax',
	9 => 'hpp',
	10 => 'sisa'
);

// getting total number records without any search
$sql =" SELECT p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,pl.nama_pelanggan ";
$sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id ";
$sql.=" WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("eror.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,pl.nama_pelanggan ";
$sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id ";
$sql.=" WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror.php2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();      
	
      $sum_subtotal_detail_penjualan = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_penjualan WHERE no_faktur = '$row[no_faktur]'");
      $cek_sum_sub = mysqli_fetch_array($sum_subtotal_detail_penjualan);
      
      $subtotal = $cek_sum_sub['subtotal'];
      
      $sum_hpp_penjualan = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$row[no_faktur]'");
      $cek_sum_hpp = mysqli_fetch_array($sum_hpp_penjualan);
      
      $laba_kotor = $subtotal - $cek_sum_hpp['total_hpp'];
      
      $laba_jual = $laba_kotor - $row['potongan'];



      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['kode_pelanggan']." - ".$row['nama_pelanggan'];
      $nestedData[] = rp($subtotal);
      $nestedData[] = rp($cek_sum_hpp['total_hpp']);
      $nestedData[] = rp($laba_kotor);
      $nestedData[] = rp($row['potongan']);
      $nestedData[] = rp($laba_jual);
	
	$data[] = $nestedData;

}

  $nestedData=array();
      
      $nestedData[] = "<p style='color:red'> TOTAL </p>";
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "<p style='color:red'>".rp($total_subtotal)."</p>";
      $nestedData[] = "<p style='color:red'>".rp($total_total_pokok)."</p>";
      $nestedData[] = "<p style='color:red'>".rp($total_laba_kotor)."</p>";
      $nestedData[] = "<p style='color:red'>".rp($total_diskon)."</p>";
      $nestedData[] = "<p style='color:red'>".rp($total_laba_jual)."</p>";
  
  $data[] = $nestedData;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>