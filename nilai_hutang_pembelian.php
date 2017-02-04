<?php 
include 'db.php';
include 'sanitasi.php';

  $no_faktur_pembelian = $_POST['no_faktur_hutang'];
  $total = 0;

//UNTUK MERUBAH DATA BERUPA "ARRAY" MENJADI DATA BERUPA VARIABLE ($variable) GUNAKAN FITUR => foreach ($variable as $key => $value)

foreach ($no_faktur_pembelian as $nomor_faktur_pembelian ) {

	 $query = $db->query("SELECT kredit FROM pembelian WHERE no_faktur = '$nomor_faktur_pembelian'");
 	 $data = mysqli_fetch_array($query);
 	 $total = $total + $data['kredit'];
}

  echo rp($total);

 mysqli_close($db); 


        
  ?>


