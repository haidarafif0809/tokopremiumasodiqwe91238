<?php session_start();

// memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';


    $session_id = session_id();

    $kode_barang = stringdoang($_POST['kode_barang']);    
    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
              $jumlah_retur = angkadoang($_POST['jumlah_retur']);
              $harga = stringdoang($_POST['harga']);
              
              $potongan = stringdoang($_POST['potongan1']);
              $pajak = angkadoang($_POST['tax1']);
              
              $potongan = stringdoang($_POST['potongan1']);
              $a = $harga * $jumlah_retur;
              
              
              if(strpos($potongan, "%") !== false)
              {
              $potongan_jadi = $a * $potongan / 100;
              $potongan_tampil = $potongan_jadi;
              }
              else
              {
              
              $potongan_jadi = $potongan;
              $potongan_tampil = $potongan;
              }
              
              $satu = 1;
              $x = $a - $potongan_tampil;
              
              $hasil_tax = $satu + ($pajak / 100);
              
              $hasil_tax2 = $x / $hasil_tax;
              
              $tax_persen1 = $x - $hasil_tax2;
              
              $tax_persen = round($tax_persen1);
              
              $subtotal = $harga * $jumlah_retur - $potongan_jadi;


   
   $query9 = $db->prepare("UPDATE detail_penjualan SET sisa = sisa - ? WHERE no_faktur = ? AND kode_barang = '$kode_barang'");

   $query9->bind_param("is",
    $jumlah_retur, $no_faktur_penjualan);

    $jumlah_retur = angkadoang($_POST['jumlah_retur']);
    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);

   $query9->execute();    

       

    $cek2 = $db->query("SELECT jumlah_barang, satuan FROM detail_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur_penjualan'");
    $data= mysqli_fetch_array($cek2); 

    $konversi = $db->query("SELECT $data[jumlah_barang] / konversi AS jumlah_jual FROM satuan_konversi WHERE kode_produk = '$kode_barang' AND id_satuan = '$data[satuan]' ");
    $num_rows = mysqli_num_rows($konversi);
    $data_konversi = mysqli_fetch_array($konversi); 
    
    if ($num_rows > 0 ){
    
    $jumlah_jual = $data_konversi['jumlah_jual'];
    }
    else{ 
    
    $jumlah_jual = $data['jumlah_barang'];
    }



   $perintah = $db->prepare("INSERT INTO tbs_retur_penjualan (session_id,no_faktur_penjualan,nama_barang,kode_barang,jumlah_beli,jumlah_retur,harga,subtotal,potongan,tax,satuan,satuan_jual) VALUES (?,?,?,?,'$jumlah_jual',?,'$harga',?,?,?,?,?)");

   $perintah->bind_param("ssssiiiiss",
    $session_id, $no_faktur_penjualan, $nama_barang, $kode_barang, $jumlah_retur, $subtotal,$potongan_tampil,$tax_persen,$satuan_produk,$satuan_jual);

    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $jumlah_retur = angkadoang($_POST['jumlah_retur']);
    $harga = stringdoang($_POST['harga']);
     $satuan_produk = stringdoang($_POST['satuan_produk']);
     $satuan_jual = stringdoang($_POST['satuan_jual']);

   $perintah->execute();

        
if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}


    
?>