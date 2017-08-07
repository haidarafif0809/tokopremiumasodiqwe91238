<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


  $dari_tanggal = stringdoang($_GET['dari_tanggal']);
  $sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

  $query1 = $db->query("SELECT * FROM perusahaan ");
  $data1 = mysqli_fetch_array($query1);

  $perintah = $db->query("SELECT id, tanggal FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY tanggal ORDER BY tanggal DESC");

  $query_row = $db->query("SELECT tanggal FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
  $jumlah_sum_row = mysqli_num_rows($query_row);

  $query_sum = $db->query("SELECT SUM(total) AS t_total, SUM(nilai_kredit) AS t_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
  $data_sum = mysqli_fetch_array($query_sum);
  $total_sum = $data_sum['t_total'];
  $kredit_sum = $data_sum['t_kredit'];

  $bayar_sum = $total_sum - $kredit_sum;

 ?>


<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PEMBELIAN HARIAN </b></h3>
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
                  <th> Tanggal </th>                  
                  <th> Jumlah Transaksi </th>
                  <th> Total Transaksi </th>
                  <th> Jumlah Bayar Tunai </th>
                  <th> Jumlah Bayar Kredit </th>
                                                     
            </thead>
            
            <tbody>
            <?php
          
          //menyimpan data sementara yang ada pada $perintah
          while ($data = mysqli_fetch_array($perintah))
          {
          //menampilkan data
          $query_row = $db->query("SELECT tanggal FROM pembelian WHERE tanggal = '$data[tanggal]'");
          $jumlah_row = mysqli_num_rows($query_row);

          $perintah2 = $db->query("SELECT SUM(total) AS t_total, SUM(nilai_kredit) AS t_kredit FROM pembelian WHERE tanggal = '$data[tanggal]'");
          $data2 = mysqli_fetch_array($perintah2);
          $t_total = $data2['t_total'];
          $t_kredit = $data2['t_kredit'];
          $t_bayar = $t_total - $t_kredit;

          echo "<tr>
          <td>". $data['tanggal'] ."</td>
          <td>". $jumlah_row."</td>
          <td>". rp($t_total) ."</td>
          <td>". rp($t_bayar) ."</td>
          <td>". rp($t_kredit) ."</td>
          </tr>";
          }

          echo "<tr>
          <td style='color:red'>TOTAL</td>
          <td style='color:red'>". $jumlah_sum_row."</td>
          <td style='color:red'>". rp($total_sum) ."</td>
          <td style='color:red'>". rp($bayar_sum) ."</td>
          <td style='color:red'>". rp($kredit_sum) ."</td>
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