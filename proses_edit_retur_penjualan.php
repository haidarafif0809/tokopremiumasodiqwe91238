<?php 

include 'sanitasi.php';
include 'db.php';



$no_faktur_retur = $_GET['no_faktur_retur'];



$perintah3 = $db->query("SELECT * FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
while ($data = mysqli_fetch_array($perintah))
{
	  $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_retur] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_retur] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan,sk.konversi FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);

      if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
        $harga = $data['harga'] * $data_konversi['konversi'];
       $jumlah_retur = $data['jumlah_retur'] / $data_konversi['konversi'];
      }
      else{
        $harga = $data['harga'];
        $jumlah_retur = $data['jumlah_retur'];
      }


$perintah1 = $db->query("INSERT INTO tbs_retur_penjualan (no_faktur_retur, no_faktur_penjualan	, nama_barang, kode_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax,satuan, satuan_jual) VALUES ( '$data[no_faktur_retur]', '$data[no_faktur_penjualan]', '$data[nama_barang]', '$data[kode_barang]', '$data[jumlah_beli]', '$jumlah_retur', '$harga', '$data[subtotal]', '$data[potongan]', '$data[tax]','$data[satuan]','$data[asal_satuan]')");


}

header ('location:edit_retur_penjualan.php?no_faktur_retur='.$no_faktur_retur.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


