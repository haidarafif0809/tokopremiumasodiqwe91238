<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM item_keluar");

$session_id = session_id();


 ?>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>

<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div class="container">


      <h3> FORM ITEM KELUAR </h3><hr> 

<button type="button" class="btn btn-info" id="cari_item_keluar" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari (F1) </button>  <br><br>
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
            <table id="tabel_item_keluar" class="table table-bordered table-sm">
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


        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
      </div>

    </div>
  </div>


  <form enctype="multipart/form-data" role="form" action="form_item_keluar.php" method="post ">


      <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >

  </form>

<div class="row">

  <div class="col-sm-8">

      <!-- membuat form -->
      <form class="form"  role="form" id="formtambahproduk">
        
        <div class="form-group col-sm-3"> 
      <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
            <option value="">SILAKAN PILIH...</option>
       <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {

            if ($key['berkaitan_dgn_stok'] == 'Barang') {
              # code...
               echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_beli'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
            }
           
          }

        ?>
    </select>
        </div>

          <input type="hidden" class="form-control" name="nama_barang" id="nama_barang" readonly="" placeholder="Nama Barang">

        <div class="form-group col-sm-3">
          <input type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" autocomplete="off" placeholder="Jumlah Barang" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
        </div>

        
        <input type="hidden" id="jml_barang" name="jml_barang" class="form-control">
        <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
        <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >
        
        <!-- membuat tombol submit-->
        <label><br></label>
      <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah (F3)</button>

      </form>


                <span id="span_tbs">   
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_item_keluar" class="table table-bordered table-sm">
                          <thead> 

                              <th> Kode Barang </th>
                              <th> Nama Barang </th>
                              <th> Jumlah </th>
                              <th> Satuan </th>
                              <th> Harga </th>
                              <th> Subtotal </th>
                              <th> Hapus </th>
                          
                          </thead> 
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
          <input type="text" name="total" id="total_item_keluar" class="form-control" data-total="" placeholder="TOTAL AKHIR" readonly="" style="height: 15px" >
        </div>

        <div class="col-sm-12">
          <label> Keterangan </label><br>
          <textarea name="keterangan" id="keterangan" class="form-control" ></textarea> 
        </div>
        
        <input type="hidden" name="no_faktur" id="nomorfaktur" class="form-control" value="<?php echo $session_id; ?>">
        
        <button type="submit" id="transaksi_baru" class="btn btn-primary" style="display: none"> <i class='fa fa-refresh'> </i> Transaksi Baru (Alt + R)</a> </button>
        <button type="submit" id="pembayaran_item_keluar" class="btn btn-info"> <i class='fa fa-send'> </i> Selesai (F8)</a> </button>
        <button type="submit" id="batal" class="btn btn-danger"> <i class='fa fa-close'> </i> Batal (F9)</a> </button>

      </form><!--tag penutup form-->
    </div>

    <div class="alert alert-success" id="alert_berhasil" style="display:none">
    <strong>Sukses!</strong> Data Item Keluar Berhasil !
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
        <h4 class="modal-title">Konfirmasi Hapus Data Item Hapus</h4>
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

      <label> Jumlah Barang Lama </label> <br>
      <input type="text" name="jumlah_lama" id="edit_jumlah_lama" class="form-control" readonly="">

      <input type="hidden" name="kode_barang" id="kode_edit">
      <input type="hidden" name="harga" id="edit_harga">

      <input type="hidden" class="form-control" id="id_edit">

   </div>   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>

  <span id="alert"></span>
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


<script type="text/javascript">
  $(document).ready(function(){


  
    $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});

        var dataTable = $('#tabel_item_keluar').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_item_keluar_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_item_keluar").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
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

          $('#tabel_tbs_item_masuk').DataTable().destroy();
            var dataTable = $('#tabel_tbs_item_keluar').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "Tidak Ada Data Di Tabel Ini" },
            "ajax":{
              url :"data_tbs_item_keluar.php", // json datasource
              
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_item_masuk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });

   

});

  shortcut.add("f2", function() {
        // Do something
      $("#kode_barang").trigger('chosen:open');

    });

    shortcut.add("f8", function() {
        // Do something
      $("#pembayaran_item_keluar").click();

    });


    shortcut.add("f9", function() {
        // Do something
      $("#batal").click();

    });

    shortcut.add("f1", function() {
        // Do something
      $("#cari_item_keluar").click();

    });

    shortcut.add("f3", function() {
        // Do something
      $("#submit_produk").click();

    });


    $("#transaksi_baru").click(function(){

      $("#alert_berhasil").hide();
       var dataTable = $('#tabel_tbs_item_keluar').DataTable().draw();
      $(this).hide();
     $("#pembayaran_item_keluar").show();
     $("#batal").show();
        $("#kode_barang").trigger('chosen:updated');
       $("#kode_barang").trigger('chosen:open');


    });

    $("#batal").click(function(){
            var konfirmasi_batal = confirm("Apakah Anda Yakin Untuk Membatalkan Item Keluar Ini ?");

            if (konfirmasi_batal == true) {

               $.get('batal_item_keluar.php',function(data){
                    if (data == 1) {
                      //perbarui datatable
                       var dataTable = $('#tabel_tbs_item_keluar').DataTable().draw();
                       $("#total_item_keluar").val(0);
                    }
                    else {
                      alert('Terjadi kesalahan, Batal Item Keluar Gagal');
                    }
                });

            }
      
    });

</script>


<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $('.table').DataTable();
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
  document.getElementById("jml_barang").value = $(this).attr('jumlah-barang');
$("#kode_barang").trigger('chosen:updated');


  $('#myModal').modal('hide');
  });
   

// tabel lookup table_barang
  $(function () {
  $("#table_barang").dataTable();
  });



  </script>


   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

    var kode_barang = $("#kode_barang").val();

    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    var jml_barang = $("#jml_barang").val();
    var satuan = $("#satuan_produk").val();
    var harga = $("#harga_produk").val();
    var session_id = $("#session_id").val();
    var stok = jml_barang - jumlah_barang;

    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_keluar").val()))));


    if (total == '') 
    {
    total = 0;
    }



    var sub_tbs = parseInt(harga,10) * parseInt(jumlah_barang,10);

    var subtotal = parseInt(total,10) + parseInt(sub_tbs,10);



     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');               
                                    
      if (jumlah_barang == ""){
      alert("Jumlah Barang Harus Diisi");
      }
      else if (kode_barang == ""){
      alert("Kode Harus Diisi");
      }
      else if ( stok < 0){
      
      alert ("Jumlah Melebihi Stok!");
      
      }
      
      else
      {

        $("#total_item_keluar").val(tandaPemisahTitik(subtotal));
                                    
 $.post("proses_tbs_item_keluar.php",{session_id:session_id,kode_barang:kode_barang,jumlah_barang:jumlah_barang,satuan:satuan,nama_barang:nama_barang,harga:harga},function(info) {
    
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');

     var dataTable = $('#tabel_tbs_item_keluar').DataTable().draw();
       $("#kode_barang").trigger('chosen:open');
       
       });


      }  

      $("form").submit(function(){
      return false;
      });  


  });

//menampilkan no urut faktur setelah tombol click di pilih
   $("#cari_item_keluar").click(function() {

     $("#alert_berhasil").hide();

  });

   </script>


<script type="text/javascript">

   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran_item_keluar").click(function(){


var total = $("#total_item_keluar").val();
var keterangan = $("#keterangan").val();
var session_id = $("#session_id").val();




if (total == ""){
alert("Tidak Ada Total Item Masuk");
}
else
{
    
     $("#pembayaran_item_keluar").hide();
     $("#batal").hide();
     $("#transaksi_baru").show();

     $.post("proses_bayar_item_keluar.php",{session_id:session_id,total:total,keterangan:keterangan},function(info) {
                              

      $("#alert_berhasil").show();
      $("#total_item_keluar").val('');
      $("#keterangan").val('');



      var dataTable = $('#tabel_tbs_item_keluar').DataTable().draw();
});

 /*$.post($("#form_item_keluar").attr("action"), $("#form_item_keluar :input").serializeArray(), function(info) {
$("#demo").html(info);
     
     $("#alert_berhasil").show();
     
     $("#result").load("tabel_item_keluar.php");
     $("#pembayaran_item_keluar").val('');
     $("#keterangan").val();
     $("#total_item_keluar").val('');
     
  
    
       
   });*/
}

// #result didapat dari tag span id=result

//mengambil session_id pembelian agar berurutan

 $("#form_item_keluar").submit(function(){
    return false;
});
 });


  


      
  </script>




  
  <script>

$(document).ready(function(){

  var session_id = $("#session_id").val();

$.post("cek_total_item_keluar.php",
    {
        session_id: session_id
    },
    function(data){
        $("#total_item_keluar"). val(data);
    });

});


</script>




      <script type="text/javascript">
            $(document).ready(function(){
            
            
            //fungsi hapus data 
            $(document).on('click', '.btn-hapus', function (e) {



            var nama_barang = $(this).attr("data-nama-barang");
            var id = $(this).attr("data-id");
            var sub_total = $(this).attr("data-subtotal");
            var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_keluar").val()))));

             var konfirmasi_hapus = confirm("Apakah Anda Yakin Untuk Menghapus "+ nama_barang+" ?");
              if (konfirmasi_hapus == true) {
                  if (total == '') 
                  {
                    total = 0;
                  }

                  else if (sub_total == '') {
                   sub_total = 0;
                  }

                   var total_akhir = parseInt(total,10) - parseInt(sub_total,10);

                  $("#total_item_keluar").val(tandaPemisahTitik(total_akhir));




                        $.post("hapus_tbs_item_keluar.php",{id:id},function(data){
                        if (data == "sukses") {
                        $(".tr-id-"+id).remove();
                      }

                       var dataTable = $('#tabel_tbs_item_keluar').DataTable().draw();
                        });


              }// end konfirmasi hapus 
            

            });
      

              $('form').submit(function(){
              
              return false;
              });
        });

 

   </script> 

   <script type="text/javascript">
     
   $("#jumlah_barang").keyup(function(){
    var jumlah_barang = $("#jumlah_barang").val();
    var jml_barang = $("#jml_barang").val();
    var stok = jml_barang - jumlah_barang;

    if ( stok < 0){

      alert ("Jumlah Melebihi Stok!");
      $("#jumlah_barang").val('');
    }


  });

   </script>

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").change(function(){

          var kode_barang = $(this).val();
          var session_id = $("#session_id").val();

         
          
    $.post('cek_kode_barang_tbs_item_keluar.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
    
    if(data == 1){

    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

    $("#kode_barang").val('');
    $("#nama_barang").val('');


    }//penutup if
    else {

        //hitung stok

        $.post("cek_stok.php",{kode_barang: $("#kode_barang").val()},
          function(data){
          $("#jml_barang"). val(data);
          });
  
        $('#nama_barang').val($('#opt-produk-'+kode_barang).attr('nama-barang'));
        $('#satuan_produk').val($('#opt-produk-'+kode_barang).attr('satuan'));
        $('#harga_produk').val($('#opt-produk-'+kode_barang).attr('harga'));

    }

    
    });////penutup function(data)


     

       
        
        });
        });

      
      
</script>

                              <script type="text/javascript">
                                 
                  $(document).on('dblclick', '.edit-jumlah', function (e) { 

                         var id = $(this).attr("data-id");

                         $("#text-jumlah-"+id+"").hide();

                         $("#input-jumlah-"+id+"").attr("type", "text");

                    });


                       $(document).on('blur', '.input_jumlah',function(e){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var harga = $(this).attr("data-harga");
                                    var kode_barang = $(this).attr("data-kode");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
                                    var subtotal = harga * jumlah_baru;
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_keluar").val()))));

                                    
                                    var total_akhir = parseInt(subtotal_penjualan) - parseInt(subtotal_lama) + parseInt(subtotal);


                                    $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru},function(data){

                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                       $(this).val($(".text-jumlah-"+id+"").text());

                                     }

                                     else{


                                    $("#total_item_keluar").val(tandaPemisahTitik(total_akhir));
                                    $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);

                                    $.post("update_jumlah_barang_tbs_item_keluar.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");       
                                    
                                    
                                    });
                                    
                                     }

                                   });

                                   
                                   $("#kode_barang").focus();

                                 });

                             </script>

  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
  
  $("#kode_barang").trigger('chosen:updated');

 $.post('cek_kode_barang_tbs_item_keluar.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)
 
    });//penutup click(function()
  });//penutup ready(function()
</script>   


<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>