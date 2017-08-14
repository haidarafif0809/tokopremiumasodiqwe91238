<?php session_start();


    include 'sanitasi.php';
    include 'db.php';


    $cara_bayar = $_POST['cara_bayar'];
    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
    
    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:sa');
    $tahun_terakhir = substr($tahun_sekarang, 2);
    $user_edit = $_SESSION['user_name'];

    
    $potong_piutang = stringdoang($_POST['potong_piutang']);
    
    $row_piutang = $db->query("SELECT no_faktur_piutang FROM retur_pembayaran_piutang WHERE no_faktur_retur = '$no_faktur_retur'");
    $data_faktur_piutang_hidden = mysqli_num_rows($row_piutang);

    $total1 = angkadoang($_POST['total1']);
    $total = angkadoang($_POST['total']);
    
    $tax = angkadoang($_POST['tax']);
    $potongan = angkadoang($_POST['potongan']);
    $a = $total1 - $potongan;
    
    $tax_jadi = $tax * $a / 100;


    $perintah1 = $db->query("DELETE FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");

    $no_faktur_piutang = $_POST['no_faktur_piutang'];
    $no_faktur_piutang_hidden = stringdoang($_POST['no_faktur_piutang_hidden']);

    if ($data_faktur_piutang_hidden > 0 || $no_faktur_piutang == "") {
      foreach ($no_faktur_piutang as $no_faktur_piutangg) {
          $piutang = $db->query("SELECT kredit_penjualan_lama AS kredit FROM retur_pembayaran_piutang WHERE no_faktur_piutang = '$no_faktur_piutangg'");
          $data_piutang = mysqli_fetch_array($piutang);

      // UPDATE JUMLAH PIUTANG SEBELUM DIPOTONG
          $update_penjualan_kredit_awal = $db->query("UPDATE penjualan SET kredit = kredit + '$data_piutang[kredit]' WHERE no_faktur = '$no_faktur_piutangg'");
      }
    }



    if ($potong_piutang >= $total) {
        $total_setelah_dipotong_piutang = 0;
    }
    else{
        $total_setelah_dipotong_piutang = $total - $potong_piutang;
    }

  // buat prepared statements
        $stmt = $db->prepare("UPDATE retur_penjualan SET no_faktur_retur = ?, kode_pelanggan = ?, total = ?, potongan = ?, tax = ?, tanggal = ?, user_edit = ?, tanggal_edit = ?, jam = ?, cara_bayar = ?, tunai = ?, sisa = ?, ppn = ? WHERE no_faktur_retur = ?");
  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssiiisssssiiss", 
        $no_faktur_retur, $kode_pelanggan, $total_setelah_dipotong_piutang, $potongan, $tax_jadi, $tanggal, $user_edit, $tanggal_sekarang, $jam_sekarang, $cara_bayar, $pembayaran, $sisa, $ppn_input, $no_faktur_retur);        

  // siapkan "data" query
    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
    $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
    $total1 = angkadoang($_POST['total1']);
    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);
    $ppn_input = stringdoang($_POST['ppn_input']);
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $tanggal = stringdoang($_POST['tanggal']);
    $pembayaran = angkadoang($_POST['pembayaran']);
    $sisa = angkadoang($_POST['sisa']);
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



    $query = $db->query("SELECT * FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
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

        $query2 = "INSERT INTO detail_retur_penjualan (no_faktur_retur, no_faktur_penjualan, tanggal, nama_barang, kode_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax, asal_satuan, satuan,jam) VALUES ('$data[no_faktur_retur]','$data[no_faktur_penjualan]','$tanggal','$data[nama_barang]','$data[kode_barang]','$data[jumlah_beli]','$jumlah_barang','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$data[satuan_jual]','$data[satuan]','$jam_sekarang')";

        if ($db->query($query2) === TRUE) {
                
            } else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }

    }



  $potong_piutang = angkadoang($_POST['potong_piutang']);  
  $no_faktur_piutang = $_POST['no_faktur_piutang'];
  $no_faktur_retur = $_POST['no_faktur_retur'];  

  $sub_total = $db->query("SELECT SUM(subtotal) AS sub_total FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
  $data_sub = mysqli_fetch_array($sub_total);

  $diskon_pajak = $db->query("SELECT potongan, tax FROM retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
  $data_diskon_pajak = mysqli_fetch_array($diskon_pajak);
  $pajak = $data_diskon_pajak['tax'];
  $diskon = $data_diskon_pajak['potongan'];

  $subtotal_detail = ($data_sub['sub_total'] - $diskon) + $pajak;

  if ($total >= $potong_piutang) {
     $sub_akhir = $potong_piutang;
  }
  else{
     $sub_akhir = $subtotal_detail;
  }


// UPDATE penjualan PIUTANG RETUR <START>

if ($data_faktur_piutang_hidden > 0 || $no_faktur_piutang == "") {


  $query3 = $db->query("DELETE  FROM retur_pembayaran_piutang WHERE no_faktur_retur = '$no_faktur_retur'");

while ($sub_akhir > 0) {



$no_faktur_piutang = $_POST['no_faktur_piutang'];


foreach ($no_faktur_piutang as $no_faktur_piutang) {

  $piutang = $db->query("SELECT kredit FROM penjualan WHERE no_faktur = '$no_faktur_piutang'");
  $data_piutang_per_faktur = mysqli_fetch_array($piutang);



  if ($sub_akhir == $data_piutang_per_faktur['kredit']) {


    $update_penjualan_total = $db->query("UPDATE penjualan SET kredit = kredit - $sub_akhir WHERE no_faktur = '$no_faktur_piutang'");
    $update_penjualan_lunas = $db->query("UPDATE penjualan SET status = 'Lunas' WHERE kredit = 0 AND no_faktur = '$no_faktur_piutang'");

    $query2 = "INSERT INTO retur_pembayaran_piutang (no_faktur_retur, no_faktur_piutang, kredit_penjualan_lama) VALUES ('$no_faktur_retur','$no_faktur_piutang', '$sub_akhir')";     

        if ($db->query($query2) === TRUE) {
                
            } 
            else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }


    $sub_akhir = 0;
    
  }// END if ($sub_akhir == $potong_piutang)

  elseif ($sub_akhir > $data_piutang_per_faktur['kredit']) {

    $update_penjualan_total = $db->query("UPDATE penjualan SET kredit = '0' WHERE no_faktur = '$no_faktur_piutang'");
    $update_penjualan_lunas = $db->query("UPDATE penjualan SET status = 'Lunas' WHERE kredit = 0 AND no_faktur = '$no_faktur_piutang'");

    $query2 = "INSERT INTO retur_pembayaran_piutang (no_faktur_retur, no_faktur_piutang, kredit_penjualan_lama) VALUES ('$no_faktur_retur','$no_faktur_piutang', '$data_piutang_per_faktur[kredit]')";     

        if ($db->query($query2) === TRUE) {
                
            } 
            else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }


    $sub_akhir = $sub_akhir - $data_piutang_per_faktur['kredit'];

  }// END if ($sub_akhir > $potong_piutang)

  elseif ($sub_akhir < $data_piutang_per_faktur['kredit']) {

    $update_penjualan_total = $db->query("UPDATE penjualan SET kredit = kredit - $sub_akhir WHERE no_faktur = '$no_faktur_piutang'");
    $update_penjualan_lunas = $db->query("UPDATE penjualan SET status = 'Lunas' WHERE kredit = 0 AND no_faktur = '$no_faktur_piutang'");

    $query2 = "INSERT INTO retur_pembayaran_piutang (no_faktur_retur, no_faktur_piutang, kredit_penjualan_lama) VALUES ('$no_faktur_retur','$no_faktur_piutang', '$sub_akhir')";     

        if ($db->query($query2) === TRUE) {
                
            } 
            else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }

    $sub_akhir = 0;

  }// END if ($sub_akhir < $potong_piutang)


  

} // END foreach

}// END while ($sub_akhir > 0)

  } // END if ($no_faktur_piutang != "") 

// UPDATE penjualan PIUTANG RETUR </FINISH>

 // Jurnalnya dihapus disini, karena kalo ditrigger pembelian nya jadi gak update
    $delete = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur_retur' ");
 // Jurnalnya dihapus disini, karena kalo ditrigger pembelian nya jadi gak update

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_retur_penjualan WHERE session_id = '$session_id'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

$select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE id = '$kode_pelanggan'");
$ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE no_faktur = '$no_faktur_retur'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$ppn_input = stringdoang($_POST['ppn_input']);
   
$persediaan = $total_hpp;
$total_akhir = $total_setelah_dipotong_piutang;



//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");



//HPP    
      $insert_juranl1 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '0', '$persediaan', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");



if ($ppn_input == "Non") {  

 

  $total_penjualan = $total1;  


 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");

} 

else if ($ppn_input == "Include") {
//ppn == Include

  $total_penjualan = $total1 - $total_tax;
  $pajak = $total_tax;

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");
      }

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");



}

else {
//ppn == Exclude
  $total_penjualan = $total1;
  $pajak = $tax_jadi;
    
if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");
      }
      

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");


}


 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '0', '$total_akhir', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");

    //JIKA RETUR DENGAN POTONG PIUTANG
    if ($data_faktur_piutang_hidden > 0 ||$no_faktur_piutang != "") {


        if ($total >= $potong_piutang) {
           $retur_piutang = $potong_piutang;  
        }
        else{
           $retur_piutang = $total;
        }


      //PIUTANG DAGANG
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[kredit_retur_jual]', '0','$retur_piutang', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit')");
        /*
        Tidak dipakai karena, jika retur potong piutang.. Jurnal nya  -> piutang pada Persediaan (Pak Iwan)

         //RETUR piutang
                $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_edit,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[bayar_piutang_retur]','0','$retur_piutang','Retur Pembelian', '$no_faktur_retur','1', '$user_edit','')");
        */  

    }

if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_retur_jual]', '0', '$potongan', 'Retur Penjualan', '$no_faktur_retur','1', '$user_edit', '$user_edit')");
}



    $query3 = $db->query("DELETE  FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur'");
    echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);       
    ?>