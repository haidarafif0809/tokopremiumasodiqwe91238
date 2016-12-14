<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
    
    //menampilkan seluruh data yang ada pada tabel pembelian
    $perintah = $db->query("SELECT * FROM pembelian");
    $session_id = session_id();

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

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

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
    
    
    <!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
    <div class="container">
    

  <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpembelian.php" method="post ">
          
          <!-- membuat teks dengan ukuran h3 -->
          <h3> FORM PEMBELIAN </h3><br> 
          
 <div class="row">
   <div class="col-sm-8">

       
          <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
          <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >
          
    <div class="col-sm-6">
      
          <label> Suplier </label><br>
          
          <select name="suplier" id="nama_suplier" class="form-control chosen" required="" >
          <option value="">--Silakan Pilih--</option>
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM suplier");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          
          
          ?>
          </select>

    </div>      
         
    <div class="col-sm-6">
          <label> Gudang </label><br>
          
          <select name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
          <option value="">--Silakan Pilih--</option>
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
          <br>    <br>    <br>   


        <div class="col-sm-6">
          <label>PPN</label>
          <select name="ppn" id="ppn" class="form-control">
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
        </div>

        <div class="col-sm-6">
          
          <label> Cara Bayar </label><br>
          <b><select type="text" name="cara_bayar" id="carabayar1" class="form-control"  required="" style="font-size: 16px" ></b>
          <b><option value=""> Silahkan Pilih </option></b>
          <?php 
          
          
          $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
          }
                      
          ?>
          
          </select>

        </div>
        

  </form> <!-- tag penutup form --><br>
        
   
        
        <!-- membuat tombol agar menampilkan modal -->
        <button type="button" class="btn btn-info" id="cari_produk_pembelian" accesskey="s" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
       <div class="table-responsive">
         
       
        <!--perintah agar modal update-->
        <span class="modal_baru">
        


</span>
</div>
          
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Tbs Pembelian</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     <input type="text" id="nama-barang" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" >

    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"><span class='glyphicon glyphicon-ok-sign'> </span>Ya </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal </button>
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
        <h4 class="modal-title">Edit Data Pembelian Barang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
    <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">
     <input type="hidden" class="form-control" id="harga_edit" readonly="">     
     <input type="hidden" class="form-control" id="kode_edit">    
     <input type="hidden" class="form-control" id="potongan_edit" readonly="">
     <input type="hidden" class="form-control" id="tax_edit" readonly="">
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->
        
        
        <form class="form-inline" role="form" id="formtambahproduk">
        
        <div class="row">
        <div class="col-sm-2">
        <input style="height:25px;font-size:15px;  width: 100px" type="text" class="form-control" name="kode_barang" accesskey="k" id="kode_barang" placeholder="Kode Produk" autocomplete="off">
        </div>
        
        <div class="col-sm-4"> 
        <!-- memasukan teks pada kolom kode barang -->
        <input style="height:25px;font-size:15px" type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
        </div>
        

        <input type="hidden" class="form-control"  name="over_stok" id="over_stok" autocomplete="off" placeholder="Over Stok">



        <div class="col-sm-2">
        <input style="height:25px;font-size:15px; width: 100px" type="text" class="form-control" accesskey="j" name="jumlah_barang" id="jumlah_barang" autocomplete="off" placeholder="Jumlah">
        </div>

        

        <input type="hidden" id="harga_produk" name="harga" class="form-control" placeholder="Harga Lama" required="">
        <input type="hidden" id="harga_lama" name="harga_lama" class="form-control" required="">


        

        <div class="col-sm-2">
          
          <select type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="" style="height:50px;font-size:15px; width: 100px" >
          
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
          </select>

        </div>

        <div class="col-sm-2">
        <input style="height:25px;font-size:15px;width: 100px" type="text" id="harga_baru" name="harga_baru" class="form-control" placeholder="Harga">
        </div>

        </div>
        
        <div class="row">
        <div class="col-sm-2">
        <input style="height:25px;font-size:15px;width: 100px" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan" >
        </div>
        
        <div class="col-sm-2">
        <input style="height:25px;font-size:15px;width: 100px" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Pajak (%)" >
        </div>

        <button type="submit" id="submit_produk" class="btn btn-success"><i class='fa fa-plus'></i> Tambah Produk</button>
        <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->

        <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
        <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
        <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >
        

        </div>
        

        

  </form>
      


  <div class="table-responsive"><!--tag untuk membuat garis pada tabel--> 
       <span id="result">  
  <table id="table" class="table table-bordered">
    <thead>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah Barang </th>
      <th> Satuan </th>
      <th> Harga </th>
      <th> Subtotal </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Hapus </th>
      
    </thead>
    
    <tbody id="tbody">
    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.session_id = '$session_id'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>

      <td>". $data1['nama'] ."</td>
      <td>". rp($data1['harga']) ."</td>
      <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
      <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
      <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>

     <td> <button class='btn btn-danger btn-hapus-tbs' id='hapus-tbs-".$data1['id']."' data-id='". $data1['id'] ."' data-subtotal='".$data1['subtotal']."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                

      </tr>";


      }


          //Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db); 
    ?>
    </tbody>

  </table>
    </span> <!--tag penutup span-->
  </div>





 </div> <!--col-sm-8-->  

<form action="proses_bayar_beli.php" id="form_beli" method="POST"><!--tag pembuka form-->
<style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
}
</style>

<div class="col-sm-4">



<div class="total">


          <label> Subtotal </label><br>
          <input type="text" name="total" id="total_pembelian1" class="form-control" placeholder="" readonly=""  >


          <label> Total Akhir</label><br>
          <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
          <b><input type="text" name="total" id="total_pembelian" class="form-control" placeholder="" readonly="" style="font-size: 20px" ></b>

<div class="row">
          <div class="col-sm-6">

          <label> Potongan ( Rp ) </label><br>
          <input type="text" name="potongan" id="potongan_pembelian" data-diskon="" style="height:25px;font-size:15px" class="form-control" autocomplete="off" placeholder=" ">

          </div>


          <div class="col-sm-6">

          <label> Potongan ( % ) </label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" style="height:25px;font-size:15px" class="form-control" autocomplete="off" placeholder="">
          </div>
</div>

<div class="row">
          <div class="col-sm-6">
          
          <label> Tax ( % )</label><br>
          <input type="text" name="tax" id="tax" class="form-control" style="height:25px;font-size:15px" autocomplete="off" data-pajak="" placeholder="" >
          </div>

            <div class="col-sm-6">
            <label> Tanggal Jatuh Tempo </label><br>
            <input type="text" name="tanggal_jt" id="tanggal_jt" placeholder="" style="height:25px;font-size:15px" value="" class="form-control" >
            </div>

</div>

          
          
  <b><label> Pembayaran </label><br>
          <input type="text" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" class="form-control" onkeyup="javascript:tandaPemisahTitik(this);"  style="font-size: 20px"></b>


<div class="row">
          <div class="col-sm-6">

          <label> Kembalian </label><br>
          <b><input type="text" name="sisa_pembayaran" id="sisa_pembayaran_pembelian" style="height:25px;font-size:15px" class="form-control" placeholder=" " readonly="" style="font-size: 20px"></b>
          </div>

          <div class="col-sm-6">
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control" style="height:25px;font-size:15px" placeholder="" readonly=""  style="font-size: 20px" ></b>
          </div>

</div>
          
          
          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="">  
          <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  
          
          
          
          
          <!-- memasukan teks pada kolom suplier, dan nomor faktur namun disembunyikan -->
          <input type="hidden" name="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >
          
          <input value="Umum" type="hidden" name="suplier" id="supplier" class="form-control" required="" >


</div>




          <!--membuat tombol submit bayar & Hutang-->
          <button type="submit" id="pembayaran" class="btn btn-info">Bayar</button>
          <a class="btn btn-info" href="formpembelian.php" id="transaksi_baru" style="display: none"><span class="glyphicon glyphicon-repeat"></span> Transaksi Baru</a>
          <button type="submit" id="hutang" class="btn btn-warning">Hutang</button>
          <!--membuaat link pada tombol batal-->
          <a href='batal_pembelian.php?session_id=<?php echo $session_id;?>' id='batal' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Batal </a>

          <a href="cetak_pembelian_tunai.php" id="cetak_tunai" style="display: none;" class="btn btn-success" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Tunai </a>

          <a href="cetak_pembelian_hutang.php" id="cetak_hutang" style="display: none;" class="btn btn-success" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Hutang </a>
     



</form><!--tag penutup form-->
<div class="alert alert-success" id="alert_berhasil" style="display:none">
<strong>Success!</strong> Pembayaran Berhasil
</div>
 

          <!-- readonly = digunakan agar teks atau isi hanya bisa dibaca tapi tidak bisa diubah -->
</div><!--col-sm-4-->

<span id="demo"> </span>

</div> <!--row-->

</div><!-- end of container -->


    
<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>


<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("over_stok").value = $(this).attr('over_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("harga_produk").value = $(this).attr('harga');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("id_produk").value = $(this).attr('id-barang');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');

  
  $('#myModal').modal('hide');
  $("#jumlah_barang").focus();
  });


   
  </script> <!--tag penutup perintah java script-->






   <script>
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk
    
  
   $("#submit_produk").click(function(){

    var session_id = $("#session_id").val();
    var suplier = $("#nama_suplier").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = $("#jumlah_barang").val();
    var harga = $("#harga_produk").val();
    var harga_baru = $("#harga_baru").val();
    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
    var tax = $("#tax1").val();
    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_konversi").val();
    var kode_gudang = $("#kode_gudang").val();
    var ppn = $("#ppn").val();
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));

                              
    if (total == '') 
    {
    total = 0;
    } 
      
        if (potongan == '') 
          {
             potongan = 0;
          }

        else
          {
            var pos = potongan.search("%");
           if (pos > 0) 
            {
               var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
               potongan_persen = potongan_persen.replace("%","");
               potongan = jumlah_barang * harga * potongan_persen / 100 ;
            };
          }


    
    var subtotal = parseInt(jumlah_barang, 10) *  parseInt(harga, 10) - parseInt(potongan, 10);
    var total_akhir = parseInt(total,10) + parseInt(subtotal,10);


     $("#jumlah_barang").val(''); 
     $("#potongan1").val('');   
     $("#tax1").val('');
     $("#nama_barang").val('');
     $("#kode_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');   
     $("#harga_produk").val('');
     $("#harga_baru").val('');

  if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
  }
  else if (suplier == ''){
  alert("Suplier Harus Dipilih");
  }
  else if (kode_barang == ''){
  alert("Kode Barang Harus Diisi");
  }
    else if (kode_gudang == ''){
  alert("Kode Gudang Harus Diisi");
  }
    else if (ppn == ''){
  alert("PPN Harus Diisi");
  }    else if (tax > 100){
  alert("Tax Tidak Boleh Lebih Dari 100%");
  }


  
  else {


        $("#total_pembelian").val(tandaPemisahTitik(total_akhir));
        $("#total_pembelian1").val(tandaPemisahTitik(total_akhir));

        $("#submit_produk").hide()

    $.post("prosestbspembelian.php",{session_id:session_id,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan},function(data){
      

      $("#tbody").prepend(data);
      $("#kode_barang").focus();
      $("#ppn").attr("disabled", true);
      $("#nama_barang").val('');
      $("#kode_barang").val('');
      $("#jumlah_barang").val('');
      $("#potongan1").val('');
      $("#tax1").val('');  
      $("#harga_produk").val('');
      $("#harga_baru").val(''); 

    });
}
    
      
  });
              
     $("form").submit(function(){
     return false;
     });




     $("#cari_produk_pembelian").click(function() {

     //menyembunyikan notif berhasil
     $("#alert_berhasil").hide();
     /* Act on the event */

     var suplier = $("#nama_suplier").val();
     
     $.post("modal_beli_baru.php",{suplier:suplier},function(data) {
     
     $(".modal_baru").html(data);
     $("#cetak_tunai").hide('');
     $("#cetak_hutang").hide('');
     
     
     });
     
     });

     
</script>


<script type="text/javascript">
  $(document).ready(function(){
$("#cari_produk_pembelian").click(function(){
  var session_id = $("#session_id").val();

  $.post("cek_tbs_pembelian.php",{session_id: "<?php echo $session_id; ?>"},function(data){
        if (data != "1") {


             $("#ppn").attr("disabled", false);

        }
    });
$("#submit_produk").show('');
});


});
</script>
         


 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){

       var session_id = $("#session_id").val();
       var no_faktur = $("#nomorfaktur").val();
       var sisa_pembayaran = $("#sisa_pembayaran_pembelian").val();
       var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val()))));
       var suplier1 = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
       var total_1 = $("#total_pembelian1").val();
       var potongan = $("#potongan_pembelian").val();
       var potongan_persen = $("#potongan_persen").val();
       var tax = $("#tax").val();
       var tax1 = $("#tax1").val();
       var cara_bayar = $("#carabayar1").val();
       var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
       var kode_gudang = $("#kode_gudang").val();
       var ppn = $("#ppn").val();
       var ppn_input = $("#ppn_input").val();
       var sisa = pembayaran - total;
       var sisa_kredit = total - pembayaran;

     $("#total_pembelian").val('');
     $("#pembayaran_pembelian").val('');
     $("#sisa_pembayaran_pembelian").val('');
     $("#kredit").val('');
     $("#potongan_pembelian").val('');
     $("#potongan_persen").val('');
     $("#nama_suplier").val('');
     
 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


 else if (suplier1 == "") 
 {

alert("Suplier Harus Di Isi");



 }
else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }
 else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }
 else if (sisa < 0)
 {

alert("Silakan Bayar Hutang ");

 }
  else if (total == "" || total == 0)
 {

alert(" Anda Belum Melakukan Pembelian ");

 }

  else if (kode_gudang == "")
 {

alert(" Kode Gudang Harus Diisi ");

 }

 else

 {

  $("#pembayaran").hide();
  $("#hutang").hide();
  $("#batal").hide();
  $("#transaksi_baru").show();

 $.post("proses_bayar_beli.php",{total_1:total_1,kode_gudang:kode_gudang,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,suplier:suplier1,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,tax1:tax1,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,ppn:ppn,ppn_input:ppn_input},function(info) {
    

    $("#result").html(info);
    $("#tax").val('');
    $("#alert_berhasil").show();
    $("#cetak_tunai").show();
    $("#pembayaran_pembelian").val('');
    $("#sisa_pembayaran_pembelian").val('');
    $("#tax").val('');
    
       
   });



 }



    

  });
   $("form").submit(function(){
    return false;
});
            
  
      
  </script>

   <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#hutang").click(function(){
       
       var session_id = $("#session_id").val();
       var no_faktur = $("#nomorfaktur").val();

       var sisa_pembayaran = $("#sisa_pembayaran_pembelian").val();
       var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val()))));
       var suplier = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
       var total_1 = $("#total_pembelian1").val();
       var potongan = $("#potongan_pembelian").val();
       var potongan_persen = $("#potongan_persen").val();
       var tax = $("#tax").val();
       var tax1 = $("#tax1").val();
       var cara_bayar = $("#carabayar1").val();
       var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
       if (pembayaran == '')
       {
        pembayaran = 0;
       }
       var kode_gudang = $("#kode_gudang").val();
       var ppn = $("#ppn").val();
       var ppn_input = $("#ppn_input").val();

       var sisa = pembayaran - total;


       var sisa_kredit = total - pembayaran;

       kredit = sisa_kredit;

       $("#pembayaran_pembelian").val('');
       $("#sisa_pembayaran_pembelian").val('');
       $("#kredit").val('');
       $("#tanggal_jt").val('');

        if (suplier == "") 
       {
       
       alert("Suplier Harus Di Isi");
       
       }
       else if (kode_gudang == "")
        {
          
        alert(" Kode Gudang Harus Diisi ");
          
        }
      else if (tanggal_jt == "")
       {

        alert ("Tanggal Jatuh Tempo Harus Di Isi");
          $("#tanggal_jt").focus();

        
        }
      else if (sisa_kredit == "" )
      {

        alert ("Jumlah Pembayaran Tidak Mencukupi");
      }

      
       
        else if (total == "" || total == 0) 
        {
        
        alert("Total Kosong, Anda Belum Melakukan Pembelian");
        
        }

        

        
       else
       {
         $("#kredit").val(sisa_kredit);
         $("#pembayaran").hide();
         $("#hutang").hide();
         $("#batal").hide();
         $("#transaksi_baru").show();

       $.post("proses_bayar_beli.php",{total_1:total_1,kode_gudang:kode_gudang,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,suplier:suplier,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,tax1:tax1,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,ppn:ppn,ppn_input:ppn_input},function(info) {

       $("#demo").html(info);
       
       $("#alert_berhasil").show();
       $("#cetak_hutang").show();
       $("#result").load("tabel_pembelian.php");
       $("#pembayaran_pembelian").val('');
       $("#sisa_pembayaran_pembelian").val('');
       $("#tanggal_jt").val('');
       
       
       
       });
        // #result didapat dari tag span id=result
       
       }  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

            $("#hutang").mouseleave(function(){
             
             $.get('no_faktur_bl.php', function(data) {
             /*optional stuff to do after getScript */ 
             
             $("#nomorfaktur").val(data);
             $("#no_faktur0").val(data);
             });
             var suplier = $("#nama_suplier").val();
             if (suplier == ""){
             $("#nama_suplier").attr("disabled", false);
             }
             
             });
      
  </script>


<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
 $.post('cek_kode_barang_tbs_pembelian.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>




<script type="text/javascript">

// untuk memunculkan data cek total pembelian
$(document).ready(function(){

  var session_id = $("#session_id").val();

$.post("cek_total_pembelian.php",
    {
        session_id: "<?php echo $session_id; ?>"
    },
    function(data){
        $("#total_pembelian"). val(data);
        $("#total_pembelian1").val(data);
    });

});


</script>

<script>

// untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
    $("#pembayaran_pembelian").keyup(function(){
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
       var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val()))));
      var sisa = pembayaran - total;
      var sisa_kredit = total - pembayaran; 

if (sisa < 0  )
      {

       $("#kredit").val(sisa_kredit);
       $("#sisa_pembayaran_pembelian").val('0');
       $("#tanggal_jt").attr("disabled", false);
      }

else  
      {
       
       
        $("#sisa_pembayaran_pembelian").val(sisa);
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
       } 

      
    });


  });
</script>


<script>

//untuk menampilkan sisa penjualan secara otomatis
  $(document).ready(function(){

  $("#jumlah_barang").keyup(function(){

    var jumlah_barang = $("#jumlah_barang").val();
    if (jumlah_barang == "") {
      jumlah_barang = 0;
    }
    var jumlahbarang =$("#jumlahbarang").val();
     var over_stok = $("#over_stok").val();
    var stok = parseInt(jumlah_barang) + parseInt(jumlahbarang);


if( over_stok < stok ){

      alert ("Persediaan Barang Ini Sudah Melebihi Batas Stok!");
      
    }


  });
});

</script>


<!--membuat menampilkan no faktur dan suplier pada tax-->
<script>

$(document).ready(function(){
    $("#nama_suplier").change(function(){
      var suplier = $("#nama_suplier").val();
      $("#supplier").val(suplier);
        
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

<script>

// untuk memunculkan jumlah kas secara otomatis
  $(document).ready(function(){


$("#pembayaran_pembelian").keyup(function(){
      var jumlah = $("#pembayaran_pembelian").val();
      var jumlah_kas = $("#jumlah1").val();
      var sisa = jumlah_kas - jumlah;
      var carabayar1 = $("#carabayar1").val();

       if (sisa < 0 || carabayar1 == "") 

      {
          $("#submit").hide();
          $("#pembayaran_pembelian").val('');
          $("#potongan_pembelian").val('');
          $("#potongan_persen").val('');
          $("#tax").val('');

        alert("Jumlah Kas Tidak Mencukupi Atau Kolom Cara Bayar Masih Kosong");

      }
      else {
        $("#submit").show();
      }
});

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
      var pembayaran = $("#pembayaran_pembelian").val();
      var tax = $("#tax").val();

      if (tax == "") {
        tax = 0;
      }


      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
      var potongan_rp = ((total * potongan_persen) / 100);
      var sisa_potongan = total - potongan_rp;
      var kredit = parseInt(sisa_potongan, 10) - parseInt(pembayaran,10);
      var kembalian = parseInt(pembayaran,10) - parseInt(sisa_potongan, 10);
      var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
      var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
             
      if (kembalian < 0) {
      $("#kredit").val(kredit);
      $("#sisa_pembayaran_pembelian").val('0');
      }
      if (kredit < 0) {
      $("#kredit").val('0');
      $("#sisa_pembayaran_pembelian").val(kembalian);
      }

             if (potongan_rp != ""){
             $("#potongan_pembelian").attr("readonly", true);
             }

             else{
              $("#potongan_pembelian").attr("readonly", false);
             }
             
      $("#total_pembelian").val(hasil_akhir);
      $("#potongan_pembelian").val(potongan_rp);

      });
      });

      $(document).ready(function(){
      $("#potongan_pembelian").keyup(function(){
      var potongan_pembelian = $("#potongan_pembelian").val();
      var pembayaran = $("#pembayaran_pembelian").val();
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
      var potongan_persen = ((potongan_pembelian / total) * 100);
      var sisa_potongan = total - potongan_pembelian;
      var tax = $("#tax").val();

      if (tax == "") {
        tax = 0;
      }

      var kredit = parseInt(sisa_potongan, 10) - parseInt(pembayaran,10);
      var kembalian = parseInt(pembayaran,10) - parseInt(sisa_potongan, 10);
      var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
      var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
      
      if (kembalian < 0) {
      $("#kredit").val(kredit);
      $("#sisa_pembayaran_pembelian").val('0');
      }
      if (kredit < 0) {
      $("#kredit").val('0');
      $("#sisa_pembayaran_pembelian").val(kembalian);
      }


             if (potongan_persen != ""){
             $("#potongan_persen").attr("readonly", true);
             }

             else{
              $("#potongan_persen").attr("readonly", false);
             }

      $("#total_pembelian").val(Math.round(hasil_akhir));
      $("#potongan_persen").val(Math.round(potongan_persen));
      });
      });

</script>

<script type="text/javascript">
      
      $(document).ready(function(){


      $("#tax").keyup(function(){

              var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var pembayaran = $("#pembayaran_pembelian").val();
              var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
                 $("#potongan_persen").val('');
              }
              
              var t_tax = ((parseInt(t_total,10) * parseInt(tax,10)) / 100);
              var total_akhir = parseInt(t_total,10) + parseInt(t_tax,10);
              var kredit = parseInt(total_akhir, 10) - parseInt(pembayaran, 10);
              var kembalian = parseInt(pembayaran, 10) - parseInt(total_akhir, 10);
              
              
              if (kembalian < 0) {
              $("#kredit").val(kredit);
              $("#sisa_pembayaran_pembelian").val('0');
              }
              if (kredit < 0) {
              $("#kredit").val('0');
              $("#sisa_pembayaran_pembelian").val(kembalian);
              }


              
              $("#total_pembelian").val(parseInt(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }


      });
    });
      
</script>





      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>



<script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data
$(document).on('click', '.btn-hapus-tbs', function (e) {
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
        var subtotal_tbs = $(this).attr("data-subtotal");
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));

      if (total == '') 
        {
          total = 0;
        };
      var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10);

      $("#total_pembelian").val(tandaPemisahTitik(total_akhir));
      $("#total_pembelian1").val(tandaPemisahTitik(total_akhir));


    $.post("hapustbs_pembelian.php",{id:id},function(data){
    if (data == 'sukses') {

      $(".tr-id-"+id+"").remove();
    
    }
    });
    
    
    });

//end fungsi hapus data



              $('form').submit(function(){
              
              return false;
              });
        });


    
     
     function tutupmodal() {
     $(".modal").modal("hide")
     }
     function tutupalert() {
     $(".alert").hide("fast")
     }

</script>

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").keyup(function(){

          var kode_barang = $(this).val();
          var session_id = $("#session_id").val();
          
          $.post("cek_barang_pembelian.php",
          {
          kode_barang: kode_barang
          },
          function(data){
          $("#jumlahbarang").val(data);
          });
          
          $.post('cek_kode_barang_tbs_pembelian.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)

      $.getJSON('lihat_nama_barang_pembelian.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#over_stok').val('');
        $('#harga_produk').val('');
        $('#satuan_produk').val('');
        $('#satuan_konversi').val('');
        $('#harga_baru').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#over_stok').val(json.over_stok);
        $('#harga_produk').val(json.harga_beli);
        $('#satuan_produk').val(json.satuan);
        $('#satuan_konversi').val(json.satuan);
        $('#harga_baru').val(json.harga_beli);
      }
                                              
        });
        
        });
        });

      
      
</script>

<script>
/* Membuat Tombol Shortcut */

function myFunction(event) {
    var x = event.which || event.keyCode;

    if(x == 112){


     $("#myModal").modal();

    }

    else if(x == 113){


     $("#pembayaran_pembelian").focus();

    }

   else if(x == 115){


     $("#pembayaran").focus();

    }
  }
</script>

<script type="text/javascript">
    $(document).ready(function(){

      $("#tax").attr("disabled", true);


    $("#ppn").change(function(){

    var ppn = $("#ppn").val();
    $("#ppn_input").val(ppn);

  if (ppn == "Include"){

      $("#tax").attr("disabled", true);
      $("#tax1").attr("disabled", false);
  }

  else if (ppn == "Exclude") {
    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", true);
  }


  });
  });
</script>


 <script type="text/javascript">
                                 
                                 $(".edit-jumlah").dblclick(function(){

                                      var id = $(this).attr("data-id");
                   
                                     
                                        $("#text-jumlah-"+id+"").hide();                                        
                                        $("#input-jumlah-"+id+"").attr("type", "text");


                                 });


                                 $(".input_jumlah").blur(function(){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));
                                    
                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                    
                                    var subtotal = parseInt(harga,10) * parseInt(jumlah_baru,10) - parseInt(potongan,10);
                                    
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian").val()))));
                                    
                                    subtotal_penjualan = parseInt(subtotal_penjualan,10) - parseInt(subtotal_lama,10) + parseInt(subtotal,10);
                                    
                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = tax_tbs * subtotal / 100;


                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total_pembelian").val(tandaPemisahTitik(subtotal_penjualan));   
                                    $("#total_pembelian1").val(tandaPemisahTitik(subtotal_penjualan));         



                                     $.post("update_pesanan_barang_beli.php",{harga:harga,jumlah_lama:jumlah_lama,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang},function(){

                                    });


                                    $("#kode_barang").focus();
                                    $("#pembayaran_pembelian").val("");

                                 });

                             </script>


<script>

$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      

      $.getJSON("cek_satuan_konversi.php",{satuan_konversi:satuan_konversi, id_produk:id_produk},function(info){
        
        if (satuan_konversi == prev) {
        

          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);

        }

        else if (info.jumlah_total == 0) {
          alert('Satuan Yang Anda Pilih Tidak Tersedia Untuk Produk Ini !');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val('');
          $("#harga_baru").val('');

        }

        else{
          $("#harga_produk").val(info.harga_pokok);
          $("#harga_baru").val(info.harga_pokok);
        }

      });
        
    });

});
</script>



<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>

