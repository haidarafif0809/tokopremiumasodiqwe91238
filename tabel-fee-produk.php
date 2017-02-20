<?php session_start();


include 'sanitasi.php';
include 'db.php';
$session_id = session_id();
//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM fee_produk");

 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'> Nama Petugas </th>
			<th style='background-color: #4CAF50; color: white'> Kode Produk</th>
			<th style='background-color: #4CAF50; color: white'> Nama Produk </th>
			<th style='background-color: #4CAF50; color: white'> Jumlah Prosentase </th>
			<th style='background-color: #4CAF50; color: white'> Jumlah Nominal </th>
			<th style='background-color: #4CAF50; color: white'> User Buat </th>

<?php
include 'db.php';

$pilih_akses_fee_produk_edit = $db->query("SELECT komisi_produk_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND komisi_produk_edit = '1'");
$fee_produk_edit = mysqli_num_rows($pilih_akses_fee_produk_edit);

    if ($fee_produk_edit > 0) {						
			echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
		}
		?>

<?php
include 'db.php';

$pilih_akses_fee_produk_hapus = $db->query("SELECT komisi_produk_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND komisi_produk_hapus = '1'");
$fee_produk_hapus = mysqli_num_rows($pilih_akses_fee_produk_hapus);

    if ($fee_produk_hapus > 0) {
			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";
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
			<td>". $data1['nama_petugas'] ."</td>
			<td>". $data1['kode_produk'] ."</td>
			<td>". $data1['nama_produk'] ."</td>
			<td>". persen($data1['jumlah_prosentase']) ."</td>
			<td>". rp($data1['jumlah_uang']) ."</td>
			<td>". $data1['user_buat'] ."</td>";


include 'db.php';

$pilih_akses_fee_produk_edit = $db->query("SELECT komisi_produk_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND komisi_produk_edit = '1'");
$fee_produk_edit = mysqli_num_rows($pilih_akses_fee_produk_edit);

    if ($fee_produk_edit > 0) {
			echo "<td> <button class='btn btn-success btn-edit' data-prosentase='". $data1['jumlah_prosentase'] ."' data-nominal='". $data1['jumlah_uang'] ."' data-id='". $data1['id'] ."' > <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
		}

include 'db.php';

$pilih_akses_fee_produk_hapus = $db->query("SELECT komisi_produk_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND komisi_produk_hapus = '1'");
$fee_produk_hapus = mysqli_num_rows($pilih_akses_fee_produk_hapus);

    if ($fee_produk_hapus > 0) {

			 echo " <td> <button class='btn btn-danger btn-hapus' data-id='".$data1['id']."' data-petugas='". $data1['nama_petugas'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button></td>
			
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
	$('#tableuser').DataTable();
	});

</script>

  <script>
    
  //fungsi hapus data 
    $(".btn-hapus").click(function(){
    var nama_petugas = $(this).attr("data-petugas");
    var id = $(this).attr("data-id");
    $("#data_petugas").val(nama_petugas);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });


    $("#btn_jadi_hapus").click(function(){
    
    var id = $("#id_hapus").val();
    $.post("hapus_fee_produk.php",{id:id},function(data){

    
    $("#tabel_baru").load('tabel-fee-produk.php');
    $("#modal_hapus").modal('hide');
    
   

    
    });
    
    });
// end fungsi hapus data


//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var prosentase = $(this).attr("data-prosentase");
		var nominal = $(this).attr("data-nominal");  
		var id  = $(this).attr("data-id");
		$("#prosentase_edit").val(prosentase);
		$("#nominal_edit").val(nominal);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var prosentase = $("#prosentase_edit").val();
		var nominal = $("#nominal_edit").val();
		var id = $("#id_edit").val();

		$.post("update_fee_produk.php",{jumlah_prosentase:prosentase,jumlah_uang:nominal,id:id},function(data){
		if (data != '') {
		$(".alert").show('fast');
		$("#tabel_baru").load('tabel-fee-produk.php');
		 $("#modal_edit").modal('hide');

		
		}
		});
		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});
	


</script>

<script type="text/javascript">
	
	          $("#nominal_edit").keyup(function(){
              var nominal_edit = $("#nominal_edit").val();
              var prosentase_edit = $("#prosentase_edit").val();
              
              if (nominal_edit == "") 
              {
              $("#prosentase").show();
              }
              
              else
              {
              $("#prosentase").hide();
              }
              
              
              
              });
											
											$("#prosentase_edit").keyup(function(){
											var prosentase_edit = $("#prosentase_edit").val();
											var nominal_edit = $("#nominal_edit").val();
											

											if (prosentase_edit > 100)
											{
											
											alert("Jumlah Prosentase Melebihi ??");
											$("#prosentase_edit").val('');
											}

											else if (prosentase_edit == "") 
											{
											$("#nominal").show();
											}
											
											else
											{
											$("#nominal").hide();
											}
											
											
											
											});

</script>