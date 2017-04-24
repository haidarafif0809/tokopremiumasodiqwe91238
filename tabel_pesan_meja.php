<?php 
include 'db.php';
include 'sanitasi.php';

//ambil 2 angka terakhir dari tahun sekarang 
$tahun = $db->query("SELECT YEAR(NOW()) as tahun");
$v_tahun = mysqli_fetch_array($tahun);
 $tahun_terakhir = substr($v_tahun['tahun'], 2);
//ambil bulan sekarang
$bulan = $db->query("SELECT MONTH(NOW()) as bulan");
$v_bulan = mysqli_fetch_array($bulan);
$v_bulan['bulan'];


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($v_bulan['bulan']);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$v_bulan['bulan'];
 }
 else
 {
  $data_bulan_terakhir = $v_bulan['bulan'];

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }


 $query = $db->query("SELECT * FROM barang");

$kode_meja = $_GET['kode_meja'];

 ?>

 <table id="tableuser" class="table table-bordered" style="width:100%">
        

        <thead>


          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Subtotal </th>
          <th> Hapus </th>

        </thead>
        <tbody>
        <?php
        
        // menampilkan seluruh data yang ada pada tabel barang
        $perintah = "SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur'";
        $perintah1 = $db->query($perintah);
        
        // menyimpoan data sementara yang ada pada $perintah1
        while ($data1 = mysqli_fetch_array($perintah1))
        {
        // menampilkan data
            echo "<tr>
            <td>". $data1['nama_barang'] ."</td>
            <td>". $data1['jumlah_barang'] ."</td>
            <td>". $data1['subtotal'] ."</td>
            <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-pesanan='". $data1['nama_barang'] ."' kode-data='". $data1['kode_barang'] ."'> Hapus </button> </td> 
        </tr>";
        
        }

          //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
        
        ?>

        </tbody>
        </table>