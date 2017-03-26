<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=laporan_kekuatan_penjualan_peritem.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tgl = stringdoang($_GET['dari_tanggal']);
$sampai_tgl = stringdoang($_GET['sampai_tanggal']);

 ?>


<div class="container">
		<center><h3><b>Laporan Kekuatan Penjualan Per Item</b></h3></center><br>
		<center><h3><b>Periode <?php echo$dari_tgl; ?> Sampai <?php echo $sampai_tgl; ?></b></h3></center>

    <table id="kartu_stok" class="table table-bordered">
       <thead>

      <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
      <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
      <th style='background-color: #4CAF50; color:white'> Satuan </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Periode </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Per Hari </th>
      <th style='background-color: #4CAF50; color:white'> Stok</th>
      <th style='background-color: #4CAF50; color:white'> Stok Habis (hari)</th>

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

</div> <!--Closed Container-->



