<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';



    $no_faktur = stringdoang($_GET['no_faktur']);

    $query0 = $db->query("SELECT no_faktur, potongan, tax, biaya_admin, total, tunai, sisa, tanggal FROM penjualan WHERE no_faktur = '$no_faktur' ");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT nama_barang, jumlah_barang, harga, subtotal, no_faktur FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");

    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];


        // AMBIL  ATURAN POIN
    $ambil_poin = $db->query("SELECT poin_rp, nilai_poin FROM aturan_poin ");
    $data_poin = mysqli_fetch_array($ambil_poin);

        // hitung jumlah poin yang didapat
        
        // total penjualan dibagi dengan ketentuan poin / aturan poin / nilai poin RP
        
        $hitung_poin = $data0['total'] / $data_poin['poin_rp'];

        // poin yang didapat = membulatkan hasil hitungan poin(kebwah) * nilai poin yg ada di aturan poin.
        $poin_yg_didapat = floor($hitung_poin) * $data_poin['nilai_poin'];
    // end hitung poin pelanggan


    $poin_masuk = $db->query("SELECT SUM(poin) AS total_poin FROM poin_masuk WHERE id_pelanggan = '$data0[kode_pelanggan]'");
    $masuk = mysqli_fetch_array($poin_masuk);

    $poin_keluar = $db->query("SELECT SUM(subtotal_poin) AS total_poin FROM poin_keluar WHERE id_pelanggan = '$data0[kode_pelanggan]'");
    $keluar = mysqli_fetch_array($poin_keluar);

                                      
    $total_poin = $masuk['total_poin'] - $keluar['total_poin'];

    
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
            //untuk mengambil data bonus
            $queryb = $db->query("SELECT bp.nama_produk,bp.qty_bonus,b.harga_jual,bp.harga_disc,bp.keterangan FROM bonus_penjualan bp LEFT JOIN barang b ON  bp.kode_produk = b.kode_barang WHERE bp.no_faktur_penjualan = '$data2[no_faktur]'");
            $bonus = mysqli_fetch_array($queryb);
            $keterangan = $bonus['keterangan'];
            if ($keterangan == 'Free Produk') {
              $subtotal_bonus = $bonus['qty_bonus'] * $bonus['harga_jual'];
            }
            else{
              $subtotal_bonus = $bonus['qty_bonus'] * $bonus['harga_jual'];
              $subtotal_bonusnya = $bonus['qty_bonus'] * $bonus['harga_disc'];
              $subtotal_bonus_disc = $subtotal_bonus - $subtotal_bonusnya;
            }
           
           echo '<tr><td width:"50%"> '. $data2['nama_barang'] .' </td> <td style="padding:3px"> '. $data2['jumlah_barang'] .'</td>  <td style="padding:3px"> '. rp($data2['harga']) .'</td>  <td style="padding:3px"> '. rp($data2['subtotal']) . ' </td></tr>';
           }
           echo '<tr><td width:"50%"> '. $bonus['nama_produk'] .' </td> <td style="padding:3px"> '. $bonus['qty_bonus'] .'</td>'; 
           if ($keterangan == 'Free Produk') {
              echo '<td style="padding:3px"> '. $bonus['harga_jual'] .'</td>';
            }
            else{
              echo '<td style="padding:3px"> '. $bonus['harga_jual'] .'</td>';
            } 
            echo '<td style="padding:3px"> '.rp($subtotal_bonus) .'</td></tr>';          
            if ($keterangan == 'Free Produk') {
              echo '<td style="padding:3px"> </td><td style="padding:3px"> </td><td style="padding:3px"> Disc : </td><td style="padding:3px"> '.'-'.rp($subtotal_bonus) .'</td>';
            }
            else{
              echo '<td style="padding:3px"> </td><td style="padding:3px"> </td><td style="padding:3px"> Disc : </td><td style="padding:3px"> '.'-'.rp($subtotal_bonus_disc) .'</td>';
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
      <!--<tr><td  width="50%">Pajak</td> <td> :</td> <td> /* echo rp($data0['tax']);?>*/ </td></tr>-->
      <tr><td  width="50%">Biaya Admin</td> <td> :</td> <td> <?php echo rp($data0['biaya_admin']);?> </td></tr>
      <tr><td  width="50%">Total Item</td> <td> :</td> <td> <?php echo $total_item; ?> </td></tr>
      <tr><td width="50%">Total Penjualan</td> <td> :</td> <td><?php echo rp($data0['total']); ?> </tr>
      <tr><td  width="50%">Tunai</td> <td> :</td> <td> <?php echo rp($data0['tunai']); ?> </td></tr>
      <tr><td  width="50%">Kembalian</td> <td> :</td> <td> <?php echo rp($data0['sisa']); ?>  </td></tr>
            

  </tbody>
</table>
    ===================<br>
     <table>
    <tbody>
        <tr><td width="50%">Poin Bertambah</td> <td> :</td> <td><?php echo rp($poin_yg_didapat);?> </tr>
        <tr><td  width="50%">Total Poin</td> <td> :</td> <td> <?php echo rp($total_poin);?> </td></tr>
           

    </tbody>
  </table>
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

