<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

$id = angkadoang($_GET['id']);
$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);

 ?>

  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">

<h3><b> SETTING DISKON : <?php echo $nama_barang; ?> || <?php echo $kode_barang; ?> </b></h3><hr>

<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> INPUT SETTING </button> <br><br>


    <div id="myModal" class="modal" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Input Setting</h3>
                </div>
                <div class="modal-body">

                    <form>
 
                        <div class="form-group">
                            <label> Jumlah barang </label>
                            <br>
                            <input type="text" placeholder="Ketentuan Jumlah barang" name="jumlah_barang" id="jumlah_barang" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        </div>
                        <div class="form-group">
                            <label> Potongan </label>
                            <br>
                            <input type="text" placeholder="Potongan" name="over_stok" id="potongan" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        </div>
			<!-- membuat tombol submit -->

                            <input type="hidden" name="id_barang" id="id_barang" class="form-control" value="<?php echo $id; ?>">                            
                            <input type="hidden" name="kode_barang" id="kode_barang" class="form-control" value="<?php echo $kode_barang; ?>">
							<button type="submit" id="submit" class="btn btn-info"> <i class="fa fa-plus"> </i>  Submit</button>
				</form>
			</div>


			<!--button penutup-->
			<div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>


		</div>

		</div>
	</div>

	<div class="card card-block">
		<div class="table-responsive">
			<table id="table_settingdiskon" class="table table-bordered">
				<thead>
					<th style='background-color: #4CAF50; color: white; width:200px; '> Kode Barang </th>
					<th style='background-color: #4CAF50; color: white; width:200px; '> Ketentuan Jumlah Barang </th>
					<th style='background-color: #4CAF50; color: white; width:200px;'> Potongan </th>
					<th style='background-color: #4CAF50; color: white;'> Hapus </th>
				
				</thead>
			</table>
		</div>
	</div>

 <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah jika ingin mengedit.</i></h6>
</div>


<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('click','#submit', function(e){

			var kode_barang = $("#kode_barang").val();
			var id_barang = $("#id_barang").val();
			var jumlah_barang = $("#jumlah_barang").val();
			var potongan = $("#potongan").val();

			if (jumlah_barang == "") {
				alert("Jumlah Barang tidak boleh kosong!");
				$("#jumlah_barang").val('');
			}else if (potongan == '') {
				alert("Potongan tidak boleh kosong!");
			}else{

				$("#myModal").modal('hide');
				$.post("proses_input_seeting_diskon.php",{kode_barang:kode_barang,id_barang:id_barang,jumlah_barang:jumlah_barang,potongan:potongan}, function(data){

						var table_settingdiskon = $('#table_settingdiskon').DataTable();
						table_settingdiskon.draw();
						$("#jumlah_barang").val('');
						$("#potongan").val('');

				});
			}

		});



		  $("form").submit(function(){
		      return false;
		  });

	});
</script>


<script type="text/javascript" language="javascript" >
	$(document).ready(function(){

		     	$('#table_settingdiskon').DataTable().destroy();

		          var dataTable = $('#table_settingdiskon').DataTable( {
		          "processing": true,
		          "serverSide": true,
		          "language": {
		        "emptyTable":     "My Custom Message On Empty Table"
		    },
		          "ajax":{
		            url :"datatable_Setting_diskon.php", // json datasource
		             "data": function ( d ) {
						d.kode_barang = $("#kode_barang").val();
						d.id_barang = $("#id_barang").val();
		                // etc
		            },
		                type: "post",  // method  , by default get
		            error: function(){  // error handling
		              $(".tbody").html("");
		              $("#table_settingdiskon").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
		              $("#table_settingdiskon_processing").css("display","none");
		              
		            }
		          }
		    


		        } );
      
});

  $("form").submit(function(){
      return false;
  });
</script>



<script type="text/javascript">		

								  //fungsi hapus data 
								$(document).on('click', '.btn-hapus', function (e) {

								    var id = $(this).attr("data-id");

								    var alert = confirm("Anda yakin mau menghapus data ini ?");

								    if (alert == true) {

										$.post("hapus_setting_diskon.php",{id:id},function(data){

										var table_settingdiskon = $('#table_settingdiskon').DataTable();
										table_settingdiskon.draw();
								          
								      });
								    };
								    
								    });
								// end fungsi hapus datasource				
									
								$(document).on('dblclick', '.edit-jumlah', function (e) {

									var id = $(this).attr("data-id");
									$("#text-jumlah-"+id).hide();
									$("#input-jumlah-"+id).attr("type","text");
								
								});
								
								$(document).on('blur', '.edit-jumlah', function (e) {
								
								var id = $(this).attr("data-id");
								var jumlah = $("#input-jumlah-"+id).val();
								var kode_barang = $("#text-kode-"+id).text();
								var jumlah_lama = $("#text-jumlah-"+id).text();
								var id_barang = $("#id_barang").val();
								var jenis_edit = "jumlah";

									if (jumlah == jumlah_lama) {
										
															$("#text-jumlah-"+id).show();
															$("#text-jumlah-"+id).text(jumlah_lama);
															$("#input-jumlah-"+id).val(jumlah_lama);
															$("#input-jumlah-"+id).attr("type","hidden");	
									}else{
												$.post("cek_setting_diskon.php",{jumlah:jumlah,kode_barang:kode_barang,id_barang:id_barang,jenis_edit:jenis_edit}, function(info){

													if (info > 0) {

														alert("Jumlah yang anda masukan sudah ada!");
															
															$("#text-jumlah-"+id).show();
															$("#text-jumlah-"+id).text(jumlah_lama);
															$("#input-jumlah-"+id).val(jumlah_lama);
															$("#input-jumlah-"+id).attr("type","hidden");	

													}else{
														$.post("edit_setting_diskon.php",{id:id,jumlah:jumlah,jenis_edit:jenis_edit},function(data){

															$("#text-jumlah-"+id).show();
															$("#text-jumlah-"+id).text(jumlah);
															$("#input-jumlah-"+id).val(jumlah);
															$("#input-jumlah-"+id).attr("type","hidden");				
														
														});											
													};

											});
									};




								
								});

								$(document).on('dblclick', '.edit-potongan', function (e) {

									var id = $(this).attr("data-id");
									$("#text-potongan-"+id).hide();
									$("#input-potongan-"+id).attr("type","text");
								
								});
								
								$(document).on('blur', '.edit-potongan', function (e) {
								
								var id = $(this).attr("data-id");
								var potongan = $("#input-potongan-"+id).val();
								var jenis_edit = "potongan";
								var kode_barang = $("#text-kode-"+id).text();
								var potongan_lama = $("#text-potongan-"+id).text();
								var id_barang = $("#id_barang").val();

								if (potongan == potongan_lama) {
											
											$("#text-potongan-"+id).show();
											$("#text-potongan-"+id).text(potongan_lama);
											$("#input-potongan-"+id).val(potongan_lama);
											$("#input-potongan-"+id).attr("type","hidden");		
								}else{
										$.post("cek_setting_diskon.php",{potongan:potongan,kode_barang:kode_barang,id_barang:id_barang,jenis_edit:jenis_edit}, function(info){

										if (info > 0) {

											alert("Potongan yang anda masukan sudah ada!");
											
											$("#text-potongan-"+id).show();
											$("#text-potongan-"+id).text(potongan_lama);
											$("#input-potongan-"+id).val(potongan_lama);
											$("#input-potongan-"+id).attr("type","hidden");		

										}else{

											$.post("edit_setting_diskon.php",{id:id,potongan:potongan,jenis_edit:jenis_edit},function(data){
											
											$("#text-potongan-"+id).show();
											$("#text-potongan-"+id).text(potongan);
											$("#input-potongan-"+id).val(potongan);
											$("#input-potongan-"+id).attr("type","hidden");				
									
											});
										};

								
									});								
								};
								


								});


</script>

<?php 
include 'footer.php';
 ?>	
