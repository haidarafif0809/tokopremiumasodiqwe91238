<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
$data_perusahaan = mysqli_fetch_array($query_perusahaan);

$query_sum = $db->query("SELECT SUM(p.total) AS total_akhir, SUM(p.tunai) AS total_tunai, SUM(p.kredit) AS total_kredit, SUM(p.nilai_kredit) AS total_nilai_kredit, SUM(dph.jumlah_bayar) + SUM(dph.potongan) AS total_bayar FROM pembelian p LEFT JOIN detail_pembayaran_hutang dph ON p.no_faktur = dph.no_faktur_pembelian WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0");
$data_sum = mysqli_fetch_array($query_sum);

?>

<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PEMBELIAN HUTANG </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> 
                 
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

              <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
              <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
              <th style="background-color: #4CAF50; color: white;"> Suplier </th>
              <th style="background-color: #4CAF50; color: white;"> Tanggal JT </th>
              <th style="background-color: #4CAF50; color: white;"> Umur Hutang </th>
              <th style="background-color: #4CAF50; color: white;"> Petugas </th>
              <th style="background-color: #4CAF50; color: white;"> Total Beli </th>
              <th style="background-color: #4CAF50; color: white;"> Bayar Beli </th>
              <th style="background-color: #4CAF50; color: white;"> Hutang </th>
              <th style="background-color: #4CAF50; color: white;"> Pembayaran Hutang </th>
              <th style="background-color: #4CAF50; color: white;"> Saldo Hutang </th>
                                          
            </thead>
            
            <tbody>
            <?php

                  $query_pembelian = $db->query("SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nilai_kredit,s.nama,g.nama_gudang,p.tunai, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND kredit != 0 ORDER BY p.id DESC");
                  while ($data_pembelian = mysqli_fetch_array($query_pembelian)){

                  $query_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_pembelian[no_faktur]' ");
                  $data_hutang = mysqli_fetch_array($query_hutang);

                  echo "<tr>
                  <td>". $data_pembelian['tanggal'] ."</td>
                  <td>". $data_pembelian['no_faktur'] ."</td>
                  <td>". $data_pembelian['nama'] ."</td>
                  <td>". $data_pembelian['tanggal_jt'] ."</td>
                  <td>". $data_pembelian['usia_hutang'] ."</td>
                  <td>". $data_pembelian['user'] ."</td>
                  <td align='right'>". rp($data_pembelian['total']) ."</td>
                  <td align='right'>". rp($data_pembelian['tunai']) ."</td>
                  <td align='right'>". rp($data_pembelian['nilai_kredit']) ."</td>
                  <td align='right'>". rp($data_hutang['total_bayar']) ."</td>
                  <td align='right'>". rp($data_pembelian['kredit']) ."</td>

                  </tr>";


                  }
                  

                  echo "<tr>
                  <td style='color:red'>TOTAL</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_akhir']) ."</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_tunai']) ."</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_nilai_kredit']) ."</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_bayar']) ."</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_kredit']) ."</td>
                  </tr>";

                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db); 
 
            ?>
            </tbody>

      </table>
</div>



 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>