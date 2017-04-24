<?php 


include 'db.php';

 $no_faktur = $_POST['no_faktur'];

 $retur = $db->query("SELECT drp.no_faktur_pembelian, rp.tanggal,drp.no_faktur_retur FROM detail_retur_pembelian drp INNER JOIN retur_pembelian rp ON drp.no_faktur_retur = rp.no_faktur_retur WHERE drp.no_faktur_pembelian = '$no_faktur'");

 $hutang = $db->query("SELECT no_faktur_pembayaran, tanggal FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$no_faktur'");

 $hpp_masuk_penjualan = $db->query("SELECT no_faktur, tanggal FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur'");
 ?>



    <style>
table {
    border-collapse: collapse;
    width: 100%;
}

.th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

.th {
    background-color: #4CAF50;
    color: white;
}
</style>

<h4>Maaf No Transaksi <strong><?php echo $no_faktur; ?></strong> tidak dapat dihapus, karena telah terdapat transaksi Pembayaran Hutang atau Retur Pembelian atau Transaksi Penjualan. Dengan daftar sebagai berikut :</h4>

<table id="tableuser" class="table table-hover">
    <thead>

          <th class="th"> Nomor Faktur</th>
          <th class="th"> Tanggal </th>
          <th class="th"> Keterangan </th>
          </thead>
          
          
    <tbody>
          
          <?php
          
          //menyimpan data sementara yang ada pada $perintah
          while ($data1 = mysqli_fetch_array($retur))
          {
          //menampilkan data
          echo "<tr>
          <td>". $data1['no_faktur_retur'] ."</td>
          <td>". $data1['tanggal'] ."</td>
          <td> Retur Pembelian </td>

          </tr>";


          }
       
          ?>

          <?php
          

          //menyimpan data sementara yang ada pada $perintah
          while ($data2 = mysqli_fetch_array($hpp_masuk_penjualan))
          {
          //menampilkan data
          echo "<tr>
          <td>". $data2['no_faktur'] ."</td>
          <td>". $data2['tanggal'] ."</td>
          <td>Transaksi Penjualan </td>

          </tr>";


          }
       
          ?>


    <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data3 = mysqli_fetch_array($hutang))
      {
        //menampilkan data
      echo "<tr>
      <td>". $data3['no_faktur_pembayaran'] ."</td>
      <td>". $data3['tanggal'] ."</td>
      <td> Pembayaran Hutang </td>


      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    
    </tbody>
</table>
