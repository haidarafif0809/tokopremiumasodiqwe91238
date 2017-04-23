<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_kartu_stok.xls");

include 'db.php';
include 'sanitasi.php';

$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);
$bulan = stringdoang($_GET['bulan']);
$tahun = stringdoang($_GET['tahun']);
$moon = stringdoang($_GET['moon']);

// awal Select untuk hitung Saldo Awal
$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND CONCAT(tanggal,'',jam) <= '$bulan' AND CONCAT(tanggal,'',jam) <= '$tahun'");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND CONCAT(tanggal,'',jam) <= '$bulan' AND CONCAT(tanggal,'',jam) <= '$tahun'");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;
 ?>

<style type="text/css">
  .rata-kanan{
    text-align: right;
  }
</style>

<div class="container">

<table style="color:blue;">
	<tbody>
		<tr><center><h3><b>Laporan Data Stok</b></h3></center></tr>
		<tr><td><b>Kode Barang</b></td> <td>=</td> <td><b><?php echo $kode_barang ?></b></td> </tr>
		<tr><td><b>Nama Barang</b></td> <td>=</td> <td><b><?php echo $nama_barang ?></b></td> </tr>
		<tr><td><b>Bulan</b></td> <td>=</td> <td><b><?php echo $moon ?></b></td> </tr>
		<tr><td><b>Tahun</b></td> <td>=</td> <td><b><?php echo $tahun ?></b></td> </tr>
	</tbody>
</table>
</b>
</h3>
    <table id="kartu_stok" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

      <th style='background-color: #4CAF50; color:white'> No Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Jenis Transaksi </th>
      <th style='background-color: #4CAF50; color:white'> Harga </th>
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Masuk </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Keluar </th>
      <th style='background-color: #4CAF50; color:white'> Saldo</th>

</thead>
<tbody>
<tr style="color:red;">
<td></td>
<td style='background-color:gold;'>Saldo Awal</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td style='background-color:gold;' class='rata-kanan'><?php echo rp($total_saldo) ?></td>
</tr>

<?php 


$select = $db->query("SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp, tanggal, jam FROM hpp_masuk 
			WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' 
			UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp, tanggal, jam FROM hpp_keluar 
			WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' 
			ORDER BY CONCAT(tanggal,' ',jam)  ");

while($data = mysqli_fetch_array($select))
	{

if ($data['jenis_hpp'] == '1')
{
	$masuk = $data['jumlah_kuantitas'];
	$total_saldo = ($total_saldo + $masuk);

			echo "<tr>
			<td>". $data['no_faktur'] ."</td>";
      
//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)
      
      if ($data['jenis_transaksi'] == 'Pembelian') {

        $ambil_suplier = $db->query("SELECT p.suplier, s.nama FROM pembelian p INNER JOIN  suplier s ON p.suplier = s.id WHERE p.no_faktur = '$data[no_faktur]' ");
        $data_suplier = mysqli_fetch_array($ambil_suplier);
        $nama_suplier = $data_suplier['nama'];

        echo "<td> ".$data['jenis_transaksi']." (".$nama_suplier.") </td>";
        
      }
      else if ($data['jenis_transaksi'] == 'Retur Penjualan') {
        $ambil_pelanggan = $db->query("SELECT rp.kode_pelanggan, p.nama_pelanggan FROM retur_penjualan rp INNER JOIN  pelanggan p ON rp.kode_pelanggan = p.kode_pelanggan WHERE rp.no_faktur_retur = '$data[no_faktur]' ");
        $data_pelanggan = mysqli_fetch_array($ambil_pelanggan);
        $nama_pelanggan = $data_pelanggan['nama_pelanggan'];
        echo "<td> ".$data['jenis_transaksi']." (".$nama_pelanggan.") </td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Opname') {
        echo "<td> ".$data['jenis_transaksi']." ( + )</td>";
      }
      else{
       echo "<td>".$data['jenis_transaksi']."</td>";
      }

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)
//
//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)
      if ($data['jenis_transaksi'] == 'Pembelian') {

        $ambil_harga_beli = $db->query("SELECT harga AS harga_beli FROM detail_pembelian  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_beli = mysqli_fetch_array($ambil_harga_beli);
        $harga_beli = $data_beli['harga_beli'];

        echo "<td class='rata-kanan'>".rp($harga_beli)."</td>";
        
      }
      else if ($data['jenis_transaksi'] == 'Retur Penjualan') {


        $ambil_harga_retur_jual = $db->query("SELECT harga AS harga_retur_jual FROM detail_retur_penjualan  WHERE no_faktur_retur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_retur_jual = mysqli_fetch_array($ambil_harga_retur_jual);
        $harga_retur_jual = $data_retur_jual['harga_retur_jual'];

        echo "<td class='rata-kanan'>".rp($harga_retur_jual)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Item Masuk') {


        $ambil_harga_masuk = $db->query("SELECT harga AS harga_masuk FROM detail_item_masuk  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_masuk = mysqli_fetch_array($ambil_harga_masuk);
        $harga_masuk = $data_masuk['harga_masuk'];

        echo "<td class='rata-kanan'>".rp($harga_masuk)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Opname') {


        $ambil_harga_opname = $db->query("SELECT harga AS harga_opname FROM detail_stok_opname  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_opname = mysqli_fetch_array($ambil_harga_opname);
        $harga_opname = $data_opname['harga_opname'];

        echo "<td class='rata-kanan'>".rp($harga_opname)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Awal') {


        $ambil_harga_awal = $db->query("SELECT harga AS harga_awal FROM stok_awal  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_awal = mysqli_fetch_array($ambil_harga_awal);
        $harga_awal = $data_awal['harga_awal'];

        echo "<td class='rata-kanan'>".rp($harga_awal);
      }

//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)

  echo "<td>". tanggal($data['tanggal']) ."</td>
      <td class='rata-kanan'>". rp($masuk) ."</td>
      <td class='rata-kanan'>0</td>
      <td class='rata-kanan'>". rp($total_saldo) ."</td>
			";
}
else
{

$keluar = $data['jumlah_kuantitas'];
$total_saldo = $total_saldo - $keluar;

			echo "<tr>
			<td>". $data['no_faktur'] ."</td>";

      //LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)

      if ($data['jenis_transaksi'] == 'Retur Pembelian') {

        $ambil_suplier = $db->query("SELECT p.nama_suplier, s.nama FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE p.no_faktur_retur = '$data[no_faktur]' ");
        $data_suplier = mysqli_fetch_array($ambil_suplier);
        $nama_suplier = $data_suplier['nama'];

        echo "<td> ".$data['jenis_transaksi']." (".$nama_suplier.") </td>";
        
      }
      else if ($data['jenis_transaksi'] == 'Penjualan') {
        $ambil_pelanggan = $db->query("SELECT p.kode_pelanggan, pl.nama_pelanggan FROM penjualan p INNER JOIN  pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE p.no_faktur = '$data[no_faktur]' ");
        $data_pelanggan = mysqli_fetch_array($ambil_pelanggan);
        $nama_pelanggan = $data_pelanggan['nama_pelanggan'];
        echo "<td> ".$data['jenis_transaksi']." (".$nama_pelanggan.") </td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Opname') {
        echo "<td> ".$data['jenis_transaksi']." ( - ) </td>";
      }
      else{
        echo "<td>".$data['jenis_transaksi']."</td>";
      }

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)
//
//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)

      if ($data['jenis_transaksi'] == 'Penjualan') {

        $ambil_harga_jual = $db->query("SELECT harga AS harga_jual FROM detail_penjualan  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_jual = mysqli_fetch_array($ambil_harga_jual);
        $harga_jual = $data_jual['harga_jual'];

        echo "<td class='rata-kanan'>".rp($harga_jual)."</td>";
        
      }
      else if ($data['jenis_transaksi'] == 'Retur Pembelian') {


        $ambil_harga_retur_beli = $db->query("SELECT harga AS harga_retur_beli FROM detail_retur_pembelian  WHERE no_faktur_retur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_retur_beli = mysqli_fetch_array($ambil_harga_retur_beli);
        $harga_retur_beli = $data_retur_beli['harga_retur_beli'];

        echo "<td class='rata-kanan'>".rp($harga_retur_beli)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Item Keluar') {


        $ambil_harga_keluar = $db->query("SELECT harga AS harga_keluar FROM detail_item_keluar  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_keluar = mysqli_fetch_array($ambil_harga_keluar);
        $harga_keluar = $data_keluar['harga_keluar'];

        echo "<td class='rata-kanan'>".rp($harga_keluar)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Opname') {


        $ambil_harga_opname = $db->query("SELECT harga AS harga_opname FROM detail_stok_opname  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_opname = mysqli_fetch_array($ambil_harga_opname);
        $harga_opname = $data_opname['harga_opname'];

        echo "<td class='rata-kanan'>".rp($harga_opname)."</td>";
      }

//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)

      echo "<td>". tanggal($data['tanggal']) ."</td>
      <td class='rata-kanan'>0</td>
      <td class='rata-kanan'>".rp($keluar)."</td>
      <td class='rata-kanan'>". rp($total_saldo) ."</td>
			";
}

		echo "</tr>";


} // and while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!--Closed Container-->



