<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = $_GET['no_faktur'];

    $query0 = $db->query("SELECT * FROM penjualan_order WHERE no_faktur_order = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT * FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur' ");


    $total_item = 0;
    
 ?>



  <?php echo $data1['nama_perusahaan']; ?><br>
  <?php echo $data1['alamat_perusahaan']; ?><br><br>
  ===================<br>
  No Faktur : <?php echo $data0['no_faktur_order']; ?> || Kasir : <?php echo $_SESSION['nama']; ?><br>
  Status : <b><?php echo $data0['status_order']; ?> </b><br>
  ===================<br>
 <table>

  <tbody>
           <?php 
           while ($data2 = mysqli_fetch_array($query2)){

                    // QUERY CEK BARCODE DI SATUAN KONVERSI
                                    
            $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data,konversi  FROM satuan_konversi WHERE kode_produk = '$data2[kode_barang]' AND id_satuan = '$data2[satuan]' ");
            $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);     

            // QUERY CEK BARCODE DI SATUAN KONVERSI

            if ($data2['harga_konversi'] != 0) {
             $harga = $data2['harga_konversi'];
            }else{
              $harga = $data2['harga'];
            }

                        // IF CEK BARCODE DI SATUAN KONVERSI
            if ($data_satuan_konversi['jumlah_data'] > 0) {//    if ($data_satuan_konversi['jumlah_data'] > 0) {
                    
                    $jumlah_barang = $data2['jumlah_barang'] / $data_satuan_konversi['konversi'];
                                        
                  }else{
                      
                     $jumlah_barang = $data2['jumlah_barang'];

                  }

            $total_item = $total_item + $jumlah_barang;
           
           echo '<tr><td width:"50%"> '. $data2['nama_barang'] .' </td> <td style="padding:3px"> '. $jumlah_barang .'</td>  <td style="padding:3px"> '. rp($harga) .'</td> </tr>';
           
           }
           
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);            
           
           ?> 
 </tbody>
</table>
    ===================<br>
 <table>
  <tbody>
      <tr><td  width="50%">Total Item</td> <td> :</td> <td> <?php echo $total_item; ?> </td></tr>

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