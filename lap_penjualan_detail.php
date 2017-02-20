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

<h3>LAPORAN PENJUALAN DETAIL </h3><hr>
<form class="form-inline" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control tanggal_cari" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control tanggal_cari" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" ><i class="fa fa-eye"> </i> Tampil </button>

</form>

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="tableuser" class="table table-bordered">
					<thead>
					<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
					<th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Satuan </th>
					<th style="background-color: #4CAF50; color: white;"> Harga </th>
					<th style="background-color: #4CAF50; color: white;"> Subtotal </th>
					<th style="background-color: #4CAF50; color: white;"> Potongan </th>
					<th style="background-color: #4CAF50; color: white;"> Tax </th>
      <?php 
             if ($_SESSION['otoritas'] == 'Pimpinan')
             {
             
             
             echo "<th style='background-color: #4CAF50; color: white;'> Hpp </th>";
             }
      ?>

					
					<th style="background-color: #4CAF50; color: white;"> Sisa Barang </th>
					
					
					</thead>
					
					<tbody>

					</tbody>
					
					</table>
</span>
</div> <!--/ responsive-->

<span id="table_tampil" style="display: none;">
      <td width="70%">Jumlah Item :&nbsp;  <span id="jumlah_item"></span></td><br>

      <td  width="70%">Total Subtotal :&nbsp; Rp. <span id="total_subtotal"></span></td><br>

      <td  width="70%">Total Potongan :&nbsp; Rp. <span id="total_potongan"></span></td><br>

      <td width="70%">Total Pajak :&nbsp; Rp. <span id="total_pajak"></span></td><br>
      
      <td  width="70%">Total Akhir :&nbsp; Rp. <span id="total_akhir"></span></td><br>

      <td  width="70%">Total Kredit :&nbsp; Rp. <span id="total_kredit"></span></td><br>

  	<div class="card card-block">

		<div class="table-responsive">
		 <table id="table_lap_penjualan_detail" class="table table-bordered">
							<thead>
							<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
							<th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
							<th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
							<th style="background-color: #4CAF50; color: white;"> Jumlah Barang </th>
							<th style="background-color: #4CAF50; color: white;"> Satuan </th>
							<th style="background-color: #4CAF50; color: white;"> Harga </th>
							<th style="background-color: #4CAF50; color: white;"> Subtotal </th>
							<th style="background-color: #4CAF50; color: white;"> Potongan </th>
							<th style="background-color: #4CAF50; color: white;"> Tax </th>
		      <?php 
		             if ($_SESSION['otoritas'] == 'Pimpinan')
		             {
		             
		             
		             echo "<th style='background-color: #4CAF50; color: white;'> Hpp </th>";
		             }
		      ?>

							
							<th style="background-color: #4CAF50; color: white;"> Sisa Barang </th>
							<th style="background-color: #4CAF50; color: white;"> Status </th>
							
				</thead>					
			</table>
		</div>

	<br>

       <a href='cetak_lap_penjualan_detail.php' id="cetak_lap" class='btn btn-success' target='blank' ><i class='fa fa-print'> </i> Cetak Penjualan </a>
	</div>
</span>

</div> <!--/ container-->

<script type="text/javascript">
//PICKERDATE
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  // /PICKERDATE
</script>

		<script type="text/javascript">
		$(document).on('click','#submit',function(e){
			$('#table_lap_penjualan_detail').DataTable().destroy();
			var dari_tanggal = $("#dari_tanggal").val();
      		var sampai_tanggal = $("#sampai_tanggal").val();

      		$.getJSON('ambil_total_seluruh.php',{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(json){

      $("#jumlah_item").html(tandaPemisahTitik(json.jml_item));
      $("#total_subtotal").html(tandaPemisahTitik(json.total_subtotal));
      $("#total_potongan").html(tandaPemisahTitik(json.total_potongan));
      $("#total_pajak").html(tandaPemisahTitik(json.total_tax));
      $("#total_akhir").html(tandaPemisahTitik(json.total_subtotal));
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
          var dataTable = $('#table_lap_penjualan_detail').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_penjualan_detail.php", // json datasource
           	"data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_penjualan_detail").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[12]+'');
            },

        });

        $("#cetak").show();
    	$("#cetak_lap").attr("href", "cetak_lap_penjualan_detail.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
        }//end else
        $("form").submit(function(){
        return false;
        });
		
		});
		
		</script>

<!--start ajax datatable-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_keterangan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_ket_jumpenjualan_detail.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");

             $("#table_keterangan").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#table_keterangan_processing").css("display","none");
              
            }
          }
        } );
      } );
    </script>
<!--end ajax datatable-->

<?php 
include 'footer.php';
 ?>