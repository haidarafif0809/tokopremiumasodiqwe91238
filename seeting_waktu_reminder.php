<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>


  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">


<h3><b> SETTING WAKTU REMINDER </b></h3><hr>
<div class="table-responsive">
<span id="tabel_baru">
<table id="tableuser" class="table table-bordered table-sm">
		<thead>
			<th style='background-color: #4CAF50; color: white'>Waktu</th>
			<th style='background-color: #4CAF50; color: white'>Satuan</th>			
		</thead>
		
		<tbody>
		<?php
			$perintah = $db->query("SELECT * FROM setting_waktu_reminder");
			//menyimpan data sementara yang ada pada $perintah
			while ($data = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>

			<td class='edit-waktu' data-id='".$data['id']."'><span id='text-waktu-".$data['id']."'>". rp($data['waktu']) ."</span> <input type='hidden' id='input-waktu-".$data['id']."' value='".$data['waktu']."' class='input_waktu' data-id='".$data['id']."' autofocus=''> </td>

			<td>". $data['satuan'] ."</td>";
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>

					</tbody>

	</table>
	</span>


</div>

<h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom Waktu jika ingin mengedit.</i></h6>
</div>

<script>
	$(document).ready(function(){
		$('#tableuser').dataTable();
	});
</script>

<script type="text/javascript">
$(".edit-waktu").dblclick(function(){

	var id = $(this).attr("data-id");

		$("#text-waktu-"+id+"").hide();

		$("#input-waktu-"+id+"").attr("type", "text");

});

$(".input_waktu").blur(function(){

	var id = $(this).attr("data-id");
	var input_waktu = $(this).val();

	$.post("update_waktu_reminder.php",{id:id,input_waktu:input_waktu},function(data){

		$("#text-waktu-"+id+"").show();
		$("#text-waktu-"+id+"").text(input_waktu);

		$("#input-waktu-"+id+"").attr("type", "hidden");           

	});
});
</script>

<?php 
	include 'footer.php';
?>