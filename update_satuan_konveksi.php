<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'satuan') {

    $select_satuan = stringdoang($_POST['select_satuan']);

        $query =$db->prepare("UPDATE satuan_konversi SET id_satuan = ?  WHERE id = ?");
        
        $query->bind_param("si",
        $select_satuan, $id);
        
        
        $query->execute();
        
        if (!$query) 
        {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }


}
elseif ($jenis_edit == 'Barcode') {


        $barcode = stringdoang($_POST['barcode']);
    
        $query =$db->prepare("UPDATE satuan_konversi SET kode_barcode = ?  WHERE id = ?");
        
        $query->bind_param("si",
        $barcode, $id);
        
        
        $query->execute();
        
        if (!$query) 
        {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }

}
elseif ($jenis_edit == 'Konversi') {


        $konversi = angkadoang($_POST['konversi']);
    
        $query =$db->prepare("UPDATE satuan_konversi SET konversi = ?  WHERE id = ?");
        
        $query->bind_param("ii",
        $konversi, $id);
        
        
        $query->execute();
        
        if (!$query) 
        {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }

}
elseif ($jenis_edit == 'harga_pokok') {


        $harga_pokok = angkadoang($_POST['harga_pokok']);
    
        $query =$db->prepare("UPDATE satuan_konversi SET harga_pokok = ?  WHERE id = ?");
        
        $query->bind_param("ii",
        $harga_pokok, $id);
        
        
        $query->execute();
        
        if (!$query) 
        {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }

}
elseif ($jenis_edit == 'harga_jual') {


        $harga_jual = angkadoang($_POST['harga_jual']);
    
        $query =$db->prepare("UPDATE satuan_konversi SET harga_jual_konversi = ?  WHERE id = ?");
        
        $query->bind_param("ii",
        $harga_jual, $id);
        
        
        $query->execute();
        
        if (!$query) 
        {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }

}



 ?>