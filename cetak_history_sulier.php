<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


$suplier = stringdoang($_GET['suplier']);
$dari_tanggal = stringdoang($_GET['daritgl']);
$sampai_tanggal = stringdoang($_GET['sampaitgl']);


$query_saldo_hutang_awal = $db->query("SELECT SUM(nilai_kredit) AS sum_nilai
      FROM pembelian WHERE suplier = '$suplier' AND tanggal < '$dari_tanggal'");
$data_hutang_awal_pembelian = mysqli_fetch_array($query_saldo_hutang_awal);
$nilai_kredit = $data_hutang_awal_pembelian['sum_nilai'];

$query_jumlah_bayar = $db->query("SELECT SUM(jumlah_bayar) AS sum_nilai
      FROM detail_pembayaran_hutang WHERE suplier = '$suplier' AND tanggal < '$dari_tanggal'");
$data_jumlah_bayar = mysqli_fetch_array($query_jumlah_bayar);
$jumlah_bayar = $data_jumlah_bayar['sum_nilai'];


$query_kredit_pembelian_lama = $db->query("SELECT SUM(rph.kredit_pembelian_lama) AS saldo_hutang
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal < '$dari_tanggal' ");
$data_kredit_pembelian_lama = mysqli_fetch_array($query_kredit_pembelian_lama);
$kredit_pembelian_lama = $data_kredit_pembelian_lama['saldo_hutang'];


$saldo_awal_hutang = $nilai_kredit - ($jumlah_bayar + $kredit_pembelian_lama);

    $query1 = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);
    


 ?>

<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
   .rata-kanan{
    text-align: right;
   }
</style>


<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='80' height='80`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $data1['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->



    <center> <h4> <b> HISTORY SUPLIER </b> </h4> </center>
    <center> <h4> <b> PERIODE <?php echo tgl($dari_tanggal); ?> Sampai <?php echo tgl($sampai_tanggal); ?></b> </h4> </center><hr>



  <div class="row">
    <div class="col-sm-9">

    </div>


<style type="text/css">
  th,td{
    padding: 1px;
  }


.table1, .th, .td {
    border: 1px solid black;
    font-size: 15px;
    font: verdana;
}


</style>
<br><br>
<table id="tableuser" class="table table-bordered table-sm">
        <thead>
      
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jenis Transaksi </th>
      <th style='background-color: #4CAF50; color:white'> No Faktur</th>
      <th style='background-color: #4CAF50; color:white'> No Faktur Terkait </th>
      <th style='background-color: #4CAF50; color:white'> Nilai Faktur</th>
      <th style='background-color: #4CAF50; color:white'> Pembayaran</th>
      <th style='background-color: #4CAF50; color:white'> Saldo Hutang</th>
            
        </thead>
        <tbody>

    <tr style="color:red;">
<td></td>
<td></td>
<td></td>
<td><b style='color:red ;'>Saldo Hutang Awal</b></td>
<td></td>
<td></td>
<td class="rata-kanan"><b style='color:red ;'><?php echo rp($saldo_awal_hutang) ?></b></td>
</tr>

<?php 

$select = $db->query("SELECT no_faktur, tanggal,total,jenis,no_faktur_terkait,pembayaran,saldo_hutang
FROM (SELECT no_faktur AS no_faktur, tanggal AS tanggal,total,CONCAT('Pembelian',' (',status_beli_awal,')') AS jenis,'' AS no_faktur_terkait,tunai AS pembayaran,nilai_kredit AS saldo_hutang
      FROM pembelian WHERE suplier = '$suplier' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'
      UNION SELECT rb.no_faktur_retur AS no_faktur,  rb.tanggal,rb.total,'Retur Pembelian' AS jenis ,'' AS no_faktur_terkait,rb.total_bayar AS pembayaran,rph.kredit_pembelian_lama AS saldo_hutang
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal >= '$dari_tanggal' AND rb.tanggal <= '$sampai_tanggal' UNION SELECT no_faktur_pembayaran AS no_faktur,  tanggal,jumlah_bayar AS total ,'Pembayaran Hutang' AS jenis,no_faktur_pembelian AS no_faktur_terkait,jumlah_bayar AS pembayaran,jumlah_bayar AS saldo_hutang
      FROM detail_pembayaran_hutang WHERE suplier = '$suplier' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ) AS p ORDER BY tanggal ASC ");


while($data = mysqli_fetch_array($select))
  {

    
    echo "<tr>
    <td style='width:100px;' >".tgl($data["tanggal"])."</td>";
    if($data["jenis"] == 'Retur Pembelian' AND $data["total"] == 0 ){
    echo "<td style='width:250px;' >Retur Pembelian (Potong Hutang)</td>";
    }
    else{
     echo "<td>".$data["jenis"]."</td>";
    }
     echo "<td>".$data["no_faktur"]."</td>
     <td>".$data["no_faktur_terkait"]."</td>
     <td align='right'>".rp($data["total"])."</td>
     <td align='right'>".rp($data["pembayaran"])."</td>";
    
    if($data["saldo_hutang"] == ""){
    echo "<td style='color:red;width:110px;' align='right'>Tidak Ada Perubahan</td>";
    }else{


    if ($data["jenis"] == 'Pembelian (Kredit)' OR $data["jenis"] == 'Pembelian (Tunai)'){
        $saldo_awal_hutang = $saldo_awal_hutang + $data['saldo_hutang'];

        echo "<td align='right'> ".rp($saldo_awal_hutang)."</td>";

    }

    else if ($data["jenis"] == 'Retur Pembelian' OR $data["jenis"] == 'Pembayaran Hutang'){
       $saldo_awal_hutang = $saldo_awal_hutang - $data['saldo_hutang'];

      echo "<td align='right'> ".rp($saldo_awal_hutang)."</td>";

    }

    }

    echo "</tr>";


} // and while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>

    </table>


<br>


    <div class="col-sm-9">  
    <!--<font class="satu"><b>Nama <?php echo $data200['kata_ubah']; ?> <br><br><br> <font class="satu"><?php echo $data_inner['nama_pelanggan']; ?></font> </b></font>--> 
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-3"> 
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>
    </div> <!--/ col-sm-6-->




</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>