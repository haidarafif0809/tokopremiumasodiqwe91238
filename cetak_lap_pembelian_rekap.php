<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query1 = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
$data1 = mysqli_fetch_array($query1);

$total_potongan = 0;
$total_tax = 0;
$total_beli = 0;
$total_sisa = 0;
$total_kredit = 0;


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



 <table id="tableuser" class="table table-bordered table-sm">
    <thead>

          <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
          <th style="background-color: #4CAF50; color: white;"> Nama Suplier </th>
          <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
          <th style="background-color: #4CAF50; color: white;"> Jam </th>
          <th style="background-color: #4CAF50; color: white;"> User </th>
          <th style="background-color: #4CAF50; color: white;"> Status </th>
          <th style="background-color: #4CAF50; color: white;"> Potongan </th>
          <th style="background-color: #4CAF50; color: white;"> Tax </th>
          <th style="background-color: #4CAF50; color: white;"> Total </th>
          <th style="background-color: #4CAF50; color: white;"> Kembalian </th>
          <th style="background-color: #4CAF50; color: white;"> Kredit </th>      

    </thead>
    <tbody>
            <?php


        $perintah_tampil = $db->query("SELECT p.no_faktur, p.tanggal, p.jam, p.user, p.status, p.potongan, p.tax, p.total, p.tunai, p.sisa, p.kredit, s.nama FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
      
                  while ($data11 = mysqli_fetch_array($perintah_tampil))

                  {

                      $total_kotor_jual = $data11['total'] + $data11['potongan'];
              
                      echo "<tr>
                      <td>". $data11['no_faktur'] ."</td>
                      <td>". $data11['nama'] ."</td>
                      <td>". $data11['tanggal'] ."</td>
                      <td>". $data11['jam'] ."</td>
                      <td>". $data11['user'] ."</td>
                      <td>". $data11['status'] ."</td>
                      <td align='right'>". rp($data11['potongan']) ."</td>
                      <td align='right'>". rp($data11['tax']) ."</td>
                      <td align='right'>". rp($data11['total']) ."</td>
                      <td align='right'>". rp($data11['sisa']) ."</td>
                      <td align='right'>". rp($data11['kredit']) ."</td>
                      </tr>";


                       $total_potongan = $total_potongan + $data11['potongan'];
                       $total_tax = $total_tax + $data11['tax'];
                       $total_beli = $total_beli + $data11['total'];
                       $total_sisa = $total_sisa + $data11['sisa'];
                       $total_kredit = $total_kredit + $data11['kredit'];


                  }

                      echo "<tr>
                      <td style='color:red'>TOTAL</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style='color:red' align='right'>". rp($total_potongan) ."</td>
                      <td style='color:red' align='right'>". rp($total_tax) ."</td>
                      <td style='color:red' align='right'>". rp($total_beli) ."</td>
                      <td style='color:red' align='right'>". rp($total_sisa) ."</td>
                      <td style='color:red' align='right'>". rp($total_kredit) ."</td>
                      </tr>";

                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db); 
        
        
            ?>
            </tbody>

      </table>
</div>
</div>



 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>