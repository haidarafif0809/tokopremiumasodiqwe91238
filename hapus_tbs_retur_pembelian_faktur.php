<?php 
//memasukan file db.php
include 'db.php';

$id = $_POST['id'];
$kode_barang = $_POST['kode_barang'];
$no_faktur_pembelian = $_POST['no_faktur_pembelian'];




$query1 = $db->query("SELECT * FROM tbs_retur_pembelian WHERE kode_barang = '$kode_barang' AND no_faktur_pembelian = '$no_faktur_pembelian'");
$cek = mysqli_fetch_array($query1);

echo $jumlah = $cek['jumlah_retur'];


    	
$query2 = $db->query("UPDATE detail_pembelian SET sisa = sisa + '$jumlah' WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur_pembelian'");


//menghapus seluruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM tbs_retur_pembelian WHERE id = '$id'");

//jika $query benar maka akan menuju file formpembelian.php , jika salah maka failed
if ($query == TRUE)
{
echo "sukses";
}
else
{
	
	}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
