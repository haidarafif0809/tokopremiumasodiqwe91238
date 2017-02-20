<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>

<div class="container">

 <h3><b>DAFTAR DATA RETUR PENJUALAN</b></h3><hr>


<div class="dropdown">
             <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"> Jenis Laporan <span class="caret"></span></button>

             <ul class="dropdown-menu">
				<li><a href="lap_retur_penjualan_rekap.php"> Laporan Retur Penjualan Rekap </a></li> 
				<li><a href="lap_retur_penjualan_detail.php"> Laporan Retur Penjualan Detail </a></li>
				<!--
				<li><a href="lap_retur_penjualan_harian.php"> Laporan Retur Penjualan Harian </a></li>
				<li><a href="lap_pelanggan_detail.php"> Laporan Jual Per Pelanggan Detail </a></li>
				<li><a href="lap_pelanggan_rekap.php"> Laporan Jual Per Pelanggan Rekap </a></li>
				<li><a href="lap_sales_detail.php"> Laporan Jual Per Sales Detail </a></li>
				<li><a href="lap_sales_rekap.php"> Laporan Jual Per Sales Rekap </a></li>
				-->


             </ul>
</div> <!--/ dropdown-->


<br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="table_laporan_retur_penjualan" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Tunai </th>
		</thead>
		
	</table>
</span>
</div> <!--/ responsive-->
</div> <!--/ container-->


<script type="text/javascript">
	$(document).ready(function(){
          var dataTable = $('#table_laporan_retur_penjualan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_laporan_retur_penjualan.php", // json datasource
           	"data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_laporan_retur_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },

        });

        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>

<?php include 'footer.php'; ?>