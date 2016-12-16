<?php include 'session_login.php';


// memasukan file session login, db,header dan navbar.php
 include 'db.php';
 include 'header.php';
 include 'navbar.php';

// mengirim data $id menggunakan metode GET
 $id = $_GET['id'];
 
 // menampilkan seluruh data dari tabel user berdasarkan id
 $query = $db->query("SELECT pa.id_promo_alert,b.id,b.kode_barang,b.nama_barang,pa.pesan_alert,pa.status FROM promo_alert pa INNER JOIN barang b ON pa.id_produk = b.id WHERE id_promo_alert = '$id'");
 
 // menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);
 ?>



<!-- membuat form prosesedit -->

<!-- agar tampilan form terlihat rapih dalam satu tempat -->
<div class="container">



<h3><b>EDIT PROMO ALERT</b></h3> <hr>
			<form role="form" method="POST" action="update_pormo_alert.php">
		<div class="form-group">
					
					<label> Nama Produk </label><br>
					<input name="kode_barang" id="kode_barang" class="form-control ss"  value="<?php echo $data['kode_barang'];?>(<?php echo $data['nama_barang'];?>)" placeholder="Ketik Nama Produk (Promo)" autocomplete="off" required="" >
<br>					

					<input type="hidden" name="id_produk" id="id_produk" value="<?php echo $data['id'];?>">
					<input type="hidden" name="id_promo_alert" id="id_promo_alert" value="<?php echo $id;?>">


					<label> Pesan Alert </label><br>
					<textarea name="pesan_alert" id="pesan_alert" style="height:250px" class="form-control"  placeholder="Pesan Alert Promo" required=""><?php echo $data['pesan_alert'];?></textarea>  <br>

					<label> Status </label><br>
					<select name="status" id="status" class="form-control ss" autocomplete="off" required="" >
					<?php 
					if ($data['status'] == '1')
					{
						echo '<option value="1">Aktif</option>';
					}
					else
					{
						echo '<option value="2">Tidak Aktif</option>';
					}
					?>
					<option value="1">Aktif</option>
					<option value="2">Tidak Aktif</option>
					</select><br>					


					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>

		</div>
</form>


</div>

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          
          if (kode_barang != '')
          {

      $.getJSON('lihat_nama_barang.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#id_produk').val('');
       
      }

      else 
      {
        $('#id_produk').val(json.id);
        
      }
                                              
        });   
}

        });
        });     
</script>


<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kodebarang_promo_autocomplete.php'
    });
});
</script>

<script type="text/javascript">
$(function () {
 $("#pesan_alert").wysihtml5();

});
</script>


<?php
 include 'footer.php'; ?>

