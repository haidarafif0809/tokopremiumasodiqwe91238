<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
?>

<div class="container">

<h3><b><u> GROUP AKUN</u></b></h3> <br>

<form action="proses_daftar_grup_akun.php" method="post">
					<div class="form-group">
					<label> Kode Group Akun </label><br>
					<input type="text" name="kode_akun" id="kode_akun" class="form-control" placeholder="Kode Group Akun" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Nama Group Akun </label>
					<br>
					<input type="text" id="nama_akun" name="nama_akun" class="form-control" placeholder="Nama Group Akun" autocomplete="off" required="">

					</div>


					<div class="form-group">
					<label> Sub Dari </label><br>
					<select type="text" name="sub_dari" id="sub_dari" class="form-control">
					<option value="-"> - </option>

<?php 
$select = $db->query("SELECT * FROM grup_akun ");
while ($ambil = mysqli_fetch_array($select))
{

echo"<option value='".$ambil['kode_grup_akun']."'>".$ambil['kode_grup_akun']." -- ".$ambil['nama_grup_akun']."</option>";
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>
					
					</select>
					</div>

					<div class="form-group">
					<label> Kategori Akun </label><br>
					<select type="text" name="kategori_akun" id="kategori_akun" class="form-control">

					<option value="">--Kategori Akun--</option>	

					<option value="Aktiva">Aktiva</option>	
					<option value="Kewajiban">Kewajiban</option>	
					<option value="Modal">Modal</option>	
					<option value="Pendapatan">Pendapatan</option>	
					<option value="HPP">HPP</option>	
					<option value="Biaya">Biaya</option>
					<option value="HPP">Pendapatan Lain</option>	
					<option value="Biaya">Biaya Lain</option>	

					</select>
					</div>

					<div class="form-group">
					<label> Tipe Akun </label><br>
					<select name="tipe_akun" id="tipe_akun" class="form-control chosen" required="" >


					<option value=""></option>	

					<option>Akun Header</option>
					<option>Kas & Bank</option>	
					<option>Piutang Dagang</option>	
					<option>Piutang Non Dagang</option>	
					<option>Persediaan</option>	
					<option>Investasi Portofolio</option>	
					<option>Pajak Dibayar Dimuka</option>	
					<option>Beban Bayar Dimuka</option>	
					<option>Aktiva Tetap</option>	
					<option>Akumulasi Penyusutan</option>	
					<option>Hutang Dagang</option>	
					<option>Pendapatan Diterima Dimuka</option>	
					<option>Beban YMH Dibayar</option>	
					<option>Hutang Pajak</option>	
					<option>Hutang Bank Jangka Pendek</option>	
					<option>Hutang Bukan Bank Jangka Pendek</option>	
					<option>Hutang Non Dagang</option>	
					<option>Ekuitas</option>
					<option>Pendapatan Penjualan</option>		
					<option>Pendapatan Diluar Usaha</option>	
					<option>Harga Pokok Penjualan</option>	
					<option>Beban Administrasi dan Umum</option>
					<option>Beban Penjualan</option>
					<option>Beban Pemansaran</option>
					<option>Beban Operasional</option>
					<option>Beban Diluar Usaha</option>
					<option>Bunga Pinjaman</option>
					<option>Hutang Bank Jangka Panjang</option>
					<option>Hutang Bukan Bank Jangka Panjang</option>
					<option>Deviden</option>
					<option>Beban Pajak Penghasilan</option>

					</select>
					</div>

   
   					<button type="submit" id="submit_tambah" class="btn btn-primary"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>

</form>
</div> <!-- end container-->





      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

<script type="text/javascript">

               $(document).ready(function(){
               $("#kode_akun").blur(function(){
               var kode_akun = $("#kode_akun").val();

              $.post('cek_kode_akun.php',{kode_akun:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Kode Akun Sudah Ada");
                    $("#kode_akun").val('');
                    $("#kode_akun").focus();
                }
                else {
                    
                }
              });
                
               });
               });

</script>

<?php 

// memasukan file footer.php
include 'footer.php'; 
?>