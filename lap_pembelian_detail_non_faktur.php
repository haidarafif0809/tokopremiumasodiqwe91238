<?php include 'session_login.php';

//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';





 ?>


 <div class="container">

<h3> LAPORAN PEMBELIAN DETAIL NON FAKTUR</h3><hr>

<form class="form-inline" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control tanggal_cari" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control tanggal_cari" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-eye"></i> Tampil </button>

</form>

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
					<table id="tableuser" class="table table-bordered table-sm">
					<thead>
					<th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Total </th>
					<th style="background-color: #4CAF50; color: white;"> Potongan </th>
					<th style="background-color: #4CAF50; color: white;"> Tax </th>

					
					
					</thead>
					
					<tbody>

					</tbody>
					
					</table>
</span>
</div> <!--/ responsive-->

<span id="table_tampil" style="display: none">
	<div class="card card-block">

<div class="table-responsive">
					<table id="table_lap_pembelian_detail" class="table table-bordered table-sm">
					<thead>
					<th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Total </th>
					<th style="background-color: #4CAF50; color: white;"> Potongan </th>
					<th style="background-color: #4CAF50; color: white;"> Tax </th>
					</thead>

		</table>
</div>


  <br>

       <a href='cetak_lap_pembelian_detail_non_faktur.php'class='btn btn-success' id="cetak_lap" target='blank'><i class='fa fa-print'> </i> Cetak Pembelian </a>

</div>
</span>
</div> <!--/ container-->

<script type="text/javascript">
//PICKERDATE
	$(function(){
		$(".tanggal_cari").pickadate({selectYears: 100,format: 'yyyy-mm-dd'});
	});
	// /PICKERDATE
</script>


<script type="text/javascript">
		$(document).on('click','#submit',function(e){


			$('#table_lap_pembelian_detail').DataTable().destroy();


			var dari_tanggal = $("#dari_tanggal").val();
      		var sampai_tanggal = $("#sampai_tanggal").val();


      		if (dari_tanggal == '') {
            alert("Silakan dari tanggal diisi terlebih dahulu.");
            $("#dari_tanggal").focus();
          }
          else if (sampai_tanggal == '') {
            alert("Silakan sampai tanggal diisi terlebih dahulu.");
            $("#sampai_tanggal").focus();
          }
            else{

            $('#table_tampil').show();
			$('#result').hide();

          var dataTable = $('#table_lap_pembelian_detail').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lab_pembelian_detail_non_faktur.php", // json datasource
           	"data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_pembelian_detail").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        }
          
        });

    	$("#cetak_lap").attr("href", "cetak_lap_pembelian_detail_non_faktur.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

        }//end else

        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>


<?php 
include 'footer.php';
 ?>