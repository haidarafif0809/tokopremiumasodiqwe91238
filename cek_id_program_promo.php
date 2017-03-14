<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = $_GET['tanggal_sekarang'];
 
$tbs = $db->query("SELECT sum(subtotal) as subto FROM tbs_penjualan WHERE session_id = '$session_id'");
$tbs_pen = mysqli_fetch_array($tbs);
$subto = $tbs_pen['subto'];

$querytb = $db->query("SELECT pr.jenis_bonus,pr.id as id_program,pr.syarat_belanja FROM promo_disc_produk pp LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pr.jenis_bonus = 'Disc Produk'");
$idtb = mysqli_fetch_array($querytb);

$syaratt = $idtb['syarat_belanja'];

 $querytbs = $db->query("SELECT pr.jenis_bonus,pr.id as id_program,b.id,sum(tp.subtotal) as sub_tp,pp.nama_produk,pr.syarat_belanja FROM tbs_penjualan tp LEFT JOIN barang b ON tp.kode_barang = b.kode_barang LEFT JOIN produk_promo pp ON b.id = pp.nama_produk LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id ");
$idtbs = mysqli_fetch_array($querytbs);
$produk = $idtbs['nama_produk'];
$sub = $idtbs['sub_tp'];
$syarat = $idtbs['syarat_belanja'];
if ($produk > 0 && $sub >= $syarat){

  echo json_encode($idtbs);
}
else if ($subto >= $syaratt){

  echo json_encode($idtb);
}

else {
echo 0;
}



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


