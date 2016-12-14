<?php 

include 'db.php';
include 'sanitasi.php';

$kode_barang =  stringdoang($_POST['kode_barang']);
$level_harga =  stringdoang($_POST['level_harga']);
$jumlah_barang =  stringdoang($_POST['jumlah_barang']);
$satuan_konversi =  stringdoang($_POST['satuan_konversi']);
$id_produk =  stringdoang($_POST['id_produk']);

 $query = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND id_produk = '$id_produk'");
 $data = mysqli_fetch_array($query);

$hasil = $jumlah_barang * $data['konversi'];


$query = $db->query("SELECT harga_jual, harga_jual2, harga_jual3 FROM barang WHERE kode_barang = '$kode_barang'");
$data_harga = mysqli_fetch_array($query);

if ($level_harga == 'Level 1') {
	 $harga = $data_harga['harga_jual'];
}
elseif ($level_harga == 'Level 2') {
	 $harga = $data_harga['harga_jual2'];
}
elseif ($level_harga == 'Level 3') {
	 $harga = $data_harga['harga_jual3'];
}

if ($data['konversi'] == '') {

echo $harga * $jumlah_barang;

}
else{
echo $harga * $hasil;
}


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
 ?>

