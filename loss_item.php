<?php include_once 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


 ?>

<div class="container">
 	
<h4><b>Laporan Loss Item</b></h4>
<br>

<div class="card card-block">
<span id="perubahan_data">      
<div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->       
<table id="table_laporan_data" class="table table-bordered table-sm">
    <thead>

		<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
		<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
    <th style='background-color: #4CAF50; color:white'> Satuan </th>
    <th style='background-color: #4CAF50; color:white'> Total Terjual Bulan Lalu </th>

    </thead>
    

   </table>
  </div>

  <a href='cetak_loss_item.php' type='submit' target="blank" id="btn-print" class='btn btn-success'><i class="fa fa-print"> Print</i></a>

  <a href='download_loss_item.php' type='submit' target="blank" id="btn-download" class='btn btn-purple'><i class="fa fa-download"> Download Excel</i></a>

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
            url :"show_data_laporan_loss_item.php", // json datasource
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