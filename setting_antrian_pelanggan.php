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


<h3><b> SETTING ANTRIAN PELANGGAN </b></h3> <hr>

<br>
<br>


<span id="table_baru">  
<div class="table-responsive">
  <table id="table-antrian" class="table table-bordered">
 
    <thead>
      <tr>

          <th style='background-color: #4CAF50; color: white; width: 50%'>Tampil Antrian Di Penjualan </th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM setting_antrian ORDER BY id DESC");
   while($data = mysqli_fetch_array($query))      
      {
      echo "<tr class='tr-id-".$data['id']."'>";
      if ($data['setting_tampil'] == 'Tampil') {
        echo"<td class='edit-antrian' data-id='".$data['id']."'><span id='text-antrian-".$data['id']."'>Tampil</span>
      <select style='display:none' id='select-antrian-".$data['id']."' value='Tampil' class='select-antrian' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="Tampil">Tampil</option>';
      
      echo '<option value="Tidak">Tidak</option>';
      
      
      
      echo  '</select>
      </td>';

      }
      else
      {
      echo"<td class='edit-antrian' data-id='".$data['id']."'><span id='text-antrian-".$data['id']."'>Tidak</span>
      <select style='display:none' id='select-antrian-".$data['id']."' value='Tidak' class='select-antrian' data-id='".$data['id']."' autofocus=''>";


      echo '<option value="Tidak">Tidak</option>';

      echo '<option value="Tampil">Tampil</option>';
      
      
      
      
      echo  '</select>
      </td>';
      }

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
                                 
                                 $(".edit-antrian").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-antrian-"+id+"").hide();

                                    $("#select-antrian-"+id+"").show();

                                 });

                                 $(".select-antrian").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_tampil = $(this).val();


                                    $.post("update_setting_antrian.php",{id:id, select_tampil:select_tampil,jenis_select:"antrian"},function(data){


                                    if (select_tampil == 'Tampil') {
                                      select_tampil = 'Tampil';
                                    }
                                    else
                                    {
                                      select_tampil = 'Tidak';
                                    }
                                    
                                    $("#text-antrian-"+id+"").show();
                                    $("#text-antrian-"+id+"").text(select_tampil);

                                    $("#select-antrian-"+id+"").hide();           

                                    });
                                 });

                             </script>
<!--FOOTER-->
<?php 
  include 'footer.php';
?>
<!--END FOOTER-->


  