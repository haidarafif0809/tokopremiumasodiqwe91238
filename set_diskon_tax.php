<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$ambil_data = $db->query("SELECT * FROM setting_diskon_tax");
$data = mysqli_fetch_array($ambil_data);
 ?>


  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Diskon dan Pajak</h4>
      </div>
      <div class="modal-body">
  <form role="form" method="post">
  <span id="nominal">
					<div class="form-group">
					<label>Diskon Nominal (Rp)</label><br>
					<input type="text" name="diskon_nominal" id="nominal_edit"  class="form-control" autocomplete="off" required="" >
					</div>
  </span>

<span id="persen">
					<div class="form-group">
					<label> Diskon Persen (%) </label><br>
					<input type="text" name="diskon_persen" id="persen_edit" class="form-control" autocomplete="off" required="" >
					</div>
</span>

					<div style="display: none" class="form-group">
					<label> Pajak (%) </label><br>
					<input type="text" name="tax" id="tax_edit" value="<?php echo $data['tax']; ?>" class="form-control" autocomplete="off" required="" >
					</div>

						

					<input type="hidden" name="id" id="id_edit" value="<?php echo $data['id']; ?>">
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<h3><b> DEFAULT DISKON & PAJAK </b></h3><hr>
<div class="table-responsive">
<span id="tabel_baru">
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
	</span>


</div>
</div>
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