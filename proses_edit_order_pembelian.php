<?php session_start();

  include 'sanitasi.php';
  include 'db.php';

  $jam_sekarang = date('H:i:s');

try {

 echo $no_faktur = stringdoang($_POST['no_faktur']);
      $tanggal = stringdoang($_POST['tanggal']);
      $total = angkadoang($_POST['total2']);
      $user = $_SESSION['nama'];
      $suplier = stringdoang($_POST['suplier']);
      $no_jurnal = no_jurnal();

    $hapus_detail_order = $db->query("DELETE FROM detail_pembelian_order WHERE no_faktur_order = '$no_faktur' ");

    $query = $db->query("SELECT * FROM tbs_pembelian_order WHERE no_faktur_order = '$no_faktur' ORDER BY kode_barang ");
    while ($data = mysqli_fetch_array($query))
      {

      $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_barang] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);
      $data_rows = mysqli_num_rows($pilih_konversi);

      if ($data_rows > 0) {

            if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
              $harga = $data_konversi['harga_konversi'];
              $jumlah_barang = $data_konversi['jumlah_konversi'];
              $satuan = $data_konversi['satuan'];
            }
            else{
              $harga = $data['harga'];
              $jumlah_barang = $data['jumlah_barang'];
              $satuan = $data['satuan'];
            }
        
      }
      
      else{
        $harga = $data['harga'];
        $jumlah_barang = $data['jumlah_barang'];
        $satuan = $data['satuan'];
      }

      
        $query2 = "INSERT INTO detail_pembelian_order (no_faktur_order,kode_barang, nama_barang, jumlah_barang,satuan, harga, subtotal, potongan, tax,tanggal,jam,asal_satuan) VALUES ('$no_faktur','$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$tanggal','$jam_sekarang','$satuan')";

        if ($db->query($query2) === TRUE) {

        } 
        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }
        
      }


            // buat prepared statements
            $stmt2 = $db->prepare("UPDATE pembelian_order SET no_faktur_order = ?, kode_gudang = ?, suplier = ?, total = ?, tanggal = ?, jam = ?, user_edit = ? , keterangan = ? WHERE no_faktur_order = ?");
          
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("sssisssss", 
            $no_faktur, $kode_gudang, $suplier, $total, $tanggal, $jam_sekarang , $user, $keterangan, $no_faktur);

            
            // siapkan "data" query
              $keterangan = stringdoang($_POST['keterangan']);
              $kode_gudang = stringdoang($_POST['kode_gudang']);
              $total = angkadoang($_POST['total2']);            
              $ppn_input = stringdoang($_POST['ppn_input']);
              $suplier = stringdoang($_POST['suplier']);
              $user = $_SESSION['nama'];
            
            // jalankan query
            
            $stmt2->execute();  
              


    $query3 = $db->query("DELETE FROM tbs_pembelian_order WHERE no_faktur_order = '$no_faktur'");


    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>