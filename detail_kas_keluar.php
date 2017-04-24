<?php 

include 'sanitasi.php';
include 'db.php';


 $no_faktur = $_POST['no_faktur'];
    //menampilkan semua data yang ada pada tabel tbs kas keluar dalam DB

    $perintah = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM detail_kas_keluar km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun WHERE no_faktur = '$no_faktur'");

 ?>


<div class="container">

<div class="table-responsive">     
 <table id="tableuser" class="table table-bordered">
    <thead>
      <th> No. Faktur </th>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Jumlah </th>
      <th> Tanggal </th>
      <th> Jam </th>
      <th> Keterangan </th>
      <th> User </th>
      
    </thead>
    
    <tbody>
    <?php


      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {

        $perintah1 = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM detail_kas_keluar km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun WHERE km.dari_akun = '$data1[dari_akun]'");
        $data10 = mysqli_fetch_array($perintah1);

        //menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data10['nama_daftar_akun'] ."</td>
      <td>". $data1['nama_daftar_akun'] ."</td>
      <td>". rp($data1['jumlah']) ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['keterangan'] ."</td>
      <td>". $data1['user'] ."</td>
      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

    ?>
    </tbody>

  </table>
</div>

</div><!--end of container-->
