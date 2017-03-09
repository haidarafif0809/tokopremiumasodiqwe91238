<?php include 'session_login.php';
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tgl = stringdoang($_GET['dari_tanggal']);
$sampai_tgl = stringdoang($_GET['sampai_tanggal']);
$kelipatan = angkadoang($_GET['kelipatan']);
$satu = 1;


$query1 = $db->query("SELECT * FROM perusahaan ");
$next_cp = mysqli_fetch_array($query1);




 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $next_cp['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='130' height='130`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $next_cp['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $next_cp['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $next_cp['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->



    <center> <h4> <b> LAPORAN BUCKET SIZE </b> </h4> </center>
    <center> <h4> <b> PERIODE <?php echo $dari_tgl; ?>  Sampai <?php echo $sampai_tgl; ?>  </b> </h4> </center>
<br>


<style type="text/css">
  th,td{
    padding: 1px;
  }


.table1, .th, .td {
    border: 1px solid black;
    font-size: 15px;
    font: verdana;
}


</style>
<br><br>

<table id="tableuser" class="table table-hover">
    <thead>
      <th> Omset per Faktur </th>
      <th> Total Faktur  </th>
      <th> % </th>
      
    </thead>
    
    <tbody>
  <?php

  $sql = $db->query("SELECT MAX(total) AS total FROM penjualan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ");
  $data1 = mysqli_fetch_array($sql);

  $total1 = $kelipatan + $data1['total'];
        
  while($kelipatan <= $total1) {
      

    echo "<tr>

    <td>".rp($satu) ." - ". rp($kelipatan)."</td>";

    $query2 = $db->query("SELECT COUNT(*) AS total_faktur FROM penjualan WHERE total BETWEEN '$satu' AND '$kelipatan' ");
    $data2 = mysqli_fetch_array($query2);

    $query5 = $db->query("SELECT COUNT(*) AS total_faktur_semua FROM penjualan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl'");
    $data5 = mysqli_fetch_array($query5);

    //hitung persen 
    $hitung = $data2['total_faktur'] / $data5['total_faktur_semua'] * 100 /100;


    echo"<td>".rp($data2['total_faktur'])."</td>
    <td>".rp(round($hitung,2))."</td>";
       
    $kelipatan1 = angkadoang($_GET['kelipatan']);
    $kelipatan += $kelipatan1;
    $satu += $kelipatan1;

    echo "</tr>";
             
   }
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>


<br>

    <div class="row">
      <div class="col-sm-6">
              <font class="satu"><b>Petugas <br><br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font> 
      </div>
         <div class="col-sm-3">


    </div>
    





</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>


