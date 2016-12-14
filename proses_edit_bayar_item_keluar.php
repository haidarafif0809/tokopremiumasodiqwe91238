<?php session_start();


    //mekeluarkan file db.php
    include 'sanitasi.php';
    include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:sa');


 $query5 = $db->query("DELETE FROM detail_item_keluar WHERE no_faktur = '$no_faktur'");

  // buat prepared statements
        $stmt = $db->prepare("UPDATE item_keluar SET no_faktur = ?, tanggal = ?, total = ?, tanggal_edit = ?, jam = ?, user_edit = ?, keterangan = ? WHERE no_faktur = ?");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssisssss", 
        $no_faktur, $tanggal, $total , $tanggal_sekarang, $jam_sekarang, $user_edit, $keterangan, $no_faktur);

  // siapkan "data" query
    $no_faktur = stringdoang($_POST['no_faktur']);
    $tanggal = stringdoang($_POST['tanggal']);
    $total = angkadoang($_POST['total']);
    $user_edit = $_SESSION['user_name'];
    $keterangan = stringdoang($_POST['keterangan']);

  // jalankan query
        $stmt->execute();



    $query = $db->query("SELECT * FROM tbs_item_keluar WHERE no_faktur = '$no_faktur'");
    while ($data = mysqli_fetch_array($query))
    {

        $query2 = $db->query("INSERT INTO detail_item_keluar (no_faktur, tanggal, kode_barang, nama_barang, jumlah, satuan, harga, subtotal) 
		VALUES ('$data[no_faktur]',now(),'$data[kode_barang]','$data[nama_barang]','$data[jumlah]','$data[satuan]','$data[harga]','$data[subtotal]')");
    }



$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
$total = $ambil_sum['total'];

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Persediaan -', '$ambil_setting[persediaan]', '0', '$total', 'Item Keluar', '$no_faktur','1', '$user_edit', '$user_edit' )");

  //ITEM KELUAR    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Item Keluar -', '$ambil_setting[item_keluar]', '$total', '0', 'Item Masuk', '$no_faktur','1', '$user_edit' , '$user_edit')");



    $query3 = $db->query("DELETE  FROM tbs_item_keluar WHERE no_faktur = '$no_faktur'");
    echo "Success";


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>