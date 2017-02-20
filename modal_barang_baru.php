<?php 

include 'sanitasi.php';
include 'db.php';
?>

<div class="table-responsive">
 <!-- membuat agar ada garis pada tabel, disetiap kolom-->
        <table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Status </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php

    // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
    $perintah = $db->query("SELECT * FROM barang");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."' 
      satuan='". $data1['satuan'] ."' harga_beli='". $data1['harga_beli'] ."' >
      
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". rp($data1['harga_beli']) ."</td>
      <td>". rp($data1['harga_jual']) ."</td>
            <td>". rp($data1['harga_jual2']) ."</td>
            <td>". rp($data1['harga_jual3']) ."</td>";


     // mencari jumlah Barang
            $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$data1[kode_barang]'");
            $ambil_sisa = mysqli_fetch_array($select);
            
            $stok_barang = $ambil_sisa['jumlah_barang'];


      echo "<td>". $stok_barang ."</td>
      <td>". $data1['satuan'] ."</td>
      <td>". $data1['status'] ."</td>
      </tr>";
      
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
