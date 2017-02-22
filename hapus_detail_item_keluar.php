<?php 

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$no_faktur = $_GET['no_faktur'];




    
        $query3 = $db->query("SELECT * FROM detail_item_keluar WHERE no_faktur = '$no_faktur'");
    
        while($data = mysqli_fetch_array($query3))
        {

        //  '$data[jumlah]'== diambil dari jumlah dari tabel detail item masuk
        $query1 = "UPDATE barang SET jumlah_barang = jumlah_barang + '$data[jumlah]' WHERE kode_barang = '$data[kode_barang]'";
        // untuk mengecek kesalahn pada query
        if ($db->query($query1) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $query1 . "<br>" . $db->error;
}
 
        }




       
        $query = $db->query("DELETE FROM detail_item_keluar WHERE no_faktur = '$no_faktur'");

        

//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($query == TRUE)
{

header('location:detail_item_keluar.php');
}
else
{
    echo "failed";
    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
