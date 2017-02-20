<?php 
    include 'db.php';
    include_once 'sanitasi.php';

$barang = $db->query("SELECT * FROM barang");
while ($dp = mysqli_fetch_array($barang)) {
      
    $total = $dp['harga_beli'] * 100;

    $stok = "INSERT INTO stok_awal(no_faktur, kode_barang, nama_barang, jumlah_awal, satuan, harga, total, gudang, tanggal, jam, user, tanggal_edit, user_edit) VALUES ('1/SA/02/17','$dp[kode_barang]','$dp[nama_barang]','100','$dp[satuan]','$dp[harga_beli]','$total','NULL','2017-02-16','13:01:10','it','NULL','NULL')";

    if ($db->query($stok) === TRUE) {
        echo "SUKSES";
        } 
    else{
        echo "Error: " . $stok . "<br>" . $db->error;
        }
}

echo "sukses";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
?>