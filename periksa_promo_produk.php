<?php

include 'db.php';

$id = $_POST['id_produk'];
$id_program = $_POST['id_program'];

$query_program = $db->query("SELECT pp.batas_akhir, pfp.nama_produk, DATEDIFF(pp.batas_akhir, DATE(NOW())) AS tanggal FROM program_promo pp INNER JOIN promo_free_produk pfp ON pp.id = pfp.nama_program WHERE pfp.nama_produk = '$id' HAVING tanggal >= 0");
$data_program = mysqli_num_rows($query_program);

if ($data_program > 0){

  echo "1";
}
else {

}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

