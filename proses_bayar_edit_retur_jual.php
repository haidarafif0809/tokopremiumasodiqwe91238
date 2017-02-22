<?php session_start();


    include 'sanitasi.php';
    include 'db.php';


    $cara_bayar = $_POST['cara_bayar'];
    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
    
    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:sa');
    $tahun_terakhir = substr($tahun_sekarang, 2);

    
    $perintah1 = $db->query("DELETE FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");


  // buat prepared statements
        $stmt = $db->prepare("UPDATE retur_penjualan SET no_faktur_retur = ?, kode_pelanggan = ?, total = ?, potongan = ?, tax = ?, tanggal = ?, user_edit = ?, tanggal_edit = ?, jam = ?, cara_bayar = ?, tunai = ?, sisa = ?, ppn = ? WHERE no_faktur_retur = ?");
  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssiiisssssiiss", 
        $no_faktur_retur, $kode_pelanggan, $total, $potongan, $tax_jadi, $tanggal, $user_edit, $tanggal_sekarang, $jam_sekarang, $cara_bayar, $pembayaran, $sisa, $ppn_input, $no_faktur_retur);        

  // siapkan "data" query
    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
    $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
    $total = angkadoang($_POST['total']);
    $total1 = angkadoang($_POST['total1']);
    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);
    $ppn_input = stringdoang($_POST['ppn_input']);
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $tanggal = stringdoang($_POST['tanggal']);
    $pembayaran = angkadoang($_POST['pembayaran']);
    $sisa = angkadoang($_POST['sisa']);
    $user_edit = $_SESSION['user_name'];
    $a = $total1 - $potongan;

    $tax_jadi = $tax * $a / 100;

    $_SESSION['no_faktur_retur'] = $no_faktur_retur;


  // jalankan query
        $stmt->execute();

        

    if (!$stmt) {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else {
    
    }



    $query = $db->query("SELECT * FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
    while ($data = mysqli_fetch_array($query))
    {

      $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_retur] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_retur] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);

      if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
        $harga = $data_konversi['harga_konversi'];
        $jumlah_barang = $data_konversi['jumlah_konversi'];
      }
      else{
        $harga = $data['harga'];
        $jumlah_barang = $data['jumlah_retur'];
      }

        $query2 = "INSERT INTO detail_retur_penjualan (no_faktur_retur, no_faktur_penjualan, tanggal, nama_barang, kode_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax, asal_satuan, satuan,jam) VALUES ('$data[no_faktur_retur]','$data[no_faktur_penjualan]','$tanggal','$data[nama_barang]','$data[kode_barang]','$data[jumlah_beli]','$jumlah_barang','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$data[satuan_jual]','$data[satuan]','$jam_sekarang')";

        if ($db->query($query2) === TRUE) {
                
            } else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }

    }



$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE no_faktur = '$no_faktur_retur'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$ppn_input = stringdoang($_POST['ppn_input']);
   
   $persediaan = $total_hpp;
   $total_akhir = $total;



  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");



//HPP    
      $insert_juranl1 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '0', '$persediaan', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");


 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '0', '$total', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");



if ($ppn_input == "Non") {  

 

  $total_penjualan = $total1;  


 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");

} 

else if ($ppn_input == "Include") {
//ppn == Include

  $total_penjualan = $total1 - $total_tax;
  $pajak = $total_tax;

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");
      }

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");



}

else {
//ppn == Exclude
  $total_penjualan = $total1;
  $pajak = $tax_jadi;
    
if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");
      }
      

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");


}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_retur_jual]', '0', '$potongan', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");
}


    $query3 = $db->query("DELETE  FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
    echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);       
    ?>