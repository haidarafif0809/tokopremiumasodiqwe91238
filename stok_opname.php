<?php include 'session_login.php';

//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM stok_opname");


 ?>


<style>
	tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container"> <!--start of container-->

<h3><b> DATA STOK OPNAME </b></h3><hr>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Satuan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nomor Faktur :</label>
     <input type="text" id="data_faktur" class="form-control" readonly=""> 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
        
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-alert">
       </span>
      </div>

     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data, 
        silahkan hapus terlebih dahulu<br> Transaksi Penjualan.</i></h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!--membuat link-->

<?php
include 'db.php';

$pilih_akses_stok_opname = $db->query("SELECT stok_opname_edit,stok_opname_tambah,stok_opname_hapus FROM otoritas_stok_opname WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$stok_opname = mysqli_fetch_array($pilih_akses_stok_opname);

if ($stok_opname['stok_opname_tambah'] > 0) {

echo '<button id="tambah" type="submit" class="btn btn-primary" data-toggle="collapse"  accesskey="r" ><i class="fa fa-plus"> </i>&nbsp;Stok Opname</button>';
echo '<button style="display:none" data-toggle="collapse tooltip" accesskey="k" id="kembali" class="btn btn-warning" data-placement="top" title="Klik untuk kembali ke utama.""><i class="fa fa-reply"></i> <u>K</u>embali </button>';
}

?>
<div id="demo" class="collapse">

 <form role="form" id="formtambahproduk">

  <div class="form-group">        
    <input type="text" name="kode_barang" id="kode_barang" style="width:35%" class="form-control" placeholder="Ketikan Kode Barang / Nama Barang ">
       <?php 

        /* include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

        */?>
 

      <input type="hidden" class="form-control" name="nama_barang" id="nama_barang" >
   
      <input type="text"  class="form-control"  style="width:35%" name="fisik" autocomplete="off" id="jumlah_fisik" placeholder="Jumlah Fisik">

       <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
                  <input type="hidden" id="satuan" name="satuan" class="form-control" value="" required="">
                  <input type="hidden" name="no_faktur" id="nomorfaktur1" class="form-control" value="" required="" >
            
        <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
     </div>
</form>

            <span id="result">  
                  <div class="table-responsive">    
                  <table id="tabel_tbs_stok_opname" align="center" class="table table-bordered table-sm">
                  <thead>
                      <th> Kode Barang </th>
                      <th> Nama Barang </th>
                      <th> Satuan </th>
                      <th> Stok Komputer </th>
                      <th> Jumlah Fisik </th>
                      <th> Selisih Fisik </th>
                      <th> Hapus </th>         
                  </thead>
                 
                  
                  </table>
                  </div>
                  </span> <!--tag penutup span-->
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>


    <input type="hidden" class="form-control" style="font-size: 25px" name="total_selisih_harga" id="total_selisih_harga" readonly="" placeholder="Total Selisih Harga">

    <button type="submit" id="selesai" style="display:none;" class="btn btn-info"> <i class='fa fa-send'> </i> Selesai </button>


</div>

<br><br>
<button type="submit" name="submit" id="filter_1" class="btn btn-primary" > Filter Faktur </button>
<button type="submit" name="submit" id="filter_2" class="btn btn-primary" > Filter Detail </button>

  <input type="hidden" name="no_faktur_detail" class="form-control " id="no_faktur_detail" placeholder="no_faktur  "/>
<!--START FILTER FAKTUR-->
<span id="fil_faktur">
<form class="form-inline" action="show_filter_stok_opname.php" method="get" role="form">
					
					<div class="form-group"> 
					
					<input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
					</div>
					
					<div class="form-group"> 
					
					<input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
					</div>
					
					<button type="submit" name="submit" id="submit_filter_1" class="btn btn-success" ><i class="fa fa-eye"> </i> Lihat Faktur </button>

					
</form>
<span id="result"></span>  
</span>
<!--END FILTER FAKTUR-->

<!--START FILTER DETAIl-->
<span id="fil_detail">
<form class="form-inline" action="show_filter_stok_opname_detail.php" method="get" role="form">
					
					<div class="form-group"> 
					
					<input type="text" name="dari_tanggal" id="dari_tanggal2" class="form-control" placeholder="Dari Tanggal" required="">
					</div>
					
					<div class="form-group"> 
					
					<input type="text" name="sampai_tanggal" id="sampai_tanggal2" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
					</div>
					
					<button type="submit" name="submit" id="submit_filter_2" class="btn btn-success" ><i class="fa fa-eye"> </i> Lihat Detail </button>

					
</form>
<span id="result"></span>  
</span>
<!--END FILTER DETAIl-->

<div class="table-responsive">
<span id="tabel_baru">
<table id="table_stok_opname" class="table table-bordered table-sm">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
      <th style='background-color: #4CAF50; color:white'> Nama Barang </th>
      <th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
      <th style='background-color: #4CAF50; color:white'> Fisik </th>
      <th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
      <th style='background-color: #4CAF50; color:white'> Selisih Harga</th>
      <th style='background-color: #4CAF50; color:white'> Status </th>
      <th style='background-color: #4CAF50; color:white'> User </th>
      <th style='background-color: #4CAF50; color:white'> Keterangan </th>
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jam </th>

			<?php 

				if ($stok_opname['stok_opname_edit'] > 0) {
					echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
				}
							 ?>

				<?php
				include 'db.php';

				if ($stok_opname['stok_opname_hapus'] > 0) {

								echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
							}
			?>
			
			<th style='background-color: #4CAF50; color:white'> Download </th>
			
		</thead>
		
	</table>
</span>
</div>

<br>


                 <script>
                  //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk
                 $(document).on('click', '#submit_produk', function () {
                  
                  var kode_barang = $("#kode_barang").val();
                  var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
                  var nama_barang = $("#nama_barang").val();
                  var fisik = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_fisik").val()))));
                  var satuan = $("#satuan").val();

                  if (kode_barang == ""){
                  alert("Kode Barang Harus Diisi");
                  }
                  else if (fisik == ""){
                  alert("Jumlah Fisik Harus Diisi");
                  }
                 
                  else{

                    $.get('cek_kode_barang_tbs_stok_opname.php',function(json){
      
                  if(json == 1)
                  {
                    alert("Anda Sudah Melakukan Stok Opname , Selesaikan Terlebih dahulu ");
                    $("#kode_barang").focus();
                    $("#kode_barang").val('');
                    $("#nama_barang").val('');
                    $("#jumlah_fisik").val('');

                  }
                  else{  

                 $.post("proses_tbs_stok_opname.php", {kode_barang:kode_barang,nama_barang:nama_barang,satuan:satuan,fisik:fisik}, function(info) {
                  


                  $("#kode_barang").focus();

          $('#tabel_tbs_stok_opname').DataTable().destroy();
          //pembaruan datatable data tbs stok opname 
           var dataTable = $('#tabel_tbs_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_stok_opname.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_tbs_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
           },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-tbs-id-'+aData[7]+'');
            },
          });
         //pembaruan datatable data tbs stok opname 


                  $("#kode_barang").val('');
                  $("#nama_barang").val('');
                  $("#jumlah_fisik").val('');
                  $("#satuan").val('');
                  $("#kode_barang").hide();
                  $("#nama_barang").hide();
                  $("#jumlah_fisik").hide();
                  $("#satuan").hide();
                  $("#submit_produk").hide();
                  $("#selesai").click();
                  

                  });
               
               } // penutup else 

           }); // penutup  $.get('cek_kode_barang_tbs_stok_opname.php',function(json){

        }//penutup else luar

                  $("form").submit(function(){
                  return false;
                  });
        });
//menyembunyikan notif berhasil
     $("#alert_berhasil").hide();
</script>


<script type="text/javascript">
       $(document).ready(function(){
                $.get("cek_total_selisih_harga.php",function(data){
                data = data.replace(/\s+/g, '');
                    $("#total_selisih_harga").val(tandaPemisahTitik(data));
                    });


              $(".container").hover(function(){
                  
                  $.get("cek_total_selisih_harga.php",function(data){
                     data = data.replace(/\s+/g, '');
                  $("#total_selisih_harga").val(tandaPemisahTitik(data));
                  }); 
             });
     });
</script>


<script>            
    $(document).on('click', '#selesai', function () {
                  var total_selisih_harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_selisih_harga").val()))));
                  var keterangan = $("#keterangan").val();


                 
                  $.get('cek_kode_barang_tbs_stok_opname.php',function(json){
      
                  if(json == 0)
                  {
                    alert("Anda Belum Melakukan Stok Opname  ");
                    $("#kode_barang").focus();
                  }
                  else{
                  $.post("proses_selesai_stok_opname.php",{total_selisih_harga:total_selisih_harga,keterangan:keterangan},function(info) {
                  
                  $("#result").hide();

            $('#table_stok_opname').DataTable().destroy();
            $('#tabel_tbs_stok_opname').DataTable().destroy();


//pembaruan datatable data stok opname 
          var dataTable = $('#table_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_stok_opname.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[15]+'');
            },
        });
//pembaruan datatable data stok opname 

//pembaruan datatable data tbs stok opname 
         var dataTable = $('#tabel_tbs_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_stok_opname.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_tbs_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-tbs-id-'+aData[7]+'');
            },
        });
//pembaruan datatable data tbs stok opname 


                  $("#total_selisih_harga").val('');       
                  $("#alert_berhasil").show();
                  $("#kode_barang").show();
                  $("#nama_barang").show();
                  $("#jumlah_fisik").show();

                  $("#kode_barang").val('');
                  $("#nama_barang").val('');
                  $("#jumlah_fisik").val('');

                  $("#submit_produk").show();
                  $("#satuan").show();
                  $("#demo").hide();
                  $("#tambah").show();
                  $("#kembali").hide();
                  $("#filter_1").show();
                  $("#filter_2").show();


                  
                  });
                  
                  // #result didapat dari tag span id=result
                  //mengambil no_faktur pembelian agar berurutan
               
                  $("form").submit(function(){
                  return false;
               });
              }//ennd else kode barang
          });  
   });                  
</script>


<!--script disable hubungan pasien-->
<script type="text/javascript">
$(document).ready(function(){

  $("#tambah").click(function(){
  $("#demo").show();
  $("#kembali").show();
  $("#tambah").hide();
  $("#filter_1").hide();
  $("#filter_2").hide();
  $("#kode_barang").show();
  $("#nama_barang").show();
  $("#jumlah_fisik").show();

  $("#kode_barang").val('');
  $("#nama_barang").val('');
  $("#jumlah_fisik").val('');
  $("#submit_produk").show(); 

            $('#tabel_tbs_stok_opname').DataTable().destroy();
//pembaruan datatable data tbs stok opname 
         var dataTable = $('#tabel_tbs_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_stok_opname.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_tbs_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-tbs-id-'+aData[7]+'');
            },
        });
//pembaruan datatable data tbs stok opname 



  });

  $("#kembali").click(function(){
  $("#demo").hide();
  $("#tambah").show();
  $("#kembali").hide();
  $("#filter_1").show();
  $("#filter_2").show();

            $('#tabel_tbs_stok_opname').DataTable().destroy();
  //pembaruan datatable data tbs stok opname 
         var dataTable = $('#tabel_tbs_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_stok_opname.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_tbs_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-tbs-id-'+aData[7]+'');
            },
        });
//pembaruan datatable data tbs stok opname 


  });
});
</script>


<script type="text/javascript">
  
        $(document).ready(function(){
          $("#kode_barang").blur(function(){

          var kode_barang = $('#kode_barang').val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));


    $.getJSON('lihat_stok_opname.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        $('#nama_barang').val('');
        $('#satuan').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#satuan').val(json.satuan);
      }
                                              
      });
      
        
        });
        }); 
</script>




                              <script type="text/javascript">
                                $(document).on('dblclick', '.edit-jumlah', function () {

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });

                                $(document).on('blur', '.input_jumlah', function () {

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var harga = $(this).attr("data-harga");
                                    var kode_barang = $(this).attr("data-kode");

                                    var stok_sekarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-stok-sekarang-"+id+"").text()))));
                                    var hpp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-hpp-"+id+"").text()))));

                                    var selisih_fisik = parseInt(jumlah_baru,10) - parseInt(stok_sekarang,10);
                                    var selisih_harga = parseInt(selisih_fisik,10) * parseInt(hpp,10);


                              
                                  $.post("update_tbs_stok_opname.php", {jumlah_baru:jumlah_baru,id:id,kode_barang:kode_barang,selisih_harga:selisih_harga,selisih_fisik:selisih_fisik}, function(info){


                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-selisih-"+id+"").text(tandaPemisahTitik(selisih_harga));
                                    $("#text-selisih-fisik-"+id+"").text(tandaPemisahTitik(selisih_fisik));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");        
                                    
                                    
                                    });
                                    
                           

                                   
                                   $("#kode_barang").focus();

                                 });

                             </script>



<script type="text/javascript">

                                  
//fungsi hapus data 
    $(document).on('click', '.btn-hapus-tbs', function (e) {
    var nama_barang = $(this).attr("data-nama-barang");
    var kode_barang = $(this).attr("data-kode-barang");
    var id = $(this).attr("data-id");
                  
                  $.get("cek_total_selisih_harga.php",function(data){
                     data = data.replace(/\s+/g, '');
                  $("#total_selisih_harga").val(tandaPemisahTitik(data));
                  });

    $(".tr-tbs-id-"+id).remove();
    $.post("hapus_tbs_stok_opname.php",{kode_barang:kode_barang},function(data){
   
    
    });
    
    });
// end fungsi hapus data
 </script>


<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>


	<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
</div><!--end of container-->
		<span id="demo"> </span>

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

            $('#table_stok_opname').DataTable().destroy();
            $('#table_tbs_stok_opname').DataTable().destroy();


//pembaruan datatable data stok opname 
          var dataTable = $('#table_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_stok_opname.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[15]+'');
            },
        });
//pembaruan datatable data stok opname 

//pembaruan datatable data tbs stok opname 
         var dataTable = $('#tabel_tbs_stok_opname').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_tbs_stok_opname.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_tbs_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-tbs-id-'+aData[7]+'');
            },
        });
//pembaruan datatable data tbs stok opname 


        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->


<script type="text/javascript">
	
	//fungsi hapus data 
		$(document).on('click','.btn-hapus',function(e){
		var no_faktur = $(this).attr("data-faktur");
		var id = $(this).attr("data-id");
		
		$("#data_faktur").val(no_faktur);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
// end fungsi hapus data

</script>

<script type="text/javascript">
     $(document).on('click', '#btn_jadi_hapus', function (e) {    
					var no_faktur = $("#data_faktur").val();
					var id = $(this).attr("data-id");
                    
                    
                    $("#modal_hapus").modal('hide');
                    
                    $.post("hapus_data_stok_opname.php",{no_faktur:no_faktur},function(data){
                      $('#table_stok_opname').DataTable().destroy();
     
                  var dataTable = $('#table_stok_opname').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      "ajax":{
                        url :"datatable_stok_opname.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                          $(".employee-grid-error").html("");
                          $("#table_stok_opname").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                          $("#employee-grid_processing").css("display","none");
                          }
                      },
                         "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                          $(nRow).attr('class','tr-id-'+aData[15]+'');         

                      }
                    });
                    });

                    
        }); 

     
</script>

<script type="text/javascript">
	
	$(document).on('click', '.btn-alert', function (e) {    

		var no_faktur = $(this).attr("data-faktur");

		$.post('modal_alert_hapus_data_stok_opname.php',{no_faktur:no_faktur},function(data){


		$("#modal_alert").modal('show');
		$("#modal-alert").html(data);

		});

		
		});

</script>



<script>
    $(function() {
    $( "#dari_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


    <script>
    $(function() {
    $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <script>
    $(function() {
    $( "#dari_tanggal2" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


    <script>
    $(function() {
    $( "#sampai_tanggal2" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <script type="text/javascript">
//fil FAKTUR
$("#submit_filter_1").click(function() {
$.post($("#formtanggal").attr("action"), $("#formtanggal :input").serializeArray(), function(info) { $("#dataabsen").html(info); });
    
});

$("#formtanggal").submit(function(){
    return false;
});

function clearInput(){
    $("#formtanggal :input").each(function(){
        $(this).val('');
    });
};



</script>

<script type="text/javascript">
//fill DETAIL
$("#submit_filter_2").click(function() {
$.post($("#formtanggal").attr("action"), $("#formtanggal :input").serializeArray(), function(info) { $("#dataabsen").html(info); });
    
});

$("#formtanggal").submit(function(){
    return false;
});

function clearInput(){
    $("#formtanggal :input").each(function(){
        $(this).val('');
    });
};



</script>

<script type="text/javascript">
		$(document).ready(function(){
			$("#fil_faktur").hide();
			$("#fil_detail").hide();
	});
</script>


<script type="text/javascript">
		$(document).ready(function(){
				$("#filter_1").click(function(){		
			$("#fil_faktur").show();
			$("#filter_2").show();
			$("#filter_1").hide();	
			$("#fil_detail").hide();
			});

				$("#filter_2").click(function(){		
			$("#fil_detail").show();	
			$("#fil_faktur").hide();
			$("#filter_2").hide();
			$("#filter_1").show();
			});

	});
</script>

<?php 
include 'footer.php';
 ?>