<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM perusahaan");

 ?>

  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">

<h3><b> DATA PERUSAHAAN </b></h3><hr>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered btn-sm">
		<thead>
			<th style='background-color: #4CAF50; color: white'> Nama Perusahaan</th>
			<th style='background-color: #4CAF50; color: white'> Alamat Perusahaan</th>
			<th style='background-color: #4CAF50; color: white'> Singkatan Perusahaan </th>
			<th style='background-color: #4CAF50; color: white'> Foto </th>
			<th style='background-color: #4CAF50; color: white'> Nomor Telepon </th>
			<th style='background-color: #4CAF50; color: white'> Nomor Fax </th>
			<th style='background-color: #4CAF50; color: white'> Setting PPN </th>
			<th style='background-color: #4CAF50; color: white'> Pajak (%)</th>

<?php
include 'db.php';

$pilih_akses_perusahaan_edit = $db->query("SELECT set_perusahaan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND set_perusahaan_edit = '1'");
$perusahaan_edit = mysqli_num_rows($pilih_akses_perusahaan_edit);

    if ($perusahaan_edit > 0) {	
			echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
	}
	?>

			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>
			<td>". $data1['nama_perusahaan'] ."</td>
			<td>". $data1['alamat_perusahaan'] ."</td>
			<td>". $data1['singkatan_perusahaan'] ."</td>
			<td><img src='save_picture/". $data1['foto'] ."' height='30px' width='40px'></td>
			<td>". $data1['no_telp'] ."</td>
			<td>". $data1['no_fax'] ."</td>";

			if ($data1['setting_ppn'] == 'Include') {
				echo"<td class='edit-ppn' data-id='".$data1['id']."'><span id='text-ppn-".$data1['id']."'>Include</span><select style='display:none' id='select-ppn-".$data1['id']."' value='Include' class='select-ppn' data-id='".$data1['id']."' autofocus=''>";

				echo '<option>Include</option>';
				echo '<option>Exclude</option>';
				echo '<option>Non</option>';
			}
			elseif ($data1['setting_ppn'] == 'Exclude') {
				echo"<td class='edit-ppn' data-id='".$data1['id']."'><span id='text-ppn-".$data1['id']."'>Exclude</span><select style='display:none' id='select-ppn-".$data1['id']."' value='Exclude' class='select-ppn' data-id='".$data1['id']."' autofocus=''>";

				echo '<option>Exclude</option>';
				echo '<option>Non</option>';
				echo '<option>Include</option>';				
			}
			else{
				echo"<td class='edit-ppn' data-id='".$data1['id']."'><span id='text-ppn-".$data1['id']."'>Non</span><select style='display:none' id='select-ppn-".$data1['id']."' value='Non' class='select-ppn' data-id='".$data1['id']."' autofocus=''>";

				echo '<option>Non</option>';
				echo '<option>Include</option>';
				echo '<option>Exclude</option>';
			}

				echo "<td style='font-size:15px;cursor:pointer;' align='left' class='edit-nilai' data-id='".$data1['id']."' > <span id='text-jumlah-".$data1['id']."'>".$data1['nilai_ppn']."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['nilai_ppn']."' class='input_jumlah_jual' data-id='".$data1['id']."' autofocus=''> </td>";

include 'db.php';

$pilih_akses_perusahaan_edit = $db->query("SELECT set_perusahaan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND set_perusahaan_edit = '1'");
$perusahaan_edit = mysqli_num_rows($pilih_akses_perusahaan_edit);

    if ($perusahaan_edit > 0) {	
			echo "<td> <a href='edit_perusahaan.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a> </td>
			</tr>";
		}
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>

					</tbody>

	</table>
</div>

                <h6 style="text-align: left ; color: red"><i><b> * Klik 2x pada kolom Setting PPN untuk merubah default PPN. </b></i></h6>
</div>

<script>
$(document).ready(function(){
	$('#tableuser').dataTable();
});
</script>

<script type="text/javascript">                                 
	$(".edit-ppn").dblclick(function(){

		var id = $(this).attr("data-id");

		$("#text-ppn-"+id+"").hide();
		$("#select-ppn-"+id+"").show();

	});

	$(".select-ppn").blur(function(){

		var id = $(this).attr("data-id");
		var select_ppn = $(this).val();

		$.post("update_setting_ppn.php",{id:id, select_ppn:select_ppn,jenis_select:"ppn"},function(data){

			if (select_ppn == 'Include'){
				select_ppn = 'Include';
			}
			else if (select_ppn == 'Exclude') {
				select_ppn = 'Exclude'
			}
			else{
				select_ppn = 'Non';
			}

			$("#text-ppn-"+id+"").show();
			$("#text-ppn-"+id+"").text(select_ppn);
			$("#select-ppn-"+id+"").hide();           

		});
	});
</script>

<script type="text/javascript">
	$(document).on('dblclick','.edit-nilai',function(e){
		var id = $(this).attr("data-id");

        $("#text-jumlah-"+id+"").hide();
        $("#input-jumlah-"+id+"").attr('type','text');

    });

	$(document).on('blur','.input_jumlah_jual',function(e){

                                    var id = $(this).attr("data-id");
                                    var input_tampil = $(this).val();


                                    $.post("update_nilai_ppn.php",{id:id,input_tampil:input_tampil},function(data){
                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(input_tampil);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 

                                    });
	});
</script>

<?php 
include 'footer.php';
 ?>