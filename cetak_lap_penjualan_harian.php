<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

$perintah = $db->query("SELECT tanggal FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY tanggal");

$perintah11 = $db->query("SELECT * FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data11 = mysqli_num_rows($perintah11);

$perintah210 = $db->query("SELECT SUM(total) AS total_total FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");

$data210 = mysqli_fetch_array($perintah210);

$total_total = $data210['total_total'];

$perintah212 = $db->query("SELECT SUM(kredit) AS total_kredit FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data212 = mysqli_fetch_array($perintah212);
$total_kredit = $data212['total_kredit'];

$total_bayar = $total_total - $total_kredit;

 ?>


<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PENJUALAN HARIAN </b></h3>
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
            $perintah1 = $db->query("SELECT * FROM penjualan WHERE tanggal = '$data[tanggal]'");
            $data1 = mysqli_num_rows($perintah1);

            $perintah2 = $db->query("SELECT SUM(total) AS t_total FROM penjualan WHERE tanggal = '$data[tanggal]'");
            $data2 = mysqli_fetch_array($perintah2);
            $t_total = $data2['t_total'];

            $perintah21 = $db->query("SELECT SUM(kredit) AS t_kredit FROM penjualan WHERE tanggal = '$data[tanggal]'");
            $data21 = mysqli_fetch_array($perintah21);
            $t_kredit = $data21['t_kredit'];

            $t_bayar = $t_total - $t_kredit;

          echo "<tr>
          <td>". $data['tanggal'] ."</td>
          <td>". $data1."</td>
          <td>". rp($t_total) ."</td>
          <td>". rp($t_bayar) ."</td>
          <td>". rp($t_kredit) ."</td>


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

<div class="container">
 <table>
  <tbody>

      <tr>
      <td><b><i>TOTAL : </b></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $data11; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo rp($total_total); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo rp($total_bayar); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo rp($total_kredit); ?> </td>
      </tr>
                 
  </tbody>
  </table>
</div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>