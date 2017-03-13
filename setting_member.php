<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT lama_tidak_aktif,aktif_kembali,satuan_tidak_aktif , id FROM setting_member");

 ?>

  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">

<h3><b> SETTING MEMBER </b></h3><hr>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'> Lama Tidak Aktif  </th>

			<th style='background-color: #4CAF50; color: white'> Satuan Lama Tidak Aktif </th>

			<th style='background-color: #4CAF50; color: white'> Aktif Kembali </th>
		
		</thead>
		
		<tbody>
		<?php
			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>
			<td class='edit-lama' data-id='".$data1['id']."'><span id='text-lama-".$data1['id']."'>". $data1['lama_tidak_aktif'] ."</span>
			<input type='hidden' data-id='".$data1['id']."' data-lama='".$data1['lama_tidak_aktif']."' class='edit-lama' id='input-lama-".$data1['id']."' autofocus='' value='".$data1['lama_tidak_aktif']."'></td>";

 			if ($data1['satuan_tidak_aktif'] == 1) {
				$satuan_tidak_aktif = "Bulan";
			}
			else if ($data1['satuan_tidak_aktif'] == 2) {
				$satuan_tidak_aktif = "Tahun";
			}

				echo"<td class='edit-satuan' data-id='".$data1['id']."'><span id='text-satuan-".$data1['id']."'>".$satuan_tidak_aktif."</span>
			      <select style='display:none' id='select-satuan-".$data1['id']."' data-satuan=".$data1['satuan_tidak_aktif']." class='select-satuan' data-id='".$data1['id']."' autofocus=''>";
			      
			      echo '<option value="1">Bulan</option>';

			      echo '<option value="2">Tahun</option>';

			      echo  '</select>
			      </td>';

			echo"<td class='edit-kembali' data-id='".$data1['id']."'><span id='text-kembali-".$data1['id']."'>". $data1['aktif_kembali'] ." Kali Belanja</span><input type='hidden' data-id='".$data1['id']."' data-kembali='".$data1['aktif_kembali']."' class='edit-kembali' id='input-kembali-".$data1['id']."' autofocus='' value='".$data1['aktif_kembali']."' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'></td>
			</tr>";
		
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>

					</tbody>

	</table>
</div>
</div>


<script type="text/javascript">

								$(document).on('dblclick', '.edit-lama', function (e) {

									var id = $(this).attr("data-id");
									$("#text-lama-"+id).hide();
									$("#input-lama-"+id).attr("type","text");
								
								});
								
								$(document).on('blur', '.edit-lama', function (e) {
								
								var id = $(this).attr("data-id");
								var lama_tidak_aktif = $(this).attr("data-lama");
								var lama_tidak_aktif1 = $("#input-lama-"+id).val();
								var jenis_edit = "edit-lama-tidak-aktif";
								
								$.post("edit_setting_member.php",{id:id,lama_tidak_aktif1:lama_tidak_aktif1,jenis_edit:jenis_edit},function(data){
								$("#text-lama-"+id).show();
								$("#text-lama-"+id).text(lama_tidak_aktif1);
	
								$("#input-lama-"+id).val(lama_tidak_aktif1);
								$("#input-lama-"+id).attr("type","hidden");				
								
								});
								
								});


								$(document).on('dblclick', '.edit-satuan', function (e) {

								var id = $(this).attr("data-id");

								$("#text-satuan-"+id).hide();
								$("#select-satuan-"+id).show();
								
								});
								
								$(document).on('blur', '.edit-satuan', function (e) {
								
								var id = $(this).attr("data-id");
								var satuan_lama = $(this).attr("data-satuan");
								var satuan = $("#select-satuan-"+id).val();
								var jenis_edit = "satuan";
								
								$.post("edit_setting_member.php",{id:id,satuan:satuan,jenis_edit:jenis_edit},function(data){


								if (satuan == 1) {
									satuan_baru = "Bulan";
								}
								else if (satuan == 2) {
									satuan_baru = "Tahun";
								}
								
								$("#text-satuan-"+id).text(satuan_baru);	
								$("#text-satuan-"+id).show();	
								$("#select-satuan-"+id).val(satuan);
								$("#select-satuan-"+id).hide();				
								
								});
								
								});


								$(document).on('dblclick', '.edit-kembali', function (e) {

									var id = $(this).attr("data-id");
									$("#text-kembali-"+id).hide();
									$("#input-kembali-"+id).attr("type","text");
								
								});
								
								$(document).on('blur', '.edit-kembali', function (e) {
								
								var id = $(this).attr("data-id");
								var aktif_kembali = $("#input-kembali-"+id).val();
								var jenis_edit = "aktif_kembali";
								
								$.post("edit_setting_member.php",{id:id,aktif_kembali:aktif_kembali,jenis_edit:jenis_edit},function(data){

								$("#text-kembali-"+id).show();
								$("#text-kembali-"+id).text(aktif_kembali + " Kali Belanja");
								$("#input-kembali-"+id).val(aktif_kembali);
								$("#input-kembali-"+id).attr("type","hidden");				
								
								});
								
								});


</script>



		<script>
		
		$(document).ready(function(){
		$('#tableuser').dataTable();
		});
		</script>

<?php 
include 'footer.php';
 ?>	