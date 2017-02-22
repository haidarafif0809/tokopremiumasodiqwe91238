<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_loss_item.xls");

include 'db.php';
include 'sanitasi.php';

$bulan = date('m') - 1;
 if ($bulan == 0)
 {
  echo $bulan = 12;
 }

$bulan_sekarang = date('m');

 ?>

<div class="container">
<center><b>Data Loss Item </b></center>
<table id="tableuser" class="table table-bordered">
        <thead>

           <th> Kode Barang </th>
           <th> Nama Barang </th>
           <th> Satuan </th>
           <th> Total Terjual Bulan Lalu </th>

            
        </thead>
        
        <tbody>
        <?php

          $get_detail = $db->query("SELECT kode_barang FROM detail_penjualan WHERE MONTH(tanggal) = '$bulan_sekarang' GROUP BY kode_barang");
          while ($get_data = mysqli_fetch_array($get_detail))
            {

            $kode_now = $get_data['kode_barang'];

            $select_data = $db->query("SELECT p.kode_barang, SUM(p.jumlah_barang) AS jumlah, s.nama, p.nama_barang FROM detail_penjualan p LEFT JOIN satuan s ON p.satuan = s.id WHERE MONTH(p.tanggal) = '$bulan' AND p.kode_barang != '$kode_now' GROUP BY p.kode_barang");

            while ($out = mysqli_fetch_array($select_data))
            {
                //menampilkan data
            echo "<tr>
                <td>". $out['kode_barang'] ."</td>
                <td>". $out['nama_barang'] ."</td>
                <td>". $out['nama'] ."</td>
                <td>". $out['jumlah'] ."</td>
            <tr>";

            }
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