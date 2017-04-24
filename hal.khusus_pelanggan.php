<?php  include 'session_login.php';
    // memasukan file login, header, navbar, dan db.
    
    include 'header.php';
    include 'sanitasi.php';
    include 'db.php';

    $query = $db->query("SELECT * FROM perusahaan ORDER BY id");
    $oke = mysqli_fetch_array($query);
    $naper = $oke['nama_perusahaan'];

    $querypromo = $db->query("SELECT nama_promo,keterangan_promo FROM halaman_promo ORDER BY id");
    $promo = mysqli_fetch_array($querypromo);
    $napro = $promo['nama_promo'];
    $ketpro = $promo['keterangan_promo'];
    
?>



<div class="container">

<CENTER><h3>INFO HARGA PRODUK DI <?php echo $naper; ?></h3></CENTER>


<!-- Modal Tampilkan Produk yang promo -->
<div id="modal_produk_promo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

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

<div class="row"> 
  <center><img src='save_picture/<?php echo $oke['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='80%;' height='60%;'></center>
</div>
<div class="row">
          <div class="col-sm-3"></div>

          <span id="kode">
          <div class="col-sm-3">
              <div class="form-group"> 
                  <input type="text" name="kode_produk" id="kode_produk" class="form-control" placeholder="SILAKAN INPUT KODE PRODUK" required="">
              </div>
              <button type="submit" id="infonya" class="btn btn-primary" style="background-color:blue" ><i class="fa fa-eye"> </i> Lihat </button>
           </div>
          </span>

           <div class="col-sm-3"></div> 

</div>

    <div class="row">
      <span id="infoharga" style="display: none;">
      <div class="card card-block">
      <div class="col-sm-3"><button type="submit" id="kembali" class="btn btn-warning" style="background-color:green" ><i class="fa fa-reply"> </i> Kembali </button></div>
      <div class="col-sm-3">
      <!--div class="form-group">
      <label>Kode Produk</label>
        <input type="text" name="kode_produk" id="kode_produk">
      </div-->
      
      <div class="form-group">
      <label>Nama Produk</label>
        <input type="text" name="nama_produk" readonly="" id="nama_produk">
      </div>

      <div class="form-group">
      <label>Harga</label>
        <input type="text" name="harga_produk" readonly="" id="harga_produk">
      </div>
      </div>

      <div class="col-sm-3">
      <div class="form-group">
      <label>Satuan</label>
        <input type="text" name="satuan" readonly="" id="satuan">
      </div>

      <div class="form-group">
      <label>Jumlah Produk</label>
        <input type="text" name="jumlah_produk" readonly="" id="jumlah_produk">
      </div>
        </div>
      </div>
      </span>

</div><!--end row-->	
</div>

<script type="text/javascript">
    $(document).on('click','#infonya',function(e){
     
      var kode_produk = $("#kode_produk").val();
      var kode_produk = kode_produk.substr(0, kode_produk.indexOf('('));
      if (kode_produk == '') {
        alert("Silakan input kode produk.")
      }
          
      else{
        $.getJSON('cek_info_harga.php',{kode_produk:kode_produk},function(json){

         $("#kode").hide();
        $("#infoharga").show();
          $("#nama_produk").val(json.nama_barang);
          $("#harga_produk").val(tandaPemisahTitik(json.harga_jual));
          $("#satuan").val(json.satuan);
          if (json.jumlah_barang == null) {
          $("#jumlah_produk").val('0');
          }
          else{
          $("#jumlah_produk").val(tandaPemisahTitik(json.jumlah_barang));
          }
  });
      }
          
    });
    
</script>

<script type="text/javascript">
    $(document).on('click','#kembali',function(e){
      $("#kode").show();
        $("#infoharga").hide();
    });
</script>
<script type="text/javascript">
$(function() {
    $( "#kode_produk" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>

<!--script type="text/javascript">
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
		
</script-->

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

}(1000)); // define here seconds
</script>

<?php include 'footer.php' ?>