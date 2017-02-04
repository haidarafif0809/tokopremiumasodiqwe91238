<?php session_start();


include 'db.php';

 $satuan_konversi = $_POST['satuan_konversi'];
 $jumlah_retur = $_POST['jumlah_retur'];
 $kode_barang = $_POST['kode_barang'];
 $id_produk = $_POST['id_produk'];
 $no_faktur = $_POST['no_faktur'];


 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur' OR no_faktur_hpp_masuk = '$no_faktur'");
 $dataaa = mysqli_fetch_array($queryy);

 $stok = $dataaa['total_sisa'];

 $query = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND id_produk = '$id_produk'");
 $data = mysqli_fetch_array($query);
$num_rows = mysqli_num_rows($query);

if ($num_rows > 0)
{
	 $hasil = $jumlah_retur * $data['konversi'];
} 
else
{
	$hasil = $jumlah_retur;
}

 echo $hasil1 = $stok - $hasil;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
