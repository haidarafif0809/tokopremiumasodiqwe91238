<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

//menampilkan seluruh data yang ada pada tabel pembayaran_piutang
$perintah = $db->query("SELECT p.nama_pelanggan,pp.nama_suplier,pp.no_faktur_pembayaran,pp.tanggal,pp.dari_kas,pp.total FROM pembayaran_piutang pp LEFT JOIN pelanggan p ON pp.nama_suplier = p.kode_pelanggan WHERE pp.tanggal >= '$dari_tanggal' AND pp.tanggal <= '$sampai_tanggal'");


//menampilkan seluruh data yang ada pada tabel pembayaran_piutang




$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM detail_pembayaran_piutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];


$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM pembayaran_piutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];



 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PEMBAYARAN PIUTANG REKAP </b></h3>
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
      <th> Kode Pelanggan </th>
      <th> Cara Bayar </th>
      <th> Potongan </th>
      <th> Jumlah Bayar </th>
                                    
            </thead>
            
            <tbody>
            <?php

               
                  while ($data11 = mysqli_fetch_array($perintah))

                  {

                    $perintah0 = $db->query("SELECT * FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$data11[no_faktur_pembayaran]'");
                    $data0 = mysqli_fetch_array($perintah0);
      
                  echo "<tr>
                  <td>". $data11['no_faktur_pembayaran'] ."</td>
                  <td>". $data11['tanggal'] ."</td>
                  <td>". $data11['nama_suplier'] ." ". $data11['nama_pelanggan'] ."</td>
                  <td>". $data11['dari_kas'] ."</td>
                  <td>". rp($data0['potongan']) ."</td>
                  <td>". rp($data11['total']) ."</td>
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


<div class="col-sm-9">
</div>


<div class="col-sm-3">
<h4><b>Total :</b> <?php echo rp($total_akhir); ?></h4>
</div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>