<?php include 'session_login.php';


// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';
include 'bootstrap.php';


$session_id = session_id();

$kategori = $_GET['kategori'];


if ($kategori == 'semua') {
    
    $query = $db->query("SELECT * FROM barang ");
}

else{
    $query = $db->query("SELECT * FROM barang WHERE kategori = '$kategori'");
}


          $pilih_kategori = $db->query("SELECT * FROM kategori");
          
         $cek = mysqli_fetch_array($pilih_kategori);



 ?>



<style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
}
</style>

<script>
  $(function() {
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>

<div class="form-group col-sm-12 col-xs-12">
<h3> Tambah Data Penjualan </h3><br>
</div>

<div id="modal_komen" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Permintaan</h4>
      </div>

      <div class="modal-body">
   

   <form>
    <div class="form-group">
    <label> Tambah Permintaan </label>
     <textarea name="komentar" id="kolom_komen" class="form-control" ></textarea>
      <input name="id" id="id_komen" class="form-control" type="hidden">
    </div>
   
   </form>
    
<button type="submit" id="submit_komen" class="btn btn-primary">Add</button>
     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div>




  <!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit - Hapus  Penjualan Barang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">

    <label> Nama Pesanan :</label>
     <input type="text" id="data_nama_barang" class="form-control" readonly=""> 

    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>

     <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">

     <input type="hidden" class="form-control" id="harga_edit" readonly="">
     <input type="hidden" class="form-control" id="kode_edit">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   <button type="submit" id="submit_edit" class="btn btn-info btn-sm"  style="margin-right: 59%">Edit</button> 
    <button type="button" class="btn btn-danger btn-sm" id="btn_jadi_hapus">Hapus</button> 
  
  </form>
  <span id="alert"> </span>
  <div class="alert-edit alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->


<span id="menu_pesanan">
	<div class="row">
 		<div class="col-sm-7 col-xs-7">
 		<h4> Cari Produk :</h4>
      <div class="input-group">
      <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-search"></span></span>
      <input type="text" id="cari_pesanan" class="form-control" style="width:30%;" aria-describedby="basic-addon1" autofocus="">
      </div><br>

      <?php  

echo "<ul class='nav nav-tabs'>
        <li><button id='kategori_semua'  class='btn btn-kategori btn-primary' data-kategori='semua'> Semua Kategori</button></li>";

          include 'db.php';
          $pilih_kategori = $db->query("SELECT * FROM kategori");
          
          while ($cek = mysqli_fetch_array($pilih_kategori)) 
          {
          
          echo "<li><button class='btn btn-kategori btn-primary' data-kategori='". $cek['nama_kategori'] ."'> ". $cek['nama_kategori'] ." </button></li>";

         }


echo "</ul>";

?>
<br>
<br>
<div style="height:50%;width:100%;border:1px solid #ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">
 		<span id="jumlah_pos">
<?php 

while ($data=mysqli_fetch_array($query)) 
	{

// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$data[kode_barang]'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$data[kode_barang]'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$data[kode_barang]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$data[kode_barang]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$data[kode_barang]'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$data[kode_barang]'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$data[kode_barang]'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$data[kode_barang]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];


 



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;



            $stok_barang = $total_1 - $total_2;



      echo '<div class="img" data-kode="'. $data['kode_barang'] .'" nama-barang="'. $data['nama_barang'] .'" harga="'. $data['harga_jual'] .'" foto="'. $data['foto'] .'" satuan="'. $data['satuan'] .'" ber_stok="'. $data['berkaitan_dgn_stok'] .'">
    
      <span style="cursor:pointer">';

if ($data['foto'] == "") {
 
 echo '<img src="save_picture/box.jpg " height="100px" width="100px" data-toggle="tooltip" data-placement="top" title="'. $data['nama_barang'] .'" class="test">';

}

else{

  echo '<img src="save_picture/'. $data['foto'] .'" height="100px" width="100px" data-toggle="tooltip" data-placement="top"  title="'. $data['nama_barang'] .'" class="test">';

}
      

    echo '</span>
      
      
      
      </div>';

}



 ?>

 </span>

 </div>
 	</div><!--end col-sm-9-->

		<div class="col-sm-5 col-xs-5" id="sm_3">	

			<form class="form-inline" action="lis_pos.php" role="form" id="formtambahproduk">


          <div class="form-group">
          <label> Kode Pelanggan </label><br>
          <select name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="" autofocus="">
 
          
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query = $db->query("SELECT * FROM pelanggan");

    //untuk menyimpan data sementara yang ada pada $query
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data['kode_pelanggan'] ."' class='opt-pelanggan-".$data['kode_pelanggan']."' data-level='".$data['level_harga'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
    }
    
    
    ?>
    </select>
    </div>

        <div class="form-group">
          <label> Gudang </label><br>
          
          <select name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM gudang");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
          }
          
          
          ?>
          </select>
</div>

<div class="form-group">
<label>Sales</label><br>
<select name="sales" id="sales" class="form-control chosen" required="">

  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama FROM user WHERE status_sales = 'Iya'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
    echo "<option value='".$data01['nama'] ."'>".$data01['nama'] ."</option>";
    }
    
    
    ?>

</select>
</div>

				

        <div class="form-group"><br>
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="" >
        </div>

	        <div class="form-group">
          <label>PPN</label><br>
          <select name="ppn" id="ppn" class="form-control">
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
        </div>

        
				<div class="form-group">
				<label> Total </label><br>
				<input type="text" name="total" id="total" class="form-control" placeholder="Total" readonly="" >

				</div>





        <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >


        </div>


				
				<br><br><label> Item : </label>	

				
		</form>	

				

				
		<div class="table-responsive">
			<span id="result">		
				<table id="tableuser" class="table table-bordered" style="width:100%">
        

        <thead>


          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Subtotal </th>

        </thead>
        <tbody>
        <?php
        
        // menampilkan seluruh data yang ada pada tabel barang
        $perintah = "SELECT * FROM tbs_penjualan WHERE session_id = '$session_id'";
        $perintah1 = $db->query($perintah);
        
        // menyimpoan data sementara yang ada pada $perintah1
        while ($data1 = mysqli_fetch_array($perintah1))
        {
        // menampilkan data
            echo "<tr class='hapus_edit tr-id-". $data1['id'] ."' data-jumlah-barang='". $data1['jumlah_barang'] ."' data-harga='". $data1['harga'] ."' data-id='". $data1['id'] ."' data-pesanan='". $data1['nama_barang'] ."' data-kode='". $data1['kode_barang'] ."'>
            <td>". $data1['nama_barang'] ."</td>
            <td>". $data1['jumlah_barang'] ."</td>
            <td>". $data1['subtotal'] ."</td> 
        </tr>";
        
        }
        
        ?>

        </tbody>
        </table>
				</span>

        <span id="alert_limit"></span>
		</div>

    
				<br>
				<button id="submit_produk" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-send"></span>Bayar</button>
			

				
		</div><!--col-sm 3-->
		</div><!-- row-->
	</span>


	<span style="display:none" id="menu_bayar">
	<form action="proses_bayar_pos.php" id="form_jual" method="POST" >
			
			<style type="text/css">
			.disabled {
			opacity: 0.6;
			cursor: not-allowed;
			disabled: false;
			}
			</style>
<div class="form-group col-sm-12 col-xs-12">
<label> <br> </label><br>
<button id="kembali" class="btn btn-success">Kembali</button>
</div>



		  <div class="form-group col-sm-6 col-xs-6">
      <label> Subtotal </label><br>
      <input type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" >
		  <label> Cara Bayar </label><br>
          <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  style="font-size: 16px" >
          <option value=""> Silahkan Pilih </option>
             <?php 
             
             
             $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
             $data_sett = mysqli_fetch_array($sett_akun);
             
             
             
             echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";
             
             $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
             while($data = mysqli_fetch_array($query))
             {
             
             
             
             
             echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
             
             
             
             
             }
             
             
             ?>
          
          </select>
<?php
          $total_tbs = $db->query("SELECT SUM(subtotal) as s_total FROM tbs_penjualan WHERE session_id = '$session_id'");
          $ambil_total = mysqli_fetch_array($total_tbs);
          $total_bener = $ambil_total['s_total'];




          $ambil_diskon_tax = $db->query("SELECT * FROM setting_diskon_tax");
          $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

        if ($data_diskon['diskon_nominal'] != 0 AND $data_diskon['diskon_persen'] == 0) {

             $diskon = $data_diskon['diskon_nominal'];

           
             if ($total_bener == 0) {
              $diskon_p = 0;
              }
              else{
                  $diskon_p = $diskon * 100 / $total_bener;

              }
  

            ?>
          
          <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

          <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon_p); ?>" class="form-control" placeholder="" autocomplete="off" >
          

          <?php  }
          else{
            $diskon = $data_diskon['diskon_persen'];

           $diskon_n = $total_bener /  100 * $diskon;



?>


          <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon_n); ?>" class="form-control" placeholder="" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >

          <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off" >
         
<?php
          }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
           ?>

           <label> Pajak </label><br>
          <input type="text" name="tax" id="tax" value="<?php echo $data_diskon['tax']; ?>" class="form-control"  autocomplete="off" >

          <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" >

           <label style="display: none"> Adm Bank  (%)</label>
          <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
          
          <label> Tanggal Jatuh Tempo </label><br>
          <input type="text" name="tanggal_jt" id="tanggal_jt"  value="" class="form-control" >


          </div>
           </div>

          <div class="form-group col-sm-4 col-xs-4">
          <label style="font-size:15px"> Total </label><br>
          <b><input type="text" name="total" id="total1" class="form-control" style="height: 50px; width:90%; font-size:25px;" placeholder="Total" readonly="" ></b>

          <label> Pembayaran </label><br>
          <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 50px; width:90%; font-size:25px;" autocomplete="off" class="form-control"   style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>


          <label> Kembalian </label><br>
          <b><input type="text" name="sisa_pembayaran" id="sisa_pembayaran_penjualan" style="height: 50px; width:90%; font-size:25px;" class="form-control"  readonly="" required=""  style="font-size: 20px" ></b>
          


         
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly="" required="" ></b>

<?php 

if ($_SESSION['otoritas'] == 'Pimpinan') {
 echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px;" class="form-control" placeholder="" readonly="" required="">';
}



 ?>



</div>

          
          
          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">   <br> 
          
          
          <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  

          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >
          
          
      
          <div class="form-group col-sm-12 col-xs-12">
          <button type="submit" id="penjualan" class="btn btn-info">Bayar </a> </button>

          <a href="pos.php?kategori=semua" id="transaksi_baru" class="btn btn-info" style="display: none"> Transaksi Baru</a>

          <button type="submit" id="piutang" class="btn btn-warning">Piutang</button>

          <button type="submit" id="batal" class="btn btn-danger">Batal</button>

          <a href='cetak_penjualan_tunai_pos.php' id="cetak_tunai" style="display: none;" class="btn btn-success" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Tunai </a>

          <a href='cetak_penjualan_tunai_besar_pos.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-primary" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Tunai Besar </a>

          <a href='cetak_penjualan_piutang_pos.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Piutang </a>

          <br>
          <br>
          <label> User :  <?php echo $_SESSION['user_name']; ?> </label><br>
          </div>

     
	
	</form>
	</span>

	<span id="cek_id"> </span>

          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>
                                                                                                                                                          
<script type="text/javascript">
 $(document).on('click', '.img', function (e) {

  document.getElementById("ber_stok").value = $(this).attr('ber_stok');

  });
</script>          
 


				<script type="text/javascript">
				
				// jika dipilih, nim akan masuk ke input dan modal di tutup
				$(document).on('click', '.img', function (e) {



				var kode_barang = $(this).attr('data-kode');
				var harga = $(this).attr('harga');
				var nama_barang = $(this).attr('nama-barang');
				var satuan = $(this).attr('satuan');
        var ber_stok = $("#ber_stok").val();
				var session_id = $("#session_id").val();
        var sales = $("#sales").val();
				
        if (ber_stok == 'Jasa') {

        $.post('lis_pos.php',{sales:sales,kode_barang:kode_barang,satuan:satuan,harga:harga,nama_barang:nama_barang,ber_stok:ber_stok,session_id:session_id},function(data) {
        
        
        $("#result").load('tabel-pesanan.php');
        $("#alert_limit").html(data);

        setTimeout(tutupalert, 2000);



        
        });

        }

        else
        {

        $.post('lis_pos.php',{sales:sales,kode_barang:kode_barang,satuan:satuan,harga:harga,nama_barang:nama_barang,ber_stok:ber_stok,session_id:session_id},function(data) {
        
        
        $("#result").load('tabel-pesanan.php');
        $("#alert_limit").html(data);

        setTimeout(tutupalert, 2000);



        
        });

        }

				


				});
				
				
				$("form").submit(function(){
				return false;
				});

                              function tutupalert() {
                              $("#alert_limit").html("")
                              }
				
				// tabel lookup table_barang
				$(function () {
				$("#table_barang").dataTable();
				});
				
				$(document).ready(function() {
					
				
				$(".img").mouseleave(function(){
				
				var kode_pelanggan = $("#kd_pelanggan").val();
				var persen = $("#potongan_persen").val();
        var rupiah = $("#potongan_penjualan").val();
				
				if (kode_pelanggan != ""){
				$("#kd_pelanggan").attr("disabled", true);
				}
				
				var session_id = $("#session_id").val();

				$.post("cek_total_hpp.php",
				{
				session_id: session_id
				},
				function(data){
				$("#total_hpp"). val(data);
				});



        var session_id = $("#session_id").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2"). val(data);
        $("#total"). val(data);
        });




				
				});
				
				});
				
				
				</script>
		



	<script type="text/javascript">
	$(document).ready(function() {

        var session_id = $("#session_id").val();
        
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2").val(data);

        $("#total").val(data);
        });
								
				
				
       $("#submit_produk").click(function(){

        var session_id = $("#session_id").val();
        var potongan_rp = $("#potongan_penjualan").val();
        var tax = $("#tax").val();
        var adm_bank = $("#adm_bank").val();
        var potongan_penjualan = $("#potongan_penjualan").val();
        var potongan_persen = $("#potongan_persen").val();
				
        $.post("cek_total_seluruh.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total2"). val(data);
        var t_akhir = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(data ))));


        if (potongan_penjualan == "" || potongan_penjualan == 0){

          var nominal = t_akhir / 100 * potongan_persen; 
          $("#potongan_penjualan").val(tandaPemisahTitik(nominal));

          var t_tax = t_akhir * tax / 100;
          var total = t_akhir - nominal + t_tax;

          $("#total1").val(tandaPemisahTitik(total));



        }

        else if(potongan_persen == "" || potongan_persen == 0)
        {


          var persen = potongan_penjualan * 100 / t_akhir; 
          $("#potongan_persen").val(parseInt(persen));


        }

        else{
        var t_tax = t_akhir * tax / 100;

          var persen =  $("#potongan_persen").val();

          var nominal =  t_akhir / 100 * persen; 
      
                 var total = t_akhir - nominal + t_tax;
  $("#potongan_penjualan").val(tandaPemisahTitik(nominal));
          $("#total1").val(tandaPemisahTitik(total));

        }
        
        });


          $("#menu_bayar").show('fast');
          $("#menu_pesanan").hide('fast');  
          $("#alert_limit").hide('fast');  
	});


        
        
        $.post("cek_total_hpp.php",
        {
        session_id: session_id
        },
        function(data){
        $("#total_hpp"). val(data);
        });
        
        });

				
	</script>
				
				<script type="text/javascript">
				
				$("#kembali").click(function(){
				
				$("#menu_bayar").hide('fast');
				$("#menu_pesanan").show('fast');
				$("#alert_berhasil").hide();

				$("#cetak_tunai").hide('');
        $("#cetak_tunai_besar").hide('');
				$("#cetak_piutang").hide('');
				
				});
				
				</script>
				
				<script>
				
				$("#penjualan").click(function(){
				
				var session_id = $("#session_id").val();
				var no_faktur = $("#nomor_faktur_penjualan").val();
				var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
				var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
				var kode_pelanggan = $("#kd_pelanggan").val();
				var tanggal_jt = $("#tanggal_jt").val();
				var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
				var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
				var potongan_persen = $("#potongan_persen").val();
				var tax = $("#tax_rp").val();
				var cara_bayar = $("#carabayar1").val();
				var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#sales").val();


				var sisa = pembayaran - total;
				
				var sisa_kredit = total - pembayaran;
				
        $("#total1").val('');
        $("#pembayaran_penjualan").val('');
        $("#sisa_pembayaran_penjualan").val('');
				
				if (sisa_pembayaran < 0)
				{
				
				alert("Jumlah Pembayaran Tidak Mencukupi");
				
				}

				else if (kode_pelanggan == "") 
				{
				
				alert("Kode Pelanggan Harus Di Isi");
				
				}
				else if (pembayaran == "") 
				{
				
				alert("Pembayaran Harus Di Isi");
				
				}
				else if (potongan_persen > 100) 
				{
				
				alert("Potongan Melebihi 100%");
				
				}
                           

        else if (sisa < 0) 
        {
        
        alert("Pembayaran Tidak Mencukupi");
        
        }
        
                else if (total ==  0 || total == "") 
        {
        
        alert("Anda Belum Melakukan Pemesanan");
        
        }
				
				else
				
				{
          $("#penjualan").hide();
          $("#batal").hide();
          $("#kembali").hide();
          $("#piutang").hide();
          $("#transaksi_baru").show();
          $("#cetak_tunai").show();
          $("#cetak_tunai_besar").show();
          
				$.post("proses_bayar_pos.php",{sales:sales,kode_gudang:kode_gudang,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp},function(info) {
				var no_faktur = info;
        $("#result").html(info);
				$("#alert_berhasil").show();
        $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai_pos.php?no_faktur='+no_faktur+'');
        $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar_pos.php?no_faktur='+no_faktur+'');
				$("#total1").val('');
				$("#pembayaran_penjualan").val('');
				$("#sisa_pembayaran_penjualan").val('');
				$("#kredit").val('');
				$("#potongan_penjualan").val('');
				$("#potongan_persen").val('');
				$("#kd_pelanggan").val('');
                            
				
				
				});
				
				// #result didapat dari tag span id=result
				
				
				}
				
				$("form").submit(function(){
				return false;
				});
				
				});
				
				$("#penjualan").mouseleave(function(){
				
				$.get('no_faktur_jl.php', function(data) {
				/*optional stuff to do after getScript */ 
				
				$("#nomor_faktur_penjualan").val(data);
				});
				var kode_pelanggan = $("#kd_pelanggan").val();
				if (kode_pelanggan == ""){
				$("#kd_pelanggan").attr("disabled", false);
				}
				
				});
				
				</script>
				
				
				<script>
				//perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
				$("#piutang").click(function(){
        var session_id = $("#session_id").val();
        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var tax = $("#tax_rp").val();
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
				
				var sisa =  pembayaran - total; 
				
				var sisa_kredit = total - pembayaran;
				
				        $("#total_penjualan").val('');
        $("#pembayaran_penjualan").val('');
        $("#sisa_pembayaran_penjualan").val('');
        $("#kredit").val('');

        
				if (sisa_pembayaran == "" )
				{
				
				alert ("Jumlah Pembayaran Tidak Mencukupi");
				}
				
				else if (kode_pelanggan == "") 
				{
				
				alert("Kode Pelanggan Harus Di Isi");
				
				}

				else if (tanggal_jt == "")
				{
				
				alert ("Tanggal Jatuh Tempo Harus Di Isi");
				
				}

                           
				
				else
				{

          $("#piutang").hide();
          $("#batal").hide();
          $("#penjualan").hide();
          $("#kembali").hide();
          $("#transaksi_baru").show();
          $("#cetak_tunai").show();
          $("#cetak_tunai_besar").show();
				
				$.post("proses_bayar_pos.php",{kode_gudang:kode_gudang,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp},function(info) {
				var no_faktur = info;       
        $("#alert_berhasil").show();
        $("#cetak_piutang").attr('href', 'cetak_penjualan_piutang_pos.php?no_faktur='+no_faktur+'');
				$("#total_penjualan").val('');
				$("#pembayaran_penjualan").val('');
				$("#sisa_pembayaran_penjualan").val('');
				$("#kredit").val('');
				$("#potongan_penjualan").val('');
				$("#potongan_persen").val('');
				$("#tanggal_jt").val('');
				$("#cetak_piutang").show();
				
				
				
				});
				// #result didapat dari tag span id=result
				$("#result").load("tabel-pesanan.php");
				
				}  
				//mengambil no_faktur pembelian agar berurutan
				
				});
				$("form").submit(function(){
				return false;
				});
				
				
				</script>   


					<script>
					
					$(document).ready(function(){	
					
					//button batal agar tidak ada loading
					$("#batal").click(function(){
					var session_id = $("#session_id").val();
					
					$.post("batal_pos.php",{session_id:session_id},function(info) {
					
					$("#result").html(info);
					$("#menu_bayar").hide('fast');
					$("#menu_pesanan").show('fast');	
					
					
					});
					});
					});
					
					</script>
				
				
				<script>
				
				//untuk menampilkan sisa penjualan secara otomatis
				$(document).ready(function(){
				$("#pembayaran_penjualan").keyup(function(){
				var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
				var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
				var sisa = pembayaran - total;
				var sisa_kredit = total - pembayaran; 
				
				if (sisa < 0 )
				{
				$("#kredit").val( tandaPemisahTitik(sisa_kredit));
				$("#sisa_pembayaran_penjualan").val('0');
				$("#tanggal_jt").attr("disabled", false);
				
				}
				
				else  
				{
				
				
				
				$("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
				$("#kredit").val('0');
				$("#tanggal_jt").attr("disabled", true);
				
				} 
				
				
				});
				
				
				});
				</script>
				
				<script>
				$(document).ready(function(){
				//id kode pelanggan dari kode_pelanggan
				$("#kd_pelanggan").change(function(){
				var kode_pelanggan = $("#kd_pelanggan").val();
				
				//id yang di hidden
				$("#k_pelanggan").val(kode_pelanggan);
				
				});
				});
				</script>

				<script>
				
				// BELUM KELAR !!!!!!
				$(document).ready(function(){
				$("#carabayar1").change(function(){
				var cara_bayar = $("#carabayar1").val();
				
				//metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
				$.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
				/*optional stuff to do after success */
				
				$("#jumlah1").val(data);
				});
				
				});
				});
				</script>
				



<script type="text/javascript">
        $(document).ready(function(){
        
        $("#adm_bank").blur(function(){
        
        var potongan = $("#potongan_penjualan").val();
        var potongan_persen = $("#potongan_persen").val();
        var total = $("#total2").val();
        var tax = $("#tax").val();
        var adm_bank = $("#adm_bank").val();
        
        if (adm_bank > 100 ) {
          alert ("Adm Bank Tidak Boleh Lebih Dari 100%");

          $("#adm_bank").val('');
          $("#carabayar1").val('');
        }
        else{
          $.post("cek_adm_bank.php", {potongan:potongan,potongan_persen:potongan_persen,total:total,tax:tax,adm_bank:adm_bank}, function(data) {
        
        $("#total1").val(parseInt(data));

        
        
        });
        }
        

        });
        });
        
</script>
				
				<script type="text/javascript">
				
				$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
				
				</script>


                             
          <script type="text/javascript">
                             
          $(document).ready(function(){

          
          //fungsi edit data 
          $(".hapus_edit").click(function(){
          
          $("#modal_edit").modal('show');
          var jumlah_barang = $(this).attr("data-jumlah-barang");
          var harga = $(this).attr("data-harga");
          var id  = $(this).attr("data-id");
          var kode_barang = $(this).attr("data-kode");
                                     var nama_barang = $(this).attr("data-pesanan");
          $("#harga_edit").val(harga);
          $("#barang_lama").val(jumlah_barang);
          $("#id_edit").val(id);
          $("#kode_edit").val(kode_barang);
                                    $("#data_nama_barang").val(nama_barang);
                                    
                $("#alert_limit").hide('fast');
          
          
          });
          
          $("#submit_edit").click(function(){
          var jumlah_barang = $("#barang_lama").val();
          var jumlah_baru = $("#barang_edit").val();
          var harga = $("#harga_edit").val();
          var id = $("#id_edit").val();
          var kode_barang = $("#kode_edit").val();
          var no_faktur = $("#nofaktur").val();
          
          $.post("update_tbs_pos.php",{id:id,jumlah_barang:jumlah_barang,jumlah_baru:jumlah_baru,harga:harga,kode_barang:kode_barang,no_faktur:no_faktur},function(data){
          
          $("#alert").html(data);
          $("#result").load('tabel-pesanan.php');

          $("#alert_limit").hide('fast');
          
          setTimeout(tutupmodal, 2000);
          setTimeout(tutupalert, 2000);
          
                  
          });
                  
          });


                $("#btn_jadi_hapus").click(function(){
                
                var id = $("#id_edit").val();
                var kode_barang = $("#kode_edit").val();
                $.post("hapus_pos_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
                if (data != "") {
                $(".tr-id-"+id+"").remove();
                $("#modal_edit").modal('hide');

                $("#alert_limit").hide('fast');
                }
                
                
                });
                
                });
                  
                  $('form').submit(function(){
                  
                  return false;
                  });
                  });
                  
                  
                  function tutupalert() {
                  $("#alert").html("")
                  }
                  
                  function tutupmodal() {
                  $("#modal_edit").modal("hide")
                  }
                  
                  
                  </script>



																		
																		<script type="text/javascript">
																		$(document).ready(function(){
																		$("#cari_pesanan").keyup(function(){
																		var nama_barang = $(this).val();
																		
																		$.post("cari_pesanan.php",{nama_barang:nama_barang},function(info){
																		
																		$("#jumlah_pos").html(info);
																		
																		});
																		
																		
																		});
																		});
																		
																		</script>

																		 <script type="text/javascript">
                               
                                               $(".btn-komen").click(function(){
                                               var komentar = $(this).attr("data-komen");
                                               var id = $(this).attr("data-id");

                                               $("#kolom_komen").val(komentar);
                                               $("#id_komen").val(id);
                                               $("#modal_komen").modal('show');
                                               
                                               
                                               });
                                                         
                                                         $("#submit_komen").click(function(){
                                                         var komentar = $("#kolom_komen").val();
                                                         var id = $("#id_komen").val();                                                         
                                                         $.post("proses_permintaan.php",{id:id,komentar:komentar},function(data){
                                                         
                                                         
                                                         $("#result").load('tabel-pesanan.php');
                                                         $("#modal_komen").modal('hide');
                                                         
                                                         });
                                                         
                                                         
                                                         });

                             </script>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<script type="text/javascript">

$(".btn-kategori").click(function(){

  var kategori = $(this).attr('data-kategori');

    $.get('tabel-data-kategori.php?kategori='+kategori+'', function(info) {
    $("#jumlah_pos").html(info);

  });


});


</script>

 <script type="text/javascript">
  $(document).ready(function(){
$("#cari_produk_penjualan").click(function(){
  var session_id = $("#session_id").val();

  $.post("cek_tbs_penjualan.php",{session_id: "<?php echo $session_id; ?>"},function(data){
        if (data != "1") {


             $("#ppn").attr("disabled", false);

        }
    });

});
});
</script>

<script type="text/javascript">
        $(document).ready(function(){
        
        $("#pembayaran_penjualan").focus(function(){

        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
        var potongan_penjualan = ((total * potongan_persen) / 100);
        var sisa_potongan = total - potongan_penjualan;
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
        $("#potongan_penjualan").val(tandaPemisahTitik(parseInt(potongan_penjualan)));

        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
        var sisa_potongan = total - potongan_penjualan;
        

        
        $("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
        $("#potongan_persen").val(parseInt(potongan_persen));
        
        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
       
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_penjualan").val('');
                 $("#potongan_persen").val('');
              }
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_tax,10)))));
              
              
              $("#total1").val(parseInt(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }
        

        $("#tax_rp").val(parseInt(t_tax));


        });
        });
        
        </script>
				
				<!-- memasukan file footer.php -->
				<?php
				
				include 'footer.php'; 
				
				?>