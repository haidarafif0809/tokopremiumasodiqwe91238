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
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Suplier </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
<?php


        
        $perintah = $db->query("SELECT s.nama,kode_barang,b.nama_barang,b.satuan,b.harga_beli,b.harga_jual,b.harga_jual2,b.harga_jual3,b.stok_barang,b.satuan,b.kategori,b.suplier FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = 'Barang' || b.berkaitan_dgn_stok = '' ");
        
        //menyimpan data sementara yang ada pada $perintah
        while ($data1 = mysqli_fetch_array($perintah))
        {
        
        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."'
        satuan='". $data1['satuan'] ."' harga_beli='". $data1['harga_beli'] ."' jumlah-barang='". $data1['stok_barang'] ."'>
        
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td>". rp($data1['harga_beli']) ."</td>
            <td>". rp($data1['harga_jual']) ."</td>
            <td>". rp($data1['harga_jual2']) ."</td>
            <td>". rp($data1['harga_jual3']) ."</td>
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