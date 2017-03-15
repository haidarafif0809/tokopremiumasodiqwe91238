<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT poin_rp,nilai_poin , id FROM aturan_poin");

 ?>

  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">

<h3><b> SETTING POIN </b></h3><hr>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'> Poin </th>

			<th style='background-color: #4CAF50; color: white'> Nilai Poin (Rp)</th>
		
		</thead>
		
		<tbody>
		<?php
			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>
			<td class='edit-nilai-poin' data-id='".$data1['id']."'><span id='text-nilai-poin-".$data1['id']."'>". rp($data1['nilai_poin']) ."</span>
			<input type='hidden' data-id='".$data1['id']."' data-poin='".$data1['nilai_poin']."' class='edit-nilaipoin' id='input-nilai-poin-".$data1['id']."' autofocus='' value='".$data1['nilai_poin']."' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'>
			</td>

			<td class='edit-poin-rp' data-id='".$data1['id']."'><span id='text-poin-rp-".$data1['id']."'>". rp($data1['poin_rp']) ."</span>
			<input type='hidden' data-id='".$data1['id']."' data-poin='".$data1['poin_rp']."' class='edit-poinrp' id='input-poin-".$data1['id']."' autofocus='' value='".$data1['poin_rp']."' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'>
			</td>
			</tr>";
		
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>

					</tbody>

	</table>

</div>
 <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom poin jika ingin mengedit.</i></h6>
</div>


<script type="text/javascript">

							$(document).on('dblclick', '.edit-poin-rp', function (e) {

								var id = $(this).attr("data-id");

								$("#text-poin-rp-"+id).hide();
								$("#input-poin-"+id).attr("type","text");
								
								});
								
								$(document).on('blur', '.edit-poinrp', function (e) {
								
								var id = $(this).attr("data-id");
								var poin_lama = $(this).attr("data-poin");
								var poin_baru = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).val()))));
								var jenis_edit = "edit-poin-rp";
								
								$.post("edit_aturan_poin.php",{id:id,poin_baru:poin_baru,jenis_edit:jenis_edit},function(data){
								
								$("#text-poin-rp-"+id).text(tandaPemisahTitik(poin_baru));	
								$("#text-poin-rp-"+id).show();	
								$("#input-poin-"+id).val(tandaPemisahTitik(poin_baru));
								$("#input-poin-"+id).attr("type","hidden");				
								
								});
								
								});



								$(document).on('dblclick', '.edit-nilai-poin', function (e) {

									var id = $(this).attr("data-id");
									$("#text-nilai-poin-"+id).hide();
									$("#input-nilai-poin-"+id).attr("type","text");
								
								});
								
								$(document).on('blur', '.edit-nilaipoin', function (e) {
								
								var id = $(this).attr("data-id");
								var poin_lama = $(this).attr("data-poin");
								var poin_baru = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).val()))));
								var jenis_edit = "edit-nilai-poin";
								
								$.post("edit_aturan_poin.php",{id:id,poin_baru:poin_baru,jenis_edit:jenis_edit},function(data){
								
								$("#text-nilai-poin-"+id).text(tandaPemisahTitik(poin_baru));	
								$("#text-nilai-poin-"+id).show();	
								$("#input-nilai-poin-"+id).val(tandaPemisahTitik(poin_baru));
								$("#input-nilai-poin-"+id).attr("type","hidden");				
								
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