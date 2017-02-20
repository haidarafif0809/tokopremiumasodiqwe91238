<?php session_start();

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$no_faktur = $_POST['no_faktur'];
$user = $_SESSION['user_name'];

 // INSERT HISTORY STOK OPNAME
$stok_opname = $db->query("SELECT * FROM stok_opname WHERE no_faktur = '$no_faktur'");
$data_stok_opname = mysqli_fetch_array($stok_opname);

$insert_stok_opname = $db->query("INSERT INTO history_stok_opname (no_faktur, tanggal, jam, status, keterangan, total_selisih,hpp, user, user_hapus) VALUES ('$no_faktur','$data_stok_opname[keterangan]','$data_stok_opname[total_selisih]','$data_stok_opname[status]', '$data_stok_opname[tanggal]','$data_stok_opname[jam]', '$data_stok_opname[hpp]', '$data_stok_opname[user]', '$user')");


// INSERT HISTORY DETAIL STOK OPNAME
$detail_stok_opname = $db->query("SELECT * FROM detail_stok_opname WHERE no_faktur = '$no_faktur'");
while($data_detail_stok_opname = mysqli_fetch_array($detail_stok_opname)){

      $insert_stok_opname = $db->query("INSERT INTO history_detail_stok_opname (no_faktur, tanggal, jam, kode_barang, nama_barang, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp, user_hapus) VALUES ('$no_faktur', '$data_detail_stok_opname[tanggal]', '$data_detail_stok_opname[jam]', '$data_detail_stok_opname[kode_barang]', '$data_detail_stok_opname[nama_barang]', '$data_detail_stok_opname[awal]', '$data_detail_stok_opname[masuk]', '$data_detail_stok_opname[keluar]', '$data_detail_stok_opname[stok_sekarang]', '$data_detail_stok_opname[fisik]', '$data_detail_stok_opname[selisih_fisik]', '$data_detail_stok_opname[selisih_harga]', '$data_detail_stok_opname[harga]', '$data_detail_stok_opname[hpp]', '$user')");

} 


//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($insert_stok_opname == TRUE)
{
      echo "sukses";
}
else
{

}

            //Untuk Memutuskan Koneksi Ke Database
            mysqli_close($db);   
?>