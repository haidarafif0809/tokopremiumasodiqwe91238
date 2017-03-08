<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_loss_customer.xls");

include 'db.php';
include 'sanitasi.php';

// hitung bulan sebelumnya
$bulan = date('m') - 1;
 if ($bulan == 0)
 {
 	echo $bulan = 12;
 }

$bulan_sekarang = date('m');

?>

<div class="container">
<center><h3><b>Data Loss Customer</b></h3></center>
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
            
          $select_data = $db->query("SELECT pl.kode_pelanggan AS code_card,p.kode_pelanggan,SUM(p.total) AS jumlah,pl.nama_pelanggan,pl.no_telp FROM penjualan p INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE MONTH(p.tanggal) = '$bulan' AND p.kode_pelanggan != '$kode_a' GROUP BY p.kode_pelanggan");

            while ($out = mysqli_fetch_array($select_data))
            {
                //menampilkan data
            echo "<tr>
                <td>". $out['code_card'] ."</td>
                <td>". $out['nama_pelanggan'] ."</td>
                <td>". $out['no_telp'] ."</td>
                <td>". $out['jumlah'] ."</td>
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
