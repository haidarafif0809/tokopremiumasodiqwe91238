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
			<li class='nav-item'><a class='nav-link active' href='setting_akun_data_pembelian.php'> Pembelian </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_penjualan.php'> Penjualan </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_hutang_piutang.php'> Hutang Piutang </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_lain.php'> Lain-lain </a></li>


         </ul>
         <br><br>

<form class="form" action="proses_simpan_setting_akun_data_pembelian.php" method="post">
<div class="col-sm-6">


<h3><b>Data Akun Pembelian</b></h3><br><br>


 <table>
  <tbody>

      <tr><td  width="45%"><p>Potongan Pembelian</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="pot_beli">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pot_pembelian = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$data_pot_pembelian['kode_daftar_akun'] ."'";

		if ($data_setting['potongan'] == $data_pot_pembelian['kode_daftar_akun']) {
			echo "selected";
		}
		echo ">".$data_pot_pembelian['kode_daftar_akun'] ." - ".$data_pot_pembelian['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>
      <tr><td  width="45%"><p>Pajak Pembelian</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="pajak_beli">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pajak = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_pajak['kode_daftar_akun'] ."'";

		if ($data_setting['pajak'] == $data_pajak['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pajak['kode_daftar_akun'] ." - ".$data_pajak['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>

<!--
      <tr><td  width="45%"><p>Biaya Lain- lain</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="biaya_lain">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_biaya_lain = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_biaya_lain['kode_daftar_akun'] ."'";

		if ($data_setting['potongan'] == $data_biaya_lain['kode_daftar_akun']) {
			echo "selected";
		}
		echo ">".$data_biaya_lain['kode_daftar_akun'] ." - ".$data_biaya_lain['nama_daftar_akun'] ."</option>";
		
		} 
 ?>
 </select>

      </td></tr>
-->

      <tr><td  width="45%"><p>Pembayaran Tunai / DP</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="bayar_tunai">

<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($bayar_dp = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$bayar_dp['kode_daftar_akun'] ."'";

		if ($data_setting['pembayaran_tunai'] == $bayar_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$bayar_dp['kode_daftar_akun'] ." - ".$bayar_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr> 
      
      <tr><td  width="45%"><p>Pembayaran Kredit</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="bayar_kredit">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pembayaran_hutang = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_pembayaran_hutang['kode_daftar_akun'] ."'";

		if ($data_setting['hutang'] == $data_pembayaran_hutang['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pembayaran_hutang['kode_daftar_akun'] ." - ".$data_pembayaran_hutang['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>

  </tbody>
</table>
<br>

<h3><b>Data Akun Retur Pembelian</b></h3><br><br>

 <table>
  <tbody>

      <tr><td  width="45%"><p>Potongan Retur Pembelian</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="pot_retur_beli">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pot_beli = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$data_pot_beli['kode_daftar_akun'] ."'";

		if ($data_setting['potongan_retur_beli'] == $data_pot_beli['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pot_beli['kode_daftar_akun'] ." - ".$data_pot_beli['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>
      <tr><td  width="45%"><p>Pajak Retur Pembelian</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="pajak_retur_beli">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pajak_beli = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_pajak_beli['kode_daftar_akun'] ."'";

		if ($data_setting['pajak_retur_beli'] == $data_pajak_beli['kode_daftar_akun']) {
			echo "selected";
		}
		echo ">".$data_pajak_beli['kode_daftar_akun'] ." - ".$data_pajak_beli['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>


<!--
      <tr><td  width="45%"><p>Biaya Lain- lain</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="biaya_retur_beli">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_biaya_lain = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_biaya_lain['kode_daftar_akun'] ."'";

		if ($data_setting['potongan'] == $data_biaya_lain['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_biaya_lain['kode_daftar_akun'] ." - ".$data_biaya_lain['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>
-->

      <tr><td  width="45%"><p>Pembayaran Retur Tunai / DP</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="bayar_retur_tunai">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($bayar_dp = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$bayar_dp['kode_daftar_akun'] ."'";

		if ($data_setting['tunai_retur_beli'] == $bayar_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$bayar_dp['kode_daftar_akun'] ." - ".$bayar_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr> 
      <tr><td  width="45%"><p>Pembayaran Retur Kredit</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="bayar_retur_kredit">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_hutang = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_hutang['kode_daftar_akun'] ."'";

		if ($data_setting['kredit_retur_beli'] == $data_hutang['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_hutang['kode_daftar_akun'] ." - ".$data_hutang['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>

  </tbody>
</table>


</div> <!-- /col-sm-6 (1) -->


<div class="col-sm-6">
<!--
<h3><b>Data Akun Pesanan Pembelian / PO</b></h3><br><br>

 <table>
  <tbody>


      <tr><td  width="45%"><p>Kas Uang Muka Pesanan</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="uang_muka_pesanan">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($bayar_dp = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$bayar_dp['kode_daftar_akun'] ."'";

		if ($data_setting['pembayaran_tunai'] == $bayar_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$bayar_dp['kode_daftar_akun'] ." - ".$bayar_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>



  </tbody>
</table>
-->	
</div> <!-- /col-sm-6 (2) -->


<div class="col-sm-12">
<hr>

<button type="submit" id="simpan" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan </button>
</div>

</form>
</div><!--end of container-->


<?php 
include 'footer.php';
 ?>