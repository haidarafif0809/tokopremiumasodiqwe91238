<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];
$kode_barang = $_POST['kode_barang'];



$query1 = $db->query("SELECT * FROM tbs_pembelian WHERE kode_barang = '$kode_barang'");
$cek =mysqli_fetch_array($query1);



$jumlah = $cek['jumlah_barang'];


    	


//menghapus se+uruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM tbs_pembelian WHERE id = '$id'");

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

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];
$kode_barang = $_POST['kode_barang'];



$query1 = $db->query("SELECT * FROM tbs_pembelian WHERE kode_barang = '$kode_barang'");
$cek =mysqli_fetch_array($query1);



$jumlah = $cek['jumlah_barang'];


    	


//menghapus se+uruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM tbs_pembelian WHERE id = '$id'");

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

<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];


//menghapus se+uruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM tbs_pembelian WHERE id = '$id'");

//jika $query benar maka akan menuju file formpembelian.php , jika salah maka failed
if ($query == TRUE)
{

echo "1";
}
else
{
	
	}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>