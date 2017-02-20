<?php include 'session_login.php';

// memasukan file session login,  header, navbar, db.php,

include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';
include 'bootstrap.php';


$session_id = session_id();

 
 $query = $db->query("SELECT * FROM barang WHERE kategori = 'Makanan' OR kategori = 'Minuman' OR kategori = 'Beef'");

$no_faktur = $_GET['no_faktur'];
$kode_meja = $_GET['kode_meja'];

 ?>



<style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
}
</style>



<div class="form-group col-sm-12 col-xs-12">
<h3> Pembayaran Pesanan </h3><br>
</div>

<!-- Modal komen-->
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
</div> <!--/modal komen-->



<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Pesanan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Pesanan :</label>
     <input type="text" id="data_pesanan" class="form-control" readonly=""> 

    <label> Nomor Pesanan :</label> 
     <input type="text" id="kode_pesanan_hapus" class="form-control" readonly="" > 
     <input type="hidden" id="id_hapus" class="form-control" > 
     <input type="hidden" id="kode_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

  <!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Penjualan Barang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
     <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">
     <input type="hidden" class="form-control" id="no_pesanan_edit" readonly="">
     <input type="hidden" class="form-control" id="harga_edit" readonly="">
     <input type="hidden" class="form-control" id="kode_edit">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
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
if ($stok_barang > 0) 
    {
  
      echo '<div class="img" data-kode="'. $data['kode_barang'] .'" nama-barang="'. $data['nama_barang'] .'" harga="'. $data['harga_jual'] .'" foto="'. $data['foto'] .'" satuan="'. $data['satuan'] .'">
      
      <span style="cursor:pointer">

      <img src="save_picture/'. $data['foto'] .'" height="150px" width="190px">
      
      </span>
      
      <div class="desc">'.$data['nama_barang'].'</div>
      </div>';
    }
      
  } 



 ?>
 </span>
  </div><!--end col-sm-9-->

<div class="hover">
    <div class="col-sm-5 col-xs-5" id="sm_3"> 

    
    <div class="table-responsive">
      <span id="result">    
        <table id="tableuser" class="table table-bordered" style="width:100%">
        

        <thead>


          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Subtotal </th>
          <th> Nomor Pesanan </th>
          <th> Permintaan </th>
      <th> Edit Permintaan </th>
 
          <th> Edit </th>
          <th> Hapus </th>

        </thead>
        <tbody>
        <?php
        
        // menampilkan seluruh data yang ada pada tabel barang
        $perintah = "SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ORDER BY id DESC";
        $perintah1 = $db->query($perintah);
        
        // menyimpoan data sementara yang ada pada $perintah1
        while ($data1 = mysqli_fetch_array($perintah1))
        {
        // menampilkan data
            echo "<tr>
            <td>". $data1['nama_barang'] ."</td>
            <td>". $data1['jumlah_barang'] ."</td>
            <td>". $data1['subtotal'] ."</td>
            <td>". $data1['no_pesanan'] ."</td>";

            
           if ($data1['komentar'] == '') {
             echo "<td> <button class='btn btn-primary btn-komen' data-id='".$data1['id']."' data-komen='".$data1['komentar']."'><span class='glyphicon glyphicon-pencil'> </span> Add Comment </button> </td>";
           }

             else {

             echo "<td>". $data1['komentar'] ."</td>";
           }

           if ($data1['komentar'] != '') {
              echo "<td> <button class='btn btn-primary btn-komen' data-id='".$data1['id']."' data-komen='".$data1['komentar']."'><span class='glyphicon glyphicon-edit'> </span> Edit Comment </button> </td>";

           }

           else{
            echo "<td> </td>";
           }


           echo "<td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-barang='". $data1['jumlah_barang'] ."' data-kode='". $data1['kode_barang'] ."' data-harga='". $data1['harga'] ."' kode-pesanan='". $data1['no_pesanan'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

            <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-pesanan='". $data1['nama_barang'] ."' kode-data='". $data1['kode_barang'] ."' kode-pesanan='". $data1['no_pesanan'] ."'> Hapus </button> </td> 
        </tr>";
        
        }
        
        ?>

        </tbody>
        </table>
        </span>
    </div>

    <form class="form-inline" action="proses_simpan_sementara.php" role="form" id="formtambahproduk">


          <div class="form-group">
          <label> Kode Pelanggan </label><br>
          <select type="text" data-placeholder="Umum" name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen"  required="" >
          <option value="Umum">Umum</option>
          
          <?php 
          
          //untuk menampilkan semua data pada tabel pelanggan dalam DB
          $query = $db->query("SELECT * FROM pelanggan");
          
          //untuk menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
          }
          
          
          ?>
          </select>
          </div>

        

        <div class="form-group">
        <label> Nomor Faktur </label><br>
        <input type="text" name="no_faktur" id="nomor_faktur_penjualan" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
        </div>


        <div class="form-group"><br>
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="" >
        </div>
        

        <div class="form-group">
        <label> Kode Meja </label><br>
        <input type="text" name="kode_meja" id="kode_meja" value="<?php echo $kode_meja; ?>" class="form-control" placeholder="Total" readonly="" >
        </div>

        <div class="form-group">
        <label> Total </label><br>
        <input type="text" name="total" id="total" class="form-control" placeholder="Total" readonly="" >
        </div>

        
    

        
        <br> <br>

  <?php 

if ( $_SESSION['otoritas'] == 'Pimpinan' OR $_SESSION['otoritas'] == 'Cashier') {
echo '<button id="submit_produk" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"> </span> Bayar  </button>';
}
   ?>
        
 <button id="submit_simpan" class="btn btn-info"><span class="glyphicon glyphicon-floppy-disk"> </span>  Simpan Pesanan </button>

                <a href='cetak_pesanan_makanan.php' id="cetak_makanan" style="display: none;" class="btn btn-primary" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Makanan </a>

        <a href='cetak_pesanan_minuman.php' id="cetak_minuman" style="display: none;" class="btn btn-primary" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Minuman </a>

        <a href='cetak_pesanan_beef.php' id="cetak_beef" style="display: none;" class="btn btn-primary" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Beef </a>

        <a href='cetak_pesanan.php' id="cetak_pelanggan" style="display: none;" class="btn btn-primary" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Pesanan </a>
                  <br>
                  <br>
          <br>
          <label> User :  <?php echo $_SESSION['user_name']; ?> </label><br>
</form> 
       <div class="alert alert-success" id="alert_berhasil_pesanan" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>  

           
    </div><!--col-sm 3-->
    </div>
    </div><!-- row-->
  </span>

          

	<span style="display:none" id="menu_bayar">

	<form action="proses_bayar_pesanan.php" id="form_jual" method="POST" >
   


  </form>
			
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
          <input type="text" name="total" id="total2" class="form-control" placeholder="" readonly="" >
          
      
          <label> Cara Bayar </label><br>
         
          <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  style="font-size: 16px" >

          <?php 
          
          
          $query = $db->query("SELECT * FROM kas ");
          while($data = mysqli_fetch_array($query))
          {
           if ($data['status'] == 'Ya') {
             

            echo "<option selected>".$data['nama'] ."</option>";

           }
            else{

              echo "<option>".$data['nama'] ."</option>";
            }     
          

            
          
          }
          
          
          ?>
          
          </select>

          <?php
          $total_tbs = $db->query("SELECT SUM(subtotal) as s_total FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
          $ambil_total = mysqli_fetch_array($total_tbs);
          $total_bener = $ambil_total['s_total'];




          $ambil_diskon_tax = $db->query("SELECT * FROM setting_diskon_tax");
          $data_diskon = mysqli_fetch_array($ambil_diskon_tax);


          if ($data_diskon['diskon_nominal'] != 0 AND $data_diskon['diskon_persen'] == 0) {

             $diskon = $data_diskon['diskon_nominal'];

             $diskon_p = $diskon * 100 / $total_bener;

            ?>
          
          <label> Potongan ( Rp )</label><br>
          <input type="text" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >

          <label> Potongan ( % )</label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon_p); ?>" class="form-control" placeholder="" autocomplete="off" >
          

          <?php  }
          else{
            $diskon = $data_diskon['diskon_persen'];

            $diskon_n = $total_bener /  100 * $diskon;



?>


          <label> Potongan ( Rp )</label><br>
          <input type="text" name="potongan" id="potongan_penjualan" value="<?php echo intval($diskon_n); ?>" class="form-control" placeholder="" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >

          <label> Potongan ( % )</label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" value="<?php echo intval($diskon); ?>" class="form-control" placeholder="" autocomplete="off" >
          
<?php
          }


           ?>

           <label> Tax </label><br>
          <input type="text" name="tax" id="tax" class="form-control" value="<?php echo $data_diskon['tax']; ?>" placeholder="" autocomplete="off">

          <input type="hidden" name="tax" id="tax_rp" class="form-control" value="" placeholder="" autocomplete="off">

          <label> Tanggal Jatuh Tempo </label><br>
          <input type="text" name="tanggal_jt" id="tanggal_jt"  value="" class="form-control" >

          </div>

          <div class="form-group col-sm-6 col-xs-6">
          
          <label style="font-size:15px"> Total </label><br>
          <b><input type="text" name="total" id="total1" class="form-control" style="height: 50px; width:90%; font-size:25px; " placeholder="Total" readonly="" ></b>

          <label> Pembayaran </label><br>
          <b><input type="text" name="pembayaran" id="pembayaran_penjualan" autocomplete="off" class="form-control" placeholder="" style="height: 50px; width:90%; font-size:25px; " onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" ></b>
          

          <label> Kembalian </label><br>
          <b><input type="text" name="sisa_pembayaran" id="sisa_pembayaran_penjualan" class="form-control" placeholder="" readonly="" required="" style="height: 50px; width:90%; font-size:25px; " ></b>

          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control" placeholder="" readonly="" required="" style="height: 50px; width:90%; font-size:25px; " ></b>
          

<?php 
if ($_SESSION['otoritas'] == 'Pimpinan') {
 echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px; "class="form-control" placeholder="" readonly="" required="">';
}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>
          
          
          </div>

          
          
          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">   <br> 
          
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->
          <input type="hidden" name="no_faktur" id="nofaktur" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >
          
          
      
          <div class="form-group col-sm-12 col-xs-12">
          <button type="submit" id="penjualan" class="btn btn-info">Bayar </button>

          <button type="submit" id="piutang" class="btn btn-warning">Piutang</button>


          <a href='cetak_penjualan_pesanan.php' id="cetak_tunai" style="display: none;" class="btn btn-success" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Pembayaran </a>

          <a href='cetak_penjualan_pesanan_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Piutang </a>

         

          <br>
          <br>

          <span id="demo"></span>

          <label> User :  <?php echo $_SESSION['user_name']; ?> </label><br>
          </div>

          <input type="hidden" name="tes" id="tes" class="form-control" placeholder="tes" >

     
	
	
	</span>

<div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>  
                                             
 


        <script type="text/javascript">
        
        // jika dipilih, nim akan masuk ke input dan modal di tutup
        $(document).on('click', '.img', function (e) {
                  
                  var no_faktur = $("#nofaktur").val();
                  
                  $.post("cek_total_pesanan_awal.php",
                  {
                  no_faktur: no_faktur
                  },
                  function(data){
                  $("#total2"). val(data);
                  });
        
        var kode_barang = $(this).attr('data-kode');
        var harga = $(this).attr('harga');
        var nama_barang = $(this).attr('nama-barang');
        var satuan = $(this).attr('satuan');
        var no_faktur = $("#nomor_faktur_penjualan").val();
        
        $.post('lis_bayar_pesanan.php',{kode_barang:kode_barang,satuan:satuan,harga:harga,nama_barang:nama_barang,no_faktur:no_faktur},function(data) {
        
        $("#result").html(data);
        $("#result").load('tabel_bayar_pesanan.php?no_faktur=<?php echo $no_faktur; ?>');
        
        });
        
        
        
        
        });
        
        
        $("form").submit(function(){
        return false;
        });


        
        // tabel lookup table_barang
        $(function () {
        $(".table").dataTable({"ordering":false});
        });
        
        $(document).ready(function() {
          
        
        $(".img").mouseleave(function(){
        
        var kode_pelanggan = $("#kd_pelanggan").val();
        
        
        if (kode_pelanggan != ""){
        $("#kd_pelanggan").attr("disabled", true);
        }
        
        var no_faktur = $("#nofaktur").val();
        var potongan_rp = $("#potongan_penjualan").val();
        var tax = $("#tax").val();
        
        $.post("cek_total_pesanan.php",
        {
        no_faktur: no_faktur, potongan:potongan_rp, tax:tax
        },
        function(data){
        $("#total"). val(data);
        $("#total1"). val(data);
        });
        
        $.post("cek_total_hpp_pesanan.php",
        {
        no_faktur: no_faktur
        },
        function(data){
        $("#total_hpp"). val(data);
        });

                  var no_faktur = $("#nofaktur").val();
                  
                  $.post("cek_total_pesanan_awal.php",
                  {
                  no_faktur: no_faktur
                  },
                  function(data){
                  $("#total2"). val(data);
                  });

        
        });
        
        });
        
        
        </script>

        <script type="text/javascript">
        $(document).ready(function() {
          
        
        $(".hover").hover(function(){
        
        var kode_pelanggan = $("#kd_pelanggan").val();
        
        
        if (kode_pelanggan != ""){
        $("#kd_pelanggan").attr("disabled", true);
        }
        
        var no_faktur = $("#nofaktur").val();
        var potongan_rp = $("#potongan_penjualan").val();
        var tax = $("#tax").val();
        
        $.post("cek_total_pesanan.php",
        {
        no_faktur: no_faktur, potongan:potongan_rp, tax:tax
        },
        function(data){
        $("#total"). val(data);
        $("#total1"). val(data);
        });
        
        $.post("cek_total_hpp_pesanan.php",
        {
        no_faktur: no_faktur
        },
        function(data){
        $("#total_hpp"). val(data);
        });
        
        });
        
        });
        
        
        </script>

        
        <script type="text/javascript">
				$(document).ready(function() {
								
				
				
				$("#submit_produk").click(function(){
				var no_faktur = $("#nofaktur").val();
        var potongan_rp = $("#potongan_penjualan").val();
        var tax = $("#tax").val();
				
				$.post("cek_total_pesanan.php", {no_faktur: no_faktur, potongan:potongan_rp, tax:tax}, function(data){
				$("#total1"). val(data);
				$("#total"). val(data);

				
				
				
				$("#menu_bayar").show('fast');
				$("#menu_pesanan").hide('fast');
				});


                  var no_faktur = $("#nofaktur").val();
                  
                  $.post("cek_total_pesanan_awal.php",
                  {
                  no_faktur: no_faktur
                  },
                  function(data){
                  $("#total2"). val(data);
                  });

				});

				});
				
				</script>


        
        <script type="text/javascript">
        
        $("#kembali").click(function(){
        
        $("#menu_bayar").hide('fast');
        $("#menu_pesanan").show('fast');
        $("#alert_berhasil").hide();

        $("#cetak_tunai").hide('');
        $("#cetak_piutang").hide('');
        
        });
        
        </script>
        
        

          <script>
          
          $(document).ready(function(){ 
          
          //button batal agar tidak ada loading
          $("#batal").click(function(){
          var session_id = $("#session_id").val();
          
          $.post("batal_pos.php",{session_id:session_id},function(info) {
          
          $("#result").html(info);
          $("#menu_pesanan").show('fast');  
          
          
          });
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

                             
                             <script type="text/javascript">
                             
                $(document).ready(function(){

          //fungsi hapus data 
                $(".btn-hapus").click(function(){
                var nama_barang = $(this).attr("data-pesanan");
                var id = $(this).attr("data-id");
                var kode_barang = $(this).attr("kode-data");
                var no_pesanan = $(this).attr("kode-pesanan");

                $("#data_pesanan").val(nama_barang);
                $("#kode_pesanan_hapus").val(no_pesanan);
                $("#id_hapus").val(id);
                $("#kode_hapus").val(kode_barang);
                $("#modal_hapus").modal('show');
                
                
                });
                
                
                $("#btn_jadi_hapus").click(function(){
                
                var id = $("#id_hapus").val();
                var kode_barang = $("#kode_hapus").val();
                var no_pesanan = $("#kode_pesanan_hapus").val();

                $.post("hapus_bayar_pesanan.php",{id:id,kode_barang:kode_barang,no_pesanan:no_pesanan},function(data){
                if (data != "") {
                $("#result").load('tabel_bayar_pesanan.php?no_faktur=<?php echo $no_faktur; ?>');
                $("#modal_hapus").modal('hide');
                
                }
                
                
                });
                
                });
          // end fungsi hapus data

                    //fungsi edit data 
          $(".btn-edit-tbs").click(function(){
          
          $("#modal_edit").modal('show');
          var jumlah_barang = $(this).attr("data-jumlah-barang");
          var harga = $(this).attr("data-harga");
          var id  = $(this).attr("data-id");
          var kode_barang = $(this).attr("data-kode");
          var no_pesanan = $(this).attr("kode-pesanan");
          $("#harga_edit").val(harga);
          $("#no_pesanan_edit").val(no_pesanan);
          $("#barang_lama").val(jumlah_barang);
          $("#id_edit").val(id);
          $("#kode_edit").val(kode_barang);
          
          
          });
          
          $("#submit_edit").click(function(){
          var jumlah_barang = $("#barang_lama").val();
          var jumlah_baru = $("#barang_edit").val();
          var harga = $("#harga_edit").val();
          var no_pesanan = $("#no_pesanan_edit").val();
          var id = $("#id_edit").val();
          var kode_barang = $("#kode_edit").val();
          var no_faktur = $("#nofaktur").val();
          
          $.post("update_bayar_pesanan.php",{id:id,jumlah_barang:jumlah_barang,jumlah_baru:jumlah_baru,harga:harga,kode_barang:kode_barang,no_faktur:no_faktur,no_pesanan:no_pesanan},function(data){
          
          $("#alert").html(data);
          $("#result").load('tabel_bayar_pesanan.php?no_faktur=<?php echo $no_faktur; ?>');
          
          setTimeout(tutupmodal, 2000);
          setTimeout(tutupalert, 2000);
          
          
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
        
        $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
        
        </script>


<!--proses bayar pesanan-->
<script>

				
				$("#penjualan").click(function(){
				
				var session_id = $("#session_id").val();
                             var no_faktur = $("#nofaktur").val();
				var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
				var kode_pelanggan = $("#kd_pelanggan").val();
				var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
				var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
                             var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
				var potongan_persen = $("#potongan_persen").val();
				var tax = $("#tax_rp").val();
				var cara_bayar = $("#carabayar1").val();
				var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
				var total_hpp = $("#total_hpp").val();
        var kode_meja = $("#kode_meja").val();
        
        var tes_coba = parseInt(sisa_pembayaran, 10);

        var sisa_kredit = total - pembayaran;

				var sisa = pembayaran - total;
				var tes = $("#tes").val(tes_coba);

         $("#tes").val(sisa_pembayaran);
				
				
				if (sisa_pembayaran < 0)
				{
				
				alert("Jumlah Pembayaran Tidak Mencukupi");
				
				}

				else if (kode_pelanggan == "") 
				{
				
				alert("Kode Pelanggan Harus Di Isi");
				
				}
        else if (cara_bayar == "") 
        {
        
        alert("Cara Bayar Belum Di Pilih");
        
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
				
				else
				
				{
				
				$.post("proses_bayar_pesanan.php",{session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kode_pelanggan:kode_pelanggan,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,total_hpp:total_hpp,kode_meja:kode_meja,sisa_kredit:sisa_kredit},function(info) {
				
				$("#demo").html(info);
				$("#cetak_tunai").attr('href', 'cetak_penjualan_pesanan.php?no_faktur=<?php echo $no_faktur; ?>');
				$("#alert_berhasil").show();
				$("#total1").val('');
				$("#pembayaran_penjualan").val('');
				$("#sisa_pembayaran_penjualan").val('');
				$("#potongan_penjualan").val('');
				$("#potongan_persen").val('');
				$("#kd_pelanggan").val('');
				$("#cetak_tunai").show();
				
				
				});
				
				// #result didapat dari tag span id=result
				$("#result").load("tabel_bayar_pesanan.php?no_faktur=<?php echo $no_faktur; ?>");
				
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

<script type="text/javascript">
  $("#potongan_persen").keyup(function(){

      var potongan_persen = $("#potongan_persen").val();

            if (potongan_persen > 100){
              alert("Potongan Tidak Boleh Lebih Dari 100%")
             }
  });
</script>


				<script>
				
				
				$(document).ready(function(){
				$("#potongan_persen").keyup(function(){
				var potongan_persen = $("#potongan_persen").val();
				var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
				var potongan_penjualan = ((total * potongan_persen) / 100);
				var sisa_potongan = total - potongan_penjualan;
				
				
             if (potongan_penjualan != ""){
             $("#potongan_penjualan").attr("disabled", true);
             }

             else{
              $("#potongan_penjualan").attr("disabled", false);
             }
				
				
				$("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
				$("#potongan_penjualan").val(tandaPemisahTitik(parseInt(potongan_penjualan)));
				});
				});
				
				
				$(document).ready(function(){
				$("#potongan_penjualan").keyup(function(){
				var potongan_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
				var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
				var potongan_persen = ((potongan_penjualan / total) * 100);
				var sisa_potongan = total - potongan_penjualan;
				
             if (potongan_persen != ""){
             $("#potongan_persen").attr("disabled", true);
             }

             else{
              $("#potongan_persen").attr("disabled", false);
             }
				
				$("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
				$("#potongan_persen").val(parseInt(potongan_persen));
				});
				});
				
				
				
				</script>
				
				
				
				<script type="text/javascript">
				$(document).ready(function(){
				
				$("#tax").blur(function(){
				
				var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
				var potongan_persen = $("#potongan_persen").val();
				var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
				var tax = $("#tax").val();
				
	if (tax > 100) {
          alert("Tax Tidak Boleh Lebih Dari 100%");
          $("#tax").val('');
        }
        else{

        $.post("cek_tax.php", {potongan:potongan,potongan_persen:potongan_persen,total:total,tax:tax}, function(data) {
        
        $("#total1").val(tandaPemisahTitik(parseInt(data)));
        
        
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
        $(document).ready(function() {
                
        
        
        $("#submit_simpan").click(function(){
        var no_faktur = $("#nomor_faktur_penjualan").val();

     

        $.post("proses_simpan_bayar.php", {no_faktur: no_faktur}, function(data){

      $("#cetak_makanan").attr('href','cetak_makanan_bayar.php?no_faktur='+no_faktur+'');
      $("#cetak_minuman").attr('href','cetak_minuman_bayar.php?no_faktur='+no_faktur+'');
      $("#cetak_pelanggan").attr('href','cetak_pesanan_bayar.php?no_faktur='+no_faktur+'');
        $("#result").html(data);
        $("#cetak_makanan").show();
        $("#cetak_minuman").show();
        $("#cetak_beef").show();
        $("#cetak_pelanggan").show();
        $("#alert_berhasil_pesanan").show();
        });

        

        });
        
        $("#formtambahproduk").submit(function(){
        return false;
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
                                                         $.post("proses_permintaan_bayar.php",{id:id,komentar:komentar},function(data){
                                                         
                                                         
                                                         $("#result").load("tabel_bayar_pesanan.php?no_faktur=<?php echo $no_faktur; ?>");
                                                         $("#modal_komen").modal('hide');
                                                         
                                                         });
                                                         
                                                         
                                                         });
                                                         
                                                         </script>



            
            <script>
            
            // BELUM KELAR !!!!!!
            $(document).ready(function(){
            var cara_bayar = $("#carabayar1").val();
            
            //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
            $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
            /*optional stuff to do after success */
            
            $("#jumlah1").val(data);
            
            });
            $("#carabayar1").change(function(){
            var cara_bayar = $("#carabayar1").val();
            
            //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
            $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
            /*optional stuff to do after success */
            
            $("#jumlah1").val(data);
            
            });
            
            
            var no_faktur = $("#nofaktur").val();
            var potongan_rp = $("#potongan_penjualan").val();
            var tax = $("#tax").val();
            
            $.post("cek_total_pesanan.php",
            {
            no_faktur: no_faktur, potongan:potongan_rp, tax:tax
            },
            function(data){
            $("#total"). val(data);
            $("#total1"). val(data);
            });
            
            });
            });
            </script>




            <script type="text/javascript">
        $(document).ready(function(){
        
        $("#pembayaran_penjualan").focus(function(){
        
        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
        var tax = $("#tax").val();
        
        if (tax > 100 ) {
          alert ("Tax Tidak Boleh Lebih Dari 100%");

          $("#tax").val('');
          $("#carabayar1").val('');
        }
        else{
          $.post("cek_tax.php", {potongan:potongan,potongan_persen:potongan_persen,total:total,tax:tax}, function(data) {
        
        $("#total1").val(tandaPemisahTitik(parseInt(data)));

        
        
        });
        }
        

      var tax_persen = $("#tax").val();
        var tax_rp = ((total * tax_persen) / 100);
        

        $("#tax_rp").val(parseInt(tax_rp));
      


        });
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
         var kode_meja = $("#kode_meja").val();
        
        var sisa =  pembayaran - total; 
        
        var sisa_kredit = total - pembayaran;
        
        
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
        
        $.post("proses_bayar_pesanan.php",{session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,kode_meja:kode_meja},function(info) {
       
        $("#alert_berhasil").show();
        $("#cetak_piutang").attr('href', 'cetak_penjualan_pesanan_piutang.php?no_faktur=<?php echo $no_faktur; ?>');
        $("#alert_berhasil").show();
        $("#total1").val('');
        $("#pembayaran_penjualan").val('');
        $("#sisa_pembayaran_penjualan").val('');
        $("#potongan_penjualan").val('');
        $("#potongan_persen").val('');
        $("#kd_pelanggan").val('');
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
  $(function() {
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>
        
        <!-- memasukan file footer.php -->
        <?php
        
        include 'footer.php'; 
        
        ?>