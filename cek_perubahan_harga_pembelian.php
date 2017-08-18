<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();
    $perubahan_harga = 0;

 		$query = $db->query("SELECT harga,kode_barang,jumlah_barang,satuan FROM tbs_pembelian WHERE session_id = '$session_id' AND no_faktur IS NULL");
    	while ($data = mysqli_fetch_array($query)){

				//Cek apakah barang tersebut memiliki Konversi ?
		        $query_cek_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data,konversi,harga_pokok FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
		        $data_tampil_konvers = mysqli_fetch_array($query_cek_satuan_konversi);

		        if($data_tampil_konvers['jumlah_data'] > 0){

		        		if($data['harga'] != $data_tampil_konvers['harga_pokok']){

		        			$perubahan_harga = $perubahan_harga + 1;
			        	}
			        	else{

			        		$perubahan_harga = 0;
			        	}


		       	 }else{

		        		//Barang yang tidak Terkonversi di periksa di sini !!

							$harga_tbs = $data['harga'];

							$query_produk = $db->query("SELECT kode_barang,harga_beli,harga_jual FROM barang WHERE kode_barang = '$data[kode_barang]'");
							while($data_produk = mysqli_fetch_array($query_produk)){

								if($data_produk['harga_beli'] != $harga_tbs){

										$perubahan_harga = $perubahan_harga + 1;

								}else{

									$perubahan_harga = 0; 
									 }

							}
		        	}


	       }

	       echo $perubahan_harga;
	   
 ?>