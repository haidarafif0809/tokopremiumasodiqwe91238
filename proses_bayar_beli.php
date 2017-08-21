<?php session_start();

    include 'sanitasi.php';
    include 'db.php';
    include 'cache_folder/cache.class.php';

    $session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM pembelian ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM pembelian ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_faktur = "1/BL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $no_faktur = $nomor."/BL/".$data_bulan_terakhir."/".$tahun_terakhir;

}





           $tax = angkadoang($_POST['tax']);
           $total_1 = angkadoang($_POST['total_1']);
           $potongan = angkadoang($_POST['potongan']);
           $sisa = angkadoang($_POST['sisa']);
           $sisa_kredit = angkadoang($_POST['kredit']);
           $a = $total_1 - $potongan;
           $tax_persen = $tax * $a / 100;
           $suplier = stringdoang($_POST['suplier']);

$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$suplier'");
$ambil_suplier = mysqli_fetch_array($select_suplier);

        if ($sisa_kredit == 0 ) {

  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO pembelian (no_faktur, kode_gudang, suplier, total, tanggal, jam, user, status, potongan, tax, sisa, cara_bayar,tunai, status_beli_awal, ppn) VALUES (?,?,?,?,?,?,?,'Lunas',?,?,?,?,?,'Tunai',?)");
        
        
        
  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("sssisssiiisis", 
        $no_faktur, $kode_gudang, $suplier, $total , $tanggal_sekarang, $jam_sekarang, $user, $potongan, $tax_persen, $sisa, $cara_bayar, $pembayaran, $ppn_input);
        
  // siapkan "data" query
           
           $suplier = stringdoang($_POST['suplier']);
           $total = angkadoang($_POST['total']);
           $total_1 = angkadoang($_POST['total_1']);
           $potongan = angkadoang($_POST['potongan']);
           $tax = angkadoang($_POST['tax']);
           $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
           $sisa = angkadoang($_POST['sisa']);
           $ppn_input = stringdoang($_POST['ppn_input']);
           $cara_bayar = stringdoang($_POST['cara_bayar']);
           $kode_gudang = stringdoang($_POST['kode_gudang']);
           $pembayaran = angkadoang($_POST['pembayaran']);
           $t_total = $total_1 - $potongan;
        
           $user = $_SESSION['user_name'];

           $_SESSION['no_faktur']=$no_faktur;
  // jalankan query

        $stmt->execute();
        

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_pembelian WHERE session_id = '$session_id'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

           $ppn_input = stringdoang($_POST['ppn_input']);


if ($ppn_input == "Non") {

    $persediaan = $total_1;
    $total_akhir = $total;


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");
} 

else if ($ppn_input == "Include") {
//ppn == Include

  $persediaan = $total_1 - $total_tax;
  $total_akhir = $total;
  $pajak = $total_tax;

  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$no_faktur','1', '$user')");
}

}


else {

//ppn == Exclude
  $persediaan = $total_1;
  $total_akhir = $total;
  $pajak = $tax_persen;

  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$no_faktur','1', '$user')");
}

}



//KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$cara_bayar', '0', '$total_akhir', 'Pembelian', '$no_faktur','1', '$user')");

if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$no_faktur','1', '$user')");
}


        
        }
        
        else if ($sisa_kredit != 0)
        
        {
        
  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO pembelian (no_faktur, kode_gudang, suplier, total, tanggal,tanggal_jt, jam, user, status, potongan, tax, kredit, nilai_kredit, cara_bayar,tunai,status_beli_awal,ppn) VALUES (?,?,?,?,?,?,?,?,'Hutang',?,?,?,?,?,?,'Kredit',?)");
        
        
  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("sssissssiiiisis", 
        $no_faktur, $kode_gudang, $suplier, $total , $tanggal_sekarang, $tanggal_jt, $jam_sekarang, $user, $potongan, $tax_persen, $sisa_kredit, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input);
        
  // siapkan "data" query
           
           $suplier = stringdoang($_POST['suplier']);
           $total = angkadoang($_POST['total']);
           $total_1 = angkadoang($_POST['total_1']);
           $potongan = angkadoang($_POST['potongan']);
           $tax = angkadoang($_POST['tax']);
           $ppn_input = stringdoang($_POST['ppn_input']);
           $tanggal_jt = angkadoang($_POST['tanggal_jt']);
           $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
           $sisa_kredit = angkadoang($_POST['kredit']);
           $cara_bayar = stringdoang($_POST['cara_bayar']);
           $kode_gudang = stringdoang($_POST['kode_gudang']);
           $pembayaran = angkadoang($_POST['pembayaran']);
           $t_total = $total_1 - $potongan;
           
           $user = $_SESSION['user_name'];

           $_SESSION['no_faktur']=$no_faktur;

  // jalankan query
           $stmt->execute();




$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_pembelian WHERE session_id = '$session_id'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

           $ppn_input = stringdoang($_POST['ppn_input']);


if ($ppn_input == "Non") {

    $persediaan = $total_1;
    $total_akhir = $total;

      //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");

    }

else if ($ppn_input == "Include") {
//ppn == Include

  $persediaan = $total_1 - $total_tax;
  $total_akhir = $total;
  $pajak = $total_tax;


//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$no_faktur','1', '$user')");
      }


}

else {

//ppn == Exclude
  $persediaan = $total_1;
  $total_akhir = $total;
  $pajak = $tax_persen;

//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$no_faktur','1', '$user')");
if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$no_faktur','1', '$user')");
      }


}

//HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[hutang]', '0', '$sisa_kredit', 'Pembelian', '$no_faktur','1', '$user')");

     if ($pembayaran > 0 ) 
     
        {
//KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$cara_bayar', '0', '$pembayaran', 'Pembelian', '$no_faktur','1', '$user')");
        }


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$no_faktur','1', '$user')");
}



    // cek query
    if (!$stmt) {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else {
    
    }
 
// tutup statements

}

    $query = $db->query("SELECT * FROM tbs_pembelian WHERE session_id = '$session_id'");
    while ($data = mysqli_fetch_array($query)){

      $query_barang = $db->query("SELECT harga_beli,satuan FROM barang WHERE kode_barang = '$data[kode_barang]' ");
      $data_barang = mysqli_fetch_array($query_barang);



      $pilih_konversi = $db->query("SELECT sk.konversi * $data[jumlah_barang] AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);

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
       

        $query2 = "INSERT INTO detail_pembelian (no_faktur, no_faktur_order, tanggal, jam, waktu, kode_barang, nama_barang, jumlah_barang, asal_satuan, satuan, harga, subtotal, potongan, tax, sisa) VALUES ('$no_faktur','$data[no_faktur_order]','$tanggal_sekarang','$jam_sekarang','$waktu','$data[kode_barang]','$data[nama_barang]','$jumlah_barang', '$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$jumlah_barang')";

        if ($db->query($query2) === TRUE) {
        } 

        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }

        $update_order = "UPDATE pembelian_order SET status_order = 'Di Beli' WHERE no_faktur_order = '$data[no_faktur_order]'";

        if ($db->query($update_order) === TRUE) {
        }
        else {
          echo "Error: " . $update_order . "<br>" . $db->error;
        }

      if($data['harga'] != $data_barang['harga_beli']){

        //Cek apakah barang tersebut memiliki Konversi ?
        $query_cek_satuan_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
        $data_jumlah_konversi = mysqli_fetch_array($query_cek_satuan_konversi);
        $data_jumlah = mysqli_num_rows($query_cek_satuan_konversi);


        if($data_jumlah > 0){
          $hasil_konversi = $data['harga'] / $data_jumlah_konversi['konversi'];
          //Jika Iya maka ambil harga setelah di bagi dengan jumlah barang yang sebenarnya di konversi !!
          $harga_beli_sebenarnya = $hasil_konversi;
          //Update Harga Pokok pada konversi
          $query_update_harga_konversi  = $db->query("UPDATE satuan_konversi SET harga_pokok = '$data[harga]' WHERE kode_produk = '$data[kode_barang]'");
         
        }
        else{
          //Jika Tidak ambil harga yang sebenarnya dari TBS !!
          $harga_beli_sebenarnya = $data['harga'];
        }

          //UPDATE CACHE 
              // membuat objek cache
            $cache = new Cache();
            // setting default cache 
            $cache->setCache('produk');
            // hapus cache
            $cache->eraseAll();

            $query_update_harga_beli  = $db->query("UPDATE barang SET harga_beli = '$harga_beli_sebenarnya' WHERE kode_barang = '$data[kode_barang]'");
          
          $query_update_barang_cache = $db->query("SELECT * FROM barang ");
          while ($data_update = $query_update_barang_cache->fetch_array()) {
         
          // store an array
              $cache->store($data_update['kode_barang'], array(
            'kode_barang' => $data_update['kode_barang'],
            'nama_barang' => $data_update['nama_barang'],
            'harga_beli' => $data_update['harga_beli'],
            'harga_jual' => $data_update['harga_jual'],
            'harga_jual2' => $data_update['harga_jual2'],
            'harga_jual3' => $data_update['harga_jual3'],
            'harga_jual4' => $data_update['harga_jual4'],
            'harga_jual5' => $data_update['harga_jual5'],
            'harga_jual6' => $data_update['harga_jual6'],
            'harga_jual7' => $data_update['harga_jual7'],
            'kategori' => $data_update['kategori'],
            'suplier' => $data_update['suplier'],
            'limit_stok' => $data_update['limit_stok'],
            'over_stok' => $data_update['over_stok'],
            'berkaitan_dgn_stok' => $data_update['berkaitan_dgn_stok'],
            'tipe_barang' => $data_update['tipe_barang'],
            'status' => $data_update['status'],
            'satuan' => $data_update['satuan'],
            'id' => $data_update['id'],
                ));
            }
        $cache->retrieveAll();
        //UPDATE CACHE 

      }
        
    }




    $query3 = $db->query("DELETE FROM tbs_pembelian WHERE session_id = '$session_id'");



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>