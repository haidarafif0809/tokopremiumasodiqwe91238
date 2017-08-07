<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

header("Content-type:application/json");

$status_hapus = 0;

$kode_barang = $_POST['kode_barang'];
$subtotal = $_POST['subtotal'];
$subtotal = hapus_koma_dua($subtotal);
$subtotal = angkadoang($subtotal);

$session_id = session_id();
$tanggal_sekarang = date('Y-m-d');

$arr = array();
$arr_diskon = array();   

$select_program_free = $db->query("SELECT id,jenis_bonus,syarat_belanja FROM program_promo WHERE batas_akhir >= '$tanggal_sekarang' AND jenis_bonus = 'Free Produk' ");
while ($data_program_free = mysqli_fetch_array($select_program_free)){

    $program = $data_program_free['id'];
    $jenis_bonus = $data_program_free['jenis_bonus'];
    $syarat_belanja = $data_program_free['syarat_belanja'];

   	$select_produk_promo = $db->query("SELECT b.kode_barang AS kode_barang_promo FROM produk_promo pro LEFT JOIN barang b ON pro.nama_produk = b.id WHERE nama_program = '$program'");
    while($data_produk_promo = mysqli_fetch_array($select_produk_promo)){
        $kode_barang_promo = $data_produk_promo['kode_barang_promo'];

    $query_tbs_penjualan = $db->query("SELECT SUM(subtotal) AS subtotal FROM tbs_penjualan WHERE kode_barang = '$kode_barang_promo' AND session_id = '$session_id'");
    $data_query_tbs = mysqli_fetch_array($query_tbs_penjualan);

    	if($data_query_tbs['subtotal'] < $syarat_belanja){


			$query_tbs_bonus = $db->query("SELECT kode_produk, nama_produk FROM tbs_bonus_penjualan WHERE keterangan = 'Free' GROUP BY kode_produk ");
			while($data_tbs_bonus = mysqli_fetch_array($query_tbs_bonus)){
			


			$query_hapus_tbs_bonus_penjualan_disk = $db->query("DELETE FROM tbs_bonus_penjualan WHERE kode_produk = '$data_tbs_bonus[kode_produk]' AND session_id = '$session_id' AND keterangan = 'Free'");

				$temp = array(
					"kode_barang" => $data_tbs_bonus['kode_produk'],
					"nama_barang" => $data_tbs_bonus['nama_produk']
				);

				array_push($arr, $temp);
				$status_hapus = $status_hapus + 1;

				

			}
    	}
  }
}




// DISKON PRODUK
$select_program_diskon = $db->query("SELECT id,jenis_bonus,syarat_belanja,nama_program FROM program_promo WHERE batas_akhir >= '$tanggal_sekarang' AND jenis_bonus = 'Disc Produk' ");
while ($data_program_diskon = mysqli_fetch_array($select_program_diskon)){

    $program = $data_program_diskon['id'];
    $jenis_bonus = $data_program_diskon['jenis_bonus'];
    $syarat_belanja = $data_program_diskon['syarat_belanja'];
    $nama_program = $data_program_diskon['nama_program'];
    
    if($subtotal < $syarat_belanja){

			$query_tbs_bonus_diskon = $db->query("SELECT kode_produk, nama_produk FROM tbs_bonus_penjualan WHERE keterangan = 'Diskon' GROUP BY kode_produk");
			while($data_tbs_bonus_diskon = mysqli_fetch_array($query_tbs_bonus_diskon)){



				$query_hapus_tbs_bonus_penjualan_disk = $db->query("DELETE FROM tbs_bonus_penjualan WHERE kode_produk = '$data_diskon[kode_barang]' AND session_id = '$session_id' AND keterangan = 'Diskon' ");


					$temp_diskon = array(
						"kode_barang" => $data_tbs_bonus_diskon['kode_produk'],
						"nama_barang" => $data_tbs_bonus_diskon['nama_produk']
					);

					array_push($arr_diskon, $temp_diskon);
					$status_hapus = $status_hapus + 1 ;
				


			}


         // 


                    
      
    }      
}


if($status_hapus > 0){
	echo 1;
}
else{
	echo 0;
}

	/*$gabungan_barang_free_diskon = array_merge($arr_diskon, $arr);

	$show = json_encode($gabungan_barang_free_diskon);
  
	echo '{ "status": "'.$status_hapus.'" ,"barang": '.$show.'}';*/




?>

