<?php 
include 'db.php';
include 'sanitasi.php';

  $no_faktur_penjualan = $_POST['no_faktur_piutang'];
  $total = 0;

//UNTUK MERUBAH DATA BERUPA "ARRAY" MENJADI DATA BERUPA VARIABLE ($variable) GUNAKAN FITUR => foreach ($variable as $key => $value)
if ($no_faktur_penjualan == "") {
	$total = 0;
}
else{

	foreach ($no_faktur_penjualan as $nomor_faktur_penjualan ) {

		 $query = $db->query("SELECT kredit FROM penjualan WHERE no_faktur = '$nomor_faktur_penjualan'");
	 	 $data = mysqli_fetch_array($query);
	 	 $total = $total + $data['kredit'];
	}
	
}

  echo rp($total);

 mysqli_close($db); 


        
  ?>


