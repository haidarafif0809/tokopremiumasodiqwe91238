<?php 


include 'db.php';

 $no_faktur = $_POST['no_faktur'];

 $hpp_masuk_penjualan = $db->query("SELECT no_faktur, tanggal, kode_barang, jenis_transaksi FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur' ");

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

<h4>Maaf No Transaksi <strong><?php echo $no_faktur; ?></strong> tidak dapat dihapus, karena telah terdapat Transaksi Penjualan atau Item Keluar. Dengan daftar sebagai berikut :</h4>

<table id="tableuser" class="table table-hover">
    <thead>

          <th class="th"> Nomor Faktur</th>
          <th class="th"> Tanggal </th>
          <th class="th"> Keterangan </th>
          </thead>
          
          
    <tbody>
          
          <?php
          
          //menyimpan data sementara yang ada pada $perintah
          while ($data1 = mysqli_fetch_array($hpp_masuk_penjualan))
          {
          //menampilkan data
          echo "<tr>
          <td>". $data1['no_faktur'] ."</td>
          <td>". $data1['tanggal'] ."</td>
          <td> Transaksi ". $data1['jenis_transaksi'] ." </td>

          </tr>";


          }

      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);        
          ?>



    </tbody>
</table>





