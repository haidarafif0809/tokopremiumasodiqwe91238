<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = date('Y-m-d');

//cek subtotal di tbs penjualan
$tbs = $db->query("SELECT sum(subtotal) as subto,sum(potongan) as pot FROM tbs_penjualan WHERE session_id = '$session_id'");
$tbs_pen = mysqli_fetch_array($tbs);
$subto = $tbs_pen['subto'];

//cek ada tidaknya barang di tbs_bonus saat ini
$tbsbonuspenjualan = $db->query("SELECT kode_produk FROM tbs_bonus_penjualan WHERE (session_id = '$session_id' AND keterangan = 'Disc Produk') OR (session_id = '$session_id' AND keterangan = 'Free Produk')");
$cek = mysqli_num_rows($tbsbonuspenjualan);

//mengambil / cek data ditbs adakah promo didalamnya (free produk)  ==start
$querytbsnya = $db->query("SELECT pp.nama_produk FROM tbs_penjualan tp LEFT JOIN barang b ON tp.kode_barang = b.kode_barang LEFT JOIN produk_promo pp ON b.id = pp.nama_produk LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id ");
$idtbsnya = mysqli_num_rows($querytbsnya);


 $querytbs = $db->query("SELECT b.harga_jual,pr.jenis_bonus,pr.id as id_program,b.id,sum(tp.subtotal) as sub_tp,pp.nama_produk,pr.syarat_belanja FROM tbs_penjualan tp LEFT JOIN barang b ON tp.kode_barang = b.kode_barang LEFT JOIN produk_promo pp ON b.id = pp.nama_produk LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id ");
$idtbs = mysqli_fetch_array($querytbs);// ==end

//mengambil / cek data ditbs adakah promo dan telah terpenuhikah syarat promonya didalamnya (disc produk)
$querytb = $db->query("SELECT pr.jenis_bonus,pr.id as id_program,pr.syarat_belanja, pp.harga_disc, pp.id as idnya, pp.qty_max ,pr.batas_akhir FROM promo_disc_produk pp LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pr.jenis_bonus = 'Disc Produk' ORDER BY pp.id");
$idtb = mysqli_fetch_array($querytb);

$syaratt = $idtb['syarat_belanja'];

$sub = $idtbs['sub_tp'];
$syarat = $idtbs['syarat_belanja'];

if ($cek < 1 && $idtbsnya > 0 && $sub >= $syarat){

  echo json_encode($idtbs);
}
else if ($cek < 1 && $subto >= $syaratt){
	$harga = $idtbs['harga_jual'];
	$subto = $tbs_pen['subto'];
	$pot = $tbs_pen['pot'];
$idtb['nama_produk'] = $subto;
$idtb['id'] = $pot;
$idtb['batas_akhir'] = $harga;
  echo json_encode($idtb);
}

else {
echo 0;
}



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


