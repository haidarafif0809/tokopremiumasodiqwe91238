<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>




<style>
.table {
    border-collapse: collapse;
    width: 100%;
}

.th, .td {
    text-align: left;
    padding: 8px;
}

.tr:nth-child(even){background-color: #f2f2f2}

.th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="container"> <!--start of container-->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data </h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label>Nomor Faktur :</label>
     <input type="text" id="faktur_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control">
    </div>
   
   </form>
   
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class="fa fa-check"> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class="fa fa-close"> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Penukaran Poin</h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>


        <div class="table-responsive"> 
          <table id="table-detail" class="table table-striped">
          <thead>
            <th> No. Faktur </th>
            <th> Kode Produk </th>
            <th> Nama Produk</th>
            <th> Satuan </th>
            <th> Jumlah </th>
            <th> Poin </th>
            <th> Subtotal Poin </th>
          </thead>
          
          </table>
          </div>



      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<h3>PENUKARAN POIN </h3>
<hr>


<?php 
include 'db.php';

$pilih_akses_tukar_poin_tambah = $db->query("SELECT tukar_poin_tambah FROM otoritas_tukar_poin WHERE id_otoritas = '$_SESSION[otoritas_id]' AND tukar_poin_tambah = '1'");
$tukar_poin_tambah = mysqli_num_rows($pilih_akses_tukar_poin_tambah);


    if ($tukar_poin_tambah > 0){
// membuat link-->
echo '<a href="form_penukaran_poin.php"  class="btn btn-info"> <i class="fa fa-plus"></i> Tukar Poin</a>';

}
?>



<br><br>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru" > 
<table id="tukar_poin" class="table table-bordered table-sm">
		<thead>
			<th style='background-color: #4CAF50; color:white' class='th'> Detail </th>

<?php  

include 'db.php';

$pilih_akses_tukar_poin_edit = $db->query("SELECT tukar_poin_edit FROM otoritas_tukar_poin WHERE id_otoritas = '$_SESSION[otoritas_id]' AND tukar_poin_edit = '1'");
$tukar_poin_edit = mysqli_num_rows($pilih_akses_tukar_poin_edit);


    if ($tukar_poin_edit > 0){
        echo "<th style='background-color: #4CAF50; color:white' class='th'> Edit </th>";

      }


$pilih_akses_tukar_poin_hapus = $db->query("SELECT tukar_poin_hapus FROM otoritas_tukar_poin WHERE id_otoritas = '$_SESSION[otoritas_id]' AND tukar_poin_hapus = '1'");
$tukar_poin_hapus = mysqli_num_rows($pilih_akses_tukar_poin_hapus);


    if ($tukar_poin_hapus > 0){
				echo "<th style='background-color: #4CAF50; color:white' class='th'> Hapus </th>";
	}
	?>
			
			<th style='background-color: #4CAF50; color:white' class='th'> Cetak </th>
			<th style='background-color: #4CAF50; color:white' class='th'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white' class='th'> Pelanggan </th>
			<th style='background-color: #4CAF50; color:white' class='th'> Poin Terakhir </th>
			<th style='background-color: #4CAF50; color:white' class='th'> Sisa Poin Terakhir </th>
      <th style='background-color: #4CAF50; color:white' class='th'> Total Poin </th>
      <th style='background-color: #4CAF50; color:white' class='th'> User </th>  
      <th style='background-color: #4CAF50; color:white' class='th'> User Edit</th>  
      <th style='background-color: #4CAF50; color:white' class='th'> Jam </th>  
			<th style='background-color: #4CAF50; color:white' class='th'> Tanggal </th>			
      <th style='background-color: #4CAF50; color:white' class='th'> Tanggal Edit</th>    
		</thead>
		
		
	</table>
</span>
</div>

		<br>
		<span id="demo"> </span>

</div><!--end of container-->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
          $('#tukar_poin').DataTable().destroy();
          var status = $("#status").val();
          var dataTable = $('#tukar_poin').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_penukaran_poin.php", // json datasource
            "data": function ( d ) {
                      d.status = $("#status").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tukar_poin").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#tukar_poin_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[9]);
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->

<!--menampilkan detail penjualan-->
		<script type="text/javascript">
		
		$(document).on('click','.detail',function(e){

		var no_faktur = $(this).attr('no_faktur');
				
		$("#modal_detail").modal('show');

      $('#table-detail').DataTable().destroy();

          var dataTable = $('#table-detail').DataTable( {
          "processing": true,
          "serverSide": true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_detail_tukar_poin.php", // json datasource
             "data": function ( d ) {
                d.no_faktur = no_faktur;
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-detail").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table-detail_processing").css("display","none");
              
            }
          }
    


        } );

		
		});
		
		</script>
		
		
		


		<script type="text/javascript">
						$(document).ready(function(){
						//fungsi hapus data 
						$(document).on('click', '.btn-hapus', function (e) {
						var no_faktur = $(this).attr("data-no_faktur");
						var id = $(this).attr("data-id");

						$("#faktur_hapus").val(no_faktur);
						$("#id_hapus").val(id);
						$("#modal_hapus").modal('show');
						$("#btn_jadi_hapus").attr("data-id", id);

						});
						
            $(document).on('click', '#btn_jadi_hapus', function (e) {

						
						var id = $(this).attr("data-id");
						var no_faktur = $("#faktur_hapus").val();

						$.post("hapus_penukaran_poin.php", {id:id, no_faktur:no_faktur}, function(data){

						$("#modal_hapus").modal("hide");
        					$('#tukar_poin').DataTable().destroy();
                  var status = $("#status").val();
                  var dataTable = $('#tukar_poin').DataTable( {
                  "processing": true,
                  "serverSide": true,
                  "ajax":{
                    url :"datatable_penukaran_poin.php", // json datasource
                    "data": function ( d ) {
                              d.status = $("#status").val();
                              // d.custom = $('#myInput').val();
                              // etc
                          },
                    type: "post",  // method  , by default get
                    error: function(){  // error handling
                      $(".employee-grid-error").html("");
                      $("#tukar_poin").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                      $("#tukar_poin_processing").css("display","none");
                    }
                },
                    
                    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                        $(nRow).attr('class','tr-id-'+aData[9]);
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
include 'footer.php';
 ?>