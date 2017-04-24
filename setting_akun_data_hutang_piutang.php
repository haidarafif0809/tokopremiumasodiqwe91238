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
			<li class='nav-item'><a class='nav-link active' href='setting_akun_data_hutang_piutang.php'> Hutang Piutang </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_lain.php'> Lain-lain </a></li>


         </ul>
         <br><br>

<form class="form" action="proses_simpan_setting_akun_data_hutang_piutang.php" method="post">
<h3><b>Data Akun Hutang Piutang</b></h3><br><br>

<table>
  <tbody>

      <tr><td  width="45%"><p>Potongan Hutang</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="pot_hutang">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pot_hutang = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$data_pot_hutang['kode_daftar_akun'] ."'";

		if ($data_setting['potongan_hutang'] == $data_pot_hutang['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pot_hutang['kode_daftar_akun'] ." - ".$data_pot_hutang['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>
      <tr><td  width="45%"><p>Potongan Piutang</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="pot_piutang">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pot_piutang = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_pot_piutang['kode_daftar_akun'] ."'";

		if ($data_setting['potongan_piutang'] == $data_pot_piutang['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pot_piutang['kode_daftar_akun'] ." - ".$data_pot_piutang['nama_daftar_akun'] ."</option>";
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