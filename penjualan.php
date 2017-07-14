<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$status = $_GET['status'];

 ?>




<div class="container"><!--start of container-->

<!--hidden untuk no faktur buat kirim ke button detail-->
    <input type="hidden" name="no_faktur_detail" class="form-control " id="no_faktur_detail" placeholder="no_faktur  "/>
    <input type="hidden" name="status" class="form-control " id="status" value="<?php echo $status ?>" "/>

<!--MODAL VOID -->
<div id="modal_void" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Batal / Void</h4>
      </div>
      <div class="modal-body">
  <form role="form" action="proses_login_void.php" method="post" >
   <div class="form-group" id="modal_login">
<h3> Silakan Masuk </h3>
          <input type="text" name="username" placeholder="Username" id="username" autocomplete="off" required class="form-control input-lg" value="" /> <br>
          
          <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password  " required="" /> <br>

          <button type="submit" id="login" class="btn btn-primary">LogIn</button>
	</div>
</form>


	
	 <form role="form" action="Proses_batal_void.php" method="post" >
	<div class="form-group" id="modal_keterangan" style="display:none">

			<label> Keterangan Batal </label>
			<textarea name="keterangan" id="keterangan" class="form-control"></textarea><br>
			<input type="hidden" name="no_faktur" class="form-control input-lg" id="no_faktur_batal" placeholder="no_faktur  "/>
			
			<button type="submit" id="batal_penjualan" class="btn btn-danger">Batal / Void</button>
    
   </div>

   
  </form>

<div class="alert-sukses alert-info" style="display:none">
            <strong>SUKSES!</strong> LogIn Berhasil !.
</div>

<div class="alert-void alert-danger" style="display:none">
                <strong>PERHATIAN!</strong> LogIn Gagal !.
</div>

  
 <div class="alert alert-info" style="display:none">
            <strong>SUKSES!</strong>Pindah Meja Berhasil
 </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal pindah meja -->


<!-- Modal pindah meja -->
<div id="modal_meja_edit" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Pindah Meja</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nomor / Nama Meja Baru:</label><br>

    	<select type="text" name="kode_meja" id="meja_edit" class="form-control" required="" >
    	<option value="">--SILAHKAN PILIH--</option>
			<?php 
			
			//untuk menampilkan semua data pada tabel pelanggan dalam DB
			$query = $db->query("SELECT kode_meja, nama_meja FROM meja WHERE status_pakai = 'Belum Terpakai'");
			
			//untuk menyimpan data sementara yang ada pada $query
			while($data = mysqli_fetch_array($query))
			{
			
			echo "<option value='".$data['kode_meja'] ."'>".$data['nama_meja'] ."</option>";
			}
			
			
			?>
    	</select>




     <label for="email">Nomor / Nama Meja Lama:</label>
     <input type="text" class="form-control" id="meja_lama" readonly="">
     <input type="hidden" class="form-control" id="no_faktur_meja">
    
   </div>
    <button type="submit" id="submit_meja" class="btn btn-primary">Submit</button>
   
  </form>
  
 <div class="alert alert-info" style="display:none">
            <strong>SUKSES!</strong>Pindah Meja Berhasil
 </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal pindah meja -->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Penjualan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label>Kode Pelanggan :</label>
     <input type="text" id="kode_pelanggan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
     <input type="hidden" id="kode_meja" class="form-control" > 
     <input type="text" id="faktur_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->


<div id="modal_detail" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><h4><b>Detail Penjualan</b></h4></center></h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>

       
  <table id="table_modal_detail" class="table table-bordered table-sm">
  <thead> <!-- untuk memberikan nama pada kolom tabel -->

          <th> No Faktur </th>
          <th> Kode Barang </th>
          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Satuan </th>
          <th> Harga </th>
          <th> Subtotal </th>
          <th> Potongan </th>
          <th> Tax </th>

  </thead> <!-- tag penutup tabel -->
  </table>


      </div>

     </div>

      <div class="modal-footer">
        
  <center><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></center>
      </div>
    </div>

  </div>
</div>


<div id="modal_bonus" class="modal" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><h4><b>Bonus Penjualan</b></h4></center></h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>

       
  <table id="table_modal_bonus" class="table table-bordered table-sm">
  <thead> <!-- untuk memberikan nama pada kolom tabel -->

          <th> No Faktur </th>
          <th> Kode Barang </th>
          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Satuan </th>
          <th> Harga </th>
          <th> Subtotal </th>
          <th> Potongan </th>
          <th> Tax </th>

  </thead> <!-- tag penutup tabel -->
  </table>


      </div>

     </div>

      <div class="modal-footer">
        
  <center><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></center>
      </div>
    </div>

  </div>
</div>

<div id="modal_alert" class="modal" role="dialog">
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
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Pembayaran Piutang atau Item Keluar</h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<h3>DATA PENJUALAN</h3>
<hr>

<div class="row">

<div class="col-sm-5">

<?php 
$pilih_akses_penjualan_tambah = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_tambah = '1'");
$penjualan_tambah = mysqli_num_rows($pilih_akses_penjualan_tambah);


if ($penjualan_tambah > 0){
 echo '<a href="formpenjualan.php" class="btn btn-info" > <i class="fa fa-plus"> </i>  PENJUALAN </a>';
 
}
?>

</div>


<div class="col-sm-7">
	<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
       <?php if ($status == 'semua'): ?>

      <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=semua'> Semua Penjualan </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Lunas' > Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Piutang' > Penjualan Piutang </a></li>
       	
       <?php endif ?>

       <?php if ($status == 'Lunas'): ?>

         <li class="nav-item"><a class="nav-link" href='penjualan.php?status=semua'> Semua  Penjualan </a></li>
        <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=Lunas'> Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Piutang' > Penjualan Piutang </a></li>
       	
       <?php endif ?>

       <?php if ($status == 'Piutang'): ?>

          <li class="nav-item"><a class="nav-link" href='penjualan.php?status=semua'> Semua  Penjualan </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Lunas'> Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=Piutang'> Penjualan Piutang </a></li>
       	
       <?php endif ?>


         </ul>
</div>
       
</div>



<style>


tr:nth-child(even){background-color: #f2f2f2}


</style>
<br>



<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="table_penjualan" class="table table-bordered table-sm">
		<thead>

		
			
<?php 
$pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){
				echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
			}
				
?>



<?php 
$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


    if ($penjualan_hapus > 0){

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";

		}
?>
			<th style='background-color: #4CAF50; color:white'> Cetak  Tunai </th>
			<th style='background-color: #4CAF50; color:white'> Cetak Piutang </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>
      <th style='background-color: #4CAF50; color:white'> Bonus </th>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Gudang </th>
			<!--<th style='background-color: #4CAF50; color:white'> Bayar </th>-->
			<th style='background-color: #4CAF50; color:white'> Kode Pelanggan</th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Jt </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> Petugas Kasir </th>
			<th style='background-color: #4CAF50; color:white'> Sales </th>
			<th style='background-color: #4CAF50; color:white'> Status </th>
			<th style='background-color: #4CAF50; color:white'> Potongan </th>
			<th style='background-color: #4CAF50; color:white'> Tax </th>
			<th style='background-color: #4CAF50; color:white'> Kembalian </th>
			<th style='background-color: #4CAF50; color:white'> Kredit </th>

		</thead>
		
</table>
</span>
</div>



</div><!--end of container-->
		
<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
          $('#table_penjualan').DataTable().destroy();
          var dataTable = $('#table_penjualan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_penjualan.php", // json datasource
            "data": function ( d ) {
                      d.status = $("#status").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[20]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->




		<script type="text/javascript">
			$(document).ready(function(){
//fungsi hapus data

		$(document).on('click', '.btn-hapus', function (e) {
		var kode_pelanggan = $(this).attr("data-pelanggan");
		var id = $(this).attr("data-id");
		var no_faktur = $(this).attr("data-faktur");
		var kode_meja = $(this).attr("kode_meja");


		$("#kode_pelanggan").val(kode_pelanggan);
    $("#id_hapus").val(id);
		$("#faktur_hapus").val(no_faktur);
		$("#kode_meja").val(kode_meja);

		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		
		var id = $(this).attr("data-id");
		var no_faktur = $("#faktur_hapus").val();
		var kode_meja = $("#kode_meja").val();
		
		
		
		$("#modal_hapus").modal('hide');

		$.post("hapus_data_penjualan.php",{id:id,no_faktur:no_faktur,kode_meja:kode_meja},function(data){


      var table_penjualan = $('#table_penjualan').DataTable();
          table_penjualan.draw();
		
		});
		
		
		});




						$('form').submit(function(){
						
						return false;
						});
});

		</script>

		<script type="text/javascript">
		
		$(".pindah_meja").click(function(){
		var no_faktur = $(this).attr('no_faktur');
		var kode_meja = $(this).attr('kode_meja');
		$("#no_faktur_meja").val(no_faktur);
		$("#meja_lama").val(kode_meja);
		$("#modal_meja_edit").modal('show');
		});

		$("#submit_meja").click(function(){
		var no_faktur = $("#no_faktur_meja").val();
		var kode_meja = $("#meja_lama").val();
		var meja_baru = $("#meja_edit").val();
		
		$.post('proses_pindah_meja.php',{no_faktur:no_faktur,kode_meja:kode_meja,meja_baru:meja_baru},function(info) {
		
		$(".alert").show();
		$("#table-baru").html(info);
		$("#table-baru").load('tabel-penjualan.php');
		setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
		
		
		});
		
		});
		
				$('form').submit(function(){
				
				return false;
				});


     function tutupmodal() {
     $("#modal_meja_edit").modal("hide")
     }
     function tutupalert() {
     $(".alert").hide("fast")
     }
		</script>




		<script type="text/javascript">
			
		$(".void").click(function(){

		var no_faktur = $(this).attr('no_faktur');

		$("#no_faktur_batal").val(no_faktur);
		$("#modal_void").modal('show');

		});

$("#login").click(function(){

		var username = $("#username").val();
		var password = $("#password").val();

		$.post('proses_login_void.php',{username:username,password:password},function(data){

	if (data == "sukses") {

		
		$("#modal_void").modal('show');
		$("#modal_login").hide('fast');
		$("#modal_keterangan").show('fast');
		$(".alert-sukses").show();
		$(".alert-void").hide();
		setTimeout(tutupalert, 2000);

		}
		else{

		$("#modal_login").hide('fast');

			$(".alert-void").show();
			setTimeout(tutupalert, 2000);

			$("#username").val('');
			$("#password").val('');
		$("#modal_login").show('fast');
		}

		





});

		

});


     function tutupmodal() {
     $("#modal_void").modal("hide")
     }
     function tutupalert() {
     $(".alert-sukses").hide("fast")
     $(".alert-void").hide("fast")
     }

		</script>

		<script type="text/javascript">



			$("#batal_penjualan").click(function(){

				var keterangan = $("#keterangan").val();
				var no_faktur = $("#no_faktur_batal").val();
				

				$.post('proses_batal_void.php',{keterangan:keterangan, no_faktur:no_faktur},function(data){

				$("#table-baru").load('tabel-penjualan.php');
				$("#keterangan").val('');
				$("#modal_void").modal('hide');

			});
			});
		</script>


<script type="text/javascript">
	
		$(document).on('click', '.btn-alert', function (e) {
		var no_faktur = $(this).attr("data-faktur");

		$.post('modal_retur_piutang.php',{no_faktur:no_faktur},function(data){


		$("#modal_alert").modal('show');
		$("#modal-alert").html(data);

		});

		
		});

</script>

<!--/Pagination teal-->



<!--Start Ajax Modal DETAIL-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
    $(document).on('click', '.detail', function (e) {
    $("#modal_detail").modal('show');

    var no_faktur = $(this).attr("no_faktur");
    $("#no_faktur_detail").val(no_faktur);
      var no_faktur_detail = $("#no_faktur_detail").val();
            $('#table_modal_detail').DataTable().destroy();

        var dataTable = $('#table_modal_detail').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_detail_penjualan.php", // json datasource
             "data": function ( d ) {
                  d.no_faktur = $("#no_faktur_detail").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_modal_detail").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

         

        });  
  
     }); 
  });
 </script>
<!--Ending Ajax Modal Detail-->

<!--Start Ajax Modal Bonus-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
    $(document).on('click', '.bonus', function (e) {
    $("#modal_bonus").modal('show');

    var no_faktur = $(this).attr("no_faktur");
    $("#no_faktur_detail").val(no_faktur);
      var no_faktur_detail = $("#no_faktur_detail").val();
            $('#table_modal_bonus').DataTable().destroy();

        var dataTable = $('#table_modal_bonus').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_bonus_penjualan.php", // json datasource
             "data": function ( d ) {
                  d.no_faktur = $("#no_faktur_detail").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_modal_bonus").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

         

        });  
  
     }); 
  });
 </script>
<!--Ending Ajax Modal Bonus-->

<!--Start Ajax Modal Cari-->
<!--menampilkan detail penjualan-->

<!--<script type="text/javascript">
    $(document).on('click', '.detail', function (e){
    var no_faktur = $(this).attr('no_faktur');
    
    
    $("#modal_detail").modal('show');
    
    $.post('proses_detail_penjualan.php',{no_faktur:no_faktur},function(info) {
    
    $("#modal-detail").html(info);
    
    
    });
    
    });
    
    </script>-->

<?php 
include 'footer.php';
 ?>