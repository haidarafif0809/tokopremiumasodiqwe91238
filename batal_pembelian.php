<?php session_start();
    // memasukan file db.php
    
    include 'db.php';
    include 'sanitasi.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 
    $session_id = session_id();
    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 

    if (isset($_GET['no_faktur'])) {

           $no_faktur = stringdoang($_GET['no_faktur']);

        $query = $db->query("DELETE FROM tbs_pembelian WHERE no_faktur = '$no_faktur'");
    }
    else
    {

        $query = $db->query("DELETE FROM tbs_pembelian WHERE session_id = '$session_id'");
    }

    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
	// dan jika salah maka akan menampilkan kalimat failed
    
    if ($query == TRUE)
    {
        header('location:formpembelian.php');
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>