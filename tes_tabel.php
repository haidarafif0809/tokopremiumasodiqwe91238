<?php 

include 'db.php';
include 'sanitasi.php';
 
?>


<table id="table-pelamar" class="table table-bordered">
 
    <thead>

         <tr>
         <th>No Faktur</th>
         <th>Kode Barang</th>
         <th>Tanggal </th>
         <th>Tipe</th>
         <th>Jumlah Masuk</th>
         <th>Jumlah Keluar</th>
         <th>Saldo</th>
         <th>Pelanggan / Suplier</th>
         </tr>

    </thead>
    <tbody>
      <tr style="color:blue;">
<?php 
// untuk produk yang nambah 
$query00 = $db->query("SELECT SUM(jumlah) AS jumlah_produk FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Pembelian' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) < '$tahun' ");
$cek0 = mysqli_fetch_array($query00);
$jumlah_produk0 = $cek0['jumlah_produk'];

$query10 = $db->query("SELECT SUM(jumlah) AS jumlah_retur FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Retur Penjualan' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) < '$tahun'");
$cek10 = mysqli_fetch_array($query10);
$jumlah_retur0 = $cek10['jumlah_retur'];


$query20 = $db->query("SELECT SUM(jumlah) AS jumlah_item FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Stok Awal' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) < '$tahun'");
$cek20 = mysqli_fetch_array($query20);
$jumlah_item0 = $cek20['jumlah_item'];

$query30 = $db->query("SELECT SUM(jumlah) AS jumlah_stok_awal FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Item Masuk' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) < '$tahun'");
$cek30 = mysqli_fetch_array($query30);
$jumlah_stok_awal0 = $cek30['jumlah_stok_awal'];


$tambah_jumlah0 = $jumlah_produk0 + $jumlah_retur0 + $jumlah_item0 + $jumlah_stok_awal0;

// untuk produk yang berkurang

$querdo0 = $db->query("SELECT SUM(jumlah) AS jumlah_produk_jual FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Penjualan' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) < '$tahun'");
$out0 = mysqli_fetch_array($querdo0);
$jumlah_jual0 = $out0['jumlah_produk_jual'];

$querdo10 = $db->query("SELECT SUM(jumlah) AS jumlah_produk_retur FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Retur Pembelian' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) < '$tahun'");
$out10 = mysqli_fetch_array($querdo10);
$jumlah_produk_retur_beli0 = $out10['jumlah_produk_retur'];

$querdo20 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Item Keluar' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) < '$tahun'");
$out20 = mysqli_fetch_array($querdo20);
$jumlah_item_keluar0 = $out20['jumlah_item_keluar'];


$kurang_jumlah0 = $jumlah_jual0 + $jumlah_produk_retur_beli0 + $jumlah_item_keluar0;


// hasil nya

$saldo = $tambah_jumlah0 - $kurang_jumlah0;
 ?>

<td></td>
<td></td>
<td></td>
<td>Saldo Awal</td>
<td></td>
<td></td>
<td></td>
<td><?php echo $saldo; ?></td>
</tr>
<?php 


$select_to = $db->query("SELECT * FROM kartu_stok WHERE kode_barang = '03' AND MONTH(tanggal) = '5' AND YEAR(tanggal) = '2016' ORDER BY tanggal ASC");
while ($data = mysqli_fetch_array($select_to))
{


 
echo" <tr><td>". $data['no_transaksi']."</td>
      <td>". $data['kode_barang']."</td>
      <td>". $data['tanggal']."</td>
      <td>". $data['tipe']."</td>";

if ($data['tipe'] == 'Penjualan' OR $data['tipe'] == 'Item Keluar' OR $data['tipe'] == 'Retur Pembelian' )
{
  $saldo = $saldo - $data['jumlah'];
echo "<td>0</td>
  <td>". $data['jumlah']."</td>
  ";
  echo " <td>". $saldo."</td>
</tr>
";
}
else if ($data['tipe'] == 'Pembelian' OR $data['tipe'] == 'Item Masuk' OR $data['tipe'] == 'Retur Penjualan' OR $data['tipe'] == 'Stok Awal')
{
$saldo = $saldo + $data['jumlah'];

echo "<td>". $data['jumlah']."</td>
  <td>0</td>
  ";
  echo " <td>". $saldo."</td>
  
      <td>". $data['suplier_pelanggan']."</td>
</tr>";

}


}
 ?>
      
  </tbody>
 </table>