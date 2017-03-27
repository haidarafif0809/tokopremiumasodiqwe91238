<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';




?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

  <div class="container">


<h3><b> SETTING FLAG TIMBANGAN  </b></h3> <hr>

<br>
<br>


<span id="table_baru">  
<div class="table-responsive">
  <table id="table-antrian" class="table table-bordered table-sm">
 
    <thead>
      <tr>

          <th style='background-color: #4CAF50; color: white;'>Kode Flag </th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT id,kode_flag FROM setting_timbangan");
   while($data = mysqli_fetch_array($query))      
      {
      echo "<tr class='tr-id-".$data['id']."'>";
    echo "<td style='font-size:15px;background-color:#90caf9;cursor:pointer;' align='left' class='edit-timbangan' data-id='".$data['id']."' > <span id='text-jumlah-".$data['id']."'>".$data['kode_flag']."</span> <input type='hidden' id='input-jumlah-".$data['id']."' value='".$data['kode_flag']."' class='input_jumlah_jual' data-id='".$data['id']."' autofocus=''> </td>";

     echo"</tr>";
      }
    ?>
  </tbody>
 </table>
 </div>
</span>

<h6 style="text-align: left ; color: red"><i> * Klik 2x pada  Kolom  jika ingin mengedit.</i></h6>





</div><!--CONTAINER-->



<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

    <script type="text/javascript">
              $(document).on('dblclick','.edit-timbangan',function(e){
                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr('type','text');

                                 });

                          $(document).on('blur','.input_jumlah_jual',function(e){

                                    var id = $(this).attr("data-id");

                                    var input_tampil = $(this).val();


                                    $.post("update_setting_timbangan.php",{id:id,input_tampil:input_tampil},function(data){

                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(input_tampil);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 

                                    });
                                 });

                             </script>
<!--FOOTER-->
<?php 
  include 'footer.php';
?>
<!--END FOOTER-->


  