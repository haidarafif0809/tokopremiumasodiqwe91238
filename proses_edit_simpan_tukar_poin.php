<?php include 'session_login.php';
include 'sanitasi.php';
include 'db.php';


$session_id = session_id();

echo$no_faktur = stringdoang($_POST['no_faktur']);
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


      $delete_detail = $db->query("DELETE  FROM detail_tukar_poin WHERE no_faktur = '$no_faktur' ");


        // INSERT DETAIL TUKAR POIN
    $history_a = "INSERT INTO detail_tukar_poin(no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu)  
    SELECT no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu FROM tbs_tukar_poin
     WHERE no_faktur = '$no_faktur'  AND session_id IS NULL ";


        if ($db->query($history_a) === TRUE) {
        } 

        else {
        echo "Error: " . $history_a . "<br>" . $db->error;
        }


      $delete_poin = $db->query("DELETE FROM poin_keluar WHERE no_faktur = '$no_faktur' ");

      // INSERT POIN KELUAR
    $history_b = "INSERT INTO poin_keluar(no_faktur, id_pelanggan, kode_barang, jumlah_barang, poin_produk_terakhir, subtotal_poin, tanggal, jam, waktu) 
    SELECT no_faktur, pelanggan, kode_barang,  jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu FROM tbs_tukar_poin
     WHERE no_faktur = '$no_faktur'  AND session_id IS NULL ";


        if ($db->query($history_b) === TRUE) {
        } 

        else {
        echo "Error: " . $history_b . "<br>" . $db->error;
        }

            
        // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
        $stmt = $db->prepare("UPDATE tukar_poin SET poin_pelanggan_terakhir = ?, total_poin = ?, sisa_poin = ?,  keterangan = ?, user_edit = ? , 
          waktu_edit = ? WHERE no_faktur = ?");
        
        $stmt->bind_param("iiissss",
        $poin_pelangan, $total_poin, $sisa_poin, $keterangan, $user, $waktu, $no_faktur);
        
        
        $stmt->execute();
        
        if (!$stmt) 
        {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }


      $tbs_history_poin = $db->query("INSERT INTO history_edit_tbs_tukar_poin(no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu)  
          SELECT  no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu FROM tbs_tukar_poin 
          WHERE no_faktur = '$no_faktur' AND session_id IS NULL ");
      
      
      $query3 = $db->query("DELETE  FROM tbs_tukar_poin WHERE no_faktur = '$no_faktur' AND session_id IS NULL ");


    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
    } catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
    }


   ?>

