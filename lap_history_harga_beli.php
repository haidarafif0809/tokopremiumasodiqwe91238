<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>


<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<div class="container">


<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">

    <!-- isi modal-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Data Barang</b></center></h4>
      </div>
      <div class="modal-body">
      <center>
          <div class="table-responsive">    
            <table id="table-modal" class="table table-bordered table-sm">
              <thead>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Jumlah Barang </th>
                <th> Satuan </th>
                <th> Kategori </th>
                <th> Status </th>
              </thead>
            </table>
          </div>
      </center>
      </div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <center><b><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div></b></center>
    </div>

  </div>
</div>
<!-- end of modal data barang  -->



<h3>HISTORY HARGA BELI</h3> <hr>

<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1)</i>  </button> 
<br><br>
<form class="form-inline" role="form" id="form_tanggal">

<div class="form-group">
           <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
          <option value="">SILAKAN PILIH...</option>
             <?php 

              include 'cache.class.php';
                $c = new Cache();
                $c->setCache('produk');
                $data_c = $c->retrieveAll();

                foreach ($data_c as $key) {
                  echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'"  satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'"  id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
                }

              ?>
      </select>
</div>

<!-- Start Input Hidden-->
<div class="form-group">
<input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama">
<input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" >  
</div>
<!-- Ending Input Hidden-->


<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">


</div>



<button type="submit" name="submit" id="lihat_kartu_stok" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>


    <span id="total_saldo"></span>

<span style="display: none" id="result">
<div class="card card-block" >  <center><h2 style="display: none;" id="judul"></h2></center>
<br>  
 <table id="table-data">
  <tbody>
      <tr><td width="25%"><font class="satu">Nama Barang</font></td> <td> :&nbsp;</td> <td><font class="satu" id="nama"></font> </tr>

      <tr><td  width="25%"><font class="satu">Kode Barang</font></td> <td> :&nbsp;</td> <td><font class="satu" id="kode"></font></td></tr>
         

  </tbody>
</table>
<br>
<div class="table-responsive">
    
    <table id="table-kartustok" class="table table-bordered table-sm">

        <thead>

      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Suplier </th>
      <th style='background-color: #4CAF50; color:white'> No Faktur</th>
      <th style='background-color: #4CAF50; color:white'> Harga Beli</th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Barang </th>
     
            
           </thead>

     </table>

</div>
  <div class="row">
          <a id="trx" href='' class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak</a>
    </div>
</div>

  </span>




</div><!--Div Container-->


 <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#lihat_kartu_stok',function(e) {

        var kode_barang = $("#kode_barang").val();
        var nama_barang = $("#nama_barang").val();   
        var id_produk = $("#id_produk").val();        
        var daritgl = $("#daritgl").val();        
        var sampaitgl = $("#sampaitgl").val();
        if (kode_barang == '') {
          alert("Kode Barang Harus di isi");
           $("#kode_barang").focus();
        }
        else if (daritgl == '') {
          alert("Dari Tanggal Harus di isi");
           $("#daritgl").focus();
        }
       else if (sampaitgl == '') {
          alert("Sampai Tanggal Harus di isi");
           $("#sampaitgl").focus();
        }
        else
        {

     $('#table-kartustok').DataTable().destroy();

          var dataTable = $('#table-kartustok').DataTable( {
          "processing": true,
          "serverSide": true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"show_harga_beli.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#daritgl").val();
                d.sampai_tanggal = $("#sampaitgl").val();
                d.kode_barang = $("#kode_barang").val();  

                d.id_produk = $("#id_produk").val();   
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-kartustok").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table-kartustok_processing").css("display","none");
              
            }
          }
    


        } );
        $("#result").show()


       function ambil_tgl(tanggal_input1){
        var birthday1 = tanggal_input1;
        birthday1=birthday1.split("-");   
        var hari_ini = birthday1[2];
        return hari_ini;
        }
        function ambil_bln(tanggal_input2){
        var birthday2 = tanggal_input2;
        birthday2=birthday2.split("-");   
        var bulan = birthday2[1];
        return bulan;
        }

        function ambil_thn(tanggal_input3){
        var birthday3 = tanggal_input3;
        birthday3=birthday3.split("-");   
        var tahun = birthday3[0];
        return tahun;
        }
        var ambil_tgl1 = ambil_tgl(daritgl);
        var ambil_bln1 = ambil_bln(daritgl);
        var ambil_thn1 = ambil_thn(daritgl);
        var tanggal1 = ambil_tgl1 + "/" + ambil_bln1 + "/" + ambil_thn1;

        var ambil_tgl2 = ambil_tgl(sampaitgl);
        var ambil_bln2 = ambil_bln(sampaitgl);
        var ambil_thn2 = ambil_thn(sampaitgl);
        var tanggal2 = ambil_tgl2 + "/" + ambil_bln2 + "/" + ambil_thn2;

        var judul = "Periode " + tanggal1 + " Sampai " + tanggal2;

          $("#judul").show();
          $("#judul").text(judul);

          $("#trx").attr("href",'cetak_history_harga_beli.php?daritgl='+daritgl+'&sampaitgl='+sampaitgl+'&kode_barang='+kode_barang+'&nama_barang='+nama_barang);
         

            $("#nama").text(nama_barang)
            $("#kode").text(kode_barang)
         
        }


          

   } );  

  $("form").submit(function(){
      return false;
  });

  } );
    </script>


<!--SCRIPT datepicker -->
<script> 
  $(function() {
    $( ".dsds" ).datepicker({ dateFormat: "yy-mm-dd", beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
         inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
        }, 0);
    } });
  });
</script> 
<!--end SCRIPT datepicker -->
  

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#table-modal').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_kartu_stok_periode.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table-modal").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('id-barang', aData[6]);


          }

        });    
     
  });
 
 </script>


<script> 
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_penjualan").click();

    });
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
  document.getElementById("id_produk").value = $(this).attr('id-barang');

  $('#myModal').modal('hide');

});

  </script>


<script type="text/javascript">
  //SELECT CHOSSESN    
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});   
</script>

<script>
//Choosen Open select
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});
</script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $(document).on('change','#kode_barang',function(e){

    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");


          $("#nama_barang").val(nama_barang);
          $("#id_produk").val(id_barang);

  });
      
    });    
</script>


<?php include 'footer.php'; ?>
