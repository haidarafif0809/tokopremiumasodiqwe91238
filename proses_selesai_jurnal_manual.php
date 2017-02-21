<?php session_start();


    //memasukkan file db.php
include 'sanitasi.php';
include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST
$user = $_SESSION['user_name'];


$session_jurnal_manual = stringdoang($_POST['session_id']);
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);




    $perintah = $db->query ("INSERT INTO nomor_faktur_jurnal (no_faktur_jurnal,tanggal) VALUES ('".no_faktur_jurnal()."','$tanggal_sekarang')");

        if ($db->query($perintah) === TRUE)
        {
					echo '<div class="alert alert-danger" id="alert_gagal" style="display:none">
					<strong>Gagal!</strong> Anda Belum Memasukan Data
					</div>';

        }
        else
        {
					echo '<div class="alert alert-success" id="alert_berhasil" style="display:none">
					<strong>Sukses!</strong> Penambahan Berhasil
					</div>';

        }




              $keterangan = stringdoang($_POST['keterangan']);
              $kode_akun = stringdoang($_POST['kode_akun']);
              $nama_akun = stringdoang($_POST['nama_akun']);
              $jenis = stringdoang($_POST['jenis']);
              $tanggal = stringdoang($_POST['tanggal']);
              $debit = angkadoang($_POST['debit']);
              $kredit = angkadoang($_POST['kredit']);
              $no_transaksi = stringdoang($_POST['no_transaksi']);
              $no_ref = stringdoang($_POST['no_ref']);
              $t_debit = angkadoang($_POST['t_debit']);
              $t_kredit = angkadoang($_POST['t_kredit']);

              $user =  $_SESSION['user_name'];
$query60 = $db->query("SELECT * FROM tbs_jurnal");
while($data0 = mysqli_fetch_array($query60))
{
$select_no_jurnal = $db->query("SELECT * FROM nomor_faktur_jurnal ORDER BY id DESC LIMIT 1");
$ambil_no_jurnal = mysqli_fetch_array($select_no_jurnal);


if ($data0['session_id'] == $session_jurnal_manual) {





  
   $insert_no_faktur_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."','$tanggal $jam_sekarang','Jurnal Manual - $data0[keterangan]','$data0[kode_akun_jurnal]','$data0[debit]','$data0[kredit]','$jenis','$ambil_no_jurnal[no_faktur_jurnal]','1','$user')");

}

}



     $query3 = $db->query("DELETE FROM tbs_jurnal WHERE session_id = '$session_jurnal_manual'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   


    ?>