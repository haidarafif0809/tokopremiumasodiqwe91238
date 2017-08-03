<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $nomor_faktur = stringdoang($_POST['no_faktur']);
    

$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');



$tanggal = stringdoang($_POST['tanggal']);
$waktu = $tanggal." ".$jam_sekarang;
$kode_pelanggan = stringdoang($_POST['kode_pelanggan']);


                $delete_detail_penjualan = $db->query("DELETE FROM detail_penjualan_order WHERE no_faktur_order = '$nomor_faktur' ");


$select_kode_pelanggan = $db->query("SELECT id,nama_pelanggan FROM pelanggan WHERE id = '$kode_pelanggan'");
$ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);
            
         


            $query12 = $db->query("SELECT * FROM tbs_penjualan_order WHERE no_faktur_order = '$nomor_faktur' ");
            while ($data = mysqli_fetch_array($query12))
            
            {

            
                  $pilih_konversi = $db->query("SELECT COUNT(sk.konversi) AS jumlah_data,sk.konversi, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.kode_produk = b.kode_barang AND sk.id_produk = b.id WHERE sk.kode_produk = '$data[kode_barang]' AND sk.id_satuan = '$data[satuan]'");
                  $data_konversi = mysqli_fetch_array($pilih_konversi);

                  if ($data_konversi['jumlah_data'] != 0) {
                        
                        $harga_konversi = $data['harga_konversi'];
                        $jumlah_barang = $data['jumlah_barang'] * $data_konversi['konversi'];
                        $satuan = $data['satuan'];

                  }
                  else{

                        $harga_konversi = 0;
                        $jumlah_barang = $data['jumlah_barang'];
                        $satuan = $data['satuan'];
                  }

             
            $query2 = "INSERT INTO detail_penjualan_order (no_faktur_order,kode_barang, nama_barang, jumlah_barang,satuan, harga, subtotal, potongan, tax,tanggal,jam,asal_satuan,harga_konversi,tipe_barang)
             VALUES ('$nomor_faktur','$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$data[satuan]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]','$data[tanggal]','$data[jam]','$satuan','$harga_konversi','$data[tipe_barang]')";


                       if ($db->query($query2) === TRUE) {
                       } 
                       
                       else {
                       echo "Error: " . $query2 . "<br>" . $db->error;
                       }
                       
            } 

            
        
            
            // buat prepared statements
            $stmt2 = $db->prepare("UPDATE penjualan_order SET no_faktur_order = ?, kode_gudang = ?, kode_pelanggan = ?, total = ?, tanggal = ?, jam = ?, user = ? , keterangan = ? WHERE no_faktur_order = ?");
          
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("sssisssss", 
            $nomor_faktur, $kode_gudang, $kode_pelanggan, $total, $tanggal, $jam_sekarang , $sales, $keterangan, $nomor_faktur);

            
            // siapkan "data" query
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
            $total = angkadoang($_POST['total2']);
            $keterangan = stringdoang($_POST['keterangan']);

            $sales = stringdoang($_POST['sales']);
            $user = $_SESSION['user_name'];
            $tanggal = stringdoang($_POST['tanggal']);
            $kode_gudang = stringdoang($_POST['kode_gudang']);
            
            // jalankan query
            
            $stmt2->execute();    

            
            $perintah2 = $db->query("DELETE FROM tbs_penjualan_order WHERE no_faktur_order = '$nomor_faktur'");



    // cek query
if (!$stmt2) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}




    echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>