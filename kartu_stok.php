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
      <div class="table-resposive">
           <table id="table_modal_kartu_stok" class="table table-bordered table-sm">
           <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Status </th>
                              
           </thead> <!-- tag penutup tabel -->
           </table>
      </div>
</center>
</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- end of modal data barang  -->



<h1>KARTU STOK</h1> <hr>


<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1) </i>  </button> 
<br><br>
<form class="form-inline" role="form" id="form_tanggal">

<div class="form-group">          
  <label> Kode Barang </label><br>
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

<!-- Start Input Hidden-->
<div class="form-group">
<input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama">
<input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">  
</div>
<!-- Ending Input Hidden-->


<div class="form-group">
          <label> Bulan </label><br>
          <select type="text" name="bulan" id="bulan" class="form-control" required="">
            <option value=""> Pilih Bulan</option>
            <option value="1"> Januari </option>
            <option value="2"> Februari </option>
            <option value="3"> Maret </option>
            <option value="4"> April </option>
            <option value="5"> Mei </option>
            <option value="6"> Juni </option>
            <option value="7"> Juli </option>
            <option value="8"> Agustus </option>
            <option value="9"> September </option>
            <option value="10"> Oktober </option>
            <option value="11"> November </option>
            <option value="12"> Desember </option>
          </select> 
</div>


<div class="form-group">
          <label> Tahun </label><br>
          <select type="text" name="tahun" id="tahun" class="form-control" required="">
          <option value=""> Pilih Tahun </option>
            <option value="2016"> 2016 </option>
            <option value="2017"> 2017 </option>
            <option value="2018"> 2018 </option>
            <option value="2019"> 2019 </option>
            <option value="2020"> 2020 </option>
          </select> 
          </div>


<button type="submit" name="submit" id="lihat_kartu_stok" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>



<span style="display: none" id="result">
<div class="card card-block" >  <center><h2 style="display: none;" id="judul"></h2></center>
  <br>  
 <table id="table-data">
  <tbody>
      <tr><td width="25%"><font class="satu">Nama Barang</font></td> <td> :&nbsp;</td> <td><font class="satu" id="nama"></font> </tr>

      <tr><td  width="25%"><font class="satu">Kode Barang</font></td> <td> :&nbsp;</td> <td><font class="satu" id="kode"></font></td></tr>
         

  </tbody>
</table><br>
   <div class="table-responsive">
    <table id="table_kartu_stoknya" class="table table-sm">

        <!-- membuat nama kolom tabel -->
        <thead>

      <th style='background-color: #4CAF50; color:white'> No Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Tipe </th>
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Masuk </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Keluar </th>
      <th style='background-color: #4CAF50; color:white'> Saldo</th>

        </thead>
    </table>
  </div>

  <div class="row">
        <div class="col-sm-2"><br>
          <a id="trx" href='' class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak</a>
        </div>  

         <div class="col-sm-2">
         <br>
        <a href='' style="width: 170px;" type='submit' id="btn-export" class='btn btn-default'><i class='fa fa-download'> </i> Download Excel</a>
        </div>
    </div>
</div>

  </span>
</div><!--Div Container-->


<script type="text/javascript">
//berdasarkan rm dan tanggal
        $(document).on('click','#lihat_kartu_stok',function(){

        var kode_barang = $("#kode_barang").val();
        var nama_barang = $("#nama_barang").val();   
        var id_produk = $("#id_produk").val();        
        var bulan = $("#bulan").val();        
        var tahun = $("#tahun").val();

        if(kode_barang == '')
        {
          alert("Masukan Kode Barang Terlebih Dahulu!");
          $("#kode_barang").focus();

        }
        else if(bulan == '')
        {
          alert("Pilih Bulan Yang Akan di Tampilkan!!");
          $("#bulan").focus();
        }
        else if(tahun == '')
        {
          alert("Pilih Tahun Yang Akan di Tampilkan!!");
          $("#tahun").focus();
        }
        else
        {
            $("#result").show();
            $('#table_kartu_stoknya').DataTable().destroy();
          
              var dataTable = $('#table_kartu_stoknya').DataTable( {
              "processing": true,
              "serverSide": true,
              "ajax":{
                url :"datatable_kartu_stok.php", // json datasource
                "data": function ( d ) {
                d.kode_barang = $("#kode_barang").val();
                d.nama_barang = $("#nama_barang").val();   
                d.id_produk = $("#id_produk").val();        
                d.bulan = $("#bulan").val();        
                d.tahun = $("#tahun").val();
                // d.custom = $('#myInput').
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                type: "post",  // method  , by default get
                error: function(){  // error handling
                  $(".employee-grid-error").html("");
                  $("#table_kartu_stoknya").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                  $("#employee-grid_processing").css("display","none");
                }
            },
                
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('class','tr-id-'+aData[10]+'');
                },

            });


      
          if (bulan == '1')
          {
          moon = 'Januari';
          }
          else if (bulan == '2')
          {
          moon = 'Febuari';
          }
          else if (bulan == '3')
          {
          moon = 'Maret';
          }
          else if (bulan == '4')
          {
          moon = 'April';
          }
          else if (bulan == '5')
          {
          moon = 'Mei';
          }
          else if (bulan == '6')
          {
          moon = 'Juni';
          }
          else if (bulan == '7')
          {
          moon = 'Juli';
          }
          else if (bulan == '8')
          {
          moon = 'Agustus';
          }
          else if (bulan == '9')
          {
          moon = 'September';
          }
          else if (bulan == '10')
          {
          moon = 'Oktober';
          }
          else if (bulan == '11')
          {
          moon = 'November';
          }
          else if (bulan == '12')
          {
          moon = 'Desember';
          }


          var judul = "Periode" + " " + moon + " " + " " + tahun;

          $("#judul").show();
          $("#judul").text(judul);
 
          $("#btn-export").attr('href','export_kartu_stok.php?bulan='+bulan+'&tahun='+tahun+'&kode_barang='+kode_barang+'&nama_barang='+nama_barang+'&moon='+moon);
          $("#trx").attr("href",'cetak_kartu_stok_bulan.php?bulan='+bulan+'&tahun='+tahun+'&kode_barang='+kode_barang+'&nama_barang='+nama_barang+'&moon='+moon);
         

            $("#nama").text(nama_barang)
            $("#kode").text(kode_barang)

                        $("form").submit(function(){
            return false;
            });

          }// /else 
        });
           
        $("form").submit(function(){
        
        return false;
        
        });
        
</script>


<!--<script type="text/javascript">
  $("#cari_produk_penjualan").click(function() {

      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      
      var kode_pelanggan = $("#kd_pelanggan").val();
      //coding update jumlah barang baru "rabu,(9-3-2016)"
      $.post('modal_kartu_stok_baru.php',{kode_pelanggan:kode_pelanggan},function(data) {
      
      $(".modal_baru").html(data);
     
      });
      /* Act on the event */
      });

</script>-->

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

<script type="text/javascript">
  //SELECT CHOSSESN    
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});    
</script>

<script>
//Choosen Open select
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});
</script>

<script type="text/javascript">
  $("#cari_produk_penjualan").click(function() {
    var kode_pelanggan = $("#kd_pelanggan").val();
    $("#alert_berhasil").hide();
    $("#table_modal_kartu_stok").DataTable().destroy();
          var dataTable = $('#table_modal_kartu_stok').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_modal_kartu_stok_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_modal_kartu_stok").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
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
