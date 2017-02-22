<?php 
include 'sanitasi.php';
include 'db.php';


?>

<div class="table-responsive">
        <table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Suplier </th>
      <th> Total Beli</th>
      <th> Tanggal </th>
      <th> Tanggal Jatuh Tempo </th>
      <th> Jam </th>
      <th> User </th>
      <th> Status </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa </th>
      <th> Kredit </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php

  
        $suplier = $_POST['suplier'];
        $no_faktur_pembayaran = $_POST['no_faktur_pembayaran'];
        
       
        $perintah = $db->query("SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama,g.nama_gudang FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.suplier = '$suplier'  ORDER BY p.id DESC");
        
        
        while ($data1 = mysqli_fetch_array($perintah))
        {

        	 $query00 = $db->query("SELECT tb.no_faktur_pembelian,dh.jumlah_bayar AS jumlah_detail ,IFNULL(tb.jumlah_bayar,0) AS jumlah_tbs FROM detail_pembayaran_hutang dh LEFT JOIN tbs_pembayaran_hutang tb ON dh.no_faktur_pembayaran = tb.no_faktur_pembayaran WHERE dh.no_faktur_pembelian = '$data1[no_faktur]' AND dh.no_faktur_pembayaran = '$no_faktur_pembayaran'");

         
          $data01 = mysqli_fetch_array($query00);
          $jumlah_detail = $data01['jumlah_detail'];
          $jumlah_tbs = $data01['jumlah_tbs'];
          $sisa_hutang = ($data1['kredit'] + $jumlah_detail) - $jumlah_tbs; 


        if ($jumlah_tbs > 0 OR $sisa_hutang == 0 ) 
        {
          
        }

        else{




       echo "<tr class='pilih' no-faktur='". $data1['no_faktur'] ."' kredit='". $sisa_hutang ."' total='". $data1['total'] ."' tanggal_jt='". $data1['tanggal_jt'] ."'  >
      


      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['nama'] ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['user'] ."</td>
      <td>". $data1['status'] ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['tax']) ."</td>
      <td>". rp($data1['sisa']) ."</td>
      <td>". rp($sisa_hutang) ."</td>
      </tr>";
      
       }
   }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </tbody> <!--tag penutup tbody-->

  </table> 
  </div>
<script type="text/javascript">
  $(function () {
  $("#tableuser").dataTable();
  });
</script>