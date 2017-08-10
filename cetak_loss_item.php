<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$tahun_sekarang = date('Y');
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
                 <center><h3> <b> LAPORAN LOSS ITEM </b></h3></center>
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

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>