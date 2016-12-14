<?php 

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';



$perintah = $db->prepare("INSERT INTO satuan_konversi (id_satuan,id_produk,kode_produk,konversi,harga_pokok,harga_jual_konversi)
			VALUES (?,?,?,?,?,?)");

$perintah->bind_param("sissii",
	$nama_satuan_konversi, $id_produk, $kode_produk, $konversi, $harga_pokok, $harga_jual_konversi);

	$nama_satuan_konversi = stringdoang($_POST['nama_satuan_konversi']);
	$id_produk = angkadoang($_POST['id_produk']);
	$konversi = stringdoang($_POST['konversi']);
  $harga_pokok = angkadoang($_POST['harga_pokok']);
  $harga_jual_konversi = angkadoang($_POST['harga_jual_konversi']);
	$kode_produk = stringdoang($_POST['kode_produk']);

$perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}



 ?>

 <?php

    
 	$satuan_konversi = $db->query("SELECT * FROM satuan_konversi WHERE id_produk = '$id_produk' ORDER BY id DESC LIMIT 1");

    $data = mysqli_fetch_array($satuan_konversi);
    
      echo "<tr class='tr-id-".$data['id']."'>
      <td>". $data['id_satuan'] ."</td>
      <td>". $data['konversi'] ."</td>
      <td>". $data['harga_pokok'] ."</td>

      <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-satuan='". $data['id_satuan'] ."'> <i class='fa fa-trash'> </i> Hapus </button> </td>

      <td><button class='btn btn-success btn-edit' data-satuan='". $data['id_satuan'] ."' data-id='". $data['id'] ."' > <i class='fa fa-edit'> </i> Edit </button> </td>

      </tr>";



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>