<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';


$pilih = $db->query("SELECT * FROM status_print WHERE status_print IS NULL ORDER BY id ASC Limit 1");
$ambil_baris = mysqli_num_rows($pilih);
$ambil_data = mysqli_fetch_array($pilih);


if ($ambil_baris == 1) {
  $query0 = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$ambil_data[no_faktur]' ");
  $data0 = mysqli_fetch_array($query0);

  $query1 = $db->query("SELECT * FROM perusahaan ");
  $data1 = mysqli_fetch_array($query1);

  $query2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$ambil_data[no_faktur]' ");

  $query3 = $db->query("SELECT b.kategori, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.komentar FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$ambil_data[no_faktur]' AND dp.no_pesanan = '$ambil_data[no_pesanan]'");

  $update_status_print = $db->query("UPDATE status_print SET status_print = 'Sudah' WHERE no_faktur = '$ambil_data[no_faktur]' ");

      $query30 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$ambil_data[no_faktur]'");
    $data30 = mysqli_fetch_array($query30);
    $total_item = $data30['total_item'];
 ?>


  <?php echo $data1['nama_perusahaan']; ?><br>
  <?php echo $data1['alamat_perusahaan']; ?><br><br>
  ===================<br>
  No Faktur : <?php echo $data0['no_faktur']; ?> || Kasir : <?php echo $_SESSION['nama']; ?><br>
  ===================<br>



 <table>

  <tbody>
           <?php 
           while ($data2 = mysqli_fetch_array($query2)){
           
           echo '<tr><td width:"50%"> '. $data2['nama_barang'] .' </td> <td style="padding:3px"> '. $data2['jumlah_barang'] .'</td>  <td style="padding:3px"> '. rp($data2['harga']) .'</td>  <td style="padding:3px"> '. rp($data2['subtotal']) . ' </td></tr>';
           
           }
           
                   //Untuk Memutuskan Koneksi Ke Database
                   
                   mysqli_close($db); 
        
           
           ?> 
 </tbody>
</table>
    ===================<br>
 <table>
  <tbody>
      <tr><td width="50%">Diskon</td> <td> :</td> <td><?php echo rp($data0['potongan']);?> </tr>
      <tr><td  width="50%">Pajak</td> <td> :</td> <td> <?php echo persen($data0['tax']);?> </td></tr>
      <tr><td  width="50%">Total Item</td> <td> :</td> <td> <?php echo $total_item; ?> </td></tr>
      <tr><td width="50%">Total Penjualan</td> <td> :</td> <td><?php echo rp($data0['total']); ?> </tr>
      <tr><td  width="50%">Tunai</td> <td> :</td> <td> <?php echo rp($data0['tunai']); ?> </td></tr>
      <tr><td  width="50%">Kembalian</td> <td> :</td> <td> <?php echo rp($data0['sisa']); ?>  </td></tr>
            

  </tbody>
</table>

    ===================<br>
    ===================<br>
    Tanggal : <?php echo tanggal($data0['tanggal']);?><br>
    ===================<br><br>
    Terima Kasih<br>
    Selamat Datang Kembali<br>
    Telp. <?php echo $data1['no_telp']; ?><br>

    

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php 

} 

?>

