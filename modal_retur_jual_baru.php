<?php 

include 'sanitasi.php';
include 'db.php';
?>

<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Kode Pelanggan </th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <!--
      <th> Jumlah Beli </th>
      -->
      <th> Satuan </th>
      <th> Harga Barang  </th>
      <th> Subtotal </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa Barang </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php


      $kode_pelanggan = $_POST['kode_pelanggan'];

    // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
    $perintah = $db->query("SELECT b.id AS id_produk , ss.nama AS satuan_asal ,dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, dp.sisa, p.kode_pelanggan, pl.nama_pelanggan, dp.asal_satuan, SUM(hk.sisa_barang) as sisa_barang ,s.nama FROM detail_penjualan dp LEFT JOIN hpp_keluar hk ON dp.no_faktur = hk.no_faktur AND dp.kode_barang = hk.kode_barang LEFT JOIN penjualan p ON dp.no_faktur = p.no_faktur LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan INNER JOIN satuan s ON dp.satuan = s.id
      INNER JOIN satuan ss ON dp.asal_satuan = ss.id  INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE hk.sisa_barang > '0' AND p.kode_pelanggan = '$kode_pelanggan' GROUP BY dp.no_faktur, dp.kode_barang   ");
     

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      { 
        //menampilkan konversi dari satuan_konversi
      $konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$data1[satuan]' AND kode_produk = '$data1[kode_barang]'");
      $data_konversi = mysqli_fetch_array($konversi);
      $num_rows = mysqli_num_rows($konversi);

      if ($num_rows > 0) {
        
     $sisa = $data1['sisa_barang'] % $data_konversi['konversi'];
     $harga = $data1['harga'] * $data_konversi['konversi'];

      }
      else{

        $sisa = $data1['sisa_barang'];
        $harga = $data1['harga'];
      }

if ($sisa == 0)
{

          $konversi_data = $data1['sisa_barang'] / $data_konversi['konversi'];

        // menampilkan data
      echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."' satuan='". $data1['satuan'] ."' no_faktur='". $data1['no_faktur'] ."' harga='". $harga ."' jumlah-barang='". $data1['jumlah_barang'] ."' sisa='". $konversi_data ."' id_produk='". $data1['id_produk'] ."' asal_satuan = ".$data1['asal_satuan']." harga_pcs = ".$data1['harga']." >";

}
else{

       // menampilkan data
      echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."' satuan='". $data1['asal_satuan'] ."' no_faktur='". $data1['no_faktur'] ."' harga='". $data1['harga'] ."' jumlah-barang='". $data1['jumlah_barang'] ."' sisa='". $data1['sisa_barang'] ."' id_produk='". $data1['id_produk'] ."' asal_satuan = ".$data1['asal_satuan']." harga_pcs = ".$data1['harga']." >";

}      
      echo "<td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_pelanggan'] ." </td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['nama'] ."</td>";
      if ($sisa == 0) {
        echo "<td>". rp($harga) ."</td>";
      }
      else{
        echo "<td>". rp($data1['harga']) ."</td>";

      }
      echo"<td>". rp($data1['subtotal']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['tax']) ."</td>";
      if ($sisa == 0) {
        $konversi_data = $data1['sisa_barang'] / $data_konversi['konversi'];
       echo"<td>". $konversi_data ." ". $data1['nama'] ."</td>";
      }
      else
      {
        echo"<td>". $data1['sisa_barang'] ." ". $data1['satuan_asal'] ."</td>";
      }

      echo"</tr>";
      
       }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </tbody> <!--tag penutup tbody-->

  </table> <!-- tag penutup table-->
  </div>
  <script type="text/javascript">
  $(function () {
  $("#tableuser").dataTable();
  });
</script>