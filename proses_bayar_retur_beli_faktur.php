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


    $total1 = angkadoang($_POST['total1']);
    
    $tax = angkadoang($_POST['tax']);
    $potongan = angkadoang($_POST['potongan']);
    $a = $total1 - $potongan;
    
    $tax_jadi = $tax * $a / 100;


  // buat prepared statements
        $stmt = $db->prepare("INSERT INTO retur_pembelian (no_faktur_retur, tanggal, jam, nama_suplier,
                total, potongan, tax, user_buat, cara_bayar, tunai, sisa, ppn)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
            
  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssiiissiis", 
        $no_faktur_retur, $tanggal_sekarang, $jam_sekarang, $nama_suplier , $total, $potongan, $tax_jadi, $user_buat, $cara_bayar, $pembayaran, $sisa, $ppn_input);        

  // siapkan "data" query
    $nama_suplier = stringdoang($_POST['nama_suplier']);
    $total = angkadoang($_POST['total']);
    $pembayaran = angkadoang($_POST['pembayaran']);
    $sisa = angkadoang($_POST['sisa']);
    $ppn_input = stringdoang($_POST['ppn_input']);
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $user_buat = $_SESSION['user_name'];

    

    $_SESSION['no_faktur_retur'] = $no_faktur_retur;


  // jalankan query
        $stmt->execute();

    

    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);
    $satuan_dasar = stringdoang($_POST['satuan_dasar']);

    $query = $db->query("SELECT * FROM tbs_retur_pembelian 
	WHERE session_id = '$session_id'");
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

        if ($ppn_input == "Non") {  
                    
                    $persediaan = $total_hpp ;
                    $total_akhir = $total;
                    
                    
                    //PERSEDIAAN    
                    $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '0', '$persediaan', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");




                    } 
                    
                    else if ($ppn_input == "Include") {
                    //ppn == Include
                    
                    $pajak = $total_tax;
                    $persediaan = $total_hpp;
                    $total_akhir = $total;
                    
                    
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
                    $total_akhir = $total;
                    
                    
                    //PERSEDIAAN    
                    $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '0', '$persediaan', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
                    
                    if ($pajak != "" || $pajak != 0 ) {
                    //PAJAK
                    $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[pajak_retur_beli]', '0', '$pajak', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
                    }
                    
                    }





 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$cara_bayar', '$total_akhir', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");

 
if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[potongan_retur_beli]', '$potongan', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
}

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

    $query3 = $db->query("DELETE  FROM tbs_retur_pembelian WHERE session_id = '$session_id'");
    echo "Success";


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
?>