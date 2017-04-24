<?php 

    include 'db.php';
    



    $nama = $_POST['nama'];
    $status = $_POST['status'];

    $query = $db->query("SELECT * FROM kas WHERE status = 'Ya'");
    $default = mysqli_num_rows($query);
    if ($status == 'Ya') {
        

        $query_update = $db->query("UPDATE kas SET status = ''");
         $perintah = $db->query("INSERT INTO kas (nama,status)
            VALUES ('$nama','$status')");
            
            if ($perintah == TRUE)
            {
            header ('location:kas.php');
            }
            else
            {
            echo "Data Tidak Berhasil Di Masukan";
            }

    }

    else
    {
            $perintah = $db->query("INSERT INTO kas (nama,status)
            VALUES ('$nama','$status')");
            
            if ($perintah == TRUE)
            {
            header ('location:kas.php');
            }
            else
            {
            echo "Data Tidak Berhasil Di Masukan";
            }

    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>