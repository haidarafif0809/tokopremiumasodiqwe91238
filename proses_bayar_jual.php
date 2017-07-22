<?php session_start();
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST

$session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$waktu = date('Y-m-d H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$no_jurnal = no_jurnal();


try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown

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

 $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
  echo $no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

  echo $no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

//pengambilan data dari form 
              $biaya_adm = stringdoang($_POST['biaya_adm']);
              $biaya_adm = str_replace(',','.',$biaya_adm);
              if ($biaya_adm == '') {
                $biaya_adm = 0;
              }

              $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
              $keterangan = stringdoang($_POST['keterangan']);
              $kode_gudang = stringdoang($_POST['kode_gudang']);

              $total = stringdoang($_POST['total']);
              $total = str_replace(',','.',$total);
              if ($total == '') {
                $total = 0;
              }  

              $total2 = stringdoang($_POST['total2']);
              $total2 = str_replace(',','.',$total2);
              if ($total2 == '') {
                $total2 = 0;
              }  

              $potongan = stringdoang($_POST['potongan']);
              $potongan = str_replace(',','.',$potongan);
              if ($potongan == '') {
                $potongan = 0;
              }   

              $tax = stringdoang($_POST['tax']);
              $tax = str_replace(',','.',$tax);
              if ($tax == '') {
                $tax = 0;
              }

              $sisa_pembayaran = stringdoang($_POST['sisa_pembayaran']);
              $sisa_pembayaran = str_replace(',','.',$sisa_pembayaran);
              if ($sisa_pembayaran == '') {
                $sisa_pembayaran = 0;
              }


              $sisa = stringdoang($_POST['sisa']);
              $sisa = str_replace(',','.',$sisa);              
              if ($sisa == '') {
                $sisa = 0;
              }

              $sisa_kredit = stringdoang($_POST['kredit']);
              $sisa_kredit = str_replace(',','.',$sisa_kredit);              
              if ($sisa_kredit == '') {
                $sisa_kredit = 0;
              }

              $cara_bayar = stringdoang($_POST['cara_bayar']);

              $pembayaran = stringdoang($_POST['pembayaran']);
              $pembayaran = str_replace(',','.',$pembayaran);              
              if ($pembayaran == '') {
                $pembayaran = 0;
              }

              $sales = stringdoang($_POST['sales']);
              $ppn_input = stringdoang($_POST['ppn_input']);
              $user =  $_SESSION['user_name'];

              $tanggal_jt = stringdoang($_POST['tanggal_jt']);

              $pj_total = $total - ($potongan + $tax);
              $_SESSION['no_faktur']=$no_faktur;
//pengambilan data dari form 



    $no_jurnal = no_jurnal();
    
    $select_kode_pelanggan = $db->query("SELECT id,nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);
    $id_pelanggan = $ambil_kode_pelanggan['id'];
    
    
    // AMBIL  ATURAN POIN
    $ambil_poin = $db->query("SELECT poin_rp, nilai_poin FROM aturan_poin ");
    $data_poin = mysqli_fetch_array($ambil_poin);

    $nilai_poin = $data_poin['nilai_poin'];
    $poin_rp = $data_poin['poin_rp'];

  // total penjualan dibagi dengan ketentuan poin / aturan poin / nilai poin RP
    $hitung_poin = $total / $poin_rp;

    // poin yang didapat = membulatkan hasil hitungan poin(kebwah) * nilai poin yg ada di aturan poin.
    $poin_yg_didapat = floor($hitung_poin) * $nilai_poin;
    // hitung jumlah poin yang didapat
        
  
    // insert poin pelanggan
    $poin_masuk = $db->prepare("INSERT INTO poin_masuk(no_faktur_penjualan, id_pelanggan, total_penjualan, nilai_poin_akhir, poin_rp_akhir, poin,tanggal, jam, waktu) 
      VALUES (?,?,?,?,?,?,?,?,?)");
        

    // hubungkan "data" dengan prepared statements
    $poin_masuk->bind_param("siiiiisss",
    $no_faktur, $id_pelanggan,$total,$nilai_poin,$poin_rp, $poin_yg_didapat,$tanggal_sekarang,$jam_sekarang,$waktu);
              
    $poin_masuk->execute();

        // cek query
          if (!$poin_masuk) 
          {
          die('Query Error : '.$db->errno.
          ' - '.$db->error);
          }
          
          else 
          {
          
          }
    // end hitung poin pelanggan

    
    $perintah0 = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$sales'  ");
    $cek = mysqli_fetch_array($perintah0);
    $nominal = $cek['jumlah_uang'];
    $prosentase = $cek['jumlah_prosentase'];

    if ($nominal != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar) VALUES ('$cek[nama_petugas]', '$no_faktur', '$nominal', '$tanggal_sekarang', '$jam_sekarang', '')");

    }

    elseif ($prosentase != 0) {


     
      $fee_prosentase = $prosentase * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam) VALUES ('$cek[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang')");
      
    }



              
    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$sales' AND session_id = '$session_id' ");
   while  ($cek0 = mysqli_fetch_array($query0)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang')");


    }

    $query_delete_detail = $db->query("DELETE  FROM detail_penjualan WHERE no_faktur = '$no_faktur'");


    $query = $db->query("SELECT no_faktur_order,jumlah_barang ,subtotal,satuan,kode_barang,harga,nama_barang,potongan,tax,tanggal,jam FROM tbs_penjualan WHERE session_id = '$session_id' AND no_faktur IS NULL");
    while ($data = mysqli_fetch_array($query))
      {


      $pilih_konversi = $db->query("SELECT COUNT(sk.konversi) AS jumlah_data,sk.konversi, b.satuan,sk.harga_jual_konversi FROM satuan_konversi sk INNER JOIN barang b ON sk.kode_produk = b.kode_barang AND sk.id_produk = b.id WHERE sk.kode_produk = '$data[kode_barang]' AND sk.id_satuan = '$data[satuan]'");
      $data_konversi = mysqli_fetch_array($pilih_konversi);

          if ($data_konversi['jumlah_data'] != 0) {
                
                $harga_konversi = $data_konversi['harga_jual_konversi'];
                $jumlah_barang = $data['jumlah_barang'] * $data_konversi['konversi'];
                $satuan = $data['satuan'];

          }
          else{

                $harga_konversi = 0;
                $jumlah_barang = $data['jumlah_barang'];
                $satuan = $data['satuan'];
          }


    
        $query2 = "INSERT INTO detail_penjualan (no_faktur, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa,harga_konversi)
         VALUES ('$no_faktur', '$data[tanggal]', '$data[jam]', '$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$satuan','$data[satuan]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]', '$jumlah_barang','$harga_konversi')";

        if ($db->query($query2) === TRUE) {
        } 

        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }


        $update_order = "UPDATE penjualan_order SET status_order = 'Selesai Order' WHERE no_faktur_order = '$data[no_faktur_order]'";

        if ($db->query($update_order) === TRUE) {
        } 

        else {
        echo "Error: " . $update_order . "<br>" . $db->error;
        }
        
      }





// insert data penjualan lunas        
  if ($sisa_kredit == 0 ) 
            {
              $ket_jurnal = "Penjualan "." Lunas ".$ambil_kode_pelanggan['nama_pelanggan']." ";


              $stmt = "INSERT INTO penjualan (no_faktur, kode_gudang, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, tax, sisa, cara_bayar, 
                    tunai, status_jual_awal, keterangan, ppn, biaya_admin,no_faktur_jurnal,keterangan_jurnal)
               VALUES ('$no_faktur','$kode_gudang','$id_pelanggan','$total','$tanggal_sekarang','$jam_sekarang','$user','$sales','Lunas','$potongan','$tax','$sisa','$cara_bayar',
                '$pembayaran','Tunai','$keterangan','$ppn_input','$biaya_adm','$no_jurnal','$ket_jurnal')";

                if ($db->query($stmt) === TRUE) {
                } 

                else {
                echo "Error: " . $stmt . "<br>" . $db->error;
                }

                                          
 }
// insert data penjualan lunas        
    

//insert data penjualan piutang
  else if ($sisa_kredit != 0)
            {
              
             $ket_jurnal = "Penjualan "." Piutang ".$ambil_kode_pelanggan['nama_pelanggan']." ";

              $stmt = "INSERT INTO penjualan (no_faktur, kode_gudang, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, sales, status, potongan, tax, kredit, nilai_kredit, cara_bayar, tunai, status_jual_awal, keterangan, ppn, biaya_admin, no_faktur_jurnal,keterangan_jurnal) 
               VALUES ('$no_faktur', '$kode_gudang', '$id_pelanggan', '$total', '$tanggal_sekarang', '$tanggal_jt', '$jam_sekarang', '$user', '$sales','Piutang','$potongan', '$tax', '$sisa_kredit', '$sisa_kredit', '$cara_bayar',
              '$pembayaran', 'Kredit','$keterangan', '$ppn_input','$biaya_adm','$no_jurnal','$ket_jurnal')";

                if ($db->query($stmt) === TRUE) {
                } 

                else {
                echo "Error: " . $stmt . "<br>" . $db->error;
                }              
            
   
}
//insert data penjualan piutang




//awal nya bonus
$query_tbs_bonus_penjualan = $db->query("SELECT tp.kode_produk,tp.nama_produk,tp.qty_bonus,tp.keterangan,tp.tanggal,tp.jam,b.id as baranga,tp.harga_disc FROM tbs_bonus_penjualan tp LEFT JOIN barang b ON tp.kode_produk = b.kode_barang WHERE tp.session_id = '$session_id'");
    while($datatb = mysqli_fetch_array($query_tbs_bonus_penjualan)){

//LOGIKA KETIKA ADA PRODUK PARCEL YANG AKAN DIJUAL, KARENA PARCEL TIDAK MASUK KE DALAM PRODUK BONUS
        $query_cek_produk = $db->query("SELECT COUNT(kode_barang) FROM barang WHERE kode_barang = '$datatb[kode_produk]'");
        $jumlah_cek_produk = mysqli_num_rows($query_cek_produk);
          
          if ($jumlah_cek_produk > 0 ) {

              $subtotal_bonusnya = $datatb['qty_bonus'] * $datatb['harga_disc'];

              $querybonus = "INSERT INTO bonus_penjualan (no_faktur_penjualan, kode_pelanggan, tanggal, jam, kode_produk, nama_produk, qty_bonus,keterangan,harga_disc,subtotal,satuan) VALUES ('$no_faktur', '$id_pelanggan', '$datatb[tanggal]', '$datatb[jam]', '$datatb[kode_produk]', '$datatb[nama_produk]', '$datatb[qty_bonus]', '$datatb[keterangan]', '$datatb[harga_disc]' ,'$subtotal_bonusnya','$datatb[satuan]' )";

                if ($db->query($querybonus) === TRUE) {
                } 

                else {
                echo "Error: " . $querybonus . "<br>" . $db->error;
                }



                // MENGAUPDATE KETERANGAN_PROMO_DISC DI TABLE PENJAUALAN 
                $update_jual = "UPDATE penjualan SET keterangan_promo_disc = '$datatb[keterangan]' WHERE no_faktur = '$no_faktur'";
                    if ($db->query($update_jual) === TRUE) {
                    } 

                    else {
                    echo "Error: " . $update_jual . "<br>" . $db->error;
                    }

          }
          else{

          }

      }
//end nya bonus


        // coding untuk memasukan history_tbs dan menghapus tbs
    $tbs_penjualan_masuk = "INSERT INTO history_tbs_penjualan (no_faktur,no_faktur_order,session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tanggal,jam, tipe_barang,harga_konversi) 
    SELECT '$no_faktur',no_faktur_order,session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tanggal,jam, tipe_barang,harga_konversi FROM tbs_penjualan WHERE session_id = '$session_id' AND no_faktur IS NULL ";
        if ($db->query($tbs_penjualan_masuk) === TRUE) {
              
        }
        else{
            echo "Error: " . $tbs_penjualan_masuk . "<br>" . $db->error;
        }


    $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE session_id = '$session_id'");
    $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE session_id = '$session_id'");
    $query321 = $db->query("DELETE  FROM tbs_bonus_penjualan WHERE session_id = '$session_id'");



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
