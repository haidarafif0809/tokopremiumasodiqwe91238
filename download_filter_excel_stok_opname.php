<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_filter_stok_opname.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']); 
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


?>

<div class="container">
<center><h3><b>Data Loss Customer</b></h3></center>

	<table id="table_filter_stok_opname" class="table table-bordered table-sm">
    	<thead>
      <th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
      <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
      <th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
      <th style='background-color: #4CAF50; color:white'> Fisik </th>
      <th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
      <th style='background-color: #4CAF50; color:white'> Selisih Harga</th>
      <th style='background-color: #4CAF50; color:white'> Status </th>
      <th style='background-color: #4CAF50; color:white'> User </th>
      <th style='background-color: #4CAF50; color:white'> Keterangan </th>
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jam </th> 
    	</thead>
  <tbody>
<?php 


$query_stok_opname = $db->query(" SELECT so.no_faktur,so.tanggal,so.jam,so.status,so.total_selisih,so.user,so.id,so.keterangan,dso.kode_barang,dso.nama_barang,dso.stok_sekarang,dso.fisik,dso.selisih_fisik FROM stok_opname so LEFT JOIN detail_stok_opname dso ON so.no_faktur = dso.no_faktur WHERE so.tanggal >= '$dari_tanggal' AND so.tanggal <= '$sampai_tanggal' ");
while ($row = mysqli_fetch_array($query_stok_opname)) {
	# code...
	 echo "<tr>
                <td>". $row["no_faktur"] ."</td>
                <td>". $row["kode_barang"] ."</td>
                <td>". $row["nama_barang"] ."</td>
                <td>". rp($row["stok_sekarang"]) ."</td>
                <td>". rp($row["fisik"]) ."</td>
                <td>". rp($row["selisih_fisik"]) ."</td>
                <td>". rp($row["total_selisih"]) ."</td>
                <td>". $row["status"] ."</td>
                <td>". $row["user"] ."</td>
                <td>". $row["keterangan"] ."</td>
                <td>". $row["tanggal"] ."</td>
                <td>". $row["jam"] ."</td>
          <tr>";

}

 ?>
    </tbody>
 </table>

 </div> <!--end container-->
