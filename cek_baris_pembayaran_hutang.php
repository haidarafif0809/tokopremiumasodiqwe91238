<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
    $nomor_faktur = $_POST['no_faktur'];

    $jumlah_bayar_hutang = $db->query("SELECT SUM(jumlah_bayar) AS jumlah_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$nomor_faktur'");

    $ambil_jumlah = mysqli_num_rows($jumlah_bayar_hutang);

    if ($ambil_jumlah > 0) {

        echo "1";
        
    } 
    else {
        
    }
    


    ?>