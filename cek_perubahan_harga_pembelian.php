<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();

 		$query = $db->query("SELECT harga,kode_barang,jumlah_barang,satuan FROM tbs_pembelian WHERE session_id = '$session_id' AND no_faktur IS NULL");
    	while ($data = mysqli_fetch_array($query)){

				//Cek apakah barang tersebut memiliki Konversi ?
		        $query_cek_satuan_konversi = $db->query("SELECT konversi,harga_pokok FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
		        $data_jumlah = mysqli_num_rows($query_cek_satuan_konversi);

		        if($data_jumlah > 0){


 					$query_konv = $db->query("SELECT konversi,harga_pokok FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]' AND harga_pokok > '$data[harga]'");
		       		$data_konv = mysqli_num_rows($query_konv);

				      if($data_konv > 0){
				         echo 1; // ada perubahan harga di atas harga sebelumnya
				      }
				      else{

	 						$query_konv_minus = $db->query("SELECT konversi,harga_pokok FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]' AND harga_pokok < '$data[harga]'");
			       			$data_konv_minus = mysqli_num_rows($query_konv_minus);
			       			
			       			if($data_konv_minus > 0){
					         	echo 2; // ada perubahan di bawah harga sebelumnya
					      	}
					      	else{
					      		echo 3;// tidak ada perubahan harga beli apapun
					      	}

				      }

		        }
		        else{

		        	//Barang yang tidak Terkonversi di periksa di sini !!

					$harga_tbs = $data['harga'];

					$query_produk = $db->query("SELECT kode_barang,harga_beli,harga_jual FROM barang WHERE kode_barang = '$data[kode_barang]'");
					while($data_produk = mysqli_fetch_array($query_produk)){

						if($data_produk['harga_beli'] != $harga_tbs){

							if($data_produk['harga_jual'] < $harga_tbs){
								echo 1; // ada perubahan harga di atas harga sebelumnya
							}
							else{
								echo 2; // ada perubahan di bawah harga sebelumnya
							}
						}
						else{

							echo 3; // tidak ada perubahan harga 
						}

					}

	    		}
	       }
	   
 ?>