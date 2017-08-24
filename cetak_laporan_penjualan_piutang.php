<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);


$total_akhir = 0;
$total_bayar = 0;
$total_kredit = 0;



 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PIUTANG PERIODE </b></h3>
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
      <th style="background-color: #4CAF50; color: white;"> Nama Pelanggan</th>
      <th style="background-color: #4CAF50; color: white;"> Tgl. Transaksi </th>
      <th style="background-color: #4CAF50; color: white;"> Tgl. Jatuh Tempo </th>
      <th style="background-color: #4CAF50; color: white;"> Usia Piutang </th>
      <th style="background-color: #4CAF50; color: white;"> Nilai Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Dibayar </th>
      <th style="background-color: #4CAF50; color: white;"> Piutang </th>
                                    
            </thead>
            
            <tbody>
            <?php

          $perintah009 = $db->query("SELECT id,tanggal,tanggal_jt, DATEDIFF(DATE(NOW()), tanggal) AS usia_piutang ,no_faktur,kode_pelanggan,total,jam,sales,status,potongan,tax,sisa,kredit,nilai_kredit,tunai FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 ORDER BY waktu_input DESC ");
                  while ($data11 = mysqli_fetch_array($perintah009))

                  {

                $query0232 = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS total_bayar FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$data11[no_faktur]' ");
                $kel_bayar = mysqli_fetch_array($query0232);

                $tot_bayar = $kel_bayar['total_bayar'] + $data11['tunai'];
                $sisa_kredit = $data11['nilai_kredit'] - $kel_bayar['total_bayar'];


                  $query_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE id = '$data11[kode_pelanggan]' ");
                  $data_pelanggan = mysqli_fetch_array($query_pelanggan);

                  echo "<tr>
                  <td>". $data11['no_faktur'] ."</td>
                  <td>". $data_pelanggan['nama_pelanggan'] ."</td>
                  <td>". $data11['tanggal'] ."</td>
                  <td>". $data11['tanggal_jt'] ."</td>
                  <td  align='right' >". rp($data11['usia_piutang']) ." Hari</td>
                  <td  align='right' >". rp($data11['total']) ."</td>";

                  echo "<td align='right' >". rp($tot_bayar) ."</td>";

                if ($sisa_kredit < 0 ) {
                # code...
                     echo "<td>0</td>";
                  }
                else {
                  echo "<td align='right' >".rp($sisa_kredit)."</p>";
                }

                      $total_akhir = $total_akhir + $data11['total'];
                      $total_bayar = $total_bayar + $tot_bayar;
                      $total_kredit = $total_kredit + $sisa_kredit;

                  }


    echo "
    <tr>
    <td><p style='color:red'> TOTAL </p></td>
      <td><p style='color:red'> - </p></td>
      <td><p style='color:red'> - </p></td>
      <td><p style='color:red'> - </p></td>
      <td><p style='color:red' align='right'> - </p></td>
      <td><p style='color:red' align='right' > ".rp($total_akhir)." </p></td>
      <td><p style='color:red' align='right' > ".rp($total_bayar)." </p></td>
      <td><p style='color:red' align='right' > ".rp($total_kredit)." </p></td>
      </tr>";              


//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

            ?>
            </tbody>

      </table>
</div>
</div>
<br>

<div class="col-sm-6">
</div>




     </div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>