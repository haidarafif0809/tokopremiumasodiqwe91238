<?php include 'session_login.php';

//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB


$perintah = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM kas_mutasi km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun ORDER BY km.id DESC");


// menyimpan data sementara yang ada pada $query1
 $data = mysqli_fetch_array($perintah);

 // mengambil dan menyimpan data id pada variabel ($nomor_terkhir)
 $nomor_terakhir = $data['id'];

 // mengambil dan menyimpan data nomor terakhir +1 pada variabel ($nomor_faktur)
 $nomor_faktur = $nomor_terakhir + 1;


 ?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

			<script>
			$(function() {
			$( ".tgl" ).datepicker({dateFormat: "yy-mm-dd"});
			});
			</script>


<div style="padding-left:5%; padding-right:5%"> <!--start of container-->

<h3><b>DATA KAS MUTASI</u></b></h3><hr>

<?php
include 'db.php';

$pilih_akses_kas_mutasi = $db->query("SELECT * FROM otoritas_kas_mutasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$kas_mutasi = mysqli_fetch_array($pilih_akses_kas_mutasi);

if ($kas_mutasi['kas_mutasi_tambah'] > 0) {

echo '<button type="button" id="tambah" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> KAS MUTASI </button>';
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
        <h4 class="modal-title">Tambah Kas Mutasi</h4>
     	 </div>
     		<div class="modal-body">
        
			<form role="form">

				<div class="form-group">
						<div class="form-group">
						<label> Tanggal </label><br>
						<input type="text" name="tanggal" autocomplete="off" id="tanggal1" placeholder="Tanggal" value="<?php echo date("d-m-Y"); ?>" class="form-control tgl" >
						</div>
						
						<div class="form-group">
						<label> Nomor Faktur </label><br>
						<input type="text" name="no_faktur" autocomplete="off" id="tambah_faktur" placeholder="Nomor Faktur" class="form-control" readonly="">
						
						</div>
						
						<div class="form-group">
						<label> Keterangan </label><br>
						<input type="text" name="keterangan" autocomplete="off" placeholder="Keterangan" id="keterangan" class="form-control">
						</div>
						
						<div class="form-group">
						<label> Dari Kas </label><br>
						<select type="text" name="dari_akun" id="dari_akun1" class="form-control" >
						<option value="">Silahkan Pilih</option>
						
						
						
						<?php 
						
						
						$query = $db->query("SELECT * FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
						while($data = mysqli_fetch_array($query))
						{
						
						echo "<option value='".$data['kode_daftar_akun'] ."'>".$data['nama_daftar_akun'] ."</option>";
						}
						
						
						?>
						</select>
						</div>
						
						<!-- diganti ke hidden -->
						<div class="form-group">
						<label> Total Kas </label><br>
						<input type="text" name="jumlah_kas" id="jumlah_kas1" class="form-control" readonly="">
						</div>
						
						<div class="form-group">
						<label> Ke Kas </label><br>
						<select type="text" name="ke_akun" id="ke_akun1" class="form-control" >
						<option value="">Silahkan Pilih</option>
						
						<?php 
						
						
						$query = $db->query("SELECT * FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
						while($data = mysqli_fetch_array($query))
						{
						
						echo "<option value='".$data['kode_daftar_akun'] ."'>".$data['nama_daftar_akun'] ."</option>";
						}
						
						
						?>
						</select>
						</div>
						
						<div class="form-group">
						<label> Jumlah Nominal</label><br>
						<input type="text" name="jumlah" id="jumlah2" autocomplete="off" placeholder="Jumlah Nominal" class="form-control" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >
						</div>
									

				</div>

					<button type="submit" id="submit_tambah" class="btn btn-success"><i class="fa fa-plus"></i> Submit</button>
			</form>
				
				<div class="alert alert-success" style="display:none">
				<strong>Berhasil!</strong> Data berhasil Di Tambah
				</div>
  </div>
				<div class ="modal-footer">
				<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
  </div>

  </div>
</div><!-- end of modal buat data  -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Kas Mutasi</h4>
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
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
        <h4 class="modal-title">Edit Kas Mutasi</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">

   					
				<label> Nomor Faktur </label><br>
				<input type="text" name="no_faktur" id="faktur_edit" placeholder="Nomor Faktur" class="form-control" readonly="" >
						
					
					<label> Tanggal </label><br>
					<input type="text" name="tanggal_edit" id="tanggal_edit" placeholder="Tanggal" value="<?php echo date("d-m-Y"); ?>" autocomplete="off" class="form-control tgl" >

						
					<label> Jumlah Baru </label><br>
					<input type="text" name="jumlah_baru" id="edit_jumlah" onkeydown="return numbersonly(this, event);" autocomplete="off" onkeyup="javascript:tandaPemisahTitik(this);" class="form-control">


					<input type="hidden" name="jumlah" id="edit_jumlah_lama" value="<?php echo $data['jumlah']; ?>" class="form-control" readonly="">	
					
					<input type="hidden" name="ke_akun" id="edit_ke_akun" value="<?php echo $data['ke_akun']; ?>" class="form-control" readonly="">

					<input type="hidden" name="dari_akun" id="edit_dari_akun" value="<?php echo $data['dari_akun']; ?>" class="form-control" readonly="">

					<input type="hidden" name="sisa_kas" id="sisa_kas" class="form-control" readonly="">
					
					<label> Keterangan </label><br>
					<textarea type="text" name="keterangan" id="edit_keterangan" class="form-control"> </textarea>
					<input type="hidden" class="form-control" id="id_edit">
					
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-primary">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>

</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>

</div>

  </div>
</div><!-- end of modal edit data  -->

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel_baru">
<table id="table_mutasi" class="table table-bordered table-sm">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Cetak </th>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan </th>
			<th style='background-color: #4CAF50; color:white'> Dari Akun </th>
			<th style='background-color: #4CAF50; color:white'> Ke Akun </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> Petugas Edit </th>
			<th style='background-color: #4CAF50; color:white'> Waktu Edit </th>	

<?php
if ($kas_mutasi['kas_mutasi_hapus'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}
?>

<?php
if ($kas_mutasi['kas_mutasi_edit'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
?>		
			
		</thead>

	</table>
</span>
</div>
</div><!--end of container-->


<!-- DATATABLE AJAX -->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_mutasi').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_kas_mutasi.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_mutasi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[13]+'');
            },
        });
      });
    </script>
<!-- / DATATABLE AJAX -->


			<!-- Dari Form Kas Mutasi -->
			<script>
			
			//untuk mengambil data jumlah dari tabel kas bertdasarkan id dari akun1
			$(document).ready(function(){

			var dari_akun = $("#dari_akun1").val();
			
			$.post('cek_jumlah_kas.php', {dari_akun: dari_akun}, function(data) {

				data = data.replace(/\s+/g, '');
			
			$("#jumlah_kas1").val(data);
			});

			$("#dari_akun1").change(function(){
			var dari_akun = $("#dari_akun1").val();
			
			//metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
			$.post('cek_jumlah_kas.php', {dari_akun: dari_akun}, function(data) {
			/*optional stuff to do after success */
			
		data = data.replace(/\s+/g, '');

			
			$("#jumlah_kas1").val(tandaPemisahTitik(data));
			});
			
			});
			});
			</script>
		<!--	
			<script>
			
			// untuk memunculkan jumlah kas secara otomatis
			$(document).ready(function(){
			$("#jumlah2").blur(function(){
			var jumlah = $("#jumlah2").val();
			var jumlah_kas = $("#jumlah_kas1").val();
			var sisa = jumlah_kas - jumlah;
			
			if (sisa < 0) 
			
			{
			$("#submit").hide();
			alert("Jumlah Kas Tidak Mencukupi");
			
			}
			else {
			$("#submit").show();
			}
			
			
			});
			
			});
			</script>
			-->
			<script>
			$(document).ready(function(){
			$("#ke_akun1").change(function(){
			var dari_akun = $("#dari_akun1").val();
			var ke_akun = $("#ke_akun1").val();
			
			if (ke_akun == dari_akun)
			{
			
			alert("Nama Akun Tidak Boleh Sama");
			$("#ke_akun1").val('');
			
			}
			
			});


			$("#dari_akun1").change(function(){
			var dari_akun = $("#dari_akun1").val();
			var ke_akun = $("#ke_akun1").val();
			
			if (ke_akun == dari_akun)
			{
			
			alert("Nama Akun Tidak Boleh Sama");
			$("#dari_akun1").val('');
			$("#jumlah_kas1").val('');
			
			}
			
			});

			});
			</script>

			<!-- Dari Form Kas Mutasi -->

			<script>
						
						$("#tambah").click(function() {
						
						$.get('no_faktur_KMT.php', function(data) {
							data = data.replace(/\s+/g, '');
						
						$("#tambah_faktur").val(data);
						});
						
						});

			</script>




<script type="text/javascript">
$(document).ready(function(){

//fungsi untuk menambahkan data
		$("#submit_tambah").click(function(){
		var tanggal = $("#tanggal1").val();
		var no_faktur = $("#tambah_faktur").val();
		var keterangan = $("#keterangan").val();
		var dari_akun = $("#dari_akun1").val();
		var ke_akun = $("#ke_akun1").val();
		var jumlah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah2").val()))));
		var sisa_kas = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_kas1").val()))));

		 sisa_kas = parseInt(sisa_kas,10) - parseInt(jumlah,10);

if (sisa_kas < 0) {

			alert("Total Kas Tidak Mencukupi !!");
			$("#jumlah2").val('');
			$("#jumlah2").focus();

}

else{


		
		if (tanggal == "") {

			alert("Silakan Isi Kolom Tanggal");
			$("#tanggal1").focus();
		}
		
		else if(ke_akun == ""){
			alert("Silakan Isi Kolom Ke Kas");
			$("#ke_akun1").focus();
		}
		else if(dari_akun == ""){
			alert("Silakan Isi Kolom Dari Kas");
			$("#dari_akun1").focus();
		}
		else if(jumlah == ""){

			alert("Silakan Isi Kolom Jumlah");
			$("#jumlah2").focus()
		}
		else{

		$.post('proses_kas_mutasi.php',{tanggal:tanggal,no_faktur:no_faktur,keterangan:keterangan,dari_akun:dari_akun,ke_akun:ke_akun,jumlah:jumlah},function(data){
		
		$('#table_mutasi').DataTable().destroy();
		      var dataTable = $('#table_mutasi').DataTable( {
		          "processing": true,
		          "serverSide": true,
		          "ajax":{
		            url :"datatable_kas_mutasi.php", // json datasource
		            type: "post",  // method  , by default get
		            error: function(){  // error handling
		              $(".employee-grid-error").html("");
		              $("#table_mutasi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
		              $("#employee-grid_processing").css("display","none");
		              
		            }
		          },
		            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
		              $(nRow).attr('class','tr-id-'+aData[13]+'');
		            },
		        })

		$("#tanggal1").val('');
		$("#tambah_faktur").val('');
		$("#keterangan").val(dari_akun1);
		$("#dari_akun1").val('');
		$("#ke_akun1").val('');
		$("#jumlah2").val('');
		$(".alert").show('fast');

		setTimeout(tutupalert, 100);
		$(".modal").modal("hide");
		
		});

		}
	function tutupmodal() {
		}
		}
		});

		});

		$('form').submit(function(){
		
		return false;
		});

// end fungsi tambah data
</script>



<script>
			
//fungsi hapus data 
$(document).ready(function(){	
		$(document).on('click','.btn-hapus',function(e){
		
		var id = $(this).attr("data-id");
		var no_faktur = $(this).attr("data-faktur");

		$("#hapus_no_faktur").val(no_faktur);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		
		var id = $(this).attr("data-id");
		var no_faktur = $("#hapus_no_faktur").val();

		$.post("hapus_kas_mutasi.php",{id:id, no_faktur:no_faktur},function(data){
		if (data != "") {

		

		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id).remove();
		
		}
		
		});
		});


//fungsi edit data 
		$(document).on('click','.btn-edit',function(e){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-satuan"); 
		var keterangan = $(this).attr("data-ket");
		var tanggal = $(this).attr("data-tanggal");
		var jumlah = $(this).attr("data-jumlah"); 
		var ke_akun = $(this).attr("data-ke-akun"); 
		var dari_akun = $(this).attr("data-dari-akun"); 
		var id  = $(this).attr("data-id");
		var no_faktur  = $(this).attr("data-faktur");

		$("#nama_edit").val(nama);
		$("#tanggal_edit").val(tanggal);
		$("#edit_jumlah_lama").val(jumlah);
		$("#edit_keterangan").val(keterangan);
		$("#edit_ke_akun").val(ke_akun);
		$("#edit_dari_akun").val(dari_akun);
		$("#id_edit").val(id);
		$("#faktur_edit").val(no_faktur);

				var dari_akun = $("#edit_dari_akun").val();			
					$.post('cek_jumlah_kas.php', {dari_akun: dari_akun}, function(data) {
					data = data.replace(/\s+/g, '');			
					$("#sisa_kas").val(data);	
				});
		
		});
		
		$("#submit_edit").click(function(){

		var jumlah_baru = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#edit_jumlah").val()))));
		var tanggal = $("#tanggal_edit").val();
		var jumlah = $("#edit_jumlah_lama").val();
		var ke_akun = $("#edit_ke_akun").val();
		var dari_akun = $("#edit_dari_akun").val();
		var keterangan = $("#edit_keterangan").val();
		var id = $("#id_edit").val();
		var no_faktur = $("#faktur_edit").val();
		var sisa_kas = $("#sisa_kas").val();
		var jumlah_t = parseInt(jumlah_baru,10);
		    sisa_kas = parseInt(sisa_kas,10) + parseInt(jumlah,10);

		var total_j = parseInt(sisa_kas,10) - parseInt(jumlah_t,10);

		if (total_j < 0) {
			alert("Total Kas Tidak Mencukupi !!");
			$("#edit_jumlah").val('');
			$("#edit_jumlah").focus();	
		}

		else{

			$.post("update_kas_mutasi.php",{no_faktur:no_faktur,tanggal:tanggal,jumlah_baru:jumlah_baru,jumlah:jumlah,ke_akun:ke_akun,dari_akun:dari_akun,keterangan:keterangan,id:id},function(data){

		
			$('#table_mutasi').DataTable().destroy();
		      var dataTable = $('#table_mutasi').DataTable( {
		          "processing": true,
		          "serverSide": true,
		          "ajax":{
		            url :"datatable_kas_mutasi.php", // json datasource
		            type: "post",  // method  , by default get
		            error: function(){  // error handling
		              $(".employee-grid-error").html("");
		              $("#table_mutasi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
		              $("#employee-grid_processing").css("display","none");
		              
		            }
		          },
		            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
		              $(nRow).attr('class','tr-id-'+aData[13]+'');
		            },
		        })

		$("#tanggal1").val('');
		$("#tambah_faktur").val('');
		$("#keterangan").val(dari_akun1);
		$("#dari_akun1").val('');
		$("#ke_akun1").val('');
		$("#jumlah2").val('');
		$(".alert").show('fast');

		setTimeout(tutupalert, 100);
		$(".modal").modal("hide");
		
		});

		}
	function tutupmodal() {
		}

		});
		


//end function edit data


		$('form').submit(function(){
		
		return false;
		});
		
		});
		
		
		
		
		function tutupalert() {
		$(".alert").hide("fast");

		}
		

</script>

<?php 
include 'footer.php';
 ?>