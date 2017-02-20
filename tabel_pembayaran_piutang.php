<?php session_start();
 
include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM pembayaran_piutang");




 ?>


<table id="tableuser" class="table table-bordered">
    <thead>
      <th> Detail </th>

<?php
include 'db.php';

$pilih_akses_pembayaran_piutang_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Pembayaran Piutang'");
$pembayaran_piutang_edit = mysqli_num_rows($pilih_akses_pembayaran_piutang_edit);

    if ($pembayaran_piutang_edit > 0) {
      echo "<th> Edit </th>";
}
?>

<?php
include 'db.php';

$pilih_akses_pembayaran_piutang_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Pembayaran Piutang'");
$pembayaran_piutang_hapus = mysqli_num_rows($pilih_akses_pembayaran_piutang_hapus);

    if ($pembayaran_piutang_hapus > 0) {
      echo "<th> Hapus </th>";
}
?>

      <th> Cetak </th>
      <th> Nomor Faktur </th>
      <th> Tanggal </th>
      <th> Jam </th>
      <th> Kode Pelanggan </th>
      <th> Keterangan </th>
      <th> Total </th>
      <th> User Buat </th>
      <th> User Edit </th>
      <th> Tanggal Edit </th>
      <th> Dari Kas </th>
      

      
      
    </thead>
    
    <tbody>
    <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        $perintah5 = $db->query("SELECT * FROM detail_pembayaran_piutang");
        $data5 = mysqli_fetch_array($perintah5);

        //menampilkan data
      echo "<tr>
      <td> <button class='btn btn-info detail' no_faktur_pembayaran='". $data1['no_faktur_pembayaran'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>"; 


include 'db.php';

$pilih_akses_pembayaran_piutang_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Pembayaran Piutang'");
$pembayaran_piutang_edit = mysqli_num_rows($pilih_akses_pembayaran_piutang_edit);

    if ($pembayaran_piutang_edit > 0) {
      echo "<td> <a href='proses_edit_pembayaran_piutang.php?no_faktur_pembayaran=". $data1['no_faktur_pembayaran']."&no_faktur_penjualan=". $data5['no_faktur_penjualan']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";
    }

include 'db.php';

$pilih_akses_pembayaran_piutang_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Pembayaran Piutang'");
$pembayaran_piutang_hapus = mysqli_num_rows($pilih_akses_pembayaran_piutang_hapus);

    if ($pembayaran_piutang_hapus > 0) {    

      echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-suplier='". $data1['nama_suplier'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

    echo "<td> <a href='cetak_lap_pembayaran_piutang.php?no_faktur_pembayaran=".$data1['no_faktur_pembayaran']."'  class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Piutang </a> </td>

      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['nama_suplier'] ."</td>
      <td>". $data1['keterangan'] ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". $data1['user_buat'] ."</td>
      <td>". $data1['user_edit'] ."</td>
      <td>". $data1['tanggal_edit'] ."</td>
      <td>". $data1['dari_kas'] ."</td>



      
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

    $(".detail").click(function(){
    var no_faktur_pembayaran = $(this).attr('no_faktur_pembayaran');
    
    
    $("#modal_detail").modal('show');
    
    $.post('detail_pembayaran_piutang.php',{no_faktur_pembayaran:no_faktur_pembayaran},function(info) {
    
    $("#modal-detail").html(info);
    
    
    });
    
    });

</script>

 <script type="text/javascript">
      
//fungsi hapus data 
    $(".btn-hapus").click(function(){
    var suplier = $(this).attr("data-suplier");
    var id = $(this).attr("data-id");
    $("#suplier").val(suplier);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });


    $("#btn_jadi_hapus").click(function(){
    
    var id = $("#id_hapus").val();
    $.post("hapus_data_pembayaran_piutang.php",{id:id},function(data){
    if (data != "") {
    $("#tabel-baru").load('tabel_pembayaran_piutang.php');
    $("#modal_hapus").modal('hide');
    
    }

    
    });
    
    
    });




    </script>
