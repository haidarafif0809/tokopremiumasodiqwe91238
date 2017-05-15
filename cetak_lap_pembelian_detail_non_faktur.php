<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);



//mencari total jumlah dan harga
    $query_perusahaan = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
    $data_perusahaan = mysqli_fetch_array($query_perusahaan);

  $query_sum_detail_pembaelian = $db->query("SELECT SUM(jumlah_barang) as sum_jumlah,SUM(subtotal) as sum_subtotal,SUM(potongan) AS sum_potongan,SUM(tax) AS sum_tax,SUM(sisa) AS sum_sisa  FROM detail_pembelian  WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$data_sum_dari_detail_pembaelian = mysqli_fetch_array($query_sum_detail_pembaelian);
$total_akhir = $data_sum_dari_detail_pembaelian['sum_subtotal'];
$total_jumlah = $data_sum_dari_detail_pembaelian['sum_jumlah'];





 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>

                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PEMBELIAN DETAIL </b></h3>
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
          <th> Kode Barang </th>
          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Total </th>
          <th> Potongan </th>
          <th> Tax </th>

                  <th> </th>                                    
                </thead>
                <tbody>
            <?php

                $perintah009 = $db->query("SELECT SUM(dp.jumlah_barang) as sum_jumlah,s.nama,dp.id,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,SUM(dp.subtotal) as sum_subtotal,SUM(dp.potongan) AS sum_potongan,SUM(dp.tax) AS sum_tax,SUM(dp.sisa) AS sum_sisa, ss.nama AS asal_satuan FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' GROUP BY dp.kode_barang ");
                  while ($data11 = mysqli_fetch_array($perintah009))

                  {

          //menampilkan data
          echo "
          <tr>
          <td>".$data11['kode_barang']."</td>
          <td>".$data11['nama_barang']."</td>
          <td align='right'>".$data11['sum_jumlah'] ." ". $data11['asal_satuan']."</td>
          <td align='right'>".rp($data11['sum_subtotal'])."</td>
          <td>".rp($data11['sum_potongan'])."</td>
          <td>".rp($data11['sum_tax'])."</td>
          </tr>";


                  }
         //Untuk Memutuskan Koneksi Ke Database       
       mysqli_close($db); 
            ?>
        <td style='color:red'> - </td>
        <td style='color:red'> - </td>
        <td style='color:red' align='right'> <?php echo rp($total_jumlah); ?> </td>
        <td style='color:red' align='right'> <?php echo rp($total_akhir); ?> </td>
        <td style='color:red'> - </td>
        <td style='color:red'> - </td>
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