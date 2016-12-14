<?php 

include 'sanitasi.php';
include 'db.php';


$nama_petugas = stringdoang($_POST['nama_petugas']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

$perintah1 = $db->query("SELECT * FROM laporan_fee_faktur WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

$query01 = $db->query("SELECT SUM(jumlah_fee) AS total_fee FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total_fee1 = $cek01['total_fee'];

$query0 = $db->query("SELECT SUM(jumlah_fee) AS total_fee FROM laporan_fee_faktur WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek0 = mysqli_fetch_array($query0);
$total_fee2 = $cek0['total_fee'];

$total_komisi = $total_fee1 + $total_fee2;

 ?>

 <style>
      
      tr:nth-child(even){background-color: #f2f2f2}
      
</style>

<div class="card card-block">

<h3><center><b>Komisi Produk / Petugas</b></center></h3><br>
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
                  
                  echo "<tr class='pilih' data-petugas='". $data1['nama_petugas'] ."'>
                  <td>". $data1['nama_petugas'] ."</td>
                  <td>". $data1['no_faktur'] ."</td>
                  <td>". $data1['kode_produk'] ."</td>
                  <td>". $data1['nama_produk'] ."</td>
                  <td>". rp($data1['jumlah_fee']) ."</td>
                  <td>". tanggal($data1['tanggal']) ."</td>
                  <td>". $data1['jam'] ."</td>
                  </tr>";
                  }
            ?>
            </tbody>

      </table>
</div>
</div>
      <h4> Total Komisi / Produk Dari <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> : <b><?php echo rp($total_fee1); ?></b></h4>
<br><br>

<div class="card card-block">
<h3><center><b>Komisi Faktur / Petugas</b></center></h3><br>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
                  <th style="background-color: #4CAF50; color: white;"> Nama Petugas </th>
                  <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                  <th style="background-color: #4CAF50; color: white;"> Jumlah Komisi </th>
                  <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
                  <th style="background-color: #4CAF50; color: white;"> Jam </th>
                  
            </thead>
            
            <tbody>
            <?php

                  //menyimpan data sementara yang ada pada $perintah
                  while ($data0 = mysqli_fetch_array($perintah1))

                  {
                  
                  echo "<tr class='pilih' data-petugas='". $data1['nama_petugas'] ."'>
                  <td>". $data0['nama_petugas'] ."</td>
                  <td>". $data0['no_faktur'] ."</td>
                  <td>". rp($data0['jumlah_fee']) ."</td>
                  <td>". tanggal($data0['tanggal']) ."</td>
                  <td>". $data0['jam'] ."</td>
                  </tr>";
                  }
                  
                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db);   
            ?>
            </tbody>

      </table>
</div>

<a href='cetak_laporan_komisi.php?nama_petugas=<?php echo $nama_petugas; ?>&dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success'><i class='fa fa-print'> </i> Cetak Komisi / Petugas</a>

</div>
      <h4> Total Komisi / Faktur Dari <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> : <b><?php echo rp($total_fee2); ?></b></h4><br>

      <h3 style="color: red"><b> Total Komisi Dari <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> : <?php echo rp($total_komisi); ?> </b></h3>

            


<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>