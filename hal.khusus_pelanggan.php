<?php  include 'session_login.php';
    // memasukan file login, header, navbar, dan db.
    
    include 'header.php';
    include 'sanitasi.php';
    include 'db.php';

    $query = $db->query("SELECT nama_perusahaan FROM perusahaan ORDER BY id");
    $oke = mysqli_fetch_array($query);
    $naper = $oke['nama_perusahaan'];

    $querypromo = $db->query("SELECT nama_promo,keterangan_promo FROM halaman_promo ORDER BY id");
    $promo = mysqli_fetch_array($querypromo);
    $napro = $promo['nama_promo'];
    $ketpro = $promo['keterangan_promo'];
    
?>



<div style="padding-top: 5%; padding-bottom: 5%; padding-right: 5%; padding-left: 5%;">

<CENTER><h3>DAFTAR SEMUA PRODUK DI <?php echo $naper; ?></h3></CENTER>


<!-- Modal Tampilkan Produk yang promo -->
<div id="modal_produk_promo" class="modal modal-lg" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><b><?php echo $napro ?></b></h3>
      </div>
      <div class="modal-body">

      <marquee><h4><?php echo $ketpro ?></h4></marquee>
  </div>
				<div class ="modal-footer">
				<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
  </div>

  </div>
</div><!-- end of modal buat data  -->
<br><br><br>
<div class="table-responsive">
	<table id="table_khusus" class="table">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
            <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
            <th style='background-color: #4CAF50; color:white'> Harga Jual Level 1</th>
            <th style='background-color: #4CAF50; color:white'> Harga Jual Level 2</th>
            <th style='background-color: #4CAF50; color:white'> Harga Jual Level 3</th>
            <th style='background-color: #4CAF50; color:white'> Harga Jual Level 4</th>
            <th style='background-color: #4CAF50; color:white'> Harga Jual Level 5</th>
            <th style='background-color: #4CAF50; color:white'> Harga Jual Level 6</th>
            <th style='background-color: #4CAF50; color:white'> Harga Jual Level 7</th>
            <th style='background-color: #4CAF50; color:white'> Jumlah Barang </th>
            <th style='background-color: #4CAF50; color:white'> Satuan </th>
            <th style='background-color: #4CAF50; color:white'> Tipe Barang</th>
            <th style='background-color: #4CAF50; color:white'> Kategori </th>
		</thead>
	</table>	


</div>
	
</div>

<!--script type="text/javascript">
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script-->

<script type="text/javascript">
	$(document).ready(function(){
			$('#table_khusus').DataTable().destroy();
			
          var dataTable = $('#table_khusus').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_khusus_pelanggan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_khusus").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
         

        });
         
		
		});
	 
		
	function bukamodal() {

		}
		
</script>

<script type="text/javascript">
//untuk jika ke table penjualan awal
 (function(seconds) {
    var refresh,       
        intvrefresh = function() {
            clearInterval(refresh);
            refresh = setTimeout(function() {
		$(".modal").modal("show");
            }, seconds * 25);
        };

    $(document).on('keypress click', function() { intvrefresh() });
    intvrefresh();

}(300)); // define here seconds
</script>

<?php include 'footer.php' ?>