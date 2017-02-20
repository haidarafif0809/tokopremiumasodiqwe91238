<?php include 'session_login.php';

//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'db.php';


 ?>

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>


 <div style="padding-left:5%; padding-right:5%;"><!--tag yang digunakan untuk membuat tampilan form menjadi rapih dalam satu tempat-->

<center><h3><b>Data Promo Produk</b></h3><hr></center>
<div class="row">
	
	<button id="coba" type="submit" class="btn btn-info" data-toggle="collapse"  data-target="#demo"  accesskey="r" ><i class='fa fa-plus'> </i>&nbsp;Tambah Produk Promo</button>
			<br>
	<div id="demo" class="collapse"><!--div id="demo" class="collapse"-->

		<button type="button" id="cari_produk" class="btn btn-success " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1)</i>  </button>

		<!--tampilan modal-->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">

		    <!-- isi modal-->
		    <div class="modal-content">

		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title"><center><b>Data Barang</b></center></h4>
		      </div>
		      <div class="modal-body">


		<span class="modal_baru">
		<div class="table-resposive">
		  <table id="tabel_cari" class="table table-bordered table-sm">
		        <thead> <!-- untuk memberikan nama pada kolom tabel -->
		        
		            <th> Kode Barang </th>
		            <th> Nama Barang </th>
		            <th> Jumlah Barang </th>
		            <th> Satuan </th>
		            <th> Kategori </th>
		            <th> Suplier </th>
		        
		        </thead> <!-- tag penutup tabel -->
		  </table>
		  </div>
		</span>
		</div> <!-- tag penutup modal-body-->
		      <div class="modal-footer">
		       <center> <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center>
		      </div>
		    </div>

		  </div>
		</div><!-- end of modal data barang  -->


				<form role="form">
					<div class="col-sm-3"><!--div class="col-sm-4"-->
						<div class="form-group">
							<label> Nama Produk</label><br>
							<input type="text" name="nama_produk" id="nama_produk">
						</div>
					</div>

					<div class="col-sm-3"><!--div class="col-sm-4"-->
						<div class="form-group">
							<input type="text" name="id_produk" id="id_produk" placeholder="">
						</div>
					</div>

					<br><button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>
				</form>

	</div><!--/div id="demo" class="collapse"-->
	</div><!--/div class="col-sm-4"-->


<br><br>


		<div class="table-responsive"><!--membuat agar ada garis pada tabel, disetiap kolom -->
			<span id="table_baru">
			<table id="table_free" class="table table-bordered">
					<thead> 
						<th style="background-color: #4CAF50; color: white;"> Nama Produk </th>
						<th style="background-color: #4CAF50; color: white;"> Hapus </th>
						<th style="background-color: #4CAF50; color: white;"> Edit </th>
					</thead>
			</table>
			</span>
		</div><!--/div class="table-responsive"-->

</div> <!--/div class="container"-->

<!--<script type="text/javascript">
$(function() {
    $( "#nama_produk" ).autocomplete({
        source: 'free_promo_produk_autocomplete.php'
    });
});
</script>-->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_free').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_free_produk.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_free").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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

  <script type="text/javascript">
  	$(document).on('click', '#submit_tambah', function (e) {
    var nama_produk = $("#nama_produk").val();
    var total_belanja = $("#total_belanja").val();
    var free_produk = $("#free_produk").val();
    if (nama_produk == '') {
    	alert("Silakan masukkan produk")
    }
      $.post("proses_promo_free_produk.php",{no_reg:no_reg, keterangan:keterangan},function(data){

      });
  });
  </script>

<?php include 'footer.php' ?>