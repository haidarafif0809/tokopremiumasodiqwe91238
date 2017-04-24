<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = date('Y-m-d');
 


//select untuk mengambil harga_jualnormal barang dan harga disc yang ada di tbsbonus
$query_tbs_bonus_penjualan = $db->query("SELECT pp.harga_disc,pp.qty_bonus,b.harga_jual,pp.id as idne, pp.kode_produk, pp.keterangan FROM tbs_bonus_penjualan pp LEFT JOIN barang b ON pp.kode_produk = b.kode_barang WHERE pp.session_id = '$session_id' AND pp.tanggal = '$tanggal_sekarang' ORDER BY pp.id");
$jumlah_data_tbs_bonus_penjualan = mysqli_num_rows($query_tbs_bonus_penjualan);
$data_tbs_bonus_penjualan = mysqli_fetch_array($query_tbs_bonus_penjualan);

if ($jumlah_data_tbs_bonus_penjualan > 0){
  echo json_encode($data_tbs_bonus_penjualan);
}
else {
echo 0;
}



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


