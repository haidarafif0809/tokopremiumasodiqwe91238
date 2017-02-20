<?php session_start();

include 'sanitasi.php';
include 'db.php';

$tanggal = date('Y-m-d');
$petugas = $_SESSION['nama'];
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
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

//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM data_perubahan_masal ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT nomor FROM data_perubahan_masal ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['nomor'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $nomor = "1/PR/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $nomor = $nomor."/PR/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

        $perintah = $db->prepare("INSERT INTO data_perubahan_masal (nomor,kategori,
            perubahan_harga,acuan_harga,pola_perubahan,jumlah_nilai,nilai,pembulatan,tanggal,petugas,status) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

        $perintah->bind_param("sssssisssss",
          $nomor, $kategori, $change_price, $acuan_price, $sistem_change, $jumlah_nilai,
          $nilai, $pembulatan, $tanggal, $petugas,$status);
        
        
        $kategori = stringdoang($_POST['kategori']);
        $change_price = stringdoang($_POST['change_price']);
        $acuan_price = stringdoang($_POST['acuan_price']);
        $sistem_change = stringdoang($_POST['sistem_change']);
        $jumlah_nilai = angkadoang($_POST['jumlah_nilai']);
        $nilai = stringdoang($_POST['nilai']);
        $pembulatan = stringdoang($_POST['pembulatan']);
        $status = 'Belum Simpan';

        $perintah->execute();
        

if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
}
    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>