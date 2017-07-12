<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


  //menampilkan seluruh data yang ada pada tabel penjualan
  $penjualan = $db->query("SELECT kode_barang , nama_barang , SUM(jumlah_barang) AS jumlah_barang, SUM(subtotal) AS total_penjualan , IFNULL(SUM(potongan),0) 
    AS total_potongan,(SELECT IFNULL( SUM(total_nilai),0) AS total_hpp FROM hpp_keluar WHERE kode_barang = detail_penjualan.kode_barang 
      AND hpp_keluar.tanggal >= '$dari_tanggal' AND hpp_keluar.tanggal <= '$sampai_tanggal' AND hpp_keluar.jenis_transaksi = 'Penjualan') AS total_hpp,SUM(subtotal) - (SELECT IFNULL( SUM(total_nilai),0) AS total_hpp FROM hpp_keluar WHERE kode_barang = detail_penjualan.kode_barang AND hpp_keluar.tanggal >= '$dari_tanggal' AND hpp_keluar.tanggal <= '$sampai_tanggal' AND hpp_keluar.jenis_transaksi = 'Penjualan') AS total_laba FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY detail_penjualan.kode_barang ORDER BY SUM(subtotal) - total_hpp DESC");

    $query1 = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    // total keseluruhan
    $jumlah_barang = 0;
    $total_penjualan = 0;
    $total_hpp = 0;
    $total_potongan = 0;
    $total_laba = 0;


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
                 <h4> <b> LAPORAN LABA KOTOR PENJUALAN PERPRODUK  </b></h4>
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
<br><br>
 <table id="tableuser" class="table1">
         <thead>
              <th class="table1" style="text-align: center; width: 5%"> Kode Produk </th>
              <th class="table1" style="text-align: center; width: 5%"> Nama Produk </th>
              <th class="table1" style="text-align: center; width: 5%"> Jumlah Produk</th>
              <th class="table1" style="text-align: center; width: 5%"> Total Penjualan </th>
              <th class="table1" style="text-align: center; width: 5%"> Total HPP </th>
              <th class="table1" style="text-align: center; width: 5%"> Total Diskon</th>
              <th class="table1" style="text-align: center; width: 5%"> Total Laba</th> 
              <th class="table1" style="text-align: center; width: 5%"> %Laba </th> 
			
		</thead>
		
		<tbody>
		<?php
			//menyimpan data sementara yang ada pada $perintah
			while ($data_penjualan = mysqli_fetch_array($penjualan))

			{


      // persentase labe
      // (total laba / total penjualan) * 100
      $persentase_laba = ($data_penjualan['total_laba'] / $data_penjualan['total_penjualan']) * 100;

            // total keseluruhan
      $jumlah_barang = $data_penjualan['jumlah_barang'] + $jumlah_barang;
      $total_penjualan = $data_penjualan['total_penjualan'] + $total_penjualan;
      $total_hpp = $data_penjualan['total_hpp'] + $total_hpp;
      $total_potongan = $data_penjualan['total_hpp'] + $total_potongan;
      $total_laba = $data_penjualan['total_penjualan'] +  $total_laba;

		//menampilkan data
			echo "<tr>
			<td class='table1' style='text-align: center'>". $data_penjualan['kode_barang'] ."</td>
			<td class='table1' style='text-align: center'>". $data_penjualan['nama_barang'] ."</td>
			<td class='table1' style='text-align: right'>". rp($data_penjualan['jumlah_barang']) ."</td>
			<td class='table1' style='text-align: right'>". rp($data_penjualan['total_penjualan']) ."</td>
			<td class='table1' style='text-align: right'>". rp($data_penjualan['total_hpp']) ."</td>
			<td class='table1' style='text-align: right'>". rp($data_penjualan['total_potongan']) ."</td>
			<td class='table1' style='text-align: right'>". rp($data_penjualan['total_laba']) ."</td>
			<td class='table1' style='text-align: right'>". rp($persentase_laba,2) ."%</td>
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
		
		<tr><td width="50%"><font class="satu"><b>Jumlah Produk</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($jumlah_barang); ?></td></tr>
		<tr><td width="50%"><font class="satu"><b>Total Penjualan</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_penjualan); ?></td></tr>
		<tr><td  width="50%"><font class="satu"><b>Total HPP</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_hpp); ?></td></tr>
		<tr><td  width="50%"><font class="satu"><b>Total Diskon </b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_potongan); ?></td></tr>
		<tr><td  width="50%"><font class="satu"><b>Total Laba</b></font></td> <td><b> :&nbsp;</b></td> <td><?php echo rp($total_laba); ?></td></tr>
		
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