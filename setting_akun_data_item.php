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


			<li class='nav-item'><a class='nav-link active' href='setting_akun_data_item.php'> Data Item </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_pembelian.php'> Pembelian </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_penjualan.php'> Penjualan </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_hutang_piutang.php'> Hutang Piutang </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_lain.php'> Lain-lain </a></li>


         </ul>
         <br><br>

<h3><b>Data Akun Perkiraan</b></h3><br><br>

<form class="form" action="proses_simpan_setting_akun_data_item.php" method="post">
 <table>
  <tbody>

      <tr><td  width="45%"><p>Harga Pokok Penjualan</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="hpp">

<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_hpp = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$data_hpp['kode_daftar_akun'] ."'";
		if ($data_setting['hpp_penjualan'] == $data_hpp['kode_daftar_akun'] ) {
			echo"selected";
		}


		echo ">".$data_hpp['kode_daftar_akun'] ." - ".$data_hpp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>
      <tr><td  width="45%"><p>Pendapatan Jual</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="pend_jual">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pendapatan = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_pendapatan['kode_daftar_akun'] ."'";

		if ($data_setting['total_penjualan'] == $data_pendapatan['kode_daftar_akun']) {
			echo "selected";
		}


		echo ">".$data_pendapatan['kode_daftar_akun'] ." - ".$data_pendapatan['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>
      <tr><td  width="45%"><p>Persediaan</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="persediaan">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_persediaan = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_persediaan['kode_daftar_akun'] ."'";

		if ($data_setting['persediaan'] == $data_persediaan['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_persediaan['kode_daftar_akun'] ." - ".$data_persediaan['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>   

  </tbody>
</table>
<br><br>

<h3><b>Data Akun Saldo Awal, Item Masuk & Keluar</b></h3><br><br>

<table>
  <tbody>

      <tr><td  width="45%"><p>Item Masuk</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="item_masuk">
<?php 
$daftar_akun3 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_item_masuk = mysqli_fetch_array($daftar_akun3))
		{
		
		echo "<option value='".$data_item_masuk['kode_daftar_akun'] ."'";

		if ($data_setting['item_masuk'] == $data_item_masuk['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_item_masuk['kode_daftar_akun'] ." - ".$data_item_masuk['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>
      <tr><td  width="45%"><p>Item Keluar</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="item_keluar">
<?php 
$daftar_akun4 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_item_keluar = mysqli_fetch_array($daftar_akun4))
		{
		
		echo "<option value='".$data_item_keluar['kode_daftar_akun'] ."'";

		if ($data_setting['item_keluar'] == $data_item_keluar['kode_daftar_akun']) {
			echo "selected";
		}
		echo ">".$data_item_keluar['kode_daftar_akun'] ." - ".$data_item_keluar['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>
      <tr><td  width="45%"><p>Stok Opname</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="s_opname">
<?php 
$daftar_akun5 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_opname = mysqli_fetch_array($daftar_akun5))
		{
		
		echo "<option value='".$data_opname['kode_daftar_akun'] ."'";

		if ($data_setting['pengaturan_stok'] == $data_opname['kode_daftar_akun']) {
			echo "selected";
		}
		echo ">".$data_opname['kode_daftar_akun'] ." - ".$data_opname['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>   
      <tr><td  width="45%"><p>Stok Awal</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="s_awal">
<?php 
$daftar_akun6 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_stok_awal = mysqli_fetch_array($daftar_akun6))
		{
		
		echo "<option value='".$data_stok_awal['kode_daftar_akun'] ."'";

		if ($data_setting['stok_awal'] == $data_stok_awal['kode_daftar_akun']) {
			echo "selected";
		}
		echo ">".$data_stok_awal['kode_daftar_akun'] ." - ".$data_stok_awal['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>  

  </tbody>
</table>
<hr>


<button type="submit" id="simpan" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan </button>

</form>
</div><!--end of container-->


<?php 
include 'footer.php';
 ?>