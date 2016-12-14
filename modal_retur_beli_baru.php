<?php 

include 'sanitasi.php';
include 'db.php';
?>
<div class="table-responsive">

<table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah Beli </th>
      <th> Satuan </th>
      <th> Harga Barang  </th>
      <th> Subtotal </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa Barang </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php

    $suplier = $_POST['suplier'];

    // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
    $perintah = $db->query("SELECT b.id AS id_produk,b.satuan AS satuan_dasar, s.nama AS satuan_beli ,ss.nama AS satuan_asli, dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, p.suplier, hm.harga_unit, IFNULL(SUM(hpm.sisa),0) + IFNULL(hm.sisa,0) AS sisa, dp.satuan, dp.asal_satuan  FROM detail_pembelian dp LEFT JOIN pembelian p ON dp.no_faktur = p.no_faktur LEFT JOIN hpp_masuk hm ON dp.no_faktur = hm.no_faktur AND dp.kode_barang = hm.kode_barang LEFT JOIN hpp_masuk hpm ON dp.no_faktur = hpm.no_faktur_hpp_masuk AND dp.kode_barang = hpm.kode_barang INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE (hpm.sisa > 0 OR hm.sisa > 0) AND p.suplier = '$suplier' GROUP BY dp.no_faktur, dp.kode_barang");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

      //menampilkan konversi dari satuan_konversi
      $konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$data1[satuan]' AND kode_produk = '$data1[kode_barang]'");
      $data_konversi = mysqli_fetch_array($konversi);
      $num_rows = mysqli_num_rows($konversi);

     if ($num_rows > 0) {
        
     $sisa = $data1['sisa'] % $data_konversi['konversi'];
     $jumlah_barang = $data1['jumlah_barang'] / $data_konversi['konversi'];
     echo $harga = $data1['harga'] * $data_konversi['konversi'];

      }
      else{

        $sisa = $data1['sisa'];
        $harga = $data1['harga'];
        $jumlah_barang = $data1['jumlah_barang'];
        
      }

if ($sisa == 0)
{

      $konversi_data = $data1['sisa'] / $data_konversi['konversi'];

        // menampilkan data
      echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."' satuan='". $data1['satuan'] ."' no_faktur='". $data1['no_faktur'] ."' harga='". $harga ."' jumlah-barang='". $data1['jumlah_barang'] ."' sisa='". $konversi_data ."' harga_pcs = ".$data1['harga']." id_produk='". $data1['id_produk'] ."' asal_satuan = '".$data1['asal_satuan']."'  satuan_pcs = '".$data1['satuan_dasar']."' satuan_beli = '".$data1['satuan']."'>";

}

else{

        // menampilkan data
      echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."' satuan='". $data1['asal_satuan'] ."' no_faktur='". $data1['no_faktur'] ."' harga='". $data1['harga'] ."' jumlah-barang='". $data1['jumlah_barang'] ."' sisa='". $data1['sisa'] ."' id_produk='". $data1['id_produk'] ."' asal_satuan = '".$data1['asal_satuan']."' harga_pcs = '".$data1['harga']."'  satuan_pcs = '".$data1['satuan_dasar']."' satuan_beli = '".$data1['satuan']."'>";


}
      
      
      echo "<td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $jumlah_barang ."</td>
      <td>". $data1['satuan_beli'] ."</td>";

      if ($sisa == 0) {
        echo "<td>". rp($harga) ."</td>";
      }
      else{
        echo "<td>". rp($data1['harga']) ."</td>";

      }

      echo "<td>". rp($data1['subtotal']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['tax']) ."</td>";
       if ($sisa == 0) {
        $konversi_data = $data1['sisa'] / $data_konversi['konversi'];
       echo"<td>". $konversi_data ." ". $data1['satuan_beli'] ."</td>";
      }
      else
      {
        echo"<td>". $data1['sisa'] ." ". $data1['satuan_asli'] ."</td>";
      }

echo "</tr>";

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