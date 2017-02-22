<?php include_once 'session_login.php';
 

// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'db.php';
include 'sanitasi.php';

 
// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB
 $perintah = $db->query("SELECT * FROM grup_akun ORDER BY id DESC");

 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Kode Group Akun </th>
			<th> Nama Group Akun </th>
			<th> Dari Sub </th>
			<th> Kategori Akun</th>
			<th> Tipe Akun </th>
			<th> User Buat</th>
			<th> User Edit </th>
			<th> Waktu </th>

<?php 
include 'db.php';

$pilih_akses_satuan_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Daftar Group Akun'");
$satuan_hapus = mysqli_num_rows($pilih_akses_satuan_hapus);


    if ($satuan_hapus > 0){
			echo "<th> Hapus </th>";

		}
?>

<?php 
include 'db.php';

$pilih_akses_satuan_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Daftar Group Akun'");
$satuan_edit = mysqli_num_rows($pilih_akses_satuan_edit);


    if ($satuan_edit > 0){
			echo "<th> Edit </th>";
		}
?>
			
		</thead>
		
		<tbody>
		<?php

		
			while ($data = mysqli_fetch_array($perintah))
			{
			echo "<tr>
			<td>". $data['kode_grup_akun'] ."</td>
			<td>". $data['nama_grup_akun'] ."</td>
			<td>". $data['parent'] ."</td>
			<td>". $data['kategori_akun'] ."</td>
			<td>". $data['tipe_akun'] ."</td>
			<td>". $data['user_buat'] ."</td>
			<td>". $data['user_edit'] ."</td>
			<td>". $data['waktu'] ."</td>";


include 'db.php';

$pilih_akses_satuan_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Daftar Group Akun'");
$satuan_hapus = mysqli_num_rows($pilih_akses_satuan_hapus);


    if ($satuan_hapus > 0){
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-satuan='". $data['nama_grup_akun'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}

include 'db.php';

$pilih_akses_satuan_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Daftar Group Akun'");
$satuan_edit = mysqli_num_rows($pilih_akses_satuan_edit);


    if ($satuan_edit > 0){
			

			echo "<td><button class='btn btn-success btn-edit' data-satuan='". $data['nama_grup_akun'] ."' data-id='". $data['id'] ."' > <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

			</tr>";
		}
			}

				//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>

		<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable(
			{"ordering": false});
		});
		</script>


<script type="text/javascript">
	//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama_group = $(this).attr("data-satuan");
		var id = $(this).attr("data-id");
		$("#nama_group").val(nama_group);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();
		$.post("hapus_group_akun.php",{id:id},function(data){
		if (data != "") {
		$("#table-baru").load('tabel-group-akun.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

	$("form").submit(function(){
    return false;
    
    });

</script>