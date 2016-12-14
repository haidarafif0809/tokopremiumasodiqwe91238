<?php 
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';


    $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);

    
    $cek2 = $db->query("SELECT * FROM tbs_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
    $data= mysqli_num_rows($cek2); 

if ($data > 0){

    $query1 = $db->prepare("UPDATE tbs_pembayaran_hutang SET jumlah_bayar = jumlah_bayar + ?, potongan = potongan + ?, total = ? WHERE no_faktur_pembelian = ?");

      $query1->bind_param("iiis",
          $jumlah_bayar, $potongan, $total_kredit, $no_faktur_pembelian);

    $no_faktur_pembelian = stringdoang($_POST['no_faktur_pembelian']);
    $potongan = angkadoang($_POST['potongan']);
    $total_kredit = angkadoang($_POST['total']);
    $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);

    $query1->execute();

}

else {

        $perintah = $db->prepare("INSERT INTO tbs_pembayaran_hutang (no_faktur_pembayaran,no_faktur_pembelian,tanggal,tanggal_jt,kredit,potongan,total,jumlah_bayar) 
        VALUES (?,?,now(),?,?,?,?,?)");
         
         
         $perintah->bind_param("sssiiii",
         $no_faktur_pembayaran, $no_faktur_pembelian, $tanggal_jt, $kredit, $potongan, $total, $jumlah_bayar);
         
         $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);
         $no_faktur_pembelian = stringdoang($_POST['no_faktur_pembelian']);
         $tanggal_jt = angkadoang($_POST['tanggal_jt']);
         $kredit = angkadoang($_POST['kredit']);
         $total = angkadoang($_POST['total']);            
         $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);
         $potongan = angkadoang($_POST['potongan']);

         $perintah->execute();
        
if (!$query) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}

}
    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>