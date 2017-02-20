<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>


 <div class="container">

<h3> LAPORAN PENJUALAN PIUTANG </h3><hr>

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
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan</th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
		</thead>
		
	</table>
</span>
</div> <!--/ responsive-->

<span id="table_tampil" style="display: none;">
<table>
  <tbody>

      <tr><td  width="70%">Total Potongan</td> <td> :&nbsp; Rp. </td> <td><span id="total_potongan"></span></td></tr>
      <tr><td  width="70%">Total Pajak</td> <td> :&nbsp; Rp. </td> <td><span id="total_tax"></span></td></tr>
      <tr><td  width="70%">Total Kredit</td> <td> :&nbsp; Rp. </td> <td><span id="total_kredit"></span></td></tr>
      <tr><td  width="70%">Total Akhir</td> <td> :&nbsp; Rp. </td> <td><span id="total_akhir"></span></td>
      </tr>
            
  </tbody>
  </table>
  <br><br>
<div class="card card-block">
<div class="table-responsive">
 <table id="table_laporan_penjualan_piutang" class="table table-bordered">
            <thead>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan</th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Tunai </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
			
		</thead>
		
		</table>
</div>
<br>


       <a href='cetak_laporan_penjualan_piutang.php' id="cetak_lap" class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Penjualan Piutang</a>

</div>
<h3> Subtotal Piutang :  Rp. <span id="total_piutang"></span></h3>
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
			$('#table_laporan_penjualan_piutang').DataTable().destroy();
			var dari_tanggal = $("#dari_tanggal").val();
      		var sampai_tanggal = $("#sampai_tanggal").val();
      		$.getJSON("ambil_total_seluruh_piutang.php",{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(json){

		  $("#total_piutang").html(tandaPemisahTitik(json.total_piutang));
	      $("#total_potongan").html(tandaPemisahTitik(json.total_potongan));
	      $("#total_tax").html(tandaPemisahTitik(json.total_tax));
	      $("#total_akhir").html(tandaPemisahTitik(json.total_akhir));
	      $("#total_kredit").html(tandaPemisahTitik(json.total_kredit));

		  	});
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
          var dataTable = $('#table_laporan_penjualan_piutang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_laporan_penjualan_piutang.php", // json datasource
           	"data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_laporan_penjualan_piutang").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },

        });

        

    	$("#cetak_lap").attr("href", "cetak_laporan_penjualan_piutang.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
        }//end else
        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>


<?php 
include 'footer.php';
 ?>