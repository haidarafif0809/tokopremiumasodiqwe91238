<?php include 'session_login.php';
	//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST
    

    $id = angkadoang($_POST['id']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

    if ($jenis_edit == 'jumlah') {
       
           $jumlah = angkadoang($_POST['jumlah']);


           // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
                $query = $db->prepare("UPDATE setting_diskon_jumlah SET syarat_jumlah = ? WHERE id = ? ");
                
                $query->bind_param("ii",
                    $jumlah, $id);

                $query->execute();

            if (!$query) 
            {
             die('Query Error : '.$db->errno.
             ' - '.$db->error);
            }

    }
    elseif ($jenis_edit == 'potongan') 
    {
            $potongan = angkadoang($_POST['potongan']);

            // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
            $query = $db->prepare("UPDATE setting_diskon_jumlah SET potongan = ? WHERE id = ? ");
            
                $query->bind_param("ii",
              $potongan, $id);

            $query->execute();

        if (!$query) 
        {
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }

    }
    

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>