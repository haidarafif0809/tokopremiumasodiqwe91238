<?php 

    include 'sanitasi.php';
    include 'db.php';

    $keterangan = $_POST['keterangan'];
    $no_faktur = $_POST['no_faktur'];

    $ambil_penjualan = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$no_faktur' ");
    $data_penjualan = mysqli_fetch_array($ambil_penjualan);
    
    $insert_batal_penjualan = $db->query("INSERT INTO batal_penjualan (no_faktur, kode_pelanggan, kode_meja, total, tanggal, tanggal_jt, jam, user, status, potongan, tax, sisa, kredit, total_hpp, cara_bayar, tunai, no_pesanan, keterangan_batal) VALUES ('$data_penjualan[no_faktur]', '$data_penjualan[kode_pelanggan]', '$data_penjualan[kode_meja]', '$data_penjualan[total]', '$data_penjualan[tanggal]', '$data_penjualan[tanggal_jt]', '$data_penjualan[jam]', '$data_penjualan[user]', '$data_penjualan[status]', '$data_penjualan[potongan]', '$data_penjualan[tax]', '$data_penjualan[sisa]', '$data_penjualan[kredit]', '$data_penjualan[total_hpp]', '$data_penjualan[cara_bayar]', '$data_penjualan[tunai]', '$data_penjualan[no_pesanan]', '$keterangan')");


    $ambil_detail_penjualan = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");
    while ($data_detail_penjualan = mysqli_fetch_array($ambil_detail_penjualan))
    {

     
    	$insert_batal_penjualan = $db->query("INSERT INTO batal_detail_penjualan (no_faktur, kode_meja, tanggal, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, status, hpp, sisa, no_pesanan, komentar, batal_detail_penjualan) VALUES ('$data_detail_penjualan[no_faktur]', '$data_detail_penjualan[kode_meja]', '$data_detail_penjualan[tanggal]', '$data_detail_penjualan[kode_barang]', '$data_detail_penjualan[nama_barang]', '$data_detail_penjualan[jumlah_barang]', '$data_detail_penjualan[satuan]', '$data_detail_penjualan[harga]', '$data_detail_penjualan[subtotal]', '$data_detail_penjualan[potongan]', '$data_detail_penjualan[tax]', '$data_detail_penjualan[status]', '$data_detail_penjualan[hpp]', '$data_detail_penjualan[sisa]', '$data_detail_penjualan[no_pesanan]', '$data_detail_penjualan[komentar]', '$keterangan')");

    }

    
    $hapus_data_penjualan = $db->query("DELETE FROM penjualan WHERE no_faktur = '$no_faktur'");
    $hapus_data_detail_penjualan = $db->query("DELETE FROM detail_penjualan WHERE no_faktur = '$no_faktur'");



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>