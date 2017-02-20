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

   <!-- Modal Untuk Confirm Delete-->
<div id="modale-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
          <center><h4>Apakah Anda Yakin Ingin Menghapus Data Ini ?</h4></center>

    <div class="modal-body">
    </div>
    <div class="container">
      <div class="form-group">
  <label for="sel1">Nama </label>
<input type="text" style="height: 20px;" class="form-control" id="nama_hapus" name="nama_hapus" autocomplete="off" readonly="">
        <input type="hidden" id="id2" name="id2">

</div>
    </div>

    <div class="modal-footer">
        <button type="submit" data-id="" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->

<?php 

$pilih_akses_admin_tambah = $db->query("SELECT biaya_admin_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND biaya_admin_tambah = '1'");
$admin_tambah = mysqli_num_rows($pilih_akses_admin_tambah);

 ?>

<h3><b> DATA BIAYA ADMIN </b></h3>
<?php if ($admin_tambah > 0): ?>
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"> </i> Biaya Admin  </button>
<br>
<br>
<?php endif ?>



<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">

    <thead>
      <tr>

          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Persentase </th>
          <th style='background-color: #4CAF50; color: white'>Hapus</th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM biaya_admin ");
   while($data = mysqli_fetch_array($query))      
      {
      echo "<tr class='tr-id-".$data['id']."'>";

  $pilih_akses_biaya_admin_edit = $db->query("SELECT biaya_admin_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND biaya_admin_edit = '1'");
$biaya_admin_edit = mysqli_num_rows($pilih_akses_biaya_admin_edit);
  if ($biaya_admin_edit > 0) {
      
      echo "<td class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['nama'] ."</span> <input type='hidden' id='input-nama-".$data['id']."' value='".$data['nama']."' class='input_nama' data-id='".$data['id']."' data-nama='".$data['nama']."' autofocus=''> </td>";

        echo "<td class='edit-persen' data-id='".$data['id']."'><span id='text-persen-".$data['id']."'>". $data['persentase'] ."</span> <input type='hidden' id='input-persen-".$data['id']."' value='".$data['persentase']."' class='input_persen' data-id='".$data['id']."' data-persen='".$data['persentase']."' autofocus=''> %</td>";
}
else{

  echo "<td>". $data['nama'] ." </td>";
  echo "<td>". $data['persentase'] ." %</td>";
}




$pilih_akses_biaya_admin_hapus = $db->query("SELECT biaya_admin_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND biaya_admin_hapus = '1'");
$biaya_admin_hapus = mysqli_num_rows($pilih_akses_biaya_admin_hapus);
  if ($biaya_admin_hapus > 0) {

    echo "<td><button data-id='".$data['id']."' data-nama='".$data['nama']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";
    
  }
  else{

    echo "<td> </td>";

  }
      echo "
      </tr>";
      }
    ?>
  </tbody>
 </table>
 </div>
</span>

<h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom yang ingin di edit.</i></h6>



<!-- Modal -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Biaya Admin</h4>
        </div>
        <div class="modal-body">

          <form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Nama </label>
  <input type="text" style="height: 20px;" class="form-control" id="nama" name="nama" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Persentase </label>
  <input type="text" style="height: 20px;" class="form-control" id="persentase" name="persentase" autocomplete="off">
</div>

<button id="submit_tmbh" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button>
</form>

</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



</div><!--CONTAINER-->



<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
    var nama = $(this).attr('data-nama');

  $("#modale-delete").modal('show');
  $("#id2").val(id);  
  $("#nama_hapus").val(nama);  

});


</script>
<!--   end script modal confiormasi dellete -->

<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id2").val();


$.post('delete_biaya_admin.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $("#cari").keyup(function(){
var q = $(this).val();

$.post('table_baru_poli.php',{q:q},function(data)
{
  $("#table_baru").html(data);
  
});
});
</script>
<!-- END script cari untuk pegy natio -->

<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $("#persentase").keyup(function(){
  var persentase = $("#persentase").val();
  if(persentase == 0)
  {
    alert("Persetase Tidak Boleh 0");
     $("#persentase").val('');
    $("#persentase").focus();
  }
  else if(persentase > 100)
  {
    alert("Tidak Boleh Lebih dari 100%");
    $("#persentase").val('');
    $("#persentase").focus();

  }
});
</script>
<!-- END script cari untuk pegy natio -->

<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $(document).on('click','#submit_tmbh',function(e){

  var nama = $("#nama").val();
  var persentase = $("#persentase").val();

 if (nama == '') {

      alert('Nama Belum Terisi');
    }
    else if(persentase == '')
    {
      alert('Persentase Tidak Boleh 0');
    }
    
    else{

// cek namanya
 $.post('cek_nama_biaya_admin.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Nama Biaya Admin Sudah Ada !!');
          $("#nama").val('');
          $("#nama").focus();
        }
        else{

// Start Proses
     $("#modal").modal('hide');
  $.post('proses_biaya_admin.php',{nama:nama,persentase:persentase},function(data)
  {
  
  $("#tbody").prepend(data);
  $("#nama").val('');
  $("#persentase").val('');
  });
// Finish Proses
        }

      }); // end post dari cek nama

    } // end else breket

});

            
     $('form').submit(function(){
     return false;
     });


</script>
<!-- END script cari untuk pegy natio -->


<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>



<script type="text/javascript">
$(document).on('dblclick','.edit-nama',function(e){
  
var id = $(this).attr("data-id");
$("#text-nama-"+id+"").hide();
 $("#input-nama-"+id+"").attr("type", "text");

 });

$(document).on('blur','.input_nama',function(e){
var nama_lama = $(this).attr("data-nama");
var id = $(this).attr("data-id");
var input_nama = $(this).val();

if (input_nama == '') {
      alert('Nama Tidak Boleh Kosong !!');

    }
    
    else{

// cek namanya
 $.post('cek_nama_biaya_admin.php',{nama:input_nama}, function(data){

        if(data == 1){
          alert('Nama Biaya Admin Sudah Ada!');
$("#text-nama-"+id+"").show();
$("#text-nama-"+id+"").text(nama_lama);
$("#input-nama-"+id+"").attr("type", "hidden");
$("#input-nama-"+id+"").val(nama_lama);
$("#input-nama-"+id+"").attr("data-nama",nama_lama);

        }
        else{

// Start Proses
$.post("update_data_biaya_admin.php",{id:id, input_nama:input_nama,jenis_edit:"nama_biaya_admin"},function(data){

$("#text-nama-"+id+"").show();
$("#text-nama-"+id+"").text(input_nama);
$("#input-nama-"+id+"").attr("type", "hidden");           
$("#input-nama-"+id+"").val(input_nama);
$("#input-nama-"+id+"").attr("data-nama",input_nama);


});
// Finish Proses
        }

      }); // end post dari cek nama

    } // end else breket


});

</script>


<!--EDIT PERSENTASE-->
<script type="text/javascript">
$(document).on('dblclick','.edit-persen',function(e){
  
var id = $(this).attr("data-id");
$("#text-persen-"+id+"").hide();
 $("#input-persen-"+id+"").attr("type", "text");

 });

$(document).on('blur','.input_persen',function(e){
var persen_lama = $(this).attr("data-persen");
var id = $(this).attr("data-id");
var input_persen = $(this).val();

if (input_persen == '') {
alert('Persentase Tidak Boleh Kosong !!');
$("#text-persen-"+id+"").show();
$("#text-persen-"+id+"").text(persen_lama);
$("#input-persen-"+id+"").attr("type", "hidden");
$("#input-persen-"+id+"").val(persen_lama);
$("#input-persen-"+id+"").attr("data-persen",persen_lama);
    }
    
    else if 
      (input_persen == 0){

alert('Persentase Tidak Boleh 0!');
$("#text-persen-"+id+"").show();
$("#text-persen-"+id+"").text(persen_lama);
$("#input-persen-"+id+"").attr("type", "hidden");
$("#input-persen-"+id+"").val(persen_lama);
$("#input-persen-"+id+"").attr("data-persen",persen_lama);

        }
        else{

// Start Proses
$.post("update_persentase_biaya_admin.php",{id:id, input_persen:input_persen},function(data){

$("#text-persen-"+id+"").show();
$("#text-persen-"+id+"").text(input_persen);
$("#input-persen-"+id+"").attr("type", "hidden");           
$("#input-persen-"+id+"").val(input_persen);
$("#input-persen-"+id+"").attr("data-persen",input_persen);


});
// Finish Proses
        }


});

</script>
<!--end edit persentase-->
<!--FOOTER-->
<?php 
  include 'footer.php';
?>
<!--END FOOTER-->


  