<?php 

include 'sanitasi.php';
include 'db.php';

$no_faktur_retur = stringdoang($_POST['no_faktur_retur']);

?>

<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Kode Pelanggan </th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah Jual </th>

      <th> Satuan </th>
      <th> Harga Barang  </th>
      <th> Subtotal </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa Barang </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php


      $kode_pelanggan = $_POST['kode_pelanggan'];

// menampilkan data dari 3 tabel
$perintah = $db->query("SELECT b.id AS id_produk ,dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan AS satuan_jual, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, dp.sisa, p.kode_pelanggan, pl.nama_pelanggan, dp.asal_satuan, b.satuan AS satuan_barang , ss.nama AS satuan_real , st.nama AS satuan_asli FROM detail_penjualan dp LEFT JOIN penjualan p ON dp.no_faktur = p.no_faktur LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan LEFT JOIN barang b ON dp.kode_barang = b.kode_barang LEFT JOIN satuan ss ON dp.satuan = ss.id LEFT JOIN satuan st ON b.satuan = st.id WHERE p.kode_pelanggan = '$kode_pelanggan' GROUP BY dp.no_faktur, dp.kode_barang");

 


while ($data = mysqli_fetch_array($perintah))
{


//harga tabel penjualan
$harga_penjualan = $data['harga'];
//no faktur jual
$no_faktur_jual = $data['no_faktur'];
// kode barang
$kode_barang = $data['kode_barang'];

// sisa barang hpp keluar
$select_sisa = $db->query("SELECT SUM(sisa_barang) AS sisa_barang FROM hpp_keluar WHERE no_faktur = '$data[no_faktur]'");
$data1 = mysqli_fetch_array($select_sisa);
$sisa_barang_hpp = $data1['sisa_barang'];

// jumlah retur tbs retur
$select_jumlah_tbs = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_tbs, satuan FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur' AND no_faktur_penjualan = '$no_faktur_jual' ");
$data2 = mysqli_fetch_array($select_jumlah_tbs);
$jumlah_retur_tbs = $data2['jumlah_retur_tbs'];


// jumlah retur detail retur
$select_jumlah_detail = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_detail FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur_retur' AND no_faktur_penjualan = '$no_faktur_jual' ");
$data3 = mysqli_fetch_array($select_jumlah_detail);
$jumlah_retur_detail = $data3['jumlah_retur_detail'];

// konversi dari satuan konversi
$select_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$data[satuan_jual]'");
$data4 = mysqli_fetch_array($select_konversi);
$jumlah_konversi = $data4['konversi'];



// jika jumlah retur tbs != 0
if ($jumlah_retur_tbs != '') {
 
        //jumlah tbs sebenarnya
        if ($data2['satuan'] == $data['satuan_barang']) {

          $jumlah_tbs = $jumlah_retur_tbs;
        }
        else{
          $jumlah_tbs = $jumlah_retur_tbs * $jumlah_konversi;
        } 

} // END if ($jumlah_retur_tbs != '')
else
{
  $jumlah_tbs = 0;
}

//sisa barang sebenarnya
$sisa_barang_sebenarnya = ($sisa_barang_hpp + $jumlah_retur_detail) - $jumlah_tbs;
// data konfersi kosong run under
if ($jumlah_konversi == '')
      {
  
          $penentu_satuan = 1;
      }
      else
      {
      $penentu_satuan = $sisa_barang_sebenarnya % $jumlah_konversi;
      }
//sisa barang yang tampil pada modal
if ($data['satuan_barang'] == $data['satuan_jual']) {
        $sisa_barang_tampil = $sisa_barang_sebenarnya;
        $satuan_tampil = $data['satuan_jual'];
        $harga_tampil = $data['harga'];
        $jumlah_tampil = $data['jumlah_barang'];

}

else{
        
        if ($penentu_satuan == 0) {
           $harga_tampil = $data['harga'] * $jumlah_konversi;
           $sisa_barang_tampil = $sisa_barang_sebenarnya / $jumlah_konversi;
           $satuan_tampil = $data['satuan_jual']; 
           $jumlah_tampil = $data['jumlah_barang'] /  $jumlah_konversi; 
        }//end if ($penentu_satuan == 0)
        else
        {
          $sisa_barang_tampil = $sisa_barang_sebenarnya;
          $satuan_tampil = $data['satuan_barang'];
          $harga_tampil = $data['harga'];
          $jumlah_tampil = $data['jumlah_barang'];

        }

}// end else

        // menampilkan data
      echo "<tr class='pilih' data-kode='". $data['kode_barang'] ."' nama-barang='". $data['nama_barang'] ."' satuan='". $satuan_tampil ."' no_faktur='". $no_faktur_jual ."' harga='". $harga_tampil ."' jumlah-barang='". $data['jumlah_barang'] ."' sisa='". $sisa_barang_tampil ."' id_produk='". $data['id_produk'] ."'  asal_satuan ='".$data['satuan_barang']."' harga_pcs = ".$data['harga']." >

      <td>". $data['no_faktur'] ."</td>
      <td>". $data['kode_pelanggan'] ." </td>
      <td>". $data['kode_barang'] ."</td>
      <td>". $data['nama_barang'] ."</td>
      <td>".  $jumlah_tampil."</td>
      <td>". $data['satuan_real'] ."</td>
      <td>". rp($harga_tampil) ."</td>
      <td>". rp($data['subtotal']) ."</td>
      <td>". rp($data['potongan']) ."</td>
      <td>". rp($data['tax']) ."</td>";

// untuk bedakan satuan dalam sisa barang
if ($penentu_satuan == 0)
{
       echo "<td>". $sisa_barang_tampil ." ". $data['satuan_real']."</td>";

}
else
{
     echo "<td>". $sisa_barang_tampil ." ". $data['satuan_asli']."</td>
      </tr>";
} // END untuk bedakan satuan dalam sisa barang


} //end while
    ?>
    </tbody> <!--tag penutup tbody-->

  </table> <!-- tag penutup table-->
  </div>
  <script type="text/javascript">
  $(function () {
  $("#tableuser").dataTable();
  });
</script>