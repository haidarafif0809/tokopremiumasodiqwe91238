<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$cara_bayar = stringdoang($_POST['cara_bayar']);


// TOTAL KAS MASUK

//PENJUALAN
$total_kas_masuk_penjualan = $db->query("SELECT * FROM penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'  AND cara_bayar = '$cara_bayar'");

$sum_total_penjualan = $db->query("SELECT  SUM(total) AS total_penjualan FROM penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND cara_bayar = '$cara_bayar'");
$data_total_penjualan = mysqli_fetch_array($sum_total_penjualan);
$total_penjualan = $data_total_penjualan['total_penjualan'];

$sum_kredit_penjualan = $db->query("SELECT  SUM(kredit) AS kredit_penjualan FROM penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND cara_bayar = '$cara_bayar'");
$data_kredit_penjualan = mysqli_fetch_array($sum_kredit_penjualan);
$kredit_penjualan = $data_kredit_penjualan['kredit_penjualan'];

$total_bener = $total_penjualan - $kredit_penjualan;

$sum_tunai_penjualan = $db->query("SELECT  SUM(tunai) AS tunai_penjualan FROM penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'  AND cara_bayar = '$cara_bayar'");
$data_tunai_penjualan = mysqli_fetch_array($sum_tunai_penjualan);
$tunai_penjualan = $data_tunai_penjualan['tunai_penjualan'];

$sum_kembalian = $db->query("SELECT  SUM(sisa) AS kembalian FROM penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'  AND cara_bayar = '$cara_bayar'");
$data_kembalian = mysqli_fetch_array($sum_kembalian);
$kembalian = $data_kembalian['kembalian'];

$tunai = $tunai_penjualan - $kembalian;



// PEMBAYARAN PIUTANG 
$total_kas_masuk_piutang = $db->query("SELECT * FROM pembayaran_piutang WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_kas = '$cara_bayar'");

$sum_total_piutang = $db->query("SELECT  SUM(total) AS total_piutang FROM pembayaran_piutang WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_kas = '$cara_bayar'");
$data_total_piutang = mysqli_fetch_array($sum_total_piutang);
$total_piutang = $data_total_piutang['total_piutang'];


//KAS MASUK
$total_kas_masuk = $db->query("SELECT * FROM kas_masuk WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND ke_akun = '$cara_bayar'");

$sum_total_kas_masuk = $db->query("SELECT  SUM(jumlah) AS total_kas_masuk FROM kas_masuk WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND ke_akun = '$cara_bayar'");
$data_total_kas_masuk = mysqli_fetch_array($sum_total_kas_masuk);
$total_total_kas_masuk = $data_total_kas_masuk['total_kas_masuk'];


//RETUR PEMBELIAN
$total_retur_pembelian = $db->query("SELECT p.id,p.no_faktur_retur,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.potongan,p.tax,p.tunai,p.sisa,s.nama FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE p.tanggal >= '$dari_tanggal'  AND p.tanggal <= '$sampai_tanggal' AND p.cara_bayar = '$cara_bayar' ORDER BY p.id DESC ");

$sum_total_retur_pembelian = $db->query("SELECT  SUM(total) AS total_retur_pembelian FROM retur_pembelian WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND cara_bayar = '$cara_bayar'");
$data_total_retur_pembelian = mysqli_fetch_array($sum_total_retur_pembelian);
$total_total_retur_pembelian = $data_total_retur_pembelian['total_retur_pembelian'];


// TOTAL KAS MUTASI MASUK
$total_kas_mutasi_masuk = $db->query("SELECT * FROM kas_mutasi WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND ke_akun = '$cara_bayar'");

$sum_total_kas_mutasi_masuk = $db->query("SELECT  SUM(jumlah) AS total_kas_mutasi FROM kas_mutasi WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND ke_akun = '$cara_bayar'");
$data_total_kas_mutasi_masuk = mysqli_fetch_array($sum_total_kas_mutasi_masuk);
$total_total_kas_mutasi_masuk = $data_total_kas_mutasi_masuk['total_kas_mutasi'];



$total_seluruh_kas_masuk = $tunai + $total_piutang + $total_total_kas_masuk + $total_total_retur_pembelian + $total_total_kas_mutasi_masuk;

// TOTAL KAS MASUK


// TOTAL KAS KELUAR

// PEMBELIAN
$total_kas_keluar_pembelian = $db->query("SELECT * FROM pembelian WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND cara_bayar = '$cara_bayar'");

$sum_total_pembelian = $db->query("SELECT  SUM(tunai) AS total_pembelian FROM pembelian WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND cara_bayar = '$cara_bayar'");
$data_total_pembelian = mysqli_fetch_array($sum_total_pembelian);
$total_pembelian = $data_total_pembelian['total_pembelian'];

$sum_kredit_pembelian = $db->query("SELECT SUM(kredit) AS kredit_pembelian FROM pembelian WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND cara_bayar = '$cara_bayar'");
$data_kredit_pembelian = mysqli_fetch_array($sum_kredit_penjualan);
$sisa_pembelian = $data_kredit_pembelian['kredit_pembelian'];

$total_betul = $total_pembelian - $sisa_pembelian;

$sum_tunai_pembelian = $db->query("SELECT  SUM(tunai) AS tunai_pembelian FROM pembelian WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'  AND cara_bayar = '$cara_bayar'");
$data_tunai_pembelian = mysqli_fetch_array($sum_tunai_pembelian);
$tunai_pembelian = $data_tunai_pembelian['tunai_pembelian'];


// PEMBAYARAN HUTANG 
$total_kas_keluar_hutang = $db->query("SELECT p.id,p.no_faktur_pembayaran,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.dari_kas,s.nama FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE p.tanggal >= '$dari_tanggal'  AND p.tanggal <= '$sampai_tanggal' AND p.dari_kas = '$cara_bayar' ORDER BY p.id DESC");

$sum_total_hutang = $db->query("SELECT  SUM(total) AS total_hutang FROM pembayaran_hutang WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_kas = '$cara_bayar'");
$data_total_hutang = mysqli_fetch_array($sum_total_hutang);
$total_hutang = $data_total_hutang['total_hutang'];


//KAS KELUAR
$total_kas_keluar= $db->query("SELECT * FROM kas_keluar WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_akun = '$cara_bayar'");

$sum_total_kas_keluar = $db->query("SELECT  SUM(jumlah) AS total_kas_keluar FROM kas_keluar WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_akun = '$cara_bayar'");
$data_total_kas_keluar = mysqli_fetch_array($sum_total_kas_keluar);
$total_total_kas_keluar = $data_total_kas_keluar['total_kas_keluar'];


//RETUR PENJUALAN
$total_retur_penjualan = $db->query("SELECT * FROM retur_penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND cara_bayar = '$cara_bayar'");

$sum_total_retur_penjualan = $db->query("SELECT  SUM(total) AS total_retur_penjualan FROM retur_penjualan WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND cara_bayar = '$cara_bayar'");
$data_total_retur_penjualan = mysqli_fetch_array($sum_total_retur_penjualan);
$total_total_retur_penjualan = $data_total_retur_penjualan['total_retur_penjualan'];


// TOTAL KAS MUTASI KELUAR
$total_kas_mutasi_keluar = $db->query("SELECT * FROM kas_mutasi WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_akun = '$cara_bayar'");

$sum_total_kas_mutasi_keluar = $db->query("SELECT  SUM(jumlah) AS total_kas_mutasi FROM kas_mutasi WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_akun = '$cara_bayar'");
$data_total_kas_mutasi_keluar = mysqli_fetch_array($sum_total_kas_mutasi_keluar);
$total_total_kas_mutasi_keluar = $data_total_kas_mutasi_keluar['total_kas_mutasi'];

$total_seluruh_kas_keluar = $tunai_pembelian + $total_hutang + $total_total_kas_keluar + $total_total_retur_penjualan + $total_total_kas_mutasi_keluar;
// TOTAL KAS KELUAR


//
//
//
//

// SALDO AWAL 
$sum_total_penjualan0 = $db->query("SELECT  SUM(total) AS total_penjualan FROM penjualan WHERE tanggal < '$dari_tanggal' AND cara_bayar = '$cara_bayar'");
$data_total_penjualan0 = mysqli_fetch_array($sum_total_penjualan0);
$total_penjualan0 = $data_total_penjualan0['total_penjualan'];

$sum_kredit_penjualan0 = $db->query("SELECT  SUM(kredit) AS kredit_penjualan FROM penjualan WHERE tanggal < '$dari_tanggal' AND cara_bayar = '$cara_bayar'");
$data_kredit_penjualan0 = mysqli_fetch_array($sum_kredit_penjualan0);
$kredit_penjualan0 = $data_kredit_penjualan0['kredit_penjualan'];
$total_bener0 = $total_penjualan0 - $kredit_penjualan0;

$sum_total_piutang0 = $db->query("SELECT  SUM(total) AS total_piutang FROM pembayaran_piutang WHERE tanggal < '$dari_tanggal'  AND dari_kas = '$cara_bayar'");
$data_total_piutang0 = mysqli_fetch_array($sum_total_piutang0);
$total_piutang0 = $data_total_piutang0['total_piutang'];

$sum_total_kas_masuk0 = $db->query("SELECT  SUM(jumlah) AS total_kas_masuk FROM kas_masuk WHERE tanggal < '$dari_tanggal' AND ke_akun = '$cara_bayar'");
$data_total_kas_masuk0 = mysqli_fetch_array($sum_total_kas_masuk0);
$total_total_kas_masuk0 = $data_total_kas_masuk0['total_kas_masuk'];

$sum_total_retur_pembelian0 = $db->query("SELECT  SUM(total) AS total_retur_pembelian FROM retur_pembelian WHERE tanggal < '$dari_tanggal'  AND cara_bayar = '$cara_bayar'");
$data_total_retur_pembelian0 = mysqli_fetch_array($sum_total_retur_pembelian0);
$total_total_retur_pembelian0 = $data_total_retur_pembelian0['total_retur_pembelian'];

$sum_total_kas_mutasi_masuk0 = $db->query("SELECT  SUM(jumlah) AS total_kas_mutasi FROM kas_mutasi WHERE tanggal < '$dari_tanggal' AND dari_akun = '$cara_bayar'");
$data_total_kas_mutasi_masuk0 = mysqli_fetch_array($sum_total_kas_mutasi_masuk0);
$total_total_kas_mutasi_masuk0 = $data_total_kas_mutasi_masuk0['total_kas_mutasi'];

$total_seluruh_kas_masuk0 = $total_bener0 + $total_piutang0 + $total_total_kas_masuk0 + $total_total_retur_pembelian0 + $total_total_kas_mutasi_masuk0;

// TOTAL KAS MASUK
$sum_total_pembelian0 = $db->query("SELECT  SUM(total) AS total_pembelian FROM pembelian WHERE tanggal < '$dari_tanggal' AND cara_bayar = '$cara_bayar'");
$data_total_pembelian0 = mysqli_fetch_array($sum_total_penjualan0);
$total_pembelian0 = $data_total_pembelian0['total_pembelian'];

$sum_kredit_penjualan0 = $db->query("SELECT  SUM(kredit) AS kredit_pembelian FROM pembelian WHERE tanggal < '$dari_tanggal' AND cara_bayar = '$cara_bayar'");
$data_kredit_penjualan0 = mysqli_fetch_array($sum_kredit_penjualan0);
$sisa_pembelian0 = $data_kredit_penjualan0['kredit_pembelian'];
$total_betul0 = $total_pembelian0 - $sisa_pembelian0;

$sum_total_hutang0 = $db->query("SELECT  SUM(total) AS total_hutang FROM pembayaran_hutang WHERE tanggal < '$dari_tanggal' AND dari_kas = '$cara_bayar'");
$data_total_hutang0 = mysqli_fetch_array($sum_total_hutang0);
$total_hutang0 = $data_total_hutang0['total_hutang'];

$sum_total_kas_keluar0 = $db->query("SELECT  SUM(jumlah) AS total_kas_keluar FROM kas_keluar WHERE tanggal < '$dari_tanggal' AND dari_akun = '$cara_bayar'");
$data_total_kas_keluar0 = mysqli_fetch_array($sum_total_kas_keluar0);
$total_total_kas_keluar0 = $data_total_kas_keluar0['total_kas_keluar'];

$sum_total_retur_penjualan0 = $db->query("SELECT  SUM(total) AS total_retur_penjualan FROM retur_penjualan WHERE tanggal < '$dari_tanggal' AND cara_bayar = '$cara_bayar'");
$data_total_retur_penjualan0 = mysqli_fetch_array($sum_total_retur_pembelian0);
$total_total_retur_penjualan0 = $data_total_retur_penjualan0['total_retur_penjualan'];

$sum_total_kas_mutasi_keluar0 = $db->query("SELECT  SUM(jumlah) AS total_kas_mutasi FROM kas_mutasi WHERE tanggal < '$dari_tanggal' AND dari_akun = '$cara_bayar'");
$data_total_kas_mutasi_keluar0 = mysqli_fetch_array($sum_total_kas_mutasi_keluar0);
$total_total_kas_mutasi_keluar0 = $data_total_kas_mutasi_keluar0['total_kas_mutasi'];

$total_seluruh_kas_keluar0 = $total_betul0+ $total_hutang0 + $total_total_kas_keluar0 + $total_total_retur_penjualan0 + $total_total_kas_mutasi_keluar0;

// TOTAL KAS KELUAR



$saldo_awal = $total_seluruh_kas_masuk0 - $total_seluruh_kas_keluar0;
//SALDO AWAL

//PERUBAHAN SALDO

$perubahan_saldo = $total_seluruh_kas_masuk - $total_seluruh_kas_keluar;

//PERUBAHAN SALDO

//SALDO AKHIR
$saldo_akhir = $saldo_awal + $perubahan_saldo;
//SALDO AKHIR

 ?>
<h1> <b> Total Kas Masuk : Rp. <?php echo rp($total_seluruh_kas_masuk); ?> </b> </h1>
 <h2> Penjualan Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($tunai); ?></h2>

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur </th>
			<th> Tanggal </th>
			<th> Kode Pelanggan</th>
			<th> Total </th>
			<th> Jam </th>
			<th> User </th>
			<th> Status </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> Kembalian </th>
			<th> Kredit </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_kas_masuk_penjualan))

			{

				$t = $data1['total'];
				$k = $data1['kredit'];

				if ($k != $t) {

			//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['kode_pelanggan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['status'] ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			<td>". rp($data1['kredit']) ."</td>
			</tr>";
					
				}

			}
		?>
		</tbody>

	</table>

</div>
<br>

 <h2> Pembayaran Piutang Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_piutang); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur </th>
			<th> Tanggal </th>
			<th> Jam </th>
			<th> Kode Pelanggan </th>
			<th> Keterangan </th>
			<th> Total </th>
			<th> User  </th>
			<th> Ke Kas </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_kas_masuk_piutang))

			{
				//menampilkan data
			echo "<tr>

			<td>". $data1['no_faktur_pembayaran'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['nama_suplier'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['user_buat'] ."</td>
			<td>". $data1['dari_kas'] ."</td>
			</tr>";
			}
		?>
		</tbody>

	</table>

</div>
<br>

 <h2>Kas Masuk Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_total_kas_masuk); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur </th>
			<th> Tanggal </th>
			<th> Ke Kas </th>
			<th> Total </th>
			<th> Jam </th>
			<th> User </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_kas_masuk))

			{

				$detail_kas_masuk = $db->query("SELECT dari_akun FROM detail_kas_masuk WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'  AND dari_akun = '$cara_bayar'");
				$ambil_detail_km = mysqli_fetch_array($detail_kas_masuk);
				//menampilkan data
			echo "<tr>

			<td>". $data1['no_faktur'] ."</td>			
			<td>". $data1['tanggal'] ."</td>			
			<td>". $data1['ke_akun'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			</tr>";
			}
		?>
		</tbody>

	</table>

</div>
<br>

 <h2>Retur Pembelian Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_total_retur_pembelian); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur Retur </th>
			<th> Tanggal </th>
			<th> Nama Suplier </th>
			<th> Total </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> User  </th>
			<th> Tunai </th>
			<th> Kembalian </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_retur_pembelian))

			{
				//menampilkan data
			echo "<tr>

			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". $data1['user_buat'] ."</td>
			<td>". rp($data1['tunai']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			</tr>";
			}
		?>
		</tbody>

	</table>

</div>
<br>
		
 <h2>Kas Mutasi Masuk Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_total_kas_mutasi_masuk); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
            			<th> Nomor Faktur </th>
			<th> Keterangan </th>
			<th> Tanggal </th>
			<th> Dari Akun </th>
			<th> Jumlah </th>
			<th> Jam </th>
			<th> User </th>	
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_kas_mutasi_masuk))

			{
				//menampilkan data
			echo "<tr>

			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". $data1['dari_akun'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			</tr>";
			}
		?>
		</tbody>

	</table>

</div>
<br>	

<hr>
<hr>

<h1> <b> Total Kas Keluar : Rp. <?php echo rp($total_seluruh_kas_keluar); ?> </b> </h1>
 <h2> Pembelian Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_betul); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur </th>
			<th> Suplier </th>
			<th> Total </th>
			<th> Tanggal </th>
			<th> Tanggal Jatuh Tempo </th>
			<th> Jam </th>
			<th> User </th>
			<th> Status </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> Kembalian</th>
			<th> Kredit </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_kas_keluar_pembelian))

			{

				$t = $data1['total'];
				$k = $data1['kredit'];

				if ($k != $t){
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['suplier'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['tanggal_jt'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['status'] ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			<td>". rp($data1['kredit']) ."</td>
			</tr>";
			}


			}
		?>
		</tbody>

	</table>

</div>
<br>

 <h2> Pembayaran Hutang Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_hutang); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur </th>
			<th> Tanggal </th>
			<th> Jam </th>
			<th> Nama Suplier </th>
			<th> Keterangan </th>
			<th> Total </th>
			<th> User </th>
			<th> Dari Kas </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_kas_keluar_hutang))

			{
				//menampilkan data
			echo "<tr>

			<td>". $data1['no_faktur_pembayaran'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['user_buat'] ."</td>
			<td>". $data1['dari_kas'] ."</td>
			</tr>";
			}
		?>
		</tbody>

	</table>

</div>
<br>

 <h2>Kas Keluar Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_total_kas_keluar); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur </th>
			<th> Ke Kas </th>
			<th> Jumlah </th>
			<th> Tanggal </th>
			<th> Jam </th>
			<th> User </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_kas_keluar))

			{

				$detail_kas_keluar = $db->query("SELECT ke_akun FROM detail_kas_keluar WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal'  AND dari_akun = '$cara_bayar'");
				$ambil_detail_kk = mysqli_fetch_array($detail_kas_keluar);

			//menampilkan data
			echo "<tr>

			<td>". $data1['no_faktur'] ."</td>
			<td>". $ambil_detail_kk['ke_akun'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			</tr>";
			}
		?>
		</tbody>

	</table>

</div>
<br>

 <h2>Retur Penjualan Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_total_retur_penjualan); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur Retur </th>
			<th> Tanggal </th>
			<th> Kode Pelanggan </th>
			<th> Total </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> User  </th>
			<th> Tunai </th>
			<th> Kembalian </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_retur_penjualan))

			{
				//menampilkan data
			echo "<tr>

			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['kode_pelanggan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". $data1['user_buat'] ."</td>
			<td>". rp($data1['tunai']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			</tr>";
			}
		?>
		</tbody>

	</table>

</div>
<br>

<hr>
<hr>

		
 <h2>Kas Mutasi Keluar Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_total_kas_mutasi_keluar); ?></h2>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
            			<th> Nomor Faktur </th>
			<th> Tanggal </th>
			<th> Keterangan </th>
			<th> Ke Kas </th>
			<th> Jumlah </th>
			<th> Jam </th>
			<th> User </th>	
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_kas_mutasi_keluar))

			{
			if ($data1['dari_akun'] == $cara_bayar) {
			//menampilkan data
			echo "<tr>

			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". $data1['ke_akun'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			</tr>";				
			}

			}

				//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>

</div>
<br>			

<b> <h3>Saldo Awal Tanggal </b> <b><?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> : Rp. <?php echo rp($saldo_awal); ?></b></h3>
<b> <h3>Perubahan Saldo Tanggal </b> <b><?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> : Rp. <?php echo rp($perubahan_saldo); ?></b></h3>

<hr>
<hr>

<b> <h3> Saldo Akhir Tanggal </b> <b><?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> : Rp. <?php echo rp($saldo_akhir); ?></b></h3>

<br>
<div class="form-group">
<a href='cetak_cashflow_perperiode.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>&cara_bayar=<?php echo $cara_bayar; ?>' class='btn btn-success' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak  </a>
</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>

<?php include 'footer.php'; ?>