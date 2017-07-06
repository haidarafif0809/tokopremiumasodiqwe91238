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

<br>
<CENTER><h3>INFO HARGA PRODUK DI <?php echo $naper; ?></h3></CENTER><hr>


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

<div class="card card-block">


<div class="row"> 
  <center><img src='save_picture/<?php echo $oke['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='40%;' height='30%;'></center>
</div>

<div class="row">

<div class="col-sm-3"></div>

  <span id="kode">
            <div class="col-sm-5">
                <div class="form-group"><br>

                      <label>Cari Produk</label><br>
                       <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
                        <option value="">SILAKAN PILIH...</option>
                           <?php 

                            include 'cache.class.php';
                              $c = new Cache();
                              $c->setCache('produk');
                              $data_c = $c->retrieveAll();

                              foreach ($data_c as $key) {
                                echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
                              }

                              $cache_parcel = new Cache();
                              $cache_parcel->setCache('produk_parcel');
                              $data_parcel = $cache_parcel->retrieveAll();

                              foreach ($data_parcel as $key_parcel) {
                                echo '<option id="opt-produk-'.$key_parcel['kode_parcel'].'" value="'.$key_parcel['kode_parcel'].'" data-kode="'.$key_parcel['kode_parcel'].'"> '. $key_parcel['kode_parcel'].' ( '.$key_parcel['nama_parcel'].' ) </option>';
                              }

                            ?>
                      </select>
                </div>
                
             </div>

    <div class="col-sm-1">
    <br>
      <button type="submit" id="infonya" class="btn btn-info btn-floating" style="height: 45px; width: 45px"> <i class="fa fa-search"></i> </button>
    </div> 

  </span>

</div>

  <span id="infoharga" style="display: none">

      <div class="form-group row" style="padding-left: 150px">

            <div class="col-sm-2">
              <label>Nama Produk</label>
                <input type="text" style="height: 20px" name="nama_produk" readonly="" id="nama_produk">
            </div>

            <div class="col-sm-2">
              <label>Harga Produk</label>
                <input type="text" style="height: 20px" name="harga_produk" readonly="" id="harga_produk">
            </div>

            <div class="col-sm-2">
              <label>Satuan Produk</label>
                <input type="text" style="height: 20px" name="satuan" readonly="" id="satuan">
            </div>
 
            <div class="col-sm-2">
              <label>Jumlah Produk</label>
                <input type="text" style="height: 20px" name="jumlah_produk" readonly="" id="jumlah_produk">
            </div>

            <div class="col-sm-2">
              <button type="submit" id="kembali" class="btn btn-warning" style="background-color:green" ><i class="fa fa-reply"> </i> Kembali </button>
            </div>

      </div>

    </span>
  
</div><!-- /CARD BLOCK -->

</div>

<script>
  $(document).ready(function(){
    $("#kode_barang").trigger('chosen:updated');
    $("#kode_barang").trigger('chosen:open');
  });
</script>

<script type="text/javascript">
// START script untuk pilih kode barang menggunakan chosen     
$(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_barang = $(this).val();
    $("#kode_barang").val(kode_barang);
    

  });
}); 
// end script untuk pilih kode barang menggunakan chosen   
</script>

<script type="text/javascript">
    $(document).on('click','#infonya',function(e){
     
      var kode_produk = $("#kode_barang").val();
      if (kode_produk == '') {
        alert("Silakan Cari Produk Dahulu")
      }
          
      else{
        $.getJSON('cek_info_harga.php',{kode_produk:kode_produk},function(json){

          $("#kode").hide();
          $("#infoharga").show();
          $("#nama_produk").val(json.nama_barang);
          $("#harga_produk").val(tandaPemisahTitik(json.harga_jual));
          $("#satuan").val(json.satuan);
          
          if (json.kode_barang == null) {
            $("#jumlah_produk").val('0');
          }
          else{
            $("#jumlah_produk").val(tandaPemisahTitik(json.kode_barang));
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


<script type="text/javascript">
  //SELECT CHOSSESN    
  $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});    
</script>

<?php include 'footer.php' ?>