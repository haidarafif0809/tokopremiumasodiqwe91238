<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$query = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");



 ?>

<style>
      
      tr:nth-child(even){background-color: #f2f2f2}
      
</style>

<div class="container">
 <h3><b>DATA KAS</b></h3> <hr>


<!-- Modal edit data -->
<div id="modal_edit-default" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Kas Keluar</h4>
      </div>
      <div class="modal-body">
  <form role="form" action="update_default_kas.php" method="post">
   <div class="form-group">

          <label> Default Kas </label><br>
          <select type="text" name="kas_default" id="kas_default" autocomplete="off" class="form-control" >
          <option value="Ya">Ya</option>
          <option value="">Tidak</option>
          </select> 
     
          
          <input type="hidden" name="kode_daftar_akun" id="kode_daftar_akun" class="form-control">
          <input type="hidden" name="id" id="id_edit_default" class="form-control"> 
    
   </div>
   
   
   <button type="submit" id="submit_edit_default" class="btn btn-success">Submit</button>
  </form>


  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<div class="card card-block">

<div class="table-responsive"> 
<span id="tabel_baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nama  </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah </th>
      <th style="background-color: #4CAF50; color: white;"> Default </th>


<?php
include 'db.php';

$pilih_akses_kas_edit = $db->query("SELECT * FROM otoritas_kas WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$kas_edit = mysqli_fetch_array($pilih_akses_kas_edit);

    if ($kas_edit['kas_edit'] > 0) {
      echo "<th style='background-color: #4CAF50; color: white;''> Edit </th>";
}
?>			

			
			
		</thead>
		
		<tbody>
		<?php

		
			while ($data = mysqli_fetch_array($query))
		{
			echo "<tr>
      <td>". $data['nama_daftar_akun'] ."</td>";

            
// MENCARI JUMLAH KAS
            $query0 = $db->query("SELECT SUM(debit) - SUM(kredit) AS total_kas FROM jurnal_trans WHERE kode_akun_jurnal = '$data[kode_daftar_akun]'");
            $cek0 = mysqli_fetch_array($query0);
            $total_kas = $cek0['total_kas'];

            echo "<td>". rp($total_kas) ."</td>";
            $sett_akun = $db->query("SELECT kas FROM setting_akun");
            $data_sett = mysqli_fetch_array($sett_akun);
            
            if ($data['kode_daftar_akun'] == $data_sett['kas']) {
            
            echo "<td> <i class='fa fa-check'> </i> </td>";
            }
            else{
            echo "<td> <i class='fa fa-close'> </i> </td>";
            }
            
            
            
    if ($kas_edit['kas_edit'] > 0) {
            
            echo "<td> <button class='btn btn-info btn-edit-default' data-id='".$data['id']."' data-kode='".$data['kode_daftar_akun']."'> <span class='glyphicon glyphicon-edit'></span> Edit</button> </td>";
            
            }

      }


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>
</span>

</div>

</div>

<script>

$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>




<script type="text/javascript">
  
    $(".btn-edit-default").click(function(){
    
    $("#modal_edit-default").modal('show');
    var kode_daftar_akun = $(this).attr("data-kode");
    var id  = $(this).attr("data-id");
    $("#kode_daftar_akun").val(kode_daftar_akun);
    $("#id_edit_default").val(id);
    
    
    });

    $(".btn-edit-default").click(function(){

      var kode_daftar_akun = $("#kode_daftar_akun").val();
      var kas_default = $("#kas_default").val();
      var id = $("#id_edit_default").val();

        $.post("update_default_kas.php",{id:id,kas_default:kas_default,kode_daftar_akun:kode_daftar_akun},function(data){
        
        
        });
      });

</script>



<?php include 'footer.php'; ?>

