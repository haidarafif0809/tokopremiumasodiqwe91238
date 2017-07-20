<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = date('Y-m-d');

//cek subtotal di tbs penjualan
$query_tbs_penjualan = $db->query("SELECT sum(subtotal) as subto, sum(potongan) as pot FROM tbs_penjualan WHERE session_id = '$session_id'");
$data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan);
$subtotal_tbs_penjualan = round($data_tbs_penjualan['subto']);

//cek ada tidaknya barang di tbs_bonus saat ini  DISC PRODUK
$query_tbs_bonus_penjualan_disc = $db->query("SELECT kode_produk,keterangan FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND (keterangan = 'Disc Produk')");
$jumlah_data_query_tbs_bonus_penjualan_disc = mysqli_num_rows($query_tbs_bonus_penjualan_disc);

//cek ada tidaknya barang di tbs_bonus saat ini FREE PRODUK
$query_tbs_bonus_penjualan = $db->query("SELECT kode_produk,keterangan FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND (keterangan = 'Free Produk')");
$jumlah_data_query_tbs_bonus_penjualan = mysqli_num_rows($query_tbs_bonus_penjualan);

//mengambil / cek data ditbs adakah promo didalamnya (free produk) 
$query_tbs_penjualan_innerjoin = $db->query("SELECT b.harga_jual,pr.jenis_bonus,pr.id as id_program,b.id,sum(tp.subtotal) as sub_tp,pp.nama_produk,pr.syarat_belanja FROM tbs_penjualan tp INNER JOIN barang b ON tp.kode_barang = b.kode_barang INNER JOIN produk_promo pp ON b.id = pp.nama_produk INNER JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id");//  
$jumlah_data_tbs_penjualan_innerjoin = mysqli_num_rows($query_tbs_penjualan_innerjoin);
$data_tbs_penjualan_innerjoin = mysqli_fetch_array($query_tbs_penjualan_innerjoin);


//mengambil / cek data ditbs adakah promo dan telah terpenuhikah syarat promonya didalamnya (disc produk)
$query_promo_disc_produk = $db->query("SELECT pr.jenis_bonus,pr.id as id_program,pr.syarat_belanja, pp.harga_disc, pp.id as idnya,b.harga_jual , pp.qty_max ,pr.batas_akhir,pp.nama_produk FROM promo_disc_produk pp INNER JOIN program_promo pr ON pp.nama_program = pr.id INNER JOIN barang b ON pp.nama_produk = b.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pr.jenis_bonus = 'Disc Produk'");
$data_promo_disc_produk = mysqli_fetch_array($query_promo_disc_produk);

$syarat_promo_disc_produk = $data_promo_disc_produk['syarat_belanja'];
$subtotal_tbs_penjualan_difree = round($data_tbs_penjualan_innerjoin['sub_tp']);
$syarat_promo_free = $data_tbs_penjualan_innerjoin['syarat_belanja'];

$total_syarat_free = $subtotal_tbs_penjualan_difree - $syarat_promo_free;
$total_syarat_disc = $subtotal_tbs_penjualan - $syarat_promo_disc_produk;

if ($jumlah_data_query_tbs_bonus_penjualan_disc < 1 && $total_syarat_disc >= 0){

  $promo_disc_produk = array(
    'harga_jual_normal' => $data_promo_disc_produk['harga_jual'],
    'potongan_tbs_penjualan' => round($data_tbs_penjualan['pot']),    
    'subtotal_tbs_penjualan' => round($data_tbs_penjualan['subto']),  
    'jenis_bonus' => $data_promo_disc_produk['jenis_bonus'],
    'syarat_belanja' => $data_promo_disc_produk['syarat_belanja'],
    'harga_disc' => $data_promo_disc_produk['harga_disc'],
    'qty_max' => $data_promo_disc_produk['qty_max'],
    'id_program' => $data_promo_disc_produk['id_program']
   );
  echo json_encode($promo_disc_produk);
}
 
else if ($jumlah_data_query_tbs_bonus_penjualan < 1 && $jumlah_data_tbs_penjualan_innerjoin > 0 && $total_syarat_free >= 0 && $total_syarat_free != NULL){

  $promo_free_produk = array(
    'harga_jual' => $data_tbs_penjualan_innerjoin['harga_jual'],
    'jenis_bonus' => $data_tbs_penjualan_innerjoin['jenis_bonus'],    
    'id_program' => $data_tbs_penjualan_innerjoin['id_program'],  
    'id' => $data_tbs_penjualan_innerjoin['id'],
    'sub_tp' => round($data_tbs_penjualan_innerjoin['sub_tp']),
    'nama_produk' => $data_tbs_penjualan_innerjoin['nama_produk'],
    'syarat_belanja' => $data_tbs_penjualan_innerjoin['syarat_belanja'],
    'id_program' => $data_tbs_penjualan_innerjoin['id_program']
   );
  echo json_encode($promo_free_produk);
}

else {
echo 0;
}



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


