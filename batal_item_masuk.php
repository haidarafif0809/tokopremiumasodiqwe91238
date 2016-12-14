<?php 
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 
    $no_faktur = $_GET['no_faktur'];
    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
    $query = $db->query("DELETE FROM tbs_item_masuk WHERE no_faktur = '$no_faktur'");
    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
	// dan jika salah maka akan menampilkan kalimat failed
    
    if ($query == TRUE)
    {
        header('location:form_item_masuk.php');
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>