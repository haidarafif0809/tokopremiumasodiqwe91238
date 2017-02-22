<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$nama_petugas = $_GET['nama_petugas'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];

    $query0 = $db->query("SELECT * FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query10 = $db->query("SELECT SUM(jumlah_fee) AS total_fee FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
    $cek0 = mysqli_fetch_array($query10);
    $total_fee = $cek0['total_fee'];
    
 ?>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 <h3> <b> BUKTI KOMISI PRODUK / PETUGAS </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-5">
                          <br><br><br><br><br>
<table>
  <tbody>
  
      <tr><td  width="40%">Nama Petugas</td> <td> :&nbsp;</td> <td> <?php echo $data0['nama_petugas']; ?></td></tr>
      <tr><td  width="40%">Tanggal</td> <td> :&nbsp;</td> <td> <?php echo tanggal($data0['tanggal']); ?> </td>
      </tr>
      <tr><td  width="40%">Periode</td> <td> :&nbsp;</td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> </td></tr>
      <tr><td  width="40%">User</td> <td> :&nbsp;</td> <td> <?php echo $_SESSION['user_name']; ?> </td></tr>
   
            
  </tbody>
</table>          
                 
        </div><!--penutup colsm4-->
      
    </div><!--penutup row1-->
</div> <!-- end of container-->


<br>
<div class="container">

<table id="tableuser" class="table table-bordered">
            <thead>
                  <th> Nama Petugas </th>
                  <th> Nomor Faktur </th>
                  <th> Kode Produk </th>
                  <th> Nama Produk </th>
                  <th> Jumlah Komisi </th>
                  <th> Tanggal </th>
                  <th> Jam </th>


                  <?php 

                  
                  ?>
                  
            </thead>
            
            <tbody>
            <?php
                $query10 = $db->query("SELECT * FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' ");
                while ($data10 = mysqli_fetch_array($query10))
                {
                  
                  echo "<tr>
                  <td>". $data10['nama_petugas'] ."</td>
                  <td>". $data10['no_faktur'] ."</td>
                  <td>". $data10['kode_produk'] ."</td>
                  <td>". $data10['nama_produk'] ."</td>
                  <td>". rp($data10['jumlah_fee']) ."</td>
                  <td>". tanggal($data10['tanggal']) ."</td>
                  <td>". $data10['jam'] ."</td>
                  </tr>";
                }

                        //Untuk Memutuskan Koneksi Ke Database
                        
                        mysqli_close($db); 
        

        
            ?>
            </tbody>

      </table>
      <br>
      <div class="row">
      <div class="col-sm-8">
        
 <table>
  <tbody>

      <tr><td><i> <b> Terbilang </b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo kekata($total_fee); ?> </i> </td></tr>

  </tbody>
  </table>


     </div>

     <div class="col-sm-4">
        
 <table>
  <tbody>

      <tr><td width="75%"><b>Jumlah Komisi Petugas</b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo $total_fee; ?> </td></tr>

  </tbody>
  </table>

     </div>
<br>
<hr>
</div>

 <div class="row">
     <div class="col-sm-1">
</div>
     <div class="col-sm-8"><b>&nbsp;&nbsp;&nbsp;Hormat Kami<br><br><br><br>( ...................... )</b></div>
     <div class="col-sm-3"><b>&nbsp;&nbsp;&nbsp;&nbsp;Penerima<br><br><br><br>( ................... )</b></div>

     


</div>
        

</div> <!--end container-->



 <script>
$(document).ready(function(){
  window.print();
});
</script>






<?php include 'footer.php'; ?>