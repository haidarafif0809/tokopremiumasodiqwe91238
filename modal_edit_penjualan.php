<?php 

    include 'sanitasi.php';
    include 'db.php';
    
$no_faktur = stringdoang($_POST['no_faktur']);





?>

        <div class="table-responsive">
        <!-- membuat agar ada garis pada tabel, disetiap kolom-->
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
            <th> Suplier </th>
            <th> Tambah </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
<?php


        
        $perintah = $db->query("SELECT s.nama AS nama_satuan ,b.id ,b.limit_stok ,b.berkaitan_dgn_stok ,b.kode_barang ,b.nama_barang ,b.harga_beli ,b.harga_jual ,b.harga_jual2 ,b.harga_jual3 ,b.satuan ,b.suplier FROM barang b INNER JOIN satuan s ON b.satuan = s.id ");
        
        //menyimpan data sementara yang ada pada $perintah
        while ($data1 = mysqli_fetch_array($perintah))
        {

// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$data1[kode_barang]'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$data1[kode_barang]'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$data1[kode_barang]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$data1[kode_barang]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$data1[kode_barang]'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$data1[kode_barang]'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$data1[kode_barang]'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$data1[kode_barang]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];

// select detail penjualan dan tbs_penjualan
            $queryyy = $db->query("SELECT dp.jumlah_barang AS jumlah_detail ,tp.jumlah_barang AS jumlah_tbs, dp.satuan  FROM detail_penjualan dp LEFT JOIN tbs_penjualan tp ON dp.no_faktur = tp.no_faktur WHERE dp.kode_barang = '$data1[kode_barang]' AND dp.no_faktur = '$no_faktur' ");
            $data000 = mysqli_fetch_array($queryyy);


//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;

            $konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$data000[satuan]' AND kode_produk = '$data1[kode_barang]'");
            $data_konversi = mysqli_fetch_array($konversi);
            

             $jumlah_tbs = $data000['jumlah_tbs'] * $data_konversi['konversi'];


            $stok_barang = $total_1 - $total_2;
            $sisa_barang = ($stok_barang + $data000['jumlah_detail']) - $jumlah_tbs;
        
        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."' limit_stok='". $data1['limit_stok'] ."'
        satuan='". $data1['satuan'] ."' harga='". $data1['harga_jual'] ."' harga_level_2='". $data1['harga_jual2'] ."'  harga_level_3='". $data1['harga_jual3'] ."'  jumlah-barang='". $sisa_barang ."' ber-stok='". $data1['berkaitan_dgn_stok'] ."' id-barang='". $data1['id'] ."'>
        
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td>". rp($data1['harga_beli']) ."</td>
            <td>". rp($data1['harga_jual']) ."</td>
            <td>". rp($data1['harga_jual2']) ."</td>
            <td>". rp($data1['harga_jual3']) ."</td>
            <td>". $sisa_barang ."</td>
            <td>". $data1['nama_satuan'] ."</td>
            <td>". $data1['suplier'] ."</td>
            <td> <button type='button' class='btn btn-sm btn-primary btn-tambah'>Tambah</button> </td>
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
