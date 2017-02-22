<?php session_start();


include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

$perintah = $db->query("SELECT * FROM tbs_jurnal");



 ?>
  <table id="tableuser" class="table table-hover">
    <thead>
      <th> Kode Akun </th>
      <th> Nama Akun </th>
      <th> Debit </th>      
      <th> Kredit </th>      
      <th> Hapus </th> 
      
    </thead>
    
    <tbody>
    <?php

    //menampilkan semua data yang ada pada tabel tbs kas masuk dalam DB
     $perintah = $db->query("SELECT * FROM tbs_jurnal WHERE session_id = '$session_id'");

      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {
        //menampilkan data
      echo "<tr class='tr-id-". $data1['id'] ."'>
      <td>". $data1['kode_akun_jurnal'] ."</td>
      <td>". $data1['nama_akun_jurnal'] ."</td>";

if ($data1['debit'] == 0) {
      echo "<td>". rp($data1['debit']) ."</td>   ";
} 

else {
       echo "<td class='edit-debit' data-id='".$data1['id']."'> <span id='text-debit-".$data1['id']."'> ". rp($data1['debit']) ." </span> <input type='hidden' id='input-debit-".$data1['id']."' value='".$data1['debit']."' class='input-debit' data-id='".$data1['id']."' data-debit='".$data1['debit']."' autofocus=''> </td>"; 
}

  
if ($data1['kredit'] == 0) {
      echo "<td>". rp($data1['kredit']) ."</td>   ";
} 

else {
       echo "<td class='edit-kredit' data-id='".$data1['id']."'> <span id='text-kredit-".$data1['id']."'> ". rp($data1['kredit']) ." </span> 
       <input type='hidden' id='input-kredit-".$data1['id']."' value='".$data1['kredit']."' class='input-kredit' data-id='".$data1['id']."' data-kredit='".$data1['kredit']."' autofocus=''> </td>   "; 
}

         

      echo "
      <td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-akun='". $data1['kode_akun_jurnal'] ."' data-nama='". $data1['nama_akun_jurnal'] ."' ><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>

      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>

  <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom Debit atau Kredit jika ingin mengedit.</i></h6>
<script>

$(document).ready(function(){
    $('.table').dataTable();
});

</script>


<script type="text/javascript">

    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){

    
      var nama_akun_jurnal = $(this).attr("data-nama");
      var kode_akun_jurnal = $(this).attr("data-kode-akun");
      var id = $(this).attr("data-id");
      var debit = bersihPemisah($("#debit").val());
      var kredit = bersihPemisah($("#kredit").val());
      var total_kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_kredit").val()))));
      var total_debit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_debit").val()))));
    
        if (total_kredit == '') 
        {
          total_kredit = 0;
        }
        else if(kredit == '')
        {
          kredit = 0;
        };
        var total_kredit_akhir = parseInt(total_kredit,10) - parseInt(kredit,10);

        if (total_debit == '') 
          {
            total_debit = 0;
          }
          else if(debit == '')
          {
            debit = 0;
          };

         var total_debit_akhir = parseInt(total_debit) - parseInt(debit);

          if (total_debit_akhir == '') 
          {
            total_debit_akhir = 0;
          }
          else if(total_kredit_akhir == '')
          {
            total_kredit_akhir = 0;
          };


    $("#t_kredit").val(tandaPemisahTitik(total_kredit_akhir))
    $("#t_debit").val(tandaPemisahTitik(total_debit_akhir))

    $.post("hapus_jurnal_manual.php",{id:id,kode_akun_jurnal:kode_akun_jurnal},function(data){
    if (data == 'sukses') {
    
    
    $(".tr-id-"+id+"").remove();
    
    }
    });           
    
    });
                  $('form').submit(function(){
                  
                  return false;
                  });


    });
  
//end fungsi hapus data
</script>

                             <script type="text/javascript">
                                 
                                 $(".edit-debit").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-debit-"+id+"").hide();

                                    $("#input-debit-"+id+"").attr("type", "text");

                                 });

                                 $(".input-debit").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var debit_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-debit")))));
                                    var total_debit_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_debit").val()))));

                                    var input_debit = $(this).val();

                                    if (total_debit_lama == '') 
                                    {
                                    total_debit_lama = 0;
                                    }
                                    
                                    var total_debit_akhir = parseInt(total_debit_lama,10) - parseInt(debit_lama,10) + parseInt(input_debit,10);



                                    $.post("update_jurnal_manual.php",{id:id, input_debit:input_debit,jenis_edit:"debit"},function(data){

                                    $("#text-debit-"+id+"").show();
                                    $("#text-debit-"+id+"").text(input_debit);
                                    $("#t_debit").val(total_debit_akhir);
                                    $("#input-debit-"+id+"").attr("type", "hidden");           

                                    });

    

                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                 $(".edit-kredit").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-kredit-"+id+"").hide();

                                    $("#input-kredit-"+id+"").attr("type", "text");

                                 });

                                 $(".input-kredit").blur(function(){

                                    var id = $(this).attr("data-id");
                                    var kredit_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-kredit")))));
                                    var total_kredit_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_kredit").val()))));

                                    var input_kredit = $(this).val();

                                    if (total_kredit_lama == '') 
                                    {
                                    total_kredit_lama = 0;
                                    }
                                    
                                    var total_kredit_akhir = parseInt(total_kredit_lama,10) - parseInt(kredit_lama,10) + parseInt(input_kredit,10);



                                    $.post("update_jurnal_manual.php",{id:id, input_kredit:input_kredit,jenis_edit:"kredit"},function(data){

                                    $("#text-kredit-"+id+"").show();
                                    $("#text-kredit-"+id+"").text(input_kredit);
                                    $("#t_kredit").val(total_kredit_akhir);
                                    $("#input-kredit-"+id+"").attr("type", "hidden");           
                                    
                                    });
                                    


                                    });

                             </script>
