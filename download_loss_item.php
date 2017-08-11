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

           $get_detail = $db->query("SELECT p.kode_barang, SUM(p.jumlah_barang) AS jumlah, s.nama, p.nama_barang FROM detail_penjualan p LEFT JOIN satuan s ON p.satuan = s.id WHERE MONTH(p.tanggal) = '$bulan' GROUP BY p.kode_barang ORDER BY p.id DESC ");
          while ($get_data = mysqli_fetch_array($get_detail))
            {

                  $query_detail = $db->query("SELECT COUNT(kode_barang) AS jumlah_data FROM detail_penjualan WHERE kode_barang = '$get_data[kode_barang]' AND MONTH(tanggal) = '$bulan_sekarang' ");
                  $data_detail = mysqli_fetch_array($query_detail);

                  if ($data_detail['jumlah_data'] == 0) {

                      //menampilkan data
                  echo "<tr>
                      <td>". $get_data['kode_barang'] ."</td>
                      <td>". $get_data['nama_barang'] ."</td>
                      <td>". $get_data['nama'] ."</td>
                      <td>". rp($get_data['jumlah']) ."</td>
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