<?php session_start();
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';

//mengirimkan $id menggunakan metode GET

$id = stringdoang($_POST['id']);
$kode_barang = stringdoang($_POST['kode_barang']);
$session_id = session_id();
$i = 0;
$array_potongan = array();

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_penjualan_order WHERE id = '$id'");

$query2 = $db->query("DELETE FROM tbs_fee_produk WHERE kode_produk = '$kode_barang'");

     // UNTUK MENGETAHUI JUMLAAH TBS SEBENARNYA
    $jumlah_tbs = 0;
    $potongan_tbs_order = 0;

    if (isset($_POST['no_faktur_order'])) {

    $no_faktur_order = stringdoang($_POST['no_faktur_order']);

    $query_stok_tbs = $db->query("SELECT jumlah_barang,satuan, subtotal, potongan FROM tbs_penjualan_order WHERE kode_barang = '$kode_barang' AND no_faktur_order = '$no_faktur_order' ");
    }
    else{

    $query_stok_tbs = $db->query("SELECT jumlah_barang,satuan, potongan FROM tbs_penjualan_order WHERE kode_barang = '$kode_barang' AND session_id = '$session_id' ");	
    }

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
	$query = $db->query("SELECT  potongan,  syarat_jumlah FROM setting_diskon_jumlah WHERE kode_barang = '$kode_barang' ");
	while ($data = mysqli_fetch_array($query)) {// while
				
				$i = $i + 1;

				$hitung = $jumlah_tbs - $data['syarat_jumlah'];

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

                }else{


                          
                   $potongan_tampil;  
                                  
                }


			    if (isset($_POST['no_faktur_order'])) {
			    	
			    		$no_faktur_order = stringdoang($_POST['no_faktur_order']);

			              $query1 = $db->prepare("UPDATE tbs_penjualan_order SET subtotal = subtotal - $potongan_tampil , potongan = ? WHERE kode_barang = ? AND no_faktur_order = ? LIMIT 1 ");

                          $query1->bind_param("iss",
                          $potongan_tampil,$kode_barang, $no_faktur_order);

                          $query1->execute();  
		      	 }else{

		      	         
		      	         $query1 = $db->prepare("UPDATE tbs_penjualan_order SET subtotal = subtotal - $potongan_tampil , potongan = ? WHERE kode_barang = ? AND session_id = ? LIMIT 1 ");

                          $query1->bind_param("iss",
                          $potongan_tampil,$kode_barang, $session_id);

                          $query1->execute();  	
		      	 }                                       # code...



if (isset($_POST['no_faktur_order'])) {
  
    $no_faktur = stringdoang($_POST['no_faktur_order']);
// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query_total = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan_order WHERE no_faktur_order = '$no_faktur'");

}else{


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query_total = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan_order WHERE session_id = '$session_id'");
}
 
 // menyimpan data sementara yg ada pada $query
 $data_total = mysqli_fetch_array($query_total);
 $total = $data_total['total_penjualan'];


echo$total;
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>