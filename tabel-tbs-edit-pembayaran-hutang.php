<?php 

 include 'db.php';
 include 'sanitasi.php';

$nomor_faktur_pembayaran = $_GET['no_faktur_pembayaran'];

$query = $db->query("SELECT * FROM pembayaran_hutang");
 
 
//ambil 2 angka terakhir dari tahun sekarang 
$tahun = $db->query("SELECT YEAR(NOW()) as tahun");
$v_tahun = mysqli_fetch_array($tahun);
 $tahun_terakhir = substr($v_tahun['tahun'], 2);
//ambil bulan sekarang
$bulan = $db->query("SELECT MONTH(NOW()) as bulan");
$v_bulan = mysqli_fetch_array($bulan);
$v_bulan['bulan'];


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($v_bulan['bulan']);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$v_bulan['bulan'];
 }
 else
 {
  $data_bulan_terakhir = $v_bulan['bulan'];

 }
//ambil bulan dari tanggal pembayaran_hutang terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM pembayaran_hutang ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari pembayaran_hutang terakhir
$no_terakhir = $db->query("SELECT no_faktur_pembayaran FROM pembayaran_hutang ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur_pembayaran'],0,-8);

/*jika bulan terakhir dari pembayaran_hutang tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/PH/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/PH/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

$perintah50 = $db->query("SELECT * FROM tbs_pembayaran_hutang 
                WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");
$data50 = mysqli_fetch_array($perintah50);
$no_faktur_pembelian = $data50['no_faktur_pembelian']; 

 ?>
  <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Pembayaran </th>
      <th> Nomor Faktur Pembelian </th>
      <th> Tanggal </th>
      <th> Tanggal JT </th>
      <th> Kredit </th>
      <th> Potongan </th>
      <th> Total</th>
      <th> Jumlah Bayar </th>
      
      <th> Hapus </th>
      <th> Edit </th>
      
    </thead>
    
    <tbody>
    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT * FROM tbs_pembayaran_hutang 
                WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['no_faktur_pembelian'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>
      

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-no-faktur-pembelian='". $data1['no_faktur_pembelian'] ."' data-hutang='". $data1['kredit'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

      <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."' data-no-faktur-pembelian='". $data1['no_faktur_pembelian'] ."' data-potongan='". $data1['potongan'] ."' data-kredit='". $data1['kredit'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
      </tr>";
      }

        //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </tbody>

  </table>

  <script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>

<script type="text/javascript">
  
    //fungsi hapus data 
    $(".btn-hapus").click(function(){
    var no_faktur_pembelian = $(this).attr("data-no-faktur-pembelian");
    var kredit = $(this).attr("data-hutang");
    var id = $(this).attr("data-id");
    $("#no_faktur_pembelian").val(no_faktur_pembelian);
    $("#jumlah_hutang").val(kredit);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
    
        //fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_lama = $(this).attr("data-jumlah-bayar");
        var id  = $(this).attr("data-id");
        var nofaktur1  = $(this).attr("data-no-faktur-pembelian");
        var kredit  = $(this).attr("data-kredit");
        var potongan_lama = $(this).attr("data-potongan");
        $("#potongan_lama").val(potongan_lama);
        $("#kredit_edit").val(kredit);
        $("#bayar_lama").val(jumlah_lama);
        $("#id_edit").val(id);
        $("#no_faktur_pembelian1").val(nofaktur1);

        
        
        });
        
//end function edit data

              $('form').submit(function(){
              
              return false;
              });

              function tutupalert() {
    $("#alert").html("")
    }

    function tutupmodal() {
    $("#modal_edit").modal("hide")
    }

    </script>