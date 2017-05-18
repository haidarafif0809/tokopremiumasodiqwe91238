<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

$kategori = $_GET['kategori'];
$tipe = $_GET['tipe'];

?>

<style type="text/css">
  tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container">

<h3><b>DATA ITEM</b></h3><hr>

<div class="col-sm-12">

  <ul class="nav nav-tabs md-pills pills-ins" role="tablist">
    
    <?php if ($tipe == 'barang'): ?>

      <li class="nav-item"><a class="nav-link" href='persediaan_barang.php?kategori=semua&tipe=barang'> Umum </a></li>
      <li class="nav-item"><a class="nav-link" href='persediaan_barang2.php?kategori=semua&tipe=barang' > Lain - lain </a></li>
      <li class="nav-item"><a class="nav-link active" href='filter_stok_produk.php?kategori=semua&tipe=barang'> Filter Stok Produk </a></li>

    <?php else: ?>

      <li class="nav-item"><a class="nav-link" href='persediaan_barang.php?kategori=semua&tipe=barang_jasa'> Umum </a></li>
      <li class="nav-item"><a class="nav-link" href='persediaan_barang2.php?kategori=semua&tipe=barang_jasa' > Lain - lain </a></li>
      <li class="nav-item"><a class="nav-link active" href='filter_stok_produk.php?kategori=semua&tipe=barang_jasa' > Filter Stok Produk </a></li>

    <?php endif ?>

  </ul>
  
</div>

<div class="row">
   <div class="col-sm-2 form-group">
    <label><br></label><br>
        <select name="filter" id="filter" autocomplete="off" class="form-control chosen" required="">
          <option value="" style="display: none">--PILIH FILTER--</option>
          <optgroup label="Jenis Filter">
            <option>Kurang Dari</option>
            <option>Lebih Dari</option>
            <option>Antara</option>
          </optgroup>
        </select>
   </div>

<span id="kolom_1" style="display: none">
   <div class="col-sm-2 form-group">
   <br>
       <input type="text" style="height: 15px" placeholder="Jumlah Stok" name="filter_jumlah" id="filter_jumlah" class="form-control" autocomplete="off" required="">
   </div>
</span>

<span id="kolom_2" style="display: none">
   <div class="col-sm-2 form-group">
   <br>
       <input type="text" style="height: 15px" placeholder="Dari Jumlah" name="dari_jumlah" id="dari_jumlah" class="form-control" autocomplete="off" required="">
   </div> 

   <div class="col-sm-2 form-group">
   <br>
       <input type="text" style="height: 15px" placeholder="Sampai Jumlah" name="sampai_jumlah" id="sampai_jumlah" class="form-control" autocomplete="off" required="">
   </div>  
</span>

   <div class="col-sm-2 form-group">
        <br>
        <button type="submit" name="submit_filter" id="submit_filter" class="btn btn-info"> <i class="fa fa-search"></i> Cari Produk</button>
   </div>
  
</div>

<!--Table TBS PENJUALAN -->
<div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
  <span id="span_produk">  
    <table id="tabel_produk" class="table table-sm">
      <thead>
        <th style='background-color: #4CAF50; color: white'> Kode Barang </th>
        <th style='background-color: #4CAF50; color: white'> Nama Barang </th>
        <th style='background-color: #4CAF50; color: white' align="right"> Jumlah Barang </th>
        <th style='background-color: #4CAF50; color: white'> Satuan </th>        
        <th style='background-color: #4CAF50; color: white'> Kategori </th>
      </thead>
    </table>
  </span>
</div>
<!--end tABLE tbs Penjualan-->

</div> <!--/ container-->

<script type="text/javascript">
  $(document).on('change','#filter',function(e){
    var filter = $("#filter").val();

    if (filter == "Antara") {
      $("#kolom_2").show();
      $("#kolom_1").hide();
    }
    else{
      $("#kolom_2").hide();
      $("#kolom_1").show();
    }
  });
</script>

<script type="text/javascript">
  $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});
</script>

<script type="text/javascript">
// FEE PRODUK per PETUGAS DATATABLE MENGGUNAKAN AJAX
  $(document).ready(function() {
  $(document).on('click','#submit_filter',function(e) {

    var filter = $("#filter").val();
    if (filter == "") {
      alert ("Silakan Pilih Jenis Pencarian.");
      $("#filter").trigger("chosen:open");
    }
    else{

        $('#tabel_produk').DataTable().destroy();
              //TABLE KOMISI PRODUK
              var dataTable = $('#tabel_produk').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"proses_filter_stok_produk.php", // json datasource
                   "data": function ( d ) {
                      d.filter = $("#filter").val();
                      d.filter_jumlah = $("#filter_jumlah").val();
                      d.dari_jumlah = $("#dari_jumlah").val();
                      d.sampai_jumlah = $("#sampai_jumlah").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#tabel_produk").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });
    

              $("#span_produk").show();      
    }


        });
   });  
   // /FEE PRODUK per PETUGAS DATATABLE MENGGUNAKAN AJAX
</script>

<?php 
include 'footer.php';
 ?>