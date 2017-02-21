<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

$setting_akun = $db->query("SELECT * FROM setting_akun");
$data_setting = mysqli_fetch_array($setting_akun);


 ?>




<div class="container"><!--start of container-->

<h3>PENGATURAN AKUN</h3><hr>

       <ul class="nav nav-tabs md-pills pills-ins" role="tablist">


			<li class='nav-item'><a class='nav-link' href='setting_akun_data_item.php'> Data Item </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_pembelian.php'> Pembelian </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_penjualan.php'> Penjualan </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_hutang_piutang.php'> Hutang Piutang </a></li>
			<li class='nav-item'><a class='nav-link active' href='setting_akun_data_lain.php'> Lain-lain </a></li>


         </ul>
         <br><br>
<form class="form" action="proses_simpan_setting_akun_data_lain.php" method="post">         
<h3><b>Modal dan Laba</b></h3><br><br>

<table>
  <tbody>

      <tr><td  width="45%"><p>Prive</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="prive">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($pembayaran_dp = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$pembayaran_dp['kode_daftar_akun'] ."'";

		if ($data_setting['prive'] == $pembayaran_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$pembayaran_dp['kode_daftar_akun'] ." - ".$pembayaran_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>

</tbody>
</table>

<table>
  <tbody>

      <tr><td  width="45%"><p>Laba Ditahan</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="laba_ditahan">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($pembayaran_dp = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$pembayaran_dp['kode_daftar_akun'] ."'";

		if ($data_setting['laba_ditahan'] == $pembayaran_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$pembayaran_dp['kode_daftar_akun'] ." - ".$pembayaran_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>

</tbody>
</table>

<table>
  <tbody>

      <tr><td  width="45%"><p>Laba Tahun Berjalan</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="laba_tahun_berjalan">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($pembayaran_dp = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$pembayaran_dp['kode_daftar_akun'] ."'";

		if ($data_setting['laba_tahun_berjalan'] == $pembayaran_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$pembayaran_dp['kode_daftar_akun'] ." - ".$pembayaran_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>

</tbody>
</table><br><br>

<table>
  <tbody>

      <tr><td  width="45%"><p>Penyeimbang / Historical Balancing </p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="balancing">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($pembayaran_dp = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$pembayaran_dp['kode_daftar_akun'] ."'";

		if ($data_setting['balancing'] == $pembayaran_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$pembayaran_dp['kode_daftar_akun'] ." - ".$pembayaran_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>

</tbody>
</table><br><br>

<table>
  <tbody>

      <tr><td  width="45%"><p>Biaya Lain diambil dari</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="kas">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($pembayaran_dp = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$pembayaran_dp['kode_daftar_akun'] ."'";

		if ($data_setting['kas'] == $pembayaran_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$pembayaran_dp['kode_daftar_akun'] ." - ".$pembayaran_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>

</tbody>
</table>
<hr>
<button type="submit" id="simpan" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan </button>
</form>

</div>

<?php 
include 'footer.php';
 ?>