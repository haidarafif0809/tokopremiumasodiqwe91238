<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

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

 <div class="container">

<h3>LAPORAN RETUR PEMBELIAN REKAP </h3><hr>

<form class="form-inline" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y/m/d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-eye"></i> Tampil </button>

</form>

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="table_lapo" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Nama Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Tunai </th>
						
		</thead>
		<tbody>
			

		</tbody>

	</table>
</span>
</div> <!--/ responsive-->
<span id="table_tampil" style="display: none;">
	<div class="card card-block">

<div class="table-responsive">
<table id="table_lapo_retur_pembelian_rekap" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Nama Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Tunai </th>

		</thead>
	</table>
</div>
<br>


	<table>
	<tbody>
			
			
			<tr><td style="font-size: 30px" width="50%">Total</td> <td style="font-size: 30px"> :&nbsp; </td> <td style="font-size: 30px"><span id="totalane"></span> </td></tr>
			
	</tbody>
	</table>
<br>

       <a href='cetak_lap_retur_pembelian_rekap.php' class='btn btn-success' id="cetak_lap" target='blank'><i class='fa fa-print'> </i> Cetak Retur Pembelian </a>

</span>
</div> <!--/ container-->


		<script type="text/javascript">
		$("#submit").click(function(){
		$('#table_lapo_retur_pembelian_rekap').DataTable().destroy();
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
            $('#table_lapo').hide();
			$('#table_tampil').show();
		var dataTable = $('#table_lapo_retur_pembelian_rekap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_retur_pembelian_rekap.php", // json datasource
           	"data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lapo_retur_pembelian_rekap").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },

        });

        $.post("cek_total_retur_pembelian_rekap.php",{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(data){

		  		$("#totalane").html(data);

		  	});

		$("#cetak_lap").attr("href", "cetak_lap_retur_pembelian_rekap.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
        }//end else
        $("form").submit(function(){
        return false;
        });
		
		});
		
		</script>




<?php 
include 'footer.php';
 ?>