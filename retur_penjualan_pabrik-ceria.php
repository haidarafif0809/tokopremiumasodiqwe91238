<?php session_start();

// memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';


    $session_id = session_id();

    $kode_barang = stringdoang($_POST['kode_barang']);    
    $harga = angkadoang($_POST['harga']);
    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);

    
  $cek = $db->query("SELECT * FROM tbs_retur_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur_penjualan = '$no_faktur_penjualan'");

    // menyimpan data sementara berupa baris yang dijalankan dari $cek
    $jumlah = mysqli_num_rows($cek);

    if ($jumlah > 0) {
      $query1 = $db->prepare("UPDATE tbs_retur_penjualan SET jumlah_retur = jumlah_retur + ?, harga = ?, subtotal = subtotal + ? WHERE kode_barang = ? AND no_faktur_penjualan = ?");

      $query1->bind_param("iiiss",
    $jumlah_retur, $harga, $subtotal, $kode_barang, $no_faktur_penjualan);


      $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
      $kode_barang = stringdoang($_POST['kode_barang']);
      $jumlah_retur = angkadoang($_POST['jumlah_retur']);
      $harga = angkadoang($_POST['harga']);
      $subtotal = $harga * $jumlah_retur;

      $query1->execute();
    }

    else{
    
    $cek2 = $db->query("SELECT * FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
    $data= mysqli_fetch_array($cek2); 


   $perintah = $db->prepare("INSERT INTO tbs_retur_penjualan (session_id,no_faktur_penjualan,nama_barang,kode_barang,jumlah_beli,jumlah_retur,harga,subtotal) VALUES (?,?,?,?,'$data[jumlah_barang]',?,'$data[harga]',?)");

   $perintah->bind_param("ssssii",
    $session_id, $no_faktur_penjualan, $nama_barang, $kode_barang, $jumlah_retur, $subtotal);

    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $jumlah_retur = angkadoang($_POST['jumlah_retur']);
    $subtotal = $harga * $jumlah_retur;

   $perintah->execute();


      $query9 = $db->prepare("UPDATE detail_penjualan SET sisa = sisa - ? WHERE no_faktur = ?");

   $query9->bind_param("is",
    $jumlah_retur, $no_faktur_penjualan);

    $jumlah_retur = angkadoang($_POST['jumlah_retur']);
    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);

   $query9->execute();  

        
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