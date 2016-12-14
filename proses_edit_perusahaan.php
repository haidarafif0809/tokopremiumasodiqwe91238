<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);



       $query =$db->prepare("UPDATE perusahaan SET nama_perusahaan = ?, alamat_perusahaan = ?, singkatan_perusahaan = ?, foto= ?, no_telp = ?, no_fax = ? WHERE id = ?");

       $query->bind_param("ssssssi",
        $nama_perusahaan, $alamat_perusahaan, $singkatan_perusahaan, $foto, $nomor, $no_fax, $id);

           
         
           $nama_perusahaan = stringdoang($_POST['nama_perusahaan']);
           $alamat_perusahaan = stringdoang($_POST['alamat_perusahaan']);
           $singkatan_perusahaan = stringdoang($_POST['singkatan_perusahaan']);
           $foto = stringdoang($_FILES['foto']['name']);
           $nomor = stringdoang($_POST['no_telp']);
           $no_fax = stringdoang($_POST['no_fax']);
           $id = angkadoang($_POST['id']);

        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   
}


        //logika=> jika $perintah benar maka akan menuju ke barang.php, jika salah maka muncul kalimat error            
        $target_dir = "save_picture/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) 

        {

        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if($check !== false) 

        {

        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;

        } 

        else 

        {

        echo "File is not an image.";
        $uploadOk = 0;

        }

        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) 

        {

        echo "<center><h2>Maaf, hanya file berekstensi jpg, png, jpeg atau gif yang boleh di upload</h2></center>";
        $uploadOk = 0;

        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) 
        {
        
        // if everything is ok, try to upload file
        } 

        else 

    {
        
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) 

        {

        echo "The file ". basename( $_FILES["foto"]["name"]). " has been uploaded.";
        

               echo '<META HTTP-EQUIV="Refresh" Content="0; URL=setting_perusahaan.php">';
              
               
           
              

        
        
       
        
        
        } 
            else 
            {
            echo "Sorry, there was an error uploading your file.";
            }
    }


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>