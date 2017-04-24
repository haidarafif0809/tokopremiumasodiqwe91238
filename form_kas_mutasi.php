<?php include 'session_login.php';

 include 'db.php';
 include 'header.php';
 include 'navbar.php';
 

 
 
 $query = $db->query("SELECT * FROM kas_mutasi");
 
 

 //ambil 2 angka terakhir dari tahun sekarang 
$tahun = $db->query("SELECT YEAR(NOW()) as tahun");
$v_tahun = mysqli_fetch_array($tahun);
 $tahun_terakhir = substr($v_tahun['tahun'], 2);
//ambil bulan sekarang
$bulan = $db->query("SELECT MONTH(NOW()) as bulan");
$v_bulan = mysqli_fetch_array($bulan);
$v_bulan['bulan'];


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($v_bulan['bulan']);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$v_bulan['bulan'];
 }
 else
 {
  $data_bulan_terakhir = $v_bulan['bulan'];

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM kas_mutasi ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM kas_mutasi ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/KMT/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/KMT/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

 ?>

  
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  		<script>
  $(function() {
    $( "#tanggal1" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>





<form action="proses_kas_mutasi.php" method="post">
<div class="container">

<h3> Tambah Kas Mutasi </h3>
<br><br>

<div class="form-group">
					<div class="form-group">
					<label> Tanggal </label><br>
					<input type="text" name="tanggal" id="tanggal1" placeholder="Tanggal" class="form-control" required="" >
					</div>

					<div class="form-group">
					<label> Nomor Faktur </label><br>
					<input type="text" name="no_faktur" placeholder="Nomor Faktur" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >

					</div>

					<div class="form-group">
					<label> Keterangan </label><br>
					<input type="text" name="keterangan" placeholder="Keterangan" id="keterangan" class="form-control">
					</div>

					<div class="form-group">
					<label> Dari Kas </label><br>
					<select type="text" name="dari_akun" id="dari_akun1" class="form-control" required="" >
					<option value="">Silahkan Pilih</option>



					 <?php 

    
    $query = $db->query("SELECT * FROM daftar_akun ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option>".$data['nama'] ."</option>";
    }
    
    
    ?>
   					</select>
					</div>

					<!-- diganti ke hidden -->
					<input type="hidden" name="jumlah_kas" id="jumlah_kas1">

					<div class="form-group">
					<label> Ke Kas </label><br>
					<select type="text" name="ke_akun" id="ke_akun1" class="form-control" required="" >
					<option value="">Silahkan Pilih</option>

					 <?php 

    
    $query = $db->query("SELECT * FROM kas ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option>".$data['nama'] ."</option>";
    }
    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);     
    ?>
   					</select>
   					</div>

					<div class="form-group">
					<label> Jumlah </label><br>
					<input type="text" name="jumlah" id="jumlah2" placeholder="Jumlah" class="form-control" required="" >
					</div>

					
					<input type="hidden" name="id" value="<?php echo $id; ?>" >
					<button type="submit" id="submit" class="btn btn-info">Submit</button>

</div>
</form>

<script>

//untuk mengambil data jumlah dari tabel kas bertdasarkan id dari akun1
$(document).ready(function(){
    $("#dari_akun1").change(function(){
      var dari_akun = $("#dari_akun1").val();

      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas.php', {dari_akun: dari_akun}, function(data) {
      	/*optional stuff to do after success */

      $("#jumlah_kas1").val(data);
      });
        
    });
});
</script>

<script>

// untuk memunculkan jumlah kas secara otomatis
  $(document).ready(function(){
    $("#jumlah2").keyup(function(){
      var jumlah = $("#jumlah2").val();
      var jumlah_kas = $("#jumlah_kas1").val();
      var sisa = jumlah_kas - jumlah;

      if (sisa < 0) 

      {
          $("#submit").hide();
      	alert("Jumlah Kas Tidak Mencukupi");

      }
      else {
        $("#submit").show();
      }


    });

  });
</script>

<script>
$(document).ready(function(){
    $("#ke_akun1").change(function(){
      var dari_akun = $("#dari_akun1").val();
      var ke_akun = $("#ke_akun1").val();

if (ke_akun == dari_akun)
{

alert("Nama Akun Tidak Boleh Sama");
      
}
        
    });
});
</script>

                             <script type="text/javascript">
                             $(document).ready(function(){
                             $("#jumlah2").keyup(function(){
                             var jumlah2 = $("#jumlah2").val();
                             
                             $.post('sanitasi_angka.php', {angka:jumlah2}, function(data) {
                             $('#jumlah2').val(data);
                             
                             
                             });
                             });
                             });
                             
                             </script>

                             <script type="text/javascript">
                             $(document).ready(function(){
                             $("#keterangan").keyup(function(){
                             var keterangan = $("#keterangan").val();
                             
                             $.post('sanitasi_string.php', {string:keterangan}, function(data) {
                             $('#keterangan').val(data);
                             
                             
                             });
                             });
                             });
                             
                             </script>


<?php 

include 'footer.php';
 ?>
