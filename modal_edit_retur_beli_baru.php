<?php 

include 'sanitasi.php';
include 'db.php';
?>
<div class="table-responsive">

<table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah Beli </th>
      <th> Satuan </th>
      <th> Harga Barang  </th>
      <th> Subtotal </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa Barang </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php

    $suplier = $_POST['suplier'];
    
    
    $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);

    // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
    $perintah = $db->query("SELECT b.id AS id_produk, b.satuan AS satuan_dasar, dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan AS satuan_beli, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, dp.sisa, sp.id, dp.asal_satuan, dp.satuan, b.satuan AS satuan_barang , ss.nama AS satuan_real , st.nama AS satuan_asli FROM detail_pembelian dp LEFT JOIN pembelian p ON dp.no_faktur = p.no_faktur LEFT JOIN suplier sp ON p.suplier = sp.id LEFT JOIN barang b ON dp.kode_barang = b.kode_barang LEFT JOIN satuan ss ON dp.satuan = ss.id LEFT JOIN satuan st ON b.satuan = st.id  WHERE p.suplier = '$suplier' GROUP BY dp.no_faktur, dp.kode_barang");

    //menyimpan data sementara yang ada pada $perintah
      while ($data = mysqli_fetch_array($perintah))
      {

//harga tabel penjualan
$harga_beli = $data['harga'];
//no faktur jual
$no_faktur_beli = $data['no_faktur'];
// kode barang
$kode_barang = $data['kode_barang'];

// sisa barang hpp keluar
$select_sisa = $db->query("SELECT SUM(sisa) AS sisa FROM hpp_masuk WHERE no_faktur = '$data[no_faktur]' AND kode_barang = '$kode_barang' ");
$data1 = mysqli_fetch_array($select_sisa);
$sisa_barang_hpp = $data1['sisa'];

// jumlah retur tbs retur
$select_jumlah_tbs = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_tbs, satuan FROM tbs_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' AND no_faktur_pembelian = '$no_faktur_beli' AND kode_barang = '$kode_barang'  ");
$data2 = mysqli_fetch_array($select_jumlah_tbs);
$jumlah_retur_tbs = $data2['jumlah_retur_tbs'];


// jumlah retur detail retur
$select_jumlah_detail = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_detail FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur' AND no_faktur_pembelian = '$no_faktur_beli' AND kode_barang = '$kode_barang'  ");
$data3 = mysqli_fetch_array($select_jumlah_detail);
$jumlah_retur_detail = $data3['jumlah_retur_detail'];

// konversi dari satuan konversi
$select_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$data[satuan_beli]'");
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
          $jumlah_tampil = $data['jumlah_barang'];
      }
      else
      {
          $penentu_satuan = $sisa_barang_sebenarnya % $jumlah_konversi;
          $jumlah_tampil = $data['jumlah_barang'] /  $jumlah_konversi; 
      }
//sisa barang yang tampil pada modal
if ($data['satuan_barang'] == $data['satuan_beli']) {
        $sisa_barang_tampil = $sisa_barang_sebenarnya;
        $satuan_tampil = $data['satuan_beli'];
        $harga_tampil = $data['harga'];


}

else{
        
        if ($penentu_satuan == 0) {
           $harga_tampil = $data['harga'] * $jumlah_konversi;
           $sisa_barang_tampil = $sisa_barang_sebenarnya / $jumlah_konversi;
           $satuan_tampil = $data['satuan_beli'];

        }//end if ($penentu_satuan == 0)
        else
        {
          $sisa_barang_tampil = $sisa_barang_sebenarnya;
          $satuan_tampil = $data['satuan_barang'];
          $harga_tampil = $data['harga'];

        }

}// end else


        // menampilkan data
      echo "<tr class='pilih' data-kode='". $data['kode_barang'] ."' nama-barang='". $data['nama_barang'] ."' satuan='". $satuan_tampil ."' no_faktur='". $no_faktur_beli ."' harga='". $harga_tampil ."' jumlah-barang='". $data['jumlah_barang'] ."' sisa='". $sisa_barang_tampil ."' id_produk='". $data['id_produk'] ."' asal_satuan = '".$data['satuan_barang']."' harga_pcs = '".$data['harga']."' satuan_pcs = '".$data['satuan_dasar']."' satuan_beli = '".$data['satuan']."'>";

    
      echo "<td>". $data['no_faktur'] ."</td>
      <td>". $data['kode_barang'] ."</td>
      <td>". $data['nama_barang'] ."</td>
      <td>". $jumlah_tampil ."</td>
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



       }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </tbody> <!--tag penutup tbody-->

  </table> <!-- tag penutup table-->
  </div>
  <script type="text/javascript">
  $(function () {
  $("#tableuser").dataTable();
  });
</script>