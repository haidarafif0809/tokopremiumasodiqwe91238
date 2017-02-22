<?php 

 include 'db.php';
 include 'sanitasi.php';

$query = $db->query("SELECT * FROM pembayaran_piutang");
 
 

 // menampilkan seluruh data yang ada pada tabel penjualan secara berurutan dari yang terbesar ke yang trkecil berdsarkan id
 $query1 = $db->query("SELECT * FROM pembayaran_piutang ORDER BY id DESC LIMIT 1");

// menyimpan data sementara yang ada pada $query1
 $data = mysqli_fetch_array($query1);

 // mengambil dan menyimpan data id pada variabel ($nomor_terkhir)
 $nomor_terakhir = $data['id'];


 // mengambil dan menyimpan data nomor terakhir +1 pada variabel ($nomor_faktur)
 $nomor_faktur = $nomor_terakhir + 1;

 ?>

 <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Pembayaran </th>
      <th> Nomor Faktur Penjualan</th>
      <th> Tanggal </th>
      <th> Tanggal Jatuh Tempo </th>
      <th> Kredit </th>
      <th> Potongan </th>
      <th> Total</th>
      <th> Jumlah Bayar </th>
      <th> Hapus </th>
      <th> Edit </th>
      
    </thead>
    
    <tbody>
    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT * FROM tbs_pembayaran_piutang 
                WHERE no_faktur_pembayaran = 'PP/$nomor_faktur'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>
      

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-nomor-faktur-penjualan='". $data1['no_faktur_penjualan'] ."'> Hapus </button> </td> 

      <td> <a href='edit_tbs_pembayaran_piutang.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit </a> </td>
      </tr>";
      }

        //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </tbody>

  </table>

  <script type="text/javascript">
  	
    $(document).ready(function(){
    $('table').DataTable({"ordering":false});
    });

  </script>