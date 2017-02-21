<?php 

include 'header.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];


 $piutang = $db->query ("SELECT no_faktur_penjualan, tanggal FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$no_faktur'");

 $retur = $db->query ("SELECT no_faktur_penjualan, tanggal FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$no_faktur'");

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



<table id="tableuser" class="table table-hover">
    <thead>

          <th class="th"> Nomor Faktur</th>
          <th class="th"> Tanggal </th>
          <th class="th"> Keterangan </th>
          </thead>
          
          
    <tbody>

    <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($piutang))
      {
        //menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td> Pembayaran Piutang </td>


      </tr>";
      }


    ?>

        <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data2 = mysqli_fetch_array($retur))
      {
        //menampilkan data
      echo "<tr>
      <td>". $data2['no_faktur_penjualan'] ."</td>
      <td>". $data2['tanggal'] ."</td>
      <td> Retur Penjualan </td>


      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    
    </tbody>
</table>


