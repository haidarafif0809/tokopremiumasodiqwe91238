<?php session_start();

//memasukkan file db.php
include 'db.php';

	 $id = $_POST['id'];
	 $no_faktur_retur = $_POST['no_faktur_retur'];
	  $user = $_SESSION['user_name'];
	 
	$select = $db->query("SELECT no_faktur_pembelian,jumlah_retur,no_faktur_retur FROM detail_retur_pembelian ");
	$ambil = mysqli_fetch_array($select);

	$select0 = $db->query("SELECT sisa FROM detail_pembelian WHERE no_faktur = '$ambil[no_faktur_pembelian]'");
	$ambil0 = mysqli_fetch_array($select0);

	$sisa = $ambil0['sisa'] + $ambil['jumlah_retur'];

	$update = $db->query("UPDATE detail_pembelian SET sisa = '$sisa' WHERE no_faktur = '$ambil[no_faktur_pembelian]'");


 // INSERT HISTORY RETUR PEMBELIAN
$retur_pembelian = $db->query("SELECT * FROM retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");
$data_retur_pembelian = mysqli_fetch_array($retur_pembelian);

$insert_retur_pembelian = $db->query("INSERT INTO history_retur_pembelian (no_faktur_retur, tanggal, jam, nama_barang, nama_suplier, keterangan, total, potongan, tax, user_buat, user_edit, tanggal_edit, cara_bayar, tunai, sisa, ppn, user_hapus) VALUES ('$no_faktur_retur', '$data_retur_pembelian[tanggal]', '$data_retur_pembelian[jam]', '$data_retur_pembelian[nama_barang]', '$data_retur_pembelian[nama_suplier]','$data_retur_pembelian[keterangan]','$data_retur_pembelian[total]', '$data_retur_pembelian[potongan]', '$data_retur_pembelian[tax]', '$data_retur_pembelian[user_buat]', '$data_retur_pembelian[user_edit]', '$data_retur_pembelian[tanggal_edit]', '$data_retur_pembelian[cara_bayar]', '$data_retur_pembelian[tunai]', '$data_retur_pembelian[sisa]', '$data_retur_pembelian[ppn]', '$user')");


// INSERT HISTORY DETAIL RETUR PEMBELIAN
$detail_retur_pembelian = $db->query("SELECT * FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");
while($data_detail_retur_pembelian = mysqli_fetch_array($detail_retur_pembelian)){

      $insert_retur_pembelian = "INSERT INTO history_detail_retur_pembelian (no_faktur_retur, no_faktur_pembelian, tanggal, jam, kode_barang, nama_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax, user_hapus) VALUES ('$no_faktur_retur', '$data_detail_retur_pembelian[no_faktur_pembelian]', '$data_detail_retur_pembelian[tanggal]', '$data_detail_retur_pembelian[jam]', '$data_detail_retur_pembelian[kode_barang]', '$data_detail_retur_pembelian[nama_barang]', '$data_detail_retur_pembelian[jumlah_beli]', '$data_detail_retur_pembelian[jumlah_retur]', '$data_detail_retur_pembelian[harga]', '$data_detail_retur_pembelian[subtotal]', '$data_detail_retur_pembelian[potongan]', '$data_detail_retur_pembelian[tax]', '$user')";

if ($db->query($insert_retur_pembelian) === TRUE) {
    
    } 

    else {
    echo "Error: " . $insert_retur_pembelian . "<br>" . $db->error;
}

}


//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($insert_retur_pembelian == TRUE)
{
echo "sukses";
}
else
{
	
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
