<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>


 <div class="container">

<h3> LAPORAN PEMBELIAN HUTANG </h3><hr>

<form class="form-inline" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary"> <i class="fa fa-eye"></i> Tampil </button>

</form>

 <br>
<div class="card card-block">

  <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
    <table id="table_laporan_pembelian_hutang" class="table table-bordered table-sm">
  		<thead>
  			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
  			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
  			<th style="background-color: #4CAF50; color: white;"> Suplier </th>
  			<th style="background-color: #4CAF50; color: white;"> Tanggal JT </th>
  			<th style="background-color: #4CAF50; color: white;"> Jam </th>
  			<th style="background-color: #4CAF50; color: white;"> User </th>
  			<th style="background-color: #4CAF50; color: white;"> Status </th>
  			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
  			<th style="background-color: #4CAF50; color: white;"> Tax </th>
        <th style="background-color: #4CAF50; color: white;"> Total </th>
  			<th style="background-color: #4CAF50; color: white;"> Sisa Kredit </th>
  			<th style="background-color: #4CAF50; color: white;"> Nilai Kredit </th>
  						
  		</thead>
  		<tbody>
  			

  		</tbody>

  	</table>
  </div> <!--/ responsive-->

</div> 

<span id="table_tampil" style="display: none;">
       <a href='cetak_laporan_pembelian_hutang.php' id="cetak_lap" class='btn btn-success' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Pembelian Hutang</a>
</span>

</div> <!--/ container-->

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

<script type="text/javascript">
	$(document).on('click','#submit',function(e){
			$('#table_laporan_pembelian_hutang').DataTable().destroy();
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
            
          var dataTable = $('#table_laporan_pembelian_hutang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_laporan_pembelian_hutang.php", // json datasource
           	"data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_laporan_pembelian_hutang").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },

        });

          $('#table_tampil').show();

          $("#cetak_lap").attr("href", "cetak_laporan_pembelian_hutang.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
        }//end else
        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>

<?php 
include 'footer.php';
 ?>