<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>
<div class="container">
	<h4><b>Laporan Perubahan Harga Masal</b></h4>
<br>
<div class="card card-block">
<span id="perubahan_data">      
<div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->       
<table id="table_laporan_data" class="table table-bordered table-sm">
    <thead>
			<th style='background-color: #4CAF50; color:white'> Nomor </th>
			<th style='background-color: #4CAF50; color:white'> Kategori </th>
			<th style='background-color: #4CAF50; color:white'> Perubahan Harga </th>
			<th style='background-color: #4CAF50; color:white'> Acuan Harga </th>
			<th style='background-color: #4CAF50; color:white'> Pola Perubahan </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah Nilai </th>
			<th style='background-color: #4CAF50; color:white'> Petugas </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Status </th>
    </thead>
    
    <tbody>
    
    </tbody>

   </table>
  </div>
 </span>
</div>

</div>

<!--start ajax datatable-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_laporan_data').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"show_data_laporan_perubahan_harga_masal.php", // json datasource
            type: "post",  // method  , by default get

            error: function(){  // error handling
              $(".tbody").html("");

             $("#table_laporan_data").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#table_laporan_data_processing").css("display","none");
              
            }
          }
        } );
      } );
    </script>
<!--end ajax datatable-->

<?php 
include 'footer.php';
 ?>