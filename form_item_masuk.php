<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();

                           


?>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div class="container">

<!-- membuat form menjadi beberpa bagian -->
<form enctype="multipart/form-data" role="form" action="form_item_masuk.php" method="post ">

<!-- membuat teks dengan ukuran h3 -->
<h3> FORM ITEM MASUK </h3><hr>

  <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >

</form>


<!-- membuat tombol agar menampilkan modal -->
<button type="button" class="btn btn-info" id="cari_item_masuk" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari (F1) </button>
<br><br>
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

    <div class="form-group col-sm-3">
    <input style="height: 15px" type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode / Nama Produk" autocomplete="off">
    </div>

    <input style="height: 15px" type="hidden" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
   
    <div class="form-group col-sm-2">
    <input style="height: 15px" type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" placeholder="Jumlah" autocomplete="off">
    </div>

    <div class="form-group col-sm-2">
    <input style="height: 15px" type="text" class="form-control" name="hpp_item_masuk" id="hpp_item_masuk" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="Nilai Hpp" autocomplete="off">
    </div>


    <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
    <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
    <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
    <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >

    <!-- membuat tombol submit-->
    <label><br></label>
    <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah (F3)</button>
    </form>





  <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                <span id="span_tbs">            
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_item_masuk" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->

                              <th> Kode Barang </th>
                              <th> Nama Barang </th>
                              <th> Jumlah </th>
                              <th> Satuan </th>
                              <th> Harga </th>
                              <th> Subtotal </th>
                              <th> Hapus </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>

                </span>

                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>


  </div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

  <div class="col-sm-4" id="col_sm_4"> <!--tag pembuka col sm 4-->
    
    <div class="card card-block">
      <form class="form"  role="form" id="form_item_masuk">

        <div class="col-sm-12">
          <label> <b> Total Akhir </b></label><br>
          <input type="text" name="total" id="total_item_masuk" class="form-control" data-total="" placeholder="TOTAL AKHIR" readonly="" style="height: 15px" >
        </div>

        <div class="col-sm-12">
          <label> Keterangan </label><br>
          <textarea name="keterangan" id="keterangan" class="form-control" ></textarea> 
        </div>
        
        <input type="hidden" name="session_id" id="nomorfaktur" class="form-control" value="<?php echo $session_id; ?>">
        
        <button type="submit" id="transaksi_baru" class="btn btn-primary" style="display: none"> <i class='fa fa-refresh'> </i> Transaksi Baru (Alt + R)</a> </button>
        <button type="submit" id="pembayaran_item_masuk" class="btn btn-info"> <i class='fa fa-send'> </i> Selesai (F8)</a> </button>
        <button type="submit" id="batal" class="btn btn-danger"> <i class='fa fa-close'> </i> Batal (F9)</a> </button>

      </form><!--tag penutup form-->
    </div>

    <div class="alert alert-success" id="alert_berhasil" style="display:none">
    <strong>Sukses!</strong> Data Item Masuk Berhasil !
    </div>

  </div><!-- end of col sm 4 -->

</div><!-- end of row -->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Item Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Barang :</label>
     <input type="text" id="hapus_nama" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Item Masuk</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
                  <label> Jumlah Barang Baru </label> <br>
                  <input type="text" name="jumlah_baru" id="edit_jumlah" class="form-control" autocomplete="off" required="" >

                  <input type="hidden" name="jumlah_lama" id="edit_jumlah_lama" readonly="">

                  <input type="hidden" name="harga" id="edit_harga">

                  <input type="hidden" class="form-control" id="id_edit">

   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>

</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

</div>

  </div>
</div><!-- end of modal edit data  -->



<span id="demo"> </span>


</div><!-- end of container -->

<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $( "#kode_barang" ).focus();
  });

</script>

<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>


<script>
//untuk menampilkan data tabel
$(document).ready(function(){
  // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_item_masuk').DataTable().destroy();
            var dataTable = $('#tabel_tbs_item_masuk').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "Tidak Ada Data Di Tabel Ini" },
            "ajax":{
              url :"data_tbs_item_masuk.php", // json datasource
               "data": function ( d ) {
                  d.session_id = $("#session_id").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_item_masuk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
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
              $(nRow).attr('data-kode', aData[0]+"("+aData[1]+")");
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
document.getElementById("kode_barang").value = $(this).attr('data-kode');
document.getElementById("nama_barang").value = $(this).attr('nama-barang');
document.getElementById("satuan_produk").value = $(this).attr('satuan');
document.getElementById("harga_produk").value = $(this).attr('harga');



$('#myModal').modal('hide');
});

 


</script>


<script>
//untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
$("#submit_produk").click(function(){

var kode_barang = $("#kode_barang").val();
var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
var satuan = $("#satuan_produk").val();
var nama_barang = $("#nama_barang").val();
var harga = $("#harga_produk").val();
var session_id = $("#session_id").val();
var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
var hpp_item_masuk = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#hpp_item_masuk").val()))));
var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));


if (total == '') 
{
total = 0;
}

if (hpp_item_masuk == "") {
harga = harga;
}
else{
harga = hpp_item_masuk;
}




var sub_tbs = parseInt(harga,10) * parseInt(jumlah_barang,10);

var subtotal = parseInt(total,10) + parseInt(sub_tbs,10);


$("#kode_barang").val('');
$("#nama_barang").val('');
$("#jumlah_barang").val('');
$("#hpp_item_masuk").val('');

if (jumlah_barang == ""){
alert("Jumlah Barang Harus Diisi");
}
else if (kode_barang == ""){
alert("Kode Harus Diisi");
}

else
{


$("#total_item_masuk").val(tandaPemisahTitik(subtotal));

$("#hpp_item_masuk").val('');
$("#kode_barang").val('');
$("#nama_barang").val('');
$("#jumlah_barang").val('');

$.post("proses_tbs_item_masuk.php",{hpp_item_masuk:hpp_item_masuk,session_id:session_id,kode_barang:kode_barang,jumlah_barang:jumlah_barang,satuan:satuan,nama_barang:nama_barang,harga:harga},function(info) {


});

}

  // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_item_masuk').DataTable().destroy();
            var dataTable = $('#tabel_tbs_item_masuk').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "Tidak Ada Data Di Tabel Ini" },
            "ajax":{
              url :"data_tbs_item_masuk.php", // json datasource
               "data": function ( d ) {
                  d.session_id = $("#session_id").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_item_masuk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX

$("form").submit(function(){
return false;
});



});



</script>

<script>


//perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
$("#pembayaran_item_masuk").click(function(){

var total = $("#total_item_masuk").val();
var keterangan = $("#keterangan").val();
var session_id = $("#session_id").val();

$("#keterangan").val('');
$("#total_item_masuk").val('');


if (total == ""){
alert("Tidak Ada Total Item Masuk");
}


else
{

$("#pembayaran_item_masuk").hide();
$("#batal").hide();
$("#transaksi_baru").show();

$("#alert_berhasil").show();
$("#total_item_masuk").val('');
$("#keterangan").val('');

$.post("proses_bayar_item_masuk.php",{session_id:session_id,total:total,keterangan:keterangan},function(info) {



});

      $('#tabel_tbs_item_masuk').DataTable().destroy();
            var dataTable = $('#tabel_tbs_item_masuk').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data Di Tabel Ini" },
            "ajax":{
              url :"data_tbs_item_masuk.php", // json datasource
               "data": function ( d ) {
                  d.session_id = $("#session_id").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_item_masuk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()

}

// #result didapat dari tag span id=result

//mengambil no_faktur pembelian agar berurutan

$("#form_item_masuk").submit(function(){
return false;
});
});



</script>



<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','#transaksi_baru',function(e){

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
              $(nRow).attr('data-kode', aData[0]+"("+aData[1]+")");
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('satuan', aData[7]);
              $(nRow).attr('harga', aData[6]);


          }

        }); 

      $('#tabel_tbs_item_masuk').DataTable().destroy();
            var dataTable = $('#tabel_tbs_item_masuk').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data Di Tabel Ini" },
            "ajax":{
              url :"data_tbs_item_masuk.php", // json datasource
               "data": function ( d ) {
                  d.session_id = $("#session_id").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_item_masuk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()


            $("#transaksi_baru").hide();
            $("#alert_berhasil").hide();
            $("#pembayaran_item_masuk").show();
            $("#batal").show(); 
            $("#kode_barang").focus();
            

    });
  });

</script>


<script>

$(document).ready(function(){

var session_id = $("#session_id").val();

$.post("cek_total_item_masuk.php",
{
session_id: session_id 
},
function(data){
$("#total_item_masuk").val(data);
});

});

</script>



          <script type="text/javascript">
            $(document).ready(function(){


//fungsi hapus data 
            $(document).on('click', '.btn-hapus', function (e) {
            var id = $(this).attr("data-id");
            var sub_total = $(this).attr("data-subtotal");
            var nama_barang = $(this).attr("data-nama-barang");
            var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));

            if (total == '') 
              {
                total = 0;
              }

            else if (sub_total == '') {
                sub_total = 0;
              }


            
            var total_akhir = parseInt(total,10) - parseInt(sub_total,10);

            $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));

var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus '"+nama_barang+""+ "' ?");
if (pesan_alert == true) {

              $.post("hapus_tbs_item_masuk.php",{id:id},function(data){
            
            });
  
  // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_item_masuk').DataTable().destroy();
            var dataTable = $('#tabel_tbs_item_masuk').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "Tidak Ada Data Di Tabel Ini" },
            "ajax":{
              url :"data_tbs_item_masuk.php", // json datasource
               "data": function ( d ) {
                  d.session_id = $("#session_id").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_item_masuk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX
}
else{

}


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
    var session_id = $("#session_id").val()

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Membatalkan Transaksi Ini ?");
    if (pesan_alert == true) {
        
        $.get("batal_item_masuk.php",{session_id:session_id},function(data){

  // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_item_masuk').DataTable().destroy();
            var dataTable = $('#tabel_tbs_item_masuk').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "Tidak Ada Data Di Tabel Ini" },
            "ajax":{
              url :"data_tbs_item_masuk.php", // json datasource
               "data": function ( d ) {
                  d.session_id = $("#session_id").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_item_masuk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX

        });
    } 

    else {
    
    }

  });
  });
</script>

   <script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          var session_id = $("#session_id").val();
          
          $.post('cek_kode_barang_tbs_item_masuk.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)        

      $.getJSON('lihat_item_masuk.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#satuan_produk').val('');
        $('#harga_produk').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#satuan_produk').val(json.satuan);
        $('#harga_produk').val(json.harga_jual);
      }

        });
        
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

var id = $(this).attr("data-id");
var jumlah_baru = $(this).val();

if (jumlah_baru == "") {
  jumlah_baru = 0;
}
var harga = $(this).attr("data-harga");
var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
var subtotal = harga * jumlah_baru;
var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
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
  
  $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));
  $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
  $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
  
  $.post("update_jumlah_barang_tbs_item_masuk.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){
  
  
  
  $("#text-jumlah-"+id+"").show();
  $("#text-jumlah-"+id+"").text(jumlah_baru);
  $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
  $("#input-jumlah-"+id+"").attr("type", "hidden"); 
  
  
  });


}

$("#kode_barang").focus();

});

</script>    



  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));

 $.post('cek_kode_barang_tbs_item_masuk.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });
    //penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>


<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").focus();


    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#cari_item_masuk").click();

    }); 

    
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    }); 

    
    shortcut.add("f8", function() {
        // Do something

        $("#pembayaran_item_masuk").click();

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