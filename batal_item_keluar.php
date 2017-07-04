<?php session_start();
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 
    $session_id = session_id();
    // menghapus data pada tabel tbs_pembelian berdasarkan session_id 
    $query = $db->query("DELETE FROM tbs_item_keluar WHERE session_id = '$session_id'");
    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
	// dan jika salah maka akan menampilkan kalimat failed
    
    if ($query == TRUE)
    {
          header('location:item_keluar.php');
    }
    else
    {
        echo "failde";
    }


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
    ?>