<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$tanggal = stringdoang($_POST['tanggal']);
$waktu = $tanggal." ".$jam_sekarang;
$suplier = stringdoang($_POST['suplier']);

$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$suplier'");
$ambil_suplier = mysqli_fetch_array($select_suplier);


    $nomor_faktur = stringdoang($_POST['no_faktur']);

            $perintah1 = $db->query("DELETE FROM detail_pembelian WHERE no_faktur = '$nomor_faktur'");



            $sisa_kredit = angkadoang($_POST['jumlah_kredit_baru']);

            if ($sisa_kredit == 0 ) 
            {
                            // buat prepared statements
            $stmt2 = $db->prepare("UPDATE pembelian SET no_faktur = ?, suplier = ?, total = ?, tanggal = ?, jam = ?, user = ?, status = 'Lunas', potongan = ?, tax = ?, sisa = ?, kredit = ?, cara_bayar = ?, tunai = ?, status_beli_awal = 'Tunai', ppn = ? WHERE no_faktur = ?");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("ssisssiiiisiss", 
            $nomor_faktur, $suplier, $total , $tanggal, $jam_sekarang, $user, $potongan, $tax_persen, $sisa, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input, $nomor_faktur);

            
            // siapkan "data" query
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            $suplier = stringdoang($_POST['suplier']);
            $total = angkadoang($_POST['total']);
            $total_1 = angkadoang($_POST['total_1']);
            $potongan = angkadoang($_POST['potongan']);
            $tax = angkadoang($_POST['tax']);
            $ppn_input = stringdoang($_POST['ppn_input']);
            $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
            $sisa_kredit = 0;
            $cara_bayar = stringdoang($_POST['cara_bayar']);
            $pembayaran = angkadoang($_POST['pembayaran']);
            $tanggal = stringdoang($_POST['tanggal']);
            $user = $_SESSION['user_name'];
            
            $x = angkadoang($_POST['x']);
            
            if ($x <= $total) {
            $sisa = 0;
            } 
            
            else {
            $sisa = $x - $total;
            }

            $t_total = $total_1 - $potongan;

            $a = $total_1 - $potongan;
            $tax_persen = $tax * $a / 100;
            

            $_SESSION['no_faktur']=$nomor_faktur;
            
            // jalankan query
            
            $stmt2->execute(); 


$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_pembelian WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

           $ppn_input = stringdoang($_POST['ppn_input']);


if ($ppn_input == "Non") {
echo $ppn_input;
    $persediaan = $total_1;
    $total_akhir = $total;


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
} 

else if ($ppn_input == "Include") {
//ppn == Include
echo $ppn_input;
  $persediaan = $total_1 - $total_tax;
  $total_akhir = $total;
  $pajak = $total_tax;

  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
}

}

else {
    echo $ppn_input;

//ppn == Exclude
  $persediaan = $total_1;
  $total_akhir = $total;
  $pajak = $tax_persen;

  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
}

}



//KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$cara_bayar', '0', '$total_akhir', 'Pembelian', '$nomor_faktur','1', '$user')");

if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$nomor_faktur','1', '$user')");
}


        
        }
            else if ($sisa_kredit != 0 ) 

            {
            
            $stmt2 = $db->prepare("UPDATE pembelian SET no_faktur = ?, suplier = ?, total = ?, tanggal = ?, jam = ?, tanggal_jt = ?, user = ?, status = 'Hutang', potongan = ?, tax = ?, sisa = ?, kredit = ?, cara_bayar = ?, tunai = ?, status_beli_awal = 'Kredit', ppn = ? WHERE no_faktur = ?");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("ssissssiiiisiss", 
            $nomor_faktur, $suplier, $total , $tanggal, $jam_sekarang, $tanggal_jt, $user, $potongan, $tax, $sisa, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input, $nomor_faktur);
            
            // siapkan "data" query
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            $suplier = stringdoang($_POST['suplier']);
            $total = angkadoang($_POST['total']);
            $total_1 = angkadoang($_POST['total_1']);
            $potongan = angkadoang($_POST['potongan']);
            $tax = angkadoang($_POST['tax']);
            $tanggal_jt = angkadoang($_POST['tanggal_jt']);
            $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
            $sisa = 0;
            $ppn_input = stringdoang($_POST['ppn_input']);
            $sisa_kredit = angkadoang($_POST['jumlah_kredit_baru']);
            $cara_bayar = stringdoang($_POST['cara_bayar']);
            $pembayaran = angkadoang($_POST['pembayaran']);
            $tanggal = stringdoang($_POST['tanggal']);
            $a = $total_1 - $potongan;
            $tax_persen = $tax * $a / 100;
            $t_total = $total_1 - $potongan;

            $user = $_SESSION['user_name'];

            $_SESSION['no_faktur']=$nomor_faktur;
            
            // jalankan query
            $stmt2->execute(); 



$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_pembelian WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

           $ppn_input = stringdoang($_POST['ppn_input']);


if ($ppn_input == "Non") {
echo $ppn_input;
    $persediaan = $total_1;
    $total_akhir = $total;

      //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");

    }

else if ($ppn_input == "Include") {
//ppn == Include
echo $ppn_input;
  $persediaan = $total_1 - $total_tax;
  $total_akhir = $total;
  $pajak = $total_tax;


//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
      }


}

else {
echo $ppn_input;
//ppn == Exclude
  $persediaan = $total_1;
  $total_akhir = $total;
  $pajak = $tax_persen;

//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
      }


}

//HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[hutang]', '0', '$sisa_kredit', 'Pembelian', '$nomor_faktur','1', '$user')");

     if ($pembayaran > 0 ) 
     
        {
//KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$cara_bayar', '0', '$pembayaran', 'Pembelian', '$nomor_faktur','1', '$user')");
        }


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$nomor_faktur','1', '$user')");
}



    }

            else
            {

            }
            
            
            
            
            $query12 = $db->query("SELECT * FROM tbs_pembelian WHERE no_faktur = '$nomor_faktur' ");
            while ($data = mysqli_fetch_array($query12))
            {

            $select_hpp_keluar = $db->query("SELECT jumlah_kuantitas FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$nomor_faktur' AND kode_barang = '$data[kode_barang]'");
            $data_hpp_keluar = mysqli_fetch_array($select_hpp_keluar);
            $jumlah_keluar = $data_hpp_keluar['jumlah_kuantitas'];
            
            $select_hpp_masuk = $db->query("SELECT * FROM hpp_masuk WHERE no_faktur = '$nomor_faktur' AND kode_barang = '$data[kode_barang]' AND sisa != jumlah_kuantitas ");
            $row_hpp_masuk = mysqli_num_rows($select_hpp_masuk);

            if ($row_hpp_masuk == 0) {


            $delete_detail_pembelian = $db->query("DELETE FROM detail_pembelian WHERE no_faktur = '$nomor_faktur' AND kode_barang = '$data[kode_barang]'");
            
            $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, sk.harga_pokok * $data[jumlah_barang] / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND kode_produk = '$data[kode_barang]'");
            $data_konversi = mysqli_fetch_array($pilih_konversi);
            
            if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
            $harga = $data_konversi['harga_konversi'];
            $jumlah_barang = $data_konversi['jumlah_konversi'];
            $satuan = $data_konversi['satuan'];
            $sisa_barang = $jumlah_barang - $jumlah_keluar;
            }
            else{
            $harga = $data['harga'];
            $jumlah_barang = $data['jumlah_barang'];
            $satuan = $data['satuan'];
            $sisa_barang = $jumlah_barang - $jumlah_keluar;
            }

            $query2 = "INSERT INTO detail_pembelian (no_faktur, tanggal, jam, waktu, kode_barang, nama_barang, jumlah_barang, asal_satuan, satuan, harga, subtotal, potongan, tax, sisa) 
            VALUES ('$nomor_faktur','$tanggal_sekarang','$jam_sekarang','$waktu','$data[kode_barang]','$data[nama_barang]','$jumlah_barang', '$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$sisa_barang')";


                       if ($db->query($query2) === TRUE) {
                       } 
                       
                       else {
                       echo "Error: " . $query2 . "<br>" . $db->error;
                       }
            
            }
 
        }
            
            $perintah2 = $db->query("DELETE FROM tbs_pembelian WHERE no_faktur = '$nomor_faktur'");

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