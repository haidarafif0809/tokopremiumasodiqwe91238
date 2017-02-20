<?php session_start();


include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM pembayaran_hutang");




 ?>

<table id="tableuser" class="table table-bordered">
    <thead>
      <th> Detail </th>

<?php
include 'db.php';

$pilih_akses_pembayaran_hutang_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Pembayaran Hutang'");
$pembayaran_hutang_edit = mysqli_num_rows($pilih_akses_pembayaran_hutang_edit);

    if ($pembayaran_hutang_edit > 0) {
      echo "<th> Edit </th>";
}
?>

<?php
include 'db.php';

$pilih_akses_pembayaran_hutang_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Pembayaran Hutang'");
$pembayaran_hutang_hapus = mysqli_num_rows($pilih_akses_pembayaran_hutang_hapus);

    if ($pembayaran_hutang_hapus > 0) {
      echo "<th> Hapus </th>";
}
?>
      
      
      <th> Cetak </th>
      <th> Nomor Faktur </th>
      <th> Tanggal </th>
      <th> Jam </th>
      <th> Nama Suplier </th>
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
        $perintah5 = $db->query("SELECT * FROM pembelian");
        $data5 = mysqli_fetch_array($perintah5);
        //menampilkan data
      echo "<tr>

      <td> <button class=' btn btn-info detail' no_faktur_pembayaran='". $data1['no_faktur_pembayaran'] ."'> <span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

include 'db.php';

$pilih_akses_pembayaran_hutang_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Pembayaran Hutang'");
$pembayaran_hutang_edit = mysqli_num_rows($pilih_akses_pembayaran_hutang_edit);

    if ($pembayaran_hutang_edit > 0) {

    echo "<td> <a href='proses_edit_pembayaran_hutang.php?no_faktur_pembayaran=". $data1['no_faktur_pembayaran']."&no_faktur=". $data5['no_faktur']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";

  }

include 'db.php';

$pilih_akses_pembayaran_hutang_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Pembayaran Hutang'");
$pembayaran_hutang_hapus = mysqli_num_rows($pilih_akses_pembayaran_hutang_hapus);

    if ($pembayaran_hutang_hapus > 0) { 

      echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-suplier='". $data1['nama_suplier'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
      } 

      echo "<td> <a href='cetak_lap_pembayaran_hutang.php?no_faktur_pembayaran=".$data1['no_faktur_pembayaran']."' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Hutang </a> </td>
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
    
    // untk menampilkan datatable atau filter seacrh
    $(document).ready(function(){
    $('#tableuser').DataTable();
    });
    
    $(".detail").click(function(){
    var no_faktur_pembayaran = $(this).attr('no_faktur_pembayaran');
    
    
    $("#modal_detail").modal('show');
    
    $.post('proses_detail_pembayaran_hutang.php',{no_faktur_pembayaran:no_faktur_pembayaran},function(info) {
    
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

    </script>