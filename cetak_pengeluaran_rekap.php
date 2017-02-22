<?php include 'session_login.php';

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_GET ['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET ['sampai_tanggal']);



$sum_total_pengeluaran = $db->query("SELECT  SUM(jumlah) AS total_pengeluaran FROM detail_kas_keluar WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'");

$data_total_pengeluaran = mysqli_fetch_array($sum_total_pengeluaran);
$total_pengeluaran = $data_total_pengeluaran['total_pengeluaran'];


$sum_total_pemasukan = $db->query("SELECT  SUM(jumlah) AS c FROM detail_kas_keluar WHERE tanggal = '$dari_tanggal'");

$data_total_pemasukan = mysqli_fetch_array($sum_total_pemasukan);
$c = $data_total_pemasukan['c'];

?>

<?php if ($sampai_tanggal == ""){

?>
	 <h2> Laporan Pengeluaran Rekap Tanggal : <?php echo tanggal($dari_tanggal); ?> = Rp. <?php echo rp($c); ?></h2><br>
<?php 
}


else{
	?>
	<h2> Laporan Pengeluaran Rekap Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_pengeluaran); ?></h2><br>
	
<?php }
?>

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nama Akun </th>
			<th> Jumlah </th>
			
		</thead>
		
		<tbody>
<?php


$tabel_pengeluaran = $db->query("SELECT nama FROM pengeluaran");

while ($ambil_pengeluaran = mysqli_fetch_array($tabel_pengeluaran))

{

$select_kas_masuk = $db->query("SELECT  SUM(jumlah) AS a FROM detail_kas_keluar WHERE ke_akun = '$ambil_pengeluaran[nama]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$jumlah_pemasukan = mysqli_fetch_array($select_kas_masuk);
$a = $jumlah_pemasukan['a'];


$select_kas_masuk = $db->query("SELECT  SUM(jumlah) AS b FROM detail_kas_keluar WHERE ke_akun = '$ambil_pengeluaran[nama]' AND tanggal = '$dari_tanggal'");
$jumlah_pemasukan = mysqli_fetch_array($select_kas_masuk);
$b = $jumlah_pemasukan['b'];




echo "<tr>
			<td>". $ambil_pengeluaran['nama'] ."</td>";
if ($sampai_tanggal == "") {
	echo "<td>". rp($b) ."</td>";
}
else{
	echo "<td>". rp($a) ."</td>";
}
			

echo"</tr>";

}


//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

?>
		</tbody>

	</table>