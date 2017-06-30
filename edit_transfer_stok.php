<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();   
$no_faktur = stringdoang($_GET['no_faktur']);  

$query_transfer_stok = $db->query("SELECT keterangan FROM transfer_stok WHERE no_faktur = '$no_faktur' ");
$data_transfer_stok = mysqli_fetch_array($query_transfer_stok);
$keterangan = $data_transfer_stok['keterangan'];                      


?>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div class="container">

<!-- membuat form menjadi beberpa bagian -->
<form enctype="multipart/form-data" role="form" action="form_item_masuk.php" method="post ">

<!-- membuat teks dengan ukuran h3 -->
<h3> EDIT TRANSFER STOK <?php echo $no_faktur; ?> </h3><hr>

  <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >

</form>


<!-- membuat tombol agar menampilkan modal -->
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari (F1) </button>


<br><br>

<div id="modal_alert" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
        
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-alert">
       </span>
      </div>

     </div>

      <div class="modal-footer">
              <h6 style="text-align: left"><i> 
              * Jika ingin mengedit jumlah harus lebih besar dari jumlah yang sudah keluar  <br>
        
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal modal_barang_tidak_bisa_dijual -->
<div id="modal_barang_tidak_bisa_dijual" class="modal " role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Produk Yang Tidak Bisa Di Transfer</h4>
      </div>
      <div class="modal-body">
            <center>
            <table class="table table-bordered table-sm">
                  <thead> <!-- untuk memberikan nama pada kolom tabel -->
                  
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>Jumlah Yang Akan Di Transfer</th>
                      <th>Stok Saat Ini</th>
                  
                  
                  </thead> <!-- tag penutup tabel -->
                  <tbody id="tbody-barang-jual">
                    
                  </tbody>
            </table>
            </center>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal modal_barang_tidak_bisa_dijual  -->


<!-- Tampilan Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Data Barang</h4>
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        <div class="table-responsive">                              
          <center>
            <table id="table_item_masuk" class="table table-bordered table-sm">
              <thead> <!-- untuk memberikan nama pada kolom tabel -->
              
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Jumlah Barang </th>
                <th> Kategori </th>
                <th> Suplier </th>
                <th> Satuan </th>
                <th> Harga Beli</th>
              
              </thead> <!-- tag penutup tabel -->
            </table>
          </center>
        </div>
      </div> <!-- tag penutup modal body -->

      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> <!--tag penutup moal footer -->
    </div>
  </div>
</div>

<div class="row">

  <div class="col-sm-8">

    <!-- membuat form -->
    <form class="form"  role="form" id="formtambahproduk">

       <div class="row"><!-- class row 1 -->
             <div class="form-group col-sm-4">
              <label><b>Dari Barang</b></label>
               <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
                <option value="">SILAKAN PILIH...</option>
                   <?php 

                    include 'cache.class.php';
                      $c = new Cache();
                      $c->setCache('produk');
                      $data_c = $c->retrieveAll();

                      foreach ($data_c as $key) {
                        echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga_beli="'.$key['harga_beli'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
                      }

                    ?>
                </select>
            </div>

        <input style="height: 15px" type="hidden" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
      
        <div class="form-group col-sm-4">
              <label><b>Tujuan Barang</b></label>
           <select style="font-size:15px; height:20px" type="text" name="barang_tujuan" id="barang_tujuan" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
            <option value="">SILAKAN PILIH...</option>
               <?php 

                  $cache_barang_tujuan = new Cache();
                  $cache_barang_tujuan->setCache('produk');
                  $data_barang = $cache_barang_tujuan->retrieveAll();

                  foreach ($data_barang as $barang_tujuan) {
                    echo '<option id="opt-produk-'.$barang_tujuan['kode_barang'].'" value="'.$barang_tujuan['kode_barang'].'" data-kode="'.$barang_tujuan['kode_barang'].'" nama-barang="'.$barang_tujuan['nama_barang'].'" harga_beli="'.$barang_tujuan['harga_beli'].'" harga="'.$barang_tujuan['harga_jual'].'" harga_jual_2="'.$barang_tujuan['harga_jual2'].'" harga_jual_3="'.$barang_tujuan['harga_jual3'].'" harga_jual_4="'.$barang_tujuan['harga_jual4'].'" harga_jual_5="'.$barang_tujuan['harga_jual5'].'" harga_jual_6="'.$barang_tujuan['harga_jual6'].'" harga_jual_7="'.$barang_tujuan['harga_jual7'].'" satuan="'.$barang_tujuan['satuan'].'" kategori="'.$barang_tujuan['kategori'].'" status="'.$barang_tujuan['status'].'" suplier="'.$barang_tujuan['suplier'].'" limit_stok="'.$barang_tujuan['limit_stok'].'" ber-stok="'.$barang_tujuan['berkaitan_dgn_stok'].'" tipe_barang="'.$barang_tujuan['tipe_barang'].'" id-barang="'.$barang_tujuan['id'].'" > '. $barang_tujuan['kode_barang'].' ( '.$barang_tujuan['nama_barang'].' ) </option>';
                  }

                ?>
            </select>
        </div>

        <input style="height: 15px" type="hidden" class="form-control" name="nama_barang_tujuan" id="nama_barang_tujuan" readonly="">

        <div class="form-group col-sm-1"><br>
          <input style="height: 15px; width:60px" type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" placeholder="Jumlah" autocomplete="off">
      </div>


      
        <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
        <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
        <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
        <input type="hidden" id="stok_barang" name="stok_barang" class="form-control" value="" required="">
        <input type="hidden" id="no_faktur" name="no_faktur" class="form-control" value="<?php echo $no_faktur; ?>" required="">

        <!-- membuat tombol submit-->
        <div class="form-group col-sm-3"><br>
          <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Submit (F3)</button>
        </div>

      </div><!-- classs row 2 -->
        </form>




  <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                <span id="span_tbs">            
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_transfer_stok" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->

                              <th> Kode Barang </th>
                              <th> Nama Barang </th>                              
                              <th> Kode Barang (Tujuan)</th>
                              <th> Nama Barang (Tujuan)</th>
                              <th> Satuan </th>
                              <th> Jumlah </th>
                              <!-- hilangkan harga dan subtotal
                              
                              <th> Harga </th>                              
                              <th> Subtotal </th>

                              -->

                              <th> Hapus </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>

                </span>

                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F4) untuk mencari Kode Produk (Tujuan)atau Nama Produk(Tujuan).</b></i></h6>


  </div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

  <div class="col-sm-4" id="col_sm_4"> <!--tag pembuka col sm 4-->
    
    <div class="card card-block">
      <form class="form"  role="form" id="form_item_masuk">

        <!--div class="col-sm-12"-->
          <!--label> <b> Total Akhir </b></label><br-->
          <input type="hidden" name="total" id="total_transfer" class="form-control" data-total="" placeholder="TOTAL AKHIR" readonly="" style="height: 15px" >
        <!--/div-->

        <div class="col-sm-12">
          <label> Keterangan </label><br>
          <textarea name="keterangan" id="keterangan" class="form-control"><?php echo $keterangan; ?></textarea> 
        </div>
        
        <input type="hidden" name="session_id" id="nomorfaktur" class="form-control" value="<?php echo $session_id; ?>">
        
        <button type="submit" id="transaksi_baru" class="btn btn-primary" style="display: none"> <i class='fa fa-refresh'> </i> Transaksi Baru (Alt + R)</a> </button>
        <button type="submit" id="pembayaran_transfer_stok" class="btn btn-info"> <i class='fa fa-send'> </i> Selesai (F8)</a> </button>
        <button type="submit" id="batal" class="btn btn-danger"> <i class='fa fa-close'> </i> Batal (F9)</a> </button>

      </form><!--tag penutup form-->
    </div>

    <div class="alert alert-success" id="alert_berhasil" style="display:none">
    <strong>Sukses!</strong> Transfer Stok  Berhasil !
    </div>

  </div><!-- end of col sm 4 -->

</div><!-- end of row -->

<span id="demo"> </span>


</div><!-- end of container -->


<script type="text/javascript">
  //SELECT CHOSSESN    
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});    
</script>

<script type="text/javascript">
//Choosen Open select
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});

</script>


<script type="text/javascript">
// START script untuk pilih kode barang menggunakan chosen     
  $(document).ready(function(){

    $(document).on('change','#kode_barang',function(){

      var kode_barang = $(this).val();
      var no_faktur = $("#no_faktur").val();
      var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
      var harga_beli = $('#opt-produk-'+kode_barang).attr("harga_beli");
      var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
      var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");

      $("#nama_barang").val(nama_barang);
      $("#satuan_produk").val(satuan);
      $("#id_produk").val(id_barang);
      $("#harga_produk").val(harga_beli);

      $.post('cek_kode_barang_transfer_stok.php',{no_faktur:no_faktur,kode_barang:kode_barang}, function(data){
        if (data > 0) {
                  alert("Barang yang anda pilih sudah ada, silahkan pilih barang lain!");
                  $("#kode_barang").val('').trigger("chosen:updated");
                  $("#kode_barang").trigger("chosen:open");
        }
        else{

              $.post('ambil_jumlah_transfer_stok.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
                if (data == "") {
                data = 0;
                }
                $("#stok_barang").val(data);
                });
                $("#barang_tujuan").val('').trigger("chosen:updated");
                $("#barang_tujuan").trigger("chosen:open");
            }
      });

    });


  }); 
  // end script untuk pilih kode barang menggunakan chosen   
</script>

<script type="text/javascript">
// START script untuk pilih kode barang menggunakan chosen     
  $(document).ready(function(){

    $(document).on('change','#barang_tujuan',function(){

      var barang_tujuan = $(this).val();
      var nama_barang = $('#opt-produk-'+barang_tujuan).attr("nama-barang");
      var kode_barang = $("#kode_barang").val();
      var no_faktur = $("#no_faktur").val();


      $("#nama_barang_tujuan").val(nama_barang);

      if (barang_tujuan == kode_barang) {
        alert("Tujuan barang tidak boleh sama dengan asal barang, silahkan pilih barang lain!");
          $("#barang_tujuan").val('').trigger("chosen:updated");
          $("#barang_tujuan").trigger("chosen:open");
      }
      else{
          $.post("cek_barang_transfer_stok.php",{kode_barang:kode_barang,barang_tujuan:barang_tujuan,no_faktur:no_faktur},function(data){

              if (data == 1) {
                  alert("Tujuan Barang yang anda pilih sudah ada, silahkan pilih barang lain!");
                  $("#barang_tujuan").val('').trigger("chosen:updated");
                  $("#barang_tujuan").trigger("chosen:open");
              };

          });
      };

    });
  }); 
  // end script untuk pilih kode barang menggunakan chosen   
</script>

<script>
//untuk menampilkan data tabel
$(document).ready(function(){
  // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_transfer_stok').DataTable().destroy();
            var dataTable = $('#tabel_tbs_transfer_stok').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "Tidak Ada Data Di Tabel Ini" },
            "ajax":{
              url :"data_tbs_transfer_stok.php", // json datasource
                   "data": function ( d ) {
                   d.no_faktur = $("#no_faktur").val();
                   // d.custom = $('#myInput').val();
                   // etc
                   },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_transfer_stok").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tabel_tbs_transfer_stok_processing").css("display","none");
                
              }
            }   

      });

        
        $("#span_tbs").show()
// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX
});

</script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#table_item_masuk").DataTable().destroy();
          var dataTable = $('#table_item_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_item_masuk_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_item_masuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('satuan', aData[7]);
              $(nRow).attr('harga', aData[6]);


          }

        }); 
});
</script>

<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
$(document).on('click', '.pilih', function (e) {
              
        var no_faktur = $("#no_faktur").val();
        var kode_barang = $(this).attr('data-kode');
        var nama_barang = $(this).attr('nama-barang');
        var satuan = $(this).attr('satuan');
        var harga = $(this).attr('harga');

        $.post('cek_kode_barang_transfer_stok.php',{no_faktur:no_faktur,kode_barang:kode_barang}, function(data){
        if (data > 0) {
                  alert("Barang yang anda pilih sudah ada, silahkan pilih barang lain!");
        }
        else{

              $("#kode_barang").val(kode_barang).trigger('chosen:updated');
              $("#nama_barang").val(nama_barang);
              $("#satuan_produk").val(satuan);
              $("#harga_produk").val(harga);
              
              $('#myModal').modal('hide');
      }
});

 });



</script>


<script>
//untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
$(document).on('click','#submit_produk',function(e){


var no_faktur = $("#no_faktur").val();
var kode_barang = $("#kode_barang").val();
var barang_tujuan = $("#barang_tujuan").val();
var satuan = $("#satuan_produk").val();
var nama_barang = $("#nama_barang").val();
var nama_barang_tujuan = $("#nama_barang_tujuan").val();
var harga = $("#harga_produk").val();
var session_id = $("#session_id").val();
var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_transfer").val()))));
var stok_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#stok_barang").val()))));


if (total == '') 
{
total = 0;
}

var sub_tbs = parseInt(harga,10) * parseInt(jumlah_barang,10);

var subtotal = parseInt(total,10) + parseInt(sub_tbs,10);
var hitung_sisa = parseInt(stok_barang,10) - parseInt(jumlah_barang,10);


if (jumlah_barang == ""){
    alert("Jumlah Barang Harus Diisi");
    $("#jumlah_barang").focus();
  }
  else if (hitung_sisa < 0){
    alert("Stok tidak Mencukupi");
    $("#jumlah_barang").val('');
    $("#jumlah_barang").focus();
  }
  else if (kode_barang == ""){
  alert("Kode Harus Diisi");
          $("#kode_barang").val('').trigger("chosen:updated");
          $("#kode_barang").trigger("chosen:open");
  }else if (kode_barang == ""){
alert("Kode Harus Diisi");
          $("#kode_barang").val('').trigger("chosen:updated");
          $("#kode_barang").trigger("chosen:open");
  }
  else if (barang_tujuan == ""){
alert("Tujuan Transfer Stok Harus Diisi");
          $("#barang_tujuan").val('').trigger("chosen:updated");
          $("#barang_tujuan").trigger("chosen:open");
  }
else
  {


      $("#total_transfer").val(tandaPemisahTitik(subtotal));

      $.post("proses_tbs_transfer_stok.php",{no_faktur:no_faktur,barang_tujuan:barang_tujuan,nama_barang_tujuan:nama_barang_tujuan,
        kode_barang:kode_barang,jumlah_barang:jumlah_barang,satuan:satuan,nama_barang:nama_barang,harga:harga},function(info) {


      });
         
         var tabel_tbs_transfer_stok = $('#tabel_tbs_transfer_stok').DataTable();
         tabel_tbs_transfer_stok.draw();
         $("#kode_barang").val('').trigger("chosen:updated");
         $("#kode_barang").trigger("chosen:open");
         $("#barang_tujuan").val('').trigger("chosen:updated");
         $("#jumlah_barang").val('');
         $("#span_tbs").show()


}

// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX

$("form").submit(function(){
return false;
});



});



</script>


<script>

$(document).ready(function(){
  var no_faktur = $("#no_faktur").val();

$.post("cek_total_transfer.php",{no_faktur:no_faktur},function(data){
        data = data.replace(/\s+/g, '');
$("#total_transfer").val(tandaPemisahTitik(data));
});

});

</script>


<script>

//perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
$("#pembayaran_transfer_stok").click(function(){

var total = $("#total_transfer").val();
var keterangan = $("#keterangan").val();
var no_faktur = $("#no_faktur").val();


    $.getJSON("cek_status_transfer_stok.php",{no_faktur:no_faktur},function(result){//$.getJSON("cek_status_stok_penjualan_inap.php

             if (result.status == 0) {// if (result.status == 0) {
               
                if (total == ""){
                  alert("Tidak Ada Total Transfer Stok");
                
                }
                else{
                
                  $("#pembayaran_transfer_stok").hide();
                  $("#batal").hide();
                  $("#transaksi_baru").show();
                  
                  $("#alert_berhasil").show();
                  $("#total_transfer").val('');
                  $("#keterangan").val('');
                  
                  $.post("proses_bayar_edit_transfer_stok.php",{no_faktur,total:total,keterangan:keterangan},function(info) {
                  });

                  var tabel_tbs_transfer_stok = $('#tabel_tbs_transfer_stok').DataTable();
                  tabel_tbs_transfer_stok.draw();
                
                  $("#span_tbs").show();
                }


             }// if (result.status == 0) {
              else
              {// else if (result.status == 0) {
             alert("Tidak Bisa Di Transfer, ada stok yang habis");
       
                 $("#tbody-barang-jual").find("tr").remove();

                $.each(result.barang, function(i, item) {//  $.each(result.barang, 

   
                  var tr_barang = "<tr><td>"+ result.barang[i].kode_barang+"</td><td>"+ result.barang[i].nama_barang+"</td><td>"+ result.barang[i].jumlah_jual+"</td><td>"+ result.barang[i].stok+"</td></tr>"
                  $("#tbody-barang-jual").prepend(tr_barang);

                });//  $.each(result.barang, 

                $("#modal_barang_tidak_bisa_dijual").modal('show');
             }// else if (result.status == 0) {
            
              });
$("#form_item_masuk").submit(function(){
return false;
});
});



</script>

          <script type="text/javascript">
            $(document).ready(function(){

//fungsi hapus data 
            $(document).on('click', '.btn-hapus', function (e) {

            var no_faktur = $("#no_faktur").val();
            var id = $(this).attr("data-id");
            var sub_total = $(this).attr("data-subtotal");
            var jumlah = $(this).attr("data-jumlah");
            var nama_barang = $(this).attr("data-nama-barang");
            var kode_barang_tujuan = $(this).attr("data-kode_tujuan");
            var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_transfer").val()))));

            if (total == '') 
              {
                total = 0;
              }

            else if (sub_total == '') {
                sub_total = 0;
              }
            
            var total_akhir = parseInt(total,10) - parseInt(sub_total,10);
            var jenis_aksi = 'Hapus';

             $.post("cek_hpp_transfer_stok.php",{no_faktur:no_faktur, jenis_aksi:jenis_aksi, jumlah:jumlah,id:id,kode_barang_tujuan:kode_barang_tujuan}, function(info){
                
                if (info < 0 ) {

                        $.post('modal_alert_hapus_data_transfer_stok.php',{no_faktur:no_faktur,kode_barang_tujuan:kode_barang_tujuan},function(data){
                      
                        $("#modal_alert").modal('show');
                        $("#modal-alert").html(data);
                    
                      });

                }
                else{


                     var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus '"+nama_barang+""+ "' ?");
                     if (pesan_alert == true) {
                     
                     $("#total_transfer").val(tandaPemisahTitik(total_akhir));
                     $.post("hapus_tbs_transfer_stok.php",{id:id},function(data){
                     
                     });
                     
                     
                     var tabel_tbs_transfer_stok = $('#tabel_tbs_transfer_stok').DataTable();
                     tabel_tbs_transfer_stok.draw();
                     $("#kode_barang").val('').trigger("chosen:updated");
                     $("#kode_barang").trigger("chosen:open");
                     $("#barang_tujuan").val('').trigger("chosen:updated");
                     
                     $("#span_tbs").show()
                     }
                };

// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX
           });

// 
// 
            });

            $('form').submit(function(){
            
            return false;
            });
            
            });
            

        </script>



<script type="text/javascript">
$(document).ready(function(){
  $("#batal").click(function(){

    var no_faktur = $("#no_faktur").val();

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Membatalkan Transaksi Ini ?");
    if (pesan_alert == true) {
        
        $.post("batal_tbs_transfer_stok.php",{no_faktur:no_faktur},function(data){

          window.location.href="transfer_stok.php";
        });
    } 

    else {
    
    }

  });
  });
</script>

<script type="text/javascript">
$(document).ready(function(){
  $("#transaksi_baru").click(function(){

          window.location.href="transfer_stok.php";
    

  });
  });
</script>



<script type="text/javascript">

$(document).on('dblclick','.edit-jumlah',function(){

          var id = $(this).attr("data-id");
          
          $("#text-jumlah-"+id+"").hide();
          
          $("#input-jumlah-"+id+"").attr("type", "text");

});


$(document).on('blur','.input_jumlah',function(){

var no_faktur = $("#no_faktur").val();
var id = $(this).attr("data-id");
var kode_barang = $(this).attr("data-kode");
var kode_barang_tujuan = $(this).attr("data-kode_tujuan");
var jumlah_baru = $(this).val();

if (jumlah_baru == "") {
  jumlah_baru = 0;
}
var harga = $(this).attr("data-harga");
var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
var subtotal = harga * jumlah_baru;
var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_transfer").val()))));
var jumlah_lama = $("#text-jumlah-"+id+"").text();

var total_akhir = parseInt(subtotal_penjualan) - parseInt(subtotal_lama) + parseInt(subtotal);

if (jumlah_baru == 0) {
  alert("Jumlah barang tidak boleh nol atau kosong");

  $("#input-jumlah-"+id+"").val(jumlah_lama);
  $("#text-jumlah-"+id+"").text(jumlah_lama);
  $("#text-jumlah-"+id+"").show();
  $("#input-jumlah-"+id+"").attr("type", "hidden");

}
else
{ 

    var no_faktur = $("#no_faktur").val();
    var jenis_aksi = "Edit";
   
   $.post("cek_hpp_transfer_stok.php",{no_faktur:no_faktur,jenis_aksi:jenis_aksi,kode_barang_tujuan:kode_barang_tujuan,jumlah_baru:jumlah_baru,id:id}, function(info){


      if (info < 0) {

           $.post('modal_alert_hapus_data_transfer_stok.php',{no_faktur:no_faktur,kode_barang_tujuan:kode_barang_tujuan},function(data){
                    
           $("#modal_alert").modal('show');
           $("#modal-alert").html(data);

          $("#input-jumlah-"+id+"").val(jumlah_lama);
          $("#text-jumlah-"+id+"").text(jumlah_lama);
          $("#text-jumlah-"+id+"").show();
          $("#input-jumlah-"+id+"").attr("type", "hidden");

        });

      }else{

              $.post('ambil_jumlah_transfer_stok.php',{kode_barang:kode_barang, no_faktur:no_faktur}, function(data){

                  if (data == "") {
                    data = 0;
                  }

                  var stok_barang = parseInt(data,10) + parseInt(jumlah_lama,10);

                  // hitung stok
                  var hitung_stok = parseInt(stok_barang,10) - parseInt(jumlah_baru,10);

                  if (hitung_stok < 0) {
                        alert("Stok barang tidak mencukupi!");
                        
                        $("#input-jumlah-"+id+"").val(jumlah_lama);
                        $("#text-jumlah-"+id+"").text(jumlah_lama);
                        $("#text-jumlah-"+id+"").show();
                        $("#input-jumlah-"+id+"").attr("type", "hidden");
                  }
                  else{

                        $("#total_transfer").val(tandaPemisahTitik(total_akhir));
                        $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
                        $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                        
                        $.post("update_jumlah_tbs_transfer_stok.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){
                        
                        $("#text-jumlah-"+id+"").show();
                        $("#text-jumlah-"+id+"").text(jumlah_baru);
                        $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                        $("#input-jumlah-"+id+"").attr("type", "hidden"); 
            
            
                        });
                  };

            });
      };

  });


    
}

$("#kode_barang").focus();

});

</script>    


<script> 
    shortcut.add("f2", function() {
        // Do something

         $("#kode_barang").trigger('chosen:open');


    });

    shortcut.add("f4", function() {
        // Do something

          $("#barang_tujuan").trigger('chosen:open');


    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#pembayaran_transfer_stok").click();

    }); 

    
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    }); 

    
    shortcut.add("f8", function() {
        // Do something

        $("#pembayaran_transfer_stok").click();

    }); 

    
    shortcut.add("alt+r", function() {
        // Do something

        $("#transaksi_baru").click();

    });

    
    shortcut.add("f9", function() {
        // Do something

        $("#batal").click();

    });
</script>

<!-- memasukan file footer.php -->
 <?php include 'footer.php'; ?>