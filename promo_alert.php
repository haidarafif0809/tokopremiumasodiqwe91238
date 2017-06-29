<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';




 ?>



<!-- Modal Untuk Confirm PESAN alert-->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">

    <h3><center><b>Pesan Alert Promo</b></center></h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <span id="tampil_layanan">
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end pesan alert-->

<div class="container">
<h3><b>DATA PROMO ALERT</b></h3> <hr>
<!-- Trigger the modal with a button -->





  <button id="tambah" type="submit" class="btn btn-primary" data-toggle="collapse"  accesskey="r" ><i class='fa fa-plus'> </i>&nbsp;Tambah</button>

<button style="display:none" data-toggle="collapse tooltip" accesskey="k" id="kembali" class="btn btn-primary" data-placement='top' title='Klik untuk kembali ke utama.'><i class="fa fa-reply"></i> <u>K</u>embali </button>

<br>
<br>


<div id="demo" class="collapse">
<form role="form" method="POST" action="proses_pormo_alert.php">
		<div class="form-group">
		
   <label>Nama Produk</label> 			
   <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
    <option value="">SILAKAN PILIH...</option>
       <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

          $cache_parcel = new Cache();
          $cache_parcel->setCache('produk_parcel');
          $data_parcel = $cache_parcel->retrieveAll();

          foreach ($data_parcel as $key_parcel) {
            echo '<option id="opt-produk-'.$key_parcel['kode_parcel'].'" value="'.$key_parcel['id'].'" > '. $key_parcel['kode_parcel'].' ( '.$key_parcel['nama_parcel'].' ) </option>';
          }

        ?>
    </select>
	
          <br><br>
					<input type="hidden" name="id_produk" id="id_produk">

					<label> Pesan Alert </label><br>
					<textarea name="pesan_alert" id="pesan_alert" style="height:250px" class="form-control"  placeholder="Pesan Alert Promo" required=""></textarea>  <br>

					<label> Status </label><br>
					<select name="status" id="status" class="form-control " autocomplete="off" required="" >
					<option value="1">Aktif</option>
					<option value="2">Tidak Aktif</option>
					</select><br>					


					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>

		</div>
</form>

				
					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>
</div>




<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Promo</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
		<input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->




<style>

tr:nth-child(even){background-color: #f2f2f2}


</style>


<div class="table-responsive">
<span id="table_baru">
<table id="table_promo_alert" class="table table-bordered table-sm">
		<thead>
			<th style='background-color: #4CAF50; color: white'> Nama Produk</th>
			<th style='background-color: #4CAF50; color: white'> Pesan Alert</th>
			<th style='background-color: #4CAF50; color: white'> Status</th>
			<th style='background-color: #4CAF50; color: white'> Hapus </th>
			<th style='background-color: #4CAF50; color: white'> Edit </th>	
		</thead>
		
	</table>
</span>
</div>


<!--script disable hubungan pasien-->
<script type="text/javascript">
$(document).ready(function(){

  $("#tambah").click(function(){
    $(".chosen").chosen("destroy");
    $("#demo").show();
    $("#kembali").show();
    $("#tambah").hide();
    $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});
  });

  $("#kembali").click(function(){
    $("#demo").hide();
    $("#tambah").show();
    $("#kembali").hide();
    $(".chosen").chosen("destroy");
  });
});
</script>

	
<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_promo_alert').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_promo_alert.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_promo_alert").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->


		
			<script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'pesan_alert' );
            </script>


<!--   script untuk detail layanan -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.detaili', function (e) {
              
               
                var id = $(this).attr('data-id');
               
                $.post("detail_pesan_alert.php",{id:id},function(data){
                    $("#tampil_layanan").html(data);
               $("#detail").modal('show');
          
                });

               
            });
      

//            tabel lookup mahasiswa
            
          
</script>
<!--  end script untuk akhir detail layanan  -->


<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

<!--
<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          
          if (kode_barang != '')
          {

      $.getJSON('lihat_nama_barang.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#id_produk').val('');
       
      }

      else 
      {
        $('#id_produk').val(json.id);
        
      }
                                              
        });   
}

        });
        });     
</script>
-->


<script type="text/javascript">
// START script untuk pilih kode barang menggunakan chosen     
  $(document).ready(function(){
  $("#kode_barang").change(function(){
    var id_barang = $(this).val();

    $("#id_produk").val(id_barang);    

  });
  }); 
  // end script untuk pilih kode barang menggunakan chosen   
</script>


        <script type="text/javascript">
        $(document).ready(function(){

            $(document).on('click', '.btn-hapus', function (e) {

								var id = $(this).attr("data-id");
								$("#id_hapus").val(id);
								$("#modal_hapus").modal('show');
								
								
								});
								
								$("#btn_jadi_hapus").click(function(){
								
								var id = $("#id_hapus").val();
								
								$.post("hapuspromoalert.php",{id:id},function(data){
								if (data == "sukses") {
								$(".tr-id-"+id+"").remove();
								$("#modal_hapus").modal('hide');
							
								}
								
								
								});
								
								});
			});
					// end fungsi hapus data
</script>

<script type="text/javascript">
  $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});    
</script>

<?php
 include 'footer.php'; ?>
