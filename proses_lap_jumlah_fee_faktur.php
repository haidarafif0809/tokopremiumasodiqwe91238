<?php 

include 'sanitasi.php';
include 'db.php';


$nama_petugas = stringdoang($_POST['nama_petugas']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM laporan_fee_faktur WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

$query0 = $db->query("SELECT SUM(jumlah_fee) AS total_fee FROM laporan_fee_faktur WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek0 = mysqli_fetch_array($query0);
$total_fee = $cek0['total_fee'];

 ?>

 <style>
      
      tr:nth-child(even){background-color: #f2f2f2}
      
</style>

<div class="card card-block">

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
                  <th> Nama Petugas </th>
                  <th> Nomor Faktur </th>
                  <th> Jumlah Komisi </th>
                  <th> Tanggal </th>
                  <th> Jam </th>
                  
            </thead>
            
            <tbody>
            <?php

                  //menyimpan data sementara yang ada pada $perintah
                  while ($data1 = mysqli_fetch_array($perintah))

                  {
                  
                  echo "<tr class='pilih' data-petugas='". $data1['nama_petugas'] ."'>
                  <td>". $data1['nama_petugas'] ."</td>
                  <td>". $data1['no_faktur'] ."</td>
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


      <a href='cetak_lap_fee_faktur.php?nama_petugas=<?php echo $nama_petugas; ?>&dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success'><i class='fa fa-print'> </i> Cetak Komisi / Faktur </a>


</div>
      <h3 style="color: red"> Total Komisi / Faktur Dari <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> : <b><?php echo rp($total_fee); ?></b></h3>


<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>