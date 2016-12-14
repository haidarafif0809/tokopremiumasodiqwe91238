<?php 
    // memasukan file db.php
    include 'db.php';
    // mengirim data no faktur menggunakan metode POST
    $nama = $_POST['dari_akun'];
    // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
    // berdasarkan no faktur
// MENCARI JUMLAH KAS
            $query0 = $db->query("SELECT SUM(total) AS total_penjualan FROM penjualan WHERE cara_bayar = '$nama'");
            $cek0 = mysqli_fetch_array($query0);
            $total_penjualan = $cek0['total_penjualan'];

            $query0000 = $db->query("SELECT SUM(kredit) AS kredit_penjualan FROM penjualan WHERE cara_bayar = '$nama'");
            $cek0000 = mysqli_fetch_array($query0000);
            $kredit_penjualan = $cek0000['kredit_penjualan'];

            $query2 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk FROM kas_masuk WHERE ke_akun = '$nama'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_kas_masuk = $cek2['jumlah_kas_masuk'];

            $query20 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk_mutasi FROM kas_mutasi WHERE ke_akun = '$nama'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_kas_masuk_mutasi = $cek20['jumlah_kas_masuk_mutasi'];

            $query200 = $db->query("SELECT SUM(total) AS total_retur_pembelian FROM retur_pembelian WHERE cara_bayar = '$nama'");
            $cek200 = mysqli_fetch_array($query200);
            $total_retur_pembelian = $cek200['total_retur_pembelian'];

//total kas 1

            $kas_1 = $total_penjualan - $kredit_penjualan + $jumlah_kas_masuk + $jumlah_kas_masuk_mutasi + $total_retur_pembelian;




            $query3 = $db->query("SELECT SUM(total) AS total_pembelian FROM pembelian WHERE cara_bayar = '$nama'");
            $cek3 = mysqli_fetch_array($query3);
            $total_pembelian = $cek3['total_pembelian'];

            $query0001 = $db->query("SELECT SUM(kredit) AS kredit_pembelian FROM pembelian WHERE cara_bayar = '$nama'");
            $cek0001 = mysqli_fetch_array($query0001);
            $kredit_pembelian = $cek0001['kredit_pembelian'];


            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM kas_keluar WHERE dari_akun = '$nama'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar = $cek5['jumlah_kas_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar_mutasi FROM kas_mutasi WHERE dari_akun = '$nama'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar_mutasi = $cek5['jumlah_kas_keluar_mutasi'];

            $query5 = $db->query("SELECT SUM(total) AS total_retur_penjualan FROM retur_penjualan WHERE cara_bayar = '$nama'");
            $cek5 = mysqli_fetch_array($query5);
            $total_retur_penjualan = $cek5['total_retur_penjualan'];



//total barang 2
            $kas_2 = $total_pembelian - $kredit_pembelian + $jumlah_kas_keluar + $jumlah_kas_keluar_mutasi + $total_retur_penjualan;







            echo $jumlah_kas = $kas_1 - $kas_2;

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>