<?php include 'session_login.php';


// memasukkan file
 include 'header.php';
 include 'navbar.php';
 include 'db.php';

// mengirim data id dengan metode GET
 $id = $_GET['id'];
 
 // perintah untuk menampilkan data yang ada pada tabel barang berdasarkan id
 $query = $db->query("SELECT * FROM halaman_promo WHERE id = '$id'");
 
 // perintah untuk menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>




<!-- membuat form dengan metode POST -->
<form enctype="multipart/form-data" action="proses_edit_halaman_promo.php" method="post">
<div class="container">

          <div class="form-group">
          <label> Nama Promo </label><br>
          <input type="text" name="nama_promo" class="form-control" value="<?php echo $data['nama_promo']; ?>" class="form-control" autocomplete="off" required="" placeholder="Nama Promo" >
          </div>

          <div class="form-group">
          <label> Keterangan Promo </label><br>
          <textarea name="keterangan_promo" id="keterangan_promo" style="height:250px" class="form-control"  placeholder="Pesan Alert Promo" required=""><?php echo $data['keterangan_promo']; ?></textarea>
          </div>

              

          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <!-- membuat tombol Edit -->
          <button type="submit" class="btn btn-info">Edit</button>

</div><!-- tag penutup div class=container -->

</form>


<script>
     CKEDITOR.replace( 'keterangan_promo' );
</script>

<?php
// memasukan file footer.php
include 'footer.php'; 
?>
