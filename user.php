<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$perintah = $db->query("SELECT * FROM user");



 ?>


<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="container">


<h3><b> DATA USER </b></h3> <hr>

<?php 
include 'db.php';

$pilih_akses_user_tambah = $db->query("SELECT user_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_tambah = '1'");
$user_tambah = mysqli_num_rows($pilih_akses_user_tambah);


    if ($user_tambah > 0){

// Trigger the modal with a button -->
echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> USER</button>';
}

?>
<br>
<br>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah User</h4>
     	 </div>
     	 					<div class="modal-body">
        
						<!--form--><form role="form" action="prosesuser.php" method="post">
					<div class="form-group">
					<label>Username </label><br>
					<input type="text" name="username" id="user" class="form-control" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Password </label><br>
					<input type="text" name="password" id="password" class="form-control" required="" >
					</div>

					<div class="form-group">
					<label>Nama Lengkap </label><br>
					<input type="text" name="nama" id="nama" class="form-control" required="" >
					</div>

					<div class="form-group">
					<label>Alamat </label><br>
					<textarea name="alamat" id="alamat" class="form-control" required=""></textarea> 
					</div>

					<div class="form-group">
					<label> Jabatan </label><br>
					
					<select type="text" name="jabatan" id="jabatan" class="form-control" required="" >
					<option value="">Silahkan Pilih</option>
    <?php 

    
    $query = $db->query("SELECT * FROM jabatan ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option>".$data['nama'] ."</option>";
    }
    
    
    ?>
    
    
					</select>

					</div>

					<div class="form-group">
					<label>Otoritas</label><br>
					<select type="text" name="otoritas" id="otoritas" class="form-control" required="" >
					<option value="">Silahkan Pilih</option>
<?php 

$ambil_otoritas = $db->query("SELECT * FROM hak_otoritas");

    while($data_otoritas = mysqli_fetch_array($ambil_otoritas))
    {
    
    echo "<option>".$data_otoritas['nama'] ."</option>";

    }

 ?>
					</select>
					</div>

					<div class="form-group">
					<label> Status </label><br>
					<select type="text" name="status" id="status" class="form-control" required="" >
					<option>aktif</option>
					<option>tidak aktif</option>
					</select>
					</div>

					<div class="form-group">
					<label> Status Sales</label><br>
					<select type="text" name="status_sales" id="status_sales" class="form-control" required="" >
					<option value="">--Silakan Pilih--</option>
					<option value="Iya">Iya</option>
					<option value="Tidak">Tidak</option>
					</select>
					</div>

					
					<button type="submit" class="btn btn-info"><span class='glyphicon glyphicon-plus'> </span>Tambah</button>
					</form>
							</div>


     <!--button penutup-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>


    </div>

  </div>
</div>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data User</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Username :</label>
     <input type="text" id="user_name" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"><span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->


<!-- Modal Reset data -->
<div id="modal_reset" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Reset Password Data User</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Mengganti Password Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Username :</label>
     <input type="text" id="reset_user_name" class="form-control" readonly=""> 
     <input type="hidden" id="reset_id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Password Berhasil Di Reset
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_reset"><span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal reset data  -->




<div class="table-responsive">
<span id="table-baru">
<table id="tableuser" class="table table-bordered">
		<thead>

			<th style='background-color: #4CAF50; color: white'> Reset Password </th>
			<th style='background-color: #4CAF50; color: white'> Username </th>
			<th style='background-color: #4CAF50; color: white'> Password </th>
			<th style='background-color: #4CAF50; color: white'> Nama Lengkap </th>
			<th style='background-color: #4CAF50; color: white'> Alamat </th>
			<th style='background-color: #4CAF50; color: white'> Jabatan </th>
			<th style='background-color: #4CAF50; color: white'> Otoritas </th>
			<th style='background-color: #4CAF50; color: white'> Status </th>
			<th style='background-color: #4CAF50; color: white'> Status Sales </th>
<?php 
include 'db.php';

$pilih_akses_user_hapus = $db->query("SELECT user_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_hapus = '1'");
$user_hapus = mysqli_num_rows($pilih_akses_user_hapus);


    if ($user_hapus > 0){

			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";

		}
?>

<?php 
include 'db.php';

$pilih_akses_user_edit = $db->query("SELECT user_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_edit = '1'");
$user_edit= mysqli_num_rows($pilih_akses_user_edit);


    if ($user_edit > 0){
			echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
		}
	?>
			
			
		</thead>
		
		<tbody>
		<?php

		
			while ($data1 = mysqli_fetch_array($perintah))
			{
			echo "<tr class='tr-id-".$data1['id']."'>
			<td> <button class='btn btn-warning btn-reset' data-reset-id='". $data1['id'] ."' data-reset-user='". $data1['username'] ."'><span class='glyphicon glyphicon-refresh'> </span> Reset Password </button> </td>
			<td>". $data1['username'] ."</td>
			<td>". $data1['password'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". $data1['alamat'] ."</td>
			<td>". $data1['jabatan'] ."</td>
			<td>". $data1['otoritas'] ."</td>
			<td>". $data1['status'] ."</td>";

      if ($data1['status_sales'] == "Iya") {
        
        echo "<td> <i class='fa fa-check'> </i> </td>";
      }
      else{
         echo "<td> <i class='fa fa-close'> </i> </td>";
      }


include 'db.php';

$pilih_akses_user_hapus = $db->query("SELECT user_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_hapus = '1'");
$user_hapus = mysqli_num_rows($pilih_akses_user_hapus);


    if ($user_hapus > 0){
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-user='". $data1['username'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";

		}

include 'db.php';

$pilih_akses_user_edit = $db->query("SELECT user_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND user_edit = '1'");
$user_edit = mysqli_num_rows($pilih_akses_user_edit);


    if ($user_edit > 0){

			echo "<td> <a href='edituser.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit </a> </td> 
			
			</tr>";
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
    $('.table').DataTable();
});

</script>



        <script type="text/javascript">
			
//fungsi hapus data 
$(document).on('click', '.btn-hapus', function (e) {
		var username = $(this).attr("data-user");
		var id = $(this).attr("data-id");
		$("#user_name").val(username);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


$(document).on('click', '#btn_jadi_hapus', function (e) {
		
		var id = $("#id_hapus").val();
		$.post("hapususer.php",{id:id},function(data){
		if (data != "") {
		
		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id+"").remove();
		}

		
		});
		
		
		});

		</script> 

		<script>
//fungsi reset password data 
		$(".btn-reset").click(function(){
		var reset_user_name = $(this).attr("data-reset-user");
		var reset_id = $(this).attr("data-reset-id");
		$("#reset_user_name").val(reset_user_name);
		$("#reset_id_hapus").val(reset_id);
		$("#modal_reset").modal('show');
		

		
		$(".alert-success").hide();
		
		});


		$("#btn_jadi_reset").click(function(){
		

		var user_name = $("#reset_user_name").val();
		var id = $("#reset_id_hapus").val();
		$.post("reset_password.php",{id:id},function(data){
		if (data != "") {
		$("#table-baru").load('tabel-user.php');
		$(".alert-success").show();
		$("#modal_reset").modal('hide');
		
		}

		
		});
		
		
		});




		</script>       


<script type="text/javascript">

               $(document).ready(function(){
               $("#user").blur(function(){
               var user = $("#user").val();

              $.post('cek_user.php',{user:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Username Sudah Ada");
                    $("#user").val('');
                }
                else {
                    
                }
              });
                
               });
               });

</script>                    

<?php include 'footer.php'; ?>