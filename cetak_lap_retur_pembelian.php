<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';


$no_faktur_retur = $_SESSION['no_faktur_retur'];

$perintah = $db->query("SELECT p.id,p.no_faktur_retur,p.nama_suplier,s.nama FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id ORDER BY p.id DESC ");

$data001 = mysqli_fetch_array($perintah);


    $query_retur = $db->query("SELECT no_faktur_retur, tanggal, total, potongan, tax, potongan_hutang, tunai, sisa FROM retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' ");
    $data_retur = mysqli_fetch_array($query_retur);

    $query_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
    $data_perusahaan = mysqli_fetch_array($query_perusahaan);

    $query2 = $db->query("SELECT SUM(subtotal) as j_subtotal FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' ");
    $data2 = mysqli_fetch_array($query2);
    $j_subtotal = $data2['j_subtotal'];

    $query21 = $db->query("SELECT SUM(jumlah_retur) as j_retur FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' ");
    $data21 = mysqli_fetch_array($query21);
    $j_retur = $data21['j_retur'];



 ?>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> BUKTI RETUR PEMBELIAN </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
                          <br><br><br><br><br>

<table>
  <tbody>
    <tr><td>Petugas</td> <td>:&nbsp;</td><td><?php echo $_SESSION['nama']; ?></td></tr>
    <tr><td>No Faktur</td> <td>:&nbsp;</td><td><?php echo $data_retur['no_faktur_retur']; ?></td></tr>
    <tr><td>Tanggal</td> <td>:&nbsp;</td><td><?php echo tanggal($data_retur['tanggal']);?></td></tr>
    <tr><td>Supplier</td> <td>:&nbsp;</td><td><?php echo $data001['nama']; ?></td></tr>
  </tbody>
</table>         
                 
        </div><!--penutup colsm4-->



        
    </div><!--penutup row1-->
</div> <!-- end of container-->


<br>
<div class="container">

<table id="tableuser" class="table table-bordered table-sm">
        <thead>

           <th> Kode Barang </th>
           <th> Nama Barang </th>
           <th> Jumlah Retur </th>
           <th> Satuan </th>
           <th> Harga </th>
           <th> Potongan </th>
           <th> Tax </th>
           <th> Subtotal </th>
           
            
        </thead>
        
        <tbody>
        <?php

            $query5 = $db->query("SELECT dp.kode_barang, dp.nama_barang, dp.jumlah_retur, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, s.nama AS nama_satuan FROM detail_retur_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id WHERE dp.no_faktur_retur = '$no_faktur_retur' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {

              
            echo "<tr>
                <td>". $data5['kode_barang'] ."</td>
                <td>". $data5['nama_barang'] ."</td>
                <td align='right'>". $data5['jumlah_retur'] ."</td>
                <td>". $data5['nama_satuan'] ."</td>
                <td align='right'>". rp($data5['harga']) ."</td>
                <td align='right'>". rp($data5['potongan']) ."</td>
                <td align='right'>". rp($data5['tax']) ."</td>
                <td align='right'>". rp($data5['subtotal']) ."</td>
            <tr>";

            }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
            
        ?>
        </tbody>

    </table>

<div class="row">


    <div class="col-sm-6"> <i> <b> Terbilang : </b> <?php echo kekata($data_retur['total']); ?>  </i> </div>
    <div class="col-sm-3"> 
<table>
  <tbody>
    <tr><td>Jumlah Retur</td> <td>:&nbsp;</td><td><?php echo $j_retur; ?></td></tr>
    <tr><td>Potongan</td> <td>:&nbsp;</td><td><?php echo rp($data_retur['potongan']); ?></td></tr>
    <tr><td>Tax</td> <td>:&nbsp;</td><td><?php echo rp($data_retur['tax']); ?></td></tr>
  </tbody>
</table>    

    </div>

    <div class="col-sm-3"> 

<table>
  <tbody>
    <tr><td>Subtotal</td> <td>:&nbsp;</td><td><?php echo rp($j_subtotal); ?></td></tr>
    
    <?php if ($data_retur['potongan_hutang'] != "" OR $data_retur['potongan_hutang'] != 0): ?>
      <tr><td>Potong Hutang</td> <td>:&nbsp;</td><td><?php echo rp($data_retur['potongan_hutang']); ?></td></tr>
    <?php endif ?>   

    <tr><td>Total Akhir</td> <td>:&nbsp;</td><td><?php echo rp($data_retur['total']); ?></td></tr>
    <tr><td>Tunai</td> <td>:&nbsp;</td><td><?php echo rp($data_retur['tunai']); ?></td></tr>
    <tr><td>Kembalian</td> <td>:&nbsp;</td><td><?php echo rp($data_retur['sisa']); ?></td></tr>

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