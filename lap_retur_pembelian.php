<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>

<div class="container">

 <h3><b>DAFTAR DATA RETUR PEMBELIAN </b></h3><hr>


<div class="dropdown">
             <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"> Jenis Laporan <span class="caret"></span></button>

             <ul class="dropdown-menu">
				<li><a href="lap_retur_pembelian_rekap.php"> Laporan Retur Pembelian Rekap </a></li> 
				<li><a href="lap_retur_pembelian_detail.php"> Laporan Retur Pembelian Detail </a></li>
				<!--
				<li><a href="lap_retur_pembelian_harian.php"> Laporan Retur Pembelian Harian </a></li>
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
<table id="table_laporan_retur_pembelian" class="table table-bordered">
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
</span>
</div> <!--/ responsive-->
</div> <!--/ container-->

<script type="text/javascript">
	$(document).ready(function(){
          var dataTable = $('#table_laporan_retur_pembelian').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_laporan_retur_pembelian.php", // json datasource
           	
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_laporan_retur_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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