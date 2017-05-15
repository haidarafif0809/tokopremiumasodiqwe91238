<?php 
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id_produk']);
$kode_barang = stringdoang($_POST['kode_barang']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND tanggal < '$dari_tanggal' ");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];

$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND tanggal < '$dari_tanggal' ");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

if ($requestData['start'] > 0) 
{	

		// getting total number records without any search
		$sql = $db->query("SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp,waktu, id ,jam FROM hpp_masuk 
			WHERE kode_barang = '$kode_barang' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' 
			UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp,waktu, id ,jam FROM hpp_keluar 
			WHERE kode_barang = '$kode_barang' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' 
			ORDER BY CONCAT(tanggal,' ',jam)  LIMIT ".$requestData['start']."  ");
		while($row = mysqli_fetch_array($sql))
		{
					if ($row['jenis_hpp'] == '1')
					{
								$masuk = $row['jumlah_kuantitas'];
								$total_saldo = ($total_saldo + $masuk);
					}
					else
					{
					$keluar = $row['jumlah_kuantitas'];
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
	5=> 'saldo'


);
// data yang akan di tampilkan di table


// getting total number records without any search
$sql = "SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp,waktu, id, jam FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp,waktu, id, jam FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp,waktu, id, jam FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp,waktu,id, jam FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ";
if( !empty($requestData['search']['value']) ) { 
  // if there is a search parameter, $requestData['search']['value'] contains search parameter

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

$data = array();

	$nestedData=array();

$nestedData[] = "";
 $nestedData[] = "<p color='red'>SALDO AWAL</p>";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "";
$nestedData[] = "<p style='color:red; text-align:right'>".rp($total_saldo)."</p>";


$data[] = $nestedData;



while($row = mysqli_fetch_array($query))
	{

$nestedData=array();

			
if ($row['jenis_hpp'] == '1')
{		
		$nestedData[] = $row['no_faktur'] ;

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)

			if ($row['jenis_transaksi'] == 'Pembelian') {

				$ambil_suplier = $db->query("SELECT p.suplier, s.nama FROM pembelian p INNER JOIN  suplier s ON p.suplier = s.id WHERE p.no_faktur = '$row[no_faktur]' ");
				$data_suplier = mysqli_fetch_array($ambil_suplier);
				$nama_suplier = $data_suplier['nama'];

				$nestedData[] = "<td> ".$row['jenis_transaksi']." (".$nama_suplier.") </td>";
				
			}
			else if ($row['jenis_transaksi'] == 'Retur Penjualan') {
				$ambil_pelanggan = $db->query("SELECT rp.kode_pelanggan, p.nama_pelanggan FROM retur_penjualan rp INNER JOIN  pelanggan p ON rp.kode_pelanggan = p.kode_pelanggan WHERE rp.no_faktur_retur = '$row[no_faktur]' ");
				$data_pelanggan = mysqli_fetch_array($ambil_pelanggan);
				$nama_pelanggan = $data_pelanggan['nama_pelanggan'];
				$nestedData[] = "<td> ".$row['jenis_transaksi']." (".$nama_pelanggan.") </td>";
			}
			else if ($row['jenis_transaksi'] == 'Stok Opname') {
				$nestedData[] = "<td> ".$row['jenis_transaksi']." ( + ) </td>";
			}
			else{
				$nestedData[] = $row['jenis_transaksi'];
			}

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)

//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)
			if ($row['jenis_transaksi'] == 'Pembelian') {

				$ambil_harga_beli = $db->query("SELECT harga AS harga_beli FROM detail_pembelian  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_beli = mysqli_fetch_array($ambil_harga_beli);
				$harga_beli = $data_beli['harga_beli'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_beli)."</p>";
				
			}
			else if ($row['jenis_transaksi'] == 'Retur Penjualan') {


				$ambil_harga_retur_jual = $db->query("SELECT harga AS harga_retur_jual FROM detail_retur_penjualan  WHERE no_faktur_retur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_retur_jual = mysqli_fetch_array($ambil_harga_retur_jual);
				$harga_retur_jual = $data_retur_jual['harga_retur_jual'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_retur_jual)."</p>";
			}
			else if ($row['jenis_transaksi'] == 'Item Masuk') {


				$ambil_harga_masuk = $db->query("SELECT harga AS harga_masuk FROM detail_item_masuk  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_masuk = mysqli_fetch_array($ambil_harga_masuk);
				$harga_masuk = $data_masuk['harga_masuk'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_masuk)."</p>";
			}
			else if ($row['jenis_transaksi'] == 'Stok Opname') {


				$ambil_harga_opname = $db->query("SELECT harga AS harga_opname FROM detail_stok_opname  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_opname = mysqli_fetch_array($ambil_harga_opname);
				$harga_opname = $data_opname['harga_opname'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_opname)."</p>";
			}
			else if ($row['jenis_transaksi'] == 'Stok Awal') {


				$ambil_harga_awal = $db->query("SELECT harga AS harga_awal FROM stok_awal  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_awal = mysqli_fetch_array($ambil_harga_awal);
				$harga_awal = $data_awal['harga_awal'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_awal)."</p>";
			}


			else if ($row['jenis_transaksi'] == 'Transfer Stok') {


				$ambil_harga_transfer = $db->query("SELECT harga AS harga_transfer FROM detail_transfer_stok  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_transfer = mysqli_fetch_array($ambil_harga_transfer);
				$harga_transfer = $data_transfer['harga_transfer'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_transfer)."</p>";
			}



//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)
//
		$nestedData[] = tanggal($row['tanggal']);

		$masuk = $row['jumlah_kuantitas'];
		$total_saldo = ($total_saldo + $masuk);

		$nestedData[] = "<p style='text-align:right'>".rp($masuk)."</p>";
		$nestedData[] = "<p style='text-align:right'>0</p>";
		$nestedData[] = "<p style='text-align:right'>".rp($total_saldo)."</p>";
		$data[] = $nestedData;
	
}
else
{
		$nestedData[] = $row['no_faktur'] ;
//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)

			if ($row['jenis_transaksi'] == 'Retur Pembelian') {

				$ambil_suplier = $db->query("SELECT p.nama_suplier, s.nama FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE p.no_faktur_retur = '$row[no_faktur]' ");
				$data_suplier = mysqli_fetch_array($ambil_suplier);
				$nama_suplier = $data_suplier['nama'];

				$nestedData[] = "<td> ".$row['jenis_transaksi']." (".$nama_suplier.") </td>";
				
			}
			else if ($row['jenis_transaksi'] == 'Penjualan') {
				$ambil_pelanggan = $db->query("SELECT p.kode_pelanggan, pl.nama_pelanggan FROM penjualan p INNER JOIN  pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE p.no_faktur = '$row[no_faktur]' ");
				$data_pelanggan = mysqli_fetch_array($ambil_pelanggan);
				$nama_pelanggan = $data_pelanggan['nama_pelanggan'];
				$nestedData[] = "<td> ".$row['jenis_transaksi']." (".$nama_pelanggan.") </td>";
			}
			else if ($row['jenis_transaksi'] == 'Stok Opname') {
				$nestedData[] = "<td> ".$row['jenis_transaksi']." ( - ) </td>";
			}
			else{
				$nestedData[] = $row['jenis_transaksi'];
			}
//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)
//

//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)

			if ($row['jenis_transaksi'] == 'Penjualan') {

				$ambil_harga_jual = $db->query("SELECT harga AS harga_jual FROM detail_penjualan  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_jual = mysqli_fetch_array($ambil_harga_jual);
				$harga_jual = $data_jual['harga_jual'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_jual)."</p>";
				
			}
			else if ($row['jenis_transaksi'] == 'Retur Pembelian') {


				$ambil_harga_retur_beli = $db->query("SELECT harga AS harga_retur_beli FROM detail_retur_pembelian  WHERE no_faktur_retur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_retur_beli = mysqli_fetch_array($ambil_harga_retur_beli);
				$harga_retur_beli = $data_retur_beli['harga_retur_beli'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_retur_beli)."</p>";
			}
			else if ($row['jenis_transaksi'] == 'Item Keluar') {


				$ambil_harga_keluar = $db->query("SELECT harga AS harga_keluar FROM detail_item_keluar  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_keluar = mysqli_fetch_array($ambil_harga_keluar);
				$harga_keluar = $data_keluar['harga_keluar'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_keluar)."</p>";
			}
			else if ($row['jenis_transaksi'] == 'Stok Opname') {


				$ambil_harga_opname = $db->query("SELECT harga AS harga_opname FROM detail_stok_opname  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_opname = mysqli_fetch_array($ambil_harga_opname);
				$harga_opname = $data_opname['harga_opname'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_opname)."</p>";
			}
			else if ($row['jenis_transaksi'] == 'Transfer Stok') {


				$ambil_harga_transfer = $db->query("SELECT harga AS harga_transfer FROM detail_transfer_stok  WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$kode_barang' ");
				$data_transfer = mysqli_fetch_array($ambil_harga_transfer);
				$harga_transfer = $data_transfer['harga_transfer'];

				$nestedData[] = "<p style='text-align:right'>".rp($harga_transfer)."</p>";
			}


//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)

		$nestedData[] = tanggal($row['tanggal']);

		$keluar = $row['jumlah_kuantitas'];
		$total_saldo = $total_saldo - $keluar;

		$nestedData[] =	"<p style='text-align:right'>0</p>";
		$nestedData[] = "<p style='text-align:right'>".rp($keluar)."</p>";
		$nestedData[] = "<p style='text-align:right'>".rp($total_saldo)."</p>";
		$data[] = $nestedData;	

}



} // end while

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format
?>


