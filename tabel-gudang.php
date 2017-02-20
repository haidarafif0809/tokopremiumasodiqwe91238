<?php session_start();

include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

$query = $db->query("SELECT * FROM gudang");



 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white"> Kode Gudang </th>
			<th style="background-color: #4CAF50; color: white"> Nama Gudang </th>

<?php

include 'db.php';

$pilih_akses_otoritas = $db->query("SELECT gudang_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND gudang_hapus = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo '<th style="background-color: #4CAF50; color: white"> Hapus </th>';
}
?>
		</thead>
		
		<tbody>
		<?php

		
			while ($data = mysqli_fetch_array($query))
			{
			echo "<tr class='tr-id-". $data['id'] ."'>
			<td>". $data['kode_gudang'] ."</td>
			<td class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['nama_gudang'] ."</span> <input type='hidden' id='input-nama-".$data['id']."' value='".$data['nama_gudang']."' class='input_nama' data-id='".$data['id']."' autofocus='' > </td>";

$pilih_akses_otoritas = $db->query("SELECT gudang_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND gudang_hapus = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-gudang='". $data['kode_gudang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}			

			echo "</tr>";
		
			}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
			
		?>
		</tbody>

	</table>




<script>
	    $(document).ready(function(){
		  $(document).on('click', '.btn-hapus', function (e) {

		var id = $(this).attr("data-id");

		$.post("hapus_gudang.php",{id:id},function(data){

		

		$(".tr-id-"+id+"").remove();
		
		
		
		});
		
		});

		$('form').submit(function(){
		
		return false;
		});

	});
		


</script>


                             <script type="text/javascript">
                                 
                                 $(".edit-nama").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-nama-"+id+"").hide();

                                    $("#input-nama-"+id+"").attr("type", "text");

                                 });

                                 $(".input_nama").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var input_nama = $(this).val();


                                     $.post("update_gudang.php",{id:id, input_nama:input_nama ,jenis_nama:"nama_gudang"},function(data){

                                    $("#text-nama-"+id+"").show();
                                    $("#text-nama-"+id+"").text(input_nama);

                                    $("#input-nama-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>




