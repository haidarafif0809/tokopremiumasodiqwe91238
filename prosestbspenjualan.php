<?php session_start(); 

    include 'sanitasi.php';
    include 'db.php';
    $session_id = session_id();
    //mengirim data sesuai dengan variabel denagn metode POST 

    $kode_barang = stringdoang($_POST['kode_barang']);
    $harga_produk = stringdoang($_POST['harga_produk']);
    $harga_konversi = stringdoang($_POST['harga_konversi']);

    if ($harga_konversi != 0) {
      $harga = $harga_konversi;
    }else{
      $harga = $harga_produk;
    }

    
    $jumlah_barang = stringdoang($_POST['jumlah_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $sales = stringdoang($_POST['sales']);
    $user = $_SESSION['nama'];
    $potongan = stringdoang($_POST['potongan']);
    $a = $harga * $jumlah_barang;
    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:s');
    $tahun_terakhir = substr($tahun_sekarang, 2);
    $ppn = stringdoang($_POST['ppn']);


    if ($potongan == '') {
      $potongan_jadi = 0;
      $potongan_tampil = 0;
    }
    else
    {
           if(strpos($potongan, "%") !== false)
          {
              $potongan_jadi = $a * $potongan / 100;
              $potongan_tampil = $potongan_jadi;
          }
          else{

             $potongan_jadi = $potongan;
             $potongan_tampil = $potongan;
          }
    }


$tax = stringdoang($_POST['tax']);
$subtotal = $harga * $jumlah_barang;
if ($ppn == 'Exclude') {
             $a = $harga * $jumlah_barang;

              
              $x = $a - $potongan_tampil;

              $hasil_tax = $x * ($tax / 100);

              $tax_persen = round($hasil_tax);
            }
            else{
                        $a = $harga * $jumlah_barang;

              $satu = 1;

              $x = $a - $potongan_tampil;

              $hasil_tax = $satu + ($tax / 100);

              $hasil_tax2 = $x / $hasil_tax;

              $tax_persen1 = $x - round($hasil_tax2);

              $tax_persen = round($tax_persen1);
            }



    if ($ppn == 'Exclude') {
  # code...

              $abc = $subtotal - $potongan_tampil;

              $hasil_tax411 = $abc * ($tax / 100);

              $subtotaljadi = $harga * $jumlah_barang - $potongan_tampil + round($hasil_tax411); 

}
else
{
  $subtotaljadi = $harga * $jumlah_barang - $potongan_tampil; 
}



    $query9 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];



    if ($prosentase != 0){
      
      $query90 = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' AND kode_barang = '$kode_barang'");

      $cek90 = mysqli_fetch_array($query90);
      $jumlah1 = $cek90['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $subtotal_prosentase = $harga * $jumlah0;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

      $komisi = $fee_prosentase_produk;



          $subtotal_prosentase = $harga * $jumlah_barang;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

          $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$session_id', '$kode_barang',
            '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");


    }

    elseif ($nominal != 0) {

      $query900 = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' AND kode_barang = '$kode_barang'");

      $cek900 = mysqli_fetch_array($query900);
      $jumlah1 = $cek900['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $fee_nominal_produk = $nominal * $jumlah0;

      $komisi0 = $fee_nominal_produk;

      $fee_nominal_produk = $nominal * $jumlah_barang;

      $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$session_id', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
      

    }

    else
    {

    }


            $perintah = $db->prepare("INSERT INTO tbs_penjualan (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga_konversi,subtotal,potongan,tax,tanggal,jam, tipe_barang,harga) VALUES (?,?,
            ?,?,?,?,?,?,?,?,?,?,?)");
            
            
            $perintah->bind_param("sssisiiiisssi",
            $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga_konversi, $subtotaljadi, $potongan_tampil, $tax_persen,$tanggal_sekarang,$jam_sekarang,$tipe_barang,$harga_produk);
            
            
            $kode_barang = stringdoang($_POST['kode_barang']);
            $jumlah_barang = stringdoang($_POST['jumlah_barang']); 
            $nama_barang = stringdoang($_POST['nama_barang']);
            $satuan = stringdoang($_POST['satuan']);
            $tax = stringdoang($_POST['tax']);
            $tipe_barang = stringdoang($_POST['ber_stok']);
            if ($tax == '') {
              $tax = 0;
            }
            
            
            $perintah->execute();


    ?>

   