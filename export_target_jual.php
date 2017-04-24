<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=target_penjualan.xls");
 
include 'db.php';
include 'sanitasi.php';

$no_trx = stringdoang($_GET['no_trx']);
$daritgl = stringdoang($_GET['daritgl']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$keterangan = stringdoang($_GET['keterangan']);
$order = angkadoang($_GET['order']);
$x = 0;

$query1 = $db->query("SELECT * FROM perusahaan ");
$next_cp = mysqli_fetch_array($query1);

$sql = $db->query("SELECT dp.id,dp.jumlah_periode,dp.jual_perhari,dp.target_perhari,dp.proyeksi,dp.stok_terakhir,dp.kebutuhan,dp.kode_barang, dp.nama_barang, dp.satuan, s.nama FROM detail_target_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id WHERE dp.no_trx = '$no_trx' GROUP BY dp.kode_barang ORDER BY dp.jumlah_periode DESC");


?>

<h3><b><center> ESTIMASI ORDER BERDASARKAN TARGET PENJUALAN <br> Periode Data <?php echo $daritgl; ?> s/d <?php echo $sampai_tanggal; ?> </center><b></h3>
 
<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>



 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">No Transaksi</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $no_trx; ?></font> </tr>
      <tr><td  width="25%"><font class="satu">Order Untuk</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $order; ?> Hari</font></td></tr>
      <tr><td  width="25%"><font class="satu">Keterangan</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $keterangan; ?> </font></td></tr>

          
  </tbody>
</table>

<table id="tableuser" border="1">
		<thead>

		<th  style='background-color: #4CAF50; color: white'> No. </th>
      <th  style='background-color: #4CAF50; color: white'> Kode Barang </th>
      <th  style='background-color: #4CAF50; color: white'> Nama Barang </th>
      <th  style='background-color: #4CAF50; color: white'> Satuan </th>
      <th  style='background-color: #4CAF50; color: white'> Penjualan Periode </th>
      <th  style='background-color: #4CAF50; color: white'> Penjualan Per Hari </th>
      <th  style='background-color: #4CAF50; color: white'> Target Per Hari </th>
      <th  style='background-color: #4CAF50; color: white'> Proyeksi Penjualan Periode </th>
      <th  style='background-color: #4CAF50; color: white'> Stok Sekarang</th>
      <th  style='background-color: #4CAF50; color: white'> Kebutuhan </th>

			
			
		</thead>
		
		<tbody>
		<?php
  while ($data1 = mysqli_fetch_array($sql)) {
      
       $x = $x + 1;

    echo "<tr>

    <td>".$x."</td>   
    <td>".$data1["kode_barang"]."</td>
    <td>".$data1["nama_barang"]."</td>
    <td>".$data1["nama"]."</td>
    <td>".rp($data1['jumlah_periode'])."</td>
    <td>".rp($data1['jual_perhari'])."</td>
    <td>".rp($data1['target_perhari'])."</td>
    <td>".rp($data1['proyeksi'])."</td>

    <td>".rp($data1['stok_terakhir'])."</td>
    <td>".rp($data1['kebutuhan'])."</td>";
    echo "</tr>";
             
   }
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>
