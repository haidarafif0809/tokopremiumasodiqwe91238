<?php  include 'session_login.php';

 include 'db.php';
 include 'sanitasi.php';

 $no_faktur = $_GET['no_faktur'];
 
 $query = $db->query("SELECT * FROM kas_masuk ");
 
 

 ?>
 <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nomor Faktur </th>
      <th> Keterangan </th>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Jumlah </th>      
      <th> Tanggal </th>
      <th> Jam </th>
      <th> User </th>    
      <th> Hapus </th>
      
    </thead>
    
    <tbody>
    <?php

    //menampilkan semua data yang ada pada tabel tbs kas masuk dalam DB
     $perintah = $db->query("SELECT km.id, km.session_id, km.no_faktur, km.keterangan, km.dari_akun, km.ke_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM tbs_kas_masuk km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun WHERE no_faktur = '$no_faktur'");

      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {
        $perintah0 = $db->query("SELECT km.id, km.session_id, km.no_faktur, km.keterangan, km.ke_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM tbs_kas_masuk km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun WHERE no_faktur = '$no_faktur'");
        $data0 = mysqli_fetch_array($perintah0);

        //menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
     <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['keterangan'] ."</td>
      <td data-dari-akun ='".$data1['nama_daftar_akun']."'>". $data1['nama_daftar_akun'] ."</td>
      <td>". $data0['nama_daftar_akun'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". rp($data1['jumlah']) ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input-jumlah' data-id='".$data1['id']."' autofocus='' data-jumlah='".$data1['jumlah']."'> </td> 


      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['jam'] ."</td>
      <td>". $data1['user'] ."</td>

      <td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur'] ."' data-jumlah='". $data1['jumlah'] ."' data-ke='". $data1['ke_akun'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
      
      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>

    <script type="text/javascript">
    
    $(document).ready(function(){
    $('#tableuser').DataTable();
    });
    
    </script>

  
                              <script type="text/javascript">
                               
                                  $(document).ready(function(){
                                  
                                  //fungsi hapus data 
                                  $(".btn-hapus-tbs").click(function(){
                                  var id = $(this).attr("data-id");
                                  var ke_akun = $(this).attr("data-ke");
                                  var jumlah = $(this).attr("data-jumlah");
                                  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
                                 

                                  
                                  if (total == '') 
                                  {
                                  total = 0;
                                  }
                                  else if(jumlah == '')
                                  {
                                  jumlah = 0;
                                  };
                                  var subtotal = parseInt(total,10) - parseInt(jumlah,10);
                                  
                                  
                                  if (subtotal == 0) 
                                  {
                                  $("#ke_akun").attr("disabled", false);
                                  }



                                  $("#jumlahtotal").val(tandaPemisahTitik(subtotal))
                                  
                                  $.post("hapus_edit_tbs_kas_masuk.php",{id:id},function(data){

                                   if (data != '') {
                                  $(".tr-id-"+id+"").remove();
                                  }

                                  });
                                  
                                  
                                  });
                                  
                                  
                                  //end fungsi hapus data


              $('form').submit(function(){
              
              return false;
              });
        });


    function tutupalert() {
    $("#alert").html("")
    }

    function tutupmodal() {
    $("#modal_edit").modal("hide")
    }
                                  
                                  </script>

                                  <script type="text/javascript">

                                    
                                    $(".edit-jumlah").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    var input_jumlah = $("#text-jumlah-"+id+"").text();
                                    
                                    $("#text-jumlah-"+id+"").hide();
                                    
                                    $("#input-jumlah-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input-jumlah").blur(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    var input_jumlah = $(this).val();
                                    
                                    var jumlah_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-jumlah")))));
                                    var total_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahtotal").val()))));
                                    
                                    
                                    
                                    if (total_lama == '') 
                                    {
                                    total_lama = 0;
                                    }
                                    
                                    var subtotal = parseInt(total_lama,10) - parseInt(jumlah_lama,10) + parseInt(input_jumlah,10);
                                    
                                    
                                    
                                    $.post("update_edit_tbs_kas_masuk.php",{id:id, input_jumlah:input_jumlah,jenis_edit:"jumlah"},function(data){
                                    

                                    $("#input-jumlah-"+id).attr("data-jumlah", input_jumlah);
                                    $("#btn-hapus-"+id).attr("data-jumlah", input_jumlah);
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(tandaPemisahTitik(input_jumlah));
                                    $("#jumlahtotal").val(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");           
                                    
                                    });
                                    
                                    
                                    
                                    });

                                    
                                    </script>