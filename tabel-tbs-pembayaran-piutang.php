<?php session_start();


//memasukkan file session login, header, navbar, db.php
include 'sanitasi.php';
include 'db.php';

$query = $db->query("SELECT * FROM pembayaran_piutang");
 
 
$session_id = session_id();

$perintah50 = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE session_id = '$session_id'");
$data50 = mysqli_fetch_array($perintah50);
$no_faktur_penjualan = $data50['no_faktur_penjualan']; 

 ?>

  <table id="tableuser" class="table table-bordered">
    <thead>
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
                WHERE session_id = '$session_id'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr>
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
// untuk memunculkan data tabel 
    $(document).ready(function(){
    $('.table').DataTable();    
    
    });
 

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
        $("#tabel_baru").load('tabel-tbs-pembayaran-piutang.php');
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
