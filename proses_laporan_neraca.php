<?php 

include 'sanitasi.php';
include 'db.php';

$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$tahun_sekarang = date('Y');
$dari_tanggal = $tahun_sekarang."-01-01";


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

.panel-body{
background-color: #fafafa;
border-collapse: collapse;
}


</style>	

<div class="container"></div>

<h3><center><b>PERIODE TANGGAL <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?></b></center></h3>
<hr>


<div class="card card-block">

<!-- AKTIVA-->
<?php
$select = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Aktiva' AND tipe_akun = 'Akun Header' AND parent= '-' " );

$total_akhir_aktiva = 0;

while($data = mysqli_fetch_array($select))
{
  //AKTIVA

	echo "<h4><b>". $data['kode_grup_akun'] ." ".$data['nama_grup_akun']."</b></h4>"; 
	echo "<hr>";
// AKTIVA LANCAR, PERSEDIAAN , KEWAJIBAN

$select_grup_akun = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Aktiva' AND tipe_akun = 'Akun Header' AND parent= '$data[kode_grup_akun]' ");


while ($datagrup_akun = mysqli_fetch_array($select_grup_akun))
{
echo "<h4 style='padding-left:25px'><b>" .$datagrup_akun['kode_grup_akun']." ".$datagrup_akun['nama_grup_akun'] ."</b></h4>";

$select_daftar_akun_inner = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, da.grup_akun, SUM(j.debit) - SUM(j.kredit)  AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Aktiva' AND da.grup_akun= '$datagrup_akun[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal'  GROUP BY j.kode_akun_jurnal");
$datadaftar_akun_inner = mysqli_fetch_array($select_daftar_akun_inner);


if ($datadaftar_akun_inner['grup_akun'] != $datagrup_akun['kode_grup_akun']) {

 // SUB DARI AKTIVA LANCAR
$total_aktiva_lancar = 0;

$select_grup_akun_sub = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Aktiva' AND tipe_akun = 'Akun Header' AND parent= '$datagrup_akun[kode_grup_akun]' ");
while ($datagrup_akun_sub = mysqli_fetch_array($select_grup_akun_sub))
{
echo "<h4 style='padding-left:50px'><b>" .$datagrup_akun_sub['kode_grup_akun']." ".$datagrup_akun_sub['nama_grup_akun'] ."</b></h4>";

 // ISI / SUB DARI AKTIVA >> 
$kas_bank = 0;
$select_daftar_akun_inner = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, SUM(j.debit) - SUM(j.kredit)  AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Aktiva' AND da.grup_akun= '$datagrup_akun_sub[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal'  GROUP BY j.kode_akun_jurnal");


while ($datadaftar_akun_inner = mysqli_fetch_array($select_daftar_akun_inner))
{

$total_akhir_aktiva = $total_akhir_aktiva + $datadaftar_akun_inner['total'];

if ($datadaftar_akun_inner['total'] < 0) {
echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:75px'>" .$datadaftar_akun_inner['kode_daftar_akun']." ".$datadaftar_akun_inner['nama_daftar_akun'] ."</h4></td> <td> <h4>(". rp($datadaftar_akun_inner['total']). ") </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:75px'>" .$datadaftar_akun_inner['kode_daftar_akun']." ".$datadaftar_akun_inner['nama_daftar_akun'] ."</h4></td> <td> <h4>". rp($datadaftar_akun_inner['total']). " </h4>  </td></tr>
  </tbody>
</table>
";
}

$kas_bank = $kas_bank + $datadaftar_akun_inner['total'];

}

if ($kas_bank < 0) {
//TOTAL KAS & BANK
echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'><b> TOTAL ".$datagrup_akun_sub['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> (".rp($kas_bank).") </b> </h4>  </td></tr>
  </tbody>
</table>
";
}
else{

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'><b> TOTAL ".$datagrup_akun_sub['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($kas_bank)." </b> </h4>  </td></tr>
  </tbody>
</table>
";

}

$total_aktiva_lancar = $total_aktiva_lancar + $kas_bank;
} // END OF SUB AKTIVA LANCAR >> KAS & BANK

if ($total_aktiva_lancar < 0) {
    echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> TOTAL ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> (".rp($total_aktiva_lancar).") </b> </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
    echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> TOTAL ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($total_aktiva_lancar)." </b> </h4>  </td></tr>
  </tbody>
</table>
";
}

$total_aktiva = $total_aktiva_lancar;
  
} // END IF

else{

$total_persediaan_aktiva_tetap = 0;
$select_daftar_akun_inner = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, da.grup_akun, SUM(j.debit) - SUM(j.kredit)  AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Aktiva' AND da.grup_akun= '$datagrup_akun[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal'  GROUP BY j.kode_akun_jurnal");



while ($datadaftar_akun_inner = mysqli_fetch_array($select_daftar_akun_inner))
{

$total_akhir_aktiva = $total_akhir_aktiva + $datadaftar_akun_inner['total'];

if ($datadaftar_akun_inner['total'] < 0) {
echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:75px'>" .$datadaftar_akun_inner['kode_daftar_akun']." ".$datadaftar_akun_inner['nama_daftar_akun'] ."</h4></td> <td> <h4>(". rp($datadaftar_akun_inner['total']). ") </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:75px'>" .$datadaftar_akun_inner['kode_daftar_akun']." ".$datadaftar_akun_inner['nama_daftar_akun'] ."</h4></td> <td> <h4>". rp($datadaftar_akun_inner['total']). " </h4> </td></tr>
  </tbody>
</table>
";
}

$total_persediaan_aktiva_tetap = $total_persediaan_aktiva_tetap + $datadaftar_akun_inner['total'];


}
$total_aktiva = $total_aktiva + $total_persediaan_aktiva_tetap;

if ($total_persediaan_aktiva_tetap < 0) {
    echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> TOTAL ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> (".rp($total_persediaan_aktiva_tetap).") </b> </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
    echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> TOTAL ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($total_persediaan_aktiva_tetap)." </b> </h4>  </td></tr>
  </tbody>
</table>
";
}


}



} // END OF AKTIVA LANCAR< PERSEDIAAN KEWAJIBAN


if ($total_akhir_aktiva < 0) {

echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b> TOTAL ".$data['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> (".rp($total_akhir_aktiva).") </b> </h4>  </td></tr>
  </tbody>
</table>
";
}
else{

echo "
 <table>
  <tbody>
    <tr  style='background-color: #c62828; color:white'><td width='100%'><h4><b> TOTAL ".$data['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($total_akhir_aktiva)." </b> </h4>  </td></tr>
  </tbody>
</table>
";
}

} // END OF AKTIVA



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


echo " <hr>";


// KEWAJIBAN
$select = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Kewajiban' AND tipe_akun = 'Akun Header' AND parent= '-' " );

$total_akhir_kewajiban = 0;

while($data = mysqli_fetch_array($select))
{
  //AKTIVA


  echo "<h4><b>". $data['kode_grup_akun'] ." ".$data['nama_grup_akun']."</b></h4>"; 
 echo "<hr>";
// AKTIVA LANCAR, PERSEDIAAN , KEWAJIBAN

$select_grup_akun = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Kewajiban' AND tipe_akun = 'Akun Header' AND parent= '$data[kode_grup_akun]' ");


while ($datagrup_akun = mysqli_fetch_array($select_grup_akun))
{
echo "<h4 style='padding-left:25px'><b>" .$datagrup_akun['kode_grup_akun']." ".$datagrup_akun['nama_grup_akun'] ."</b></h4>";

$select_daftar_akun_inner = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, da.grup_akun, SUM(j.kredit) - SUM(j.debit)  AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Kewajiban' AND da.grup_akun= '$datagrup_akun[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal'  GROUP BY j.kode_akun_jurnal");
$datadaftar_akun_inner = mysqli_fetch_array($select_daftar_akun_inner);


if ($datadaftar_akun_inner['grup_akun'] != $datagrup_akun['kode_grup_akun']) {

 // SUB DARI AKTIVA LANCAR
$total_aktiva_lancar = 0;

$select_grup_akun_sub = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Kewajiban' AND tipe_akun = 'Akun Header' AND parent= '$datagrup_akun[kode_grup_akun]' ");
while ($datagrup_akun_sub = mysqli_fetch_array($select_grup_akun_sub))
{
echo "<h4 style='padding-left:50px'><b>" .$datagrup_akun_sub['kode_grup_akun']." ".$datagrup_akun_sub['nama_grup_akun'] ."</b></h4>";

 // ISI / SUB DARI AKTIVA >> 
$kas_bank = 0;
$select_daftar_akun_inner = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, SUM(j.kredit) - SUM(j.debit)  AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Kewajiban' AND da.grup_akun= '$datagrup_akun_sub[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal'  GROUP BY j.kode_akun_jurnal");


while ($datadaftar_akun_inner = mysqli_fetch_array($select_daftar_akun_inner))
{

  $total_akhir_kewajiban = $total_akhir_kewajiban + $datadaftar_akun_inner['total'];

if ($datadaftar_akun_inner['total'] < 0) {
echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:75px'>" .$datadaftar_akun_inner['kode_daftar_akun']." ".$datadaftar_akun_inner['nama_daftar_akun'] ."</h4></td> <td> <h4>(". rp($datadaftar_akun_inner['total']). ") </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:75px'>" .$datadaftar_akun_inner['kode_daftar_akun']." ".$datadaftar_akun_inner['nama_daftar_akun'] ."</h4></td> <td> <h4>". rp($datadaftar_akun_inner['total']). " </h4>  </td></tr>
  </tbody>
</table>
";
}

$kas_bank = $kas_bank + $datadaftar_akun_inner['total'];

}

if ($kas_bank < 0) {
//TOTAL KAS & BANK
echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'><b> TOTAL ".$datagrup_akun_sub['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> (".rp($kas_bank).") </b> </h4>  </td></tr>
  </tbody>
</table>
";
}
else{

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'><b> TOTAL ".$datagrup_akun_sub['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($kas_bank)." </b> </h4>  </td></tr>
  </tbody>
</table>
";

}

$total_aktiva_lancar = $total_aktiva_lancar + $kas_bank;

} // END OF SUB AKTIVA LANCAR >> KAS & BANK



if ($total_aktiva_lancar < 0) {
    echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> TOTAL ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> (".rp($total_aktiva_lancar).") </b> </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
    echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> TOTAL ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($total_aktiva_lancar)." </b> </h4>  </td></tr>
  </tbody>
</table>
";
}

$total_aktiva = $total_aktiva_lancar;
  
} // END IF

else{

$total_persediaan_aktiva_tetap = 0;

$select_daftar_akun_inner = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, da.grup_akun, SUM(j.kredit) - SUM(j.debit)  AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Kewajiban' AND da.grup_akun= '$datagrup_akun[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal'  GROUP BY j.kode_akun_jurnal");



while ($datadaftar_akun_inner = mysqli_fetch_array($select_daftar_akun_inner))
{

  $total_akhir_kewajiban = $total_akhir_kewajiban + $datadaftar_akun_inner['total'];

if ($datadaftar_akun_inner['total'] < 0) {
echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:75px'>" .$datadaftar_akun_inner['kode_daftar_akun']." ".$datadaftar_akun_inner['nama_daftar_akun'] ."</h4></td> <td> <h4>(". rp($datadaftar_akun_inner['total']). ") </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:75px'>" .$datadaftar_akun_inner['kode_daftar_akun']." ".$datadaftar_akun_inner['nama_daftar_akun'] ."</h4></td> <td> <h4>". rp($datadaftar_akun_inner['total']). " </h4>  </td></tr>
  </tbody>
</table>
";
}

$total_persediaan_aktiva_tetap = $total_persediaan_aktiva_tetap + $datadaftar_akun_inner['total'];


}

$total_aktiva = $total_aktiva + $total_persediaan_aktiva_tetap;

if ($total_persediaan_aktiva_tetap < 0) {
    echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> TOTAL ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> (".rp($total_persediaan_aktiva_tetap).") </b> </h4>  </td></tr>
  </tbody>
</table>
";
}
else{
    echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:25px'><b> TOTAL ".$datagrup_akun['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($total_persediaan_aktiva_tetap)." </b> </h4>  </td></tr>
  </tbody>
</table>
";
}


}



} // END OF AKTIVA LANCAR< PERSEDIAAN KEWAJIBAN


echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b> TOTAL ".$data['nama_grup_akun'] ." </b></h4></td> <td> <h4><b> ".rp($total_akhir_kewajiban)." </b> </h4>  </td></tr>
  </tbody>
</table>
";

} // END OF KEWAJIBAN

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// MODAL
echo "<hr>";
$select = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun WHERE kategori_akun = 'Modal' AND tipe_akun = 'Akun Header' AND parent= '-'");


while($data = mysqli_fetch_array($select))
{
  echo "<h4><b>". $data['kode_grup_akun'] ." ".$data['nama_grup_akun']."</b></h4>"; 
  echo "<hr>";

$select_daftar_akun = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, SUM(j.kredit) - SUM(j.debit) AS total FROM daftar_akun da INNER JOIN jurnal_trans j  ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE da.kategori_akun = 'Modal' AND da.grup_akun= '$data[kode_grup_akun]' AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal' GROUP BY j.kode_akun_jurnal");



$total_modal = 0;
$sum_total_laba_brjalan = $db->query("SELECT da.kode_daftar_akun, da.nama_daftar_akun, SUM(j.kredit) - SUM(j.debit) AS total FROM daftar_akun da INNER JOIN jurnal_trans j ON da.kode_daftar_akun = j.kode_akun_jurnal WHERE ( da.kategori_akun = 'Biaya' AND da.tipe_akun = 'Beban Operasional') OR ( da.kategori_akun = 'Pendapatan' AND da.tipe_akun = 'Pendapatan Penjualan') OR(da.kategori_akun = 'HPP' AND da.tipe_akun = 'Harga Pokok Penjualan') OR ( da.kategori_akun = 'Pendapatan' AND da.tipe_akun = 'Pendapatan Diluar Usaha') AND date(j.waktu_jurnal) >= '$dari_tanggal' AND date(j.waktu_jurnal) <= '$sampai_tanggal'");
$data_laba = mysqli_fetch_array($sum_total_laba_brjalan);
$total_laba_tahun_berjalan = $data_laba['total'];

while ($datadaftar_akun = mysqli_fetch_array($select_daftar_akun))
{


  $select_nama = $db->query("SELECT s.laba_tahun_berjalan, da.nama_daftar_akun FROM setting_akun s INNER JOIN daftar_akun da ON s.laba_tahun_berjalan = da.kode_daftar_akun");
  $data_sett = mysqli_fetch_array($select_nama);


if ($datadaftar_akun['total'] < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'>" .$datadaftar_akun['kode_daftar_akun']." ".$datadaftar_akun['nama_daftar_akun'] ."</h4></td> <td> <h4> &#40;". rp($datadaftar_akun['total']). "&#41; </h4>  </td></tr>
  </tbody>
</table>
";

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'>" .$data_sett['laba_tahun_berjalan'] ." - >" .$data_sett['laba_tahun_berjalan'] ."</h4></td> <td> <h4> (".rp($total_laba_tahun_berjalan).") </h4>  </td></tr>
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

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'>" .$data_sett['laba_tahun_berjalan'] ." " .$data_sett['nama_daftar_akun'] ."</h4></td> <td> <h4> ".rp($total_laba_tahun_berjalan)." </h4>  </td></tr>
  </tbody>
</table>
";

}

$total_modal = $total_modal + $datadaftar_akun['total'];

}

if ( $total_modal < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'><b>TOTAL ".$datadaftar_akun['nama_daftar_akun'] ." </b></h4></td> <td> <h4> <b> (".rp($total_modal).") </b> </h4>  </td></tr>
  </tbody>
</table>
";

}
else{
  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4><b>TOTAL ".$data['nama_grup_akun'] ."</b></h4></td> <td> <h4><b> ".rp($total_modal)." </b></h4>  </td></tr>
  </tbody>
</table>
";
}

$totol_kewajiban_modal = $total_akhir_kewajiban + $total_modal + $total_laba_tahun_berjalan;

} // END MODAL

if ( $totol_kewajiban_modal < 0) {

  echo "
 <table>
  <tbody>
    <tr><td width='100%'><h4 style='padding-left:50px'><b>TOTAL KEWAJIBAN dan MODAL </b></h4></td> <td> <h4> <b> (".rp($totol_kewajiban_modal).") </b> </h4>  </td></tr>
  </tbody>
</table>
";

}
else{
  echo "
 <table>
  <tbody>
    <tr style='background-color: #c62828; color:white'><td width='100%'><h4><b>TOTAL KEWAJIBAN dan MODAL</b></h4></td> <td> <h4><b> ".rp($totol_kewajiban_modal)." </b></h4>  </td></tr>
  </tbody>
</table>
";
}


?>


</div>
</div>
