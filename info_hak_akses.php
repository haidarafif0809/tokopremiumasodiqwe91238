<?php include 'session_login.php';

include 'header.php';
include 'sanitasi.php';
include 'db.php';


$nama = $_POST['nama'];





?>

					

<table id="table" class="table table-bordered">
		<thead>
			<th> Otoritas </th>
			<th> Akses</th>
			<th> Fungsi </th>

		</thead>
		
		<tbody>
		<?php

			$hasil_akses = $db->query("SELECT * FROM akses WHERE otoritas = '$nama'");
			while ($data = mysqli_fetch_array($hasil_akses))
			{
			echo "<tr>

			<td>". $data['otoritas'] ."</td>
			<td>". $data['akses'] ."</td>
			<td>". $data['fungsi'] ."</td>
			<tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   
		?>
		</tbody>

	</table>


<script type="text/javascript">
	
  $(document).ready(function() {
  $(".table").dataTable({ordering :false });
  });

</script>

