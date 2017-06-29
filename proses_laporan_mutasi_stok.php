<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$sub_nilai_akhir = 0;
$sub_nilai_masuk = 0;
$sub_nilai_keluar = 0;
$sub_nilai_awal = 0;


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

	0 =>'nama_barang', 
	1 => 'kode_barang',
	2=> 'satuan'

);

// getting total number records without any search
$sql = "SELECT b.nama_barang, b.kode_barang, b.satuan, s.nama";
$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id ";
$sql.=" WHERE b.berkaitan_dgn_stok != 'Jasa' ";
$sql.=" ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT b.nama_barang, b.kode_barang, b.satuan, s.nama";
$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id ";
$sql.=" WHERE b.berkaitan_dgn_stok != 'Jasa' ";

	$sql.=" AND ( b.nama_barang LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR b.kode_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.satuan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
		
 $sql.=" ORDER BY b.kode_barang ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {  // preparing an array

			$pembelian = $db->query("SELECT dp.kode_barang, SUM(p.potongan) AS diskon_faktur FROM pembelian p INNER JOIN detail_pembelian dp ON p.no_faktur = dp.no_faktur WHERE dp.kode_barang = '$row[kode_barang]' AND p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
			$cek_pembelian = mysqli_fetch_array($pembelian);
			$diskon = $cek_pembelian['diskon_faktur'];


			$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]' AND tanggal <'$dari_tanggal'");
			$cek_awal_masuk = mysqli_fetch_array($hpp_masuk);

			$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$row[kode_barang]' AND tanggal <'$dari_tanggal'");
			$cek_awal_keluar = mysqli_fetch_array($hpp_keluar);

			$awal = $cek_awal_masuk['jumlah_kuantitas'] - $cek_awal_keluar['jumlah_kuantitas'];
			$nilai_awal = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

			$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
			$cek_hpp_masuk = mysqli_fetch_array($hpp_masuk);

			$masuk = $cek_hpp_masuk['jumlah_kuantitas'];
			$nilai_masuk = $cek_hpp_masuk['total_hpp'];
			$nilai_masuk = $nilai_masuk;

			$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$row[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
			$cek_hpp_keluar = mysqli_fetch_array($hpp_keluar);

			$keluar = $cek_hpp_keluar['jumlah_kuantitas'];
			$nilai_keluar = $cek_hpp_keluar['total_hpp'];

			$akhir = ($awal + $masuk) - $keluar;
			$nilai_akhir = ($nilai_awal + $nilai_masuk) - $nilai_keluar;



$nestedData = array();
$nestedData[] = $row["kode_barang"];
$nestedData[] = $row["nama_barang"];
$nestedData[] = $row["nama"];
$nestedData[] = rp($awal);
$nestedData[] = rp($nilai_awal);
$nestedData[] = rp($masuk);
$nestedData[] = rp($nilai_masuk);
$nestedData[] = rp($keluar);
$nestedData[] = rp($nilai_keluar);
$nestedData[] = rp($akhir);
$nestedData[] = rp($nilai_akhir);
$data[] = $nestedData;

}

			$pembelian = $db->query("SELECT dp.kode_barang, SUM(p.potongan) AS diskon_faktur FROM pembelian p INNER JOIN detail_pembelian dp ON p.no_faktur = dp.no_faktur WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
			$cek_pembelian = mysqli_fetch_array($pembelian);
			$diskon = $cek_pembelian['diskon_faktur'];


			$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE tanggal <'$dari_tanggal'");
			$cek_awal_masuk = mysqli_fetch_array($hpp_masuk);

			$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE tanggal <'$dari_tanggal'");
			$cek_awal_keluar = mysqli_fetch_array($hpp_keluar);

			$awal = $cek_awal_masuk['jumlah_kuantitas'] - $cek_awal_keluar['jumlah_kuantitas'];
			$nilai_awal = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

			$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
			$cek_hpp_masuk = mysqli_fetch_array($hpp_masuk);

			$masuk = $cek_hpp_masuk['jumlah_kuantitas'];
			$nilai_masuk = $cek_hpp_masuk['total_hpp'];
			$nilai_masuk = $nilai_masuk;

			$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
			$cek_hpp_keluar = mysqli_fetch_array($hpp_keluar);

			$keluar = $cek_hpp_keluar['jumlah_kuantitas'];
			$nilai_keluar = $cek_hpp_keluar['total_hpp'];

			$akhir = ($awal + $masuk) - $keluar;
			$nilai_akhir = ($nilai_awal + $nilai_masuk) - $nilai_keluar;

			$sub_nilai_akhir = $sub_nilai_akhir + $nilai_akhir;
			$sub_nilai_awal = $sub_nilai_awal + $nilai_awal;
			$sub_nilai_masuk = $sub_nilai_masuk + $nilai_masuk;
			$sub_nilai_keluar = $sub_nilai_keluar + $nilai_keluar;
		
$nestedData = array();

$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$data[] = $nestedData;


$nestedData = array();
$nestedData[] = "<b style='color:red' >TOTAL AKHIR :</b>";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "<b style='color:red'>". rp($sub_nilai_awal) ."</b>";
$nestedData[] = "";
$nestedData[] = "<b style='color:red'>". rp($sub_nilai_masuk) ."</b>";
$nestedData[] = "";
$nestedData[] = "<b style='color:red'>". rp($sub_nilai_keluar) ."</b>";
$nestedData[] = "";
$nestedData[] = "<b style='color:red'>". rp($sub_nilai_akhir) ."</b>";
$data[] = $nestedData;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

 ?>