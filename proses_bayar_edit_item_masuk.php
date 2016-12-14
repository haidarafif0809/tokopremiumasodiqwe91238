<?php session_start();


    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:sa');


$delete_detail_item_masuk = $db->query("DELETE FROM detail_item_masuk WHERE no_faktur = '$no_faktur' ");


  // buat prepared statements
        $stmt = $db->prepare("UPDATE item_masuk SET no_faktur = ?, tanggal = ?, total = ?, tanggal_edit = ?, jam = ?, user_edit = ?, keterangan = ? WHERE no_faktur = ?");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssisssss", 
        $no_faktur, $tanggal, $total, $tanggal_sekarang, $jam_sekarang, $user_edit, $keterangan, $no_faktur);

  // siapkan "data" query
    $no_faktur = stringdoang($_POST['no_faktur']);
    $total = angkadoang($_POST['total']);
    $user_edit = $_SESSION['user_name'];
    $keterangan = stringdoang($_POST['keterangan']);
    $tanggal = stringdoang($_POST['tanggal']);
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:sa');

  // jalankan query
        $stmt->execute();


    $query = $db->query("SELECT * FROM tbs_item_masuk WHERE no_faktur = '$no_faktur'");
    while ($data = mysqli_fetch_array($query))
    {

             
            $query2 = "INSERT INTO detail_item_masuk (no_faktur, tanggal, kode_barang, nama_barang, jumlah, satuan, harga, subtotal, jam, waktu) 
            VALUES ('$data[no_faktur]','$tanggal','$data[kode_barang]','$data[nama_barang]','$data[jumlah]','$data[satuan]','$data[harga]','$data[subtotal]','$jam_sekarang','$waktu')";
                if ($db->query($query2) === TRUE) 
                {
                       } 
                       
                       else {
                       echo "Error: " . $query2 . "<br>" . $db->error;
                       }
            
   
        
    }


//JURNAL TRANSAKSI
$ambil_tbs = $db->query("SELECT SUM(subtotal) AS subtotal FROM tbs_item_masuk WHERE no_faktur = '$no_faktur'");
$data_tbs = mysqli_fetch_array($ambil_tbs);
$subtotal_tbs = $data_tbs['subtotal'];

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);



  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Persediaan -', '$ambil_setting[persediaan]', '$subtotal_tbs', '0', 'Item Masuk', '$no_faktur','1', '$user_edit', '$user_edit')");

  //ITEM MASUK    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Item Masuk -', '$ambil_setting[item_masuk]', '0', '$subtotal_tbs', 'Item Masuk', '$no_faktur','1', '$user_edit', '$user_edit')");

//</>END JURNAL TRANSAKSI


    $query3 = $db->query("DELETE  FROM tbs_item_masuk WHERE no_faktur = '$no_faktur'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>