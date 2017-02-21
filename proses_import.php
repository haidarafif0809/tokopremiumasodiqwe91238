<?php

include 'db.php'; 

$target_dir = "ktp/";
$target_file = $target_dir . basename($_FILES["import_excell"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if($imageFileType != "csv" ) {
    echo "<center><h2>Maaf, hanya file berekstensi csv yang boleh di upload</h2></center>";
   
}

else {

    if (is_uploaded_file($_FILES['import_excell']['tmp_name'])) {
            echo "<h1>" . "File ". $_FILES['import_excell']['name'] ." Berhasil di Import ke Database" . "</h1>";
            
        }
     
        //Import uploaded file to Database, Letakan dibawah sini..
        $handle = fopen($_FILES['import_excell']['tmp_name'], "r"); //Membuka file dan membacanya
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $import = "INSERT INTO barang (kode_barang,nama_barang,harga_beli,harga_jual,stok_barang,satuan,kategori,status,suplier,berkaitan_dgn_stok) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]')"; 

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

