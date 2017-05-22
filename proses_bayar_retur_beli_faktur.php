<?php session_start();


    include 'sanitasi.php';
    include 'db.php';

$session_id = session_id();

$perintah = $db->query("SELECT * FROM retur_pembelian");

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);


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

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM retur_pembelian ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur_retur FROM retur_pembelian ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur_retur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$no_faktur_retur= "1/RB/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur_retur = $nomor."/RB/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

    

    $no_faktur_hutang = $_POST['no_faktur_hutang'];
    $no_faktur_hutang_hidden = stringdoang($_POST['no_faktur_hutang_hidden']);

    if ($no_faktur_hutang_hidden != "") {

    foreach ($no_faktur_hutang as $no_faktur_hutang) {
      $hutang = $db->query("SELECT kredit FROM pembelian WHERE no_faktur = '$no_faktur_hutang'");
      $data_hutang = mysqli_fetch_array($hutang);
    } // END foreach ($no_faktur_hutang as $no_faktur_hutang)
      
    }




    $total = angkadoang($_POST['total']);
    $total1 = angkadoang($_POST['total1']);    
    $potong_hutang = angkadoang($_POST['potong_hutang']);
    $tax = angkadoang($_POST['tax']);
    $potongan = angkadoang($_POST['potongan']);
    $a = $total1 - $potongan;

    
    $tax_jadi = $tax * $a / 100;


if ($potong_hutang >= $total) {
  $total_setelah_dipotong_hutang = 0;
}
else{
  $total_setelah_dipotong_hutang = $total - $potong_hutang;
}

  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO retur_pembelian (no_faktur_retur, tanggal, jam, nama_suplier,
                total, potongan, tax, user_buat, cara_bayar, tunai, sisa, ppn, total_bayar, potongan_hutang, jenis_retur)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            
  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssiiissiisiii", 
        $no_faktur_retur, $tanggal_sekarang, $jam_sekarang, $nama_suplier , $total_setelah_dipotong_hutang, $potongan, $tax_jadi, $user_buat, $cara_bayar, $pembayaran, $sisa, $ppn_input, $total, $potong_hutang, $jenis_retur);        

  // siapkan "data" query
    $nama_suplier = stringdoang($_POST['nama_suplier']);
    $pembayaran = angkadoang($_POST['pembayaran']);
    $sisa = angkadoang($_POST['sisa']);
    $ppn_input = stringdoang($_POST['ppn_input']);
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $jenis_retur = "0";
    $user_buat = $_SESSION['user_name'];

    

    $_SESSION['no_faktur_retur'] = $no_faktur_retur;


  // jalankan query
        $stmt->execute();

    

    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);
    $satuan_dasar = stringdoang($_POST['satuan_dasar']);

    $query = $db->query("SELECT * FROM tbs_retur_pembelian WHERE session_id = '$session_id'");
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


        $query2 = "INSERT INTO detail_retur_pembelian (no_faktur_retur, no_faktur_pembelian, tanggal, jam, kode_barang, nama_barang, jumlah_beli, jumlah_retur, harga, subtotal, potongan, tax,satuan,asal_satuan) VALUES ('$no_faktur_retur','$data[no_faktur_pembelian]','$tanggal_sekarang', '$jam_sekarang','$data[kode_barang]','$data[nama_barang]','$data[jumlah_beli]','$jumlah_barang','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$data[satuan]','$data[satuan_beli]')";



        if ($db->query($query2) === TRUE) {

                
            } else {
            echo "Error: " . $query2 . "<br>" . $db->error;
            }


}



  $potong_hutang = angkadoang($_POST['potong_hutang']);    

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

if ($no_faktur_hutang_hidden != "") {

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


$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$nama_suplier'");
$ambil_suplier = mysqli_fetch_array($select_suplier);
    
$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_retur_pembelian WHERE session_id = '$session_id'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];


$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur_retur'");
$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
$total_hpp = $ambil_sum['total'];

$ppn_input = stringdoang($_POST['ppn_input']);

$tbs = $db->query("SELECT * FROM tbs_retur_pembelian 
  WHERE session_id = '$session_id'");
$data_tbs = mysqli_fetch_array($tbs);

$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur_retur'");
$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
$total_hpp = $ambil_sum['total'];


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

    $query3 = $db->query("DELETE  FROM tbs_retur_pembelian WHERE session_id = '$session_id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
?>