<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = date('Y-m-d');
 


//select untuk mengambil harga_jualnormal barang dan harga disc yang ada di tbsbonus
$tb = $db->query("SELECT pp.harga_disc,pp.qty_bonus,b.harga_jual,pp.id as idne, pp.kode_produk, pp.keterangan FROM tbs_bonus_penjualan pp LEFT JOIN barang b ON pp.kode_produk = b.kode_barang WHERE pp.session_id = '$session_id' AND pp.tanggal = '$tanggal_sekarang' ORDER BY pp.id");
$tbse = mysqli_fetch_array($tb);

//cek ada tidaknya bonus 
$tbsbonus = $db->query("SELECT * FROM tbs_bonus_penjualan WHERE tanggal = '$tanggal_sekarang' AND session_id = '$session_id' ORDER BY id");
$tbsbonusnya = mysqli_num_rows($tbsbonus);
if ($tbsbonusnya > 0){
  echo json_encode($tbse);
}
else {
echo 0;
}



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


