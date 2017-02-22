<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel jabatan
$query = $db->query("SELECT * FROM jurnal_trans WHERE jenis_transaksi = 'Jurnal Manual'  GROUP BY no_faktur");

$session_id = session_id();

 ?>


<div class="container"><!--tag yang digunakan untuk membuat tampilan form menjadi rapih dalam satu tempat-->

<h3><b> DATA TRANSAKSI JURNAL MANUAL </b></h3> <hr>

<?php
include 'db.php';

$pilih_akses_akuntansi = $db->query("SELECT * FROM otoritas_laporan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$akuntansi = mysqli_fetch_array($pilih_akses_akuntansi);

if ($akuntansi['transaksi_jurnal_manual_tambah'] > 0) {
// Trigger the modal with a button -->
echo '<a href="form_transaksi_jurnal_manual.php" class="btn btn-info" > <i class="fa fa-plus">  </i> Jurnal Manual </a>';
}
?>

<br>
<br>



<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Jurnal Manual</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     
     
     <label> Nomor Faktur :</label><br>
     <input type="text" id="jenis_transaksi" class="form-control" readonly="">  <br>

     <label> Jenis Transaksi :</label><br>
     <input type="text" id="no_jurnal" class="form-control" readonly="">


     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<style>


tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="tableuser" class="table table-bordered">
		<thead> 
			
			
<?php  
if ($akuntansi['transaksi_jurnal_manual_hapus'] > 0) {
			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
		}
?>

<?php 
if ($akuntansi['transaksi_jurnal_manual_edit'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
    }
 ?>			
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Jenis Transaksi</th>
			<th style='background-color: #4CAF50; color:white'> User Buat</th>
			<th style='background-color: #4CAF50; color:white'> User Edit</th>
			<th style='background-color: #4CAF50; color:white'> Waktu Jurnal </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan Jurnal </th>

		</thead>
		
		<tbody>
		<?php

		// menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{
				//menampilkan data
			
if ($akuntansi['transaksi_jurnal_manual_hapus'] > 0) {

			echo "<tr class='tr-id-".$data['id']."'>

			<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-jurnal='". $data['jenis_transaksi'] ."' data-faktur='". $data['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}

if ($akuntansi['transaksi_jurnal_manual_edit'] > 0) {
			echo "<td> <a href='proses_edit_jurnal_manual.php?no_faktur=". $data['no_faktur']."&session_id=". $session_id ."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";

	echo "
		<td>".$data['no_faktur']."</td>
		<td>".$data['jenis_transaksi']."</td>
		<td>".$data['user_buat']."</td>
		<td>".$data['user_edit']."</td>
		<td>".$data['waktu_jurnal']."</td>
		<td>".$data['keterangan_jurnal']."</td>

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
</div> <!-- tag penutup cantainer -->


							
<script>
    $(document).ready(function(){

	
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nomor_jurnal = $(this).attr("data-jurnal");
		var nomor_faktur = $(this).attr("data-faktur");
		var id = $(this).attr("data-id");
		$("#no_jurnal").val(nomor_jurnal);
		$("#jenis_transaksi").val(nomor_faktur);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("btn-id", id);
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var no_faktur = $("#jenis_transaksi").val();
		var id = $(this).attr("data-id");

		$.post("hapus_jurnal_trans.php",{id:id,no_faktur:no_faktur},function(data){

		if (data != "") {
		$("#table_baru").load('tabel-jurnal-manual.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

									

		function tutupmodal() {
		
		}	
		});
		


		$('form').submit(function(){
		
		return false;
		});
		


		function tutupalert() {
		$(".alert").hide("fast")
		}
		

</script>


<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>

<!-- memasukan file footer.db -->
<?php include 'footer.php'; ?>
