<?php 

    include 'sanitasi.php';
    include 'db.php';

     $nama = $_GET['nama'];


 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Otoritas </th>
			<th> Akses</th>
			<th> Fungsi </th>
			<th> Hapus </th>
			
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

			<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-akses='". $data['akses'] ."' data-fungsi='". $data['fungsi'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

			</tr>";
			}

				//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>

	 <script>
$(document).ready(function() {
        $(".table").dataTable({"ordering":false});
    });


</script>

<script type="text/javascript">
	
	$(document).on('click', '.btn-hapus', function (e) {

	var akses = $(this).attr("data-akses");
	var fungsi = $(this).attr("data-fungsi");
    var id = $(this).attr("data-id");
    $("#id_hapus").val(id);
    $("#nama_akses").val(akses);
    $("#fungsi_hapus").val(fungsi);
    $("#modal_hapus").modal('show');

	});

</script>