<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$nomor_free = 0;
$nomor_diskon = 0;

$kode_barang = $_POST['kode_barang'];
$subtotal = $_POST['subtotal'];
$subtotal = hapus_koma_dua($subtotal);
$subtotal = angkadoang($subtotal);

$session_id = session_id();
$tanggal_sekarang = date('Y-m-d');
                  
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

    if($data_query_tbs['subtotal'] >= $syarat_belanja){

        $query_bonus_free = $db->query("SELECT COUNT(id) AS jumlah FROM promo_free_produk WHERE nama_program = '$program' AND qty != '0'");

      	$data_free = mysqli_num_rows($query_bonus_free);
      	$nomor_free = $nomor_free + $data_free['jumlah'];

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
    
    if($subtotal >= $syarat_belanja){

      $query_bonus_diskon = $db->query("SELECT COUNT(id) AS jumlah FROM promo_disc_produk  WHERE nama_program = '$program' AND qty_max != '0'");
	    $data_diskon = mysqli_fetch_array($query_bonus_diskon);
	    $nomor_diskon = $nomor_diskon + $data_diskon['jumlah'];


	  }
  }

$nomor_diskon;
$nomor_free;

if($nomor_free > 0  OR $nomor_diskon > 0){
	echo 1;
}
  
mysqli_close($db); 

?>