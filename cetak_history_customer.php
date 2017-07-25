<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


$pelanggan = stringdoang($_GET['pelanggan']);
$dari_tanggal = stringdoang($_GET['daritgl']);
$sampai_tanggal = stringdoang($_GET['sampaitgl']);


$query_saldo_piutang_awal = $db->query("SELECT SUM(nilai_kredit) AS sum_nilai
      FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal < '$dari_tanggal'");
$data_piutang_awal_Penjualan = mysqli_fetch_array($query_saldo_piutang_awal);
$nilai_kredit = $data_piutang_awal_Penjualan['sum_nilai'];

$query_jumlah_bayar = $db->query("SELECT SUM(jumlah_bayar) AS sum_nilai
      FROM detail_pembayaran_piutang WHERE kode_pelanggan = '$pelanggan' AND tanggal < '$dari_tanggal'");
$data_jumlah_bayar = mysqli_fetch_array($query_jumlah_bayar);
$jumlah_bayar = $data_jumlah_bayar['sum_nilai'];

$saldo_awal_piutang = $nilai_kredit - $jumlah_bayar;


$query_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE id = '$pelanggan' ");
$data_pelanggan = mysqli_fetch_array($query_pelanggan);

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



    <center> <h4> <b> HISTORY CUSTOMER </b> </h4> </center>
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
      <th style='background-color: #4CAF50; color:white'> Saldo Piutang</th>
            
        </thead>
        <tbody>

    <tr style="color:red;">
<td></td>
<td></td>
<td></td>
<td><b style='color:red ;'>Saldo Piutang Awal</b></td>
<td></td>
<td></td>
<td class="rata-kanan"><b style='color:red ;'><?php echo rp($saldo_awal_piutang) ?></b></td>
</tr>

<?php 

$select = $db->query("SELECT no_faktur, tanggal,jam,total,jenis,no_faktur_terkait,pembayaran,saldo_piutang FROM (SELECT no_faktur AS no_faktur, tanggal AS tanggal,jam AS jam,total,CONCAT('Penjualan',' (',status_jual_awal,')') AS jenis,'' AS no_faktur_terkait,tunai AS pembayaran,nilai_kredit AS saldo_piutang 
	FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'  
	UNION SELECT no_faktur_retur AS no_faktur,  tanggal,jam AS jam,total,'Retur Penjualan' AS jenis ,'' AS no_faktur_terkait,tunai AS pembayaran,total AS saldo_piutang  
	FROM retur_penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' 
	UNION SELECT dpp.no_faktur_pembayaran AS no_faktur,  pp.tanggal,pp.jam AS jam, jumlah_bayar + potongan AS total ,'Pembayaran Piutang' AS jenis,no_faktur_penjualan 
	AS no_faktur_terkait,jumlah_bayar + potongan AS pembayaran,jumlah_bayar + potongan AS saldo_piutang  FROM detail_pembayaran_piutang dpp LEFT JOIN pembayaran_piutang pp ON dpp.no_faktur_pembayaran = pp.no_faktur_pembayaran  WHERE kode_pelanggan = '$pelanggan' AND dpp.tanggal >= '$dari_tanggal' 
	AND dpp.tanggal <= '$sampai_tanggal' ) AS p  ORDER BY CONCAT(tanggal,'',jam) ASC ");


while($data = mysqli_fetch_array($select))
  {

    
    echo "<tr>
		<td style='width:100px;' >".tgl($data["tanggal"])."</td>
		<td>".$data["jenis"]."</td>
		<td>".$data["no_faktur"]."</td>
		<td>".$data["no_faktur_terkait"]."</td>
		<td align='right'>".rp($data["total"])."</td>
		<td align='right'>".rp($data["pembayaran"])."</td>";
	    
	    if ($data["jenis"] == 'Penjualan (Kredit)' OR $data["jenis"] == 'Penjualan (Tunai)'){
	        $saldo_awal_piutang = $saldo_awal_piutang + $data['saldo_piutang'];

	        echo "<td align='right'> ".rp($saldo_awal_piutang)."</td>";

	    }

	    else if ($data["jenis"] == 'Retur Penjualan' OR $data["jenis"] == 'Pembayaran Piutang'){
	       $saldo_awal_piutang = $saldo_awal_piutang - $data['saldo_piutang'];

	      echo "<td align='right'> ".rp($saldo_awal_piutang)."</td>";

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