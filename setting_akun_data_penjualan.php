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
			<li class='nav-item'><a class='nav-link active' href='setting_akun_data_penjualan.php'> Penjualan </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_hutang_piutang.php'> Hutang Piutang </a></li>
			<li class='nav-item'><a class='nav-link' href='setting_akun_data_lain.php'> Lain-lain </a></li>


         </ul>
         <br><br>

<form class="form" action="proses_simpan_setting_akun_data_penjualan.php" method="post">
	


<div class="col-sm-6">
<h3><b>Data Akun Penjualan</b></h3><br><br>

 <table>
  <tbody>

      <tr><td  width="45%"><p>Potongan Penjualan</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="pot_jual">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pot_jual = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$data_pot_jual['kode_daftar_akun'] ."'";

		if ($data_setting['potongan_jual'] == $data_pot_jual['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pot_jual['kode_daftar_akun'] ." - ".$data_pot_jual['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>
      <tr><td  width="45%"><p>Pajak Penjualan</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="pajak_jual">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pajak_jual = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_pajak_jual['kode_daftar_akun'] ."'";

		if ($data_setting['pajak_jual'] == $data_pajak_jual['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pajak_jual['kode_daftar_akun'] ." - ".$data_pajak_jual['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>
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
		while($data_piutang = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_piutang['kode_daftar_akun'] ."'";

		if ($data_setting['pembayaran_kredit'] == $data_piutang['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_piutang['kode_daftar_akun'] ." - ".$data_piutang['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>
      <tr><td  width="45%"><p>Komisi Sales</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="komisi_sales">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_komisi = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_komisi['kode_daftar_akun'] ."'";

		if ($data_setting['komisi_sales'] == $data_komisi['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_komisi['kode_daftar_akun'] ." - ".$data_komisi['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>

  </tbody>
</table>
<br>

<h3><b>Data Akun Retur Penjualan</b></h3><br><br>

 <table>
  <tbody>

      <tr><td  width="45%"><p>Potongan Retur Penjualan</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="pot_retur_jual">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pot_jual = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$data_pot_jual['kode_daftar_akun'] ."'";

		if ($data_setting['potongan_retur_jual'] == $data_pot_jual['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pot_jual['kode_daftar_akun'] ." - ".$data_pot_jual['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>
      <tr><td  width="45%"><p>Pajak Retur Penjualan</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="pajak_retur_jual">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pajak_jual = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_pajak_jual['kode_daftar_akun'] ."'";

		if ($data_setting['pajak_retur_jual'] == $data_pajak_jual['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pajak_jual['kode_daftar_akun'] ." - ".$data_pajak_jual['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>

      <tr><td  width="45%"><p>Pembayaran Retur Tunai / DP</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="bayar_tunai_retur">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($bayar_dp = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$bayar_dp['kode_daftar_akun'] ."'";

		if ($data_setting['tunai_retur_jual'] == $bayar_dp['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$bayar_dp['kode_daftar_akun'] ." - ".$bayar_dp['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr> 
      <tr><td  width="45%"><p>Pembayaran Retur Kredit</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="bayar_kredit_retur">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_piutang = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_piutang['kode_daftar_akun'] ."'";

		if ($data_setting['kredit_retur_jual'] == $data_piutang['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_piutang['kode_daftar_akun'] ." - ".$data_piutang['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>
      <tr><td  width="45%"><p>Komisi Sales Retur</p></td> <td width="7%"> :&nbsp;</td>
      <td> 

<select class="form-control" name="bayar_komisi_retur">
<?php 
$daftar_akun2 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_komisi = mysqli_fetch_array($daftar_akun2))
		{
		
		echo "<option value='".$data_komisi['kode_daftar_akun'] ."'";

		if ($data_setting['komisi_sales_retur_jual'] == $data_komisi['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_komisi['kode_daftar_akun'] ." - ".$data_komisi['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

      </td></tr>

  </tbody>
</table>


</div> <!-- /col-sm-6 (1) -->

<!--
<div class="col-sm-6">
<h3><b>Data Akun Kasir</b></h3><br><br>

 <table>
  <tbody>

      <tr><td  width="45%"><p>Potongan Penjualan</p></td> <td width="7%"> :&nbsp;</td> 
      <td> 

<select class="form-control" name="pot_kasir_jual">
<?php 
$daftar_akun0 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pot_jual = mysqli_fetch_array($daftar_akun0))
		{
		
		echo "<option value='".$data_pot_jual['kode_daftar_akun'] ."'";

		if ($data_setting['potongan_jual'] == $data_pot_jual['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pot_jual['kode_daftar_akun'] ." - ".$data_pot_jual['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select>

	  </td></tr>
      <tr><td  width="45%"><p>Pajak Penjualan</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="pajak_kasir_jual">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pajak_jual = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_pajak_jual['kode_daftar_akun'] ."'";

		if ($data_setting['pajak_jual'] == $data_pajak_jual['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pajak_jual['kode_daftar_akun'] ." - ".$data_pajak_jual['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>


      <tr><td  width="45%"><p>Biaya Lain - lain</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="biaya_lain_kasir">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_pot_jual = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_pot_jual['kode_daftar_akun'] ."'";

		if ($data_setting['potongan_jual'] == $data_pot_jual['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_pot_jual['kode_daftar_akun'] ." - ".$data_pot_jual['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>

      <tr><td  width="45%"><p>Pembayaran Tunai</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="bayar_kasir_tunai">
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

      <tr><td  width="45%"><p>Pembayaran Kredit</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="bayar_kredit_kasir">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_piutang = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_piutang['kode_daftar_akun'] ."'";

		if ($data_setting['pembayaran_kredit'] == $data_piutang['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_piutang['kode_daftar_akun'] ." - ".$data_piutang['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>
      <tr><td  width="45%"><p>Komisi Sales</p></td> <td width="7%"> :&nbsp;</td> 
      <td>

<select class="form-control" name="komisi_sales_kasir">
<?php 
$daftar_akun1 = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
		while($data_komisi = mysqli_fetch_array($daftar_akun1))
		{
		
		echo "<option value='".$data_komisi['kode_daftar_akun'] ."'";

		if ($data_setting['komisi_sales'] == $data_komisi['kode_daftar_akun']) {
			echo "selected";
		}

		echo ">".$data_komisi['kode_daftar_akun'] ." - ".$data_komisi['nama_daftar_akun'] ."</option>";
		} 
 ?>
 </select> 

      </td></tr>



  </tbody>
</table>	
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