<?php session_start();

//mekeluarkan file db.php
include 'db.php';
include 'sanitasi.php';

//mengirimkan $id menggunakan metode GET
$no_faktur = stringdoang($_POST['no_faktur']);
$user = $_SESSION['nama'];

 // INSERT HISTORY TRANSFER STOK
	$insert_transfer_stok = "INSERT INTO history_transfer_stok(no_faktur, tanggal, jam, user, user_edit, tanggal_edit, keterangan, total, waktu_input, user_hapus) SELECT no_faktur, tanggal, jam, user, user_edit, tanggal_edit, keterangan, total, waktu_input , '$user' FROM transfer_stok WHERE no_faktur = '$no_faktur'";

	        if ($db->query($insert_transfer_stok) === TRUE) {
                
            } else {
            echo "Error: " . $insert_transfer_stok . "<br>" . $db->error;
            }


// INSERT HISTORY DETAIL TRANSFER STOK
	$insert_detail_transfer_stok = "INSERT INTO history_detail_transfer_stok(no_faktur, tanggal, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, jam, waktu_input, user_hapus) SELECT no_faktur, tanggal, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, jam, waktu_input, '$user' FROM detail_transfer_stok WHERE no_faktur = '$no_faktur'";

	        if ($db->query($insert_detail_transfer_stok) === TRUE) {
                
            } else {
            echo "Error: " . $insert_detail_transfer_stok . "<br>" . $db->error;
            }

  // DELETE TRANSFE STOK 
  
  $delete_transfer_stok = $db->query("DELETE FROM transfer_stok WHERE no_faktur = '$no_faktur'");

  // DELETE DETAIL TRANSFER STOK 
  
  $delete_detail_transfer_stok = $db->query("DELETE FROM detail_transfer_stok WHERE no_faktur = '$no_faktur'");
         
  // DELETE DETAIL JURNAL _TRANS
  
  $delete_jurnal_trans = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur'");
         
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
