<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
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

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM item_keluar ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari item_keluar terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM item_keluar ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari item_keluar tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$no_faktur = "1/IK/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/IK/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO item_keluar (no_faktur, total, tanggal, jam, user, keterangan)
			VALUES (?,?,?,?,?,?)");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("sissss", 
        $no_faktur, $total , $tanggal_sekarang, $jam_sekarang, $user, $keterangan);		

  // siapkan "data" query
    $total = angkadoang($_POST['total']);
    $user = $_SESSION['user_name'];
    $keterangan = stringdoang($_POST['keterangan']);

  // jalankan query
        $stmt->execute();



    $query = $db->query("SELECT * FROM tbs_item_keluar WHERE session_id = '$session_id'");
    while ($data = mysqli_fetch_array($query))
    {
       
        $query2 = $db->query("INSERT INTO detail_item_keluar (no_faktur, tanggal,jam, kode_barang, nama_barang, jumlah, satuan, harga, subtotal) 
		VALUES ('$no_faktur','$tanggal_sekarang','$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$data[jumlah]','$data[satuan]','$data[harga]','$data[subtotal]')");
    }

    //BATAS SINI


$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
$total = $ambil_sum['total'];

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Persediaan -', '$ambil_setting[persediaan]', '0', '$total', 'Item Keluar', '$no_faktur','1', '$user')");

  //ITEM KELUAR    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Item Keluar -', '$ambil_setting[item_keluar]', '$total', '0', 'Item Masuk', '$no_faktur','1', '$user')");

    $query3 = $db->query("DELETE  FROM tbs_item_keluar WHERE session_id = '$session_id'");
    echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>