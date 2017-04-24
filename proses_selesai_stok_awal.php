<?php session_start();


    //memasukkan file db.php
include 'db.php';
include 'sanitasi.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST
$user = $_SESSION['user_name'];
$session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);

$no_faktur_stok_awal = no_faktur_stok_awal();

    $perintah = $db->query ("INSERT INTO nomor_faktur_stok_awal (no_stok_awal,tanggal) VALUES ('$no_faktur_stok_awal','$tanggal_sekarang')");


$query6 = $db->query("SELECT * FROM tbs_stok_awal ");
    while ($data = mysqli_fetch_array($query6))
{

    $perintah = $db->query ("INSERT INTO stok_awal (no_faktur, kode_barang,nama_barang,jumlah_awal,satuan, harga,total,tanggal,jam, user) 
VALUES ('$no_faktur_stok_awal','$data[kode_barang]','$data[nama_barang]','$data[jumlah_awal]','$data[satuan]','$data[harga]','$data[total]','$tanggal_sekarang','$jam_sekarang','$user')");

        if ($db->query($perintah) === TRUE)
        {
					echo '<div class="alert alert-danger" id="alert_gagal" style="display:none">
					<strong>Gagal!</strong> Anda Belum Memasukan Data
					</div>';

        }
        else
        {
					echo '<div class="alert alert-success" id="alert_berhasil" style="display:none">
					<strong>Sukses!</strong> Penambahan Berhasil
					</div>';

        }

}



//JURNAL TRANSAKSI
$ambil_tbs = $db->query("SELECT SUM(total) AS total FROM tbs_stok_awal WHERE session_id = '$session_id'");
$data_tbs = mysqli_fetch_array($ambil_tbs);
$total_tbs = $data_tbs['total'];

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Awal -', '$ambil_setting[persediaan]', '$total_tbs', '0', 'Stok Awal', '$no_faktur_stok_awal','1', '$user')");

  //Stok Awal   
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Awal -', '$ambil_setting[stok_awal]', '0', '$total_tbs', 'Stok Awal', '$no_faktur_stok_awal','1', '$user')");

//</>END JURNAL TRANSAKSI



     $query3 = $db->query("DELETE FROM tbs_stok_awal ");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   


    ?>