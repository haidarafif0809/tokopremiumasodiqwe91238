<?php 
include 'db.php';


	
	$no_faktur = $_GET['no_faktur'];

    $perintah10 = $db->query("SELECT * FROM detail_pembelian WHERE no_faktur = '$no_faktur'");       
	while ($data2 = mysqli_fetch_array($perintah10))		
    		


			$perintah0 = $db->query("INSERT INTO tbs_pembelian (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax)
			VALUES ('$data2[no_faktur]','$data2[kode_barang]','$data2[nama_barang]','$data2[jumlah_barang]','$data2[satuan]','$data2[harga]','$data2[subtotal]','$data2[potongan]','$data2[tax]')");
			
			if ($perintah0 == TRUE)

				{
				header('location:formpembelian.php');
				}
				else
				{
				//menampilkan data
				echo "Error: " . $perintah0 . "<br>" . $db->error;
				}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>