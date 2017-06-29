<?php session_start();


    //mekeluarkan file db.php
    include 'sanitasi.php';
    include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal = stringdoang($_POST['tanggal']);
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');



 $query5 = $db->query("DELETE FROM detail_item_keluar WHERE no_faktur = '$no_faktur'");


    $query = $db->query("SELECT * FROM tbs_item_keluar WHERE no_faktur = '$no_faktur'");
    while ($data = mysqli_fetch_array($query))
    {

        $query2 = $db->query("INSERT INTO detail_item_keluar (no_faktur, tanggal,jam, kode_barang, nama_barang, jumlah, satuan, harga, subtotal)
        VALUES ('$no_faktur','$tanggal','$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$data[jumlah]','$data[satuan]','$data[harga]','$data[subtotal]')");
    }



$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
$total = $ambil_sum['total'];


  // buat prepared statements
        $stmt = $db->prepare("UPDATE item_keluar SET no_faktur = ?, tanggal = ?, total = ?, tanggal_edit = ?, jam = ?, user_edit = ?, keterangan = ? WHERE no_faktur = ?");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssisssss", 
        $no_faktur, $tanggal, $total , $tanggal, $jam_sekarang, $user_edit, $keterangan, $no_faktur);

  // siapkan "data" query
    $no_faktur = stringdoang($_POST['no_faktur']);
  
    $user_edit = $_SESSION['user_name'];
    $keterangan = stringdoang($_POST['keterangan']);

  // jalankan query
        $stmt->execute();


$query_delete_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur'");


$select_setting_akun = $db->query("SELECT persediaan,item_keluar FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Persediaan -', '$ambil_setting[persediaan]', '0', '$total', 'Item Keluar', '$no_faktur','1', '$user_edit', '$user_edit' )");

  //ITEM KELUAR    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Item Keluar -', '$ambil_setting[item_keluar]', '$total', '0', 'Item Masuk', '$no_faktur','1', '$user_edit' , '$user_edit')");



    $query3 = $db->query("DELETE  FROM tbs_item_keluar WHERE no_faktur = '$no_faktur'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>