<?php session_start();
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$session_id = session_id();
$id = $_POST['idnya'];
$kode_barang = $_POST['kodenya'];


//awal nya bonus(mengembalikan jumlah bonus ke promo_produk_disc/_free)
/*$querytb = $db->query("SELECT tp.kode_produk,tp.nama_produk,tp.qty_bonus,tp.keterangan,tp.tanggal,tp.jam,b.id as baranga,tp.harga_disc FROM tbs_bonus_penjualan tp LEFT JOIN barang b ON tp.kode_produk = b.kode_barang WHERE tp.session_id = '$session_id' AND tp.id = '$id'");
    while ($datatb = mysqli_fetch_array($querytb))
      {
        if ($datatb['keterangan'] == 'Free Produk') {
          //mengambil qty produk free kemudian di hitung dg qty bonus untuk mengambil qty sekarang
          $de = $db->query("SELECT qty FROM promo_free_produk WHERE nama_produk = '$datatb[baranga]'");
          $e = mysqli_fetch_array($de);
          $a = $e['qty'] + $datatb['qty_bonus'];
          //menupdate qty free
          $update_profre = "UPDATE promo_free_produk SET qty = '$a' WHERE nama_produk = '$datatb[baranga]'";
          if ($db->query($update_profre) === TRUE) {
          } 

          else {
          echo "Error: " . $update_profre . "<br>" . $db->error;
          }
        }
        else{
          $disc = $db->query("SELECT qty FROM promo_disc_produk WHERE nama_produk = '$datatb[baranga]'");
          $ddisc = mysqli_fetch_array($disc);
          $qdisc = $ddisc['qty'] + $datatb['qty_bonus'];

          $update_prodisc = "UPDATE promo_disc_produk SET qty = '$qdisc' WHERE nama_produk = '$datatb[baranga]'";
          if ($db->query($update_prodisc) === TRUE) {
          } 

          else {
          echo "Error: " . $update_prodisc . "<br>" . $db->error;
          }
        }
      }*/
//end nya bonus

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_bonus_penjualan WHERE id = '$id' and kode_produk = '$kode_barang'");

//jika $query benar maka akan menuju file formpenjualan.php , jika salah maka failed
if ($query == TRUE)
{
echo 1;
}
else
{

}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
