<?php session_start();

        include 'sanitasi.php';
        include 'db.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$no_faktur = stringdoang($_POST['no_faktur']); 

$hapus_detail = $db->query("DELETE FROM detail_stok_opname WHERE no_faktur = '$no_faktur'");


                $query2 = $db->prepare("UPDATE stok_opname SET no_faktur = ?, tanggal = ?, jam = ?, status = 'ya', total_selisih = ?, user = ? WHERE no_faktur = ?");
                
                $query2->bind_param("sssiss",
                $no_faktur, $tanggal, $jam_sekarang, $selisih_harga, $user, $no_faktur);
                
                $no_faktur = stringdoang($_POST['no_faktur']); 
                $tanggal = stringdoang($_POST['tanggal']);
                $total_selisih_harga = angkadoang($_POST['total_selisih_harga']);
                $selisih_harga = $total_selisih_harga;
                $user = $_SESSION['user_name'];
                
                $query2->execute();



        $query1 = $db->query("SELECT * FROM tbs_stok_opname ");
        while ($data = mysqli_fetch_array($query1))
        {


            $query = $db->query("UPDATE barang SET stok_opname = '' WHERE kode_barang = '$data[kode_barang]'");

            $query4 = "INSERT INTO detail_stok_opname (no_faktur, tanggal, jam, kode_barang, nama_barang, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) 
            VALUES ('$data[no_faktur]', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]', '$data[nama_barang]', '$data[awal]', '$data[masuk]', '$data[keluar]', '$data[stok_sekarang]', '$data[fisik]', '$data[selisih_fisik]', '$data[selisih_harga]', '$data[harga]', '$data[hpp]')";
            
            if ($db->query($query4) === TRUE) {
                
            } else {
            echo "Error: " . $query4 . "<br>" . $db->error;
            }
            
            
        
        }


//JURNAL TRANSAKSI
$ambil_tbs = $db->query("SELECT SUM(selisih_harga) AS total FROM tbs_stok_opname WHERE no_faktur = '$no_faktur'");
$data_tbs = mysqli_fetch_array($ambil_tbs);
$total_tbs = $data_tbs['total'];



$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

if ($total_tbs < 0) {

    $total0 = 0 - $total_tbs;

      //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[persediaan]', '0', '$total0', 'Stok Opname', '$no_faktur','1', '$user')");

  //STOK OPNAME    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[pengaturan_stok]', '$total0', '0', 'Stok Opname', '$no_faktur','1', '$user')");
} 

else {
      //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[persediaan]', '$total_tbs', '0', 'Stok Opname', '$no_faktur','1', '$user')");

  //STOK OPNAME    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[pengaturan_stok]', '0', '$total_tbs', 'Stok Opname', '$no_faktur','1', '$user')");
}




//</>END JURNAL TRANSAKSI



        $hapus = $db->query("DELETE FROM tbs_stok_opname");
        
        
        echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>