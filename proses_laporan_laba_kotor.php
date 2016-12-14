<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$penjualan = $db->query("SELECT p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,pl.nama_pelanggan FROM penjualan p INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'  ORDER BY p.id DESC");




 ?>

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="card card-block">

<div class="table-responsive">
 <table id="tableuser" class="table table-hover">
            <thead>
			<th style="text-align: center"> Nomor Transaksi </th>
			<th style="text-align: center"> Tanggal </th>
			<th style="text-align: center"> Kode Pelanggan</th>
			<th style="text-align: center"> Sub Total </th>
			<th style="text-align: center"> Total Pokok </th>
			<th style="text-align: center"> Laba Kotor </th>
			<th style="text-align: center"> Diskon Faktur </th>
			<th style="text-align: center"> Laba Jual </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data_penjualan = mysqli_fetch_array($penjualan))

			{

			$sum_subtotal_detail_penjualan = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_penjualan WHERE no_faktur = '$data_penjualan[no_faktur]'");
			$cek_sum_sub = mysqli_fetch_array($sum_subtotal_detail_penjualan);

			$sum_pajak_penjualan = $db->query("SELECT SUM(tax) AS pajak FROM penjualan WHERE no_faktur = '$data_penjualan[no_faktur]'");
			$cek_sum_pajak = mysqli_fetch_array($sum_pajak_penjualan);

			$subtotal = $cek_sum_sub['subtotal'] + $cek_sum_pajak['pajak'];

			$sum_hpp_penjualan = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$data_penjualan[no_faktur]'");
			$cek_sum_hpp = mysqli_fetch_array($sum_hpp_penjualan);

			$laba_kotor = $subtotal - $cek_sum_hpp['total_hpp'];

			$laba_jual = $laba_kotor - $data_penjualan['potongan'];

		//menampilkan data
			echo "<tr>
			<td>". $data_penjualan['no_faktur'] ."</td>
			<td>". $data_penjualan['tanggal'] ."</td>
			<td>". $data_penjualan['kode_pelanggan'] ." - ". $data_penjualan['nama_pelanggan'] ."</td>
			<td style='text-align: right'>". rp($subtotal) ."</td>
			<td style='text-align: right'>". rp($cek_sum_hpp['total_hpp']) ."</td>
			<td style='text-align: right'>". rp($laba_kotor) ."</td>
			<td style='text-align: right'>". rp($data_penjualan['potongan']) ."</td>
			<td style='text-align: right'>". rp($laba_jual) ."</td>
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   

		?>
		</tbody>

	</table>

<br><br>

       <a href='cetak_laporan_laba_kotor.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>'
       class='btn btn-warning' target='blank'><i class='fa fa-print'> </i> Cetak Laporan Laba Kotor </a>

</div>

<script type="text/javascript">
	
	$(document).ready(function(){
	$('#tableuser').DataTable(
	{"ordering": false});
	});

</script>
