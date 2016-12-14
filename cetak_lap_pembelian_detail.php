<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);




    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");


//menampilkan seluruh data yang ada pada tabel pembelian
$perintah0 = $db->query("SELECT * FROM detail_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data0 = mysqli_fetch_array($perintah0);



$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM detail_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];

$query20 = $db->query("SELECT SUM(tax) AS total_tax FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek20 = mysqli_fetch_array($query20);
$total_tax = $cek20['total_tax'];

$query30 = $db->query("SELECT SUM(kredit) AS total_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek30 = mysqli_fetch_array($query30);
$total_kredit = $cek30['total_kredit'];

$query15 = $db->query("SELECT SUM(subtotal) AS total_subtotal FROM 
detail_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek15 = mysqli_fetch_array($query15);
$t_subtotal = $cek15['total_subtotal'];

$query011 = $db->query("SELECT SUM(jumlah_barang) AS total_barang FROM
detail_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
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
                 <h3> <b> LAPORAN PEMBELIAN DETAIL </b></h3>
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
                  <th> Nama Suplier</th>
                  <th> Nama Pelanggan </th>
                  <th> </th>
                  <th> </th>

                                    
            </thead>
            
            <tbody>
            <?php

                  $perintah009 = $db->query("SELECT * FROM detail_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
                  while ($data11 = mysqli_fetch_array($perintah009))

                  {

               $pilih_konversi = $db->query("SELECT $data11[jumlah_barang] / sk.konversi AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data11[satuan]' AND sk.kode_produk = '$data11[kode_barang]'");
                $data_konversi = mysqli_fetch_array($pilih_konversi);

                if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
                  
                   $jumlah_barang = $data_konversi['jumlah_konversi'];
                }
                else{
                  $jumlah_barang = $data11['jumlah_barang'];
                }



                        ///menampilkan seluruh data yang ada pada tabel pembelian
                        $perintah123 = $db->query("SELECT * FROM pembelian WHERE no_faktur = '$data11[no_faktur]'");
                        $data123 = mysqli_fetch_array($perintah123);

                        $perintah1234 = $db->query("SELECT * FROM pelanggan");
                        $data1234 = mysqli_fetch_array($perintah1234);
                        
                        $perintah012 = $db->query("SELECT s.nama AS nama_satuan,dp.id,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.sisa FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id WHERE dp.no_faktur = '$data11[no_faktur]'");
                        $data012 = mysqli_fetch_array($perintah012);

                        $query0 = $db->query("SELECT SUM(jumlah_barang) AS total_barang FROM detail_pembelian WHERE no_faktur = '$data11[no_faktur]'");
                        $cek0 = mysqli_fetch_array($query0);
                        $total_barang = $cek0['total_barang'];
                        
                        
                        $query10 = $db->query("SELECT SUM(subtotal) AS total_subtotal FROM detail_pembelian WHERE no_faktur = '$data11[no_faktur]'");
                        $cek10 = mysqli_fetch_array($query10);
                        $total_subtotal = $cek10['total_subtotal'];

                        $perintah = $db->query("SELECT p.kode_barang,p.nama_barang,p.jumlah_barang,p.satuan,p.harga,p.id,p.no_faktur,p.subtotal,p.tanggal,p.status,p.potongan,p.tax,p.sisa,s.nama,pe.suplier FROM detail_pembelian p INNER JOIN pembelian pe ON p.no_faktur = pe.no_faktur INNER JOIN suplier s ON pe.suplier = s.id WHERE p.no_faktur = '$data11[no_faktur]' ORDER BY p.id DESC");
                        
                        $sup = mysqli_fetch_array($perintah);

                        echo "<tr>
                        <td>". $data11['no_faktur'] ."<br><br><u><i>Kode Barang</i></u><br>". $data012['kode_barang'] ."<br><br><br><b><br> <b>Potongan :</b>  </td>
                        
                        <td>". $data11['tanggal'] ." <br><br><u><i>Nama Barang</i></u><br>". $data012['nama_barang'] ."<br><br><br><b><br>". rp($data012['potongan']) ."</td>
                        
                        <td>". $sup['nama'] ." <br><br><br><br><br><b><br><br>Pajak :</td>                        <td>". $data1234['nama_pelanggan'] ." <br><br><i><u>Jumlah</u>&nbsp;&nbsp;<u>Satuan</u></i><br>". $jumlah_barang ." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ". $data012['nama_satuan'] ."<br>.........................<br> ". $total_barang ."<b><br><b><br>". rp($data012['tax']) ."</td>
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
      <tr><td  width="70%">Total Kredit</td> <td> :&nbsp; </td> <td> <?php echo rp($total_kredit); ?></td></tr>
            
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