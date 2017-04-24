<?php 

include 'sanitasi.php';
include 'db.php';

session_start();

$tipe = 'Semua';


$pilih = $db->query("SELECT * FROM status_print WHERE tipe_produk = '$tipe' AND status_print IS NULL  ORDER BY id ASC Limit 1");
$ambil_baris = mysqli_num_rows($pilih);
$ambil_data = mysqli_fetch_array($pilih);


if ($ambil_baris == 1) {
  $query0 = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$ambil_data[no_faktur]' ");
  $data0 = mysqli_fetch_array($query0);


  $query2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$ambil_data[no_faktur]' ");

  $query3 = $db->query("SELECT b.kategori, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.komentar FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$ambil_data[no_faktur]' AND dp.no_pesanan = '$ambil_data[no_pesanan]' ");

  $update_status_print = $db->query("UPDATE status_print SET status_print = 'Sudah' WHERE tipe_produk = '$tipe' AND no_faktur = '$ambil_data[no_faktur]' AND no_pesanan =  '$ambil_data[no_pesanan]' ");



    $query30 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$ambil_data[no_faktur]'");
    $data30 = mysqli_fetch_array($query30);
    $total_item = $data30['total_item'];

    $query33 = $db->query("SELECT SUM(subtotal) as total FROM detail_penjualan WHERE no_faktur = '$ambil_data[no_faktur]'");
    $data33 = mysqli_fetch_array($query33);
    $total = $data33['total'];

        $total_akhir = $total - $data0['potongan'] + $data0['tax'];

 ?>



  No Meja : <?php echo $data0['kode_meja']; ?> || No Faktur : <?php echo $data0['no_faktur']; ?> || Kasir : <?php echo $_SESSION['nama']; ?><br>
  ===================<br>

</font>
 
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
    <tr><td  width="50%">Total Item</td> <td> : </td> <td> <?php echo $total_item; ?>  </td></tr>
      <tr><td  width="50%">Subtotal</td> <td> : &nbsp;Rp.&nbsp;</td> <td> <?php echo rp($total); ?> </td></tr>
      <tr><td width="50%">Diskon </td> <td> : &nbsp;Rp.&nbsp;</td> <td><?php echo rp($data0['potongan']); ?> </tr>
      <tr><td width="50%">Pajak </td> <td> : &nbsp;Rp.&nbsp;</td> <td><?php echo rp($data0['tax']); ?> </tr>
      <tr><td width="50%">Total  </td> <td> : &nbsp;Rp.&nbsp;</td> <td><?php echo rp($total_akhir); ?> </tr>
            

  </tbody>
</table>



    
 <script>
$(document).ready(function(){
  window.print();
});
</script>


<?php 

} 

?>