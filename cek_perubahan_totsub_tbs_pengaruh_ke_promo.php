<?php session_start();

include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
$tanggal_sekarang = $_GET['tanggal_sekarang'];

$kode_barang = stringdoang($_GET['kode_barang']);

//cek tbs_bonus dengan produk yang ada di program promo 
$free = $db->query("SELECT tp.id as idnya, tp.kode_produk as kodenya FROM tbs_bonus_penjualan tp LEFT JOIN barang b ON tp.kode_produk = b.kode_barang LEFT JOIN promo_disc_produk pdp ON b.id =  pdp.nama_produk LEFT JOIN program_promo pr ON pdp.nama_program = pr.id  WHERE pr.batas_akhir >= '$tanggal_sekarang' AND (tp.keterangan = 'Free Produk' OR tp.keterangan = 'Disc Produk')");
$tbsfree = mysqli_fetch_array($free);

//cek tbs penjualan
$tbspenjualan = $db->query("SELECT sum(subtotal) as sub FROM tbs_penjualan WHERE session_id = '$session_id'");
$datatbs = mysqli_fetch_array($tbspenjualan);


// cek query di promo_produk = disc produk
$querytb = $db->query("SELECT pp.id as idle, pr.id as lantaran, pr.nama_program as napro, b.id, pp.nama_produk,pr.syarat_belanja as syarate FROM produk_promo pp LEFT JOIN barang b ON pp.nama_produk = b.id LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id AND pr.jenis_bonus = 'Disc Produk' ");
$idtb = mysqli_fetch_array($querytb);

$subt = $datatbs['sub'];
$syarate = $idtb['syarate'];

//cek query di produk promo jenis program =  free produk
$querytbs = $db->query("SELECT pp.id as idle, pr.id as lantaran, pr.nama_program as napro, b.id, pp.nama_produk as nama ,pr.syarat_belanja as syarat FROM produk_promo pp LEFT JOIN barang b ON pp.nama_produk = b.id LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id AND pr.jenis_bonus = 'Free Produk' ");
$idtbs = mysqli_fetch_array($querytbs);

$produk = $idtbs['nama'];
$syarat = $idtbs['syarat'];

if ($produk > 0 && $subt <= $syarat){
	$subt = $datatbs['sub'];
	$idnya = $tbsfree['idnya'];
	$kodenya = $tbsfree['kodenya'];
	$idtbs['idle'] = $subt;
	$idtbs['lantaran'] = $idnya; 
	$idtbs['napro'] = $kodenya;
  echo json_encode($idtbs);
}

else if ($subt <= $syarate){
	$idnya = $tbsfree['idnya'];
	$kodenya = $tbsfree['kodenya'];
	$subt = $datatbs['sub'];
	$idtb['idle'] = $subt;
	$idtb['lantaran'] = $idnya; 
	$idtb['napro'] = $kodenya;
  echo json_encode($idtb);
}
else {
echo 0;
}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

