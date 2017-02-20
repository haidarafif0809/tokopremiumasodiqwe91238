<?php session_start();

// memsukan file db,php
include 'db.php';


$id = $_POST['id'];
$no_faktur_pembayaran = $_POST['no_faktur_pembayaran'];
$user = $_SESSION['user_name'];

    $tbs = $db->query("SELECT * FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
    while ($data_tbs = mysqli_fetch_array($tbs))
    {

       $query002 = $db->query("UPDATE penjualan SET kredit = kredit + '$data_tbs[potongan]' WHERE no_faktur = '$data_tbs[no_faktur_penjualan]'");
       
       $query003 = $db->query("UPDATE penjualan SET kredit = kredit + '$data_tbs[jumlah_bayar]' WHERE no_faktur = '$data_tbs[no_faktur_penjualan]'");
       
       $perintah2 = $db->query("UPDATE penjualan SET status = 'Lunas' WHERE kredit = 0 AND no_faktur = '$data_tbs[no_faktur_penjualan]'");  

    }


 // INSERT HISTORY PEMBAYARAN PIUTANG
$pembayaran_piutang = $db->query("SELECT * FROM pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
$data_pembayaran_piutang = mysqli_fetch_array($pembayaran_piutang);

$insert_pembayaran_piutang = $db->query("INSERT INTO history_pembayaran_piutang (no_faktur_pembayaran, tanggal, jam, nama_suplier, keterangan, total, user_buat, user_edit, tanggal_edit, dari_kas, user_hapus) VALUES ('$no_faktur_pembayaran','$data_pembayaran_piutang[tanggal]','$data_pembayaran_piutang[jam]','$data_pembayaran_piutang[nama_suplier]', '$data_pembayaran_piutang[keterangan]','$data_pembayaran_piutang[total]','$data_pembayaran_piutang[user_buat]','$data_pembayaran_piutang[user_edit]','$data_pembayaran_piutang[tanggal_edit]','$data_pembayaran_piutang[dari_kas]', '$user')");


// INSERT HISTORY DETAIL PEMBAYARAN PIUTANG
$detail_pembayaran_piutang = $db->query("SELECT * FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
while($data_detail_pembayaran_piutang = mysqli_fetch_array($detail_pembayaran_piutang)){

	$insert_pembayaran_piutang = $db->query("INSERT INTO history_detail_pembayaran_piutang (no_faktur_pembayaran, no_faktur_penjualan, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar, user_hapus) VALUES ('$no_faktur_pembayaran', '$data_detail_pembayaran_piutang[no_faktur_penjualan]', '$data_detail_pembayaran_piutang[tanggal]', '$data_detail_pembayaran_piutang[tanggal_jt]', '$data_detail_pembayaran_piutang[kredit]', '$data_detail_pembayaran_piutang[potongan]', '$data_detail_pembayaran_piutang[total]', '$data_detail_pembayaran_piutang[jumlah_bayar]', '$user')");

} 



if ($insert_pembayaran_piutang == TRUE)
{

echo "sukses";

}
else
{
	
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
