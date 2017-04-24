<?php include 'session_login.php';
include 'sanitasi.php';
include 'db.php';

$pelanggan = angkadoang($_POST['pelanggan']);


	//ambil setting member
	$perintah = $db->query("SELECT lama_tidak_aktif,aktif_kembali,satuan_tidak_aktif FROM setting_member");
	$ambil = mysqli_fetch_array($perintah);

	$satuan_tidak_aktif = $ambil['satuan_tidak_aktif'];	
	$lama_tidak_aktif = $ambil['lama_tidak_aktif'];	
	$aktif_kembali = $ambil['aktif_kembali'];


	if ($satuan_tidak_aktif == 1) {// JIka satuan tidak aktif nya == 1 (YANG ARTINYA SAMA DENGAN BULAN), MAKA PERINTAHNYA AKAN  DIJALANKAN DIBAWAH INI
		//KEMUDIAN....
		// CEK BELANJA TERAKHIR SESUAI RENTANG WAKTU YANG ADA DI SETTING MEMBER (YANG ARTINYA SAMA DENGAN BULAN), APAKAH PELANGGAN INI PERNAH TIDAK BELANJA(TIDAK AKTIF) SELAMA '$lama_tidak_aktif '
		$query = $db->query("SELECT tanggal , DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' MONTH) AS bulan FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal <= DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' MONTH) ORDER BY tanggal DESC LIMIT 1  ");
		$cek = mysqli_num_rows($query);

				// KEMUDIAN...
				// JIKA ADA,  
				if ($cek > 0) {

							//DICEK ADA BERAPA PENJUALAN A/N PELANGGAN INI , UNTUK MENENTUKAN apakah sudah memenuhi syarat untuk aktif kembali
							$lagi = $db->query("SELECT kode_pelanggan FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal > DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' MONTH) ORDER BY tanggal DESC ");
							$cek_setelah = mysqli_num_rows($lagi);

							// hitung apakah sudah memenuhi syarat untuk aktif kemballi
							$hitung = $cek_setelah - $aktif_kembali;

							if ($hitung < 0 ) {// JIKA HASIL HITUNGAN NYA DIBAWAH 0, ARTINYA BELUM BISA DIAKTIFKAN KEMBALI 
								echo 1;
							}
				}
				


	}

	else if ($satuan_tidak_aktif == 2) {// JIka satuan tidak aktif nya == 2(YANG ARTINYA SAMA DENGAN  TAHUN), MAKA PERINTAHNYA AKAN  DIJALANKAN DIBWAH INI

		//KEMUDIAN....
		// CEK BELANJA TERAKHIR SESUAI RENTANG WAKTU YANG ADA DI SETTING MEMBER (ANG ARTINYA SAMA DENGAN  TAHUN), APAKAH PELANGGAN INI PERNAH TIDAK BELANJA(TIDAK AKTIF) SELAMA '$lama_tidak_aktif '
		$query = $db->query("SELECT tanggal , DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' YEAR) AS tahun FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal <= DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' YEAR) ORDER BY tanggal DESC LIMIT 1  ");
		$cek = mysqli_num_rows($query);;

				// KEMUDIAN...
				// JIKA ADA, 
				if ($cek > 0) {
							//DICEK ADA BERAPA PENJUALAN A/N PELANGGAN INI , UNTUK MENENTUKAN apakah sudah memenuhi syarat untuk aktif kembali
							$lagi = $db->query("SELECT kode_pelanggan FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal > DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' YEAR) ORDER BY tanggal DESC ");
							 $cek_setelah = mysqli_num_rows($lagi);

							// hitung apakah sudah memenuhi syarat untuk aktif kemballi
							$hitung =  $cek_setelah - $aktif_kembali;
							if ($hitung < 0 ) {// JIKA HASIL HITUNGAN NYA DIBAWAH 0, ARTINYA BELUM BISA DIAKTIFKAN KEMBALI 
								echo 1;
							}
				}


	}

		
mysqli_close($db);   



 ?>

  