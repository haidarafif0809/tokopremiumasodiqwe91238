<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);



//mencari total jumlah dan harga
    $query_perusahaan = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
    $data_perusahaan = mysqli_fetch_array($query_perusahaan);

$query_sum_detail_pembaelian = $db->query("SELECT SUM(jumlah_barang) as sum_jumlah,SUM(subtotal) as sum_subtotal,SUM(potongan) AS sum_potongan,SUM(tax) AS sum_tax,SUM(sisa) AS sum_sisa  FROM detail_pembelian  WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$data_sum_dari_detail_pembaelian = mysqli_fetch_array($query_sum_detail_pembaelian);
$total_akhir = $data_sum_dari_detail_pembaelian['sum_subtotal'];
$total_jumlah = $data_sum_dari_detail_pembaelian['sum_jumlah'];
$total_potongan = $data_sum_dari_detail_pembaelian['sum_potongan'];
$total_tax = $data_sum_dari_detail_pembaelian['sum_tax'];


 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>

                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PEMBELIAN DETAIL PER FAKTUR</b></h3>
                 <hr>
                 <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
         <br><br>                 
            <table>
               <tbody>
                <tr><td  width="20%">PERIODE</td> <td> &nbsp;:&nbsp; </td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?></td></tr>        
            </tbody>
          </table>                    
      </div><!--penutup colsm4-->
        
    </div><!--penutup row1-->
    <br>
    <br>
    <br>

 <table id="tableuser" class="table table-hover table-sm">
            <thead>
          <th> Nomor Faktur </th>
          <th> Kode Barang </th>
          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Harga </th>
          <th> Disc </th>
          <th> Tax </th>
          <th> Subtotal </th>
          <th> Sisa Barang </th>
                  <th> </th>                                    
                </thead>
                <tbody>
            <?php

                  $perintah009 = $db->query(" SELECT s.nama,dp.id,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.sisa, ss.nama AS asal_satuan FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ORDER BY dp.id DESC ");
                  while ($data11 = mysqli_fetch_array($perintah009))

                  {

              $pilih_konversi = $db->query("SELECT $data11[jumlah_barang] / sk.konversi AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data11[satuan]' AND sk.kode_produk = '$data11[kode_barang]'");
                $data_konversi = mysqli_fetch_array($pilih_konversi);

                if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
                  
                   $jumlah_barang = $data_konversi['jumlah_konversi'];
                }
                else{
                  $jumlah_barang = $data11['jumlah_barang'];
                }

                $sisa = cekStokHppProduk($data11['kode_barang'], $data11['no_faktur']);
          //menampilkan data
          echo "
          <tr>
          <td>".$data11['no_faktur']."</td>
          <td>".$data11['kode_barang']."</td>
          <td>".$data11['nama_barang']."</td>
          <td align='right'>".$jumlah_barang ." ". $data11['nama']."</td>
          <td align='right'>".rp($data11['harga'])."</td>
          <td align='right'>".rp($data11['potongan'])."</td>
          <td align='right'>".rp($data11['tax'])."</td>
          <td align='right'>".rp($data11['subtotal'])."</td>
          <td align='right'>".rp($sisa) ." ". $data11['asal_satuan']."</td>
          </tr>";
        }
          //menampilkan data
          echo "
          <tr>
          <td style='color:red'>TOTAL</td>
          <td style='color:red'></td>
          <td style='color:red'></td>
          <td style='color:red' align='right'>".rp($total_jumlah)."</td>
          <td style='color:red' align='right'>-</td>
          <td style='color:red' align='right'>".rp($total_potongan)."</td>
          <td style='color:red' align='right'>".rp($total_tax)."</td>
          <td style='color:red' align='right'>".rp($total_akhir)."</td>
          <td style='color:red' align='right'>-</td>
          </tr>";
         //Untuk Memutuskan Koneksi Ke Database       
       mysqli_close($db); 
            ?>
            </tbody>

      </table>
      <hr>
</div>
</div>
<br>

</div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>