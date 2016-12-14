<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Kode Group Akun </th>
			<th> Nama Group Akun </th>
			<th> Dari Sub </th>

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
			<td>". $data['nama_grup_akun'] ."</td>
			<td>". $data['nama_grup_akun'] ."</td>
			<td>". $data['sub_dari'] ."</td>";


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