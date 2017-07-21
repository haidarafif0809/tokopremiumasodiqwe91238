<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = date('Y-m-d');
 
/*$tbspenjualan = $db->query("SELECT sum(subtotal) as subto FROM tbs_penjualan WHERE session_id = '$session_id' and tanggal = '$tanggal_sekarang'");
$tbs_penjualan = mysqli_fetch_array($tbspenjualan);
$subto = $tbs_penjualan['subto'];


//mengambil / cek data ditbs adakah promo didalamnya (free produk)  ==start
$querytbsnya = $db->query("SELECT pp.nama_produk FROM tbs_penjualan tp LEFT JOIN barang b ON tp.kode_barang = b.kode_barang LEFT JOIN produk_promo pp ON b.id = pp.nama_produk LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id ");
$idtbsnya = mysqli_num_rows($querytbsnya);

//cek syarat belanja di tbs penjualan promo freeproduk
 $querytbs = $db->query("SELECT sum(tp.subtotal) as sub_tp, pr.jenis_bonus,pr.syarat_belanja FROM tbs_penjualan tp LEFT JOIN barang b ON tp.kode_barang = b.kode_barang LEFT JOIN produk_promo pp ON b.id = pp.nama_produk LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id ");
$idtbs = mysqli_fetch_array($querytbs);// ==end

$sub = $idtbs['sub_tp'];
$syarat = $idtbs['syarat_belanja'];

//mengambil / cek data ditbs adakah promo dan telah terpenuhikah syarat promonya didalamnya (disc produk)
$querytb = $db->query("SELECT pr.jenis_bonus,pr.syarat_belanja FROM promo_disc_produk pp LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pr.jenis_bonus = 'Disc Produk'");
$idtb = mysqli_fetch_array($querytb);

$syaratt = $idtb['syarat_belanja'];



//mengambil / cek data ditbsbonus (disc produk/free) 
$querytbsbonus = $db->query("SELECT kode_produk,keterangan,id, tanggal,jam,satuan,harga_disc,nama_produk,kode_pelanggan FROM tbs_bonus_penjualan WHERE tanggal = '$tanggal_sekarang' AND session_id = '$session_id' ORDER BY id");
$tbsbonus = mysqli_fetch_array($querytbsbonus);

if (($sub < $syarat) || $subto < $syaratt){

	$tbsbonus['jam'] = $idtbsnya;
	$tbsbonus['satuan'] = $sub;
	$tbsbonus['harga_disc'] = $syarat;
	$tbsbonus['kode_pelanggan'] = $syaratt;
  echo json_encode($tbsbonus);
}
else {
echo 0;
}
*/

$query_tbs_penjualan = $db->query("SELECT sum(subtotal) as subto FROM tbs_penjualan WHERE session_id = '$session_id' and tanggal = '$tanggal_sekarang'");
$data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan);

//cek syarat belanja di tbs penjualan promo freeproduk
 $query_tbs_penjualan_innerjoin = $db->query("SELECT pp.nama_produk,sum(tp.subtotal) as sub_tp, pr.jenis_bonus,pr.syarat_belanja FROM tbs_penjualan tp INNER JOIN barang b ON tp.kode_barang = b.kode_barang INNER JOIN produk_promo pp ON b.id = pp.nama_produk INNER JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id ");
$jumlah_tbs_penjualan_innerjoin = mysqli_num_rows($query_tbs_penjualan_innerjoin);
$data_tbs_penjualan_innerjoin = mysqli_fetch_array($query_tbs_penjualan_innerjoin);// ==end


//mengambil / cek data ditbs adakah promo dan telah terpenuhikah syarat promonya didalamnya (disc produk)
$query_promo_disc_produk = $db->query("SELECT pr.jenis_bonus,pr.syarat_belanja FROM promo_disc_produk pp INNER JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pr.jenis_bonus = 'Disc Produk'");
$data_promo_disc_produk = mysqli_fetch_array($query_promo_disc_produk);


//mengambil / cek data ditbsbonus (disc produk/free) 
$query_tbs_bonus = $db->query("SELECT kode_produk,keterangan,id,nama_produk FROM tbs_bonus_penjualan WHERE session_id = '$session_id'");
$jumlah_data_tbs_bonus = mysqli_num_rows($query_tbs_bonus);
$data_tbs_bonus = mysqli_fetch_array($query_tbs_bonus);

$subtotal_tbs_penjualan = $data_tbs_penjualan['subto'];
$syarat_promo_disc_produk = $data_promo_disc_produk['syarat_belanja'];
$subtotal_tbs_penjualan_difree = round($data_tbs_penjualan_innerjoin['sub_tp']);
$syarat_promo_free = $data_tbs_penjualan_innerjoin['syarat_belanja'];

/*$total_syarat_free = subtotal_tbs_penjualan_difree < syarat_promo_free;
$total_syarat_disc = subtotal_tbs_penjualan < syarat_promo_disc_produk;*/


if (($subtotal_tbs_penjualan_difree < $syarat_promo_free) || ($subtotal_tbs_penjualan < $syarat_promo_disc_produk)){

	$promo_produk = array(
    'subtotal_tbs_penjualan' => round($data_tbs_penjualan['subto']),
	'syarat_promo_disc_produk' => $data_promo_disc_produk['syarat_belanja'],
	'subtotal_tbs_penjualan_difree' => round($data_tbs_penjualan_innerjoin['sub_tp']),
	'syarat_promo_free' => $data_tbs_penjualan_innerjoin['syarat_belanja'],
    'kode_produk' =>$data_tbs_bonus['kode_produk'],
	'id' => $data_tbs_bonus['id'],
	'nama_produk' =>$data_tbs_bonus['nama_produk']
   );
  echo json_encode($promo_produk);
}
else{
	 $promo_produk = 'NULL';
	echo json_encode($promo_produk);
}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


