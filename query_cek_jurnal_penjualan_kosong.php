
<b>Catatan:</b>
Jika jumlah jurnal nya di bawah 2 , maka di anggap data jurnal nya ada yang salah, maka akan di lakukan update jurnal ke yang seharus nya 
<table border="1">
	
	<thead>
		
		<th>No Faktur </th>
		<th>Tanggal</th>
		<th>Jumlah Jurnal</th>
	</thead>
	<tbody>
<?php 

include 'db.php';
include 'sanitasi.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_penjualan = $db->query("SELECT no_faktur,tanggal FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");


while ($data_penjualan = mysqli_fetch_array($query_penjualan)) {
	# code...

	$query_jurnal = $db->query("SELECT COUNT(*) AS jumlah_jurnal FROM jurnal_trans WHERE no_faktur = '$data_penjualan[no_faktur]' AND (debit  != 0 OR kredit != 0)");
	$data_jurnal = mysqli_fetch_array($query_jurnal);

	if ($data_jurnal['jumlah_jurnal'] < 2) {
		# code...
		$db->query("UPDATE penjualan SET keterangan = 'Edit Otomatis Jurnal' WHERE no_faktur = '$data_penjualan[no_faktur]'");
	}

	echo "<tr>
			<td>".$data_penjualan['no_faktur']."</td>
			<td>".$data_penjualan['tanggal']."</td>
			<td>".$data_jurnal['jumlah_jurnal']."</td>
		 </tr>";
}
 ?>
 </tbody>
</table>