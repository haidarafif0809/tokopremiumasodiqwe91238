<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$dari_tgl = stringdoang($_GET['dari_tanggal']);
$sampai_tgl = stringdoang($_GET['sampai_tanggal']);



$query1 = $db->query("SELECT * FROM perusahaan ");
$next_cp = mysqli_fetch_array($query1);
    




 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $next_cp['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='130' height='130`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $next_cp['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $next_cp['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $next_cp['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->



    <center> <h4> <b> Laporan Kekuatan Penjualan Per Item</b> </h4> </center>
    <center> <h4> <b> Periode <?php echo$dari_tgl; ?> Sampai <?php echo $sampai_tgl; ?></b> </h4> </center>
<br>






<style type="text/css">
  th,td{
    padding: 1px;
  }


.table1, .th, .td {
    border: 1px solid black;
    font-size: 15px;
    font: verdana;
}


</style>
<br><br>

<table id="tableuser" class="table table-bordered">
    <thead>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Satuan </th>
      <th> Jumlah Periode </th>
      <th> Jumlah Per Hari </th>
      <th> Stok </th>
      <th> Stok Habis (hari) </th>
      
    </thead>
    
    <tbody>
   <?php

   

           $sql = $db->query("SELECT dp.kode_barang, dp.nama_barang, dp.satuan, s.nama FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id 
            WHERE dp.tanggal >= '$dari_tgl' AND dp.tanggal <= '$sampai_tgl' GROUP BY dp.kode_barang ORDER BY SUM(dp.jumlah_barang) DESC ");
           while ( $data1 = mysqli_fetch_array($sql)) {

   
            $zxc = $db->query("SELECT SUM(jumlah_barang) AS jumlah_periode FROM detail_penjualan  WHERE kode_barang = '$data1[kode_barang]' AND tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ");
            $qewr = mysqli_fetch_array($zxc);

            $select1 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_masuk FROM hpp_masuk WHERE kode_barang = '$data1[kode_barang]' AND tanggal <= '$sampai_tgl'  ");
            $masuk = mysqli_fetch_array($select1);
            
            $select2 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_keluar FROM hpp_keluar WHERE kode_barang = '$data1[kode_barang]' AND tanggal <= '$sampai_tgl'  ");
            $keluar = mysqli_fetch_array($select2);
            
            $stok_barang = $masuk['jumlah_masuk'] - $keluar['jumlah_keluar'];

            //hitung hari
            $datetime1 = new DateTime($dari_tgl);
            $datetime2 = new DateTime($sampai_tgl);
            $difference = $datetime1->diff($datetime2);
            $difference->days;


            if ($difference->days < 1) {
               
            // hitung jumlah rata2 perhari
            $jumlah_perhari = $qewr['jumlah_periode'];

            }
            else
            {
            // hitung jumlah rata2 perhari
            $jumlah_perhari = $qewr['jumlah_periode'] / $difference->days;
                        // hitung stok habis(hari)
            }

            if ($jumlah_perhari < 1) {
                 $stok_habis = round($jumlah_perhari);
            }
            else
            {

                 $stok_habis = $stok_barang / round($jumlah_perhari);
            }
           
      
              echo "<tr>
              <td>". $data1['kode_barang'] ."</td>
              <td>". $data1['nama_barang'] ."</td>
              <td>". $data1['nama'] ."</td>
              <td>".rp($qewr['jumlah_periode'])."</td>
              <td>".rp(round($jumlah_perhari))."</td>
              <td>".rp($stok_barang)."</td>
              <td>".rp($stok_habis)."</td>";
              echo "</tr>";
             
   }
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>


<br>

    <div class="row">
      <div class="col-sm-6">
              <font class="satu"><b>Petugas <br><br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font> 
      </div>
         <div class="col-sm-3">


    </div>
    





</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>


