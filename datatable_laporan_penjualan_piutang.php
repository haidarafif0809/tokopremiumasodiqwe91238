<?php
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

  $query02 = $db->query("SELECT SUM(pen.tunai) AS tunai_penjualan,SUM(pen.total) AS total_akhir, SUM(pen.kredit) AS total_kredit ,SUM(dpp.jumlah_bayar) + SUM(dpp.potongan) AS ambil_total_bayar FROM penjualan pen LEFT JOIN detail_pembayaran_piutang dpp ON pen.no_faktur = dpp.no_faktur_penjualan WHERE pen.tanggal >= '$dari_tanggal' AND pen.tanggal <= '$sampai_tanggal' AND pen.kredit != 0 ");

// LOGIKA UNTUK  UNTUK AMBIL  BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)

$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];
$total_kredit = $cek02['total_kredit'];
$total_bayar = $cek02['tunai_penjualan'] +  $cek02['ambil_total_bayar'];


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

  0 => 'Tanggal', 
  1 => 'Nomor',
  2 => 'nama_kostumer',
  3 => 'sales',
  4 => 'nilai_faktur', 
  5 => 'dibayar',
  6 => 'piutang',

);

// LOGIKA UNTUK FILTER BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)

// getting total number records without any search
$sql =" SELECT p.id,p.tanggal,p.tanggal_jt, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_piutang ,p.no_faktur,p.kode_pelanggan,p.total,p.jam,p.status,p.potongan,p.tax,p.sisa,p.kredit, pl.nama_pelanggan";
$sql.=" FROM penjualan p INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0  ";

// LOGIKA UNTUK FILTER BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)

$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// LOGIKA UNTUK FILTER BERDASARKAN KONSUMEN DAN SALES (QUERY PENCARIAN DATATABLE)
$sql =" SELECT p.id,p.tanggal,p.tanggal_jt, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_piutang ,p.no_faktur,p.kode_pelanggan,p.total,p.jam,p.status,p.potongan,p.tax,p.sisa,p.kredit, pl.nama_pelanggan";
$sql.=" FROM penjualan p INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0  ";
// LOGIKA UNTUK FILTER BERDASARKAN KONSUMEN DAN SALES (QUERY PENCARIAN DATATABLE)


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' )";
	
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.="ORDER BY waktu_input DESC  LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


$query0232 = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS total_bayar FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$row[no_faktur]' ");
$kel_bayar = mysqli_fetch_array($query0232);

$sum_dp = $db->query("SELECT SUM(tunai) AS tunai_penjualan FROM penjualan WHERE no_faktur = '$row[no_faktur]' ");
$data_sum = mysqli_fetch_array($sum_dp);
$Dp = $data_sum['tunai_penjualan'];

$num_rows = mysqli_num_rows($query0232);

$tot_bayar = $kel_bayar['total_bayar'] + $Dp;

      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['nama_pelanggan'];
      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['tanggal_jt'];
      $nestedData[] =  "<p align='right'>".rp($row['usia_piutang'])." Hari</p>";
      $nestedData[] =  "<p align='right'>".rp($row['total'])."</p>";

      if ($num_rows > 0 )
      {
      	$nestedData[] =  "<p align='right'>".rp($tot_bayar)."</p>";
      }
      else
      {
      	$nestedData[] = "0";

      }

      $nestedData[] =  "<p align='right'>".rp($row['kredit'])."</p>";

  $data[] = $nestedData;
}



$nestedData=array();      

      $nestedData[] = "<p style='color:red'> TOTAL </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red' align='right' > - </p>";
      $nestedData[] = "<p style='color:red' align='right' > ".rp($total_akhir)." </p>";
      $nestedData[] = "<p style='color:red' align='right' > ".rp($total_bayar)." </p>";
      $nestedData[] = "<p style='color:red' align='right' > ".rp($total_kredit)." </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
  
  $data[] = $nestedData;

  
$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>