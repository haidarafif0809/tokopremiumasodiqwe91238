<?php 

include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


?>

<style type="text/css">
	
	.span {
    text-align: right;
}

.alignleft {
 float: left;
}
.alignright {
 float: right;
}

</style>	

<div class="container">

<h3><center><b>PERIODE TANGGAL <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?></b></center></h3>
<hr>


<div class="card card-block">
<!-- PENDAPATAN-->
<?php
$select = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Pendapatan' AND tipe_akun = 'Akun Header' AND parent= '-'");

$total_pendapatan = 0;

while($data = mysqli_fetch_array($select))
{
	echo "<h4><b>". $data['kode_grup_akun'] ." ".$data['nama_grup_akun']."</b></h4>"; 
	

$total_pendapatan_jual = 0;

$select_grup_akun = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Pendapatan' AND tipe_akun = 'Akun Header' AND parent= '$data[kode_grup_akun]' ");
while ($datagrup_akun = mysqli_fetch_array($select_grup_akun))
{
	echo "<h4 style='padding-left:25px'><b>" .$datagrup_akun['kode_grup_akun']." ".$datagrup_akun['nama_grup_akun'] ."</b></h4>";
	

$select_daftar_akun = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, SUM(j.kredit) - SUM(j.debit) AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Pendapatan' AND (da.tipe_akun = 'Pendapatan Penjualan' OR da.tipe_akun = 'Pendapatan Diluar Usaha') AND da.grup_akun= '$datagrup_akun[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal' GROUP BY j.kode_akun_jurnal");



while ($datadaftar_akun = mysqli_fetch_array($select_daftar_akun))
{

if ($datadaftar_akun['total'] < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'>" .$datadaftar_akun['kode_daftar_akun']." ".$datadaftar_akun['nama_daftar_akun'] ."</h4></td> <td> <h4> &#40;". rp($datadaftar_akun['total']). "&#41; </h4>  </td></tr>
  </tbody>
</table>
";

}
else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'>" .$datadaftar_akun['kode_daftar_akun']." ".$datadaftar_akun['nama_daftar_akun'] ."</h4></td> <td> <h4>". rp($datadaftar_akun['total']). " </h4>  </td></tr>
  </tbody>
</table>
";
}


$total_pendapatan_jual = $total_pendapatan_jual  + $datadaftar_akun['total'];

}

if ($total_pendapatan_jual < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> Total ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> &#40;". rp($total_pendapatan_jual). "&#41; </b> </h4>  </td></tr>
  </tbody>
</table>
";
}

else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> Total ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($total_pendapatan_jual)." </b> </h4>  </td></tr>
  </tbody>
</table>
";
}



$total_pendapatan = $total_pendapatan + $total_pendapatan_jual;
}

if ($total_pendapatan < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b> TOTAL ".$data['nama_grup_akun']." </b></h4></td> <td> <h4><b> &#40;".rp($total_pendapatan)."&#41; </b></h4>  </td></tr>
  </tbody>
</table>
";
}

else{
 echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b> TOTAL ".$data['nama_grup_akun']." </b></h4></td> <td> <h4><b> ".rp($total_pendapatan)." </b></h4>  </td></tr>
  </tbody>
</table>
"; 
}



} // while pendapatan



// HPP
$select = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'HPP' AND tipe_akun = 'Akun Header' AND parent= '-' ");


	$total_hpp = 0;

while($data = mysqli_fetch_array($select))
{


	echo "<h4><b>". $data['kode_grup_akun'] ." ".$data['nama_grup_akun']." </b></h4>";



$select_grup_akun = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'HPP' AND tipe_akun = 'Akun Header' AND parent= '$data[kode_grup_akun]' ");
while ($datagrup_akun = mysqli_fetch_array($select_grup_akun))
{
	$subtotal_hpp = 0;
	echo "<h4 style='padding-left:25px'><b>" .$datagrup_akun['kode_grup_akun']." ".$datagrup_akun['nama_grup_akun'] ."</b></h4>";

$select_daftar_akun = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, SUM(j.debit) - SUM(j.kredit) AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'HPP' AND da.tipe_akun = 'Harga Pokok Penjualan' AND da.grup_akun= '$datagrup_akun[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal' GROUP BY j.kode_akun_jurnal ");

while ($datadaftar_akun = mysqli_fetch_array($select_daftar_akun))
{

if ($datadaftar_akun['total'] < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'> " .$datadaftar_akun['kode_daftar_akun']." ".$datadaftar_akun['nama_daftar_akun'] ." </h4></td> <td> <h4> &#40;".rp($datadaftar_akun['total']) ."&#41; </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'> " .$datadaftar_akun['kode_daftar_akun']." ".$datadaftar_akun['nama_daftar_akun'] ." </h4></td> <td> <h4> ".rp($datadaftar_akun['total']) ." </h4>  </td></tr>
  </tbody>
</table>
";
}


$subtotal_hpp = $subtotal_hpp + $datadaftar_akun['total'];

	
}


if ($subtotal_hpp < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> Total ".$datagrup_akun['nama_grup_akun'] ." </h4></td> <td> <h4> <b> (".rp($subtotal_hpp).") </b></h4>  </td></tr>
  </tbody>
</table>
";
}

else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> Total ".$datagrup_akun['nama_grup_akun'] ." </h4></td> <td> <h4> <b> ".rp($subtotal_hpp)." </b></h4>  </td></tr>
  </tbody>
</table>
";
}



$total_hpp = $total_hpp + $subtotal_hpp;

}

if ($total_hpp < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b> Total ".$data['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> (".rp($total_hpp).") </b></h4>  </td></tr>
  </tbody>
</table>
";
}

else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b> Total ".$data['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($total_hpp)." </b></h4>  </td></tr>
  </tbody>
</table>
";
}




} // while HPP



$laba_kotor = $total_pendapatan - $total_hpp;
if ($laba_kotor < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b>LABA (RUGI) KOTOR  </h4></td> <td> <h4><b> (".rp($laba_kotor).") </b></h4>  </td></tr>
  </tbody>
</table>
";
}
else{

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b>LABA (RUGI) KOTOR  </h4></td> <td> <h4><b> ".rp($laba_kotor)." </b></h4>  </td></tr>
  </tbody>
</table>
";
}





// BIAYA
$select = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Biaya' AND tipe_akun = 'Akun Header' AND parent= '-' ");

$total_biaya = 0;
while($data = mysqli_fetch_array($select))
{
	echo "<h4><b>". $data['kode_grup_akun'] ." ".$data['nama_grup_akun'] ." </b></h4>";

	$subtotal_biaya = 0;

$select_grup_akun = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Biaya' AND tipe_akun = 'Akun Header' AND parent= '$data[kode_grup_akun]' ");
while ($datagrup_akun = mysqli_fetch_array($select_grup_akun))
{
	echo "<h4 style='padding-left:25px'><b>" .$datagrup_akun['kode_grup_akun']." ".$datagrup_akun['nama_grup_akun'] ."</b></h4>";

$select_daftar_akun = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, SUM(j.debit) - SUM(j.kredit) AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Biaya' AND da.tipe_akun = 'Beban Operasional' AND da.grup_akun= '$datagrup_akun[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal' GROUP BY j.kode_akun_jurnal  ");

while ($datadaftar_akun = mysqli_fetch_array($select_daftar_akun))
{

if ($datadaftar_akun['total'] < 0 ) {
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'>" .$datadaftar_akun['kode_daftar_akun']." ".$datadaftar_akun['nama_daftar_akun'] ." </h4></td> <td> <h4> (".rp($datadaftar_akun['total']) .")</h4>  </td></tr>
  </tbody>
</table>
";
  }
  else{
echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'>" .$datadaftar_akun['kode_daftar_akun']." ".$datadaftar_akun['nama_daftar_akun'] ." </h4></td> <td> <h4> ".rp($datadaftar_akun['total']) ."</h4>  </td></tr>
  </tbody>
</table>
";

  }


	$subtotal_biaya = $subtotal_biaya + $datadaftar_akun['total'];

}

if ($subtotal_biaya < 0) {
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b>TOTAL ".$datagrup_akun['nama_grup_akun'] ." </h4></td> <td> <h4><b>  (".rp($subtotal_biaya).")</b></h4>  </td></tr>
  </tbody>
</table>
";
}
else {
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b>TOTAL ".$datagrup_akun['nama_grup_akun'] ." </h4></td> <td> <h4><b>  ".rp($subtotal_biaya)."</b></h4>  </td></tr>
  </tbody>
</table>
";
}


	$total_biaya = $total_biaya + $subtotal_biaya;
}

if ($total_biaya < 0) {
 echo "
 <table>
  <tbody>
    <tr><td  width='100%'><h4><b>TOTAL ".$data['nama_grup_akun'] ." </h4></td> <td> <h4><b> (".rp($total_biaya) .")</b></h4>  </td></tr>
  </tbody>
</table>
";
}
else {
  echo "
 <table>
  <tbody>
    <tr><td  width='100%'><h4><b>TOTAL ".$data['nama_grup_akun'] ." </h4></td> <td> <h4><b> ".rp($total_biaya) ."</b></h4>  </td></tr>
  </tbody>
</table>
";
}



} //while BIAYA


$laba_rugi = $laba_kotor - $total_biaya;

if ($laba_rugi < 0) {
  echo "
 <table>
  <tbody>
    <tr style='background-color: #c62828; color:white'><td width='100%'><h4><b>LABA RUGI </b></h4></td> <td> <h4><b> (".rp($laba_rugi) .")</b></h4>  </td></tr>
  </tbody>
</table>
";
}
else {
  echo "
 <table>
  <tbody>
    <tr style='background-color: #c62828; color:white'><td width='100%'><h4><b>LABA RUGI </b></h4></td> <td> <h4><b> ".rp($laba_rugi) ."</b></h4>  </td></tr>
  </tbody>
</table>
";
}



?>

</div> <!-- / DIV CARD_BLOCK-->



</div> <!-- / container -->
