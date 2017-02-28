<?php include 'session_login.php';
	//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST
    

    $id = angkadoang($_POST['id']);


    $jenis_edit = stringdoang($_POST['jenis_edit']);
    $waktu = date('Y-m-d H:i:sa');
    $user = $_SESSION['nama'];

    if ($jenis_edit == 'edit-lama-tidak-aktif') {
       
           $lama_tidak_aktif = angkadoang($_POST['lama_tidak_aktif1']);


           // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
                $query = $db->prepare("UPDATE setting_member SET lama_tidak_aktif = ?, user_terakhir = ?, terakhir_edit = ? WHERE id = ? ");
                
                $query->bind_param("issi",
                    $lama_tidak_aktif,$user,$waktu, $id);

                $query->execute();

            if (!$query) 
            {
             die('Query Error : '.$db->errno.
             ' - '.$db->error);
            }

    }
    elseif ($jenis_edit == 'satuan') 
    {
            $satuan = angkadoang($_POST['satuan']);

            // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
            $query = $db->prepare("UPDATE setting_member SET satuan_tidak_aktif = ?, user_terakhir = ?, terakhir_edit = ? WHERE id = ? ");
            
                $query->bind_param("issi",
                $satuan,$user,$waktu, $id);

            $query->execute();

        if (!$query) 
        {
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }

    }

    elseif ($jenis_edit == 'aktif_kembali') 
    {
    $aktif_kembali = angkadoang($_POST['aktif_kembali']);

            // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
            $query = $db->prepare("UPDATE setting_member SET aktif_kembali = ?, user_terakhir = ?, terakhir_edit = ? WHERE id = ? ");
            
                $query->bind_param("issi",
                $aktif_kembali,$user,$waktu, $id);

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