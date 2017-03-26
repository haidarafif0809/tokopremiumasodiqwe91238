<?php 
include 'sanitasi.php';
include 'db.php';

 ?>

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
        <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Suplier </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
<?php


        
        $perintah = $db->query("SELECT s.nama,kode_barang,b.nama_barang,b.satuan,b.harga_beli,b.harga_jual,b.harga_jual2,b.harga_jual3,b.stok_barang,b.satuan,b.kategori,b.suplier FROM barang b INNER JOIN satuan s ON b.satuan = s.id ");
        
        //menyimpan data sementara yang ada pada $perintah
        while ($data1 = mysqli_fetch_array($perintah))
        {

// mencari jumlah Barang
            select = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_hpp_masuk FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
             $ambil_masuk = mysqli_fetch_array($select);

             $select_2 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_hpp_keluar FROM hpp_keluar WHERE kode_barang = '$row[kode_barang]'");
             $ambil_keluar = mysqli_fetch_array($select_2);

            $stok_barang = $ambil_masuk['jumlah_hpp_masuk'] - $ambil_keluar['jumlah_hpp_keluar'];
        
        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."'
        satuan='". $data1['satuan'] ."' harga='". $data1['harga_beli'] ."' jumlah-barang='". $stok_barang ."'>
        
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td>". rp($data1['harga_beli']) ."</td>
            <td>". rp($data1['harga_jual']) ."</td>
            <td>". rp($data1['harga_jual2']) ."</td>
            <td>". rp($data1['harga_jual3']) ."</td>
            <td>". $stok_barang ."</td>
            <td>". $data1['nama'] ."</td>
            <td>". $data1['kategori'] ."</td>
            <td>". $data1['suplier'] ."</td>
            
            </tr>";
      
         }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
    
        </tbody> <!--tag penutup tbody-->
        
        </table> <!-- tag penutup table-->
  </div>
  <script type="text/javascript">
  $(function () {
  $("#tableuser").dataTable();
  });
</script>