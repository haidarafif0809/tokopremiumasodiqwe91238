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
<!-- js untuk tombol shortcut -->
<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div class="container">


<!--membuat agar tabel berada dalam baris tertentu-->
   <div class="row">
 <!--membuat tampilan halaman menjadi 8 bagian-->


  <!-- membuat form menjadi beberpa bagian -->
         <form enctype="multipart/form-data" role="form" action="form_item_keluar.php" method="post ">
          
          <!-- membuat teks dengan ukuran h3 -->
          <h3> <u>FORM ITEM KELUAR</u> </h3><br> 
   

          <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
          <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >
          
         </form>
  
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
       <table id="table_item_keluar" class="table table-bordered table-sm">
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


      <div class="col-sm-8">

      <!-- membuat tombol agar menampilkan modal -->
<button type="button" class="btn btn-info" id="cari_item_keluar1" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari</button>
<br>

<!-- membuat form -->
 <form class="form-control" action="proses_tbs_item_keluar.php" role="form" id="formtambahproduk">
  

  <!-- agar tampilan berada pada satu group -->
  <!-- memasukan teks pada kolom kode barang -->
  <div class="col-sm-4"> 

    <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
    <option value="">SILAKAN PILIH...</option>
       <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

        ?>
    </select>

  <input type="hidden" class="form-control" name="nama_barang" id="nama_barang" readonly="" >
  </div>
<div class="col-sm-2">
    <input style="height: 20px; width: 70px" type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" autocomplete="off" placeholder="Jumlah " onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
  </div>

  
 <input type="hidden" id="jml_barang" name="jml_barang" class="form-control">
<!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
  <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
  <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="" placeholder="harga produk">
  <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >
  
  <!-- membuat tombol submit-->

  <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
</form>


      <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
      <span id="result">  

        <div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->     
  <table id="tableuser" class="table table-bordered table-sm">
    <thead>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah </th>
      <th> Satuan </th>
      <th> Hapus </th>
      
    </thead>
    
    <tbody id="tbody">
    <?php

    //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
     $perintah = $db->query("SELECT tik.id,tik.no_faktur,tik.kode_barang,tik.nama_barang,tik.jumlah,tik.harga,tik.subtotal,s.nama FROM tbs_item_keluar tik LEFT JOIN satuan s ON tik.satuan = s.id WHERE tik.session_id = '$session_id'");

      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {
        //menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."'  value='".$data1['jumlah']."' class='input_jumlah' data-subtotal='".$data1['subtotal']."' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."' > </td>

      <td>". $data1['nama'] ."</td>
      <td> <button class='btn btn-sm btn-danger btn-hapus' id='btn-hapus-".$data1['id']."' data-subtotal='".$data1['subtotal']."' data-id='". $data1['id'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
      
    ?>
    </tbody>

  </table>
  </div>
        </span>
                  
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>
  </div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

 <div class="col-sm-3" id="col_sm_4"> <!--tag pembuka col sm 4-->

  <form action="proses_bayar_item_keluar.php" id="form_item_keluar" method="POST"><!--tag pembuka form-->

      <input type="hidden" name="total" id="total_item_keluar" class="form-control" placeholder="Total" readonly=""  >

      <label>Keterangan </label><br>
      <textarea name="keterangan" style="height: 80px" id="keterangan" class="form-control"></textarea>

      <input type="hidden" name="session_id" id="nomorfaktur" class="form-control" value="<?php echo $session_id; ?>">

        <a class="btn btn-primary" href="form_item_keluar.php" id="transaksi_baru" style="display: none"> <i class='fa fa-refresh'> </i> Transaksi Baru</a>
  <!--membuat tombol submit bayar & Hutang-->
      <button type="submit" id="pembayaran_item_keluar" class="btn btn-info"><i class='fa fa-send'> </i> Selesai </a> </button>
      

      <!--membuaat link pada tombol batal-->
      <a href='batal_item_keluar.php?session_id=<?php echo $session_id;?>' id='batal' class='btn btn-danger'><i class='fa fa-close'></i> Batal </a>
     

          </form><!--tag penutup form-->

<div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Data Item Keluar Berhasil
</div>
  </div><!-- end of col sm 4 -->
</div><!-- end of row -->



      <span id="demo"> </span>

</div><!-- end of container -->

<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});

</script>


      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});  
      
      </script>

                              
<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#tableuser').DataTable({"ordering":false});
    });

</script>   

<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").trigger('chosen:open');


    });   
  </script>              
          

<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {



  document.getElementById("kode_barang").value = $(this).attr('data-kode');

  $("#kode_barang").trigger('chosen:updated');


  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("harga_produk").value = $(this).attr('harga');
  document.getElementById("jml_barang").value = $(this).attr('jumlah-barang');


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
                                                           
                                    
      if (jumlah_barang == ""){
      alert("Jumlah Barang Harus Diisi");
      $("#jumlah_barang").focus();   
      }
      else if (kode_barang == ""){
      alert("Kode Harus Diisi");


    $("#kode_barang").trigger('chosen:open');


      }
      else if (stok < 0){
      
      alert ("Jumlah Melebihi Stok!");
      $("#jumlah_barang").val('');
      $("#jumlah_barang").focus();
      
      }
      
      else
      {

        $("#total_item_keluar").val(tandaPemisahTitik(subtotal));    

     $.post("proses_tbs_item_keluar.php",{session_id:session_id,kode_barang:kode_barang,jumlah_barang:jumlah_barang,satuan:satuan,nama_barang:nama_barang,harga:harga},function(info) {

     $("#tbody").prepend(info);
     $("#kode_barang").val('').trigger("chosen:updated");
     $("#kode_barang").trigger('chosen:open');
     $("#jumlah_barang").val('');
       
       });


      }  

      $("form").submit(function(){
      return false;
      });  


  });

/*/menampilkan no urut faktur setelah tombol click di pilih
   $("#cari_item_keluar1").click(function() {
     $.get('no_faktur_IK.php', function(data) {
   /*optional stuff to do after getScript 
$("#nomorfaktur").val(data);
$("#nomorfaktur1").val(data);

 });
//menyembunyikan notif berhasil
     $("#alert_berhasil").hide();
    /* Act on the event 
  

  });*/

   </script>

<script type="text/javascript">
    $(document).ready(function(){

           $("#table_item_keluar").DataTable().destroy();
          var dataTable = $('#table_item_keluar').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_item_keluar_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_item_keluar").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('satuan', aData[7]);
              $(nRow).attr('harga', aData[6]);
              $(nRow).attr('jumlah-barang', aData[2]);

          }

        });
        }); 
</script>

<script type="text/javascript">

   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran_item_keluar").click(function(){


var total = $("#total_item_masuk").val();
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

 $.post($("#form_item_keluar").attr("action"), $("#form_item_keluar :input").serializeArray(), function(info) {
$("#demo").html(info);
     
     $("#alert_berhasil").show();
     
     $("#result").html("");
     $("#pembayaran_item_keluar").val('');
     $("#keterangan").val();
     $("#total_item_keluar").val('');
     
  
    
       
   });
}

// #result didapat dari tag span id=result

//mengambil session_id pembelian agar berurutan

 $("#form_item_keluar").submit(function(){
    return false;
});
 });


  
      
  </script>




  
  <script type="text/javascript">

$(document).ready(function(){

  var session_id = $("#session_id").val();

$.post("cek_total_item_keluar.php",
    {
        session_id: session_id
    },
    function(data){
      data = data.replace(/\s+/g, '');
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
            if (data != "") {
            
            $(".tr-id-"+id).remove();

            $("#kode_barang").val('').trigger("chosen:updated");
             $("#kode_barang").trigger('chosen:open');
            
            }
            });
            });
      

              $('form').submit(function(){
              
              return false;
              });
        });

   </script> 

   <script type="text/javascript">
     
   $("#jumlah_barang").keyup(function(){
    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    var jml_barang = $("#jml_barang").val();
    var stok = jml_barang - jumlah_barang;

    if ( stok < 0){

      alert ("Jumlah Melebihi Stok!");
      $("#jumlah_barang").val('');
    }


  });

   </script>


<script type="text/javascript">
               
    $(document).on('dblclick', '.edit-jumlah', function (e) {

          var id = $(this).attr("data-id");

          $("#text-jumlah-"+id+"").hide();

          $("#input-jumlah-"+id+"").attr("type", "text");

       });

       $(document).on('blur', '.input_jumlah', function (e) {

          var id = $(this).attr("data-id");
          var jumlah_baru = $(this).val();
          var harga = $(this).attr("data-harga");
          var kode_barang = $(this).attr("data-kode");
          $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru},function(data){

             if (data == "ya") {

             alert ("Jumlah Yang Di Masukan Melebihi Stok !");

             $(this).val($(".text-jumlah-"+id+"").text());

           }

           else {
          //subtotalnya di jadikan 0 karena nilai yang sebenarnya belum di dapatkan
           $.post("update_jumlah_barang_tbs_item_keluar.php",{id:id,jumlah_baru:jumlah_baru,subtotal:0},function(info){

          $("#text-jumlah-"+id+"").show();
          $("#text-jumlah-"+id+"").text(jumlah_baru);
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

 $.post('cek_kode_barang_tbs_item_keluar.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#kode_barang").trigger('chosen:updated');
    $("#kode_barang").trigger('chosen:open');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)
 
    });//penutup click(function()
  });//penutup ready(function()
</script>   



<script type="text/javascript">
  
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var session_id = $("#session_id").val();
    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var harga_hpp = $('#opt-produk-'+kode_barang).attr("harga");
    var jumlah_barang = $('#opt-produk-'+kode_barang).attr("jumlah-barang");
    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
    var kategori = $('#opt-produk-'+kode_barang).attr("kategori");
    var status = $('#opt-produk-'+kode_barang).attr("status");
    var suplier = $('#opt-produk-'+kode_barang).attr("suplier");
    var limit_stok = $('#opt-produk-'+kode_barang).attr("limit_stok");
    var ber_stok = $('#opt-produk-'+kode_barang).attr("ber-stok");
    var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");


    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#satuan_produk").val(satuan);


    $.post("ambil_harga_hpp.php",{kode_barang:kode_barang},function(data){
        $("#harga_produk").val(data);
    });

   

if (ber_stok == 'Barang') {

    $.post('ambil_jumlah_produk.php',{kode_barang:kode_barang}, function(data){
      if (data == "") {
        data = 0;
      }
      $("#jml_barang").val(data);
    });

}


  $.post('cek_kode_barang_tbs_item_keluar.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
            
            if(data == 1){
                        alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

                        $("#kode_barang").val('').trigger("chosen:updated");
                        $("#kode_barang").trigger('chosen:open');
                        $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
                }//penutup if     



                });


      });
  });

      
      
</script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>