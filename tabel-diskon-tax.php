<?php session_start();


include 'sanitasi.php';
include 'db.php';
$session_id = session_id();
//menampilkan seluruh data yang ada pada tabel penjualan
$ambil_data = $db->query("SELECT * FROM setting_diskon_tax");
$data = mysqli_fetch_array($ambil_data);

 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'>Diskon Nominal</th>
			<th style='background-color: #4CAF50; color: white'>Diskon Persen</th>
			<!--
			<th style='background-color: #4CAF50; color: white'>Pajak</th>
			-->

<?php
include 'db.php';

$pilih_akses_diskon_tax = $db->query("SELECT set_diskon_tax_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND set_diskon_tax_edit = '1'");
$diskon_tax = mysqli_num_rows($pilih_akses_diskon_tax);

    if ($diskon_tax > 0) {	
			echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";

		}
		?>
			
		</thead>
		
		<tbody>
		<?php
			$perintah = $db->query("SELECT * FROM setting_diskon_tax");
			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>
			<td>". rp($data1['diskon_nominal']) ."</td>
			<td>". persen($data1['diskon_persen']) ."</td>";
			/*
			<td>". persen($data1['tax']) ."</td>
			*/


include 'db.php';

$pilih_akses_perusahaan_edit = $db->query("SELECT set_diskon_tax_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND set_diskon_tax_edit = '1'");
$perusahaan_edit = mysqli_num_rows($pilih_akses_perusahaan_edit);

    if ($perusahaan_edit > 0) {	
			 echo "<td> <button class='btn btn-info btn-edit' data-nominal='". $data1['diskon_nominal'] ."' data-id='". $data1['id'] ."'  data-persen='". $data1['diskon_persen'] ."'  data-tax='". $data1['tax'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
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
		$('#tableuser').dataTable();
		});
		</script>

		<script type="text/javascript">
			//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nominal = $(this).attr("data-nominal"); 
		var persen  = $(this).attr("data-persen");
		var tax = $(this).attr("data-tax"); 
		var id  = $(this).attr("data-id");
		

		$("#tax_edit").val(tax);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nominal = $("#nominal_edit").val();
		var persen = $("#persen_edit").val();
		var tax = $("#tax_edit").val();
		var id = $("#id_edit").val();



		if (nominal < 0){
			alert("Diskon Nominal Harus Diisi");
		}
		else if (persen < 0 || persen > 100){
			alert("Diskon Persen Belum Diisi atau Melebihi 100%");
		}
		else if (tax < 0 || tax > 100){
			alert("Pajak Belum Diisi atau Melebihi 100%");
		}
		else {

		$.post("proses_edit_diskon_tax.php",{id:id,diskon_nominal:nominal,diskon_persen:persen,tax:tax},function(data){


		$(".alert").show('fast');
		$("#tabel_baru").load('tabel-diskon-tax.php');
		$(".modal").modal("hide");
		
		
		});
		}

		});

		</script>

		<script type="text/javascript">
  
      $("#persen_edit").keyup(function(){
      var persen = $("#persen_edit").val();
      var nominal = $("#nominal_edit").val();
      
      if (persen > 100)
      {

          alert("Jumlah Persen Tidak Boleh Lebih dari 100%");
          $("#persen_edit").val('');
      }

      else if (persen == "") 
      {
        $("#nominal").show();
      }

      else
      {
            $("#nominal").hide();
      }


    
      });


              $("#nominal_edit").keyup(function(){
              var nominal = $("#nominal_edit").val();
              var persen = $("#persen_edit").val();
              
              if (nominal == "") 
              {
              $("#persen").show();
              }
              
              else
              {
              $("#persen").hide();
              }
              
              
              
              });


     

  </script>

  <?php 
  include 'footer.php';
   ?>