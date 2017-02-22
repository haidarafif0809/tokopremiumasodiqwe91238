<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM retur_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");



$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM detail_retur_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];

$query20 = $db->query("SELECT SUM(tax) AS total_tax FROM retur_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek20 = mysqli_fetch_array($query20);
$total_tax = $cek20['total_tax'];


$query15 = $db->query("SELECT SUM(subtotal) AS total_subtotal FROM 
detail_retur_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek15 = mysqli_fetch_array($query15);
$t_subtotal = $cek15['total_subtotal'];

$query011 = $db->query("SELECT SUM(jumlah_retur) AS total_barang FROM
detail_retur_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek011 = mysqli_fetch_array($query011);
$t_barang = $cek011['total_barang'];






 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN RETUR PENJUALAN REKAP </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
         <br><br>                 
<table>
  <tbody>

      <tr><td  width="20%">PERIODE</td> <td> &nbsp;:&nbsp; </td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?></td>
      </tr>
            
  </tbody>
</table>           
                 
        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->
    <br>
    <br>
    <br>


 <table id="tableuser" class="table table-hover">
            <thead>
                  <th> Nomor Faktur </th>                  
                  <th> Tanggal </th>
                  <th> Kode / Nama Pelanggan </th>
                  <th> </th>
                  <th> </th>

                                    
            </thead>
            
            <tbody>
            <?php

                  $perintah009 = $db->query("SELECT * FROM detail_retur_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
                  while ($data11 = mysqli_fetch_array($perintah009))

                  {
                        ///menampilkan seluruh data yang ada pada tabel penjualan
                        $perintah123 = $db->query("SELECT pel.nama_pelanggan, rp.kode_pelanggan FROM retur_penjualan rp INNER JOIN pelanggan pel ON rp.kode_pelanggan = pel.kode_pelanggan WHERE rp.no_faktur_retur = '$data11[no_faktur_retur]'");
                        $data123 = mysqli_fetch_array($perintah123);
                        
                        $perintah012 = $db->query("SELECT s.nama AS nama_satuan,drp.tax,drp.no_faktur_retur,drp.tanggal,drp.kode_barang,drp.nama_barang,drp.jumlah_retur,drp.satuan,drp.harga,drp.potongan,drp.subtotal FROM detail_retur_penjualan drp INNER JOIN satuan s ON drp.satuan = s.id WHERE drp.no_faktur_retur = '$data11[no_faktur_retur]'");
                        $data012 = mysqli_fetch_array($perintah012);

                        $query0 = $db->query("SELECT SUM(jumlah_retur) AS total_barang FROM detail_retur_penjualan WHERE no_faktur_retur = '$data11[no_faktur_retur]'");
                        $cek0 = mysqli_fetch_array($query0);
                        $total_barang = $cek0['total_barang'];
                        
                        
                        $query10 = $db->query("SELECT SUM(subtotal) AS total_subtotal FROM detail_retur_penjualan WHERE no_faktur_retur = '$data11[no_faktur_retur]'");
                        $cek10 = mysqli_fetch_array($query10);
                        $total_subtotal = $cek10['total_subtotal'];

                        

                        echo "<tr>
                        <td>". $data11['no_faktur_retur'] ."<br><br><u><i>Kode Barang</i></u><br>". $data012['kode_barang'] ."<br><br><br><b><br> <b>Potongan :</b>  </td>
                        
                        <td>". $data11['tanggal'] ." <br><br><u><i>Nama Barang</i></u><br>". $data012['nama_barang'] ."<br><br><br><b><br>". rp($data012['potongan']) ."</td>
                        
                        <td>". $data123['kode_pelanggan'] ." ". $data123['nama_pelanggan'] ."<br><br><i><u>Jumlah</u>&nbsp;&nbsp;<u>Satuan</u></i><br>". $data012['jumlah_retur'] ." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ". $data012['nama_satuan'] ."<br>.........................<br>". $total_barang ."<br><br><b>Pajak : ". rp($data012['tax']) ." </b></td>
                        <td><br><br><i><u>Harga</u>&nbsp;&nbsp;<u>Pot.</u><br>". rp($data012['harga']) ."&nbsp;&nbsp;&nbsp;". rp($data012['potongan']) ."<b><br><b><br><b><br><b><br>Total Akhir :</td>
                        <td><br><br><i><u>Total</u><br>". rp($data012['subtotal']) ." <br>.........................<br> ". rp($total_subtotal) ."<b><br><b><br>". rp($total_subtotal) ."</td>

                  </tr>";


                  }

                          //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
        
            ?>
            </tbody>

      </table>
      <hr>
</div>
</div>
<br>

<div class="col-sm-7">
</div>


<div class="col-sm-2">
<h4><b>Total Keseluruhan :</b></h4>
</div>


<div class="col-sm-3">
        
 <table>
  <tbody>

      <tr><td width="70%">Jumlah Item</td> <td> :&nbsp; </td> <td> <?php echo $t_barang; ?> </td></tr>
      <tr><td  width="70%">Total Subtotal</td> <td> :&nbsp; </td> <td> <?php echo rp($t_subtotal); ?> </td>
      </tr>
      <tr><td  width="70%">Total Potongan</td> <td> :&nbsp; </td> <td> <?php echo rp($total_potongan); ?></td></tr>
      <tr><td width="70%">Total Pajak</td> <td> :&nbsp; </td> <td> <?php echo rp($total_tax); ?> </td></tr>
      <tr><td  width="70%">Total Akhir</td> <td> :&nbsp; </td> <td> <?php echo rp($t_subtotal); ?> </td>
      </tr>
            
  </tbody>
  </table>
  <br>


     </div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>