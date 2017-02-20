<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=laporan_10_besar_penjualan.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tgl = stringdoang($_GET['dari_tanggal']);
$sampai_tgl = stringdoang($_GET['sampai_tanggal']);

 ?>


<div class="container">
		<center><h3><b>Laporan 10 Besar Penjualan</b></h3></center><br>
		<center><h3><b>Periode <?php echo$dari_tgl; ?> Sampai <?php echo $sampai_tgl; ?></b></h3></center>

    <table id="kartu_stok" class="table table-bordered">
       <thead>

      <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
      <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
      <th style='background-color: #4CAF50; color:white'> Satuan </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Periode </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Per Hari </th>
      <th style='background-color: #4CAF50; color:white'> Stok</th>

</thead>
<tbody>

<?php 


           $sql = $db->query("SELECT kode_barang FROM detail_penjualan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' GROUP BY kode_barang ORDER BY SUM(jumlah_barang) DESC LIMIT 10 ");
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
           
           
      
              echo "<tr>
              <td>". $data1['kode_barang'] ."</td>
              <td>". $data_barang['nama_barang'] ."</td>
              <td>". $data_barang['nama_satuan'] ."</td>
              <td>".rp($qewr['jumlah_periode'])."</td>
              <td>".rp(round($jumlah_perhari))."</td>
              <td>".rp($ambil_sisa['stok'])."</td>";
              echo "</tr>";
             
   }
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!--Closed Container-->



