<?php 

include 'db.php';
include 'sanitasi.php';
    
$id_produk = angkadoang($_GET['id_produk']);
 $satuan_konversi = $db->query("SELECT sk.id, sk.id_satuan, sk.id_produk, sk.konversi, sk.harga_pokok, sk.harga_jual_konversi, s.nama FROM satuan_konversi sk INNER JOIN satuan s ON sk.id_satuan = s.id WHERE sk.id_produk = '$id_produk'");


    ?>

<div class="responsive">
<table id="tableuser" class="table table-bordered">
    <thead>
      <th> Satuan </th>
      <th> Konversi </th>
      <th> Harga Pokok </th>
      <!--
      <th> Harga Jual Konversi </th>
      -->
      <th> Hapus </th>
    </thead>
    
    <tbody id="tbody">
    <?php

    
    while ($data = mysqli_fetch_array($satuan_konversi))
    {

      $query2 = $db->query("SELECT id, nama FROM satuan");

      echo "<tr class='tr-id-".$data['id']."'>

      <td class='edit-satuan' data-id='".$data['id']."'><span id='text-satuan-".$data['id']."'>". $data['nama'] ."</span>
      <select style='display:none' id='select-satuan-".$data['id']."' value='".$data['id']."' class='select-satuan' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="'. $data['id_satuan'] .'">'. $data['nama'] .'</option>';
      
      
      
      while($data2 = mysqli_fetch_array($query2))
      {
      
      echo '<option value="'. $data2['id'] .'">'. $data2['nama'] .'</option>';
      }
      
      
      echo  '</select>
      </td>';

      echo " <td class='edit-konversi' data-id='".$data['id']."'><span id='text-konversi-".$data['id']."'>". rp($data['konversi'])." ".$ddd['nama']."</span> <input type='hidden' id='input-konversi-".$data['id']."' value='".$data['konversi']."' class='input_konversi' data-id='".$data['id']."' autofocus=''> </td>

      <td class='edit-harga' data-id='".$data['id']."'><span id='text-harga-".$data['id']."'>". rp($data['harga_pokok']) ."</span> <input type='hidden' id='input-harga-".$data['id']."' value='".$data['harga_pokok']."' class='input_harga' data-id='".$data['id']."' autofocus=''> </td>";
/*
      <td class='edit-harga-jual' data-id='".$data['id']."'><span id='text-harga-jual-".$data['id']."'>". rp($data['harga_jual_konversi']) ."</span> <input type='hidden' id='input-harga-jual-".$data['id']."' value='".$data['harga_jual_konversi']."' class='input_harga_jual' data-id='".$data['id']."' autofocus=''> </td>

*/

      echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-satuan='". $data['id_satuan'] ."'> <i class='fa fa-trash'> </i> Hapus </button> </td>

      </tr>";

    }

    ?>
    </tbody>

  </table>
  </div>


                

  <script>

$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>

<script type="text/javascript">
$(document).ready(function(){
  //fungsi hapus data 
$(document).on('click', '.btn-hapus', function (e) {

    var id = $(this).attr("data-id");

    $.post("hapus_satuan_konversi.php",{id:id},function(data){
    if (data == "sukses") {

    $(".tr-id-"+id+"").remove();
    
    }

    
    });
    
    });
// end fungsi hapus data

              $('form').submit(function(){
              
              return false;
              });
              });
</script>


                              <script type="text/javascript">
                                 
                                 $(".edit-satuan").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-satuan-"+id+"").hide();

                                    $("#select-satuan-"+id+"").show();

                                 });

                                 $(".select-satuan").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_satuan = $(this).val();


                                    $.post("update_satuan_konveksi.php",{id:id, select_satuan:select_satuan,jenis_select:"satuan"},function(data){

                                    $("#text-satuan-"+id+"").show();
                                    $("#text-satuan-"+id+"").text(select_satuan);

                                    $("#select-satuan-"+id+"").hide();           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                    
                                    $(".edit-konversi").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-konversi-"+id+"").hide();
                                    
                                    $("#input-konversi-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input_konversi").blur(function(){
                                    
                                    var id = $(this).attr("data-id");

                                    var input_konversi = $(this).val();


                                    $.post("update_konversi_satuan_konveksi.php",{id:id, input_konversi:input_konversi,jenis_edit:"konversi"},function(data){

                       
                                    $("#text-konversi-"+id+"").show();
                                    $("#text-konversi-"+id+"").text(input_konversi);

                                    $("#input-konversi-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                    
                                    $(".edit-harga").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-harga-"+id+"").hide();
                                    
                                    $("#input-harga-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input_harga").blur(function(){
                                    
                                    var id = $(this).attr("data-id");

                                    var input_harga = $(this).val();


                                    $.post("update_harga_satuan_konveksi.php",{id:id, input_harga:input_harga,jenis_edit:"harga"},function(data){

                               
                                    $("#text-harga-"+id+"").show();
                                    $("#text-harga-"+id+"").text(input_harga);

                                    $("#input-harga-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                    
                                    $(".edit-harga-jual").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-harga-jual-"+id+"").hide();
                                    
                                    $("#input-harga-jual-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input_harga_jual").blur(function(){
                                    
                                    var id = $(this).attr("data-id");

                                    var input_harga_jual = $(this).val();


                                    $.post("update_harga_jual_konversi.php",{id:id, input_harga_jual:input_harga_jual,jenis_edit:"harga_jual"},function(data){

                               
                                    $("#text-harga-jual-"+id+"").show();
                                    $("#text-harga-jual-"+id+"").text(input_harga_jual);

                                    $("#input-harga-jual-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>