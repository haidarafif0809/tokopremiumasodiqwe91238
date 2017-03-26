<?php include 'session_login.php';
include 'header.php';
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_GET['no_faktur']);
$tanggal = stringdoang($_GET['tanggal']);

$query1 = $db->query("SELECT * FROM perusahaan ");
$next_cp = mysqli_fetch_array($query1);

$ambil_poin = $db->query("SELECT tp.sisa_poin, tp.total_poin , p.nama_pelanggan, p.kode_pelanggan FROM tukar_poin tp LEFT JOIN pelanggan p ON tp.pelanggan = p.id WHERE tp.no_faktur = '$no_faktur' ");
$data200 = mysqli_fetch_array($ambil_poin);


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



    <center> <h4> <b> FAKTUR PENUKARAN POIN </b> </h4> </center>
<br>

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">No. Faktur</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $no_faktur; ?></font> </tr>
      <tr><td  width="25%"><font class="satu">Pelanggan</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data200['nama_pelanggan']; ?> </font></td></tr>
            <tr><td  width="25%"><font class="satu">Kode Pelanggan</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data200['kode_pelanggan']; ?> </font></td></tr>
      <tr><td  width="25%"><font class="satu">Tanggal</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo tanggal($tanggal); ?> </font></td></tr>

          
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
            <th> No. Faktur </th>
            <th> Kode Produk </th>
            <th> Nama Produk</th>
            <th> Satuan </th>
            <th> Jumlah </th>
            <th> Poin </th>
            <th> Subtotal Poin </th>
    </thead>
    
    <tbody>
   <?php


   $ambil = $db->query("SELECT dt.no_faktur, dt.kode_barang, dt.nama_barang, dt.jumlah_barang, dt.poin, dt.subtotal_poin, s.nama  FROM detail_tukar_poin dt LEFT JOIN satuan s ON dt.satuan = s.id WHERE dt.no_faktur = '$no_faktur' ");

    while ($data1 = mysqli_fetch_array($ambil)) {

    echo "<tr>
    <td>".$no_faktur."</td>   
    <td>".$data1["kode_barang"]."</td>
    <td>".$data1["nama_barang"]."</td>
    <td>".$data1["nama"]."</td>
    <td>".rp($data1['jumlah_barang'])."</td>
    <td>".rp($data1['poin'])."</td>
    <td>".rp($data1['subtotal_poin'])."</td>";
    echo "</tr>";
             
   }
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>


<br>

    <div class="row">
       <div class="col-sm-9">
            
            <i><b><font class="satu">Terbilang :</font></b> <?php echo kekata($data200['total_poin']); ?> </i> <br>
            <!DOCTYPE html>

<style>
div.dotted {border-style: dotted;}
div.dashed {border-style: dashed;}
div.solid {border-style: solid;}
div.double {border-style: double;}
div.groove {border-style: groove;}
div.ridge {border-style: ridge;}
div.inset {border-style: inset;}
div.outset {border-style: outset;}
div.none {border-style: none;}
div.hidden {border-style: hidden;}
div.mix {border-style: dotted dashed solid double;}
</style>



</div>
 <div class="col-sm-3">

 <table>
  <tbody>

      <tr><td width="50%"><font class="satu">Total Poin</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data200['total_poin']); ?> </font></tr>
      <tr><td width="50%"><font class="satu">Sisa Poin</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data200['sisa_poin']); ?></font> </tr>

  </tbody>
</table>
  <br>
</div>




    <div class="col-sm-9">
    
    <font class="satu"><b>Pelanggan<br><br><br> <font class="satu"><?php echo $data200['nama_pelanggan']; ?></font> </b></font>
    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-3">
    
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>

    </div> <!--/ col-sm-6-->


    </div>
    





</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>


