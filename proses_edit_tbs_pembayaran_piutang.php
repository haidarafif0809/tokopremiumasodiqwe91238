<?php 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
  $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);

  $query002 = $db->prepare("UPDATE penjualan SET kredit = kredit - ? WHERE no_faktur = ?");

  $query002->bind_param("is",
    $potongan, $no_faktur_penjualan);

  $potongan = angkadoang($_POST['potongan']);
  $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);

  $query002->execute();


  $query = $db->prepare("UPDATE penjualan SET kredit = kredit - ? WHERE no_faktur = ?");

  $query->bind_param("is",
    $jumlah_bayar, $no_faktur_penjualan);

  
  $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);
  $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);

  $query->execute();
   
$cek = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE no_faktur_penjualan = '$no_faktur_penjualan'");

$jumlah = mysqli_num_rows($cek);
    
    if ($jumlah > 0){
        
      $query1 = $db->prepare("UPDATE tbs_pembayaran_piutang SET jumlah_bayar = jumlah_bayar + ?, potongan = potongan + ?, total = total + ? WHERE no_faktur_penjualan = ?");

      $query1->bind_param("iiis",
          $jumlah_bayar, $potongan, $total_kredit, $no_faktur_penjualan);

    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);

    $potongan = angkadoang($_POST['potongan']);
    $total_kredit = angkadoang($_POST['total']);
    $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);

    $query1->execute();
  }

else{
  $perintah = $db->prepare("INSERT INTO tbs_pembayaran_piutang (no_faktur_pembayaran,no_faktur_penjualan,tanggal,tanggal_jt,kredit,potongan,total,jumlah_bayar) VALUES (?,?,now(),?,?,?,?,?)");

  $perintah->bind_param("sssiiii",
    $no_faktur_pembayaran, $no_faktur_penjualan, $tanggal_jt, $kredit, $potongan, $total, $jumlah_bayar);


    $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);
    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
    $tanggal_jt = stringdoang($_POST['tanggal_jt']);
    $kredit = angkadoang($_POST['kredit']);
    $potongan = angkadoang($_POST['potongan']);
    
    $total = angkadoang($_POST['total']);
    $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);

    $perintah->execute();


if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>
