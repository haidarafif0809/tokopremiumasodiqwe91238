<?php

include 'db.php'; 

$target_dir = "csv_pelanggan/";
$target_file = $target_dir . basename($_FILES["csv_pelanggan"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if($imageFileType != "csv" ) {
    echo "<center><h2>Maaf, hanya file berekstensi csv yang boleh di upload</h2></center>";
   
}

else {

    if (is_uploaded_file($_FILES['csv_pelanggan']['tmp_name'])) {
            echo "<h1>" . "File ". $_FILES['csv_pelanggan']['name'] ." Berhasil di Import ke Database" . "</h1>";
            
        }
     
        //Import uploaded file to Database, Letakan dibawah sini..
        $handle = fopen($_FILES['csv_pelanggan']['tmp_name'], "r"); //Membuka file dan membacanya
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $import = "INSERT INTO pelanggan (nama_pelanggan,wilayah,no_telp) values('$data[0]','$data[1]','$data[2]')"; 

if ($db->query($import) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $import . "<br>" . $db->error;
}
            //data array sesuaikan dengan jumlah kolom pada CSV anda mulai dari “0” bukan “1”
            //Melakukan Import
        }
     
        fclose($handle); //Menutup CSV file
        echo "<br><strong>Import data selesai.</strong>";
        
    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>

