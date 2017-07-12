<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$penjualan = $db->query("SELECT p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,pl.nama_pelanggan FROM penjualan p INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'  ORDER BY p.id DESC");

      


      $sum_subtotal_detail_penjualan = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
      $cek_sum_sub = mysqli_fetch_array($sum_subtotal_detail_penjualan);
      
      $sum_pajak_penjualan = $db->query("SELECT SUM(tax) AS pajak, SUM(potongan) AS diskon FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
      $cek_sum_pajak = mysqli_fetch_array($sum_pajak_penjualan);
      
      $subtotal = $cek_sum_sub['subtotal'] + $cek_sum_pajak['pajak'];
      
      $sum_hpp_penjualan = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND jenis_transaksi = 'Penjualan' ");
      $cek_sum_hpp = mysqli_fetch_array($sum_hpp_penjualan);
      
      $laba_kotor = $subtotal - $cek_sum_hpp['total_hpp'];
      
      $laba_jual = $laba_kotor - $cek_sum_pajak['diskon'];
      
      $total_subtotal = $subtotal;
      $total_total_pokok = $cek_sum_hpp['total_hpp'];
      $total_laba_kotor = $laba_kotor;
      $total_diskon = $cek_sum_pajak['diskon'];
      $total_laba_jual = $laba_jual;



    $query1 = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>

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


<div class="container">

     <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h4> <b> LAPORAN LABA KOTOR PENJUALAN REKAP  </b></h4>
                 <hr>
                 <h5> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h5> 
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






 <table id="tableuser" class="table1">
         <thead>
			
			<th class="table1" style="text-align: center; width: 5%"> Nomor Transaksi </th>
			<th class="table1" style="text-align: center; width: 5%"> Tanggal </th>
			<th class="table1" style="text-align: center; width: 5%"> Kode Pelanggan</th>
			<th class="table1" style="text-align: center; width: 5%"> Sub Total </th>
			<th class="table1" style="text-align: center; width: 5%"> Total Pokok </th>
			<th class="table1" style="text-align: center; width: 5%"> Laba Kotor </th>
			<th class="table1" style="text-align: center; width: 5%"> Diskon Faktur </th>
			<th class="table1" style="text-align: center; width: 5%"> Laba Jual </th>
			
		</thead>
		
		<tbody>
		<?php
			//menyimpan data sementara yang ada pada $perintah
			while ($data_penjualan = mysqli_fetch_array($penjualan))


			{


      $sum_subtotal_detail_penjualan = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_penjualan WHERE no_faktur = '$data_penjualan[no_faktur]'");
      $cek_sum_sub = mysqli_fetch_array($sum_subtotal_detail_penjualan);
      
      $subtotal = $cek_sum_sub['subtotal'];
      
      $sum_hpp_penjualan = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$data_penjualan[no_faktur]' AND jenis_transaksi = 'Penjualan' ");
      $cek_sum_hpp = mysqli_fetch_array($sum_hpp_penjualan);
      
      $laba_kotor = $subtotal - $cek_sum_hpp['total_hpp'];
      
      $laba_jual = $laba_kotor - $data_penjualan['potongan'];

		//menampilkan data
			echo "<tr>
			<td class='table1' style='text-align: center'>". $data_penjualan['no_faktur'] ."</td>
			<td class='table1' style='text-align: center'>". $data_penjualan['tanggal'] ."</td>
			<td class='table1' style='text-align: center'>". $data_penjualan['kode_pelanggan'] ." - ". $data_penjualan['nama_pelanggan'] ."</td>
			<td class='table1' style='text-align: right'>". rp($subtotal) ."</td>
			<td class='table1' style='text-align: right'>". rp($cek_sum_hpp['total_hpp']) ."</td>
			<td class='table1' style='text-align: right'>". rp($laba_kotor) ."</td>
			<td class='table1' style='text-align: right'>". rp($data_penjualan['potongan']) ."</td>
			<td class='table1' style='text-align: right'>". rp($laba_jual) ."</td>
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   

		?>
		</tbody>

	</table>
	<hr>

<div class="col-sm-6">
</div>
			
			<div class="col-sm-3">
			
			<i><b><font class="satu">TOTAL KESELURUHAN :</font></b>  </i> <br>

			</div>
<div class="col-sm-3">
		<table>
		<tbody>
		
		<tr><td width="50%"><font class="satu"><b>Sub Total</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_subtotal); ?></td></tr>
		<tr><td width="50%"><font class="satu"><b>Total Pokok</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_total_pokok); ?></td></tr>
		<tr><td  width="50%"><font class="satu"><b>Laba Kotor</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_laba_kotor); ?></td></tr>
		<tr><td  width="50%"><font class="satu"><b>Diskon Faktur</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_diskon); ?></td></tr>
		<tr><td  width="50%"><font class="satu"><b>Laba Jual</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_laba_jual); ?></td></tr>
		
		</tbody>
		</table>
</div>


</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>