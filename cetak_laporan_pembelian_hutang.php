<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
$data_perusahaan = mysqli_fetch_array($query_perusahaan);

$query_sum = $db->query("SELECT SUM(total) AS total_akhir, SUM(potongan) AS total_potongan, SUM(tax) AS total_pajak, SUM(kredit) AS total_kredit, SUM(nilai_kredit) AS total_nilai_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
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

              <th> Tanggal </th>
              <th> Nomor Faktur </th>
              <th> Suplier </th>
              <th> Tanggal JT </th>
              <th> Jam </th>
              <th> User </th>
              <th> Status </th>
              <th> Potongan </th>
              <th> Tax </th>
              <th> Total </th>
              <th> Sisa Kredit </th>
              <th> Nilai Kredit </th>
                                    
            </thead>
            
            <tbody>
            <?php

                  $query_pembelian = $db->query("SELECT p.tanggal, p.no_faktur, p.tanggal_jt, p.jam, p.user, p.status, p.potongan, p.tax, p.total, p.kredit, p.nilai_kredit, s.nama FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id  WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND kredit != 0 ");
                  while ($data_pembelian = mysqli_fetch_array($query_pembelian)){

                  echo "<tr>
                  <td>". $data_pembelian['tanggal'] ."</td>
                  <td>". $data_pembelian['no_faktur'] ."</td>
                  <td>". $data_pembelian['nama'] ."</td>
                  <td>". $data_pembelian['tanggal_jt'] ."</td>
                  <td>". $data_pembelian['jam'] ."</td>
                  <td>". $data_pembelian['user'] ."</td>
                  <td>". $data_pembelian['status'] ."</td>
                  <td align='right'>". rp($data_pembelian['potongan']) ."</td>
                  <td align='right'>". rp($data_pembelian['tax']) ."</td>
                  <td align='right'>". rp($data_pembelian['total']) ."</td>
                  <td align='right'>". rp($data_pembelian['kredit']) ."</td>
                  <td align='right'>". rp($data_pembelian['nilai_kredit']) ."</td>

                  </tr>";


                  }
                  

                  echo "<tr>
                  <td style='color:red'>TOTAL</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red'>-</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_potongan']) ."</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_pajak']) ."</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_akhir']) ."</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_kredit']) ."</td>
                  <td style='color:red' align='right'>". rp($data_sum['total_nilai_kredit']) ."</td>
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