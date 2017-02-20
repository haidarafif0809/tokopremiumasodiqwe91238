<?php 
include 'db.php';

    $select = $db->query("SELECT * FROM stok_awal ");
    while ($ambil = mysqli_fetch_array($select))
    {

      $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$ambil[kode_barang]' ORDER BY id DESC LIMIT 1");
      $num_rows = mysqli_num_rows($select2);
      $fetc_array = mysqli_fetch_array($select2);

      $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$ambil[kode_barang]' ORDER BY id DESC LIMIT 1");
      $ambil_barang = mysqli_fetch_array($select3);

      if ($num_rows == 0) {

        $subtotal_barang = $ambil_barang['harga_beli'] * $ambil['jumlah_awal'];

 $insert = $db->query("INSERT INTO hpp_masuk (no_faktur, kode_barang, jenis_transaksi, jumlah_kuantitas, harga_unit, total_nilai, sisa, tanggal, jam, waktu) 
    VALUES ('$no_faktur','$ambil[kode_barang]','Item Masuk','$ambil[jumlah_awal]','$ambil_barang[harga_beli]','$subtotal_barang','$ambil[jumlah_awal]','$tanggal_sekarang','$jam_sekarang', '$tanggal_sekarang $jam_sekarang')");

       
      }

      else{

        $subtotal_detail = $fetc_array['harga'] * $ambil['jumlah_awal'];

        $insert = $db->query("INSERT INTO hpp_masuk (no_faktur, kode_barang, jenis_transaksi, jumlah_kuantitas, harga_unit, total_nilai, sisa, tanggal, jam, waktu) 
        VALUES ('Stok Awal','$ambil[kode_barang]','Stok Awal','$ambil[jumlah_awal]','$fetc_array[harga]','$subtotal_detail','$ambil[jumlah_awal]','$tanggal_sekarang','$jam_sekarang', '$tanggal_sekarang $jam_sekarang')");
   
          }
       
     }


 ?>