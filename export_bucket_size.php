<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=bucket_size.xls");
 
include 'db.php';
include 'sanitasi.php';

$dari_tgl = stringdoang($_GET['dari_tanggal']);
$sampai_tgl = stringdoang($_GET['sampai_tanggal']);
$kelipatan = angkadoang($_GET['kelipatan']);
$satu = 1;




?>

<h3><b><center> LAPORAN BUCKET SIZE PERIODE <?php echo $dari_tgl; ?> Sampai <?php echo $sampai_tgl; ?> </center><b></h3>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>


<table id="tableuser" border="1">
		<thead>

      <th  style='background-color: #4CAF50; color: white'> Omset per Faktur </th>
      <th  style='background-color: #4CAF50; color: white'> Total Faktur </th>
      <th  style='background-color: #4CAF50; color: white'> % </th

						
		</thead>
		
		<tbody>
		<?php

  $sql = $db->query("SELECT MAX(total) AS total FROM penjualan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ");
  $data1 = mysqli_fetch_array($sql);

  $total1 = $kelipatan + $data1['total'];
        
  while($kelipatan <= $total1) {
      

    echo "<tr>

    <td>".rp($satu) ." - ". rp($kelipatan)."</td>";

    $query2 = $db->query("SELECT COUNT(*) AS total_faktur FROM penjualan WHERE total BETWEEN '$satu' AND '$kelipatan' ");
    $data2 = mysqli_fetch_array($query2);

    $query5 = $db->query("SELECT COUNT(*) AS total_faktur_semua FROM penjualan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl'");
    $data5 = mysqli_fetch_array($query5);

    //hitung persen 
    $hitung = $data2['total_faktur'] / $data5['total_faktur_semua'] * 100 /100;


    echo"<td>".rp($data2['total_faktur'])."</td>
    <td>".rp(round($hitung,2))."</td>";
       
    $kelipatan1 = angkadoang($_GET['kelipatan']);
    $kelipatan += $kelipatan1;
    $satu += $kelipatan1;

    echo "</tr>";
             
   }
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>
