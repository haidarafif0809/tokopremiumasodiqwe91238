<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


$daritgl = stringdoang($_GET['daritgl']);
$sampaitgl = stringdoang($_GET['sampaitgl']);
$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);


// awal Select untuk hitung Saldo Awal
$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND waktu <= '$daritgl' ");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND waktu <= '$daritgl' ");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);
    


 ?>

<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='80' height='80`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $data1['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->



    <center> <h4> <b> KARTU STOK </b> </h4> </center>
    <center> <h4> <b> PERIODE <?php echo tanggal($daritgl); ?> Sampai <?php echo tanggal($sampaitgl); ?></b> </h4> </center><br>



  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">Nama Barang</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $nama_barang; ?></font> </tr>
      <tr><td  width="25%"><font class="satu">Kode Barang</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $kode_barang; ?> </font></td></tr>

            

  </tbody>
</table>


    </div>

   <!---- <div class="col-sm-3">
       <table>
        <tbody>

             <tr><td width="50%"><font class="satu"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data_inner['tanggal']);?></font> </td></tr> 
             <tr><td width="50%"><font class="satu"> Tanggal JT</td> <td> :&nbsp;&nbsp;</td> <td>-</font> </td></tr> 
             <tr><td width="50%"><font class="satu"> Kasir</td> <td> :&nbsp;&nbsp;</td> <td><?php echo $_SESSION['nama']; ?></font></td></tr> 
             <tr><td width="50%"><font class="satu"> Status </td> <td> :&nbsp;&nbsp;</td> <td><?php echo $data_inner['status']; ?></font></td></tr> 

            </tbody>
      </table>

    </div> ----end col-sm-2-->
   </div> <!--end row-->  




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
<br><br>
<table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> No Faktur</th>
            <th class="table1" style="width: 50%"> Tipe </th>
            <th class="table1" style="width: 5%"> Tanggal</th>
            <th class="table1" style="width: 5%"> Jumlah Masuk</th>
            <th class="table1" style="width: 15%"> Jumlah Keluar</th>
            <th class="table1" style="width: 5%"> Saldo</th>

    
        
            
        </thead>
        <tbody>
     <tr style="color:red;">
<td></td>
<td><b style='color:red ;'>Saldo Awal</b></td>
<td></td>
<td></td>
<td></td>
<td><b style='color:red ;'><?php echo $total_saldo ?></b></td>
</tr>

<?php 

$select = $db->query("SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp,waktu FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND tanggal >= '$daritgl' AND tanggal <= '$sampaitgl' UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp,waktu FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND tanggal >= '$daritgl' AND tanggal <= '$sampaitgl' ORDER BY waktu ASC ");


while($data = mysqli_fetch_array($select))
  {

if ($data['jenis_hpp'] == '1')
{
  $masuk = $data['jumlah_kuantitas'];
  $total_saldo = ($total_saldo + $masuk);

      echo "<tr>
      <td>". $data['no_faktur'] ."</td>
      <td>". $data['jenis_transaksi'] ."</td>
      <td>". $data['tanggal'] ."</td>
      <td>". rp($masuk) ."</td>
        <td>0</td>
        <td>". rp($total_saldo) ."</td>
      ";
}
else
{

$keluar = $data['jumlah_kuantitas'];
$total_saldo = $total_saldo - $keluar;

      echo "<tr>
      <td>". $data['no_faktur'] ."</td>
      <td>". $data['jenis_transaksi'] ."</td>
      <td>". $data['tanggal'] ."</td>
      <td>0</td>
        <td>".rp($keluar)."</td>
        <td>". rp($total_saldo) ."</td>
      ";
}

    echo "</tr>";


} // and while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>

    </table>


<br>

<!--        <div class="col-sm-6">
            
            <i><b><font class="satu">Terbilang :</font></b> <?php echo kekata($data_inner['total']); ?> </i> <br>
            <!DOCTYPE html>

<style>
div.dotted {border-style: dotted;}
div.dashed {border-style: dashed;}
div.solid {border-style: solid;}
div.double {border-style: double;}
div.groove {border-style: groove;}
div.ridge {border-style: ridge;}
div.inset {border-style: inset;}
div.outset {border-style: outset;}
div.none {border-style: none;}
div.hidden {border-style: hidden;}
div.mix {border-style: dotted dashed solid double;}
</style>



</div>
 <div class="col-sm-3">

 <table>
  <tbody>

      <tr><td width="50%"><font class="satu">Sub Total</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($t_subtotal); ?> </font></tr>
      <tr><td width="50%"><font class="satu">Diskon</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['potongan']); ?></font> </tr>
      <tr><td width="50%"><font class="satu">Biaya Admin</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['biaya_admin']); ?></font> </tr>
      <tr><td  width="50%"><font class="satu">Tax</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['tax']); ?> </font></td></tr>
      <tr><td  width="50%"><font class="satu">Total Akhir</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['total']); ?></font>  </td></tr>

  </tbody>
</table>

        </div>

        <div class="col-sm-3">

 <table>
  <tbody>

      <tr><td  width="40%"><font class="satu">Bayar</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['tunai']); ?></font> </td></tr>
      <tr><td  width="40%"><font class="satu">Kembali</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['sisa']); ?></font> </td></tr>
      <tr><td  width="40%"><font class="satu">Jenis Bayar</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_inner['nama_daftar_akun']; ?></font> </td></tr>   

  </tbody>
</table>

        </div>

-->
    <div class="col-sm-9">
    
    <!--<font class="satu"><b>Nama <?php echo $data200['kata_ubah']; ?> <br><br><br> <font class="satu"><?php echo $data_inner['nama_pelanggan']; ?></font> </b></font>-->
    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-3">
    
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>

    </div> <!--/ col-sm-6-->




</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>