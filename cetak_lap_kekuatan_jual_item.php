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

   

           $sql = $db->query("SELECT kode_barang FROM detail_penjualan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' GROUP BY kode_barang ORDER BY SUM(jumlah_barang) DESC ");
           while ( $data1 = mysqli_fetch_array($sql)) {

            $bb = $db->query("SELECT b.nama_barang, s.nama AS nama_satuan FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kode_barang = '$data1[kode_barang]' ");
            $data_barang = mysqli_fetch_array($bb);
   
            $zxc = $db->query("SELECT SUM(jumlah_barang) AS jumlah_periode FROM detail_penjualan  WHERE kode_barang = '$data1[kode_barang]' AND tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ");
            $qewr = mysqli_fetch_array($zxc);

            $select = $db->query("SELECT SUM(sisa) AS stok FROM hpp_masuk WHERE kode_barang = '$data1[kode_barang]'");
                $ambil_sisa = mysqli_fetch_array($select);

            //hitung hari
            $datetime1 = new DateTime($dari_tgl);
            $datetime2 = new DateTime($sampai_tgl);
            $difference = $datetime1->diff($datetime2);
            $difference->days;

            // hitung jumlah rata2 perhari
            $jumlah_perhari = $qewr['jumlah_periode'] / $difference->days;
           
                       // hitung stok habis(hari)
            $stok_habis = $ambil_sisa['stok'] / $jumlah_perhari;
      
              echo "<tr>
              <td>". $data1['kode_barang'] ."</td>
              <td>". $data_barang['nama_barang'] ."</td>
              <td>". $data_barang['nama_satuan'] ."</td>
              <td>".rp($qewr['jumlah_periode'])."</td>
              <td>".rp(round($jumlah_perhari))."</td>
              <td>".rp($ambil_sisa['stok'])."</td>
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


