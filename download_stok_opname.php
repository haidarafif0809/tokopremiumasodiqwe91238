<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_stok_opname.xls");

include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_GET['no_faktur']);


 ?>


<div class="container">
<center><h3>Data Stok Opname No Faktur <?php echo $no_faktur; ?></h3></center>

<!--Plus-->
    <table id="kartu_stok" class="table table-bordered">
<center><h4>Data Stok Opname </h4></center>
        <!-- membuat nama kolom tabel -->
        <thead>

      <th style='background-color: #4CAF50; color:white'> No Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
      <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
      <th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
      <th style='background-color: #4CAF50; color:white'> Fisik </th>
      <th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
      <th style='background-color: #4CAF50; color:white'> HPP</th>
      <th style='background-color: #4CAF50; color:white'> Selisih Harga</th>

</thead>
<tbody>

<?php 

$total_selisih_harga = 0;

$query_plus = $db->query ("SELECT no_faktur,kode_barang,nama_barang,stok_sekarang,fisik,selisih_fisik,hpp FROM detail_stok_opname WHERE no_faktur = '$no_faktur'  ");
		while ($out_plus = mysqli_fetch_array($query_plus))
			{
				//menampilkan data
			echo "<tr>
			<td>". $out_plus['no_faktur'] ."</td>
			<td>". $out_plus['kode_barang'] ."</td>
			<td>". $out_plus['nama_barang'] ."</td>
			<td>". $out_plus['stok_sekarang'] ."</td>
			<td>". $out_plus['fisik'] ."</td>
			<td>". $out_plus['selisih_fisik'] ."</td>
			<td>". $out_plus['hpp'] ."</td>
			<td>". $out_plus['hpp'] ."</td>

			</tr>";

			$total_selisih_harga = $total_selisih_harga + $out_plus['selisih_harga'];

			}

			echo "<tr>
			<td style='color:red'> TOTAL </td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style='color:red'>".$total_selisih_harga."</td>

			</tr>";
//Untuk Memutuskan Koneksi Ke Database
?>
        </tbody>
    </table>      
<!-- Ending Plus-->


</div> <!--Closed Container-->
