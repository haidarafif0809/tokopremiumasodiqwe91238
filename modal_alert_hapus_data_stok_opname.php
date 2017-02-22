<?php 


include 'db.php';

 $no_faktur = $_POST['no_faktur'];


 $hpp_masuk_stok_opname = $db->query("SELECT no_faktur, tanggal, jenis_transaksi FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur'");

 
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

<h4>Maaf No Transaksi <strong><?php echo $no_faktur; ?></strong> tidak dapat dihapus, karena barang yang diretur telah dikembalikan atau dijual kembali.</h4>

<table id="tableuser" class="table table-hover">
    <thead>

          <th class="th"> Nomor Faktur</th>
          <th class="th"> Tanggal </th>
          <th class="th"> Keterangan </th>
          </thead>
          
          
    <tbody>
          

          <?php
          

          //menyimpan data sementara yang ada pada $perintah
          while ($data2 = mysqli_fetch_array($hpp_masuk_stok_opname))
          {
          //menampilkan data
          echo "<tr>
          <td>". $data2['no_faktur'] ."</td>
          <td>". $data2['tanggal'] ."</td>
          <td>". $data2['jenis_transaksi'] ."</td>

          </tr>";


          }
        //Untuk Memutuskan Koneksi Ke Database
      
      mysqli_close($db); 
          ?>
    
    </tbody>
</table>





