<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = $_GET['no_faktur'];

$perintah = $db->query("SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama,g.nama_gudang FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang ORDER BY p.id DESC");

$data001 = mysqli_fetch_array($perintah);

    $query0 = $db->query("SELECT * FROM pembelian WHERE no_faktur = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);


    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_pembelian WHERE no_faktur = '$no_faktur'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];

    $query04 = $db->query("SELECT SUM(kredit) as total_kredit FROM pembelian WHERE no_faktur = '$no_faktur'");
    $data04 = mysqli_fetch_array($query04);
    $total_kredit = $data04['total_kredit'];

    $query01 = $db->query("SELECT SUM(sisa) as total_kembalian FROM pembelian WHERE no_faktur = '$no_faktur'");
    $data01 = mysqli_fetch_array($query01);
    $total_kembalian = $data01['total_kembalian'];

    $query03 = $db->query("SELECT SUM(subtotal) as total_subtotal FROM detail_pembelian WHERE no_faktur = '$no_faktur'");
    $data03 = mysqli_fetch_array($query03);
    $total_subtotal = $data03['total_subtotal'];
    
 ?>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 <h3> <b> BUKTI PEMBELIAN HUTANG </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
                          <br><br><br><br><br>

 <table>
  <tbody>

      <tr><td width="50%">No Faktur</td> <td> :&nbsp;</td>  <td>  <?php echo $data0['no_faktur']; ?> </td></tr>
      <tr><td  width="50%">Tanggal</td> <td> :&nbsp;</td>  <td> <?php echo tanggal($data0['tanggal']);?> </td>
      </tr>
      <tr><td  width="50%">Suplier</td> <td> :&nbsp;</td>  <td> <?php echo $data001['nama']; ?> </td></tr>
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

           <th> Nomor Faktur </th>
           <th> Kode Barang </th>
           <th> Nama Barang </th>
           <th> Jumlah Barang </th>
           <th> Satuan </th>
           <th> Harga </th>
           <th> Subtotal </th>
           
            
        </thead>
        
        <tbody>
        <?php

            
            $query5 = $db->query("SELECT s.nama,dp.id,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id WHERE dp.no_faktur = '$no_faktur' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {
                //menampilkan data
            echo "<tr>
                <td>". $data5['no_faktur'] ."</td>
                <td>". $data5['kode_barang'] ."</td>
                <td>". $data5['nama_barang'] ."</td>
                <td>". $data5['jumlah_barang'] ."</td>
                <td>". $data5['nama'] ."</td>
                <td>". rp($data5['harga']) ."</td>
                <td>". rp($data5['subtotal']) ."</td>
            <tr>";

            }
                    
                    //Untuk Memutuskan Koneksi Ke Database
                    
                    mysqli_close($db); 
        
        
        ?>
        </tbody>

    </table>
      <br>

    <i> <b> Terbilang </b>: <?php echo kekata($data0['total']); ?> </i>
    
<hr>
 <div class="row">
     
     <div class="col-sm-3"><b>&nbsp;&nbsp;&nbsp;Hormat Kami<br><br><br><br>( ...................... )</b></div>
     <div class="col-sm-3"><b>&nbsp;&nbsp;&nbsp;&nbsp;Penerima<br><br><br><br>( ................... )</b></div>
     <div class="col-sm-3">
        
 <table>
  <tbody>

      <tr><td width="75%">Jumlah Item</td> <td> :&nbsp;</td> <td>   <?php echo $total_item; ?> </td></tr>
      <tr><td  width="75%">Potongan</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['potongan']); ?> </td>
      </tr>
      <tr><td  width="75%">Pajak</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['tax']); ?></td></tr>
</tbody>
  </table>


     </div>

     <div class="col-sm-3">

 <table>
  <tbody>
      <tr> <td width="75%">Total Pembelian</td> <td> :&nbsp;</td> <td> <?php echo rp($total_subtotal); ?> </tr>
      <tr> <td  width="75%">Total Akhir</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['total']); ?> </td> </tr>
      <tr> <td  width="75%">Tunai</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['tunai']); ?> </td> </tr>
      <tr> <td  width="75%">Kredit</td> <td> :&nbsp;</td> <td> <?php echo rp($total_kredit); ?> </td> </tr>
      <tr> <td  width="75%">Kembalian</td> <td> :&nbsp;</td> <td> <?php echo rp($total_kembalian); ?> </td> </tr>
            

  </tbody>
</table>

    </div>


</div>
        

</div> <!--end container-->







 <script>
$(document).ready(function(){
  window.print();
});
</script>


<?php include 'footer.php'; ?>