<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';


$no_faktur_retur = $_SESSION['no_faktur_retur'];


    $query0 = $db->query("SELECT p.nama_pelanggan,rp.id,rp.kode_pelanggan,rp.no_faktur_retur,rp.kode_pelanggan,rp.total,rp.potongan,rp.tax,rp.tanggal,rp.jam,rp.user_buat,rp.user_edit,rp.tanggal_edit,rp.tunai,rp.sisa FROM retur_penjualan rp INNER JOIN pelanggan p ON rp.kode_pelanggan = p.kode_pelanggan WHERE rp.no_faktur_retur = '$no_faktur_retur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT SUM(subtotal) as j_subtotal FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur' ");
    $data2 = mysqli_fetch_array($query2);
    $j_subtotal = $data2['j_subtotal'];

    $query21 = $db->query("SELECT SUM(jumlah_retur) as j_retur FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur' ");
    $data21 = mysqli_fetch_array($query21);
    $j_retur = $data21['j_retur'];



 ?>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 <h3> <b> BUKTI RETUR PENJUALAN </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
                          <br><br><br><br><br>
<table>
  <tbody>
    <tr><td>No Faktur</td> <td>:&nbsp;</td><td><?php echo $data0['no_faktur_retur']; ?></td></tr>
    <tr><td>Tanggal</td> <td>:&nbsp;</td><td><?php echo tanggal($data0['tanggal']);?></td></tr>
    <tr><td>Kode Pelanggan</td> <td>:&nbsp;</td><td><?php echo $data0['nama_pelanggan']; ?></td></tr>

  </tbody>
</table>      
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-2">
                <br><br><br><br><br>
                User: <?php echo $_SESSION['user_name']; ?>  <br>

        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->
</div> <!-- end of container-->


<br>
<div class="container">

<table id="tableuser" class="table table-bordered">
        <thead>

           <th> Kode Barang </th>
           <th> Nama Barang </th>
           <th> Jumlah Retur </th>
           <th> Satuan </th>
           <th> Harga </th>
           <th> Potongan </th>
           <th> Total </th>
           <th> Subtotal </th>
           <th> Tax </th>
           
            
        </thead>
        
        <tbody>
        <?php

            $query5 = $db->query("SELECT drp.kode_barang ,drp.nama_barang ,drp.jumlah_retur ,s.nama ,drp.harga ,drp.potongan ,drp.subtotal ,drp.tax FROM detail_retur_penjualan drp INNER JOIN satuan s ON drp.satuan = s.id  WHERE drp.no_faktur_retur = '$no_faktur_retur' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {

              
            echo "<tr>
                <td>". $data5['kode_barang'] ."</td>
                <td>". $data5['nama_barang'] ."</td>
                <td>". $data5['jumlah_retur'] ."</td>
                <td>". $data5['nama'] ."</td>
                <td>". rp($data5['harga']) ."</td>
                <td>". rp($data5['potongan']) ."</td>
                <td>". rp($data0['total']) ."</td>
                <td>". rp($data5['subtotal']) ."</td>
                <td>". rp($data5['tax']) ."</td>
            <tr>";

            }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
            
        ?>
        </tbody>

    </table>

<div class="row">


    <div class="col-sm-6"> <i> <b> Terbilang : </b> <?php echo kekata($data0['total']); ?>  </i> </div>
    <div class="col-sm-3"> 

<table>
  <tbody>
    <tr><td>Jumlah Retur</td> <td>:&nbsp;</td><td><?php echo $j_retur; ?></td></tr>
    <tr><td>Potongan</td> <td>:&nbsp;</td><td><?php echo rp($data0['potongan']); ?></td></tr>
    <tr><td>Pajak</td> <td>:&nbsp;</td><td><?php echo rp($data0['tax']); ?></td></tr>

  </tbody>
</table>
      

    </div>

    <div class="col-sm-3"> 
<table>
  <tbody>
    <tr><td>Subtotal</td> <td>:&nbsp;</td><td><?php echo rp($j_subtotal); ?></td></tr>
    <tr><td>Total Akhir</td> <td>:&nbsp;</td><td><?php echo rp($data0['total']); ?></td></tr>
    <tr><td>Tunai</td> <td>:&nbsp;</td><td><?php echo rp($data0['tunai']); ?></td></tr>
    <tr><td>Kembalian</td> <td>:&nbsp;</td><td><?php echo rp($data0['sisa']); ?></td></tr>

  </tbody>
</table>

    </div>

</div>


 <div class="row">
      <div class="col-sm-9"><hr><b>&nbsp;Hormat Kami<br><br><br><br>( ...................... )</b></div>
     <div class="col-sm-3"><hr><b>&nbsp;&nbsp;Penerima<br><br><br><br>( ................... )</b></div>


</div>
        

</div> <!--end container-->






 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>