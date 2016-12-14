<?php 
include 'db.php';
include 'sanitasi.php';

 $kode_barang = stringdoang($_POST['kode_barang']);
 $bulan = stringdoang($_POST['bulan']);
 $tahun = stringdoang($_POST['tahun']);

// stok penjualan
$select1 = $db->query("SELECT dj.kode_barang,dj.no_faktur,dj.tanggal,dj.jumlah_barang,j.kode_pelanggan FROM detail_penjualan dj INNER JOIN penjualan j ON j.no_faktur = j.no_faktur WHERE dj.kode_barang = '$kode_barang' GROUP BY dj.no_faktur ");
while ($data1 = mysqli_fetch_array($select1)){

  $select_kartu = $db->query("SELECT no_transaksi from kartu_stok WHERE no_transaksi = '$data1[no_faktur]'  AND kode_barang = '$data1[kode_barang]' ");
$cek_kartu = mysqli_num_rows($select_kartu);

if ($cek_kartu == 0 )
{
  $insert1 = $db->query("INSERT INTO kartu_stok (no_transaksi,kode_barang,tanggal,tipe,jumlah,suplier_pelanggan) VALUES 
  ('$data1[no_faktur]','$data1[kode_barang]','$data1[tanggal]','Penjualan','$data1[jumlah_barang]','$data1[kode_pelanggan]')");
}
else{


  $update1 = $db->query("UPDATE kartu_stok SET jumlah = '$data1[jumlah_barang]' WHERE no_transaksi = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]' ");
}  

}
//end stok penjualan

// FOR DELETE DI KARTUS STOK JIKA DI EDIT DI PENJUALAN (ANYTIME)
$select_no_1 = $db->query("SELECT no_transaksi,kode_barang from kartu_stok WHERE  kode_barang = '$kode_barang' AND tipe = 'Penjualan' ");
while($cek_no_1 = mysqli_fetch_array($select_no_1))
{

  $select_to_no_1 = $db->query("SELECT no_faktur FROM detail_penjualan WHERE no_faktur = '$cek_no_1[no_transaksi]' AND kode_barang = '$cek_no_1[kode_barang]'");
$cek_to_no_1 = mysqli_num_rows($select_to_no_1);
if ($cek_to_no_1 == 0)
{
  $delete_to_no_1 = $db->query("DELETE FROM kartu_stok WHERE kode_barang = '$cek_no_1[kode_barang]' AND no_transaksi = '$cek_no_1[no_transaksi]'");
}

}

// ENDING FOR DELETE DI KARTUS TSOK JIKA DI EDIT DI PENJUALAN (ANYTIME)




//stok pembelian
$select2 = $db->query("SELECT dp.no_faktur,dp.kode_barang,dp.jumlah_barang,dp.tanggal,p.suplier FROM detail_pembelian dp INNER JOIN pembelian p ON p.no_faktur = p.no_faktur  WHERE dp.kode_barang = '$kode_barang'  ");
while ($data2 = mysqli_fetch_array($select2)){

  $select_kartu2 = $db->query("SELECT no_transaksi from kartu_stok WHERE no_transaksi = '$data2[no_faktur]'  AND kode_barang = '$data2[kode_barang]' ");
$cek_kartu2 = mysqli_num_rows($select_kartu2);

if ($cek_kartu2 == 0 )
{

$insert2 = $db->query("INSERT INTO kartu_stok(no_transaksi,kode_barang,tanggal,tipe,jumlah,suplier_pelanggan) VALUES 
  ('$data2[no_faktur]','$data2[kode_barang]','$data2[tanggal]','Pembelian','$data2[jumlah_barang]','$data2[suplier]')");
}
else{


  $update2 = $db->query("UPDATE kartu_stok SET jumlah = '$data2[jumlah_barang]' WHERE no_transaksi = '$data2[no_faktur]' AND kode_barang = '$data2[kode_barang]' ");
}  

}

//end stok pembelian


// FOR DELETE DI KARTUS TSOK JIKA DI EDIT DI PEMBELIAN (ANYTIME)
$select_no_2 = $db->query("SELECT no_transaksi,kode_barang from kartu_stok WHERE  kode_barang = '$kode_barang' AND tipe = 'Pembelian' ");
while($cek_no_2 = mysqli_fetch_array($select_no_2))
{

  $select_to_no_2 = $db->query("SELECT no_faktur FROM detail_pembelian WHERE no_faktur = '$cek_no_2[no_transaksi]' AND kode_barang = '$cek_no_2[kode_barang]'");
$cek_to_no_2 = mysqli_num_rows($select_to_no_2);
if ($cek_to_no_2 == 0)
{
  $delete_to_no_2 = $db->query("DELETE FROM kartu_stok WHERE kode_barang = '$cek_no_2[kode_barang]' AND no_transaksi = '$cek_no_2[no_transaksi]'");
}

}

// ENDING FOR DELETE DI KARTUS TSOK JIKA DI EDIT DI PEMBELIAN (ANYTIME)




//stok item masuk
$select3 = $db->query("SELECT * FROM detail_item_masuk  WHERE kode_barang = '$kode_barang'  ");
while ($data3 = mysqli_fetch_array($select3)){

  $select_kartu3 = $db->query("SELECT no_transaksi from kartu_stok WHERE no_transaksi = '$data3[no_faktur]'  AND kode_barang = '$data3[kode_barang]' ");
$cek_kartu3 = mysqli_num_rows($select_kartu3);

if ($cek_kartu3 == 0 )
{

$insert3 = $db->query("INSERT INTO kartu_stok(no_transaksi,kode_barang,tanggal,tipe,jumlah) VALUES 
  ('$data3[no_faktur]','$data3[kode_barang]','$data3[tanggal]','Item Masuk','$data3[jumlah]')");
}
else{


  $update3 = $db->query("UPDATE kartu_stok SET jumlah = '$data3[jumlah]' WHERE no_transaksi = '$data3[no_faktur]' AND kode_barang = '$data3[kode_barang]' ");
}

}

//end stok item masuk

// FOR DELETE DI KARTUS TSOK JIKA DI EDIT DI DETAIL ITEM MASUK (ANYTIME)
$select_no_3 = $db->query("SELECT no_transaksi,kode_barang from kartu_stok WHERE  kode_barang = '$kode_barang' AND tipe = 'Item Masuk'");
while($cek_no_3 = mysqli_fetch_array($select_no_3))
{

  $select_to_no_3 = $db->query("SELECT no_faktur FROM detail_item_masuk WHERE no_faktur = '$cek_no_3[no_transaksi]' AND kode_barang = '$cek_no_3[kode_barang]'");
$cek_to_no_3 = mysqli_num_rows($select_to_no_3);
if ($cek_to_no_3 == 0)
{
  $delete_to_no_3 = $db->query("DELETE FROM kartu_stok WHERE kode_barang = '$cek_no_3[kode_barang]' AND no_transaksi = '$cek_no_3[no_transaksi]'");
}

}
// ENDING FOR DELETE DI KARTUS TSOK JIKA  DI DETAIL ITEM MASUK (ANYTIME)

//stok item Keluar
$select4 = $db->query("SELECT * FROM detail_item_keluar  WHERE kode_barang = '$kode_barang' ");
while ($data4 = mysqli_fetch_array($select4)){

  $select_kartu4 = $db->query("SELECT no_transaksi from kartu_stok WHERE no_transaksi = '$data4[no_faktur]'  AND kode_barang = '$data4[kode_barang]' ");
$cek_kartu4 = mysqli_num_rows($select_kartu4);

if ($cek_kartu4 == 0 )
{

$insert4 = $db->query("INSERT INTO kartu_stok(no_transaksi,kode_barang,tanggal,tipe,jumlah) VALUES 
  ('$data4[no_faktur]','$data4[kode_barang]','$data4[tanggal]','Item Keluar','$data4[jumlah]')");
}
else{


  $update4 = $db->query("UPDATE kartu_stok SET jumlah = '$data4[jumlah]' WHERE no_transaksi = '$data4[no_faktur]' AND kode_barang = '$data4[kode_barang]' ");
}


}

//end stok item keluar


// FOR DELETE DI KARTUS TSOK JIKA DI EDIT DI DETAIL ITEM KELUAR (ANYTIME)
$select_no_4 = $db->query("SELECT no_transaksi,kode_barang from kartu_stok WHERE  kode_barang = '$kode_barang' AND tipe = 'Item Keluar' ");
while($cek_no_4 = mysqli_fetch_array($select_no_4))
{

  $select_to_no_4 = $db->query("SELECT no_faktur FROM detail_item_keluar WHERE no_faktur = '$cek_no_4[no_transaksi]' AND kode_barang = '$cek_no_4[kode_barang]'");
$cek_to_no_4 = mysqli_num_rows($select_to_no_4);
if ($cek_to_no_4 == 0)
{
  $delete_to_no_4 = $db->query("DELETE FROM kartu_stok WHERE kode_barang = '$cek_no_4[kode_barang]' AND no_transaksi = '$cek_no_4[no_transaksi]'");
}

}
// ENDING FOR DELETE DI KARTUS TSOK JIKA  DI DETAIL ITEM KELUAR (ANYTIME)

//stok stok awal
$select5 = $db->query("SELECT * FROM stok_awal  WHERE kode_barang = '$kode_barang'  ");
while ($data5 = mysqli_fetch_array($select5)){

  $select_kartu5 = $db->query("SELECT kode_barang FROM kartu_stok WHERE kode_barang = '$data5[kode_barang]' AND tipe = 'Stok Awal'");
$cek_kartu5 = mysqli_num_rows($select_kartu5);

if ($cek_kartu5 == 0 )
{

$insert5 = $db->query("INSERT INTO kartu_stok(kode_barang,tanggal,tipe,jumlah) VALUES 
  ('$data5[kode_barang]','$data5[tanggal]','Stok Awal','$data5[jumlah_awal]')");
}
else
{
  $update5 = $db->query("UPDATE kartu_stok SET jumlah = '$data5[jumlah_awal]' WHERE kode_barang = '$data5[kode_barang]' AND tipe = 'Stok Awal' ");
}

}

//end stok stok awal


// FOR DELETE DI KARTUS TSOK JIKA DI EDIT DI DETAIL STOK AWAL (ANYTIME)
$select_no_5 = $db->query("SELECT no_transaksi,kode_barang from kartu_stok WHERE  kode_barang = '$kode_barang' AND tipe = 'Stok Awal' ");
while($cek_no_5 = mysqli_fetch_array($select_no_5))
{
$select_to_no_5 = $db->query("SELECT kode_barang FROM stok_awal WHERE kode_barang = '$cek_no_5[kode_barang]'");
$cek_to_no_5 = mysqli_num_rows($select_to_no_5);

if ($cek_to_no_5 == 0)
{
  $delete_to_no_5 = $db->query("DELETE FROM kartu_stok WHERE kode_barang = '$cek_no_5[kode_barang]'");
}

}
// ENDING FOR DELETE DI KARTUS TSOK JIKA  DI DETAIL STOK AWAL (ANYTIME)


//stok detail retur pembelian
$select6 = $db->query("SELECT drp.no_faktur_retur,drp.kode_barang,drp.tanggal,drp.jumlah_retur,rb.nama_suplier FROM detail_retur_pembelian drp INNER JOIN retur_pembelian rb ON rb.no_faktur_retur = rb.no_faktur_retur  WHERE drp.kode_barang = '$kode_barang' ");
while ($data6 = mysqli_fetch_array($select6)){

  $select_kartu6 = $db->query("SELECT no_transaksi from kartu_stok WHERE no_transaksi = '$data6[no_faktur_retur]'  AND kode_barang = '$data6[kode_barang]' ");
$cek_kartu6 = mysqli_num_rows($select_kartu6);

if ($cek_kartu6 == 0 )
{

$insert6 = $db->query("INSERT INTO kartu_stok(no_transaksi,kode_barang,tanggal,tipe,jumlah,suplier_pelanggan) VALUES 
  ('$data6[no_faktur_retur]','$data6[kode_barang]','$data6[tanggal]','Retur Pembelian','$data6[jumlah_retur]','$data6[nama_suplier]')");
}
else{


  $update6 = $db->query("UPDATE kartu_stok SET jumlah = '$data6[jumlah_retur]' WHERE no_transaksi = '$data6[no_faktur_retur]' AND kode_barang = '$data6[kode_barang]' ");
}

}

//end detail retur pembelian


// FOR DELETE DI KARTUS TSOK JIKA DI EDIT DI DETAIL RETURN PEMBELIAN (ANYTIME)
$select_no_6 = $db->query("SELECT no_transaksi,kode_barang from kartu_stok WHERE  kode_barang = '$kode_barang' AND tipe = 'Retur Pembelian' ");
while($cek_no_6 = mysqli_fetch_array($select_no_6))
{

  $select_to_no_6 = $db->query("SELECT no_faktur_retur FROM detail_retur_pembelian WHERE no_faktur_retur = '$cek_no_6[no_transaksi]' AND kode_barang = '$cek_no_6[kode_barang]'");
$cek_to_no_6 = mysqli_num_rows($select_to_no_6);
if ($cek_to_no_6 == 0)
{
  $delete_to_no_6 = $db->query("DELETE FROM kartu_stok WHERE kode_barang = '$cek_no_6[kode_barang]' AND no_transaksi = '$cek_no_6[no_transaksi]'");
}

}
// ENDING FOR DELETE DI KARTUS TSOK JIKA  DI DETAIL RETURN PEMBELIAN (ANYTIME)


//stok detail retur penjualan
$select7 = $db->query("SELECT drj.no_faktur_retur,drj.kode_barang,drj.tanggal,drj.jumlah_retur,rj.kode_pelanggan FROM detail_retur_penjualan drj INNER JOIN retur_penjualan rj ON rj.no_faktur_retur = rj.no_faktur_retur  WHERE drj.kode_barang = '$kode_barang' GROUP BY rj.no_faktur_retur  ");
while ($data7 = mysqli_fetch_array($select7)){

  $select_kartu7 = $db->query("SELECT no_transaksi FROM kartu_stok WHERE no_transaksi = '$data7[no_faktur_retur]'  AND kode_barang = '$data7[kode_barang]' ");
$cek_kartu7 = mysqli_num_rows($select_kartu7);

if ($cek_kartu7 == 0 )
{

$insert7 = $db->query("INSERT INTO kartu_stok(no_transaksi,kode_barang,tanggal,tipe,jumlah,suplier_pelanggan) VALUES 
  ('$data7[no_faktur_retur]','$data7[kode_barang]','$data7[tanggal]','Retur Penjualan','$data7[jumlah_retur]','$data7[kode_pelanggan]')");
}
else{


  $update7 = $db->query("UPDATE kartu_stok SET jumlah = '$data7[jumlah_retur]' WHERE no_transaksi = '$data7[no_faktur_retur]' AND kode_barang = '$data7[kode_barang]' ");
}

}

//end detail retur penjualan

// FOR DELETE DI KARTUS TSOK JIKA DI EDIT DI DETAIL RETURN PENJUALAN (ANYTIME)
$select_no_7 = $db->query("SELECT no_transaksi,kode_barang from kartu_stok WHERE  kode_barang = '$kode_barang' AND tipe = 'Retur Penjualan' ");
while($cek_no_7 = mysqli_fetch_array($select_no_7))
{

  $select_to_no_7 = $db->query("SELECT no_faktur_retur FROM detail_retur_penjualan WHERE no_faktur_retur = '$cek_no_7[no_transaksi]' AND kode_barang = '$cek_no_7[kode_barang]'");
$cek_to_no_7 = mysqli_num_rows($select_to_no_7);
if ($cek_to_no_7 == 0)
{
  $delete_to_no_7 = $db->query("DELETE FROM kartu_stok WHERE kode_barang = '$cek_no_7[kode_barang]' AND no_transaksi = '$cek_no_7[no_transaksi]'");
}

}
// ENDING FOR DELETE DI KARTUS TSOK JIKA  DI DETAIL RETURN PENJUALAN (ANYTIME)



 ?>

  <div class="table-responsive">
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
$query00 = $db->query("SELECT SUM(jumlah) AS jumlah_produk FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Pembelian' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun' ");
$cek0 = mysqli_fetch_array($query00);
$jumlah_produk0 = $cek0['jumlah_produk'];

$query10 = $db->query("SELECT SUM(jumlah) AS jumlah_retur FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Retur Penjualan' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$cek10 = mysqli_fetch_array($query10);
$jumlah_retur0 = $cek10['jumlah_retur'];


$query20 = $db->query("SELECT SUM(jumlah) AS jumlah_item FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Stok Awal' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$cek20 = mysqli_fetch_array($query20);
$jumlah_item0 = $cek20['jumlah_item'];

$query30 = $db->query("SELECT SUM(jumlah) AS jumlah_stok_awal FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Item Masuk' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$cek30 = mysqli_fetch_array($query30);
$jumlah_stok_awal0 = $cek30['jumlah_stok_awal'];


$tambah_jumlah0 = $jumlah_produk0 + $jumlah_retur0 + $jumlah_item0 + $jumlah_stok_awal0;

// untuk produk yang berkurang

$querdo0 = $db->query("SELECT SUM(jumlah) AS jumlah_produk_jual FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Penjualan' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$out0 = mysqli_fetch_array($querdo0);
$jumlah_jual0 = $out0['jumlah_produk_jual'];

$querdo10 = $db->query("SELECT SUM(jumlah) AS jumlah_produk_retur FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Retur Pembelian' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$out10 = mysqli_fetch_array($querdo10);
$jumlah_produk_retur_beli0 = $out10['jumlah_produk_retur'];

$querdo20 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM kartu_stok WHERE kode_barang = '$kode_barang' AND tipe = 'Item Keluar' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
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
<td><?php echo $saldo; ?></td>
<td></td>
</tr>
<?php 



$select_to = $db->query("SELECT * FROM kartu_stok WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal ASC");
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
   <td>". $data['suplier_pelanggan']."</td>
</tr>";
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

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>
      
  </tbody>
 </table>

</div> <!-- Penutup table Responsive -->

<!-- SCRIPT UNTUK DATA TABLE -->                        
<script type="text/javascript">
                        
      $(function () {
      $("#table-pelamar").dataTable({ordering :false});
   });

</script>
<!-- SCRIPT UNTUK DATA TABLE -->