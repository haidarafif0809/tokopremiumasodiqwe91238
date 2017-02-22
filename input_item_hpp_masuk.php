<?php 

include 'db.php';


$select = $db->query("SELECT * FROM item_masuk ");
    while ($ambil = mysqli_fetch_array($select))
    {

      $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$ambil[kode_barang]' ORDER BY id DESC LIMIT 1");
      $num_rows = mysqli_num_rows($select2);
      $fetc_array = mysqli_fetch_array($select2);

      $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$ambil[kode_barang]' ORDER BY id DESC LIMIT 1");
      $ambil_barang = mysqli_fetch_array($select3);

      if ($num_rows == 0) {

        if ($ambil['harga'] != $ambil_barang['harga_beli']) {
          
          $subtotal_barang = $ambil['harga'] * $ambil['jumlah'];
          $harga_tbs = $ambil['harga'];
    
        }
        else{
          $subtotal_barang = $ambil_barang['harga_beli'] * $ambil['jumlah'];
          $harga_tbs = $ambil_barang['harga_beli'];
        }
        
        $subtotal_barang = $ambil_barang['harga_beli'] * $ambil['jumlah'];
        
        $insert = $db->query("INSERT INTO hpp_masuk (no_faktur, kode_barang, jenis_transaksi, jumlah_kuantitas, harga_unit, total_nilai, sisa, tanggal, jam, waktu) 
        VALUES ('$no_faktur','$ambil[kode_barang]','Item Masuk','$ambil[jumlah]','$harga_tbs','$subtotal_barang','$ambil[jumlah]','$tanggal_sekarang','$jam_sekarang', '$tanggal_sekarang $jam_sekarang')");

       
      }

      else{

        if ($ambil['harga'] != $fetc_array['harga']) {
          
        $subtotal_detail = $ambil['harga'] * $ambil['jumlah'];
        $harga_tbs = $ambil['harga'];
    
        }

        else{
        $subtotal_detail = $fetc_array['harga'] * $ambil['jumlah'];
        $harga_tbs = $ambil_barang['harga_beli'];
        }



        $insert = $db->query("INSERT INTO hpp_masuk (no_faktur, kode_barang, jenis_transaksi, jumlah_kuantitas, harga_unit, total_nilai, sisa, tanggal, jam, waktu) 
        VALUES ('$no_faktur','$ambil[kode_barang]','Item Masuk','$ambil[jumlah]','$harga_tbs','$subtotal_detail','$ambil[jumlah]','$tanggal_sekarang','$jam_sekarang', '$tanggal_sekarang $jam_sekarang')");
   
          }
       
     }
 ?>