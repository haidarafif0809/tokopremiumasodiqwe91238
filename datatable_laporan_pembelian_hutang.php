<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$jumlah_bayar_hutang = 0;

$query_sum = $db->query("SELECT SUM(total) AS total_akhir, SUM(tunai) AS total_tunai, SUM(kredit) AS total_kredit, SUM(nilai_kredit) AS total_nilai_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$data_sum = mysqli_fetch_array($query_sum);

  $query_faktur_pembelian = $db->query("SELECT no_faktur FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 ");
  while ($data_faktur_pembelian = mysqli_fetch_array($query_faktur_pembelian)) {
    $query_sum_dari_detail_pembayaran_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS ambil_total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_faktur_pembelian[no_faktur]' ");
    $data_sum_dari_detail_pembayaran_hutang = mysqli_fetch_array($query_sum_dari_detail_pembayaran_hutang);
    $jumlah_bayar_hutang = $jumlah_bayar_hutang + $data_sum_dari_detail_pembayaran_hutang['ambil_total_bayar'];
  }

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur',
	 1=>'total',
	 2=>'suplier',
	 3=>'tanggal',
	 4=>'tanggal_jt',
	 5=>'jam',
	 6=>'user',
	 7=>'status',
	 8=>'potongan,',
	 9=>'tax',
	 10=>'sisa',
	 11=>'kredit',
	 12=>'nilai_kredit',
	 13=>'nama',
	 14=>'nama_gudang',
	 15=>'id'
);

// getting total number records without any search
$sql ="SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nilai_kredit,s.nama,g.nama_gudang,p.tunai, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang ";
$sql.="FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND kredit != 0 ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nilai_kredit,s.nama,g.nama_gudang,p.tunai, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang ";
$sql.="FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND kredit != 0 AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal_jt LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%'  )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			$query_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$row[no_faktur]' ");
			$data_hutang = mysqli_fetch_array($query_hutang);

			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['no_faktur'];
			$nestedData[] = $row['nama'];
			$nestedData[] = $row['tanggal_jt'];
			$nestedData[] = $row['usia_hutang'];
			$nestedData[] = $row['user'];
			$nestedData[] = "<p align='right'>".rp($row['total'])."</p>";
			$nestedData[] = "<p align='right'>".rp($row['tunai'])."</p>";
			$nestedData[] = "<p align='right'>".rp($row['nilai_kredit'])."</p>";
			$nestedData[] = "<p align='right'>".rp($data_hutang['total_bayar'])."</p>";
			$nestedData[] = "<p align='right'>".rp($row['kredit'])."</p>";

	$data[] = $nestedData;
			}

	$nestedData=array(); 

			$nestedData[] = "<p style='color:red'>TOTAL</p>";
			$nestedData[] = "<p style='color:red'>-</p>";
			$nestedData[] = "<p style='color:red'>-</p>";
			$nestedData[] = "<p style='color:red'>-</p>";
			$nestedData[] = "<p style='color:red'>-</p>";
			$nestedData[] = "<p style='color:red'>-</p>";
			$nestedData[] = "<p style='color:red' align='right'>".rp($data_sum['total_akhir'])."</p>";
			$nestedData[] = "<p style='color:red' align='right'>".rp($data_sum['total_tunai'])."</p>";
			$nestedData[] = "<p style='color:red' align='right'>".rp($data_sum['total_nilai_kredit'])."</p>";
			$nestedData[] = "<p style='color:red' align='right'>".rp($jumlah_bayar_hutang)."</p>";
			$nestedData[] = "<p style='color:red' align='right'>".rp($data_sum['total_kredit'])."</p>";
			$nestedData[] = "<p style='color:red' align='right'>-</p>";

	$data[] = $nestedData;



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
