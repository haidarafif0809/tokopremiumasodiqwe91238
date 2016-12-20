<?php 
include 'db.php';
include 'sanitasi.php';

 $no_faktur_pembelian = $_POST['no_faktur_hutang'];

 $query = $db->query("SELECT kredit FROM pembelian WHERE no_faktur = '$no_faktur_pembelian'");
 $data = mysqli_fetch_array($query);

 echo rp($data['kredit']);

 mysqli_close($db); 
        
  ?>


