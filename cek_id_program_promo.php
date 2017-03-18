<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = date('Y-m-d');
 
$tbs = $db->query("SELECT sum(subtotal) as subto,sum(potongan) as pot FROM tbs_penjualan WHERE session_id = '$session_id'");
$tbs_pen = mysqli_fetch_array($tbs);
$subto = $tbs_pen['subto'];



 $querytbs = $db->query("SELECT b.harga_jual,pr.jenis_bonus,pr.id as id_program,b.id,sum(tp.subtotal) as sub_tp,pp.nama_produk,pr.syarat_belanja FROM tbs_penjualan tp LEFT JOIN barang b ON tp.kode_barang = b.kode_barang LEFT JOIN produk_promo pp ON b.id = pp.nama_produk LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id ");
$idtbs = mysqli_fetch_array($querytbs);

$querytb = $db->query("SELECT pr.jenis_bonus,pr.id as id_program,pr.syarat_belanja, pp.harga_disc, pp.id as idnya, pp.qty_max ,pr.batas_akhir FROM promo_disc_produk pp LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pr.jenis_bonus = 'Disc Produk' ORDER BY pp.id");
$idtb = mysqli_fetch_array($querytb);

$syaratt = $idtb['syarat_belanja'];

$produk = $idtbs['nama_produk'];
$sub = $idtbs['sub_tp'];
$syarat = $idtbs['syarat_belanja'];

if ($produk > 0 && $sub >= $syarat){

  echo json_encode($idtbs);
}
else if ($subto >= $syaratt){
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


