<?php include 'session_login.php';
	//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST
    
    $id = angkadoang($_POST['id']);
    $poin_baru = angkadoang($_POST['poin_baru']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);
    $waktu = date('Y-m-d H:i:sa');
    $user = $_SESSION['nama'];

    if ($jenis_edit == 'edit-poin-rp') {
       
           // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
                $query = $db->prepare("UPDATE aturan_poin SET poin_rp = ?, user_terakhir = ?, terakhir_edit = ? WHERE id = ? ");
                
                $query->bind_param("issi",
                    $poin_baru,$user,$waktu, $id);

                $query->execute();

            if (!$query) 
            {
             die('Query Error : '.$db->errno.
             ' - '.$db->error);
            }

    }
    elseif ($jenis_edit == 'edit-nilai-poin') 
    {

            // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
            $query = $db->prepare("UPDATE aturan_poin SET nilai_poin = ?, user_terakhir = ?, terakhir_edit = ? WHERE id = ? ");
            
                $query->bind_param("issi",
                    $poin_baru,$user,$waktu, $id);

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