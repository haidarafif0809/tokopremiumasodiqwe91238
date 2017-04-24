<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>

 <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>


 <div class="container">

 <h3><b> KOMISI / PRODUK </b></h3><hr>


<?php
include 'db.php';

$pilih_akses_fee_produk = $db->query("SELECT komisi_produk_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND komisi_produk_tambah = '1'");
$fee_produk = mysqli_num_rows($pilih_akses_fee_produk);

    if ($fee_produk > 0) {
echo '<a href="form_fee_produk_petugas.php"  class="btn btn-info" > <i class="fa fa-plus"> </i> KOMISI PETUGAS</a> <a href="form_fee_produk_jabatan.php" class="btn btn-success" > <i class="fa fa-plus"> </i> KOMISI JABATAN</a>';
}

?>
<br><br>



<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Komisi Produk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Petugas :</label>
     <input type="text" id="data_petugas" class="form-control" readonly=""> 
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

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Komisi Produk</h4>
      </div>
      <div class="modal-body">
  <form role="form">

   <div class="form-group">

<span id="prosentase">  
    <label for="email">Jumlah Prosentase ( % ):</label>
     <input type="text" name="jumlah_prosentase" class="form-control" id="prosentase_edit" autocomplete="off">
</span>

<span id="nominal">
     <br>
     <label for="email">Jumlah Nominal ( Rp ):</label>
     <input type="text" name="jumlah_uang" class="form-control" id="nominal_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">

</span>
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
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


<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel_baru">
<table id="table_fee_produk" class="table table-bordered">
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
	</table>

</div>

</div>

<script type="text/javascript">
	$(document).ready(function(){
			$('#table_fee_produk').DataTable().destroy();
			
          var dataTable = $('#table_fee_produk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_fee_produk.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_fee_produk").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[9]+'');
            },

        });

        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>

  <script>
    
  //fungsi hapus data 
    $(document).on('click','.btn-hapus',function(e){
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

<?php 

include 'footer.php';
 ?>