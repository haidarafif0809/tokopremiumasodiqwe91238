<?php 
include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_POST['id_produk']); 
$kode_barang = stringdoang($_POST['kode_barang']); 
$bulan = stringdoang($_POST['bulan']); 
$tahun = stringdoang($_POST['tahun']);

if ($bulan == '1')
{
	$moon = 'Januari';
}
else if ($bulan == '2')
{
	$moon = 'Febuari';
}
else if ($bulan == '3')
{
	$moon = 'Maret';
}
else if ($bulan == '4')
{
	$moon = 'April';
}
else if ($bulan == '5')
{
	$moon = 'Mei';
}
else if ($bulan == '6')
{
	$moon = 'Juni';
}
else if ($bulan == '7')
{
	$moon = 'Juli';
}
else if ($bulan == '8')
{
	$moon = 'Agustus';
}
else if ($bulan == '9')
{
	$moon = 'September';
}
else if ($bulan == '10')
{
	$moon = 'Oktober';
}
else if ($bulan == '11')
{
	$moon = 'November';
}
else if ($bulan == '12')
{
	$moon = 'Desember';
}



// awal Select untuk hitung Saldo Awal
$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND CONCAT(tanggal,'',jam) <= '$bulan' AND CONCAT(tanggal,'',jam) <= '$tahun'");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND CONCAT(tanggal,'',jam) <= '$bulan' AND CONCAT(tanggal,'',jam) <= '$tahun'");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;




// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

if ($requestData['start'] > 0) 
{	

		// getting total number records without any search
		$sql = $db->query("SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp, tanggal, jam FROM hpp_masuk 
			WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' 
			UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp, tanggal, jam FROM hpp_keluar 
			WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' 
			ORDER BY CONCAT(tanggal,' ',jam)  LIMIT ".$requestData['start']."  ");
		while($row = mysqli_fetch_array($sql))
		{
					if ($data['jenis_hpp'] == '1')
					{
						$masuk = $data['jumlah_kuantitas'];
						 $total_saldo = ($total_saldo + $masuk);
					}
					else
					{

					$keluar = $data['jumlah_kuantitas'];
					$total_saldo = $total_saldo - $keluar;
					}
		} 

}

$columns = array( 
// datatable column index  => database column name

	0 =>'no_faktur', 
	1 => 'tipe_transaksi',
	2=> 'tanggal',
	3 => 'masuk',
	4=> 'keluar',
	5=> 'saldo',


);

// getting total number records without any search
$sql = "SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp, tanggal, jam FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp, tanggal, jam FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp , tanggal, jam FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp, tanggal, jam FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ";
	$sql.=" AND (no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR jenis_transaksi LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR jumlah_kuantitas LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%')   ";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY CONCAT(tanggal,' ',jam) ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";
 /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query= mysqli_query($conn, $sql) or die("eror 3");

$datatable = array();

	$nestedData=array();

$nestedData[] = "";
 $nestedData[] = "<font color='red'>SALDO AWAL</font>";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] =  "<font color='red'>".rp($total_saldo)."</font>" ;


$datatable[] = $nestedData;

while($data = mysqli_fetch_array($query))
	{

$nestedData=array();

if ($data['jenis_hpp'] == '1')
{
	$masuk = $data['jumlah_kuantitas'];
	 $total_saldo = ($total_saldo + $masuk);

		

		$nestedData[] = $data['no_faktur'] ;
			$nestedData[] = $data['jenis_transaksi'];
			$nestedData[] = $data['tanggal'];
			$nestedData[] = $masuk ;
		$nestedData[] =   	"0";
		$nestedData[] =  $total_saldo ;

		$datatable[] = $nestedData;
		
}
else
{

$keluar = $data['jumlah_kuantitas'];
$total_saldo = $total_saldo - $keluar;


		
		$nestedData[] =	$data['no_faktur'] ;
		$nestedData[] = $data['jenis_transaksi'] ;
		$nestedData[] =	 $data['tanggal'] ;
		$nestedData[] =	"0";
		 $nestedData[] = 	$keluar;
		$nestedData[] =   $total_saldo;

			$datatable[] = $nestedData;
}




} // end while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $datatable   // total data array
			);

echo json_encode($json_data);  // send data as json format
?>
