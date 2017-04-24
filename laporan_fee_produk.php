<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM laporan_fee_produk");

 ?>

<div class="container">
<h3><b> LAPORAN KOMISI PRODUK </b></h3><hr>

<a href="lap_jumlah_fee_petugas.php" class="btn btn-primary"> <i class="fa fa-list"> </i> KOMISI / PETUGAS</a><br><br>


<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
            <thead>
                  <th style="background-color: #4CAF50; color: white;"> Nama Petugas </th>
                  <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                  <th style="background-color: #4CAF50; color: white;"> Kode Produk </th>
                  <th style="background-color: #4CAF50; color: white;"> Nama Produk </th>
                  <th style="background-color: #4CAF50; color: white;"> Jumlah Komisi </th>
                  <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
                  <th style="background-color: #4CAF50; color: white;"> Jam </th>


                  <?php 

                  
                  ?>
                  
            </thead>
            
            <tbody>
            <?php

                  //menyimpan data sementara yang ada pada $perintah
                  while ($data1 = mysqli_fetch_array($perintah))

                  {
                  
                  echo "<tr>
                  <td>". $data1['nama_petugas'] ."</td>
                  <td>". $data1['no_faktur'] ."</td>
                  <td>". $data1['kode_produk'] ."</td>
                  <td>". $data1['nama_produk'] ."</td>
                  <td>". rp($data1['jumlah_fee']) ."</td>
                  <td>". tanggal($data1['tanggal']) ."</td>
                  <td>". $data1['jam'] ."</td>
                  </tr>";
                  }

                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db);   
            ?>
            </tbody>

      </table>

</div>
</div>

            <script>
            
            $(document).ready(function(){
            $('#tableuser').DataTable();
            });
            </script>






<?php 
include 'footer.php';
 ?>