<?php session_start();


    include 'sanitasi.php';
    include 'db.php';


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);

    $total = angkadoang($_POST['total']);
    $potong_hutang = angkadoang($_POST['potong_hutang']);



    $tanggal = stringdoang($_POST['tanggal']);

    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);

    $row_hutang = $db->query("SELECT no_faktur_hutang FROM retur_pembayaran_hutang WHERE no_faktur_retur = '$no_faktur_retur'");
    $no_faktur_hutang_hidden = mysqli_num_rows($row_hutang);

    $total1 = angkadoang($_POST['total1']);
    
    $tax = angkadoang($_POST['tax']);
    $potongan = angkadoang($_POST['potongan']);
    $a = $total1 - $potongan;
    
    $tax_jadi = $tax * $a / 100;

    $query_user = $db->query("SELECT user_buat FROM jurnal_trans WHERE no_faktur = '$no_faktur_retur' ");
    $datauser = mysqli_fetch_array($query_user);
    $user_buat = $datauser['user_buat'];


    $perintah1 = $db->query("DELETE FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");


    $no_faktur_hutang = $_POST['no_faktur_hutang'];

if ($no_faktur_hutang_hidden > 0) {
    foreach ($no_faktur_hutang as $no_faktur_hutang) {
    $hutang = $db->query("SELECT kredit_pembelian_lama AS kredit FROM retur_pembayaran_hutang WHERE no_faktur_hutang = '$no_faktur_hutang'");
    $data_hutang = mysqli_fetch_array($hutang);

// UPDATE JUMLAH HUTANG SEBELUM DIPOTONG
    $update_pembelian_kredit_awal = $db->query("UPDATE pembelian SET kredit = kredit + '$data_hutang[kredit]' WHERE no_faktur = '$no_faktur_hutang'");
}
}


    if ($potong_hutang >= $total) {
    $total_setelah_dipotong_hutang = 0;
    }
    else{
    $total_setelah_dipotong_hutang = $total - $potong_hutang;
    }


  // buat prepared statements
        $stmt = $db->prepare("UPDATE retur_pembelian SET no_faktur_retur = ?, tanggal = ?, jam = ?, tanggal_edit = ?, nama_suplier = ?, total = ?, potongan = ?, tax = ?, user_edit = ?, cara_bayar = ?, tunai = ?, sisa = ?, ppn = ?, total_bayar = ?, potongan_hutang = ? WHERE no_faktur_retur = ?");
            
  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("sssssiiissiisiis", 
        $no_faktur_retur, $tanggal, $jam_sekarang, $tanggal_sekarang, $nama_suplier , $total_setelah_dipotong_hutang, $potongan, $tax_jadi, $user_edit, $cara_bayar, $pembayaran, $sisa, $ppn_input, $total, $potong_hutang, $no_faktur_retur);        

  // siapkan "data" query
    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
    $nama_suplier = stringdoang($_POST['nama_suplier']);
    $total1 = angkadoang($_POST['total1']);
    $total = angkadoang($_POST['total']);
    $potong_hutang = angkadoang($_POST['potong_hutang']);
    $pembayaran = angkadoang($_POST['pembayaran']);
    $sisa = angkadoang($_POST['sisa']);
    $ppn_input = stringdoang($_POST['ppn_input']);
    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $tanggal = stringdoang($_POST['tanggal']);
    $user_edit = $_SESSION['user_name'];

    $_SESSION['no_faktur_retur'] = $no_faktur_retur;


  // jalankan query
        $stmt->execute();
	
    

    if (!$stmt) {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else {
    
    }

    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);

    $query = $db->query("SELECT * FROM tbs_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");
    while ($data = mysqli_fetch_array($query))
    {

     $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_retur] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_retur] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);

      if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
        $harga = $data_konversi['harga_konversi'];
        $jumlah_barang = $data_konversi['jumlah_konversi'];
        

      }
      else{
        $harga = $data['harga'];
        $jumlah_barang = $data['jumlah_retur'];
      }

        $query2 = "INSERT INTO detail_retur_pembelian (no_faktur_retur, no_faktur_pembelian, tanggal, kode_barang, nama_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax, satuan, asal_satuan) 
		VALUES ('$data[no_faktur_retur]','$data[no_faktur_pembelian]','$tanggal','$data[kode_barang]','$data[nama_barang]','$data[jumlah_beli]','$jumlah_barang','$harga','$data[subtotal]','$data[potongan]','$data[tax]', '$data[satuan]', '$data[satuan_beli]')";

        if ($db->query($query2) === TRUE) {

                
            } else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }
    }



  $potong_hutang = angkadoang($_POST['potong_hutang']);  
  $no_faktur_hutang = $_POST['no_faktur_hutang'];
  $no_faktur_retur = $_POST['no_faktur_retur'];  

  $sub_total = $db->query("SELECT SUM(subtotal) AS sub_total FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");
  $data_sub = mysqli_fetch_array($sub_total);

  $diskon_pajak = $db->query("SELECT potongan, tax FROM retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");
  $data_diskon_pajak = mysqli_fetch_array($diskon_pajak);
  $pajak = $data_diskon_pajak['tax'];
  $diskon = $data_diskon_pajak['potongan'];

  $subtotal_detail = ($data_sub['sub_total'] - $diskon) + $pajak;

  if ($total >= $potong_hutang) {
     $sub_akhir = $potong_hutang;
  }
  else{
     $sub_akhir = $subtotal_detail;
  }


// UPDATE PEMBELIAN HUTANG RETUR <START>

if ($no_faktur_hutang_hidden > 0) {


  $query3 = $db->query("DELETE  FROM retur_pembayaran_hutang WHERE no_faktur_retur = '$no_faktur_retur'");

while ($sub_akhir > 0) {



$no_faktur_hutang = $_POST['no_faktur_hutang'];


foreach ($no_faktur_hutang as $no_faktur_hutang) {

  $hutang = $db->query("SELECT kredit FROM pembelian WHERE no_faktur = '$no_faktur_hutang'");
  $data_hutang_per_faktur = mysqli_fetch_array($hutang);



  if ($sub_akhir == $data_hutang_per_faktur['kredit']) {


    $update_pembelian_total = $db->query("UPDATE pembelian SET kredit = kredit - $sub_akhir WHERE no_faktur = '$no_faktur_hutang'");
    $update_pembelian_lunas = $db->query("UPDATE pembelian SET status = 'Lunas' WHERE kredit = 0 AND no_faktur = '$no_faktur_hutang'");

    $query2 = "INSERT INTO retur_pembayaran_hutang (no_faktur_retur, no_faktur_hutang, kredit_pembelian_lama) VALUES ('$no_faktur_retur','$no_faktur_hutang', '$sub_akhir')";     

        if ($db->query($query2) === TRUE) {
                
            } 
            else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }


    $sub_akhir = 0;
    
  }// END if ($sub_akhir == $potong_hutang)

  elseif ($sub_akhir > $data_hutang_per_faktur['kredit']) {




    $update_pembelian_total = $db->query("UPDATE pembelian SET kredit = '0' WHERE no_faktur = '$no_faktur_hutang'");
    $update_pembelian_lunas = $db->query("UPDATE pembelian SET status = 'Lunas' WHERE kredit = 0 AND no_faktur = '$no_faktur_hutang'");

    $query2 = "INSERT INTO retur_pembayaran_hutang (no_faktur_retur, no_faktur_hutang, kredit_pembelian_lama) VALUES ('$no_faktur_retur','$no_faktur_hutang', '$data_hutang_per_faktur[kredit]')";     

        if ($db->query($query2) === TRUE) {
                
            } 
            else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }


    $sub_akhir = $sub_akhir - $data_hutang_per_faktur['kredit'];

  }// END if ($sub_akhir > $potong_hutang)

  elseif ($sub_akhir < $data_hutang_per_faktur['kredit']) {

    $update_pembelian_total = $db->query("UPDATE pembelian SET kredit = kredit - $sub_akhir WHERE no_faktur = '$no_faktur_hutang'");
    $update_pembelian_lunas = $db->query("UPDATE pembelian SET status = 'Lunas' WHERE kredit = 0 AND no_faktur = '$no_faktur_hutang'");

    $query2 = "INSERT INTO retur_pembayaran_hutang (no_faktur_retur, no_faktur_hutang, kredit_pembelian_lama) VALUES ('$no_faktur_retur','$no_faktur_hutang', '$sub_akhir')";     

        if ($db->query($query2) === TRUE) {
                
            } 
            else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }

    $sub_akhir = 0;

  }// END if ($sub_akhir < $potong_hutang)


  

} // END foreach

}// END while ($sub_akhir > 0)

  } // END if ($no_faktur_hutang != "") 

// UPDATE PEMBELIAN HUTANG RETUR </FINISH>


 // Jurnalnya dihapus disini, karena kalo ditrigger pembelian nya jadi gak update
    $delete = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur_retur' ");
 // Jurnalnya dihapus disini, karena kalo ditrigger pembelian nya jadi gak update

$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$nama_suplier'");
$ambil_suplier = mysqli_fetch_array($select_suplier);
    
$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];


$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur_retur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$ppn_input = stringdoang($_POST['ppn_input']);


$tbs = $db->query("SELECT * FROM tbs_retur_pembelian 
  WHERE no_faktur_retur = '$no_faktur_retur'");
$data_tbs = mysqli_fetch_array($tbs);


$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur_retur'");
$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
$total_hpp = $ambil_sum['total'];

//
$select_pot_pemb = $db->query("SELECT potongan,subtotal,tax FROM detail_pembelian WHERE no_faktur = '$data_tbs[no_faktur_pembelian]' AND kode_barang = '$data_tbs[kode_barang]'");
$ambil_tbs = mysqli_fetch_array($select_pot_pemb);

      $total_akhir = $total_setelah_dipotong_hutang;  

    //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$cara_bayar', '$total_akhir', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");

    //JIKA RETUR DENGAN POTONG HUTANG
    if ($no_faktur_hutang_hidden != "") {


        if ($total >= $potong_hutang) {
           $retur_hutang = $potong_hutang;  
        }
        else{
           $retur_hutang = $total;
        }


      //HUTANG DAGANG
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[hutang]', '$retur_hutang', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat')");

        /*
        Tidak dipakai karena, jika retur potong hutang.. Jurnal nya  -> Hutang pada Persediaan (Pak Iwan)

         //RETUR HUTANG
                $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[bayar_hutang_retur]','0','$retur_hutang','Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
        */  

    }

  //Akun Potongan di retur Pembelian -> diganti AKun Laba / rugi penghapus hutang (Karena Diskon dalam retur pembelian dianggap sbg kerugian)
    if ($potongan != "" || $potongan != 0 ) {
        //POTONGAN
          $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '701-004', '$potongan', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
    }


    if ($ppn_input == "Non") {
                    
      $persediaan = $total_hpp ;
      $total_akhir = $total_setelah_dipotong_hutang;    
    
        //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '0', '$persediaan', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");

    } 
    
    else if ($ppn_input == "Include") {
      //ppn == Include      
      $pajak = $total_tax;
      $persediaan = $total_hpp;
      $total_akhir = $total_setelah_dipotong_hutang;
      
    
        //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '0', '$persediaan', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
        
        if ($pajak != "" || $pajak != 0 ) {
        //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[pajak_retur_beli]', '0', '$pajak', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
        }
    
    
    }
    
    else {
    
      //ppn == Exclude
      $pajak = $tax_jadi;
      $persediaan = $total_hpp;                
      $total_akhir = $total_setelah_dipotong_hutang;
    
    
      //PERSEDIAAN    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '0', '$persediaan', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
      
        if ($pajak != "" || $pajak != 0 ) {
        //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[pajak_retur_beli]', '0', '$pajak', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
        }
    
    }

/*
//DIGUNAKAN JIKA TERJADI TIDAK BALANCE ANTARA DEBIT & KREDIT
        $sum_debit_kredit = $db->query("SELECT SUM(debit) AS jumlah_debit, SUM(kredit) AS jumlah_kredit FROM jurnal_trans WHERE no_faktur = '$no_faktur_retur'");
        $data_debit_kredit = mysqli_fetch_array($sum_debit_kredit);
        $jumlah_debit = $data_debit_kredit['jumlah_debit'];
        $jumlah_kredit = $data_debit_kredit['jumlah_kredit'];

        if ($jumlah_kredit > $jumlah_debit) {
            $labarugi = $jumlah_kredit - $jumlah_debit;

             $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '701-004', '$labarugi', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
        }

        elseif ($jumlah_debit > $jumlah_kredit) {
            $labarugi = $jumlah_debit - $jumlah_kredit;

             $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '701-004', '0', '$labarugi', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
            
        }
        else{

        }

 */
    
    $query3 = $db->query("DELETE  FROM tbs_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");

    echo '<script>window.location.href="retur_pembelian_faktur.php";</script>';



    //Untuk Memutuskan Koneksi Ke Database
    mysqli_close($db);

    ?>