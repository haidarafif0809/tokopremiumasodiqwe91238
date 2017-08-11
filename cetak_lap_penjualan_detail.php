<?php include 'session_login.php';
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);


$total_jumlah = 0;
$total_harga = 0;
$total_subtotal = 0;
$total_potongan = 0;
$total_tax = 0;


 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PENJUALAN DETAIL </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
         <br><br>                 
<table>
  <tbody>

      <tr><td  width="20%">PERIODE</td> <td> &nbsp;:&nbsp; </td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?></td>
      </tr>
            
  </tbody>
</table>           
                 
        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->
    <br>
    <br>
    <br>


  <table id="table_lap_penjualan_detail" class="table table-bordered">
              <thead>
              <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
              <th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
              <th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
              <th style="background-color: #4CAF50; color: white;"> Jumlah Barang </th>
              <th style="background-color: #4CAF50; color: white;"> Satuan </th>
              <th style="background-color: #4CAF50; color: white;"> Harga </th>
              <th style="background-color: #4CAF50; color: white;"> Subtotal </th>
              <th style="background-color: #4CAF50; color: white;"> Potongan </th>
              <th style="background-color: #4CAF50; color: white;"> Tax </th>
          <?php 
                 if ($_SESSION['otoritas'] == 'Pimpinan')
                 {
                 echo "<th style='background-color: #4CAF50; color: white;'> Hpp </th>";
                 }
          ?>

              
              <th style="background-color: #4CAF50; color: white;"> Sisa Barang </th>
              <th style="background-color: #4CAF50; color: white;"> Status </th>
              
        </thead>                                  
            </thead>
            
            <tbody>
            <?php
                  $perintah009 = $db->query("SELECT s.nama,dp.id,p.status,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.hpp,dp.sisa FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN penjualan p ON dp.no_faktur = p.no_faktur WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ORDER BY dp.no_faktur DESC ");
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

                $total_jumlah = $jumlah_barang + $total_jumlah;
              $total_harga = $data11['harga'] + $total_harga;
              $total_subtotal = $data11['subtotal'] + $total_subtotal;
              $total_potongan = $data11['potongan'] + $total_potongan;
              $total_tax = $data11['tax'] + $total_tax;

          //menampilkan data
          echo "<tr>
          <td>".$data11['no_faktur']."
          <td>".$data11['kode_barang']."</td>
          <td>".$data11['nama_barang']."</td>
          <td>".koma($jumlah_barang,3)."</td>
          <td>".$data11['nama']."</td>
          <td>".koma($data11['harga'],2)."</td>
          <td>".koma($data11['subtotal'],2)."</td>
          <td>".koma($data11['potongan'],2)."</td>
          <td>".koma($data11['tax'],2)."</td>";

        if ($_SESSION['otoritas'] == 'Pimpinan'){

                echo "<td>".koma($data11['hpp'],2)."</td>";
        }

          echo "<td>".$data11['sisa']."</td>
          <td>".$data11['status']."</td>";
                     

                  "</tr>";


                  }

            //Untuk Memutuskan Koneksi Ke Database
            mysqli_close($db); 
            ?>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td style='color:red;'><?php echo koma($total_jumlah,3);?></td>
          <td></td>
          <td style='color:red;'><?php echo koma($total_harga,2);?></td>
          <td style='color:red;'><?php echo koma($total_subtotal,2);?></td>
          <td style='color:red;'><?php echo koma($total_potongan,2);?></td>
          <td style='color:red;'><?php echo koma($total_tax,2);?></td>
          <td></td>
          <td></td>
</tr>
        </tbody>

      </table>
      <hr>
</div>
</div>
<br>

<div class="col-sm-7">
</div>


 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>