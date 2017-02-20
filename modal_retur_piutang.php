<?php 
include 'db.php';

 $no_faktur = $_POST['no_faktur'];

 $retur = $db->query ("SELECT no_faktur, tanggal FROM hpp_masuk WHERE no_faktur_hpp_keluar = '$no_faktur'");

 $piutang = $db->query ("SELECT no_faktur_pembayaran, tanggal FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$no_faktur'");

 ?>

 <style>

tr:nth-child(even){background-color: #f2f2f2}


</style>

<h4>Maaf No Transaksi <strong><?php echo $no_faktur; ?></strong> tidak dapat dihapus, karena telah terdapat transaksi pembayaran piutang atau retur penjualan. Dengan daftar sebagai berikut :</h4>

<table id="table" class="table table-hover">
    <thead>

          <th style='background-color: #4CAF50; color:white'> Nomor Faktur</th>
          <th style='background-color: #4CAF50; color:white'> Tanggal </th>
          <th style='background-color: #4CAF50; color:white'> Keterangan </th>
          </thead>
          
          
    <tbody>
          
          <?php
          
          //menyimpan data sementara yang ada pada $perintah
          while ($data1 = mysqli_fetch_array($retur))
          {
          //menampilkan data
          echo "<tr>
          <td>". $data1['no_faktur'] ."</td>
          <td>". $data1['tanggal'] ."</td>
          <td> Retur Penjualan </td>

          </tr>";


          }
       
          ?>



    <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($piutang))
      {
        //menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td> Pembayaran Piutang </td>


      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    
    </tbody>
</table>


    <script>
    
    $(document).ready(function(){
    $('#table').DataTable();
    });
    </script>
