<?php 

include 'db.php';

$kategori = $_GET['kategori'];

if ($kategori == 'semua') {
    
    $query = $db->query("SELECT * FROM barang");
}

else{
    $query = $db->query("SELECT * FROM barang WHERE kategori = '$kategori'");
}

while ($data=mysqli_fetch_array($query)) 
	{



echo '<div class="img" data-kode="'. $data['kode_barang'] .'" nama-barang="'. $data['nama_barang'] .'" harga="'. $data['harga_jual'] .'" foto="'. $data['foto'] .'" satuan="'. $data['satuan'] .'" ber_stok="'. $data['berkaitan_dgn_stok'] .'">
                
      <span style="cursor:pointer">';

if ($data['foto'] == "") {
 
 echo '<img src="save_picture/box.jpg " height="100px" width="100px" data-toggle="tooltip" data-placement="top" title="'. $data['nama_barang'] .'" class="test">';

}

else{

  echo '<img src="save_picture/'. $data['foto'] .'" height="100px" width="100px" data-toggle="tooltip" data-placement="top" title="'. $data['nama_barang'] .'" class="test">';

}
                        

    echo '</span>
                        
                        
                        
                        </div>';
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>

 <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>