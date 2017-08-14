<?php session_start();


    include 'sanitasi.php';
    include 'db.php';

$session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:sa');


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

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM retur_penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur_retur FROM retur_penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur_retur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$no_faktur_retur = "1/RJ/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur_retur = $nomor."/RJ/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

    $no_faktur_piutang = $_POST['no_faktur_piutang'];
    $no_faktur_piutang_hidden = stringdoang($_POST['no_faktur_piutang_hidden']);
    $total = angkadoang($_POST['total']);   
    $potong_piutang = angkadoang($_POST['potong_piutang']);

    if ($no_faktur_piutang_hidden != "") {

      foreach ($no_faktur_piutang as $no_faktur_piutang) {
        $piutang = $db->query("SELECT kredit FROM penjualan WHERE no_faktur = '$no_faktur_piutang'");
        $data_piutang = mysqli_fetch_array($piutang);
      } // END foreach ($no_faktur_piutang as $no_faktur_piutang)
        
    }

    if ($potong_piutang >= $total) {
      $total_setelah_dipotong_piutang = 0;
    }
    else{
      $total_setelah_dipotong_piutang = $total - $potong_piutang;
    }

  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO retur_penjualan (no_faktur_retur, tanggal, jam, kode_pelanggan,
                total, potongan, tax, user_buat, cara_bayar, tunai, sisa, ppn, total_bayar, potongan_piutang)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssiiissiisii", 
        $no_faktur_retur, $tanggal_sekarang, $jam_sekarang, $kode_pelanggan , $total_setelah_dipotong_piutang, $potongan, $tax_jadi, $user_buat, $cara_bayar, $pembayaran, $sisa, $ppn_input, $total, $potong_piutang);        

  // siapkan "data" query
    $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
    $total = angkadoang($_POST['total']);
    $total1 = angkadoang($_POST['total1']);
    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $pembayaran = angkadoang($_POST['pembayaran']);
    $ppn_input = stringdoang($_POST['ppn_input']);
    $sisa = angkadoang($_POST['sisa']);
    $user_buat = $_SESSION['user_name'];

    $a = $total1 - $potongan;

    $tax_jadi = $tax * $a / 100;

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


    $query = $db->query("SELECT * FROM tbs_retur_penjualan WHERE session_id = '$session_id'");
    while ($data = mysqli_fetch_array($query))
    {


      $pilih_konversi = $db->query("SELECT COUNT(sk.konversi) AS jumlah_data,sk.konversi, b.satuan,sk.harga_jual_konversi FROM satuan_konversi sk INNER JOIN barang b ON sk.kode_produk = b.kode_barang AND sk.id_produk = b.id WHERE sk.kode_produk = '$data[kode_barang]' AND sk.id_satuan = '$data[satuan]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);

          if ($data_konversi['jumlah_data'] != 0) {
        $harga = $data_konversi['harga_jual_konversi'];
        $jumlah_barang = $data['jumlah_retur'] * $data_konversi['konversi'];
      }
      else{
        $harga = $data['harga'];
        $jumlah_barang = $data['jumlah_retur'];
      }


        $query2 = "INSERT INTO detail_retur_penjualan (no_faktur_retur, no_faktur_penjualan, tanggal, jam, nama_barang, kode_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax,asal_satuan,satuan) 
        VALUES ('$no_faktur_retur','$data[no_faktur_penjualan]','$tanggal_sekarang','$jam_sekarang','$data[nama_barang]','$data[kode_barang]','$data[jumlah_beli]','$jumlah_barang','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$data[satuan_jual]','$data[satuan]')";

            if ($db->query($query2) === TRUE) {
                
            } else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }

    }

  $potong_piutang = angkadoang($_POST['potong_piutang']);    

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

// UPDATE PENJUALAN PIUTANG RETUR <START>

if ($no_faktur_piutang_hidden != "") {

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

// UPDATE PENJUALAN PIUTANG RETUR </FINISH>

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
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");



//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '0', '$total_hpp', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");

if ($ppn_input == "Non") {  

 

  $total_penjualan = $total1;  



 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");

} 

else if ($ppn_input == "Include") {
//ppn == Include


  $total_penjualan = $total1 - $total_tax;
  $pajak = $total_tax;

if ($pajak != "" || $pajak != 0 ) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");
      }

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");



}

else {

//ppn == Exclude
  $total_penjualan = $total1;
  $pajak = $tax_jadi;
    
if ($pajak != "" || $pajak != 0 ) {

//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_retur_jual]', '$pajak', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");
      }
      

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '$total_penjualan', '0', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");


}




 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '0', '$total_akhir', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");


    //JIKA RETUR DENGAN POTONG PIUTANG
    if ($no_faktur_piutang_hidden != "") {


        if ($total >= $potong_piutang) {
           $retur_piutang = $potong_piutang;  
        }
        else{
           $retur_piutang = $total;
        }


      //PIUTANG DAGANG
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[kredit_retur_jual]', '0','$retur_piutang', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");
        /*
        Tidak dipakai karena, jika retur potong piutang.. Jurnal nya  -> piutang pada Persediaan (Pak Iwan)

         //RETUR piutang
                $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[bayar_piutang_retur]','0','$retur_piutang','Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
        */  

    }


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Penjualan - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_retur_jual]', '0', '$potongan', 'Retur Penjualan', '$no_faktur_retur','1', '$user_buat')");
}


    $query3 = $db->query("DELETE  FROM tbs_retur_penjualan WHERE session_id = '$session_id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>