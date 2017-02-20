<?php session_start();
  
include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = $_GET['no_faktur'];

    $query0 = $db->query("SELECT * FROM penjualan WHERE no_faktur = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");
    

    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];


    
 ?>


 	<?php echo $data1['nama_perusahaan']; ?><br>
 	<?php echo $data1['alamat_perusahaan']; ?><br><br>
 	===================<br>
 	No Faktur : <?php echo $data0['no_faktur']; ?> || Kasir : <?php echo $_SESSION['nama']; ?><br>
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
      <tr><td width="50%">Diskon</td> <td> :</td> <td><?php echo rp($data0['potongan']);?> </tr>
      <tr><td  width="50%">Pajak</td> <td> :</td> <td> <?php echo rp($data0['tax']);?> </td></tr>
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
    (* Sudah Termasuk PPN 10%)
    
 <script>
$(document).ready(function(){
  window.print();
});
</script>


 </body>
 </html>

