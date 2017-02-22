<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


$no_faktur = $_SESSION['no_faktur'];

    $query0 = $db->query("SELECT p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.kode_gudang,p.tunai,p.cara_bayar,pl.nama_pelanggan,pl.wilayah,dp.jumlah_barang,dp.subtotal,dp.nama_barang,dp.harga,b.satuan FROM penjualan p INNER JOIN detail_penjualan dp ON p.no_faktur = dp.no_faktur INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan INNER JOIN barang b ON dp.kode_barang = b.kode_barang ORDER BY p.id DESC");
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

    $query05 = $db->query("SELECT SUM(subtotal) as t_subtotal FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data05 = mysqli_fetch_array($query05);
    $t_subtotal = $data05['t_subtotal'];

    $setting_bahasa = $db->query("SELECT * FROM setting_bahasa WHERE kata_asal = 'Sales' ");
    $data20 = mysqli_fetch_array($setting_bahasa);

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

    <center> <h3> <b> Faktur Penjualan </b> </h3> </center>

<hr>
  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="50%">No Faktur</td> <td> :&nbsp;</td> <td><?php echo $data0['no_faktur']; ?> </tr>
      <tr><td  width="50%">Pelanggan</td> <td> :&nbsp;</td> <td> <?php echo $data0['nama_pelanggan']; ?> </td></tr>
      <tr><td  width="50%">Alamat</td> <td> :&nbsp;</td> <td> <?php echo $data0['wilayah']; ?> </td></tr>
      <tr><td  width="50%"><?php echo $data20['kata_ubah']; ?></td> <td> :&nbsp;</td> <td> <?php echo $data0['sales']; ?> </td></tr>
            

  </tbody>
</table>


    </div>

    <div class="col-sm-3">
 <table>
  <tbody>

       <tr><td width="50%"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data0['tanggal']);?> </td></tr> 
       <tr><td width="50%"> Petugas Kasir</td> <td> :&nbsp;&nbsp;</td> <td><?php echo $_SESSION['nama']; ?></td></tr> 
       <tr><td width="50%"> Status </td> <td> :&nbsp;&nbsp;</td> <td><?php echo $data0['status']; ?></td></tr> 

      </tbody>
</table>

    </div> <!--end col-sm-2-->
   </div> <!--end row-->  
</div> <!--end container-->

<br>
<div class="container">

<table id="tableuser" class="table table-bordered">
        <thead>
            <th> No. </th>
            <th> Kode Barang</th>
            <th> Nama Barang </th>
            <th> Qty </th>
            <th> Satuan </th>
            <th> Harga </th>
            <th> Potongan </th>
            <th> Subtotal </th>
           
            
        </thead>
        
        <tbody>
        <?php

        $no_urut = 0;


            $query5 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {
              $no_urut ++;
                //menampilkan data
            echo "<tr>
            <td>".$no_urut."</td>
            <td>". $data5['kode_barang'] ."</td>
            <td>". $data5['nama_barang'] ."</td>
            <td>". rp($data5['jumlah_barang']) ."</td>
            <td>". $data0['satuan'] ."</td>
            <td>". rp($data5['harga']) ."</td>
            <td>". rp($data5['potongan']) ."</td>
            <td>". rp($data5['subtotal']) ."</td>
            <tr>";

            }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

        ?>
        </tbody>

    </table>

        <div class="col-sm-8">
        
            <i><b>Terbilang :</b> <?php echo kekata($data0['total']); ?> </i> 
        
        </div>

        <div class="col-sm-4">

 <table>
  <tbody>

      <tr><td width="50%">Sub Total</td> <td> :&nbsp;</td> <td> <?php echo rp($t_subtotal); ?> </tr>
      <tr><td width="50%">Diskon</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['potongan']); ?> </tr>
      <tr><td  width="50%">Tax</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['tax']); ?> </td></tr>
      <tr><td  width="50%">Total Akhir</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['total']); ?>  </td></tr>
      <tr><td  width="50%">Bayar</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['tunai']); ?> </td></tr>
      <tr><td  width="50%">Kembali</td> <td> :&nbsp;</td> <td> <?php echo rp($data0['sisa']); ?> </td></tr>
      <tr><td  width="50%">Jenis Bayar</td> <td> :&nbsp;</td> <td> <?php echo $data0['cara_bayar']; ?> </td></tr> 

  </tbody>
</table>

        </div>

</div> <!--end container-->


<div class="container">

    <div class="col-sm-6">
    
    <b>Pelanggan <br><br><br> <?php echo $data0['nama_pelanggan']; ?> </b>
    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-6">
    
    <b>Petugas <br><br><br> <?php echo $_SESSION['nama']; ?></b>

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