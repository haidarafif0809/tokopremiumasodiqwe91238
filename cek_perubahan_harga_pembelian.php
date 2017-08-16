<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();

 		$query = $db->query("SELECT harga,kode_barang,jumlah_barang,satuan FROM tbs_pembelian WHERE session_id = '$session_id'");
    	while ($data = mysqli_fetch_array($query)){

     		$query_barang = $db->query("SELECT harga_beli,satuan,harga_jual FROM barang WHERE kode_barang = '$data[kode_barang]'");
      		$data_barang = mysqli_fetch_array($query_barang);

			//Cek apakah barang tersebut memiliki Konversi ?
	        $query_cek_satuan_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
	        $data_jumlah_konversi = mysqli_fetch_array($query_cek_satuan_konversi);
	        $data_jumlah = mysqli_num_rows($query_cek_satuan_konversi);

	        if($data_jumlah > 0){

		        if($data_jumlah_konversi['konversi'] == ''){
		        	$jumlah_konversi = 0;
		        }
		        else{
		        	$jumlah_konversi = $data_jumlah_konversi['konversi'];
		        }

		        $hasil_konversi = $data['harga'] / $jumlah_konversi;
		        $hasil = round($hasil_konversi);
	          	
	          	$harga_beli_sebenarnya = $hasil; //Hasil akhir
	          	                         
	          	//Jika Iya maka ambil harga setelah di bagi dengan jumlah barang yang sebenarnya di konversi !!
			      if($harga_beli_sebenarnya > $data_barang['harga_jual']){
			         echo 1;
			      }
			      else{
			      	echo 2;
			      }

	        }
	        else{
				//Jika Tidak ambil harga yang sebenarnya dari TBS !!
	          	$harga_beli_sebenarnya = $data['harga'];
		      	if($harga_beli_sebenarnya > $data_barang['harga_jual']){
		      		echo 1;
		      	}
		      	else{
		      		echo 2;
		      	}
	        }
	        
	    }

 ?>