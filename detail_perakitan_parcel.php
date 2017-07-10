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
  <h4> FORM DETAIL PARCEL</h4><hr> 
<!--
  <button type="button" class="btn btn-warning" id="cari_parcel" data-toggle="modal" data-target="#modalParcel"> <i class='fa fa-list'> </i> DATA PARCEL (F2)</button>
  -->
  <form class="form" role="form" id="formparcel">

    <div class=" card card-block">
    <div class="row">
      <div class="col-sm-2">
        <label>Kode Parcel</label>
        <input type="text" style="height:15px" class="form-control" name="kode_parcel" autocomplete="off" id="kode_parcel" readonly="" placeholder="KODE PARCEL">
      </div>

      <div class="col-sm-2">
        <label>Nama Parcel</label>
        <input style="height:15px;" type="text" class="form-control" name="nama_parcel" autocomplete="off" id="nama_parcel" placeholder="NAMA PARCEL">
      </div>

      <div class="col-sm-2">
        <label>Estimasi Hpp</label>
        <input style="height:15px;" type="text" class="form-control" name="estimasi_hpp" autocomplete="off" id="estimasi_hpp" readonly="" placeholder="ESTIMASI HPP">
      </div>

      <div class="col-sm-2">
        <label>Harga 1</label>
        <input style="height:15px;" type="text" class="form-control" name="harga_parcel_1" autocomplete="off" id="harga_parcel_1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 1">
      </div>

      <div class="col-sm-2">
        <label>Harga 2</label>
        <input style="height:15px;" type="text" class="form-control" name="harga_parcel_2" autocomplete="off" id="harga_parcel_2" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 2">
      </div>

      <div class="col-sm-2">
        <label>Harga 3</label>
        <input style="height:15px;" type="text" class="form-control" name="harga_parcel_3" autocomplete="off" id="harga_parcel_3" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 3">
      </div>



      <div class="col-sm-2">
        <label>Harga 4</label>
        <input style="height:15px;" type="text" class="form-control" name="harga_parcel_4" autocomplete="off" id="harga_parcel_4" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 4">
      </div>

      <div class="col-sm-2">
        <label>Harga 5</label>
        <input style="height:15px;" type="text" class="form-control" name="harga_parcel_5" autocomplete="off" id="harga_parcel_5" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 5">
      </div>

      <div class="col-sm-2">
        <label>Harga 6</label>
        <input style="height:15px;" type="text" class="form-control" name="harga_parcel_6" autocomplete="off" id="harga_parcel_6" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 6">
      </div>

      <div class="col-sm-2">
        <label>Harga 7</label>
        <input style="height:15px;" type="text" class="form-control" name="harga_parcel_7" autocomplete="off" id="harga_parcel_7" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 7">
      </div>

      <div class="col-sm-2">
        <label>Jumlah Parcel</label>
        <input style="height:15px;" type="text" class="form-control" name="jumlah_parcel" autocomplete="off" id="jumlah_parcel" placeholder="JUMLAH PARCEL">
      </div>


    </div>
    </div> <!-- END CARD BLOCK -->
  </form> <!-- END FORM -->




  <!-- Tampilan Modal DATA PARCEL
  <div id="modalParcel" class="modal" role="dialog">
    <div class="modal-dialog ">
    Isi Modal
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Data Parcel</h4>
        </div>
        <div class="modal-body">

          <div class="table-responsive">
          <span id="tabel-parcel">
            <table id="tabel_parcel" class="display table table-bordered table-sm">
              <thead>
              

                <th> Kode  </th>
                <th> Nama </th>
                <th> Harga 1</th>
                <th> Harga 2</th>
                <th> Harga 3</th>
                <th> Harga 4</th>
                <th> Harga 5</th>
                <th> Harga 6</th>
                <th> Harga 7</th>
                <th> Stok </th>

              
              </thead>
            </table>
          </span>
          </div>

        </div>
        
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> 
      </div>

    </div>
  </div>

   END Tampilan Modal DATA PARCEL --> <!-- END Tampilan Modal DATA PARCEL --> <!-- END Tampilan Modal DATA PARCEL -->

  <!-- membuat tombol agar menampilkan modal -->



  <button type="button" class="btn btn-info" id="cari_produk" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari Produk (F3)</button>

  <!-- Tampilan Modal -->
  <div id="myModal" class="modal" role="dialog">
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
  </div><!-- END Tampilan Modal Produk Parcel --> <!-- END Tampilan Modal Produk Parcel --> <!-- END Tampilan Modal Produk Parcel --> <!-- END Tampilan Modal Produk Parcel --> 


  <div class="row"><br>
    <form action="proses_tbs_item_masuk.php" role="form" id="formtambahproduk">


      <div class="col-sm-3">
      <label>Produk (F4)</label>
          <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
            <option value="">SILAKAN PILIH...</option>
               <?php 

                include 'cache.class.php';
                  $c = new Cache();
                  $c->setCache('produk');
                  $data_c = $c->retrieveAll();

                  foreach ($data_c as $key) {
                    
                      echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" data-harga="'.$key['harga_beli'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
                    
                    
                  }

                ?>
            </select>
      </div>
     



      <div class="col-sm-2">
        <input style="height: 20px" type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" placeholder="Jumlah Produk" autocomplete="off" >
      </div>
        
        <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah (F7)</button>

        <input type="hidden" class="form-control"  name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">

       
        <input type="hidden" name="id_produk" id="id_produk" class="form-control" required="" >
        <input type="hidden" name="harga_produk" id="harga_produk" class="form-control" required="" >

      <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >
      <input type="hidden" name="sisa_produk" id="sisa_produk" class="form-control" required="" >                                   
    </form>
  </div> <!-- END OF ROW --> <!-- END OF ROW --> <!-- END OF ROW --> <!-- END OF ROW --> <!-- END OF ROW --> <!-- END OF ROW -->

  <br>
                <span id="span_tbs">            
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_parcel" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th style='background-color: #4CAF50; color: white'> Kode Produk </th>
                              <th style='background-color: #4CAF50; color: white'> Nama Produk</th>
                              <th style='background-color: #4CAF50; color: white'> Jumlah Produk </th>
                              <th style='background-color: #4CAF50; color: white'> Total Produk </th>
                              <th style='background-color: #4CAF50; color: white'> Hpp Produk </th>
                              <th style='background-color: #4CAF50; color: white'> Total Hpp </th>
                              <th style='background-color: #4CAF50; color: white'> Satuan Produk</th>
                              <th style='background-color: #4CAF50; color: white'> Hapus Produk</th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>

                </span>
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F4) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>

  <button type="submit" id="simpan_produk" class="btn btn-primary"> <i class='fa fa-save'> </i> Simpan (F8)</button>
  <button type="submit" id="batal_produk" class="btn btn-danger"> <i class='fa fa-close'> </i> Batal (F9)</button>

  <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Sukses!</strong> Penyimpanan Berhasil
  </div>
  <button type="submit" style="display: none" id="transaksi_baru" class="btn btn-info"> <i class='fa fa-refresh'> </i>  Transaksi Baru (Ctrl+M)</button>

</div> <!-- END OF CONTAINER --> <!-- END OF CONTAINER --> <!-- END OF CONTAINER --> <!-- END OF CONTAINER --> <!-- END OF CONTAINER --> 

<!--
<script type="text/javascript">
$(document).ready(function(){
    
      var dataTable = $('#tabel_parcel').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_perakitan_parcel_tampil.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_parcel").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-parcel");
              $(nRow).attr('data-kode-parcel', aData[0]+" ("+aData[1]+")");
              $(nRow).attr('nama-barang-parcel', aData[1]);
              $(nRow).attr('data-jumlah-parcel', aData[9]);
              $(nRow).attr('data-id-produk-parcel', aData[10]);


          }
        });


});
</script>

-->


<script type="text/javascript">
  $(document).ready(function(){
    $.get("buat_kode_parcel.php",function(data){
      $("#kode_parcel").val(data);

        $('#tabel_tbs_parcel').DataTable().destroy();
      var dataTable = $('#tabel_tbs_parcel').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_parcel.php", // json datasource
               "data": function ( d ) {
                  d.kode_parcel = $("#kode_parcel").val();
                  d.jumlah_parcel = $("#jumlah_parcel").val();
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
  });
</script>

<script type="text/javascript">
$(document).ready(function(){
  $(document).on('keyup','#jumlah_parcel',function(e){    

    var kode_parcel = $("#kode_parcel").val();
    var jumlah_parcel = $("#jumlah_parcel").val();
    if (jumlah_parcel == "") {
      jumlah_parcel = 0;
    }

    var tabel_tbs_parcel = $('#tabel_tbs_parcel').DataTable();
        tabel_tbs_parcel.draw();
    $("#span_tbs").show();

    $.post("cek_estimasi_hpp.php", {kode_parcel:kode_parcel, jumlah_parcel:jumlah_parcel}, function(data){
        $("#estimasi_hpp"). val(tandaPemisahTitik(data));
    });

  });
});
</script>



<script type="text/javascript">

$(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger('chosen:updated');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("id_produk").value = $(this).attr('data-id-produk');
  document.getElementById("harga_produk").value = $(this).attr('data-harga');

  var kode_parcel =  $("#kode_parcel").val();
  var id_produk =  $("#id_produk").val();
  
  $.post('cek_tbs_parcel.php',{id_produk:id_produk, kode_parcel:kode_parcel}, function(data){
  
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


<!--

<script type="text/javascript">

$(document).on('click', '.pilih-parcel', function (e) {
  document.getElementById("nama_parcel_cari").value = $(this).attr('nama-barang-parcel');
  document.getElementById("session_id").value = $(this).attr('data-id-produk-parcel');
  document.getElementById("jumlah_parcel_cari").value = $(this).attr('data-jumlah-parcel');

  $('#modalParcel').modal('hide');

  // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
              $('#tabel_tbs_parcel').DataTable().destroy();
              var dataTable = $('#tabel_tbs_parcel').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "info":     false,
                    "language": { "emptyTable":     "My Custom Message On Empty Table" },
                    "ajax":{
                      url :"data_tbs_parcel.php", // json datasource
                       "data": function ( d ) {
                          d.kode_parcel = $("#kode_parcel").val();
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


// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX

});

</script>

-->

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
              $(nRow).attr('data-harga', aData[4]);


          }

      }); 
  });
</script>



<!--perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
<script>
  $(document).on('click','#submit_parcel',function(){

    var kode_parcel = $("#kode_parcel").val();
    var nama_parcel = $("#nama_parcel").val();
    var harga_parcel_1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_1").val()))));
    var harga_parcel_2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_2").val()))));
    var harga_parcel_3 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_3").val()))));
    var harga_parcel_4 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_4").val()))));
    var harga_parcel_5 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_5").val()))));
    var harga_parcel_6 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_6").val()))));
    var harga_parcel_7 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_7").val()))));
    var jumlah_parcel = $("#jumlah_parcel").val();
       

 if (kode_parcel == "") {
    alert ("SILAKAN ISI KODE PARCEL");
    $("#kode_parcel").focus();
 }

 else if (nama_parcel == "") {
    alert ("SILAKAN ISI NAMA PARCEL");
    $("#nama_parcel").focus();
 }

 else if (harga_parcel_1 == "") {
    alert ("SILAKAN ISI HARGA PARCEL 1");
    $("#harga_parcel_1").focus();
 }
 else if (jumlah_parcel == "") {
    alert ("SILAKAN ISI JUMLAH PARCEL 1");
    $("#jumlah_parcel").focus();
 }

 else
 {
    var kd_parcel = kode_parcel+" ("+nama_parcel+")";
    $("#tambah_parcel").click();    
    $("#kode_parcel_cari").val(kd_parcel);
    $("#nama_parcel_cari").val(nama_parcel);


  $.post("proses_input_parcel.php",{kode_parcel:kode_parcel, nama_parcel:nama_parcel, harga_parcel_1:harga_parcel_1, harga_parcel_2:harga_parcel_2, harga_parcel_3:harga_parcel_3, harga_parcel_4:harga_parcel_4, harga_parcel_5:harga_parcel_5, harga_parcel_6:harga_parcel_6, harga_parcel_7:harga_parcel_7,jumlah_parcel:jumlah_parcel},function(data){
     
     
      $('#tabel_tbs_parcel').DataTable().destroy();
      var dataTable = $('#tabel_tbs_parcel').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_parcel.php", // json datasource
               "data": function ( d ) {
                  d.kode_parcel = $("#kode_parcel").val();
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


    $("#kode_parcel").val('');
    $("#nama_parcel").val('');
    $("#harga_parcel_1").val('');
    $("#harga_parcel_2").val('');
    $("#harga_parcel_3").val('');
    $("#harga_parcel_4").val('');
    $("#harga_parcel_5").val('');
    $("#harga_parcel_6").val('');
    $("#harga_parcel_7").val('');
    $("#jumlah_parcel").val('');
     
     });
     
     var kode_parcel_cari = $("#kode_parcel_cari").val();
     var kode_parcel_cari = kode_parcel_cari.substr(0, kode_parcel_cari.indexOf(' ('));

     $.getJSON('ambil_session_id.php',{kode_parcel_cari:kode_parcel_cari}, function(json){
      
        if (json == null)
        {
          
          $('#session_id').val('');
        }

        else 
        {
          $('#session_id').val(json.id);
        }
      });
 }//END ELSE


  $("#formparcel").submit(function(){
    return false;
  });
    

}); //END FUNCITON CLICK
      
</script>
-->





<script>

$("#submit_produk").click(function(){

  var session_id = $("#session_id").val();
  var id_produk = $("#id_produk").val();
  var session_id = $("#session_id").val();
  var kode_parcel = $("#kode_parcel").val();
  var kode_barang = $("#kode_barang").val();
  var nama_barang = $("#nama_barang").val();
  var nama_parcel = $("#nama_parcel").val();
  var jumlah_barang = gantiTitik($("#jumlah_barang").val());
  var jumlah_parcel = $("#jumlah_parcel").val();
  var nama_parcel = $("#nama_parcel").val();
  var harga_produk = $("#harga_produk").val();


if (nama_parcel == "") {
      alert ("SILAKAN ISI NAMA PARCEL");
      $("#nama_parcel").focus();
   }
  else if (jumlah_parcel == "") {
      alert ("SILAKAN ISI JUMLAH PARCEL 1");
      $("#jumlah_parcel").focus();
   }  
       
  else if (kode_barang == ""){
    alert("Kode Produk Harus Diisi");
    $("#kode_barang").focus();
  }
  else if (jumlah_barang == ""){
    alert("Jumlah Produk Harus Diisi");
    $("#jumlah_barang").focus();
  }                         
  else
  {

    $.getJSON('lihat_sisa_produk_parcel.php',{kode_barang:kode_barang, jumlah_parcel:jumlah_parcel, jumlah_barang:jumlah_barang, id_produk:id_produk}, function(json){

        var jumlah_produk = json.jenis_hpp;
        var jumlah_parcel_yg_bisa_dibuat = json.jenis_transaksi;


      if (jumlah_produk < 0) {

            alert ("Persediaan Produk '"+nama_barang+"' Tidak Mencukupi Untuk Membuat '"+jumlah_parcel+"' Parcel '"+nama_parcel+"', Hanya Cukup Untuk Membuat '"+jumlah_parcel_yg_bisa_dibuat+"' Parcel '"+nama_parcel+"' !");
            $("#jumlah_parcel").val('');
            $("#jumlah_parcel").focus();
      }
      else{
            
            $.post("proses_isi_parcel.php",{harga_produk:harga_produk,id_produk:id_produk,kode_parcel:kode_parcel,jumlah_barang:jumlah_barang,session_id:session_id},function(data) {

              $("#nama_barang").val('');
              $("#kode_barang").val('');
              $("#kode_barang").trigger('chosen:updated');
              $("#kode_barang").trigger('chosen:open');
              $("#jumlah_barang").val('');
              $("#id_produk").val('');



              var tabel_tbs_parcel = $('#tabel_tbs_parcel').DataTable();
                  tabel_tbs_parcel.draw();

              $("#span_tbs").show();

            });

            $.post("cek_estimasi_hpp.php", {kode_parcel:kode_parcel, jumlah_parcel:jumlah_parcel}, function(data){
                $("#estimasi_hpp"). val(tandaPemisahTitik(data));
            });

      }

    });



  }
                                
      $("form").submit(function(){
      return false;
      });
                              
                              
});


 </script>


<script>

$("#simpan_produk").click(function(){

    var session_id = $("#session_id").val();
    var id_produk = $("#id_produk").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = gantiTitik($("#jumlah_barang").val());
    var jumlah_parcel = $("#jumlah_parcel").val();
    var kode_parcel = $("#kode_parcel").val();
    var nama_parcel = $("#nama_parcel").val();
    var harga_parcel_1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_1").val()))));
    var harga_parcel_2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_2").val()))));
    var harga_parcel_3 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_3").val()))));
    var harga_parcel_4 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_4").val()))));
    var harga_parcel_5 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_5").val()))));
    var harga_parcel_6 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_6").val()))));
    var harga_parcel_7 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_7").val()))));
    var estimasi_hpp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#estimasi_hpp").val()))));
    var range_estimasi = parseInt(harga_parcel_1) - parseInt(estimasi_hpp);
   

if (nama_parcel == "") {
      alert ("SILAKAN ISI NAMA PARCEL");
      $("#nama_parcel").focus();
   }

  else if (harga_parcel_1 == "") {
      alert ("SILAKAN ISI HARGA PARCEL 1");
      $("#harga_parcel_1").focus();
   }
  else if (jumlah_parcel == "") {
      alert ("SILAKAN ISI JUMLAH PARCEL 1");
      $("#jumlah_parcel").focus();
   }                       
  else
  {
    if (range_estimasi < 0) {

      var pesan_alert = confirm("Harga Jual Lebih Rendah Dari Estimasi HPP, Tetap Lanjutkan ?");
      if (pesan_alert == true) {

              $("#span_tbs").hide();
              $("#simpan_produk").hide();
              $("#batal_produk").hide();
              $("#alert_berhasil").show();
              $("#transaksi_baru").show();

              $.post("proses_simpan_parcel.php",{id_produk:id_produk,jumlah_barang:jumlah_barang,
              kode_parcel:kode_parcel, nama_parcel:nama_parcel, harga_parcel_1:harga_parcel_1, harga_parcel_2:harga_parcel_2, harga_parcel_3:harga_parcel_3, harga_parcel_4:harga_parcel_4, harga_parcel_5:harga_parcel_5, harga_parcel_6:harga_parcel_6, harga_parcel_7:harga_parcel_7,jumlah_parcel:jumlah_parcel},function(data) {

                $("#nama_barang").val('');
                $("#kode_barang").val('');
                $("#kode_barang").trigger('chosen:updated');
                $("#jumlah_barang").val('');
                $("#id_produk").val('');              
                $("#kode_parcel").val('');
                $("#nama_parcel").val('');
                $("#harga_parcel_1").val('');
                $("#harga_parcel_2").val('');
                $("#harga_parcel_3").val('');
                $("#harga_parcel_4").val('');
                $("#harga_parcel_5").val('');
                $("#harga_parcel_6").val('');
                $("#harga_parcel_7").val('');
                $("#jumlah_parcel").val('');

                var tabel_tbs_parcel = $('#tabel_tbs_parcel').DataTable();
                    tabel_tbs_parcel.draw();

                $("#span_tbs").show();

              });

      }
      else{
        $("#harga_parcel_1").focus();
      }

    }
    else{

              $("#span_tbs").hide();
              $("#simpan_produk").hide();
              $("#batal_produk").hide();
              $("#alert_berhasil").show();
              $("#transaksi_baru").show();

              $.post("proses_simpan_parcel.php",{id_produk:id_produk,jumlah_barang:jumlah_barang,
              kode_parcel:kode_parcel, nama_parcel:nama_parcel, harga_parcel_1:harga_parcel_1, harga_parcel_2:harga_parcel_2, harga_parcel_3:harga_parcel_3, harga_parcel_4:harga_parcel_4, harga_parcel_5:harga_parcel_5, harga_parcel_6:harga_parcel_6, harga_parcel_7:harga_parcel_7,jumlah_parcel:jumlah_parcel},function(data) {

                $("#nama_barang").val('');
                $("#kode_barang").val('');
                $("#kode_barang").trigger('chosen:updated');
                $("#jumlah_barang").val('');
                $("#id_produk").val('');              
                $("#kode_parcel").val('');
                $("#nama_parcel").val('');
                $("#harga_parcel_1").val('');
                $("#harga_parcel_2").val('');
                $("#harga_parcel_3").val('');
                $("#harga_parcel_4").val('');
                $("#harga_parcel_5").val('');
                $("#harga_parcel_6").val('');
                $("#harga_parcel_7").val('');
                $("#jumlah_parcel").val('');

                var tabel_tbs_parcel = $('#tabel_tbs_parcel').DataTable();
                    tabel_tbs_parcel.draw();

                $("#span_tbs").show();

              });

    }
            
  }
                                
      $("form").submit(function(){
      return false;
      });
                              
                              
});


 </script>





<script type="text/javascript">
  
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_parcel = $("#kode_parcel").val();
    var kode_barang = $(this).val();
    var harga_beli = $('#opt-produk-'+kode_barang).attr("data-harga");
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var id_produk = $('#opt-produk-'+kode_barang).attr("id-barang");


    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#harga_produk").val(harga_beli);
    $("#id_produk").val(id_produk);


  $.post('cek_tbs_parcel.php',{id_produk:id_produk, kode_parcel:kode_parcel}, function(data){
  
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



<!--
<script>

$("#simpan_produk").click(function(){

      
      $("#span_tbs").hide();
      $("#simpan_produk").hide();
      $("#alert_berhasil").show();
      $("#transaksi_baru").show();
                              
                              
});


 </script>

-->

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
  var harga_produk = $(this).attr("data-harga");
  var nama_barang = $(this).attr("data-nama-barang");
  var jumlah_lama = $("#text-jumlah-"+id+"").text();
  var jumlah_baru = $(this).val();
  var kode_parcel = $("#kode_parcel").val();
  var nama_parcel = $("#nama_parcel").val();
  var jumlah_parcel = $("#jumlah_parcel").val();

  if (jumlah_baru == '') {
  jumlah_baru = 0;
  }

  var dibelakang_koma = jumlah_baru.substr(-4);

  if (jumlah_baru == 0) {
      alert("Jumlah barang tidak boleh nol atau kosong");

      $("#input-jumlah-"+id+"").val(jumlah_lama);
      $("#text-jumlah-"+id+"").text(jumlah_lama);
      $("#text-jumlah-"+id+"").show();
      $("#input-jumlah-"+id+"").attr("type", "hidden");
  }
  else
  {


    $.getJSON('cek_stok_produk_parcel.php',{jumlah_parcel:jumlah_parcel,kode_barang:kode_barang, jumlah_baru:jumlah_baru, id_produk:id_produk, jumlah_lama:jumlah_lama}, function(json){

        var jumlah_produk = json.jenis_hpp;
        var jumlah_parcel_yg_bisa_dibuat = json.jenis_transaksi;


      if (jumlah_produk < 0) {
        console.log("!asdasd")

          alert ("Persediaan Produk '"+nama_barang+"' Tidak Mencukupi Untuk Membuat '"+jumlah_parcel+"' Parcel '"+nama_parcel+"', Hanya Cukup Untuk Membuat '"+jumlah_parcel_yg_bisa_dibuat+"' Parcel '"+nama_parcel+"' !");

          $("#input-jumlah-"+id+"").val(jumlah_lama);
          $("#text-jumlah-"+id+"").text(jumlah_lama);
          $("#text-jumlah-"+id+"").show();
          $("#input-jumlah-"+id+"").attr("type", "hidden");
          $("#jumlah_parcel").val('');
          $("#jumlah_parcel").focus();

      }

      else{ 

          if (dibelakang_koma == ",000" || dibelakang_koma == ",00" || dibelakang_koma == ",0") {
            jumlah_baru = hapusBelakangKoma(jumlah_baru);
          }
          else{
            jumlah_baru = jumlah_baru;
          }
            $("#text-jumlah-"+id+"").show();
            $("#text-jumlah-"+id+"").text(jumlah_baru);
            $("#input-jumlah-"+id+"").attr("type", "hidden");

          $.post("update_jumlah_produk_parcel.php",{jumlah_lama:jumlah_lama,id_produk:id_produk,jumlah_baru:jumlah_baru, kode_parcel:kode_parcel, harga_produk:harga_produk},function(){
            var tabel_tbs_parcel = $('#tabel_tbs_parcel').DataTable();
                tabel_tbs_parcel.draw();
            $("#span_tbs").show();
          });

          $.post("cek_estimasi_hpp.php", {kode_parcel:kode_parcel, jumlah_parcel:jumlah_parcel}, function(data){
              $("#estimasi_hpp"). val(tandaPemisahTitik(data));
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

  var kode_parcel = $("#kode_parcel").val();
  var jumlah_parcel = $("#jumlah_parcel").val();
  if (jumlah_parcel == "") {
    jumlah_parcel = 0;
  }

  var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus '"+nama_barang+"' "+ "?");
  if (pesan_alert == true) {

          $.post("hapus_tbs_parcel.php",{id:id},function(data){
            
          var tabel_tbs_parcel = $('#tabel_tbs_parcel').DataTable();
                  tabel_tbs_parcel.draw();

          $("#span_tbs").show()
          $("#kode_barang").trigger('chosen:open')  ;

          });

          $.post("cek_estimasi_hpp.php", {kode_parcel:kode_parcel, jumlah_parcel:jumlah_parcel}, function(data){
              $("#estimasi_hpp"). val(tandaPemisahTitik(data));
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




<script type="text/javascript">
$(document).ready(function(){
  $("#batal_produk").click(function(){
    var kode_parcel = $("#kode_parcel").val();
    var nama_parcel = $("#nama_parcel").val();

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Membatalkan Parcel '"+nama_parcel+"' "+ "?");
    if (pesan_alert == true) {
        
        $.get("batal_perakitan_parcel.php",{kode_parcel:kode_parcel},function(data){

          var tabel_tbs_parcel = $('#tabel_tbs_parcel').DataTable();
                  tabel_tbs_parcel.draw();

          $("#span_tbs").show();

        });
    } 

    else {
    
    }

  });
  });
</script>


<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','#transaksi_baru',function(e){

        var tabel_tbs_parcel = $('#tabel_tbs_parcel').DataTable();
                  tabel_tbs_parcel.draw();

          $("#span_tbs").show();

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
              $(nRow).attr('data-harga', aData[4]);


          }

      }); 

          $.get("buat_kode_parcel.php",function(data){
            $("#kode_parcel").val(data);
          });

            $("#transaksi_baru").hide();
            $("#alert_berhasil").hide();
            $("#simpan_produk").show();
            $("#batal_produk").show(); 
            $("#kode_barang").trigger("chosen:updated");
            $("#kode_barang").trigger("chosen:open");
            

    });
  });

</script>


<!-- SHORTCUT -->

<script> 
    shortcut.add("f4", function() {
        // Do something

        $("#kode_barang").trigger('chosen:open');

    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#btnParcel").click();

    }); 

    
    shortcut.add("f2", function() {
        // Do something

        $("#cari_parcel").click();

    }); 

    
    shortcut.add("f3", function() {
        // Do something

        $("#cari_produk").click();

    }); 
    
    shortcut.add("f7", function() {
        // Do something

        $("#submit_produk").click();

    }); 


    
    shortcut.add("f8", function() {
        // Do something

        $("#simpan_produk").click();

    }); 
    
    shortcut.add("f9", function() {
        // Do something

        $("#batal_produk").click();

    }); 
    
    shortcut.add("ctrl+m", function() {
        // Do something

        $("#transaksi_baru").click();

    }); 

    

</script>

<!-- SHORTCUT -->
<?php include 'footer.php'; ?>