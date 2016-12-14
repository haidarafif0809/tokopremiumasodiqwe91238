<?php
include 'sanitasi.php';
include 'db.php';

$id = stringdoang($_POST['id']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$kode_barang = stringdoang($_POST['kode_barang']);
$selisih_harga = angkadoang($_POST['selisih_harga']);
$selisih_fisik = angkadoang($_POST['selisih_fisik']);



    if ($selisih_fisik < 0) {

       // HARGA DARI HPP MASUK

       $pilih_hpp = $db->query("SELECT harga_unit FROM hpp_masuk WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
       $ambil_hpp = mysqli_fetch_array($pilih_hpp);
       $jumlah_hpp = $ambil_hpp['harga_unit'];


       // SAMPAI SINI

    } 

    else {

              // HARGA DARI DETAIL PEMBELIAN ATAU BARANG
        
        $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
        $num_rows = mysqli_num_rows($select2);
        $fetc_array = mysqli_fetch_array($select2);
        
        $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
        $ambil_barang = mysqli_fetch_array($select3);
        
        if ($num_rows == 0) {
        
        $jumlah_hpp = $ambil_barang['harga_beli'];
        
        } 
        
        else {
        
        $jumlah_hpp = $fetc_array['harga'];
        
        }
        
        // SAMPAI SINI


    }


$query = $db->prepare("UPDATE tbs_stok_opname SET fisik = ?, selisih_harga = ?, selisih_fisik = ?, hpp = ? WHERE id = ?");

$query->bind_param("iiiii",
	 $jumlah_baru, $selisih_harga, $selisih_fisik, $jumlah_hpp, $id);

$query->execute();


    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else
    {
    echo "sukses";
    }

        //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>