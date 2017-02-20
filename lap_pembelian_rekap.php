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

<h3> LAPORAN PEMBELIAN REKAP </h3><hr>

<form class="form-inline" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control tanggal_cari" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control tanggal_cari" placeholder="Sampai Tanggal" value="<?php echo date("Y/m/d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-eye"> </i> Tampil </button>

</form>

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Nama Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Kembalian </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
						
		</thead>

	</table>
</span>
</div> <!--/ responsive-->

<span id="table_tampil" style="display: none;">
	<div class="card card-block">

<div class="table-responsive">
 <table id="table_lap_pembelian_rekap" class="table table-bordered">
    <thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Nama Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Kembalian </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
			
		</thead>
		
	</table>
</div>
<br>

 <table>
  <tbody>

      <td style="font-size: 30px" width="50%">Total</td> <td style="font-size: 30px"> :&nbsp; </td> <td style="font-size: 30px"> <span id="totalan"></span> </td>
            
  </tbody>
  </table>
  <br><br>
       <a href='cetak_lap_pembelian_rekap.php' id="cetak_lap" class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Pembelian </a>
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
			$('#table_lap_pembelian_rekap').DataTable().destroy();
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
          var dataTable = $('#table_lap_pembelian_rekap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_pembelian_rekap.php", // json datasource
           	"data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_pembelian_rekap").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },

        });

        $.post("cek_total_rekap.php",{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(data){

		  		$("#totalan").html(data);

		  	});

    	$("#cetak_lap").attr("href", "cetak_lap_pembelian_rekap.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
        }//end else
        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>

<?php 
include 'footer.php';
 ?>