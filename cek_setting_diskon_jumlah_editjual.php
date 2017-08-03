<?php session_start();
	include 'db.php';
	include 'sanitasi.php';
			
	$session_id = session_id();
	$id = angkadoang($_GET['id']);
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

    // UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA
    $jumlah_tbs = 0;
    $potongan_tbs_order = 0;
    $query_stok_tbs = $db->query("SELECT jumlah_barang,satuan, subtotal, potongan FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id' AND id != '$id' ");
    while($data_stok_tbs = mysqli_fetch_array($query_stok_tbs)){

      $query_cek_satuan_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE kode_produk = '$kode_barang' AND id_satuan = '$data_stok_tbs[satuan]' ");
      $data_cek_satuan_konversi = mysqli_fetch_array($query_cek_satuan_konversi);

        $konversi = $data_cek_satuan_konversi['konversi'];
        if ($konversi == '') {
          $konversi = 1;
        }
        $jumlah_tbs_penjualan = $data_stok_tbs['jumlah_barang'] * $konversi;

        $jumlah_tbs = $jumlah_tbs_penjualan + $jumlah_tbs;
        $potongan_tbs_order = $potongan_tbs_order + $data_stok_tbs['potongan'];

    }
  //  UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA

     // ambil setting_diskon_jumlah yang selisih antara jumlah produk dan syarat jumlah lebih dari nol
	$query = $db->query("SELECT  potongan,  syarat_jumlah FROM setting_diskon_jumlah WHERE kode_barang = '$kode_barang' AND id_barang = '$id_barang' ");
	while ($data = mysqli_fetch_array($query)) {// while
				
				$i = $i + 1;

				$hitung = ($jumlah_tbs + $jumlah_produk) - $data['syarat_jumlah'];

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
     $potongan_tampil = 0;
		komarupiah($potongan_tampil,2);

	}else{
			                    // ambil data yang paling besar
                    $max = max($array_potongan);  
                    // ubah data dalam ventuk json encode
                    $json_encode = json_encode($max);
                    // ingin membaca format JSON di PHP maka JSON harus di convert ke Array Object dengan menggunakan json_decode
                    $data = json_decode($json_encode);   
                    // akan tampil potongan                
                    $potongan_tampil = $data->potongan;
	           }

                if ($potongan_tbs_order == $potongan_tampil) {
                	 
                    $potongan_tampil = 0;
                   komarupiah($potongan_tampil,2);


                }else{
                                              # code...
                          $query1 = $db->prepare("UPDATE tbs_penjualan SET subtotal = subtotal + potongan, potongan = 0 WHERE kode_barang = ? AND session_id = ? ");

                          $query1->bind_param("ss",
                          $kode_barang, $session_id);

                          $query1->execute();  
                          
                          komarupiah($potongan_tampil,2);
                                  
                }

echo '{ "status": "'.$i.'" ,"potongan": "'.komarupiah($potongan_tampil,2).'"}';


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>