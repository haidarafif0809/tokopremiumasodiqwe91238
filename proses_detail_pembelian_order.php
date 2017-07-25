<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];

$detail = $db->query("SELECT kode_barang FROM detail_pembelian_order WHERE no_faktur_order = '$no_faktur'");

?>
<div class="container">
	<div class="table-responsive"> 
		<table id="tabel_detail" class="table table-bordered table-sm">
			<thead>
				<th> Nomor Faktur </th>
				<th> Kode Barang </th>
				<th> Nama Barang </th>
				<th> Jumlah Barang </th>
				<th> Satuan </th>
				<th> Harga </th>
				<th> Subtotal </th>
				<th> Potongan </th>
				<th> Tax </th>
			</thead>

			<tbody>
				<?php
					while ($data1 = mysqli_fetch_array($detail)) {

						$query = $db->query("SELECT dp.id, dp.no_faktur_order, dp.kode_barang, dp.nama_barang, dp.jumlah_barang / sk.konversi AS jumlah_produk, dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, sk.id_satuan, s.nama FROM detail_pembelian_order dp LEFT JOIN satuan_konversi sk ON dp.satuan = sk.id_satuan LEFT JOIN satuan s ON dp.satuan = s.id  WHERE dp.no_faktur_order = '$no_faktur' AND dp.kode_barang = '$data1[kode_barang]' ");
						$data = mysqli_fetch_array($query);
						
					//menampilkan data
					echo "<tr>
					<td>". $data['no_faktur_order'] ."</td>
					<td>". $data['kode_barang'] ."</td>
					<td>". $data['nama_barang'] ."</td>";

					if ($data['jumlah_produk'] > 0) {
						echo "<td align='right'>". $data['jumlah_produk'] ."</td>";
					}
					else{
						echo "<td align='right'>". $data['jumlah_barang'] ."</td>";
					}

					echo"<td>". $data['nama'] ."</td>
					<td align='right'>". rp($data['harga']) ."</td>
					<td align='right'>". rp($data['subtotal']) ."</td>
					<td align='right'>". rp($data['potongan']) ."</td>
					<td align='right'>". rp($data['tax']) ."</td>

      
					</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
				?>
			</tbody>
		</table>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#tabel_detail').DataTable({"ordering":false});
});
</script>