<?php session_start();


    include 'sanitasi.php';
    include 'db.php';

$session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:sa');


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
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM retur_penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur_retur FROM retur_penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur_retur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$no_faktur_retur = "1/RJ/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur_retur = $nomor."/RJ/".$data_bulan_terakhir."/".$tahun_terakhir;


 }






  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO retur_penjualan (no_faktur_retur, tanggal, jam, kode_pelanggan,
                total, potongan, tax, user_buat, cara_bayar, tunai, sisa, ppn)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssiiissiis", 
        $no_faktur_retur, $tanggal_sekarang, $jam_sekarang, $kode_pelanggan , $total, $potongan, $tax_jadi, $user_buat, $cara_bayar, $pembayaran, $sisa, $ppn_input);        

  // siapkan "data" query
    $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
    $total = angkadoang($_POST['total']);
    $total1 = angkadoang($_POST['total1']);
    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $pembayaran = angkadoang($_POST['pembayaran']);
    $ppn_input = stringdoang($_POST['ppn_input']);
    $sisa = angkadoang($_POST['sisa']);
    $user_buat = $_SESSION['user_name'];

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


    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);


    $query = $db->query("SELECT * FROM tbs_retur_penjualan WHERE session_id = '$session_id'");
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

        $query2 = "INSERT INTO detail_retur_penjualan (no_faktur_retur, no_faktur_penjualan, tanggal, jam, nama_barang, kode_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax,asal_satuan,satuan) VALUES ('$no_faktur_retur','$data[no_faktur_penjualan]','$tanggal_sekarang','$jam_sekarang','$data[nama_barang]','$data[kode_barang]','$data[jumlah_beli]','$jumlah_barang','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$data[satuan_jual]','$data[satuan]')";

            if ($db->query($query2) === TRUE) {
                
            } else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }

    }



$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_retur_penjualan WHERE session_id = '$session_id'");
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
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");



//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '0', '$total_hpp', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");


 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '0', '$total_akhir', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");



if ($ppn_input == "Non") {  

 

  $total_penjualan = $total1;  



 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_buat')");

} 

else if ($ppn_input == "Include") {
//ppn == Include


  $total_penjualan = $total1 - $total_tax;
  $pajak = $total_tax;

if ($pajak != "" || $pajak != 0 ) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");
      }

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_buat')");



}

else {

//ppn == Exclude
  $total_penjualan = $total1;
  $pajak = $tax_jadi;
    
if ($pajak != "" || $pajak != 0 ) {

//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");
      }
      

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_buat')");


}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_retur_jual]', '0', '$potongan', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");
}




    $query3 = $db->query("DELETE  FROM tbs_retur_penjualan WHERE session_id = '$session_id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>