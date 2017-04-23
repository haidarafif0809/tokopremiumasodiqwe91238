<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);
$bulan = stringdoang($_GET['bulan']);
$tahun = stringdoang($_GET['tahun']);
$moon = stringdoang($_GET['moon']);

// awal Select untuk hitung Saldo Awal
$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND CONCAT(tanggal,'',jam) <= '$bulan' AND CONCAT(tanggal,'',jam) <= '$tahun'");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND CONCAT(tanggal,'',jam) <= '$bulan' AND CONCAT(tanggal,'',jam) <= '$tahun'");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;

    $query1 = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
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



    <center> <h4> <b> DATA STOK </b> </h4> </center>
    <center> <h4> <b> PERIODE <?php echo $moon; ?>   <?php echo $tahun; ?></b> </h4> </center><hr>



  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">Nama Barang</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $nama_barang; ?></font> </tr>
      <tr><td  width="25%"><font class="satu">Kode Barang</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $kode_barang; ?> </font></td></tr>

            

  </tbody>
</table>


    </div>

   <!--
   <div class="col-sm-3">
       <table>
        <tbody>

             <tr><td width="50%"><font class="satu"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data_inner['tanggal']);?></font> </td></tr> 
             <tr><td width="50%"><font class="satu"> Tanggal JT</td> <td> :&nbsp;&nbsp;</td> <td>-</font> </td></tr> 
             <tr><td width="50%"><font class="satu"> Kasir</td> <td> :&nbsp;&nbsp;</td> <td><?php echo $_SESSION['nama']; ?></font></td></tr> 
             <tr><td width="50%"><font class="satu"> Status </td> <td> :&nbsp;&nbsp;</td> <td><?php echo $data_inner['status']; ?></font></td></tr> 

            </tbody>
      </table>

    </div>  end col-sm-2-->
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
.rata-kanan {
  text-align: right
}


</style>
<br><br>
<table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> No Faktur</th>
            <th class="table1" style="width: 50%"> Jenis Transaksi </th>
            <th class="table1" style="width: 10%"> Harga</th>
            <th class="table1" style="width: 10%"> Tanggal</th>
            <th class="table1" style="width: 5%"> Jumlah Masuk</th>
            <th class="table1" style="width: 5%"> Jumlah Keluar</th>
            <th class="table1" style="width: 5%"> Saldo</th>

    
        
            
        </thead>
        <tbody>
     <tr style="color:red;">
<td></td>
<td><b style='color:red ;'>Saldo Awal</b></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td class='rata-kanan'><b style='color:red;'><?php echo rp($total_saldo) ?></b></td>
</tr>

<?php 

$select = $db->query("SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp, tanggal, jam FROM hpp_masuk 
      WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' 
      UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp, tanggal, jam FROM hpp_keluar 
      WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' 
      ORDER BY CONCAT(tanggal,' ',jam) ");


while($data = mysqli_fetch_array($select))
  {

if ($data['jenis_hpp'] == '1')
{
  $masuk = $data['jumlah_kuantitas'];
  $total_saldo = ($total_saldo + $masuk);

      echo "<tr>
      <td>". $data['no_faktur'] ."</td>";
      
//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)
      
      if ($data['jenis_transaksi'] == 'Pembelian') {

        $ambil_suplier = $db->query("SELECT p.suplier, s.nama FROM pembelian p INNER JOIN  suplier s ON p.suplier = s.id WHERE p.no_faktur = '$data[no_faktur]' ");
        $data_suplier = mysqli_fetch_array($ambil_suplier);
        $nama_suplier = $data_suplier['nama'];

        echo "<td> ".$data['jenis_transaksi']." (".$nama_suplier.") </td>";
        
      }
      else if ($data['jenis_transaksi'] == 'Retur Penjualan') {
        $ambil_pelanggan = $db->query("SELECT rp.kode_pelanggan, p.nama_pelanggan FROM retur_penjualan rp INNER JOIN  pelanggan p ON rp.kode_pelanggan = p.kode_pelanggan WHERE rp.no_faktur_retur = '$data[no_faktur]' ");
        $data_pelanggan = mysqli_fetch_array($ambil_pelanggan);
        $nama_pelanggan = $data_pelanggan['nama_pelanggan'];
        echo "<td> ".$data['jenis_transaksi']." (".$nama_pelanggan.") </td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Opname') {
        echo "<td> ".$data['jenis_transaksi']." ( + )</td>";
      }
      else{
       echo "<td>".$data['jenis_transaksi']."</td>";
      }

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)
//
//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)
      if ($data['jenis_transaksi'] == 'Pembelian') {

        $ambil_harga_beli = $db->query("SELECT harga AS harga_beli FROM detail_pembelian  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_beli = mysqli_fetch_array($ambil_harga_beli);
        $harga_beli = $data_beli['harga_beli'];

        echo "<td class='rata-kanan'>".rp($harga_beli)."</td>";
        
      }
      else if ($data['jenis_transaksi'] == 'Retur Penjualan') {


        $ambil_harga_retur_jual = $db->query("SELECT harga AS harga_retur_jual FROM detail_retur_penjualan  WHERE no_faktur_retur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_retur_jual = mysqli_fetch_array($ambil_harga_retur_jual);
        $harga_retur_jual = $data_retur_jual['harga_retur_jual'];

        echo "<td class='rata-kanan'>".rp($harga_retur_jual)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Item Masuk') {


        $ambil_harga_masuk = $db->query("SELECT harga AS harga_masuk FROM detail_item_masuk  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_masuk = mysqli_fetch_array($ambil_harga_masuk);
        $harga_masuk = $data_masuk['harga_masuk'];

        echo "<td class='rata-kanan'>".rp($harga_masuk)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Opname') {


        $ambil_harga_opname = $db->query("SELECT harga AS harga_opname FROM detail_stok_opname  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_opname = mysqli_fetch_array($ambil_harga_opname);
        $harga_opname = $data_opname['harga_opname'];

        echo "<td class='rata-kanan'>".rp($harga_opname)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Awal') {


        $ambil_harga_awal = $db->query("SELECT harga AS harga_awal FROM stok_awal  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_awal = mysqli_fetch_array($ambil_harga_awal);
        $harga_awal = $data_awal['harga_awal'];

        echo "<td class='rata-kanan'>".rp($harga_awal);
      }

//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)

  echo "<td>". tanggal($data['tanggal'])."</td>
      <td class='rata-kanan'>". rp($masuk) ."</td>
      <td class='rata-kanan'>0</td>
      <td class='rata-kanan'>". rp($total_saldo) ."</td>
      ";
}
else
{

$keluar = $data['jumlah_kuantitas'];
$total_saldo = $total_saldo - $keluar;

      echo "<tr>
      <td>". $data['no_faktur'] ."</td>";

      //LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)

      if ($data['jenis_transaksi'] == 'Retur Pembelian') {

        $ambil_suplier = $db->query("SELECT p.nama_suplier, s.nama FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE p.no_faktur_retur = '$data[no_faktur]' ");
        $data_suplier = mysqli_fetch_array($ambil_suplier);
        $nama_suplier = $data_suplier['nama'];

        echo "<td> ".$data['jenis_transaksi']." (".$nama_suplier.") </td>";
        
      }
      else if ($data['jenis_transaksi'] == 'Penjualan') {
        $ambil_pelanggan = $db->query("SELECT p.kode_pelanggan, pl.nama_pelanggan FROM penjualan p INNER JOIN  pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE p.no_faktur = '$data[no_faktur]' ");
        $data_pelanggan = mysqli_fetch_array($ambil_pelanggan);
        $nama_pelanggan = $data_pelanggan['nama_pelanggan'];
        echo "<td> ".$data['jenis_transaksi']." (".$nama_pelanggan.") </td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Opname') {
        echo "<td> ".$data['jenis_transaksi']." ( - ) </td>";
      }
      else{
        echo "<td>".$data['jenis_transaksi']."</td>";
      }

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)
//
//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)

      if ($data['jenis_transaksi'] == 'Penjualan') {

        $ambil_harga_jual = $db->query("SELECT harga AS harga_jual FROM detail_penjualan  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_jual = mysqli_fetch_array($ambil_harga_jual);
        $harga_jual = $data_jual['harga_jual'];

        echo "<td class='rata-kanan'>".rp($harga_jual)."</td>";
        
      }
      else if ($data['jenis_transaksi'] == 'Retur Pembelian') {


        $ambil_harga_retur_beli = $db->query("SELECT harga AS harga_retur_beli FROM detail_retur_pembelian  WHERE no_faktur_retur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_retur_beli = mysqli_fetch_array($ambil_harga_retur_beli);
        $harga_retur_beli = $data_retur_beli['harga_retur_beli'];

        echo "<td class='rata-kanan'>".rp($harga_retur_beli)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Item Keluar') {


        $ambil_harga_keluar = $db->query("SELECT harga AS harga_keluar FROM detail_item_keluar  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_keluar = mysqli_fetch_array($ambil_harga_keluar);
        $harga_keluar = $data_keluar['harga_keluar'];

        echo "<td class='rata-kanan'>".rp($harga_keluar)."</td>";
      }
      else if ($data['jenis_transaksi'] == 'Stok Opname') {


        $ambil_harga_opname = $db->query("SELECT harga AS harga_opname FROM detail_stok_opname  WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
        $data_opname = mysqli_fetch_array($ambil_harga_opname);
        $harga_opname = $data_opname['harga_opname'];

        echo "<td class='rata-kanan'>".rp($harga_opname)."</td>";
      }

//LOGIKA UNTUK MENAMPILKAN HARGA DARI MASING" TRANSAKSI (JUMLAH PRODUK BERKURANG)


      echo "<td>". tanggal($data['tanggal'])."</td>
      <td class='rata-kanan'>0</td>
      <td class='rata-kanan'>".rp($keluar)."</td>
      <td class='rata-kanan'>". rp($total_saldo) ."</td>
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