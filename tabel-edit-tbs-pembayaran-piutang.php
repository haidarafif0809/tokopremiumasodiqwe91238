<?php 

//memasukkan file session login, header, navbar, db.php
include 'sanitasi.php';
include 'db.php';


$nomor_faktur_pembayaran = $_GET['no_faktur_pembayaran'];

$query = $db->query("SELECT * FROM pembayaran_piutang");
 
 

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
//ambil bulan dari tanggal pembayaran_piutang terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM pembayaran_piutang ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari pembayaran_piutang terakhir
$no_terakhir = $db->query("SELECT no_faktur_pembayaran FROM pembayaran_piutang ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur_pembayaran'],0,-8);

/*jika bulan terakhir dari pembayaran_piutang tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/PP/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/PP/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

$perintah50 = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");
$data50 = mysqli_fetch_array($perintah50);
$no_faktur_penjualan = $data50['no_faktur_penjualan']; 

 ?>

  <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Pembayaran </th>
      <th> Nomor Faktur Penjualan</th>
      <th> Tanggal </th>
      <th> Tanggal Jatuh Tempo </th>
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
    $perintah = $db->query("SELECT * FROM tbs_pembayaran_piutang 
                WHERE no_faktur_pembayaran = '$nomor_faktur_pembayaran'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>
      

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur_penjualan'] ."' data-piutang='". $data1['kredit'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

      <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-kredit='". $data1['kredit'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."' data-no-faktur-penjualan='". $data1['no_faktur_penjualan'] ."' data-potongan='". $data1['potongan'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
      </tr>";
      }

        //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </tbody>

  </table>

      <script>
    
    $(document).ready(function(){
    $('#tableuser').DataTable();
    });
    </script>

<script type="text/javascript">
                               
//fungsi hapus data 
    $(".btn-hapus").click(function(){
    var no_faktur_penjualan = $(this).attr("data-faktur");
    var kredit = $(this).attr("data-piutang");
    var id = $(this).attr("data-id");
    $("#no_faktur_penjualan").val(no_faktur_penjualan);
    $("#jumlah_piutang").val(kredit);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
 //fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_lama = $(this).attr("data-jumlah-bayar");
        var potongan_lama = $(this).attr("data-potongan");
        var id  = $(this).attr("data-id");
        var nofaktur1  = $(this).attr("data-no-faktur-penjualan");

        var kredit  = $(this).attr("data-kredit");
        $("#bayar_lama").val(jumlah_lama);
        $("#potongan_lama").val(potongan_lama);
        $("#id_edit").val(id);
        $("#kredit_edit").val(kredit);
        $("#no_faktur_penjualan1").val(nofaktur1);

        
        
        });
       

        
        $("#alert").html(data);
        $("#tabel_baru").load('tabel-edit-tbs-pembayaran-piutang.php?no_faktur_pembayaran=<?php echo $nomor_faktur_pembayaran; ?>');
        setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
        
   
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