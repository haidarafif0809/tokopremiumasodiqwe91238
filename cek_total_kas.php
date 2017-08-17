<?php 
    // memasukan file db.php
    include 'db.php';
    include 'sanitasi.php';
    // mengirim data no faktur menggunakan metode POST
     $nama = stringdoang($_POST['ke_akun']);
     $no_faktur = stringdoang($_POST['no_faktur']);
            
            $query0 = $db->query("SELECT SUM(debit) - SUM(kredit) AS total_kas FROM jurnal_trans WHERE kode_akun_jurnal = '$nama' AND no_faktur != '$no_faktur' ");
            $cek0 = mysqli_fetch_array($query0);
           echo $total_kas = $cek0['total_kas'];

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>