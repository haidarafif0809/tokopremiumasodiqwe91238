<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';


$no_faktur = $_SESSION['no_faktur'];

    $query0 = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");
    $data2 = mysqli_fetch_array($query2);

    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];

    $query04 = $db->query("SELECT SUM(kredit) as total_kredit FROM penjualan WHERE no_faktur = '$no_faktur'");
    $data04 = mysqli_fetch_array($query04);
    $total_kredit = $data04['total_kredit'];

    
 ?>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-">
        </div>
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='130' height='110`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h2> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h2> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->
</div> <!-- end of container-->
<div class="container">
<hr>

    <center> <h2> <b> Faktur Piutang </b> </h2> </center>

<hr>
  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="50%">No Faktur</td> <td> :&nbsp;</td> <td><?php echo $data0['no_faktur']; ?> </tr>
      <tr><td  width="50%">Kode Pelanggan</td> <td> :&nbsp;</td> <td> <?php echo $data0['kode_pelanggan']; ?> </td></tr>
      <tr><td  width="50%">Jatuh Tempo</td> <td> :&nbsp;</td> <td> <?php echo tanggal($data0['tanggal_jt']);?>  </td></tr>

            

  </tbody>
</table>


    </div>

    <div class="col-sm-3">
 <table>
  <tbody>

       <tr><td width="50%"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data0['tanggal']);?> </td></tr> 
       <tr><td width="50%"> Petugas Kasir</td> <td> :&nbsp;&nbsp;</td> <td><?php echo $_SESSION['nama']; ?></td></tr> 

      </tbody>
</table>

    </div> <!--end col-sm-2-->
   </div> <!--end row-->  
</div> <!--end container-->

<br>
<div class="container">

<table id="tableuser" class="table table-bordered">
        <thead>
            <th> Nomor Faktur </th>
            <th> Kode Pelanggan</th>
            <th> Total </th>
            <th> Tanggal </th>
            <th> Jam </th>
            <th> User </th>
            <th> Status </th>
            <th> Potongan </th>
            <th> Tax </th>
            <th> Kembalian </th>
            <th> Kredit </th>
           
            
        </thead>
        
        <tbody>
        <?php

            $query5 = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$no_faktur' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {
                //menampilkan data
            echo "<tr>
            <td>". $data5['no_faktur'] ."</td>
            <td>". $data5['kode_pelanggan'] ."</td>
            <td>". rp($data5['total']) ."</td>
            <td>". $data5['tanggal'] ."</td>
            <td>". $data5['jam'] ."</td>
            <td>". $data5['user'] ."</td>
            <td>". $data5['status'] ."</td>
            <td>". rp($data5['potongan']) ."</td>
            <td>". rp($data5['tax']) ."</td>
            <td>". rp($data5['sisa']) ."</td>
            <td>". rp($data5['kredit']) ."</td>
            <tr>";

            }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

        ?>
        </tbody>

    </table>

        <div class="col-sm-8">
        
            <i><b>Terbilang :</b> <?php echo kekata($total_kredit); ?> </i> 
        
        </div>

        <div class="col-sm-4">

 <table>
  <tbody>
      <tr><td width="50%">Total Diskon</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['potongan']); ?> </tr>
      <tr><td  width="50%">Total Pajak</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['tax']); ?> </td></tr>
      <tr><td  width="50%">Total Penjualan</td> <td> :&nbsp;</td> <td> <?php echo rp($data2['subtotal']); ?>  </td></tr>
      <tr><td  width="50%">Sudah Dibayar</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['tunai']); ?> </td></tr>
      <tr><td  width="50%">Sisa Piutang</td> <td> :&nbsp;</td> <td> <?php echo rp($total_kredit); ?> </td></tr>
            

  </tbody>
</table>

        </div>

</div> <!--end container-->


<div class="container">

    <div class="col-sm-8">
    
    <b>Pelanggan <br><br><br><br> <?php echo $data0['kode_pelanggan']; ?></b>
    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-4">
    
    <b>Petugas <br><br><br><br> <?php echo $_SESSION['nama']; ?></b>

    </div> <!--/ col-sm-6-->




</div> <!--/container-->


<div class="container">
<hr>
   <i style="text-align:right;"> Terima Kasih 
    Selamat Datang Kembali
    Telp. <?php echo $data1['no_telp']; ?> 
  </i>
</div>



 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>