<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$tanggal_sekarang = date('Y-m-d');

// hitung bulan sebelumnya
$bulan = date('m') - 1;
 if ($bulan == 0)
 {
  echo $bulan = 12;
 }

$bulan_sekarang = date('m');

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);


 ?>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-5">
                 <center><h3> <b> LAPORAN LOSS CUSTOMER </b></h3></center>
                 <hr>
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-3">
                          <br><br><br><br><br>

   <table>
  <tbody>

    <tr><td  width="50%">Tanggal</td> <td> :&nbsp;</td> <td> <?php echo tanggal($tanggal_sekarang);?> </td></tr>

    <tr><td  width="50%">Petugas</td> <td> :&nbsp;</td> <td> <?php echo $_SESSION['nama'];?> </td></tr>

            
  </tbody>
  </table>
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-1">
                <br><br><br><br><br>

        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->
</div> <!-- end of container-->


<br>
<div class="container">

<table id="tableuser" class="table table-bordered">
        <thead>

           <th> Kode Pelanggan </th>
           <th> Nama Pelanggan </th>
           <th> No Telphone </th>
           <th> Total Belanja Bulan Lalu </th>

            
        </thead>
        
        <tbody>
        <?php

          $get_detail = $db->query("SELECT kode_pelanggan FROM penjualan WHERE MONTH(tanggal) = '$bulan_sekarang'");
          while ($get_data = mysqli_fetch_array($get_detail))
            {

            $kode_a = $get_data['kode_pelanggan'];

            }

          $select_data = $db->query("SELECT p.kode_pelanggan,SUM(p.total) AS jumlah,pl.nama_pelanggan,pl.no_telp FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE MONTH(p.tanggal) = '$bulan' AND p.kode_pelanggan != '$kode_a' GROUP BY p.kode_pelanggan");

            while ($out = mysqli_fetch_array($select_data))
            {
                //menampilkan data
            echo "<tr>
                <td>". $out['kode_pelanggan'] ."</td>
                <td>". $out['nama_pelanggan'] ."</td>
                <td>". $out['no_telp'] ."</td>
                <td>". rp($out['jumlah']) ."</td>
            <tr>";

            }
               
                    //Untuk Memutuskan Koneksi Ke Database
                    
                    mysqli_close($db); 
                    
        ?>
        </tbody>

    </table>
      <br>

    
<hr>
 <div class="row">
     
     <div class="col-sm-3"></div>
     <div class="col-sm-3"></div>
     <div class="col-sm-3"></div>
        
 <table>
  <tbody>

    
            
  </tbody>
  </table>


   

     <div class="col-sm-3">

 <b>&nbsp;&nbsp;&nbsp;&nbsp;Petugas<br><br><br><br>( ................... )</b>

    </div>


</div>
        

</div> <!--end container-->

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>