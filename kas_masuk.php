<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.ke_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM kas_masuk km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun");




 ?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container"> <!--start of container-->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Kas Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
   <div class="form-group">
					<label> Nomor Faktur :</label>
					<input type="text" id="hapus_no_faktur" class="form-control" readonly="">		
					<input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Kas Masuk</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    
		<label> Jumlah Baru </label><br>
		<input type="text" name="jumlah_baru" id="jumlah_baru" autocomplete="off" class="form-control" required="">
					

		<input type="hidden" name="jumlah" id="jumlah_lama" class="form-control" readonly="" required="">	
					

		<input type="hidden" name="ke_akun" id="ke_akun" class="form-control" readonly="" required="">
					

					
		<label> Keterangan </label><br>
		<textarea type="text" name="keterangan" id="keterangan" class="form-control"></textarea>

		<input type="hidden" id="id_edit" class="form-control" > 
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
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

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Kas Masuk </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<h3><b>DATA KAS MASUK</b></h3><hr>

<?php
include 'db.php';

$pilih_akses_kas_masuk = $db->query("SELECT * FROM otoritas_kas_masuk WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$kas_masuk = mysqli_fetch_array($pilih_akses_kas_masuk);

if ($kas_masuk['kas_masuk_tambah'] > 0) {

echo '<a href="form_kas_masuk.php"  class="btn btn-info"><i class="fa fa-plus"> </i> KAS MASUK</a>';
}
?>

<br><br>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel-baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Ke Akun </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>

<?php

if ($kas_masuk['kas_masuk_edit'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
?>

<?php

if ($kas_masuk['kas_masuk_hapus'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}
?>
			
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr class='tr-id-".$data1['id']."'>
			<td>". $data1['no_faktur'] ."</td>			
			<td>". $data1['nama_daftar_akun'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>			
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			


			<td> <button class=' btn btn-info detail' no_faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

if ($kas_masuk['kas_masuk_edit'] > 0) {

			echo "<td> <a href='proses_edit_data_kas_masuk.php?no_faktur=". $data1['no_faktur']."&nama_daftar_akun=". $data1['nama_daftar_akun']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";
		}

if ($kas_masuk['kas_masuk_hapus'] > 0) {
			echo "<td> <button class=' btn btn-danger btn-hapus' data-id='". $data1['id'] ."' no-faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 


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
<br>
		<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
		<span id="demo"> </span>


</div><!--end of container-->

<script>
		
		// untk menampilkan datatable atau filter seacrh
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		
		$(".detail").click(function(){
		var no_faktur = $(this).attr('no_faktur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_kas_masuk.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
</script>


	
<script type="text/javascript">
			
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var no_faktur = $(this).attr("no-faktur");
		var id = $(this).attr("data-id");
		$("#hapus_no_faktur").val(no_faktur);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		var id = $(this).attr("data-id");
		var no_faktur = $("#hapus_no_faktur").val();

		$.post("hapus_kas_masuk.php",{id:id,no_faktur:no_faktur},function(data){
		if (data != "") {

		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id).remove();
		
		}
		
		});
		
		
		});

		//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var jumlah = $(this).attr("data-jumlah");
		var ke_akun = $(this).attr("data-akun");
		var id  = $(this).attr("data-id");
		$("#jumlah_lama").val(jumlah);
		$("#ke_akun").val(ke_akun);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var jumlah_baru = $("#jumlah_baru").val();
		var jumlah = $("#jumlah_lama").val();
		var ke_akun = $("#ke_akun").val();
		var keterangan = $("#keterangan").val();
		var id = $("#id_edit").val();

		$.post("update_kas_masuk.php",{id:id,jumlah_baru:jumlah_baru,jumlah:jumlah,ke_akun:ke_akun,keterangan:keterangan},function(data){

		$(".alert").show('fast');
		$("#tabel-baru").load('tabel-kas-masuk.php');
		$("#modal_edit").modal('hide');
		

		});
		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});

</script>

<?php 
include 'footer.php';
 ?>