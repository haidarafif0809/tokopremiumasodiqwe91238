<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }
//ambil bulan dari tanggal item_keluar terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM transfer_stok ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari item_keluar terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM transfer_stok ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari item_keluar tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$no_faktur = "1/TS/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/TS/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

// siapkan "data" query
    $total = angkadoang($_POST['total']);
    $user = $_SESSION['nama'];
    $keterangan = stringdoang($_POST['keterangan']);

  // buat prepared statements
         

        $stmt = $db->prepare("INSERT INTO transfer_stok(no_faktur, tanggal, jam, user, keterangan, total)
                             VALUES (?,?,?,?,?,?)");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("sssssi", 
        $no_faktur, $tanggal_sekarang,$jam_sekarang,$user,$keterangan,$total);    

  
  // jalankan query
        $stmt->execute();
        

// INSERT DETAIL TRANSFER STOK DARI TBS
    $query_tbs_transfer_stok = $db->query("SELECT * FROM tbs_transfer_stok WHERE session_id = '$session_id'");
    while ($data_tbs_transfer_stok = mysqli_fetch_array($query_tbs_transfer_stok))
    {

       
        $query_detail_transfer_stok = "INSERT INTO detail_transfer_stok(no_faktur, tanggal, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, jam) 
        VALUES ('$no_faktur','$data_tbs_transfer_stok[tanggal]','$data_tbs_transfer_stok[kode_barang]','$data_tbs_transfer_stok[nama_barang]','$data_tbs_transfer_stok[kode_barang_tujuan]','$data_tbs_transfer_stok[nama_barang_tujuan]','$data_tbs_transfer_stok[jumlah]','$data_tbs_transfer_stok[satuan]','$data_tbs_transfer_stok[harga]','$data_tbs_transfer_stok[subtotal]','$data_tbs_transfer_stok[jam]')";


            if ($db->query($query_detail_transfer_stok) === TRUE) {
                
            } else {
            echo "Error: " . $query_detail_transfer_stok . "<br>" . $db->error;
            }


    }



// hpp  keluar
$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil_sum_hpp_keluar = mysqli_fetch_array($sum_hpp_keluar);
$total_hpp_keluar = $ambil_sum_hpp_keluar['total'];

// hpp masuk 
$sum_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_masuk WHERE no_faktur = '$no_faktur'");
$ambil_sum_hpp_masuk = mysqli_fetch_array($sum_hpp_masuk);
$total_hpp_masuk = $ambil_sum_hpp_masuk['total'];

// setting akun
$select_setting_akun = $db->query("SELECT persediaan , item_keluar, item_masuk FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

          
          // pencegah suapaya jurnal tidak doubel
          $delete_jurnal = $db->query("DELETE  FROM jurnal_trans WHERE no_faktur = '$no_faktur' AND jenis_transaksi = 'Transfer Stok' ");

    
    // jurnal masuk
              //PERSEDIAAN    
                $insert_jurnal_masuk1 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Transfer Stok - $keterangan', '$ambil_setting[persediaan]', '$total_hpp_masuk', '0', 'Transfer Stok', '$no_faktur','1', '$user')");

          //ITEM MASUK    
                $insert_jurnal_masuk2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Transfer Stok - $keterangan', '$ambil_setting[item_masuk]', '0', '$total_hpp_masuk', 'Transfer Stok', '$no_faktur','1', '$user')");

    // jurnal keluar
            //PERSEDIAAN    
                $insert_jurnal_keluar1 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Transfer Stok', '$ambil_setting[persediaan]', '0', '$total_hpp_keluar', 'Transfer Stok', '$no_faktur','1', '$user')");

                //ITEM KELUAR    
                $insert_jurnal_keluar2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Transfer Stok -', '$ambil_setting[item_keluar]', '$total_hpp_keluar', '0', 'Transfer Stok', '$no_faktur','1', '$user')");


  // INSERT HISTORY TBS TRANSFER STOK
  
  $query_insert_history_tbs_transfer_stok = $db->query("INSERT INTO history_tbs_transfer_stok(no_faktur, session_id, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, tanggal, jam, waktu) 
  SELECT '$no_faktur', session_id, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, tanggal, jam, waktu FROM tbs_transfer_stok WHERE session_id = '$session_id' ");



    $query3 = $db->query("DELETE  FROM tbs_transfer_stok WHERE session_id = '$session_id'");
    echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>