<?php include 'session_login.php';
include 'sanitasi.php';
include 'db.php';


$session_id = session_id();

$pelanggan = angkadoang($_POST['pelanggan']);
$poin_pelangan = angkadoang($_POST['poin_pelangan']);
$total_poin = angkadoang($_POST['total_poin']);
$sisa_poin = angkadoang($_POST['sisa_poin']);
$tanggal_sekarang = stringdoang($_POST['tanggal']);
$keterangan = stringdoang($_POST['keterangan']);

$waktu = date('Y-m-d H:i:s');
$user = $_SESSION['nama'];

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
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
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM tukar_poin ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM tukar_poin ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_faktur = "1/TRP/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $no_faktur = $nomor."/TRP/".$data_bulan_terakhir."/".$tahun_terakhir;


 }



		$query22 = $db->query("SELECT * FROM tbs_tukar_poin WHERE session_id = '$session_id' AND no_faktur IS NULL ");
		while($data22 = mysqli_fetch_array($query22)) {

        // INSERT DETAIL TUKAR POIN
			$query2 = "INSERT INTO detail_tukar_poin(no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu) VALUES ('$no_faktur', '$data22[pelanggan]', '$data22[kode_barang]', '$data22[nama_barang]', '$data22[satuan]', '$data22[jumlah_barang]', '$data22[poin]','$data22[subtotal_poin]', '$data22[tanggal]', '$data22[jam]', '$data22[waktu]') ";

			       if ($db->query($query2) === TRUE) {

			       } 
			       else 
			       {
			       echo "Error: " . $query2 . "<br>" . $db->error;
			       }


        // INSERT DETAIL TUKAR POIN
      $query10 = "INSERT INTO poin_keluar(no_faktur, id_pelanggan, kode_barang, jumlah_barang, poin_produk_terakhir, subtotal_poin, tanggal, jam, waktu)

      VALUES ('$no_faktur', '$data22[pelanggan]', '$data22[kode_barang]', '$data22[jumlah_barang]', '$data22[poin]','$data22[subtotal_poin]', '$data22[tanggal]', '$data22[jam]', '$data22[waktu]') ";

             if ($db->query($query10) === TRUE) {

             } 
             else 
             {
             echo "Error: " . $query10 . "<br>" . $db->error;
             }



			
		}
            

                  $stmt = $db->prepare("INSERT INTO tukar_poin(no_faktur, pelanggan, poin_pelanggan_terakhir, total_poin, sisa_poin, user, tanggal, jam,keterangan)  VALUES (?,?,?,?,?,?,?,?,?)");
                  
                  // hubungkan "data" dengan prepared statements
                  $stmt->bind_param("siiiissss",
                  $no_faktur, $pelanggan, $poin_pelangan,$total_poin,$sisa_poin,$user,$tanggal_sekarang,$jam_sekarang,$keterangan);
                  
                  
                  // jalankan query
                  $stmt->execute();
              

                    // cek query
                    if (!$stmt) 
                    {
                    die('Query Error : '.$db->errno.
                    ' - '.$db->error);
                    }


        // setting akun
        $select_setting_akun = $db->query("SELECT persediaan , item_keluar FROM setting_akun");
        $ambil_setting = mysqli_fetch_array($select_setting_akun);

          
          // pencegah suapaya jurnal tidak doubel
          $delete_jurnal = $db->query("DELETE  FROM jurnal_trans WHERE no_faktur = '$no_faktur' AND jenis_transaksi = 'Penukaran Poin' ");


          // hpp  keluar
          $sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
          $ambil_sum_hpp_keluar = mysqli_fetch_array($sum_hpp_keluar);
          $total_hpp_keluar = $ambil_sum_hpp_keluar['total'];



         // jurnal keluar
         //PERSEDIAAN    
                $insert_jurnal_keluar1 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penukaran Poin', '$ambil_setting[persediaan]', '0', '$total_hpp_keluar', 'Penukaran Poin', '$no_faktur','1', '$user')");

       //ITEM KELUAR    
                $insert_jurnal_keluar2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penukaran Poin -', '$ambil_setting[item_keluar]', '$total_hpp_keluar', '0', 'Penukaran Poin', '$no_faktur','1', '$user')");
          



      $tbs_history_poin = $db->query("INSERT INTO history_tbs_tukar_poin(session_id, no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu)  SELECT session_id, no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu FROM tbs_tukar_poin WHERE session_id = '$session_id' AND no_faktur IS NULL ");
      
      
      $query3 = $db->query("DELETE  FROM tbs_tukar_poin WHERE session_id = '$session_id' AND no_faktur IS NULL ");


    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
    } catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
    }


   ?>

