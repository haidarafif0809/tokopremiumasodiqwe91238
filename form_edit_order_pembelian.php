<?php include_once 'session_login.php';

  include 'header.php';
  include 'navbar.php';
  include 'db.php';
  include 'sanitasi.php';

  $query_default_ppn = $db->query("SELECT setting_ppn, nilai_ppn FROM perusahaan");
  $data_default_ppn = mysqli_fetch_array($query_default_ppn);
  $default_ppn = $data_default_ppn['setting_ppn'];
  $nilai_ppn = $data_default_ppn['nilai_ppn'];

  $no_faktur = stringdoang($_GET['no_faktur']);
  $suplier = stringdoang($_GET['suplier']);
  $nama_gudang = stringdoang($_GET['nama_gudang']);
  $kode_gudang = stringdoang($_GET['kode_gudang']);

  $query_order = $db->query("SELECT keterangan, tanggal FROM pembelian_order WHERE no_faktur_order = '$no_faktur'");
  $data_order = mysqli_fetch_array($query_order);
?>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->
<script type="text/javascript">
  $(function() {
    $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
  });
</script>

<div style="padding-left: 15%; padding-right: 12%">
  <h3> FORM EDIT ORDER PEMBELIAN </h3><hr>

  <div class="row"> <!-- ROW LUAR  -->
    
    <div class="col-sm-8"><!-- COL-SM-8-->

      <form enctype="multipart/form-data" role="form" action="form_order_pembelian.php" method="post ">

          <input type="hidden" name="no_faktur" id="no_faktur" class="form-control" value="<?php echo $no_faktur; ?>" readonly="">

        <div class="row">

            <div class="col-sm-5">
                <label> Suplier (F4)</label>
                <select name="suplier" id="nama_suplier" class="form-control chosen" required="" data-placeholder="SILAKAN PILIH...">
                  <?php
                    // menampilkan seluruh data yang ada pada tabel suplier
                    $query = $db->query("SELECT id, nama FROM suplier");
                    // menyimpan data sementara yang ada pada $query
                    while($data = mysqli_fetch_array($query))
                    {
                      if ($data['id'] == $suplier) {
                        echo "<option selected value='".$data['id'] ."'>".$data['nama'] ."</option>";
                      }
                      else{
                        echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
                      }
                    }
                  ?>
                </select>
            </div>    

            <div class="col-sm-2">
              <label> Gudang </label>
              <select style="font-size:15px; height:35px" name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
                <?php
                  $query = $db->query("SELECT kode_gudang, nama_gudang FROM gudang");

                  while($data = mysqli_fetch_array($query))
                  {
                    if ($data['kode_gudang'] == $kode_gudang) {
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
              <label>PPN</label>
              <select type="hidden" style="font-size:15px; height:35px" name="ppn" id="ppn" class="form-control chosen">
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

            <div class="col-sm-2">
              <label>Tanggal</label>
              <input type="text" style="font-size:15px; height:13" value="<?php echo $data_order['tanggal'];?>" name="tanggal" id="tanggal" class="form-control">
            </div>

        </div>  <!-- END ROW -->

      </form><!--tag penutup form-->

      <!-- TOMOBOL CARI PRODUK-->

  <form id="form_barcode" class="form-inline">
    <div class="form-group">
        <input type="text" style="height:15px" name="kode_barcode" id="kode_barcode" class="form-control" autocomplete="off" placeholder="Scan / Ketik Barcode">
    </div>
        <button type="submit" id="submit_barcode" class="btn btn-primary" style="font-size:15px" ><i class="fa fa-barcode"></i> Submit Barcode</button> ||  
        <button type="button" class="btn btn-info" id="cari_produk_pembelian" accesskey="s" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari Produk (F1)</button>
  </form>

      <!--MODAL PRODUK-->
      <div id="myModal" class="modal" role="dialog">
        <div class="modal-dialog ">        
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Data Barang</h4>
            </div>

            <div class="modal-body">
            <center>
              <div class="table-responsive">
                <table id="tabel_cari" class="table table-bordered table-sm">
                  <thead>

                    <th> Kode Barang </th>
                    <th> Nama Barang </th>
                    <th> Harga Beli </th>
                    <th> Jumlah Barang </th>
                    <th> Satuan </th>
                    <th> Kategori </th>
                    <th> Suplier </th>

                  </thead>
                </table>
              </div>
            </center>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div><!-- / MODAL PRODUK -->

      <form class="form"  role="form" id="formtambahproduk">

        <div class="row">

          <div class="col-sm-3">  
          <label><br></label>
           <select style="font-size:15px;" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
            <option value="">SILAKAN PILIH...</option>
               <?php 

                include 'cache.class.php';
                  $c = new Cache();
                  $c->setCache('produk');
                  $data_c = $c->retrieveAll();

                  foreach ($data_c as $key) {
                    echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_beli'].'"  satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" over_stok="'.$key['over_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';

                  }

                ?>
            </select>
          </div>

          <!--NAMA PRODUK-->
          <input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama">

          <div class="col-sm-2">
          <label></label>
            <input style="height:20px;" type="text" class="form-control" name="jumlah_barang"  autocomplete="off" id="jumlah_barang" placeholder="Jumlah" >
          </div>

          <div class="col-sm-2">
          <label></label>
            <select style="font-size:15px; height:38px" type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="">
              <?php 
                $query = $db->query("SELECT id, nama  FROM satuan");
                  while($data = mysqli_fetch_array($query)){
                    echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
                  }
              ?>
            </select>
          </div>

          <div class="col-sm-2" style="width:90px">
            <label></label>
            <input  style="height:20px" type="text" id="harga_baru" name="harga_baru" class="form-control" placeholder="Harga" readonly="">
          </div>

          <div class="col-sm-1">
          <label></label>
            <input style="height:20px;" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Disc.">
          </div>

          <div class="col-sm-1">
          <label></label>
            <?php if ($default_ppn == 'Include'): ?>
              <input style="height:20px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" value="<?php echo $nilai_ppn ?>" placeholder="Tax%" >
            <?php else: ?>
              <input style="height:20px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
            <?php endif ?>      
          </div>

          <label><br><br></label>
          <button type="submit" id="submit_produk" class="btn btn-success" style="font-size:15px" >Submit (F3)</button>

      </div>

          <input type="hidden" class="form-control"  name="over_stok" id="over_stok" autocomplete="off" placeholder="Over Stok">
          <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">
          <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
          <input type="hidden" class="form-control" id="satuan_produk" name="satuan" value="" required="">
          <input type="hidden" class="form-control" id="harga_produk" name="harga" value="" required="">
          <input type="hidden" class="form-control" id="id_produk" name="id_produk" value="" required="">        

      </form> <!-- tag penutup form -->

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

    </div><!-- / COL-SM-8 -->

    <div class="col-sm-4"><!-- COL-SM-4 -->

      <form action="proses_bayar_jual.php" id="form_jual" method="POST">
        
        <div class="form-group">
           <!-- CARD-BLOCK -->
           <div class="card card-block">

            <label style="font-size:15px"> <b> Subtotal </b></label>
            <input style="height:30px;font-size:30px" type="text" name="total" id="total2" class="form-control" placeholder="Subtotal" readonly="" >

            <label> Keterangan (F8)</label>
            <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> <?php echo $data_order['keterangan'] ?> </textarea>

          </div>
        </div><!-- / CARD-BLOCK -->

        <!-- INPUT HIDDEN -->
        <input style="height:15px" type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">
        <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">

        <!-- TOMBOL -->
        <button type="submit" id="order" class="btn btn-primary" style="font-size:15px">  Order (F10)</button>
        <a href='cetak_pembelian_tunai.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Order  </a>
        <button type="button" class="btn btn-info" id="transaksi_baru" style="display: none">  Transaksi Baru </a>
        <button type="submit" id="cetak_langsung" target="blank"  style="display: none;" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button>
        <br>

        <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Order Berhasil
        </div>

      </form>

    </div><!-- / COL-SM-4 -->

  </div><!-- / ROW LUAR  -->

</div><!-- / CONTAINER -->

<!-- OPEN KOLOM SUPLIER -->
<script>
  $(document).ready(function(){
      $("#kode_barang").trigger('chosen:open');
  });
</script>

<!-- DATATABLE PRODUK -->
<script type="text/javascript" language="javascript" >
  $(document).ready(function() {

    var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_order_pembelian.php", // json datasource
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
              $(nRow).attr('over_stok', aData[8]);
              $(nRow).attr('satuan', aData[7]);
              $(nRow).attr('harga', aData[2]);
              $(nRow).attr('id-barang', aData[9]);
              $(nRow).attr('jumlah-barang', aData[3]);
              $(nRow).attr('kategori', aData[5]);
              $(nRow).attr('suplier', aData[6]);

          }

    });

  });
</script>

<!--DATA TBS ORDER PEMBELIAN -->
<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#tabel_tbs_order').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"data_tbs_edit_order_pembelian.php", // json datasource
        "data": function ( d ) {
          d.no_faktur = $("#no_faktur").val();
          // d.custom = $('#myInput').val();
          // etc
        },

         type: "post",  // method  , by default get
         error: function(){  // error handling
           $(".employee-grid-error").html("");
           $("#tabel_tbs_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
           $("#employee-grid_processing").css("display","none");
           }
      },
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           $(nRow).attr('class','tr-id-'+aData[11]+'');
         }
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    var no_faktur = $("#no_faktur").val();

    $.get("cek_total_edit_order_pembelian.php" ,{no_faktur:no_faktur} ,function(data){
        $("#total2").val(data);
    });
  });    
</script>

<!-- PILIH PRODUK ORDER PEMBELIAN -->
<script type="text/javascript">
  $(document).on('click', '.pilih', function (e) {

    document.getElementById("kode_barang").value = $(this).attr('data-kode');
    $("#kode_barang").trigger('chosen:updated');

    document.getElementById("nama_barang").value = $(this).attr('nama-barang');
    document.getElementById("over_stok").value = $(this).attr('over_stok');
    document.getElementById("satuan_produk").value = $(this).attr('satuan');
    document.getElementById("satuan_konversi").value = $(this).attr('satuan');
    document.getElementById("harga_produk").value = $(this).attr('harga');
    document.getElementById("harga_lama").value = $(this).attr('harga');
    document.getElementById("id_produk").value = $(this).attr('id-barang');
    document.getElementById("harga_baru").value = $(this).attr('harga');
    document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');

    $("#myModal").modal('hide');
    $("#jumlah_barang").focus();

  });

</script> <!--tag penutup perintah java script-->

<script type="text/javascript">
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur = $("#no_faktur").val();
    var kode_barang = $("#kode_barang").val();

    $.post('cek_produk_edit_order_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){

      if(data == 1){
              alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

              $("#kode_barang").chosen("destroy");
              $("#kode_barang").val('');
              $("#kode_barang").trigger('chosen:updated');
              $("#nama_barang").val('');
              $("#kode_barang").trigger('chosen:open');
              $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});
       }

    });

  });//penutup click(function()
});//penutup ready(function()
</script>

<script>
//SCRIPT BARCODE INPUT
$(document).on('click', '#submit_barcode', function (e) {
  var kode_barang = $("#kode_barcode").val();
  var suplier = $("#nama_suplier").val();
  var no_faktur_order = $("#no_faktur").val();

  if (suplier == ''){
  alert("Suplier Harus Dipilih");
  $("#nama_suplier").trigger('chosen:open');
  }
  else{

  // JAVASCRIPT BARCODE
  $.post("barcode_edit_order_pembelian.php",{kode_barang:kode_barang, no_faktur_order:no_faktur_order},function(data){
    if (data == 3){
      alert("Barcode Yang Anda Masukan Tidak Ada , Silakan Periksa Kembali ");
      $("#kode_barcode").val('');
      $("#kode_barcode").focus();
    }
    else{

      $(".tr-kode-"+kode_barang+"").remove();
      $("#ppn").attr("disabled", true).trigger('chosen:updated');
      $("#nama_barang").val('');
      $("#jumlah_barang").val('');
      $("#potongan1").val('');
      $("#kode_barcode").val('');

            //perhitungan form pembayaran (total & subtotal / biaya admin) 

            var total_perorder = data;

                if (total_perorder == '') {
                  total_perorder = 0;
                }


            var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

            if (subtotal == ''){
                subtotal = 0;
              }

            var total_akhir1 = parseInt(subtotal,10) + parseInt(total_perorder,10);

            $("#total2").val(tandaPemisahTitik(Math.round(total_akhir1)));

            // datatable ajax pembaruan
                var tabel_tbs_order = $('#tabel_tbs_order').DataTable();
                    tabel_tbs_order.draw();
    
    }// end else untuk stok tidak mencukupi

  });
  }

  /// JAVASCRIPT BARCODE


$("#form_barcode").submit(function(){
    return false;
    
    });
});
 </script> 

<!-- INPUT PRODUK VIA NODAL -->
<script type="text/javascript">
  $("#submit_produk").click(function(){
    var no_faktur = $("#no_faktur").val();
    var suplier = $("#nama_suplier").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = $("#jumlah_barang").val();
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
    var harga_baru = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_baru").val()))));

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
    var ppn = $("#ppn").val();

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
            else {
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

 if (kode_barang == ''){
    alert("Kode Barang Harus Diisi");
    $("#kode_barang").trigger('chosen:open');
  }
 else if (jumlah_barang == ''){
    alert("Jumlah Barang Harus Diisi");
    $("#jumlah_barang").focus();
  }
  else if (jumlah_barang == 0){
    alert("Jumlah Barang Tidak Boleh 0");
    $("#jumlah_barang").focus();
  }
  else if (suplier == ''){
    alert("SIakan Pilih Suplier !");
    $("#nama_suplier").trigger("chosen:open");
  }
  else{
      
      $("#total2").val(tandaPemisahTitik(total_akhir));

      $.post("proses_tbs_edit_order_pembelian.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,satuan:satuan,harga:harga,harga_baru:harga_baru,tax:tax,ppn:ppn,potongan:potongan},function(data){
         
          $("#ppn").attr("disabled", true).trigger('chosen:updated');
          $("#kode_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $("#nama_barang").val('');
          $("#harga_produk").val('');
          $("#ber_stok").val('');
          $("#jumlah_barang").val('');
          $("#potongan1").val('');
          var tabel_tbs_order = $('#tabel_tbs_order').DataTable();
              tabel_tbs_order.draw();
          

      });
    }

  });

  $("form").submit(function(){
     return false;
  });
</script>

<!-- INPUT PRODUK VIA PENCARIAN -->
<script type="text/javascript">
$(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_barang = $(this).val();
    var no_faktur = $("#no_faktur").val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var jumlah_barang = $('#opt-produk-'+kode_barang).attr("jumlah-barang");
    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
    var kategori = $('#opt-produk-'+kode_barang).attr("kategori");
    var suplier = $('#opt-produk-'+kode_barang).attr("suplier");
    var over_stok = $('#opt-produk-'+kode_barang).attr("over_stok");
    var harga_lama = $('#opt-produk-'+kode_barang).attr("harga");
    var harga_produk = $('#opt-produk-'+kode_barang).attr("harga");
    var harga_baru = $('#opt-produk-'+kode_barang).attr("harga");
    var tipe_barang = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");


    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#jumlah_barang").val(jumlah_barang);
    $("#satuan_produk").val(satuan);
    $("#harga_lama").val(harga_lama);
    $("#harga_produk").val(harga_produk);
    $("#harga_baru").val(harga_baru);
    $("#satuan_konversi").val(satuan);
    $("#over_stok").val(over_stok);
    $("#id_produk").val(id_barang);


    $.post('cek_produk_edit_order_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){

      if(data == 1){
              alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

              $("#kode_barang").chosen("destroy");
              $("#kode_barang").val('');
              $("#kode_barang").trigger('chosen:updated');
              $("#nama_barang").val('');
              $("#kode_barang").trigger('chosen:open');
              $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});
       }

    });

  });

});

</script>


<!-- HAPUS TBS ORDER PEMBELIAN -->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.btn-hapus',function(e){

    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    var subtotal_tbs = $(this).attr("data-subtotal");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

    if (total == '') {
      total = 0;
    };

    var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10);

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus '"+nama_barang+"' "+ "?");
    if (pesan_alert == true) {

      $("#total2").val(tandaPemisahTitik(total_akhir));

      $.post("hapus_tbs_edit_order_pembelian.php",{id:id},function(data){
        var tabel_tbs_order = $('#tabel_tbs_order').DataTable();
          tabel_tbs_order.draw();

        $.post("cek_tbs_pembelian_order.php",{no_faktur: "<?php echo $no_faktur; ?>"},function(data){
          if (data == 0) {
                $("#ppn").attr("disabled", false).trigger('chosen:updated');
            }
        });

      });

    }

  });

    $('form').submit(function(){
      return false;
    });

});
</script>

<!--EDIT JUMLAH PRODUK ORDER PEMBELIAN -->
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
        var subtotal_pembelian = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
            subtotal_pembelian = subtotal_pembelian - subtotal_lama + subtotal;
        var tax_tbs = tax / subtotal_lama * 100;
        var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;

        var nama_barang = $(this).attr("data-nama");
        var jumlahbarang = $(this).attr("data-stok");
        var over_stok = $(this).attr("data-over");
        var stok = parseFloat(jumlah_baru) + parseFloat(jumlahbarang);

        if( over_stok < stok && over_stok != 0 ){

            alert("Persediaan Produk '"+nama_barang+"' Ini Melebihi Batas Over Stok.");
            $("#jumlah_barang").val('');
            $("#jumlah_barang").focus();
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
            $("#total2").val(tandaPemisahTitik(subtotal_pembelian));

            $.post("update_tbs_edit_order_pembelian.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){
                $("#kode_barang").trigger('chosen:open');
            });

        }

    });

</script>


<!-- ORDER PEMBELIAN -->
<script type="text/javascript">
  $(document).on("click","#order", function(){

    var no_faktur = $("#no_faktur").val();
    var suplier = $("#nama_suplier").val();
    var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
    var harga = $("#harga_produk").val();
    var kode_gudang = $("#kode_gudang").val();
    var keterangan = $("#keterangan").val();   
    var ppn_input = $("#ppn_input").val();
    var ppn = $("#ppn").val();
    var tanggal = $("#tanggal").val();


  if (suplier == "") {
  alert("Suplier Harus Di Isi");
  }

  else if (kode_gudang == "") {
  alert(" Kode Gudang Harus Diisi ");
  }

  else if (total2 ==  0 || total2 == "") {
    alert("Anda Belum Melakukan Pemesanan");
  }

  else {

      $("#order").hide();
      $("#transaksi_baru").show();

      $.post("cek_subtotal_edit_pembelian_order.php",{total2:total2,no_faktur:no_faktur},function(data) {

        if (data != 1) {

            $.post("proses_edit_order_pembelian.php",{total2:total2,no_faktur:no_faktur,suplier:suplier,harga:harga,kode_gudang:kode_gudang,keterangan:keterangan,ppn_input:ppn_input,tanggal:tanggal},function(info) {

             var no_faktur = info;
             $("#cetak_tunai").attr('href', 'cetak_pembelian_order.php?no_faktur='+no_faktur+'');
             $("#alert_berhasil").show();
             $("#cetak_tunai").show();
             $("#total2").val('');
             $("#keterangan").val('');
             $('#tbody').html('');

             var tabel_tbs_order = $('#tabel_tbs_order').DataTable();
                 tabel_tbs_order.draw();
             var tabel_cari = $('#tabel_cari').DataTable();
                 tabel_cari.draw();
               
           });

        }
        else{
            alert("Maaf Subtotal pembelian Tidak Sesuai, Silakan Tunggu Sebentar!");       
                  window.location.href="form_edit_order_pembelian.php";
        }

      });


   }

      $("form").submit(function(){
          return false;
      });

  });
</script>

<!-- INPUT JUMLAH PRODUK -->
<script>
  $(document).ready(function(){
    $("#jumlah_barang").keyup(function(){
      var nama_barang = $("#nama_barang").val(); 
      var jumlah_barang = $("#jumlah_barang").val();        
      if (jumlah_barang == "") {
          jumlah_barang = 0;
      }

      var jumlahbarang =$("#jumlahbarang").val();
      var over_stok = $("#over_stok").val();
      var stok = parseFloat(jumlah_barang) + parseFloat(jumlahbarang);


      if( over_stok < stok && over_stok != 0 ){
          alert("Persediaan Produk '"+nama_barang+"' Ini Melebihi Batas Over Stok.");
            $("#jumlah_barang").val('');
            $("#jumlah_barang").focus();
      }


  });
});

</script>

<!--TRANSAKSI BARU-->
<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','#transaksi_baru',function(e){

      window.location.href="order_pembelian.php";
    
    });
  });

</script>

<!-- CHOSEN -->
<script type="text/javascript">
  $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});    
</script>

<!-- SHORTCUT BUTTON -->
<script type="text/javascript">
  shortcut.add("f1", function() {
    $("#cari_produk_pembelian").click();
  });

  shortcut.add("f2", function() {
    $("#kode_barang").trigger("chosen:open");
  });

  shortcut.add("f3", function() {
    $("#submit_produk").click();
  });

  shortcut.add("f4", function() {
    $("#nama_suplier").trigger("chosen:open");
  });

  shortcut.add("f8", function() {
    $("#keterangan").focus();
  });

  shortcut.add("f10", function() {
    $("#order").click();
  });

</script>
<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>