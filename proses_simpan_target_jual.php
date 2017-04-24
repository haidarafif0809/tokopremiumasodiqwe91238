<?php include 'session_login.php';
include 'sanitasi.php';
include 'db.php';


$session_id = session_id();
$keterangan = stringdoang($_POST['keterangan']);
$order = angkadoang($_POST['order']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$waktu = date('Y-m-d H:i:s');
$user = $_SESSION['nama'];

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
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

 $bulan_terakhir = $db->query("SELECT MONTH(waktu) as bulan FROM target_penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_trx FROM target_penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_trx'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_trx = "1/TP/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $no_trx = $nomor."/TP/".$data_bulan_terakhir."/".$tahun_terakhir;


 }



		$query22 = $db->query("SELECT * FROM tbs_target_penjualan WHERE session_id = '$session_id' GROUP BY kode_barang ");
		while($data22 = mysqli_fetch_array($query22)) {

			$query2 = "INSERT INTO  detail_target_penjualan(no_trx, kode_barang, nama_barang, satuan, jumlah_periode, jual_perhari, target_perhari, proyeksi, stok_terakhir, kebutuhan, dari_tgl, sampai_tgl, order_hari) 
			VALUES ('$no_trx', '$data22[kode_barang]', '$data22[nama_barang]', '$data22[satuan]', '$data22[jumlah_periode]', '$data22[jual_perhari]', '$data22[target_perhari]','$data22[proyeksi]', '$data22[stok_terakhir]', 
				'$data22[kebutuhan]', '$data22[dari_tgl]', '$data22[sampai_tgl]', '$data22[order_hari]') ";

			       if ($db->query($query2) === TRUE) {

			       } 
			       else 
			       {
			       echo "Error: " . $query2 . "<br>" . $db->error;
			       }

			
		}

              $stmt = $db->prepare("INSERT INTO target_penjualan(no_trx, keterangan, order_hari,dari_tgl, sampai_tgl,user)  VALUES (?,?,?,?,?,?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("ssisss",
              $no_trx, $keterangan, $order,$dari_tanggal,$sampai_tanggal,$user);

              
    // jalankan query
              $stmt->execute();
              

    // cek query
if (!$stmt) 
      {
        die('Query Error : '.$db->errno.
          ' - '.$db->error);
      }




    $query3 = $db->query("DELETE  FROM tbs_target_penjualan WHERE session_id = '$session_id'");


    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}


   ?>