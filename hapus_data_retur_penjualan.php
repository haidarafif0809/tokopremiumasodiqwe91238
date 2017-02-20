<?php session_start();

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
	 $id = $_POST['id'];
	 $no_faktur_retur = $_POST['no_faktur_retur'];
	 $user = $_SESSION['user_name'];

	 
	$select = $db->query("SELECT no_faktur_penjualan,jumlah_retur,no_faktur_retur,kode_barang FROM detail_retur_penjualan ");
	$ambil = mysqli_fetch_array($select);

	$select0 = $db->query("SELECT sisa FROM detail_penjualan WHERE no_faktur = '$ambil[no_faktur_penjualan]' AND kode_barang = '$ambil[kode_barang]'");
	$ambil0 = mysqli_fetch_array($select0);

	$sisa = $ambil0['sisa'] + $ambil['jumlah_retur'];

	$update = $db->query("UPDATE detail_penjualan SET sisa = '$sisa' WHERE no_faktur = '$ambil[no_faktur_penjualan]'");

	


 // INSERT HISTORY RETUR PENJUALAN
$retur_penjualan = $db->query("SELECT * FROM retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
$data_retur_penjualan = mysqli_fetch_array($retur_penjualan);

$insert_retur_penjualan = $db->query("INSERT INTO history_retur_penjualan (no_faktur_retur, tanggal, jam, nama_barang, kode_pelanggan, keterangan, total, potongan, tax, user_buat, user_edit, tanggal_edit, cara_bayar, tunai, sisa, ppn, user_hapus) VALUES ('$no_faktur_retur', '$data_retur_penjualan[tanggal]', '$data_retur_penjualan[jam]', '$data_retur_penjualan[nama_barang]', '$data_retur_penjualan[kode_pelanggan]','$data_retur_penjualan[keterangan]','$data_retur_penjualan[total]', '$data_retur_penjualan[potongan]', '$data_retur_penjualan[tax]', '$data_retur_penjualan[user_buat]', '$data_retur_penjualan[user_edit]', '$data_retur_penjualan[tanggal_edit]', '$data_retur_penjualan[cara_bayar]', '$data_retur_penjualan[tunai]', '$data_retur_penjualan[sisa]', '$data_retur_penjualan[ppn]', '$user')");


// INSERT HISTORY DETAIL RETUR PENJUALAN
$detail_retur_penjualan = $db->query("SELECT * FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
while($data_detail_retur_penjualan = mysqli_fetch_array($detail_retur_penjualan)){

      $insert_retur_penjualan = "INSERT INTO history_detail_retur_penjualan (no_faktur_retur, no_faktur_penjualan, tanggal, jam, waktu, kode_barang, nama_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax, user_hapus) VALUES ('$no_faktur_retur', '$data_detail_retur_penjualan[no_faktur_penjualan]', '$data_detail_retur_penjualan[tanggal]', '$data_detail_retur_penjualan[jam]', '$data_detail_retur_penjualan[waktu]', '$data_detail_retur_penjualan[kode_barang]', '$data_detail_retur_penjualan[nama_barang]', '$data_detail_retur_penjualan[jumlah_beli]', '$data_detail_retur_penjualan[jumlah_retur]', '$data_detail_retur_penjualan[harga]', '$data_detail_retur_penjualan[subtotal]', '$data_detail_retur_penjualan[potongan]', '$data_detail_retur_penjualan[tax]', '$user')";

if ($db->query($insert_retur_penjualan) === TRUE) {
    
    } 

    else {
    echo "Error: " . $insert_retur_penjualan . "<br>" . $db->error;
}

} 


//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($insert_retur_penjualan == TRUE)
{
echo "sukses";
}
else
{
	
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
