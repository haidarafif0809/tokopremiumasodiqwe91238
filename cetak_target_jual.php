<?php include 'session_login.php';
include 'header.php';
include 'sanitasi.php';
include 'db.php';

$no_trx = stringdoang($_GET['no_trx']);
$keterangan = stringdoang($_GET['keterangan']);
$daritgl = stringdoang($_GET['daritgl']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$order = angkadoang($_GET['order']);

$x = 0;

$query1 = $db->query("SELECT * FROM perusahaan ");
$next_cp = mysqli_fetch_array($query1);

$sql = $db->query("SELECT dp.id,dp.jumlah_periode,dp.jual_perhari,dp.target_perhari,dp.proyeksi,dp.stok_terakhir,dp.kebutuhan,dp.kode_barang, 
  dp.nama_barang, dp.satuan, s.nama FROM detail_target_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id WHERE dp.no_trx = '$no_trx' 
  GROUP BY dp.kode_barang ORDER BY dp.jumlah_periode DESC");



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



    <center> <h4> <b> ESTIMASI ORDER BERDASARKAN TARGET PENJUALAN </b> </h4> </center>
    <center> <h4> <b> Periode Data <?php echo$daritgl; ?> Sampai <?php echo $sampai_tanggal; ?></b> </h4> </center>
<br>




 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">No Transaksi</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $no_trx; ?></font> </tr>
      <tr><td  width="25%"><font class="satu">Order Untuk</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $order; ?> Hari</font></td></tr>
      <tr><td  width="25%"><font class="satu">Keterangan</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $keterangan; ?> </font></td></tr>

          
  </tbody>
</table>



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

<table id="tableuser" class="table table-bordered">
    <thead>
      <th> No. </th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Satuan </th>
      <th> Penjualan Periode </th>
      <th> Penjualan Per Hari </th>
      <th> Target Per Hari </th>
      <th> Proyeksi Penjualan Periode </th>
      <th> Stok Sekarang</th>
      <th> Kebutuhan </th>
      
    </thead>
    
    <tbody>
   <?php
    while ($data1 = mysqli_fetch_array($sql)) {

       $x = $x + 1;

    echo "<tr>

    <td>".$x."</td>   
    <td>".$data1["kode_barang"]."</td>
    <td>".$data1["nama_barang"]."</td>
    <td>".$data1["nama"]."</td>
    <td>".rp($data1['jumlah_periode'])."</td>
    <td>".rp($data1['jual_perhari'])."</td>
    <td>".rp($data1['target_perhari'])."</td>
    <td>".rp($data1['proyeksi'])."</td>

    <td>".rp($data1['stok_terakhir'])."</td>
    <td>".rp($data1['kebutuhan'])."</td>";
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


