<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query1 = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
$data1 = mysqli_fetch_array($query1);

$total_akhir_kotor = 0;
$total_potongan = 0;
$total_tax = 0;
$total_jual = 0;
$total_tunai = 0;
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
                 <h3> <b> LAPORAN PENJUALAN REKAP </b></h3>
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


 <table id="tableuser" class="table table-bordered table-sm">
            <thead>
                <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                <th style="background-color: #4CAF50; color: white;"> Kode Pelanggan</th>
                <th style="background-color: #4CAF50; color: white;"> Tanggal </th> 
                <th style="background-color: #4CAF50; color: white;"> Jam </th>
                <th style="background-color: #4CAF50; color: white;"> User </th>
                <th style="background-color: #4CAF50; color: white;"> Status </th>
                <th style="background-color: #4CAF50; color: white;"> Total Kotor</th>
                <th style="background-color: #4CAF50; color: white;"> Potongan </th>
                <th style="background-color: #4CAF50; color: white;"> Tax </th>
                <th style="background-color: #4CAF50; color: white;"> Total Bersih</th>
                <th style="background-color: #4CAF50; color: white;"> Tunai </th>
                <th style="background-color: #4CAF50; color: white;"> Kembalian </th>
                <th style="background-color: #4CAF50; color: white;"> Kredit </th>                                   
            </thead>
            
            <tbody>
            <?php


        $perintah_tampil = $db->query("SELECT pel.kode_pelanggan AS code_card,pel.nama_pelanggan,dp.tanggal,dp.no_faktur,dp.kode_pelanggan,dp.total,dp.jam,dp.user,dp.status,dp.potongan,dp.tax,dp.sisa,dp.kredit,dp.tunai FROM penjualan dp INNER JOIN pelanggan pel ON dp.kode_pelanggan = pel.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal'");
      
                  while ($data11 = mysqli_fetch_array($perintah_tampil))

                  {

                      $total_kotor_jual = $data11['total'] + $data11['potongan'];
              
                      echo "<tr>
                      <td>". $data11['no_faktur'] ."</td>
                      <td>". $data11['code_card'] ." - ". $data11['nama_pelanggan'] ."</td>
                      <td>". $data11['tanggal'] ."</td>
                      <td>". $data11['jam'] ."</td>
                      <td>". $data11['user'] ."</td>
                      <td>". $data11['status'] ."</td>
                      <td align='right'>". rp($total_kotor_jual) ."</td>
                      <td align='right'>". rp($data11['potongan']) ."</td>
                      <td align='right'>". rp($data11['tax']) ."</td>
                      <td align='right'>". rp($data11['total']) ."</td>
                      <td align='right'>". rp($data11['tunai']) ."</td>
                      <td align='right'>". rp($data11['sisa']) ."</td>
                      <td align='right'>". rp($data11['kredit']) ."</td>
                      </tr>";


                       $total_akhir_kotor = $total_akhir_kotor + $total_kotor_jual;
                       $total_potongan = $total_potongan + $data11['potongan'];
                       $total_tax = $total_tax + $data11['tax'];
                       $total_jual = $total_jual + $data11['total'];
                       $total_tunai = $total_tunai + $data11['tunai'];
                       $total_sisa = $total_sisa + $data11['sisa'];
                       $total_kredit = $total_kredit + $data11['kredit'];


                  }

                          //Untuk Memutuskan Koneksi Ke Database
                          
                          mysqli_close($db); 
        
        
            ?>

      <td style='color:red'> TOTAL </td>
      <td style='color:red'> - </td>
      <td style='color:red'> - </td>
      <td style='color:red'> - </td>
      <td style='color:red'> - </td>
      <td style='color:red'> - </td>
      <td style='color:red' align='right'> <?php echo rp($total_akhir_kotor);?> </td>
      <td style='color:red' align='right'> <?php echo rp($total_potongan);?> </td>
      <td style='color:red' align='right'> <?php echo rp($total_tax);?> </td> 
      <td style='color:red' align='right'> <?php echo rp($total_jual);?> </td>
      <td style='color:red' align='right'> <?php echo rp($total_tunai);?> </td>
      <td style='color:red' align='right'> <?php echo rp($total_sisa);?> </td>
      <td style='color:red' align='right'> <?php echo rp($total_kredit);?> </td> 


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