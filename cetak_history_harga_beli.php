<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


$daritgl = stringdoang($_GET['daritgl']);
$sampaitgl = stringdoang($_GET['sampaitgl']);
$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);


    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);
    


 ?>

<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
   .rata-kanan{
    text-align: right;
   }
</style>


<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='80' height='80`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $data1['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->



    <center> <h4> <b> HISTORY HARGA BELI </b> </h4> </center>
    <center> <h4> <b> PERIODE <?php echo tanggal($daritgl); ?> Sampai <?php echo tanggal($sampaitgl); ?></b> </h4> </center><hr>



  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">Nama Barang</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $nama_barang; ?></font> </tr>
      <tr><td  width="25%"><font class="satu">Kode Barang</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $kode_barang; ?> </font></td></tr>

            

  </tbody>
</table>


    </div>


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
<table id="tableuser" class="table table-bordered table-sm">
        <thead>
      
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Suplier </th>
      <th style='background-color: #4CAF50; color:white'> No Faktur</th>
      <th style='background-color: #4CAF50; color:white'> Harga Beli</th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Barang </th>
   
        </thead>
        <tbody>
     

<?php 

$select = $db->query(" SELECT dp.tanggal,ss.nama AS nama_suplier,dp.no_faktur,dp.harga,dp.jumlah_barang FROM pembelian pb LEFT JOIN detail_pembelian dp ON pb.no_faktur = dp.no_faktur LEFT JOIN suplier ss ON pb.suplier = ss.id WHERE dp.kode_barang = '$kode_barang' AND dp.tanggal >= '$daritgl' AND dp.tanggal <= '$sampaitgl' ORDER BY CONCAT(dp.tanggal,' ',dp.jam)");


while($data = mysqli_fetch_array($select))
  {
        echo "<tr><td> ".$data['tanggal']."</td>";
        echo "<td> ".$data['nama_suplier']."</td>";
        echo "<td> ".$data['no_faktur']."</td>";
        echo "<td style='text-align:right'>".rp($data['harga'])."</td>";
        echo "<td style='text-align:right'>".rp($data['jumlah_barang'])."</td>
        </tr>";

} // and while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>

    </table>


<br>
  
    <div class="col-sm-9">
    
    <!--<font class="satu"><b>Nama <?php echo $data200['kata_ubah']; ?> <br><br><br> <font class="satu"><?php echo $data_inner['nama_pelanggan']; ?></font> </b></font>-->
    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-3">
    
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>

    </div> <!--/ col-sm-6-->




</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>