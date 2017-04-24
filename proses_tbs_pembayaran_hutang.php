<?php 
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = $_POST['session_id'];

    $no_faktur_pembelian = stringdoang($_POST['no_faktur_pembelian']);
    


    
    $cek2 = $db->query("SELECT * FROM tbs_pembayaran_hutang WHERE no_faktur_pembelian = '$no_faktur_pembelian'");
    $data= mysqli_num_rows($cek2); 

if ($data > 0){

    $query1 = $db->prepare("UPDATE tbs_pembayaran_hutang SET jumlah_bayar = jumlah_bayar + ?, potongan = potongan + ?, total = ? WHERE no_faktur_pembelian = ?");

      $query1->bind_param("iiis",
          $jumlah_bayar, $potongan, $total_kredit, $no_faktur_pembelian);

    $no_faktur_pembelian = stringdoang($_POST['no_faktur_pembelian']);
    $potongan = angkadoang($_POST['potongan']);
    $total_kredit = angkadoang($_POST['total']);
    $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);

    $query1->execute();

         if (!$query1) {
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
         }
         else 
         {
         
         }

}

else
{

        $perintah = $db->prepare("INSERT INTO tbs_pembayaran_hutang (session_id,no_faktur_pembelian,tanggal,tanggal_jt,kredit,potongan,total,jumlah_bayar) 
        VALUES (?,?,now(),?,?,?,?,?)");
         
         
         $perintah->bind_param("sssiiii",
         $session_id, $no_faktur_pembelian, $tanggal_jt, $kredit, $potongan, $total_kredit, $jumlah_bayar);
         
           $session_id = $_POST['session_id'];
         $no_faktur_pembelian = stringdoang($_POST['no_faktur_pembelian']);
         $tanggal_jt = angkadoang($_POST['tanggal_jt']);
         $kredit = angkadoang($_POST['kredit']);
         $total_kredit = angkadoang($_POST['total']);            
         $jumlah_bayar = angkadoang($_POST['jumlah_bayar']);
         $potongan = angkadoang($_POST['potongan']);

         $perintah->execute();
         
         if (!$perintah) {
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
         }
         else 
         {
         
         }

}
    

    ?>

    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT * FROM tbs_pembayaran_hutang WHERE session_id = '$session_id' ORDER BY id DESC LIMIT 1");

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

      //Untuk Memutuskan Koneksi Ke Database
      mysqli_close($db);


    ?>

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