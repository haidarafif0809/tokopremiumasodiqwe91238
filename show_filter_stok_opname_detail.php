<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$dari_tanggal = $_POST['dari_tanggal'];
$sampai_tanggal= $_POST['sampai_tanggal'];

$query = $db->query("SELECT * FROM detail_stok_opname WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' order by tanggal asc");

?>
<div class="container"><!--start of container-->

<h3><b><center> Data Detail Stok Opname Dari Tanggal <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?> </center> </b></h3><hr>

<?php
include 'db.php';

$pilih_akses_stok_opname = $db->query("SELECT * FROM otoritas_stok_opname WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$stok_opname = mysqli_fetch_array($pilih_akses_stok_opname);

if ($stok_opname['stok_opname_tambah'] > 0) {

echo '<a href="form_stok_opname.php"  class="btn btn-info" > <i class="fa fa-plus"> </i> STOK OPNAME</a>';

}

?>
<br>
<button type="submit" name="submit" id="filter_1" class="btn btn-primary" ><i class="fa fa-eye"> </i> Filter Faktur </button>
<button type="submit" name="submit" id="filter_2" class="btn btn-primary" ><i class="fa fa-eye"> </i> Filter Detail </button>


<!--START FILTER FAKTUR-->
<span id="fil_faktur">
<form class="form-inline" action="show_filter_stok_opname.php" method="post" role="form">
					
					<div class="form-group"> 
					
					<input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
					</div>
					
					<div class="form-group"> 
					
					<input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
					</div>
					
					<button type="submit" name="submit" id="submit_filter_1" class="btn btn-primary" ><i class="fa fa-eye"> </i> Filter Faktur </button>

					
</form>
<span id="result"></span>  
</span>
<!--END FILTER FAKTUR-->

<!--START FILTER DETAIl-->
<span id="fil_detail">
<form class="form-inline" action="show_filter_stok_opname_detail.php" method="post" role="form">
					
					<div class="form-group"> 
					
					<input type="text" name="dari_tanggal" id="dari_tanggal2" class="form-control" placeholder="Dari Tanggal" required="">
					</div>
					
					<div class="form-group"> 
					
					<input type="text" name="sampai_tanggal" id="sampai_tanggal2" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
					</div>
					
					<button type="submit" name="submit" id="submit_filter_2" class="btn btn-primary" ><i class="fa fa-eye"> </i> Filter Detail </button>

					
</form>
<span id="result"></span>  
</span>
<!--END FILTER DETAIl-->


<br><br>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="table-responsive">  
<span id="tabel_baru">     
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
			<th style='background-color: #4CAF50; color:white'> Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Hpp </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Harga </th>

			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($query))
			{
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['stok_sekarang'] ."</td>
			<td>". rp($data1['fisik']) ."</td>
			<td>". rp($data1['selisih_fisik']) ."</td>
			<td>". rp($data1['hpp']) ."</td>
			<td>". rp($data1['selisih_harga']) ."</td>

			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>

	</span>


</div> 
<a href='expor_excel_stok_opname_detail.php?dari tanggal=<?php echo $dari_tanggal; ?>&sampai tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-warning' role='button'>Download Excel</a>


</div> <!--end container-->



<script>
		$(document).ready(function(){
		$('#tableuser').DataTable();
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
include 'footer.php'; ?>