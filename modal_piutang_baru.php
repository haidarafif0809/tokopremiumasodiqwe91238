<?php 

include 'sanitasi.php';
include 'db.php';



?>

<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Kode Pelanggan</th>
      <th> Total </th>
      <th> Tanggal </th>
      <th> Tanggal Jatuh Tempo </th>
      <th> Jam </th>
      <th> User </th>
      <th> Status </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa </th>
      <th> Kredit </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php

    $kode_pelanggan = $_POST['kode_pelanggan'];
    
    $perintah = $db->query("SELECT * FROM penjualan WHERE kode_pelanggan = '$kode_pelanggan' AND kredit != 0");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {
          $query00 = $db->query("SELECT no_faktur_penjualan FROM tbs_pembayaran_piutang WHERE no_faktur_penjualan = '$data1[no_faktur]'");
          $data00 = mysqli_num_rows($query00);
        if ($data00 > 0) {

          
        }

        else{
                  // menampilkan datakredit
       echo "<tr class='pilih' no-faktur='". $data1['no_faktur'] ."' kredit='". $data1['kredit'] ."' total='". $data1['total'] ."' tanggal_jt='". $data1['tanggal_jt'] ."' >
      
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_pelanggan'] ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['user'] ."</td>
      <td>". $data1['status'] ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['tax']) ."</td>
      <td>". rp($data1['sisa']) ."</td>
      <td>". rp($data1['kredit']) ."</td>
      </tr>";
        }

      
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