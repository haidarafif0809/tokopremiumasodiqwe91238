<?php include 'session_login.php';


// memsukan file session login, header,navbar dan db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>




<div class="container"> <!-- start of container -->


  <!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Barang Hadiah</h4>
      </div>

      <div class="modal-body">

   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Produk :</label>
     <input type="text" id="nama_barang_hapus" class="form-control" readonly="">
     <input type="hidden" id="kode_barang_hapus" class="form-control" readonly="">  
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <i class='fa fa-check'> </i>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <i class='glyphicon glyphicon-remove'> </i>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- isi modal-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><h3><b>Data Barang</b></h3></center></h4>
      </div>
      <div class="modal-body">

  <div class="table-responsive">
  <table id="tabel_cari" class="table table-bordered table-sm">
  <thead> <!-- untuk memberikan nama pada kolom tabel -->

            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> Harga Jual Level 4 </th>
            <th> Harga Jual Level 5</th>
            <th> Harga Jual Level 6</th>
            <th> Harga Jual Level 7</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Suplier </th>

  </thead> <!-- tag penutup tabel -->
  </table>
  </div>

      <div class="table-resposive">
<span class="modal_baru">

  </span>
</div>
</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal data barang  -->


<h3><b>DAFTAR BARANG HADIAH</b></h3> <hr>
<!-- Trigger the modal with a button -->

<!--

include 'db.php';

$pilih_akses_pelanggan = $db->query("SELECT pelanggan_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_tambah = '1'");
$pelanggan = mysqli_num_rows($pilih_akses_pelanggan);


    if ($pelanggan > 0){

    	echo '';

    }

-->

<!-- Modal tambah data -->

<button type="button" id="cari_produk" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa fa-search'></i> Cari (F1)  </button> 
<a href='form_aturan_poin.php' class="btn btn-success" target="blank">  <i class="fa fa-cogs"> </i> Aturan Poin </a>


<br><br>
<div class="row"> 

	<div class="col-sm-4">
		   <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
			    <option value="">SILAKAN PILIH...</option>
			       <?php 

			        include 'cache.class.php';
			          $c = new Cache();
			          $c->setCache('produk');
			          $data_c = $c->retrieveAll();

			          foreach ($data_c as $key) {
			            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
			          }

			        ?>
    	</select>
	</div>

	<div class="col-sm-2">
		<input style="height:13px;" type="text" class="form-control" name="quantity_poin" id="quantity_poin" autocomplete="off" placeholder="Poin" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
	</div>

	<div class="col-sm-3">
		<button type="button" class="btn btn-warning" id="submit"> <i class="fa fa-plus"> </i> Submit </button>
	</div>


		<input style="height:13px;" type="hidden" class="form-control" name="nama_barang" id="nama_barang" autocomplete="off">
		<input style="height:13px;" type="hidden" class="form-control" name="satuan" id="satuan" autocomplete="off">
		<input style="height:13px;" type="hidden" class="form-control" name="kategori" id="kategori" autocomplete="off">

</div>

<br>
<br>


<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>


<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="table_poin" class="table table-bordered">
		<thead>
			
			<th style='background-color: #4CAF50; color: white'> Kode Produk </th>
			<th style='background-color: #4CAF50; color: white'> Nama Produk </th>
			<th style='background-color: #4CAF50; color: white'> Satuan </th>
			<th style='background-color: #4CAF50; color: white'> Poin</th>
			<th style='background-color: #4CAF50; color: white'> Hapus </th>


<!--

include 'db.php';

$pilih_akses_pelanggan_hapus = $db->query("SELECT pelanggan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_hapus = '1'");
$pelanggan_hapus = mysqli_num_rows($pilih_akses_pelanggan_hapus);


    if ($pelanggan_hapus > 0){

			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";

		}


include 'db.php';

$pilih_akses_pelanggan_edit = $db->query("SELECT pelanggan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pelanggan_edit = '1'");
$pelanggan_edit = mysqli_num_rows($pilih_akses_pelanggan_edit);


    if ($pelanggan_edit > 0){
    	echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
    }
-->
			
			
		</thead>


	</table>


	</span>

</div><br>
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom poin jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>
</div> <!--end of container-->

<script type="text/javascript">
  //SELECT CHOSSESN    
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});    
</script>

<script>
//Choosen Open select
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});
</script>


<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<script> 
    shortcut.add("f2", function() {
        // Do something
        $("#kode_barang").focus();

	});    

    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk").click();

    }); 

</script>


<script type="text/javascript">
// START script untuk pilih kode barang menggunakan chosen     
  $(document).ready(function(){

			  $(document).on('change','#kode_barang',function(e){

					    var kode_barang = $(this).val();
					    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
					    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");

					    $("#satuan").val(satuan);
					    $("#kode_barang").val(kode_barang);
					    $("#nama_barang").val(nama_barang);


					    $.post("cek_barang_master_poin.php",{kode_barang:kode_barang},function(data){
					    	if (data == 1) {
					    		alert("Barang yang anda pilih sudah ada, silahkan pilih barang lain!");

					    			$("#kode_barang").chosen("destroy");
					    			$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});    
					    			$("#satuan").val('');
								    $("#kode_barang").val('');
								    $("#nama_barang").val('');
								    $("#kategori").val('');
							        $("#kode_barang").trigger('chosen:updated');
							        $("#kode_barang").trigger('chosen:open');

					    	};

					    });  

			  });
  }); 
  // end script untuk pilih kode barang menggunakan chosen   
</script>


<!-- DATATABLE AJAX -->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_poin').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_poin.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_poin").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

        });
      });
    </script>
<!-- / DATATABLE AJAX -->



<!--Start Ajax Modal Cari-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_jual_baru_poin.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('harga', aData[2]);
              $(nRow).attr('harga_level_2', aData[3]);
              $(nRow).attr('harga_level_3', aData[4]);
              $(nRow).attr('harga_level_4', aData[5]);
              $(nRow).attr('harga_level_5', aData[6]);
              $(nRow).attr('harga_level_6', aData[7]);
              $(nRow).attr('harga_level_7', aData[8]);
              $(nRow).attr('jumlah-barang', aData[9]);
              $(nRow).attr('satuan', aData[17]);
              $(nRow).attr('kategori', aData[11]);
              $(nRow).attr('status', aData[16]);
              $(nRow).attr('suplier', aData[12]);
              $(nRow).attr('limit_stok', aData[13]);
              $(nRow).attr('ber-stok', aData[14]);
              $(nRow).attr('tipe_barang', aData[15]);
              $(nRow).attr('id-barang', aData[18]);

          }

        });    
     
  });
 </script>
<!--Start Ajax Modal Cari-->




<!--START INPUT DARI MODAL CARI-->
<script type="text/javascript">
//AMBIL DAN INPUT KE FORM DARI CARI BARANG
$(document).on('click', '.pilih', function (e) {

	var kode_barang = $(this).attr('data-kode');
	var nama_barang = $(this).attr('nama-barang');
	var satuan = $(this).attr('satuan')
	var kategori = $(this).attr('kategori');

		$.post("cek_barang_master_poin.php",{kode_barang:kode_barang},function(data){
					    	if (data == 1) {
					    		alert("Barang yang anda pilih sudah ada, silahkan pilih baarang lain!");

					    			$("#satuan").val('');
								    $("#kode_barang").val('');
								    $("#nama_barang").val('');
								    $("#kategori").val('');
							        $("#kode_barang").trigger('chosen:updated');
							        

					    	}
					    	else
					    	{

									  $("#kode_barang").val(kode_barang);
									  $("#kode_barang").trigger('chosen:updated');
									  $("#nama_barang").val(nama_barang);
									  $("#satuan").val(satuan);
									  $("#kategori").val(kategori);

									  $('#myModal').modal('hide'); 
									  $("#quantity_poin").focus();
					    	}


					    });  


});

</script>



        <script type="text/javascript">
                             
				$(document).ready(function(){

					//fungsi untuk menambahkan data
								$(document).on('click','#submit',function(){


								var kode_barang = $("#kode_barang").val();
								var nama_barang = $("#nama_barang").val();
								var poin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#quantity_poin").val()))));
								var satuan = $("#satuan").val();
																
								if (kode_barang == "") {

									alert("Anda belum memilih barang!, silahkan pilih barang dahulu!");
								}

								else if (poin == "") {

									alert("Jumlah Poin Harus Diisi");
								}

								else {	


									$.post('proses_master_poin.php', {kode_barang:kode_barang,nama_barang:nama_barang,poin:poin,satuan:satuan},function(data){

								    $("#satuan").val('');
								    $("#quantity_poin").val('');
								    $("#kode_barang").val('');
								    $("#nama_barang").val('');
								    $("#kategori").val('');
							        $("#kode_barang").trigger('chosen:updated');
							        $("#kode_barang").trigger('chosen:open');

										       $('#table_poin').DataTable().destroy();

										        var dataTable = $('#table_poin').DataTable( {
													          "processing": true,
													          "serverSide": true,
													          "ajax":{
													            url :"datatable_poin.php", // json datasource
													            type: "post",  // method  , by default get
													            error: function(){  // error handling
													              $(".employee-grid-error").html("");
													              $("#table_poin").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
													              $("#employee-grid_processing").css("display","none");
													              
													            }
													          },
													            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
													              $(nRow).attr('class','tr-id-'+aData[5]+'');
													            },
													        });

	
								});

							}
	
								
								});
								
					// end fungsi tambah 

					//fungsi edit data 
								$(document).on('dblclick', '.edit-poin', function (e) {

									var id = $(this).attr("data-id");
									$("#id-poin-"+id).hide();
									$("#input-poin-"+id).attr("type","text");
								
								});
								
								$(document).on('blur', '.edit-qty-poin', function (e) {
								
								var id = $(this).attr("data-id");
								var kode_barang = $(this).attr("data-kode");
								var poin_lama = $(this).attr("data-poin");
								var poin_baru = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).val()))));

								
								$.post("edit_master_poin.php",{id:id,kode_barang:kode_barang,poin_baru:poin_baru},function(data){
								
								$("#id-poin-"+id).text(tandaPemisahTitik(poin_baru));	
								$("#id-poin-"+id).show();	
								$("#input-poin-"+id).val(tandaPemisahTitik(poin_baru));
								$("#input-poin-"+id).attr("type","hidden");				
								
								});
								
								});
								
					 //end function edit data
					 
					 
					 			$(document).on('click', '.btn-hapus', function (e) {

					 			$("#modal_hapus").modal('show');

					 			var kode_barang = $(this).attr("data-kode");
					 			var nama_barang = $(this).attr("data-nama");
					 			var id = $(this).attr("data-id");

					 			$("#nama_barang_hapus").val(nama_barang);
					 			$("#kode_barang_hapus").val(kode_barang);
					 			$("#id_hapus").val(id);

								});

					 			$(document).on('click', '#btn_jadi_hapus', function (e) {

					 			var kode_barang = $("#kode_barang_hapus").val();
					 			var id = $("#id_hapus").val();

					 				$("#modal_hapus").modal('hide');
					 				

					 				$.post("hapus_master_poin.php",{id:id,kode_barang:kode_barang},function(data){

					 					        			   $('#table_poin').DataTable().destroy();
					 					        			   var dataTable = $('#table_poin').DataTable( {
													          "processing": true,
													          "serverSide": true,
													          "ajax":{
													            url :"datatable_poin.php", // json datasource
													            type: "post",  // method  , by default get
													            error: function(){  // error handling
													              $(".employee-grid-error").html("");
													              $("#table_poin").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
													              $("#employee-grid_processing").css("display","none");
													              
													            }
													          },

													        });
									
									});

								});
								
								$('form').submit(function(){
								
								return false;
								});
								
			});
								

        </script>


<?php 
//memasukkan file footer.php
include 'footer.php'; 
?>
