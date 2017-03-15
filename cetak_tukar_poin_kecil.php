<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = stringdoang($_GET['no_faktur']);
$tanggal = stringdoang($_GET['tanggal']);

$ambil_poin = $db->query("SELECT tp.total_poin, tp.sisa_poin , p.nama_pelanggan, p.kode_pelanggan FROM tukar_poin tp LEFT JOIN pelanggan p ON tp.pelanggan = p.id
 WHERE tp.no_faktur = '$no_faktur' ");
$data200 = mysqli_fetch_array($ambil_poin); 


    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT nama_barang,jumlah_barang,poin,subtotal_poin FROM detail_tukar_poin WHERE no_faktur = '$no_faktur' ");
    
 ?>



  <?php echo $data1['nama_perusahaan']; ?><br>
  <?php echo $data1['alamat_perusahaan']; ?><br><br>
  ===================<br>
  No Faktur : <?php echo $no_faktur; ?> || Kasir : <?php echo $_SESSION['nama']; ?><br>
  ===================<br>
 <table>

  <tbody>
           <?php 
           while ($data2 = mysqli_fetch_array($query2)){
           
           echo '<tr><td width:"50%"> '. $data2['nama_barang'] .' </td> <td style="padding:3px"> '. $data2['jumlah_barang'] .'</td>  
           <td style="padding:3px"> '. rp($data2['poin']) .'</td>  
           <td style="padding:3px"> '. rp($data2['subtotal_poin']) . ' </td></tr>';
           
           }
           
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);            
           
           ?> 
 </tbody>
</table>
    ===================<br>
     <table>
    <tbody>
        <tr><td width="50%">Poin Berkurang</td> <td> :</td> <td><?php echo rp($data200['total_poin']);?> </tr>
        <tr><td  width="50%">Total Poin</td> <td> :</td> <td> <?php echo rp($data200['sisa_poin']);?> </td></tr>
           

    </tbody>
  </table>
    ===================<br>
    Tanggal : <?php echo tanggal($tanggal);?><br>
    ===================<br><br>
    Terima Kasih<br>
    Selamat Datang Kembali<br>
    Telp. <?php echo $data1['no_telp']; ?><br>



 <script>
$(document).ready(function(){
  window.print();
});
</script>

 </body>
 </html>

