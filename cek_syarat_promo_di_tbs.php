<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = date('Y-m-d');
 
$tbspenjualan = $db->query("SELECT sum(subtotal) as subto FROM tbs_penjualan WHERE session_id = '$session_id' and tanggal = '$tanggal_sekarang'");
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

if (($idtbsnya > 0 && $sub < $syarat && $tbsbonus['keterangan'] == 'Free Produk') || $subto < $syaratt){

	$tbsbonus['tanggal'] = $subto;
	$tbsbonus['jam'] = $idtbsnya;
	$tbsbonus['satuan'] = $sub;
	$tbsbonus['harga_disc'] = $syarat;
	$tbsbonus['kode_pelanggan'] = $syaratt;
  echo json_encode($tbsbonus);
}
else {
echo 0;
}



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


