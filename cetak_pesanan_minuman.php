<?php session_start();


include 'sanitasi.php';
include 'db.php';
include 'header.php';



 $no_faktur = $_SESSION['no_faktur'];

    $query0 = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");


    
 ?>



  ===================<br>
  No Meja : <?php echo $data0['kode_meja']; ?> || No Faktur : <?php echo $data0['no_faktur']; ?> || Kasir : <?php echo $_SESSION['nama']; ?><br>
  ===================<br>


 <table>

  <tbody>

  <?php 

  while ($data2 = mysqli_fetch_array($query2))

   {
    $query4 = $db->query("SELECT * FROM barang WHERE kode_barang = '$data2[kode_barang]'");
    $cek4 = mysqli_fetch_array($query4);
     $kategori = $cek4['kategori'];

    if ($kategori == 'Minuman') {
      
      echo '<tr><td width:"50%"> '. $data2['nama_barang'] .' </td> <td style="padding:3px"> '. $data2['jumlah_barang'] .'</td> <td style="padding:3px"> '. $data2['komentar'] .'</td></tr>';

 }
   
  } 
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
  ?>
     </tbody>
</table>


    ===================<br>
    Tanggal : <?php echo tanggal($data0['tanggal']);?><br>
    ===================<br><br>


 <script>
$(document).ready(function(){
  window.print();
});
</script>

 </body>
 </html>

