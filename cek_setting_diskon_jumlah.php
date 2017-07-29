<?php 
	include 'db.php';
	include 'sanitasi.php';
			

	$kode_barang = stringdoang($_GET['kode_barang']);
	$id_barang = angkadoang($_GET['id_produk']);
	$jumlah_barang = angkadoang($_GET['jumlah_barang']);
	$id_satuan = angkadoang($_GET['satuan_konversi']);
	$i = 0;
	$array_potongan = array();

        // QUERY CEK BARCODE DI SATUAN KONVERSI
                                    
        $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data,konversi FROM satuan_konversi WHERE kode_produk = '$kode_barang' AND id_produk = '$id_barang' AND id_satuan = '$id_satuan' ");
        $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);     

        // QUERY CEK BARCODE DI SATUAN KONVERSI
	
	     // IF CEK BARCODE DI SATUAN KONVERSI
                  if ($data_satuan_konversi['jumlah_data'] > 0) {//    if ($data_satuan_konversi['jumlah_data'] > 0) {
                    
                    $jumlah_produk = $jumlah_barang * $data_satuan_konversi['konversi'];

                                        
                  }else{
                      
                      $jumlah_produk = $jumlah_barang;

                  }

            // IF CEK BARCODE DI SATUAN KONVERSI      


     // ambil setting_diskon_jumlah yang selisih antara jumlah produk dan syarat jumlah lebih dari nol
	$query = $db->query("SELECT  potongan,  syarat_jumlah FROM setting_diskon_jumlah WHERE kode_barang = '$kode_barang' AND id_barang = '$id_barang' ");
	while ($data = mysqli_fetch_array($query)) {// while
				
				$i = $i + 1;

				$hitung = $jumlah_produk - $data['syarat_jumlah'];

				if ($hitung >= 0) {
									// masukan data ke dalam array
					$array = array("syarat_jumlah" => $data['syarat_jumlah'],"potongan" => $data['potongan']);

					array_push($array_potongan, $array);
				}else{
										// masukan data ke dalam array
					$array = array("syarat_jumlah" => 0,"potongan" => 0);

					array_push($array_potongan, $array);
				}		
		
	}// while
		

	if ($i == 0) {

			// ambil data yang paling besar
			echo '{"syarat_jumlah":"0","potongan":"0"}';

	}else{
			// ambil data yang paling besar
			$max = max($array_potongan);	
			echo json_encode($max);
	}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>