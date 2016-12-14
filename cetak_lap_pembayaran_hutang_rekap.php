<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

//menampilkan seluruh data yang ada pada tabel pembayaran_hutang
$perintah = $db->query("SELECT * FROM pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");


//menampilkan seluruh data yang ada pada tabel pembayaran_hutang




$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM detail_pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];


$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM pembayaran_hutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
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
                 <h3> <b> LAPORAN PEMBAYARAN HUTANG REKAP </b></h3>
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
      <th> Nama Suplier </th>
      <th> Cara Bayar </th>
      <th> Potongan </th>
      <th> Jumlah Bayar </th>
                                    
            </thead>
            
            <tbody>
            <?php

                  $perintah009 = $db->query("SELECT da.nama_daftar_akun,p.no_faktur_pembayaran,p.tanggal,p.nama_suplier,p.dari_kas,p.total,s.nama FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' ORDER BY p.id DESC");
                  while ($data11 = mysqli_fetch_array($perintah009))

                  {



                    $perintah0 = $db->query("SELECT * FROM detail_pembayaran_hutang WHERE no_faktur_pembayaran = '$data11[no_faktur_pembayaran]'");
                    $data0 = mysqli_fetch_array($perintah0);
      
                  echo "<tr>
                  <td>". $data11['no_faktur_pembayaran'] ."</td>
                  <td>". $data11['tanggal'] ."</td>
                  <td>". $data11['nama'] ."</td>
                  <td>". $data11['nama_daftar_akun'] ."</td>
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