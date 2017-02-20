<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';

        //logika=> jika $perintah benar maka akan menuju ke barang.php, jika salah maka muncul kalimat error            
        $target_dir = "save_picture/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        } else {
        echo "File is not an image.";
        $uploadOk = 0;
        }
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "<center><h2>Maaf, hanya file berekstensi jpg, png, jpeg atau gif yang boleh di upload</h2></center>";
        $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["foto"]["name"]). " has been uploaded.";
        

              
// cek koneksi
if ($db->connect_errno) {
die('Koneksi gagal: ' .$db->connect_errno.
' - '.$db->connect_error);
}


 
// buat prepared statements
$stmt = $db->prepare("UPDATE barang SET foto = ? WHERE id = ?");
  
// hubungkan "data" dengan prepared statements
$stmt->bind_param("ss", 
$foto, $id );
 
// siapkan "data" query
	$foto = $_FILES['foto']['name'];
	$id = angkadoang($_POST['id']);
    

// jalankan query
$stmt->execute();
 
// cek query
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
   echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua">';
}
 
// tutup statements
$stmt->close();
 
// tutup koneksi
$db->close();
        
        
       
        
        
        } else {
        echo "Sorry, there was an error uploading your file.";
        }
        }



    
    ?>

