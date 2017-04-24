<?php

include 'sanitasi.php';
include 'db.php';


$query00 = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");
$data = mysqli_fetch_array($query00);

$query0 = $db->query("SELECT SUM(total) AS total_penjualan FROM penjualan WHERE cara_bayar = '$data[kode_daftar_akun]' AND status_jual_awal = 'Tunai'");
            $cek0 = mysqli_fetch_array($query0);
            $total_penjualan = $cek0['total_penjualan'];

            $query0000 = $db->query("SELECT SUM(kredit) AS kredit_penjualan FROM penjualan WHERE cara_bayar = '$data[kode_daftar_akun]'");
            $cek0000 = mysqli_fetch_array($query0000);
            $kredit_penjualan = $cek0000['kredit_penjualan'];

            $query2 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk FROM kas_masuk WHERE ke_akun = '$data[kode_daftar_akun]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_kas_masuk = $cek2['jumlah_kas_masuk'];

            $query20 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk_mutasi FROM kas_mutasi WHERE ke_akun = '$data[kode_daftar_akun]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_kas_masuk_mutasi = $cek20['jumlah_kas_masuk_mutasi'];

            $query200 = $db->query("SELECT SUM(total) AS total_retur_pembelian FROM retur_pembelian WHERE cara_bayar = '$data[kode_daftar_akun]'");
            $cek200 = mysqli_fetch_array($query200);
            $total_retur_pembelian = $cek200['total_retur_pembelian'];

            $piutang = $db->query("SELECT SUM(total) AS total_piutang FROM pembayaran_piutang WHERE dari_kas = '$data[kode_daftar_akun]'");
            $cek_piutang = mysqli_fetch_array($piutang);
            $total_piutang = $cek_piutang['total_piutang'];

            $sum_tunai_penjualan = $db->query("SELECT  SUM(tunai) AS tunai_penjualan FROM penjualan WHERE cara_bayar = '$data[kode_daftar_akun]' AND status_jual_awal = 'Kredit'");
            $data_tunai_penjualan = mysqli_fetch_array($sum_tunai_penjualan);
            $tunai_penjualan = $data_tunai_penjualan['tunai_penjualan'];


//total kas 1

            $kas_1 = $total_penjualan + $jumlah_kas_masuk + $jumlah_kas_masuk_mutasi + $total_retur_pembelian + $total_piutang + $tunai_penjualan;




            $query3 = $db->query("SELECT SUM(total) AS total_pembelian FROM pembelian WHERE cara_bayar = '$data[kode_daftar_akun]' AND status_beli_awal = 'Tunai' ");
            $cek3 = mysqli_fetch_array($query3);
            $total_pembelian = $cek3['total_pembelian'];

            $query0001 = $db->query("SELECT SUM(kredit) AS kredit_pembelian FROM pembelian WHERE cara_bayar = '$data[kode_daftar_akun]'");
            $cek0001 = mysqli_fetch_array($query0001);
            $kredit_pembelian = $cek0001['kredit_pembelian'];


            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM kas_keluar WHERE dari_akun = '$data[kode_daftar_akun]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar = $cek5['jumlah_kas_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar_mutasi FROM kas_mutasi WHERE dari_akun = '$data[kode_daftar_akun]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar_mutasi = $cek5['jumlah_kas_keluar_mutasi'];

            $query5 = $db->query("SELECT SUM(total) AS total_retur_penjualan FROM retur_penjualan WHERE cara_bayar = '$data[kode_daftar_akun]'");
            $cek5 = mysqli_fetch_array($query5);
            $total_retur_penjualan = $cek5['total_retur_penjualan'];

            $hutang = $db->query("SELECT SUM(total) AS total_hutang FROM pembayaran_hutang WHERE dari_kas = '$data[kode_daftar_akun]' ");
            $cek_hutang = mysqli_fetch_array($hutang);
            $total_hutang = $cek_hutang['total_hutang'];

            $sum_tunai_pembelian = $db->query("SELECT SUM(tunai) AS tunai_pembelian FROM pembelian WHERE cara_bayar = '$data[kode_daftar_akun]' AND status_beli_awal = 'Kredit'");
            $data_tunai_pembelian = mysqli_fetch_array($sum_tunai_pembelian);
            $tunai_pembelian = $data_tunai_pembelian['tunai_pembelian'];




//total barang 2
            $kas_2 = $total_pembelian + $jumlah_kas_keluar + $jumlah_kas_keluar_mutasi + $total_retur_penjualan + $total_hutang + $tunai_pembelian;







            $jumlah_kas = $kas_1 - $kas_2;
            $input_jumlah = angkadoang($_POST['input_jumlah']);

            $x = $jumlah_kas - $input_jumlah;


if ($x < 0){

  echo '<div class="alert alert-danger">
            <strong>PERHATIAN!</strong> Jumlah Kas Keluar Tidak Mencukupi.
        </div>';

}

else{

    echo $id = angkadoang($_POST['id']);
    $input_jumlah = angkadoang($_POST['input_jumlah']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'jumlah') {

$query = $db->prepare("UPDATE tbs_kas_keluar SET jumlah = ? WHERE id = ?");

$query->bind_param("ii",
    $input_jumlah, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<div class="alert alert-info">
            <strong>SUKSES!</strong> Pengeluaran Berhasil.
        </div>';
    }

}

}

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>

