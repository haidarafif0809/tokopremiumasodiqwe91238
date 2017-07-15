<?php session_start();

  include 'sanitasi.php';
  include 'db.php';

  $session_id = session_id();  
  $tahun_sekarang = date('Y');
  $bulan_sekarang = date('m');
  $tanggal_sekarang = date('Y-m-d');
  $jam_sekarang = date('H:i:s');
  $tahun_terakhir = substr($tahun_sekarang, 2);


try {
    // First of all, let's begin a transaction
    $db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown
    //mengecek jumlah karakter dari bulan sekarang
    $cek_jumlah_bulan = strlen($bulan_sekarang);
    //jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
    if ($cek_jumlah_bulan == 1) {
      $data_bulan_terakhir = "0".$bulan_sekarang;
     }
     else {
      $data_bulan_terakhir = $bulan_sekarang;
     }
    //ambil bulan dari tanggal pembelian terakhir
    $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM pembelian_order ORDER BY id DESC LIMIT 1");
    $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);
    //ambil nomor  dari pembelian terakhir
    $no_terakhir = $db->query("SELECT no_faktur_order FROM pembelian_order ORDER BY id DESC LIMIT 1");
     $v_no_terakhir = mysqli_fetch_array($no_terakhir);
    $ambil_nomor = substr($v_no_terakhir['no_faktur_order'],0,-8);
    /*jika bulan terakhir dari pembelian tidak sama dengan bulan sekarang, 
    maka nomor nya kembali mulai dari 1 ,
    jika tidak maka nomor terakhir ditambah dengan 1     
     */
    if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
      echo $no_faktur = "1/OP/".$data_bulan_terakhir."/".$tahun_terakhir;
    }
    else {
            $nomor = 1 + $ambil_nomor ;
      echo $no_faktur = $nomor."/OP/".$data_bulan_terakhir."/".$tahun_terakhir;
    }

    $total = angkadoang($_POST['total2']);
    $user = $_SESSION['nama'];
    $suplier = stringdoang($_POST['suplier']);
    $no_jurnal = no_jurnal();

    $query = $db->query("SELECT * FROM tbs_pembelian_order WHERE session_id = '$session_id' ORDER BY kode_barang ");
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

      
        $query2 = "INSERT INTO detail_pembelian_order (no_faktur_order,kode_barang, nama_barang, jumlah_barang,satuan, harga, subtotal, potongan, tax,tanggal,jam,asal_satuan) VALUES ('$no_faktur','$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$tanggal_sekarang','$jam_sekarang','$satuan')";

        if ($db->query($query2) === TRUE) {

        } 
        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }
        
      }

              $stmt = $db->prepare("INSERT INTO pembelian_order (no_faktur_order, kode_gudang, suplier, total, tanggal, jam, user, status_order,keterangan) VALUES (?,?,?,?,?,?,?,'Di Order',?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssissss",
              $no_faktur, $kode_gudang, $suplier, $total, $tanggal_sekarang, $jam_sekarang, $user, $keterangan);
              
              
              $keterangan = stringdoang($_POST['keterangan']);
              $kode_gudang = stringdoang($_POST['kode_gudang']);
              $total = angkadoang($_POST['total2']);            
              $ppn_input = stringdoang($_POST['ppn_input']);
              $suplier = stringdoang($_POST['suplier']);
              $user = $_SESSION['nama'];
              
    // jalankan query
              $stmt->execute();
              


    $query3 = $db->query("DELETE  FROM tbs_pembelian_order WHERE session_id = '$session_id'");


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