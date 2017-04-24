<?php include 'session_login.php';
//gone stok opname ajax
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>


<style>


tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="container"> <!--start of container-->

<h3><b> DATA STOK OPNAME </b></h3><hr>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Satuan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nomor Faktur :</label>
     <input type="text" id="data_faktur" class="form-control" readonly=""> 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
        
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-alert">
       </span>
      </div>

     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data, 
        silahkan hapus terlebih dahulu<br> Transaksi Penjualan.</i></h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Stok Opname </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!--membuat link-->

<?php
$pilih_akses_stok_opname = $db->query("SELECT * FROM otoritas_stok_opname WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$stok_opname = mysqli_fetch_array($pilih_akses_stok_opname);

if ($stok_opname['stok_opname_tambah'] > 0) {

echo '<a href="form_stok_opname.php"  class="btn btn-info" > <i class="fa fa-plus"> </i> STOK OPNAME</a>';

}

?>
<br>

<span id="mbalek" style="display: none;">
	<button type="submit" name="kembali" id="kembali" class="btn btn-primary" ><i class="fa fa-reply"> </i>Kembali </button>
</span>
<button type="submit" name="submit" id="filter_1" class="btn btn-primary" ><i class="fa fa-eye"> </i> Filter Faktur </button>
<button type="submit" name="submit" id="filter_2" class="btn btn-primary" ><i class="fa fa-eye"> </i> Filter Detail </button>


<!--START FILTER FAKTUR-->
<span id="fil_faktur">
<form class="form-inline" action="show_filter_stok_opname.php" method="post" role="form">
					
					<div class="form-group"> 
					
					<input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
					</div>
					
					<div class="form-group"> 
					
					<input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
					</div>
					
					<button type="submit" name="submit" id="submit_filter_1" class="btn btn-primary" ><i class="fa fa-eye"> </i> Filter Faktur </button>

					
</form>
<span id="result"></span>  
</span>
<!--END FILTER FAKTUR-->

<!--START FILTER DETAIl-->
<span id="fil_detail">
<form class="form-inline" action="show_filter_stok_opname_detail.php" method="post" role="form">
					
					<div class="form-group"> 
					
					<input type="text" name="dari_tanggal" id="dari_tanggal2" class="form-control" placeholder="Dari Tanggal" required="">
					</div>
					
					<div class="form-group"> 
					
					<input type="text" name="sampai_tanggal" id="sampai_tanggal2" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
					</div>
					
					<button type="submit" name="submit" id="submit_filter_2" class="btn btn-primary" ><i class="fa fa-eye"> </i> Filter Detail </button>

					
</form>
<span id="result"></span>  
</span>
<!--END FILTER DETAIl-->


<br><br>

<span id="table_baru">
<div class="table-responsive">
<table id="table_stok_opname" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> Status </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan </th>
			<th style='background-color: #4CAF50; color:white'> Total Selisih</th>
			
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>
			<?php 

if ($stok_opname['stok_opname_edit'] > 0) {
	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
			 ?>

<?php
if ($stok_opname['stok_opname_hapus'] > 0) {

				echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
			}

?>
			
			
			
		</thead>
	</table>
</div>
</span>

<span id="table_faktur" style="display: none;">
<div class="table-responsive">
<table id="table_filter_faktur" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> Status </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan </th>
			<th style='background-color: #4CAF50; color:white'> Total Selisih</th>
			
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>
			<?php 

if ($stok_opname['stok_opname_edit'] > 0) {
	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
			 ?>

<?php
include 'db.php';

if ($stok_opname['stok_opname_hapus'] > 0) {

				echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
			}

?>
						
		</thead>
	</table>
</div>
</span>

<span id="table_detail" style="display: none;">
<div class="table-responsive">
<table id="table_filter_detail" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
			<th style='background-color: #4CAF50; color:white'> Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Hpp </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Harga </th>

		</thead>
	</table>
</div> 

<a href='expor_excel_stok_opname_detail.php' id="export_excel" class='btn btn-warning' role='button'>Download Excel</a>
</span>
<br>
	<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
</div><!--end of container-->
		<span id="demo"> </span>

<script type="text/javascript">
	$(document).ready(function(){
			$('#table_stok_opname').DataTable().destroy();
			
          var dataTable = $('#table_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_stok_opname.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[10]+'');
            },

        });

        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>

<script type="text/javascript">
//FILTER FAKTUR
	$(document).ready(function(){
		$(document).on('click','#submit_filter_1',function(e){
			var sampai_tanggal = $("#sampai_tanggal").val();
			var dari_tanggal = $("#dari_tanggal").val();
			if (dari_tanggal == "") {
				alert("silahkan isi dari tanggal terlebih dahulu.");
				$("#dari_tanggal").focus();
			}
			else if (sampai_tanggal == "") {
				alert("silakan isi sampai tanggal terlebih dahulu.");
				$("#sampai_tanggal").focus();
			}
			else{

				$("#table_faktur").show();
				$("#table_detail").hide();
				$("#table_baru").hide();
				$('#table_filter_faktur').DataTable().destroy();
		          var dataTable = $('#table_filter_faktur').DataTable( {
		          "processing": true,
		          "serverSide": true,
		          "ajax":{
		            url :"datatable_filter_faktur_stok_opname.php", // json datasource
		            "data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
		            type: "post",  // method  , by default get
		            error: function(){  // error handling
		              $(".employee-grid-error").html("");
		              $("#table_filter_faktur").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
		              $("#employee-grid_processing").css("display","none");
		            }
		        },
		            
		            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
		                $(nRow).attr('class','tr-id-'+aData[10]+'');
		            },

		        });
			}// end else
		});
		$("form").submit(function(){
        return false;
        });
	});
	// /FILTER FAKTUR
</script>

<script type="text/javascript">
//FILTER DETAIL
	$(document).ready(function(){
		$(document).on('click','#submit_filter_2',function(e){
			var sampai_tanggal = $("#sampai_tanggal2").val();
			var dari_tanggal = $("#dari_tanggal2").val();
			if (dari_tanggal == "") {
				alert("silahkan isi dari tanggal terlebih dahulu.");
				$("#dari_tanggal").focus();
			}
			else if (sampai_tanggal == "") {
				alert("silakan isi sampai tanggal terlebih dahulu.");
				$("#sampai_tanggal").focus();
			}
			else{

				$("#table_detail").show();
				$("#table_faktur").hide();
				$("#table_baru").hide();
				$('#table_filter_detail').DataTable().destroy();
		          var dataTable = $('#table_filter_detail').DataTable( {
		          "processing": true,
		          "serverSide": true,
		          "ajax":{
		            url :"datatable_filter_detail_stok_opname.php", // json datasource
		            "data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal2").val();
                      d.sampai_tanggal = $("#sampai_tanggal2").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
		            type: "post",  // method  , by default get
		            error: function(){  // error handling
		              $(".employee-grid-error").html("");
		              $("#table_filter_detail").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
		              $("#employee-grid_processing").css("display","none");
		            }
		        },
		            
		            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
		                $(nRow).attr('class','tr-id-'+aData[10]+'');
		            },

		        });

		     $("#export_excel").attr("href", "expor_excel_stok_opname_detail.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
		  
		  
			}// /else
		});
		$("form").submit(function(){
        return false;
        });
	});
	// /FILTER DETAIL
</script>
		<!--menampilkan detail penjualan-->
		<script type="text/javascript">
		$(document).on('click','.detail',function(e){
		var no_faktur = $(this).attr('no_faktur');
				
		$("#modal_detail").modal('show');
		
		$.post('detail_stok_opname.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>


<script type="text/javascript">
	
	//fungsi hapus data 
		$(document).on('click','.btn-hapus',function(e){
		var no_faktur = $(this).attr("data-faktur");
		var id = $(this).attr("data-id");
		
		$("#data_faktur").val(no_faktur);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var no_faktur = $("#data_faktur").val();
		var id = $(this).attr("data-id");

		$.post("hapus_data_stok_opname.php",{no_faktur:no_faktur},function(data){
		if (data != "") {

         
         $("#modal_hapus").modal('hide');
         $(".tr-id-"+id).remove();
		
		}

		
		});
		
		});
// end fungsi hapus data

</script>

<script type="text/javascript">
	
		$(document).on('click', '.btn-alert', function (e) {
		var no_faktur = $(this).attr("data-faktur");

		$.post('modal_alert_hapus_data_stok_opname.php',{no_faktur:no_faktur},function(data){


		$("#modal_alert").modal('show');
		$("#modal-alert").html(data);

		});

		
		});

</script>

<script>
    $(function() {
    $( "#dari_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


    <script>
    $(function() {
    $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <script>
    $(function() {
    $( "#dari_tanggal2" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


    <script>
    $(function() {
    $( "#sampai_tanggal2" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <!--<script type="text/javascript">
//fil FAKTUR
$(document).on('click','#submit_filter_1',function(e) {
$.post($("#formtanggal").attr("action"), $("#formtanggal :input").serializeArray(), function(info) { $("#dataabsen").html(info); });
    
});

$("#formtanggal").submit(function(){
    return false;
});

function clearInput(){
    $("#formtanggal :input").each(function(){
        $(this).val('');
    });
};



</script>-->

<!--<script type="text/javascript">
//fill DETAIL
$(document).on('click','#submit_filter_2',function(e) {
$.post($("#formtanggal").attr("action"), $("#formtanggal :input").serializeArray(), function(info) { $("#dataabsen").html(info); });
    
});

$("#formtanggal").submit(function(){
    return false;
});

function clearInput(){
    $("#formtanggal :input").each(function(){
        $(this).val('');
    });
};



</script>-->





<script type="text/javascript">
		$(document).ready(function(){
			$("#fil_faktur").hide();
			$("#fil_detail").hide();
	});
</script>


<script type="text/javascript">
		$(document).ready(function(){
				$("#filter_1").click(function(){		
			$("#mbalek").show();				
			$("#fil_faktur").show();
			$("#filter_2").show();
			$("#table_faktur").show();
			$("#table_detail").hide();
			$("#filter_1").hide();	
			$("#fil_detail").hide();
			$("#table_baru").hide();
			});

				$("#filter_2").click(function(){
			$("#mbalek").show();		
			$("#fil_detail").show();
			$("#filter_1").show();
			$("#table_detail").show();
			$("#table_faktur").hide();	
			$("#fil_faktur").hide();
			$("#filter_2").hide();
			$("#table_baru").hide();
			});

				$("#kembali").click(function(){
			$("#mbalek").hide();		
			$("#fil_detail").hide();
			$("#table_detail").hide();
			$("#table_faktur").hide();	
			$("#fil_faktur").hide();
			$("#filter_1").show();
			$("#filter_2").show();
			$("#table_baru").show();
			});

	});
</script>

<?php 
include 'footer.php';
 ?>