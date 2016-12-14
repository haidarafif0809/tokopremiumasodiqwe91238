<?php session_start();


include 'db.php';

 $satuan_konversi = $_POST['satuan_konversi'];
 $jumlah_retur = $_POST['jumlah_retur'];
 $kode_barang = $_POST['kode_barang'];
 $id_produk = $_POST['id_produk'];
 $no_faktur = $_POST['no_faktur'];

 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur' OR no_faktur_hpp_masuk = '$no_faktur'");
 $dataaa = mysqli_fetch_array($queryy);

 $stok = $dataaa['total_sisa'] ;


$queryyy = $db->query("SELECT IFNULL(dp.jumlah_retur,0) AS jumlah_detail ,IFNULL(tp.jumlah_retur,0) AS jumlah_tbs FROM detail_retur_pembelian dp LEFT JOIN tbs_retur_pembelian tp ON dp.no_faktur_pembelian = tp.no_faktur_pembelian WHERE dp.kode_barang = '$kode_barang' AND dp.no_faktur_pembelian");
$data000 = mysqli_fetch_array($queryyy);

 $sisa_barang = ($stok + $data000['jumlah_detail']) - $data000['jumlah_tbs'];


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

   echo $hasil1 = $sisa_barang - $hasil;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
