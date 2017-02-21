<?php session_start();


include 'sanitasi.php';
include 'db.php';

$session_id = session_id();
//menampilkan seluruh data yang ada pada tabel pelanggan
$query = $db->query("SELECT * FROM pelanggan");

 ?>



<table id="tableuser" class="table table-bordered">
		<thead>
			
			<th style='background-color: #4CAF50; color: white'> Kode Pelanggan </th>
			<th style='background-color: #4CAF50; color: white'> Nama Pelanggan </th>
			<th style='background-color: #4CAF50; color: white'> Level Harga </th>
			<th style='background-color: #4CAF50; color: white'> Tgl. Lahir </th>
			<th style='background-color: #4CAF50; color: white'> Nomor Telp </th>
			<th style='background-color: #4CAF50; color: white'> E-mail </th>
			<th style='background-color: #4CAF50; color: white'> Wilayah</th>

<?php 

include 'db.php';

$pilih_akses_pelanggan_hapus = $db->query("SELECT pelanggan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_hapus = '1'");
$pelanggan_hapus = mysqli_num_rows($pilih_akses_pelanggan_hapus);


    if ($pelanggan_hapus > 0){

			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";

		}
?>


<?php 
include 'db.php';

$pilih_akses_pelanggan_edit = $db->query("SELECT pelanggan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_edit = '1'");
$pelanggan_edit = mysqli_num_rows($pilih_akses_pelanggan_edit);


    if ($pelanggan_edit > 0){
    	echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
    }

 ?>
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{
				//menampilkan data
			echo "<tr>
			
			<td>". $data['kode_pelanggan'] ."</td>
			<td>". $data['nama_pelanggan'] ."</td>
			<td>". $data['level_harga'] ."</td>
			<td>". tanggal($data['tgl_lahir']) ."</td>
			<td>". $data['no_telp'] ."</td>
			<td>". $data['e_mail'] ."</td>
			<td>". $data['wilayah'] ."</td>";
			


include 'db.php';

$pilih_akses_pelanggan_hapus = $db->query("SELECT pelanggan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_hapus = '1'");
$pelanggan_hapus = mysqli_num_rows($pilih_akses_pelanggan_hapus);


    if ($pelanggan_hapus > 0){


			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-pelanggan='". $data['nama_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";

		}

include 'db.php';

$pilih_akses_pelanggan_edit = $db->query("SELECT pelanggan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_edit = '1'");
$pelanggan_edit = mysqli_num_rows($pilih_akses_pelanggan_edit);


    if ($pelanggan_edit > 0){
			echo "<td> <button class='btn btn-info btn-edit' data-pelanggan='". $data['nama_pelanggan'] ."' data-kode='". $data['kode_pelanggan'] ."' data-tanggal='". $data['tgl_lahir'] ."' data-nomor='". $data['no_telp'] ."' data-email='". $data['e_mail'] ."' data-wilayah='". $data['wilayah'] ."' data-level-harga='". $data['level_harga'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
		}

			echo"</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
			
		?>
		</tbody>

	</table>

		<script>
		//untuk menampilkan data tabel
		$(document).ready(function(){
		$('.table').dataTable();
		});
		
		</script>

<script type="text/javascript">
                             
								$(document).ready(function(){

					//fungsi hapus data 
								$(document).on('click', '.btn-hapus', function (e) {
								var nama_pelanggan = $(this).attr("data-pelanggan");
								var id = $(this).attr("data-id");
								$("#data_pelanggan").val(nama_pelanggan);
								$("#id_hapus").val(id);
								$("#modal_hapus").modal('show');
								
								
								});
								
								
								$("#btn_jadi_hapus").click(function(){
								
								var id = $("#id_hapus").val();
								
								$.post("hapus_pelanggan.php",{id:id},function(data){
								if (data == "sukses") {
								$("#table_baru").load('tabel-pelanggan.php');
								$("#modal_hapus").modal('hide');
								
								}
								
								
								});
								
								});
					// end fungsi hapus data

				    //fungsi edit data 
								$(document).on('click', '.btn-edit', function (e) {
								
								$("#modal_edit").modal('show');
								var nama = $(this).attr("data-pelanggan");
								var kode = $(this).attr("data-kode");
								var tanggal   = $(this).attr("data-tanggal");
								var nomor = $(this).attr("data-nomor");
								var email   = $(this).attr("data-email");
								var wilayah = $(this).attr("data-wilayah");
								var id   = $(this).attr("data-id");
								$("#edit_nama").val(nama);
								$("#edit_kode").val(kode);
								$("#edit_tgl_lahir").val(tanggal);
								$("#edit_nomor").val(nomor);
								$("#edit_email").val(email);
								$("#edit_wilayah").val(wilayah);
								$("#id_edit").val(id);
								
								
								});

								$('form').submit(function(){
								
								return false;
								});
								
								});
								
								
								
								
								function tutupalert() {
								$(".alert").hide("fast")
								}
								</script>