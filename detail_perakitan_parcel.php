<?php include 'session_login.php';
                             
//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
$id_parcel = $_GET['id'];
$kode_parcel = $_GET['kode_parcel'];

              
?>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div class="container">
  <h4> FORM DETAIL PARCEL</h4><hr> 

  <!-- membuat tombol agar menampilkan modal -->
  <button type="button" class="btn btn-info" id="cari_produk" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari Produk (F1)</button>


  <!-- Tampilan Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <!-- Isi Modal-->
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

                  <th> Kode Produk </th>
                  <th> Nama Produk </th>
                  <th> Jumlah Produk </th>
                  <th> Satuan Produk</th>
                  <th> Harga Produk</th>

                </thead> <!-- tag penutup tabel -->
              </table>
              </center>
          </div> 

        </div><!-- tag penutup modal body -->
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
      </div>

    </div>
  </div><!-- END Tampilan Modal --> <!-- END Tampilan Modal --> <!-- END Tampilan Modal --> <!-- END Tampilan Modal --> 

  <div class="row"><br>
    <form action="proses_tbs_item_masuk.php" role="form" id="formtambahproduk">

      <div class="col-sm-3">
          <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
            <option value="">SILAKAN PILIH...</option>
               <?php 

                include 'cache.class.php';
                  $c = new Cache();
                  $c->setCache('produk');
                  $data_c = $c->retrieveAll();

                  foreach ($data_c as $key) {
                    if ($key['berkaitan_dgn_stok'] == 'Barang') {
                      echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
                    }
                    
                  }

                ?>
            </select>
      </div>

      <div class="col-sm-3" style="display: none">
        <input type="text" class="form-control"  name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
      </div>

      <div class="col-sm-2">
        <input style="height: 20px" type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" placeholder="Jumlah Produk" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
      </div>

      <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah (F3)</button>

      <input type="hidden" name="id_parcel" id="id_parcel" class="form-control" value="<?php echo $id_parcel; ?>" required="" >
      <input type="hidden" name="id_produk" id="id_produk" class="form-control" required="" >
      <input type="hidden" name="kode_parcel" id="kode_parcel" class="form-control" value="<?php echo $kode_parcel; ?>" required="" >
      <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >
      <input type="hidden" name="sisa_produk" id="sisa_produk" class="form-control" required="" >                                   
    </form>
  </div> <!-- END OF ROW --> <!-- END OF ROW --> <!-- END OF ROW --> <!-- END OF ROW --> <!-- END OF ROW --> <!-- END OF ROW -->

  <br>
                <span id="span_tbs">            
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_parcel" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th> Kode Produk </th>
                              <th> Nama Produk</th>
                              <th> Jumlah Produk </th>
                              <th> Satuan Produk</th>
                              <th> Hapus Produk</th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>

                </span>
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>

  <button type="submit" id="simpan_produk" class="btn btn-primary"> <i class='fa fa-save'> </i> Simpan (F4)</button>

  <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Sukses!</strong> Penyimpanan Berhasil
  </div>
  <a class="btn btn-info" href="data_parcel.php" id="transaksi_baru" style="display: none"> <i class="fa fa-refresh"></i> Transaksi Baru </a>

</div> <!-- END OF CONTAINER --> <!-- END OF CONTAINER --> <!-- END OF CONTAINER --> <!-- END OF CONTAINER --> <!-- END OF CONTAINER --> 



<script type="text/javascript">
$(document).ready(function(){
  $('#tabel_tbs_parcel').DataTable().destroy();
      var dataTable = $('#tabel_tbs_parcel').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_parcel.php", // json datasource
               "data": function ( d ) {
                  d.id_parcel = $("#id_parcel").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_parcel").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });

  $("#span_tbs").show()
});
</script>



<script type="text/javascript">
  $(document).ready(function(){
    $("#table_item_masuk").DataTable().destroy();
          var dataTable = $('#table_item_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_produk_parcel.php", // json datasource
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
              $(nRow).attr('data-id-produk', aData[8]);


          }

      }); 
  });
</script>

<script type="text/javascript">

$(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger('chosen:updated');

  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("id_produk").value = $(this).attr('data-id-produk');

  var id_parcel =  $("#id_parcel").val();
  var id_produk =  $("#id_produk").val();
  
  $.post('cek_tbs_parcel.php',{id_produk:id_produk, id_parcel:id_parcel}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#kode_barang").trigger('chosen:updated');
    $("#kode_barang").trigger('chosen:open');
    $("#nama_barang").val('');
   }//penutup if
 });////penutup function(data)

  $('#myModal').modal('hide');
});

</script>



<script>

$("#submit_produk").click(function(){

  var session_id = $("#session_id").val();
  var id_produk = $("#id_produk").val();
  var id_parcel = $("#id_parcel").val();
  var kode_parcel = $("#kode_parcel").val();
  var kode_barang = $("#kode_barang").val();
  var nama_barang = $("#nama_barang").val();
  var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
   
       
  if (kode_barang == ""){
    alert("Kode Produk Harus Diisi");
    $("#kode_barang").focus();
  }
  else if (jumlah_barang == ""){
    alert("Jumlah Produk Harus Diisi");
    $("#jumlah_barang").focus();
  }                         
  else
  {

    $.getJSON('lihat_sisa_produk_parcel.php',{kode_barang:kode_barang, jumlah_barang:jumlah_barang, id_produk:id_produk}, function(json){

        var jumlah_produk = json.id_parcel;
        var nama_produk = json.id_produk;
        var sisa_produk = json.id;

      if (jumlah_produk < 0) {

            alert ("Jumlah Yang Di Masukan Melebihi Jumlah Stok. Persediaan Produk "+nama_produk+" Tersisa "+sisa_produk+" !");
            $("#nama_barang").val('');
            $("#kode_barang").val('');
            $("#jumlah_barang").val('');
            $("#id_produk").val('');
      }
      else{
            
            $.post("proses_isi_detail_parcel.php",{id_produk:id_produk,jumlah_barang:jumlah_barang,id_parcel:id_parcel},function(data) {

              $("#nama_barang").val('');
              $("#kode_barang").val('');
              $("#jumlah_barang").val('');
              $("#id_produk").val('');

            });

              $('#tabel_tbs_parcel').DataTable().destroy();
              var dataTable = $('#tabel_tbs_parcel').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "info":     false,
                    "language": { "emptyTable":     "My Custom Message On Empty Table" },
                    "ajax":{
                      url :"data_tbs_parcel.php", // json datasource
                       "data": function ( d ) {
                          d.id_parcel = $("#id_parcel").val();
                          // d.custom = $('#myInput').val();
                          // etc
                      },
                          type: "post",  // method  , by default get
                      error: function(){  // error handling
                        $(".tbody").html("");
                        $("#tabel_tbs_parcel").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                        $("#tableuser_processing").css("display","none");
                        
                      }
                    }   

              });

              $("#span_tbs").show();

      }

    });



  }
                                
      $("form").submit(function(){
      return false;
      });
                              
                              
});


 </script>





<script type="text/javascript">
  
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var id_parcel = $("#id_parcel").val();
    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var id_produk = $('#opt-produk-'+kode_barang).attr("id-barang");


    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#id_produk").val(id_produk);


  $.post('cek_tbs_parcel.php',{id_produk:id_produk, id_parcel:id_parcel}, function(data){
  
  if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").chosen("destroy");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#id_produk").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     



  });
  });
  });

      
      
</script>




<script>

$("#simpan_produk").click(function(){

      
      $("#span_tbs").hide();
      $("#simpan_produk").hide();
      $("#alert_berhasil").show();
      $("#transaksi_baru").show();
                              
                              
});


 </script>


 <script type="text/javascript">
                                 
$(document).on('dblclick','.edit-jumlah',function(e){

  var id = $(this).attr("data-id");

  $("#text-jumlah-"+id+"").hide();
  $("#input-jumlah-"+id+"").attr("type", "text");

});


$(document).on('blur','.input_jumlah',function(e){

  var id_produk = $(this).attr("data-id-produk");
  var id = $(this).attr("data-id");
  var kode_barang = $(this).attr("data-kode");
  var nama_barang = $(this).attr("data-nama-barang");
  var jumlah_lama = $("#text-jumlah-"+id+"").text();
  var jumlah_baru = $(this).val();
  var id_parcel = $("#id_parcel").val();

  if (jumlah_baru == '') {
  jumlah_baru = 0;
  }

  if (jumlah_baru == 0) {
      alert("Jumlah barang tidak boleh nol atau kosong");

      $("#input-jumlah-"+id+"").val(jumlah_lama);
      $("#text-jumlah-"+id+"").text(jumlah_lama);
      $("#text-jumlah-"+id+"").show();
      $("#input-jumlah-"+id+"").attr("type", "hidden");
  }
  else
  {


    $.getJSON('cek_stok_produk_parcel.php',{kode_barang:kode_barang, jumlah_baru:jumlah_baru, id_produk:id_produk, jumlah_lama:jumlah_lama}, function(json){

        var jumlah_produk = json.id_parcel;
        var nama_produk = json.id_produk;
        var sisa_produk = json.id;

      if (jumlah_produk < 0) {

          alert ("Jumlah Yang Di Masukan Melebihi Jumlah Stok. Persediaan Produk "+nama_produk+" Tersisa "+sisa_produk+" !");

          $("#input-jumlah-"+id+"").val(jumlah_lama);
          $("#text-jumlah-"+id+"").text(jumlah_lama);
          $("#text-jumlah-"+id+"").show();
          $("#input-jumlah-"+id+"").attr("type", "hidden");

      }

      else{


          $("#text-jumlah-"+id+"").show();
          $("#text-jumlah-"+id+"").text(jumlah_baru);
          $("#input-jumlah-"+id+"").attr("type", "hidden");

          $.post("update_jumlah_produk_parcel.php",{jumlah_lama:jumlah_lama,id_produk:id_produk,jumlah_baru:jumlah_baru, id_parcel:id_parcel},function(){

          });

      }

      });

  $("#kode_barang").trigger('chosen:open');

  }

});

</script>

<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');
});

</script>

<script type="text/javascript">      
     $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});        
</script>


<script type="text/javascript">
$(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){

  var id = $(this).attr("data-id");
  var id_produk = $(this).attr("data-id-produk");
  var kode_barang = $(this).attr("data-kode");
  var nama_barang = $(this).attr("data-nama");

  var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_barang+""+ "?");
  if (pesan_alert == true) {

          $.post("hapus_tbs_parcel.php",{id:id},function(data){
            
          $('#tabel_tbs_parcel').DataTable().destroy();
              var dataTable = $('#tabel_tbs_parcel').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "info":     false,
                    "language": { "emptyTable":     "My Custom Message On Empty Table" },
                    "ajax":{
                      url :"data_tbs_parcel.php", // json datasource
                       "data": function ( d ) {
                          d.id_parcel = $("#id_parcel").val();
                          // d.custom = $('#myInput').val();
                          // etc
                      },
                          type: "post",  // method  , by default get
                      error: function(){  // error handling
                        $(".tbody").html("");
                        $("#tabel_tbs_parcel").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                        $("#tableuser_processing").css("display","none");
                        
                      },
                               "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                $(nRow).attr('class','tr-id-'+aData[5]+'');         

                            }
                    }   

              });

          $("#span_tbs").show()
          $("#kode_barang").trigger('chosen:open')  ;

          });
  }
  else {
      
      }



});
      $('form').submit(function(){   
        return false;
      });


});
  
//end fungsi hapus data
</script>


<!-- SHORTCUT -->

<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").focus();

    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk").click();

    }); 

    
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    }); 


    
    shortcut.add("f4", function() {
        // Do something

        $("#simpan_produk").click();

    }); 

    

</script>

<!-- SHORTCUT -->
<?php include 'footer.php'; ?>