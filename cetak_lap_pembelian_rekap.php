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



$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];

$query20 = $db->query("SELECT SUM(tax) AS total_tax FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek20 = mysqli_fetch_array($query20);
$total_tax = $cek20['total_tax'];

$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];


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
                 <h3> <b> LAPORAN PEMBELIAN REKAP </b></h3>
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


 <table id="tableuser" class="table table-bordered">
            <thead>
                  <th> Nomor Faktur </th>                  
                  <th> Tanggal </th>
                  <th> Nama Suplier</th>
                  <th> Jumlah Barang </th>
                  <th> Subtotal </th>
                  <th> Potongan </th>
                  <th> Pajak </th>
                  <th> Total Akhir </th>
                  <th> Bayar Tunai </th>
                  <th> Bayar Kredit </th>
                                    
            </thead>
            
            <tbody>
            <?php

                  $perintah009 = $db->query("SELECT s.nama AS nama_suplier,p.no_faktur,p.tanggal,p.suplier,p.potongan,p.tax,p.total,p.kredit FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
                  while ($data11 = mysqli_fetch_array($perintah009))

                  {
                        //menampilkan data
                        $query0 = $db->query("SELECT SUM(jumlah_barang) AS total_barang FROM detail_pembelian WHERE no_faktur = '$data11[no_faktur]'");
                        $cek0 = mysqli_fetch_array($query0);
                        $total_barang = $cek0['total_barang'];
                        
                        
                        $query10 = $db->query("SELECT SUM(subtotal) AS total_subtotal FROM detail_pembelian WHERE no_faktur = '$data11[no_faktur]'");
                        $cek10 = mysqli_fetch_array($query10);
                        $total_subtotal = $cek10['total_subtotal'];

                        $bayar_tunai = $data11['total'] - $data11['kredit']; 
                  echo "<tr>
                  <td>". $data11['no_faktur'] ."</td>
                  <td>". $data11['tanggal'] ."</td>
                  <td>". $data11['nama_suplier'] ."</td>
                  <td>". $total_barang ."</td>
                  <td>". rp($total_subtotal) ."</td>
                  <td>". rp($data11['potongan']) ."</td>
                  <td>". rp($data11['tax']) ."</td>
                  <td>". rp($data11['total']) ."</td>
                  <td>". rp($bayar_tunai) ."</td>
                  <td>". rp($data11['kredit']) ."</td>
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
      <tr><td  width="70%">Total Akhir</td> <td> :&nbsp; </td> <td> <?php echo rp($total_akhir); ?> </td>
      </tr>
      <tr><td  width="70%">Total Kredit</td> <td> :&nbsp; </td> <td> <?php echo rp($total_kredit); ?></td></tr>
            
  </tbody>
  </table>


     </div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>