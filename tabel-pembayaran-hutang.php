<?php 

include 'sanitasi.php';
include 'db.php';


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM pembayaran_hutang ORDER BY id DESC");




 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color:white"> Detail </th>

<?php

if ($pembayaran_hutang['pembayaran_hutang_edit'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
?>

<?php

if ($pembayaran_hutang['pembayaran_hutang_hapus'] > 0) {

    	echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}
?>
			
			
			<th style="background-color: #4CAF50; color:white"> Cetak </th>
			<th style="background-color: #4CAF50; color:white"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color:white"> Tanggal </th>
			<th style="background-color: #4CAF50; color:white"> Jam </th>
			<th style="background-color: #4CAF50; color:white"> Nama Suplier </th>
			<th style="background-color: #4CAF50; color:white"> Keterangan </th>
			<th style="background-color: #4CAF50; color:white"> Total </th>
			<th style="background-color: #4CAF50; color:white"> User Buat </th>
			<th style="background-color: #4CAF50; color:white"> User Edit </th>
			<th style="background-color: #4CAF50; color:white"> Tanggal Edit </th>
			<th style="background-color: #4CAF50; color:white"> Dari Kas </th>
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr class='tr-id-".$data1['id']."'>

			<td> <button class=' btn btn-info detail' no_faktur_pembayaran='". $data1['no_faktur_pembayaran'] ."'> <i class='fa fa-list-ol'>Detail</i>  </button> </td>";




if ($pembayaran_hutang['pembayaran_hutang_edit'] > 0) {

		echo "<td> <a href='proses_edit_pembayaran_hutang.php?no_faktur_pembayaran=". $data1['no_faktur_pembayaran']."&nama=". $data1['nama']."' class='btn btn-success'> <i class='fa fa-edit'>Edit</i>  </a> </td>";

	}



if ($pembayaran_hutang['pembayaran_hutang_hapus'] > 0) {

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-suplier='". $data1['nama'] ."' data-no_faktur_pembayaran='". $data1['no_faktur_pembayaran'] ."'> <i class='fa fa-trash'>Hapus</i>  </button> </td>";
			} 

			echo "<td> <a href='cetak_lap_pembayaran_hutang.php?no_faktur_pembayaran=".$data1['no_faktur_pembayaran']."&nama_suplier=".$data1['nama']."' class='btn btn-primary' target='blank'><i class='fa fa-print'>Cetak Hutang</i>  </a> </td>
			<td>". $data1['no_faktur_pembayaran'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['user_buat'] ."</td>
			<td>". $data1['user_edit'] ."</td>
			<td>". $data1['tanggal_edit'] ."</td>
			<td>". $data1['nama_daftar_akun'] ."</td>
			
			</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
			
		?>
		</tbody>

	</table>

	 <script type="text/javascript">
			
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var suplier = $(this).attr("data-suplier");
		var id = $(this).attr("data-id");
		$("#suplier").val(suplier);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();
		$.post("hapus_data_pembayaran_hutang.php",{id:id},function(data){
		if (data != "") {
		$("#table_baru").load('tabel-pembayaran-hutang.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		
		});

		</script>

		<script type="text/javascript">

					// untk menampilkan datatable atau filter seacrh
					$(document).ready(function(){
					$('table').DataTable({"ordering":false});
					});

		</script>