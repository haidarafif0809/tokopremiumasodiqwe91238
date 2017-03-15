<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">

<h1> ESTIMASI ORDER BERDASARKAN TARGET PENJUALAN </h1><hr>
<br>


<form id="perhari" class="form-inline"  method="POST" role="form">

<div class="form-group">
    <label>Order Untuk Berapa Hari</label><br>
    <input type="text" class="form-control" id="order" autocomplete="off" name="order" placeholder="Order Untuk Berapa Hari ">
</div>

<div class="form-group">
    <label>Periode Data</label><br>
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Periode Data">
</div>

<div class="form-group">
    <label>Sampai</label><br>
    <input type="text" class="form-control dsds" id="sampaitgl" autocomplete="off" name="sampaitanggal" placeholder="Sampai">
</div>

    
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i>Tampil</button>
    
</form>
<br>

<span id="result" style="display: none;">
<div class="card card-block">
<center><h2 style="display: none;" id="judul"></h2></center>   

<span id="table-baru">
<div class="table-resposive">
    <table id="tabel_tampil" class="table table-hover table-sm">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
      <th  style='background-color: #4CAF50; color: white'> No. </th>
      <th  style='background-color: #4CAF50; color: white'> Kode Barang </th>
      <th  style='background-color: #4CAF50; color: white'> Nama Barang </th>
      <th  style='background-color: #4CAF50; color: white'> Satuan </th>
      <th  style='background-color: #4CAF50; color: white'> Penjualan Periode </th>
      <th  style='background-color: #4CAF50; color: white'> Penjualan Per Hari </th>
      <th  style='background-color: #4CAF50; color: white'> Target Per Hari </th>
      <th  style='background-color: #4CAF50; color: white'> Proyeksi Penjualan Periode </th>
      <th  style='background-color: #4CAF50; color: white'> Stok Sekarang</th>
      <th  style='background-color: #4CAF50; color: white'> Kebutuhan </th>
        
        </thead> <!-- tag penutup tabel -->
  </table>
  </div>
</span>

      <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Penyimpanan Berhasil
      </div>

<br>
    <div class="row">

        <div class="col-sm-2">
          <input type="text" class="form-control" id="keterangan" autocomplete="off" name="keterangan" placeholder="Keterangan">
          <input type="hidden" class="form-control" id="order_hide" autocomplete="off" name="order_hide" placeholder="Keterangan">
          <a href='target_penjualan.php' style="display:none;" type='submit' id="kembali" class='btn btn-danger'><i class='fa fa-mail-reply'> </i> Kembali</a>
        </div>

        <div class="col-sm-2">
          <button id="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan </button>
          <a id="trx" href='' class='btn btn-success' target='blank' style="display:none;"><i class='fa fa-print'> </i> Cetak</a>
      </div>

      <div class="col-sm-2">
        <a href='' style="width: 170px; display:none;" type='submit' id="btn-export" class='btn btn-default'><i class='fa fa-download'> </i> Download Excel</a>
      </div>
      
  

    </div>
</div>


</span>

</div> <!-- END DIV container -->



    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#btntgl',function(e) {

    var order = $("#order").val();
    var daritgl = $("#daritgl").val();
    var sampaitgl = $("#sampaitgl").val();

    if (order == '') {
      alert("Order Untuk Berapa Hari harus di isi");
      $("#order").focus();
    }
    else if (daritgl == '') {
      alert("Dari tanggal harus di isi");
      $("#daritgl").focus();
    }
    else if (sampaitgl == '') {
      alert("Sampai tanggal harus di isi");
      $("#sampaitgl").focus();
    }
    else
    {
          $('#tabel_tampil').DataTable().destroy();

          var dataTable = $('#tabel_tampil').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_target_penjualan.php", // json datasource
             "data": function ( d ) {
                d.order = $("#order").val();
                d.dari_tanggal = $("#daritgl").val();
                d.sampai_tanggal = $("#sampaitgl").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#tabel_tampil").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tabel_tampil_processing").css("display","none");
              
            }
          }
    


        } );
          $("#result").show()
          $("#keterangan").focus();
          $("#order_hide").val(tandaPemisahTitik(order));
    }



   } );  
  $("#perhari").submit(function(){
      return false;
  });
  function clearInput(){
      $("#perhari :input").each(function(){
          $(this).val('');
      });
  };
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



<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

    $(document).on('click','#btntgl',function(e) {

   
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

        var order = $("#order").val();
        var dari_tanggal = $("#daritgl").val();
        var ambil_tgl1 = ambil_tgl(dari_tanggal);
        var ambil_bln1 = ambil_bln(dari_tanggal);
        var ambil_thn1 = ambil_thn(dari_tanggal);
        var tanggal1 = ambil_tgl1 + "/" + ambil_bln1 + "/" + ambil_thn1;

        var sampai_tanggal = $("#sampaitgl").val();
        var ambil_tgl2 = ambil_tgl(sampai_tanggal);
        var ambil_bln2 = ambil_bln(sampai_tanggal);
        var ambil_thn2 = ambil_thn(sampai_tanggal);

        var tanggal2 = ((parseInt(ambil_tgl1,10) - 1) + parseInt(order,10)) + "/" + ambil_bln2 + "/" + ambil_thn2;


        var judul = " Periode Data " + tanggal1 + " Sampai " + tanggal2;
        var no_trx =  $("#table-baru").text();


          $("#judul").show();
          $("#judul").text(judul);


    });  

      $("#perhari").submit(function(){
      return false;
  });
  function clearInput(){
      $("#perhari :input").each(function(){
          $(this).val('');
      });
  };

  </script>

  <!--<script type="text/javascript">

  $(document).ready(function(){

      $(document).on('blur','#order',function(e){

        var order = $(this).val();

        var order_hari = order + " Hari";

         $(this).val(order_hari);

      });


  });
  </script>
-->


  <script type="text/javascript">

  $(document).ready(function(){

      $(document).on('dblclick','.edit-target-jual',function(e){

        var kode_barang = $(this).attr("data-kode");

        $("#id-kode-"+kode_barang).hide();
        $("#id-target-"+kode_barang).attr("type","text");


      });

      $(document).on('blur','.edit',function(e){

        var id = $(this).attr("data-kode");
        var stok = $("#stok-"+id).text();
        var order = $(this).attr("data-order");
        var target_baru = $(this).val();

        var hitung_proyeksi = parseInt(order,10) * parseInt(target_baru,10);
        var kebutuhan = parseInt(hitung_proyeksi,10) - parseInt(stok,10);
        if (kebutuhan < 0) {
          kebutuhan = 0;
        };


        $.post("edit_target_jual.php",{target_baru:target_baru,hitung_proyeksi:hitung_proyeksi,kebutuhan:kebutuhan,id:id},function(data){


        $("#proyeksi-"+id).text(hitung_proyeksi);
        $("#id-kode-"+id).text(target_baru);
        $("#kebutuhan-"+id).text(kebutuhan);


        $("#id-kode-"+id).show();
        $("#id-target-"+id).attr("type","hidden");


        });

      });


  });
  </script>

  <script type="text/javascript">

  $(document).ready(function(){

      $(document).on('click','#simpan',function(e){

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

        var keterangan = $("#keterangan").val();
        var order = $("#order_hide").val();
        var dari_tanggal = $("#daritgl").val();
        var sampai_tanggall = $("#sampaitgl").val();

        var ambil_tgl1 = ambil_tgl(dari_tanggal);

        var ambil_tgl2 = ambil_tgl(sampai_tanggall);
        var ambil_bln2 = ambil_bln(sampai_tanggall);
        var ambil_thn2 = ambil_thn(sampai_tanggall);

        var sampai_tanggal = ambil_thn2 + "-"  + ambil_bln2 + "-" + ((parseInt(ambil_tgl1,10) - 1) + parseInt(order,10));


        $("#simpan").hide();
        $("#kembali").show();
        $("#keterangan").attr("type","hidden");
        
        $.post("proses_simpan_target_jual.php",{keterangan:keterangan,order:order,sampai_tanggal:sampai_tanggal,dari_tanggal:dari_tanggal},function(data){

          $("#alert_berhasil").show();
          $("#table-baru").html(data);
          $("#trx").show();
          $("#btn-export").show();

          $("#trx").attr('href','cetak_target_jual.php?no_trx='+data+"&daritgl="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&order="+order+"&keterangan="+keterangan);
          $("#btn-export").attr("href","export_target_jual.php?no_trx="+data+"&daritgl="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&order="+order+"&keterangan="+keterangan);


        });

      });


  });

  </script>


<?php 

include 'footer.php';
 ?>