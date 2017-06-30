<?php 

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';


 // mengirim data no faktur menggunakan metode POST
 $no_faktur = stringdoang($_POST['no_faktur']);
 $jenis_aksi = stringdoang($_POST['jenis_aksi']);
 					
 					if (isset($_POST['id']) AND isset($_POST['kode_barang_tujuan'])) {
 							
 						$id = angkadoang($_POST['id']);

 						$kode_barang = stringdoang($_POST['kode_barang_tujuan']);
 								 			$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_keluar FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur' AND kode_barang = '$kode_barang' ");
						$row_hpp_keluar = mysqli_fetch_array($hpp_keluar);

						$query_tbs_transfer_stok = $db->query("SELECT SUM(jumlah) AS jumlah_barang FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur' AND (session_id IS NULL OR session_id = '') AND kode_barang_tujuan = '$kode_barang' AND id != '$id'  ");

			    		$data_tbs_transfer_stok = mysqli_fetch_array($query_tbs_transfer_stok);

			    		$jumlah_tbs = $data_tbs_transfer_stok['jumlah_barang'];

 						}

		    		if ($jenis_aksi == 'Edit') {

 						$jumlah_baru = stringdoang($_POST['jumlah_baru']);

 						$hitung_jumlah = $jumlah_tbs + $jumlah_baru;

 						echo $total = $hitung_jumlah - $row_hpp_keluar['jumlah_keluar'];

		    		}
		    		elseif ($jenis_aksi == 'Hapus') {
		    			echo$total = $jumlah_tbs - $row_hpp_keluar['jumlah_keluar'];
		    		}else{


						$hpp_keluar = $db->query("SELECT no_faktur FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$no_faktur'");
						$row_hpp_keluar = mysqli_num_rows($hpp_keluar);

						if ($row_hpp_keluar > 0) {

							echo 1;
						}
						else{
							echo 0;
						}


		    		}
						

			

 
    mysqli_close($db); 
        
  ?>


