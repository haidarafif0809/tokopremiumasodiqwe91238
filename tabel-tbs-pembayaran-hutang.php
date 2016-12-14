<?php session_start();


 include 'db.php';
 include 'sanitasi.php';


 $session_id = session_id();

$query = $db->query("SELECT * FROM pembayaran_hutang");
 



 ?>

  <table id="table" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Pembelian </th>
      <th> Tanggal </th>
      <th> Tanggal JT </th>
      <th> Kredit </th>
      <th> Potongan </th>
      <th> Total </th>
      <th> Jumlah Bayar </th>
      
      <th> Hapus </th>
      <th> Edit </th>
      
    </thead>
    
    <tbody id="tbody">
    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT * FROM tbs_pembayaran_hutang 
                WHERE session_id = '$session_id'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur_pembelian'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>
      

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-no-faktur-pembelian='". $data1['no_faktur_pembelian'] ."' data-hutang='". $data1['kredit'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

      <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."' data-no-faktur-pembelian='". $data1['no_faktur_pembelian'] ."' data-potongan='". $data1['potongan'] ."' data-kredit='". $data1['kredit'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
      </tr>";
      }
    ?>
    </tbody>

  </table>

  <script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $('.table').dataTable();
});

</script>

    <script type="text/javascript">
    
    //fungsi hapus data 
    $(".btn-hapus").click(function(){
    var no_faktur_pembelian = $(this).attr("data-no-faktur-pembelian");
    var kredit = $(this).attr("data-hutang");
    var jumlah_bayar = $(this).attr("data-jumlah-bayar");
    var id = $(this).attr("data-id");
    var kredit = $(this).attr("data-hutang");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#totalbayar").val()))));

   if (total == '') 
      
      {
        total = 0;
      }
    
    else if(jumlah_bayar   == '')
      {
        jumlah_bayar   = 0;
      };
       
       var subtotal = parseInt(total,10) - parseInt(jumlah_bayar  ,10);
                                  
                                  
    if (subtotal == 0) 
      {
        subtotal = 0;
      }

      $("#totalbayar").val(tandaPemisahTitik(subtotal));

    
    $.post("hapus_tbs_pembayaran_hutang.php",{id:id, no_faktur_pembelian:no_faktur_pembelian, kredit:kredit},function(data){


    $(".tr-id-"+id).remove();    

    
    });
    
    
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