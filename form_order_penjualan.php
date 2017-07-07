<?php include_once 'session_login.php';
 

// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

 
$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_form_order_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

$query_default_ppn = $db->query("SELECT setting_ppn, nilai_ppn FROM perusahaan");
$data_default_ppn = mysqli_fetch_array($query_default_ppn);
$default_ppn = $data_default_ppn['setting_ppn'];
$nilai_ppn = $data_default_ppn['nilai_ppn'];


$session_id = session_id();

 ?>

<!-- Modal Untuk Confirm PESAN alert-->
<div id="modal_promo_alert" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">

  
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <span id="tampil_alert">
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" id="closed_alert_promo" data-dismiss="modal">Closed (Ctrl + G)</button>
    </div>
    </div>
  </div>
</div>
<!--modal end pesan alert-->


<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->


 <style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
}
</style>


<script>
  $(function() {
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>

<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->
 <div class="container">
  <h3> FORM ORDER PENJUALAN </h3>
<div class="row">

<div class="col-sm-8">


 <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="form_order_penjualan.php" method="post ">
        
  <!--membuat teks dengan ukuran h3-->      

        <div class="form-group">
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">
        </div>

<div class="row">

<div class="col-sm-4">
    <label> Kode Pelanggan </label><br>
  <select name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="" autofocus="">
 
          
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query = $db->query("SELECT * FROM pelanggan");

    //untuk menyimpan data sementara yang ada pada $query
    while($data = mysqli_fetch_array($query))
    {
            if ($data['default_pelanggan'] == '1') {

    echo "<option selected value='".$data['kode_pelanggan'] ."' class='opt-pelanggan-".$data['kode_pelanggan']."' data-level='".$data['level_harga'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
              
            }

            else{

    echo "<option value='".$data['kode_pelanggan'] ."' class='opt-pelanggan-".$data['kode_pelanggan']."' data-level='".$data['level_harga'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";

            }
    }
    
    
    ?>
    </select>
</div>
    

<div class="col-sm-2">
          <label class="gg" > Gudang </label><br>
          
          <select style="font-size:15px; height:35px" name="kode_gudang" id="kode_gudang" class="form-control gg" required="" >
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM gudang");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {

            if ($data['default_sett'] == '1') {

                echo "<option selected value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
              
            }

            else{

                echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";

            }
          
          }
          
          
          ?>
          </select>
</div>

<div class="col-sm-2">
    <label> Level Harga </label><br>
  <select style="font-size:15px; height:35px" type="text" name="level_harga" id="level_harga" class="form-control" required="" >
  <option value="harga_1">Level 1</option>
  <option value="harga_2">Level 2</option>
  <option value="harga_3">Level 3</option>
  <option value="harga_4">Level 4</option>
  <option value="harga_5">Level 5</option>
  <option value="harga_6">Level 6</option>
  <option value="harga_7">Level 7</option>
    </select>
    </div>


<div class="col-sm-2">
<label class="gg" >Sales</label>
<select style="font-size:15px; height:35px" name="sales" id="sales" class="form-control gg" required="">

  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT id,nama FROM user WHERE status_sales = 'Iya'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {


    echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";

    }
    
    
    ?>

</select>
</div>

<div class="col-sm-2">
<label class="gg">PPN</label>
<select type="hidden" style="font-size:15px; height:35px" name="ppn" id="ppn" class="form-control">
  <?php if ($default_ppn == 'Include'): ?>    
    <option selected>Include</option>  
    <option>Exclude</option>  
    <option>Non</option>
  <?php endif ?>

  <?php if ($default_ppn == 'Exclude'): ?>
    <option selected>Exclude</option>  
    <option>Non</option>
    <option>Include</option>  
  <?php endif ?>

  <?php if ($default_ppn == 'Non'): ?>
    <option selected>Non</option>
    <option>Include</option>  
    <option>Exclude</option>  
  <?php endif ?>
</select>
</div>
</div>  <!-- END ROW dari kode pelanggan - ppn -->


  </form><!--tag penutup form-->
  
  

<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1)</i>  </button> 


<!--tampilan modal-->
<div id="myModal" class="modal " role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- isi modal-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
      </div>
      <div class="modal-body">

      <div class="table-resposive">
<table id="tabel_cari" class="table table-bordered table-sm">
  <thead> <!-- untuk memberikan nama pada kolom tabel -->

            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> Harga Jual Level 4 </th>
            <th> Harga Jual Level 5</th>
            <th> Harga Jual Level 6</th>
            <th> Harga Jual Level 7</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th> 

  </thead> <!-- tag penutup tabel -->
  </table>
</div>
</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal data barang  -->



<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal " role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Tbs Penjualan</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     <input type="text" id="nama-barang" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" >
     <input type="hidden" id="kode_hapus" class="form-control" >
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->



<!-- membuat form prosestbspenjual -->


<?php if ($otoritas_tombol['tombol_submit'] > 0):?>  

<form id="form_barcode" class="form-inline">
  <br>
    <div class="form-group">
        <input type="text" style="height:15px" name="kode_barcode" id="kode_barcode" class="form-control" placeholder="Kode Barcode">
    </div>
        
    <button type="submit" id="submit_barcode" class="btn btn-primary" style="font-size:15px" ><i class="fa fa-barcode"></i> Submit Barcode</button>
        
    
        
  </form>

          <div class="alert alert-danger" id="alert_stok" style="display:none">
          <strong>Perhatian!</strong> Persediaan Barang Tidak Cukup!
          </div>



  
<form class="form"  role="form" id="formtambahproduk">

<div class="row">

  <div class="col-sm-3">  
   <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
    <option value="">SILAKAN PILIH...</option>
       <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

        ?>
    </select>
  </div>


    <input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama" >

  <div class="col-sm-2">
    <input style="height:15px;" type="text" class="form-control" name="jumlah_barang"  autocomplete="off" id="jumlah_barang" placeholder="Jumlah" >
  </div>

  <div class="col-sm-2">
          
          <select style="font-size:15px; height:35px" type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="">
          
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
          </select>
  </div>


   <div class="col-sm-2">
    <input style="height:15px;" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan">
  </div>

  <div class="col-sm-1">
    <?php if ($default_ppn == 'Include'): ?>
      <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" value="<?php echo $nilai_ppn ?>" placeholder="Tax%" >
    <?php else: ?>
      <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
    <?php endif ?>      
  </div>


  <button type="submit" id="submit_produk" class="btn btn-success" style="font-size:15px" >Submit (F3)</button>

</div>

  <input type="hidden" class="form-control" name="limit_stok" autocomplete="off" id="limit_stok" placeholder="Limit Stok" >
    <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >
    <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">
    <input type="hidden" class="form-control" name="harga_baru" id="harga_baru">
    <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
    <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
    <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
    <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">        

</form> <!-- tag penutup form -->

<?php endif ?>

                <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                <span id='tes'></span>            
                
                <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
                <table id="tabel_tbs_order" class="table table-sm">
                <thead>
                <th> Kode  </th>
                <th style="width:1000%"> Nama </th>
                <th> Jumlah </th>
                <th> Satuan </th>
                <th> Harga </th>
                <th> Potongan </th>
                <th> Pajak </th>
                <th> Subtotal </th>
                <th> Hapus </th>
                
                </thead>
                
                </table>
                </div>
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>


</div> <!-- / END COL SM 6 (1)-->


<div class="col-sm-4">

<form action="proses_bayar_jual.php" id="form_jual" method="POST" >
    
    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
    }
    </style>

  <div class="form-group">
    <div class="card card-block">
      

          
           <label style="font-size:15px"> <b> Subtotal </b></label><br>
      <input style="height:30px;font-size:30px" type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" >

       


           <label> Keterangan </label><br>
           <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> 
           </textarea>



 </div>
      </div><!-- END card-block -->

     

          
          
          <input style="height:15px" type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->

          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >
          <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  
      
<?php if ($otoritas_tombol['tombol_order'] > 0):?>  

          <button type="submit" id="order" class="btn btn-primary" style="font-size:15px">  Order (F10)</button>

<?php endif; ?>

          <a href='cetak_penjualan_tunai.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Order  </a>


          <button type="button" class="btn btn-info" id="transaksi_baru" style="display: none">  Transaksi Baru (Ctrl + M) </a>


          <button type="submit" id="cetak_langsung" target="blank"  style="display: none;" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button> 

          <br>

          
          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Order Berhasil
          </div>
     

    </form>

  </div> <!-- div col sm 4-->
</div><!-- / END row atas-->


</div><!-- end of container -->

<script type="text/javascript">
 (function(seconds) {
    var refresh,       
        intvrefresh = function() {
            clearInterval(refresh);
            refresh = setTimeout(function() {
               location.href ="home.php";
            }, seconds * 1000);
        };

    $(document).on('keypress click', function() { intvrefresh() });
    intvrefresh();

}(300)); // define here seconds

</script>

<script type="text/javascript">
  $(document).on('click', '.tidak_punya_otoritas', function (e) {
    alert("Anda Tidak Punya Otoritas Untuk Edit Jumlah Produk !!");
  });
</script>
    

<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#tabel_tbs_order').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_order_penjualan.php", // json datasource
        "data": function ( d ) {
          d.session_id = $("#session_id").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[9]+'');
         }
    });
  });
</script>


<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});

</script>


<!--Start Ajax Modal Cari-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_produk_order_penjualan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('harga', aData[2]);
              $(nRow).attr('harga_level_2', aData[3]);
              $(nRow).attr('harga_level_3', aData[4]);
              $(nRow).attr('harga_level_4', aData[5]);
              $(nRow).attr('harga_level_5', aData[6]);
              $(nRow).attr('harga_level_6', aData[7]);
              $(nRow).attr('harga_level_7', aData[8]);
              $(nRow).attr('jumlah-barang', aData[9]);
              $(nRow).attr('satuan', aData[17]);
              $(nRow).attr('kategori', aData[11]);
              $(nRow).attr('status', aData[16]);
              $(nRow).attr('suplier', aData[12]);
              $(nRow).attr('limit_stok', aData[13]);
              $(nRow).attr('ber-stok', aData[14]);
              $(nRow).attr('tipe_barang', aData[15]);
              $(nRow).attr('id-barang', aData[18]);

          }

        });    
     
  });
 </script>
<!--Start Ajax Modal Cari-->



<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {


  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger("chosen:updated");
  //$("#kode_barang").trigger("chosen:open");

  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("limit_stok").value = $(this).attr('limit_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("ber_stok").value = $(this).attr('ber-stok');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id-barang');



var level_harga = $("#level_harga").val();

var harga_level_1 = $(this).attr('harga').replace(/[^\/\d]/g,'').replace("/","");
var harga_level_2 = $(this).attr('harga_level_2').replace(/[^\/\d]/g,'').replace("/","");  
var harga_level_3 = $(this).attr('harga_level_3').replace(/[^\/\d]/g,'').replace("/","");
var harga_level_4 = $(this).attr('harga_level_4').replace(/[^\/\d]/g,'').replace("/","");  
var harga_level_5 = $(this).attr('harga_level_5').replace(/[^\/\d]/g,'').replace("/","");
var harga_level_6 = $(this).attr('harga_level_6').replace(/[^\/\d]/g,'').replace("/","");  
var harga_level_7 = $(this).attr('harga_level_7').replace(/[^\/\d]/g,'').replace("/","");

if (level_harga == "harga_1") {
  $("#harga_produk").val(harga_level_1);
  $("#harga_lama").val(harga_level_1);
  $("#harga_baru").val(harga_level_1);
}

else if (level_harga == "harga_2") {
  $("#harga_produk").val(harga_level_2);
  $("#harga_baru").val(harga_level_2);
  $("#harga_lama").val(harga_level_2);
}

else if (level_harga == "harga_3") {
  $("#harga_produk").val(harga_level_3);
  $("#harga_lama").val(harga_level_3);
  $("#harga_baru").val(harga_level_3);
}

else if (level_harga == "harga_4") {
  $("#harga_produk").val(harga_level_4);
  $("#harga_lama").val(harga_level_4);
  $("#harga_baru").val(harga_level_4);
}

else if (level_harga == "harga_5") {
  $("#harga_produk").val(harga_level_5);
  $("#harga_lama").val(harga_level_5);
  $("#harga_baru").val(harga_level_5);
}

else if (level_harga == "harga_6") {
  $("#harga_produk").val(harga_level_6);
  $("#harga_lama").val(harga_level_6);
  $("#harga_baru").val(harga_level_6);
}

else if (level_harga == "harga_7") {
  $("#harga_produk").val(harga_level_7);
  $("#harga_lama").val(harga_level_7);
  $("#harga_baru").val(harga_level_7);
}

  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang').replace(/[^\/\d]/g,'').replace("/","");


$.post("lihat_promo_alert.php",{id_barang:$(this).attr('id-barang')},function(data){

    if (data.promo != null)
    {
      $("#modal_promo_alert").modal('show');
      $("#tampil_alert").html(data.promo);
    } 

});


  $('#myModal').modal('hide'); 
  $("#jumlah_barang").focus();


});

  </script>


<script type="text/javascript">
$(document).ready(function(){
  //end cek level harga
  $("#level_harga").change(function(){
  
  var level_harga = $("#level_harga").val();
  var kode_barang = $("#kode_barang").val();
  
  var satuan_konversi = $("#satuan_konversi").val();
  var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
  var id_produk = $("#id_produk").val();
if (jumlah_barang == '')
{
    alert("Jumlah Barang Harus Terisi");
    $("#jumlah_barang").focus();
    $("#level_harga").val('harga_1');

}
else
{
  $.post("cek_level_harga_barang.php",
        {level_harga:level_harga, kode_barang:kode_barang,jumlah_barang:jumlah_barang,id_produk:id_produk,satuan_konversi:satuan_konversi},function(data){

          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
           $("#harga_lama").val(data);
        });
}


    });
});
//end cek level harga
</script>



<!-- cek stok satuan konversi change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      


      $.post("cek_stok_konversi_penjualan.php", {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,id_produk:id_produk},function(data){

      

          if (data < 0) {
            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
          $("#satuan_konversi").val(prev);

          }

      });
    });
  });
</script>
<!-- end cek stok satuan konversi change-->

<!-- cek stok satuan konversi keyup-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_barang").keyup(function(){
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();

      $.post("cek_stok_konversi_penjualan.php",
        {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk},function(data){

          if (data < 0 ) {
            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
          $("#satuan_konversi").val(prev);

          }

      });
    });
  });
</script>
<!-- cek stok satuan konversi keyup-->



<script>
$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      var harga_produk = $("#harga_lama").val();
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
      var kode_barang = $("#kode_barang").val();
      

      $.getJSON("cek_konversi_penjualan.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi,id_produk:id_produk,harga_produk:harga_produk,jumlah_barang:jumlah_barang},function(info){



        if (satuan_konversi == prev) {

          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);

        }

        else if (info.jumlah_total == 0) {
          alert('Satuan Yang Anda Pilih Tidak Tersedia Untuk Produk Ini !');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);

        }

        else{
 
          $("#harga_produk").val(info.harga_pokok);
          $("#harga_baru").val(info.harga_pokok);

        }

      });

        
    });

});
</script>




<script type="text/javascript">     
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});   
</script>


<script> 
  $(document).on('click', '#submit_barcode', function (e) {

    var kode_barang = $("#kode_barcode").val();
    var level_harga = $("#level_harga").val();
    var sales = $("#sales").val();

$.get("cek_barang.php",{kode_barang:kode_barang},function(data){
if (data != 1) {

alert("Barang Yang Anda Pesan Tidak Tersedia !!")

}

else{


$("#kode_barcode").focus();


$.post("barcode_order.php",{kode_barang:kode_barang,sales:sales,level_harga:level_harga},function(data){


        $(".tr-kode-"+kode_barang+"").remove();
        $("#ppn").attr("disabled", true);
        $("#kode_barang").val('');
        $("#nama_barang").val('');
        $("#jumlah_barang").val('');
        $("#potongan1").val('');
        


            $('#tabel_tbs_order').DataTable().destroy();
    var dataTable = $('#tabel_tbs_order').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_order_penjualan.php", // json datasource
        "data": function ( d ) {
          d.session_id = $("#session_id").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[9]+'');
         }
    });

      
  var session_id = $("#session_id").val();
        
        $.get("cek_total_seluruh_order.php",
        function(data){
        $("#total2").val(data);
        $("#total1").val(data);

        });
     
     });


$.get('lihat_nama_barang_order.php',{kode_barang:kode_barang}, function(data){

$.post("lihat_promo_alert.php",{id_barang:data},function(info){

    if (data.promo != null)
    {
      $("#modal_promo_alert").modal('show');
      $("#tampil_alert").html(data.promo);
    } 

});

});


}//end else cek barang

    });

});
 
     $("#form_barcode").submit(function(){
    return false;
    
    });
 </script>  


<script>
//untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
$(document).on('click', '#submit_produk', function (e) {

  var no_faktur = $("#nomor_faktur_penjualan").val();
  var kode_pelanggan = $("#kd_pelanggan").val();
  var kode_barang = $("#kode_barang").val();
  var nama_barang = $("#nama_barang").val();
  var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
  var level_harga = $("#level_harga").val();
  var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));

  var potongan = $("#potongan1").val();
    //potongan
    if (potongan == ''){
      potongan = 0;
    }
    else{
      
      var pos = potongan.search("%");
        
        if (pos > 0){
            var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));

            potongan_persen = potongan_persen.replace("%","");
              if(potongan_persen > 100){
                  alert("Potongan Tidak Boleh Lebih 100%");
                  $("#potongan1").val(0);
                  $("#potongan1").focus();
              }
          potongan = jumlah_barang * harga * potongan_persen / 100 ;
        };
    }
    //potongan

  var tax = $("#tax1").val();
  var jumlahbarang = $("#jumlahbarang").val();
  var satuan = $("#satuan_konversi").val();
  var sales = $("#sales").val();
  var a = $(".tr-kode-"+kode_barang+"").attr("data-kode-barang");    
  var ber_stok = $("#ber_stok").val();
  var ppn = $("#ppn").val();
  var stok = parseInt(jumlahbarang,10) - parseInt(jumlah_barang,10);

  if (harga == 0) {
    var subtotal = 0;
  }
  else{
    
  //PPN
        if (ppn == 'Exclude') 
          {

            var subtotal_tbs = parseInt(jumlah_barang, 10) *  parseInt(harga, 10) - parseInt(potongan, 10);

            if (tax == 0){
                var total_tax_exclude = 0;
              }
            else{
                var total_tax_exclude = parseInt(subtotal_tbs) * parseInt(tax) / 100;
              }              

               
              var subtotal = parseInt(subtotal_tbs) + parseInt(total_tax_exclude);

          }
          else
          {
              var subtotal = parseInt(jumlah_barang, 10) *  parseInt(harga, 10) - parseInt(potongan, 10);
          }
  //PPN
  
  }
    
  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
  if (total == ''){
    total = 0;
  }


   
  var total_akhir = parseInt(total,10) + parseInt(subtotal,10);

  $("#jumlah_barang").val('');
  $("#potongan1").val('');
  


  if (a > 0){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
  }
  else if (jumlah_barang == ''){
    alert("Jumlah Barang Harus Diisi");
    $("#jumlah_barang").focus();
  }
  else if (jumlah_barang == 0){
    alert("Jumlah Barang Tidak Boleh 0");
    $("#jumlah_barang").focus();
  }
  else if (kode_pelanggan == ''){
    alert("Kode Pelanggan Harus Dipilih");
    $("#kd_pelanggan").focus();
  }
  else if (harga == ''){
    alert("Harga Dengan Level Harga ini 0, Silahkan Edit Harga Produk !!");
  }
  else if (ber_stok == 'Jasa' ){
    if (harga == 0) {
    var pesan_alert = confirm("Harga Produk '"+nama_barang+"' Bernilai 0. Anda Yakin Ingin Melanjutkan ?");

      if (pesan_alert == true){
          $("#total2").val(tandaPemisahTitik(total_akhir));

          $.post("proses_tbs_orderpenjualan.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,sales:sales,ppn:ppn},function(data){
         
          $("#ppn").attr("disabled", true);
          $("#tbody").prepend(data);
          $("#kode_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $("#nama_barang").val('');
          $("#harga_produk").val('');
          $("#ber_stok").val('');
          $("#jumlah_barang").val('');
          $("#potongan1").val('');
          
         
         });

      }
      else{

          $("#kode_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');  

      }

    } // END IF HARGA + 0
    else{
      
      $("#total2").val(tandaPemisahTitik(total_akhir));

      $.post("proses_tbs_orderpenjualan.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,sales:sales,ppn:ppn},function(data){
         
          $("#ppn").attr("disabled", true);
          $("#tbody").prepend(data);
          $("#kode_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $("#nama_barang").val('');
          $("#harga_produk").val('');
          $("#ber_stok").val('');
          $("#jumlah_barang").val('');
          $("#potongan1").val('');
          

      });
    }
} 
  else if (stok < 0) {
    alert ("Jumlah Melebihi Stok Barang !");
  }
  else{

    if (harga == 0) {
    var pesan_alert = confirm("Harga Produk '"+nama_barang+"' Bernilai 0. Anda Yakin Ingin Melanjutkan ?");

    if (pesan_alert == true) {
        $("#total2").val(tandaPemisahTitik(total_akhir));

    $.post("proses_tbs_orderpenjualan.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,sales:sales,ppn:ppn},function(data){
     

      $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);

     $("#kode_barang").val('');
     $("#kode_barang").trigger('chosen:updated');  
     $("#kode_barang").trigger('chosen:open');     
     $("#nama_barang").val('');
     $("#harga_produk").val('');
     $("#ber_stok").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     

//pembaruan table otomatis
$('#tabel_tbs_order').DataTable().destroy();
    var dataTable = $('#tabel_tbs_order').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_order_penjualan.php", // json datasource
        "data": function ( d ) {
          d.session_id = $("#session_id").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[9]+'');
         }
    });
//pembaruan table otomatis

     
     });

  }
  else{
     $("#kode_barang").val('');
     $("#kode_barang").trigger('chosen:updated');  
     $("#kode_barang").trigger('chosen:open');  
  }

}// END IF HARGA + 0


else{
  $("#total2").val(tandaPemisahTitik(total_akhir));
     $.post("proses_tbs_orderpenjualan.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,sales:sales, ppn:ppn},function(data){
     

      $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);

     $("#kode_barang").val('');
     $("#kode_barang").trigger('chosen:open');     
     $("#nama_barang").val('');
     $("#harga_produk").val('');
     $("#ber_stok").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     

//pembaruan table otomatis
$('#tabel_tbs_order').DataTable().destroy();
    var dataTable = $('#tabel_tbs_order').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_order_penjualan.php", // json datasource
        "data": function ( d ) {
          d.session_id = $("#session_id").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[9]+'');
         }
    });
//pembaruan table otomatis
 
     });

    }
  } 
});

    $("#formtambahproduk").submit(function(){
      return false;
    });
</script>


<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#order").click(function(){

        var session_id = $("#session_id").val();
        var no_faktur = $("#nomor_faktur_penjualan").val(); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var harga = $("#harga_produk").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();


 if (kode_pelanggan == "") 
 {

alert("Kode Pelanggan Harus Di Isi");

 }

   else if (kode_gudang == "")
 {

alert(" Kode Gudang Harus Diisi ");

 }
 
  else if (total2 ==  0 || total2 == "") 
        {
        
        alert("Anda Belum Melakukan Pemesanan");
        
        }


 else

 {

  $("#batal_penjualan").hide();
  $("#order").hide();
$("#transaksi_baru").show();

 $.post("cek_subtotal_penjualan_order.php",{total2:total2,session_id:session_id},function(data) {

  if (data != 1) {

 $.post("proses_order_penjualan.php",{total2:total2,session_id:session_id,no_faktur:no_faktur,kode_pelanggan:kode_pelanggan,harga:harga,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input},function(info) {


     $("#table-baru").hide();
     var no_faktur = info;
     $("#cetak_tunai").attr('href', 'cetak_penjualan_order.php?no_faktur='+no_faktur+'');
     $("#alert_berhasil").show();
     $("#cetak_tunai").show();
     $("#total2").val('');
    $('#tbody').html('');
       
 $('#tabel_tbs_order').DataTable().destroy();
    var dataTable = $('#tabel_tbs_order').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_order_penjualan.php", // json datasource
        "data": function ( d ) {
          d.session_id = $("#session_id").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[9]+'');
         }
    });


       
   });

  }
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_order_penjualan.php";
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
    $(document).on('click','#transaksi_baru',function(e){

    
            $("#order").show();
            $("#transaksi_baru").hide();
            $("#table-baru").show();
            $("#alert_berhasil").hide();
            $("#cetak_tunai").hide();
            $("#kode_barang").trigger("chosen:open");

$('#tabel_tbs_order').DataTable().destroy();
    var dataTable = $('#tabel_tbs_order').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_order_penjualan.php", // json datasource
        "data": function ( d ) {
          d.session_id = $("#session_id").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[9]+'');
         }
    });



            function getPathFromUrl(url) {
              return url.split("?")[0];
            }


    });
  });

</script>




  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
 $.post('cek_kode_barang_tbs_penjualan_order.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
        $("#kode_barang").trigger('chosen:updated');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>



<script>

//untuk menampilkan sisa penjualan secara otomatis
  $(document).ready(function(){

  $("#jumlah_barang").keyup(function(){
     var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
     var jumlahbarang = $("#jumlahbarang").val();
     var limit_stok = $("#limit_stok").val();
     var ber_stok = $("#ber_stok").val();
     var stok = jumlahbarang - jumlah_barang;



if (stok < 0 )

  {

       if (ber_stok == 'Jasa') {
       
       }
       
       else{
       alert ("Jumlah Melebihi Stok!");
       $("#jumlah_barang").val('');
       }


    }


    else if( limit_stok > stok  )
    {
      alert("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
    }

  });
});
</script>



<script type="text/javascript">
  $(document).ready(function() {

        var session_id = $("#session_id").val();
        
        $.get("cek_total_seluruh_order.php",
        function(data){
        $("#total2").val(data);
        });
  });    
</script>


<script type="text/javascript">
$(document).ready(function(){    
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){

  var nama_barang = $(this).attr("data-barang");
  var id = $(this).attr("data-id");
  var kode_barang = $(this).attr("data-kode-barang");
  var subtotal_tbs = $(this).attr("data-subtotal");
  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

  if (total == '') {
    total = 0;
  };
  
  var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10);

  $("#total2").val(tandaPemisahTitik(total_akhir));


    $.post("hapustbs_penjualanorder.php",{id:id,kode_barang:kode_barang},function(data){
      if (data == 'sukses') {
        $(".tr-id-"+id+"").remove();
        $("#pembayaran_penjualan").val('');
      }

      $.post("cek_tbs_penjualan_order.php",{session_id: "<?php echo $session_id; ?>"},function(data){
        if (data == 0) {
             $("#ppn").attr("disabled", false);
          }
      });

    });


$('#tabel_tbs_order').DataTable().destroy();
    var dataTable = $('#tabel_tbs_order').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_order_penjualan.php", // json datasource
        "data": function ( d ) {
          d.session_id = $("#session_id").val();
          // d.custom = $('#myInput').val();
          // etc
        },
         
         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[9]+'');
         }
    });



});
                  $('form').submit(function(){
              
              return false;
              });


    });
//end fungsi hapus data
</script>

 

<script type="text/javascript">
// START script untuk pilih kode barang menggunakan chosen     
  $(document).on('change', '#kode_barang', function () {

    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var harga_jual = $('#opt-produk-'+kode_barang).attr("harga");
    var harga_jual2 = $('#opt-produk-'+kode_barang).attr('harga_jual_2');  
    var harga_jual3 = $('#opt-produk-'+kode_barang).attr('harga_jual_3');
    var harga_jual4 = $('#opt-produk-'+kode_barang).attr('harga_jual_4');
    var harga_jual5 = $('#opt-produk-'+kode_barang).attr('harga_jual_5');  
    var harga_jual6 = $('#opt-produk-'+kode_barang).attr('harga_jual_6');
    var harga_jual7 = $('#opt-produk-'+kode_barang).attr('harga_jual_7');
    var jumlah_barang = $('#opt-produk-'+kode_barang).attr("jumlah-barang");
    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
    var kategori = $('#opt-produk-'+kode_barang).attr("kategori");
    var status = $('#opt-produk-'+kode_barang).attr("status");
    var suplier = $('#opt-produk-'+kode_barang).attr("suplier");
    var limit_stok = $('#opt-produk-'+kode_barang).attr("limit_stok");
    var ber_stok = $('#opt-produk-'+kode_barang).attr("ber-stok");
    var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");
    var level_harga = $("#level_harga").val();

$.post("lihat_promo_alert.php",{id_barang:id_barang},function(data){

    if (data.promo != null)
    {
      $("#modal_promo_alert").modal('show');
      $("#tampil_alert").html(data.promo);
    } 

});

   if (level_harga == "harga_1") {

        $('#harga_produk').val(harga_jual);
        $('#harga_baru').val(harga_jual);
        $('#harga_lama').val(harga_jual);
        }
    else if (level_harga == "harga_2") {

        $('#harga_produk').val(harga_jual2);
        $('#harga_baru').val(harga_jual2);
        $('#harga_lama').val(harga_jual2);
        }
    else if (level_harga == "harga_3") {

        $('#harga_produk').val(harga_jual3);
        $('#harga_baru').val(harga_jual3);
        $('#harga_lama').val(harga_jual3);
        }
    else if (level_harga == "harga_4") {

        $('#harga_produk').val(harga_jual4);
        $('#harga_baru').val(harga_jual4);
        $('#harga_lama').val(harga_jual4);
        }
    else if (level_harga == "harga_5") {

        $('#harga_produk').val(harga_jual5);
        $('#harga_baru').val(harga_jual5);
        $('#harga_lama').val(harga_jual5);
        }
    else if (level_harga == "harga_6") {

        $('#harga_produk').val(harga_jual6);
        $('#harga_baru').val(harga_jual6);
        $('#harga_lama').val(harga_jual6);
        }
    else if (level_harga == "harga_7") {

        $('#harga_produk').val(harga_jual7);
        $('#harga_baru').val(harga_jual7);
        $('#harga_lama').val(harga_jual7);
        }

    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#jumlah_barang").val(jumlah_barang);
    $("#satuan_produk").val(satuan);
    $("#satuan_konversi").val(satuan);
    $("#limit_stok").val(limit_stok);
    $("#ber_stok").val(ber_stok);
    $("#id_produk").val(id_barang);

if (ber_stok == 'Barang') {

    $.post('ambil_jumlah_produk.php',{kode_barang:kode_barang}, function(data){
      if (data == "") {
        data = 0;
      }
      $("#jumlahbarang").val(data);
      $('#kolom_cek_harga').val('1');
    });

}


$.post('cek_kode_barang_tbs_penjualan_order.php',{kode_barang:kode_barang}, function(data){
          
  if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").chosen("destroy");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     



  });

    

  });
  // end script untuk pilih kode barang menggunakan chosen   
</script>


<script>
/* Membuat Tombol Shortcut */

function myFunction(event) {
    var x = event.which || event.keyCode;

    if(x == 112){


     $("#myModal").modal();

    }

    else if(x == 113){


     $("#pembayaran_penjualan").focus();

    }

   else if(x == 115){


     $("#penjualan").focus();

    }
  }
</script>

<script type="text/javascript">
          $(document).ready(function(){
          var session_id = $("#session_id").val();
        
        $.get("cek_total_seluruh_order.php",
        function(data){
        $("#total2").val(data);

        });

      });


</script>

        <script type="text/javascript">

$(document).ready(function(){

    $("#kd_pelanggan").change(function(){
        var kode_pelanggan = $("#kd_pelanggan").val();
        
        var level_harga = $(".opt-pelanggan-"+kode_pelanggan+"").attr("data-level");
        
        
        
        if(kode_pelanggan == 'Umum')
        {
           $("#level_harga").val('Level 1');
        }
        else 
        {
           $("#level_harga").val(level_harga);
        
        }
        
        
    });
});
</script>

                            <script type="text/javascript">
                                 
                                 $(document).on('dblclick','.edit-jumlah',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });


                                 $(document).on('blur','.input_jumlah',function(e){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var ber_stok = $(this).attr("data-berstok");

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;
                                    
                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;


                              if (ber_stok == 'Jasa'){

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#btn-hapus-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));       

                      $.post("update_pesanan_barang_order.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){

                                    });        
                                 }

                              else{

                              $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){
                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                    $("#input-jumlah-"+id+"").val(jumlah_lama);
                                    $("#text-jumlah-"+id+"").text(jumlah_lama);
                                    $("#text-jumlah-"+id+"").show();
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    
                                     }

                                      else{

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#btn-hapus-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));       


                                     $.post("update_pesanan_barang_order.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){


                                    
                                         


                                    });

                                   }



                                 });

                            }
       
                                    $("#kode_barang").trigger('chosen:open');
                                    

                                 });

                             </script>

<script type="text/javascript">
  $(document).ready(function(){

    var ppn = $("#ppn").val();
      $("#ppn_input").val(ppn);

      if (ppn == "Include"){
          $("#tax").attr("disabled", true);
          $("#tax1").attr("disabled", false);
      }
      else if (ppn == "Exclude") {
        $("#tax1").attr("disabled", true);
        $("#tax").attr("disabled", false);
      }
      else{
        $("#tax1").attr("disabled", true);
        $("#tax").attr("disabled", true);
      }
    });
</script>

<script type="text/javascript">
  $(document).ready(function(){

    $("#ppn").change(function(){
      var ppn = $("#ppn").val();
      $("#ppn_input").val(ppn);

      if (ppn == "Include"){
          $("#tax").attr("disabled", true);
          $("#tax1").attr("disabled", false);
          $("#tax").val("");
          $("#tax1").val("<?php echo $nilai_ppn ?>");
      }
      else if (ppn == "Exclude") {
          $("#tax").attr("disabled", true);
          $("#tax1").attr("disabled", false);
          $("#tax").val("");
          $("#tax1").val("<?php echo $nilai_ppn ?>");
      }
      else{
        $("#tax1").attr("disabled", true);
        $("#tax").attr("disabled", true);
        $("#tax1").val("");
        $("#tax").val("");
      }
    });

  });
</script>

<script type="text/javascript">
$(document).ready(function(){
  $("#batal_penjualan").click(function(){
    var session_id = $("#session_id").val()
        window.location.href="batal_penjualanorder.php?session_id="+session_id+"";

  })
  });
</script>

<!-- SHORTCUT -->

<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").trigger('chosen:open');

    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_penjualan").click();

    }); 

    
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    }); 

    
    shortcut.add("f4", function() {
        // Do something

        $("#carabayar1").focus();

    }); 

    
    shortcut.add("f7", function() {
        // Do something

        $("#pembayaran_penjualan").focus();

    }); 

    
    shortcut.add("f8", function() {
        // Do something

        $("#penjualan").click();

    }); 

    
    shortcut.add("f9", function() {
        // Do something

        $("#piutang").click();

    }); 


        shortcut.add("ctrl+g", function() {
        // Do something

        $("#closed_alert_promo").click();

    }); 
    
    
    shortcut.add("f10", function() {
        // Do something

        $("#order").click();

    }); 

    
    shortcut.add("ctrl+b", function() {
        // Do something

    var session_id = $("#session_id").val()

        window.location.href="batal_penjualanorder.php?session_id="+session_id+"";


    }); 

     shortcut.add("ctrl+k", function() {
        // Do something

        $("#cetak_langsung").click();


    }); 

          shortcut.add("ctrl+m", function() {
        // Do something

        $("#transaksi_baru").click();


    }); 
</script>

<!-- SHORTCUT -->



<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>