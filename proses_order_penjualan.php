<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST

    $session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);


try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown

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

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penjualan_order ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur_order FROM penjualan_order ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur_order'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_faktur = "1/OR/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $no_faktur = $nomor."/OR/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

 


    $total = angkadoang($_POST['total2']);
    $user = $_SESSION['nama'];
    $sales = stringdoang($_POST['sales']);
    $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
    $no_jurnal = no_jurnal();
    
    $select_kode_pelanggan = $db->query("SELECT id,nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

              
    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE session_id = '$session_id' ");
   while  ($cek0 = mysqli_fetch_array($query0)){

          $query10 = $db->query("UPDATE tbs_fee_produk SET no_faktur_order = '$no_faktur' , session_id = '' WHERE session_id = '$session_id')");

    }


    $query = $db->query("SELECT * FROM tbs_penjualan_order WHERE session_id = '$session_id' ORDER BY kode_barang ");
    while ($data = mysqli_fetch_array($query))
      {

      $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_barang] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);
      $data_rows = mysqli_num_rows($pilih_konversi);

      if ($data_rows > 0) {

            if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
              $harga = $data_konversi['harga_konversi'];
              $jumlah_barang = $data_konversi['jumlah_konversi'];
              $satuan = $data_konversi['satuan'];
            }
            else{
              $harga = $data['harga'];
              $jumlah_barang = $data['jumlah_barang'];
              $satuan = $data['satuan'];
            }
        
      }
      
      else{
        $harga = $data['harga'];
        $jumlah_barang = $data['jumlah_barang'];
        $satuan = $data['satuan'];
      }

      
        $query2 = "INSERT INTO detail_penjualan_order (no_faktur_order,kode_barang, nama_barang, jumlah_barang,satuan, harga, subtotal, potongan, tax,tanggal,jam,asal_satuan) VALUES ('$no_faktur','$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$data[tanggal]','$data[jam]','$satuan')";

        if ($db->query($query2) === TRUE) {

        } 
        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }
        
      }


              
              $stmt = $db->prepare("INSERT INTO penjualan_order (no_faktur_order, kode_gudang, kode_pelanggan, total, tanggal, jam, user, status_order,keterangan) VALUES (?,?,?,?,?,?,?,'Sedang Order',?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssissss",
              $no_faktur, $kode_gudang, $ambil_kode_pelanggan[id], $total, $tanggal_sekarang, $jam_sekarang, $sales, $keterangan);
              
              
              $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
              $keterangan = stringdoang($_POST['keterangan']);
              $kode_gudang = stringdoang($_POST['kode_gudang']);
              $total = angkadoang($_POST['total2']);
            
              $sales = stringdoang($_POST['sales']);
              $ppn_input = stringdoang($_POST['ppn_input']);
              $_SESSION['no_faktur']=$no_faktur;
              
    // jalankan query
              $stmt->execute();
              


    $query3 = $db->query("DELETE  FROM tbs_penjualan_order WHERE session_id = '$session_id'");


    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>
