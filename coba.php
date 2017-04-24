<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
    $nomor_faktur = $_GET['no_faktur'];
    $suplier = $_GET['suplier'];
    $nama_suplier = $_GET['nama_suplier'];
    $kode_gudang = $_GET['kode_gudang'];
    $nama_gudang = $_GET['nama_gudang'];

    $tbs = $db->query("SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$nomor_faktur'");
    $data_tbs = mysqli_num_rows($tbs);


//menampilkan seluruh data yang ada pada tabel pembelian
    $perintah = $db->query("SELECT tanggal FROM pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_tanggal = mysqli_fetch_array($perintah);

    $jumlah_bayar_hutang = $db->query("SELECT SUM(jumlah_bayar) AS jumlah_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$nomor_faktur'");

    $ambil_jumlah = mysqli_fetch_array($jumlah_bayar_hutang);

    $jumlah_bayar = $ambil_jumlah['jumlah_bayar'];

    $potongan_hutang0 = $db->query("SELECT SUM(potongan) AS potongan FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$nomor_faktur'");
    $ambil_potongan = mysqli_fetch_array($potongan_hutang0);
    $potongan_hutang = $ambil_potongan['potongan'];

    $jumlah_bayar_lama = $jumlah_bayar + $potongan_hutang;

    $data_potongan = $db->query("SELECT total, potongan, tax, ppn FROM pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_potongan = mysqli_fetch_array($data_potongan);
    $potongan = $ambil_potongan['potongan'];
    $tax = $ambil_potongan['tax'];
    $ppn = $ambil_potongan['ppn'];
    $total = $ambil_potongan['total'];


    $data_potongan_persen = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_pembelian WHERE no_faktur = '$nomor_faktur'");
    $ambil_potongan_persen = mysqli_fetch_array($data_potongan_persen);
    $subtotal_persen = $ambil_potongan_persen['subtotal'];

    $potongan_persen = $potongan / $subtotal_persen * 100;
    $hasil_persen = intval($potongan_persen);

    $subtotal_tax = $subtotal_persen - $potongan;
    $hasil_sub = intval($subtotal_tax);

    $potongan_tax = $tax / $hasil_sub * 100;
    $hasil_tax = intval($potongan_tax);

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
    $( ".tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>
    
    
<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
    <div class="container">
    
              
          <!-- membuat teks dengan ukuran h3 -->
          <h3> EDIT DATA PEMBELIAN </h3><br>


<!--membuat agar tabel berada dalam baris tertentu-->
    <div class="row">

<!--membuat tampilan halaman menjadi 8 bagian-->

<div class="col-sm-8">
  


<!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="coba.php" method="post ">

<div class="row">
  
          <div class="col-sm-6">
          <label> No Faktur </label><br>
          
          <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
          <input type="text" name="no_faktur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $nomor_faktur; ?>" required="" >
          
          
          </div>
          
          <div class="col-sm-6">
          <label> Tanggal </label><br>
          <input type="text" name="tanggal" value="<?php echo $ambil_tanggal['tanggal']; ?>" id="tanggal" placeholder="  " value="" class="form-control tanggal" >

          </div>
          

</div>

<div class="row">
  
          <div class="col-sm-6">
          <label> Suplier </label><br>
          
          <select name="suplier" id="nama_suplier" class="form-control chosen" required="" >
          <option value="<?php echo $suplier ?>"><?php echo $nama_suplier ?></option>
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
          <option value="<?php echo $kode_gudang ?>"><?php echo $nama_gudang ?></option>
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


</div>

<br>
<div class="row">
                      
                      
                      <?php if ($data_tbs > 0): ?>

                      <div class="col-sm-6">
                      <label>PPN</label>
                      <select name="ppn" id="ppn" class="form-control" disabled="true">
                      <option value="<?php echo $ppn; ?>"><?php echo $ppn; ?></option> 
                      <option value="Include">Include</option>  
                      <option value="Exclude">Exclude</option>
                      <option value="Non">Non</option>          
                      </select>
                      </div>

                      <?php else: ?>
                      
                      <div class="form-group col-sm-6">

                      <div class="col-sm-6">
                      <label>PPN</label>
                      <select name="ppn" id="ppn" class="form-control">
                      <option value="<?php echo $ppn; ?>"><?php echo $ppn; ?></option> 
                      <option value="Include">Include</option>  
                      <option value="Exclude">Exclude</option>
                      <option value="Non">Non</option>          
                      </select>
                      </div>

                      <?php endif ?> 

                      <div class="col-sm-6">
                      
                      <label> Cara Bayar </label><br>
                      <select type="text" name="cara_bayar" id="carabayar1" class="form-control"  required="" style="font-size: 16px" >
                      <option> Silahkan Pilih </option>
                      <?php 
                      
                      
                      
                      $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");
                      while($data = mysqli_fetch_array($query))
                      {
                      
                      echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                      }
                      
                      ?>
                      
                      </select>
                      </div>
</div>         
          
          
        

  </form> <!-- tag penutup form -->
        
   
        
        <!-- membuat tombol agar menampilkan modal -->
        <button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal">Cari</button>
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
        
        <!--perintah agar modal update-->
        <div class="table-resposive">
        <span class="modal_baru">
        
        
        </span>
</div> <!-- / responsive -->      	
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>
        
        
        <form class="form-inline" action="proses_coba.php" role="form" id="formtambahproduk">
      
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
        <input style="height:25px;font-size:15px;width: 100px" type="text" id="harga_baru" name="harga_baru" class="form-control" placeholder="Harga" readonly="">
        </div>



        </div>
        
        <div class="row">
        
        <div class="col-sm-2">
        <input style="height:25px;font-size:15px;width: 100px" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan" >
        </div>

        <div class="col-sm-2">
        <input style="height:25px;font-size:15px;width: 100px" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Pajak (%)" >
        </div>


        <input type="hidden" class="form-control"  name="over_stok" id="over_stok" autocomplete="off" placeholder="Over Stok">

        

        <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">

        <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
        <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
        <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">
        <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
        <input type="hidden" name="no_faktur" class="form-control" value="<?php echo $nomor_faktur; ?>" required="" >
  
  <!-- membuat tombol submit-->
  <button type="submit" id="submit_produk" class="btn btn-success">Tambah Produk</button>
    </div>


  </form>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Edit Pembelian</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     <input type="text" id="nama-barang" class="form-control" readonly=""> 
     <input type="text" id="kode-barang" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" >

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
     <input type="hidden" class="form-control" id="kode_edit" readonly="">
     <input type="hidden" class="form-control" id="faktur_edit" readonly="">
     <input type="hidden" class="form-control" id="potongan_edit" readonly="">
     <input type="hidden" class="form-control" id="tax_edit" readonly="">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
  </form>
  <span id="alert"></span>
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


<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info!</span></h3>
        <h4>Maaf No Transaksi <strong><?php echo $nomor_faktur; ?></strong> tidak dapat dihapus atau di edit, karena telah terdapat Transaksi Penjualan, Pembayaran Hutang atau Retur Pembelian. Dengan daftar sebagai berikut :</h4>
      </div>

      <div class="modal-body">
      <span id="modal-alert">
       </span>


     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Penjualan atau Pembayaran Hutang atau Retur Pembelian</i></h6>
        <button type="button" class="btn btn-warning btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

  
      <!--Mendefinisikan sebuah bagian dalam dokumen-->  


  <div class="table-responsive"><!--tag untuk membuat garis pada tabel-->    		
        <span id="result">  
	<table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nomor Faktur </th>
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
    
    <tbody>
    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$nomor_faktur'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='tr-id-". $data1['id'] ."'>
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>";

$pilih = $db->query("SELECT no_faktur_pembelian FROM detail_retur_pembelian WHERE no_faktur_pembelian = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]'");
$row_retur = mysqli_num_rows($pilih);

 $hpp_masuk_pembelian = $db->query ("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$nomor_faktur' AND sisa != jumlah_kuantitas AND kode_barang = '$data1[kode_barang]'");
 $row_hpp_masuk = mysqli_num_rows($hpp_masuk_pembelian);


$pilih = $db->query("SELECT no_faktur_pembelian FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data1[no_faktur]'");
$row_hutang = mysqli_num_rows($pilih);

if ($row_retur > 0 || $row_hutang > 0 || $row_hpp_masuk > 0 ) {


        echo"<td class='edit-jumlah-alert' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>"; 

} 

else {


echo"<td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>"; 

}




      echo"<td>". $data1['nama'] ."</td>
      <td>". rp($data1['harga']) ."</td>
      <td><span id='text-subtotal-".$data1['id']."'>". $data1['subtotal'] ."</span></td>
      <td><span id='text-potongan-".$data1['id']."'>". $data1['potongan'] ."</span></td>
      <td><span id='text-tax-".$data1['id']."'>". $data1['tax'] ."</span></td>";

if ($row_retur > 0 || $row_hutang > 0 || $row_hpp_masuk > 0 ) {

      echo "<td> <button class='btn btn-danger btn-alert-hapus' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";

} 

else
{
      echo "<td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-subtotal='".$data1['subtotal']."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}


      echo "</tr>";
      }

          //Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db); 
    ?>
    </tbody>

  </table>
    </span> <!--tag penutup span-->

<h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
  </div>



</div> <!-- /col-sm-8 -- >


  

  <style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
}
</style>





<form action="proses_bayar_beli.php" id="form_beli" method="POST"><!--tag pembuka form-->
<div class="col-sm-4">

          <label> Subtotal </label><br>
          <input type="text" name="total" id="total_pembelian1" class="form-control" placeholder="" readonly=""  >

          <label> Total Akhir</label><br>
          <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
          <b><input type="text" name="total" id="total_pembelian" class="form-control" value="<?php echo $total; ?>" placeholder="" readonly="" style="font-size: 20px" ></b>

<div class="row">
          <div class="col-sm-6">
          <label> Potongan ( Rp ) </label><br>
          <input type="text" name="potongan" id="potongan_pembelian" style="height:25px;font-size:15px" value="<?php echo $potongan; ?>" class="form-control" autocomplete="off" placeholder=" ">
          
          </div>
          
          <div class="col-sm-6">
          <label> Potongan ( % ) </label><br>
          <input type="text" name="potongan_persen" id="potongan_persen" style="height:25px;font-size:15px" value="<?php echo $hasil_persen; ?>" class="form-control" autocomplete="off" placeholder="">
          
          </div>
</div>       

          
<div class="row">
          <div class="col-sm-6">
          <label> Tax </label><br>
          <input type="text" name="tax" id="tax" class="form-control" style="height:25px;font-size:15px" value="<?php echo $hasil_tax; ?>" autocomplete="off" placeholder="" >
         
          </div>

          <div class="col-sm-6">
          <label> Tanggal Jatuh Tempo </label><br>
          <input type="text" name="tanggal_jt" id="tanggal_jt" placeholder="  " style="height:25px;font-size:15px" value="" class="form-control tanggal" >

          </div>
</div>          
           
          <b><label> Pembayaran </label><br>
          <input type="text" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" style="height:25px;font-size:15px" class="form-control" placeholder="" required="" style="font-size: 20px"></b>
          

<div class="row">
          <div class="col-sm-6">
          <label> Kembalian </label><br>
          <b><input type="text" name="sisa_pembayaran" id="sisa_pembayaran_pembelian" style="height:25px;font-size:15px" class="form-control" placeholder=" " readonly="" style="font-size: 20px"></b>

          </div>

          <div class="col-sm-6">
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control" placeholder="" style="height:25px;font-size:15px" readonly=""  style="font-size: 20px" ></b>

          </div>
</div>
          
          
          <b><input type="hidden" name="zxzx" id="zxzx" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly="" required="" ></b>

          <b><input type="hidden" name="jumlah_bayar_lama" id="jumlah_bayar_lama" value="<?php echo $jumlah_bayar_lama; ?>" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly=""></b>

          
          
          
          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="">  
          
          
          
          <!-- memasukan teks pada kolom suplier, dan nomor faktur namun disembunyikan -->
          <input type="hidden" name="no_faktur" class="form-control" value="<?php echo $nomor_faktur; ?>" required="" >
          
          <input type="hidden" name="suplier" id="supplier" class="form-control" required="" >
          <input type="hidden" name="ppn_input" id="ppn_input" value="<?php echo $ppn; ?>" class="form-control" placeholder="ppn input">  


      <div class="col-sm-12">
          <!--membuat tombol submit bayar & Hutang-->
          <button type="submit" id="pembayaran" class="btn btn-info" data-faktur='<?php echo $nomor_faktur ?>'>Bayar</button>

          <a href="pembelian.php?status=semua" id="transaksi_baru" class="btn btn-primary" style="display: none">Transaksi Baru</a>


          <button type="submit" id="hutang" class="btn btn-warning" data-faktur='<?php echo $nomor_faktur ?>'>Hutang</button>
          
          <!--membuaat link pada tombol batal-->
          <a href='batal_pembelian.php?no_faktur=<?php echo $nomor_faktur;?>' id='batal' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Batal </a>

          <a href="cetak_coba_tunai.php" id="cetak_tunai" style="display: none;" class="btn btn-success" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Tunai </a>

          <a href="cetak_coba_hutang.php" id="cetak_hutang" style="display: none;" class="btn btn-success" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Hutang </a>


  <br>
<div class="alert alert-success" id="alert_berhasil" style="display:none">
<strong>Success!</strong> Pembayaran Berhasil
</div>
      </div>



</div>


</form><!--tag penutup form-->





</div><!-- end of row -->   


<span id="demo"> </span>

</div><!-- end of container -->


    
<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $(".table").DataTable();


});
  
</script>

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
  });
   
   
  </script> <!--tag penutup perintah java script-->


   <script>
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk
    
  
   $("#submit_produk").click(function(){

    var no_faktur = $("#nomorfaktur").val();
    var suplier = $("#nama_suplier").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = $("#jumlah_barang").val();
    var harga = $("#harga_produk").val();
    var harga_baru = $("#harga_baru").val();
    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
    var tax = $("#tax1").val();
    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_produk").val();
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
    
    var subtotal = parseInt(jumlah_barang, 10) *  parseInt(harga, 10) - parseInt(potongan, 10);
    var total_akhir = parseInt(total,10) + parseInt(subtotal,10);


     $("#jumlah_barang").val(''); 
     $("#potongan1").val('');   
     $("#tax1").val('');     

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

    $.post("proses_coba.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,harga_baru:harga_baru,potongan:potongan,tax:tax,satuan:satuan},function(data){
      
      $("#kode_barang").focus();
      $("#ppn").attr("disabled", true);
      $("#result").html(data);

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
     
     $.post("modal_beli_coba.php",{suplier:suplier},function(data) {
     
     $(".modal_baru").html(data);
     $("#cetak_tunai").hide('');
     $("#cetak_hutang").hide('');
     
     
     });
     
     });

     
      
</script>

<script type="text/javascript">
  
            $(document).ready(function(){
            
            });


</script>


 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){

       var no_faktur = $("#nomorfaktur").val();
       var sisa_pembayaran = $("#sisa_pembayaran_pembelian").val();
       var kredit = $("#kredit").val();
       var suplier1 = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = $("#total_pembelian").val();
       var total_1 = $("#total_pembelian1").val();
       var potongan = $("#potongan_pembelian").val();
       var potongan_persen = $("#potongan_persen").val();
       var tax = $("#tax").val();
       var tax1 = $("#tax1").val();
       var cara_bayar = $("#carabayar1").val();
       var jumlah_barang = $("#jumlah_barang").val();
       var pembayaran = $("#pembayaran_pembelian").val();
       var tanggal = $("#tanggal").val();
       var jumlah_bayar_lama = $("#jumlah_bayar_lama").val();
       var ppn = $("#ppn").val();
       var ppn_input = $("#ppn_input").val();
       var sisa = pembayaran - total;
       var sisa_kredit = total - pembayaran;

       var jumlah_kredit_baru = parseInt(kredit,10) - parseInt(jumlah_bayar_lama,10);
       var x = parseInt(jumlah_bayar_lama,10) + parseInt(pembayaran,10);
       $("#zxzx").val(x);


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

 else if (sisa < 0) 
 {

alert("Silakan Bayar Hutang");

 }

 else if (jumlah_bayar_lama == 0)
 {

       $("#pembayaran").hide();
       $("#batal").hide();
       $("#hutang").hide();
       $("#transaksi_baru").show(); 
       
       $.post("proses_bayar_coba.php",{total_1:total_1,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,suplier:suplier1,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,tax1:tax1,cara_bayar:cara_bayar,jumlah_barang:jumlah_barang,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,tanggal:tanggal,total_1:total_1,jumlah_kredit_baru:jumlah_kredit_baru,x:x,ppn:ppn,ppn_input:ppn_input},function(info) {
       
       
       $("#alert_berhasil").show();
       $("#result").load('tabel-coba.php?no_faktur=<?php echo $nomor_faktur; ?>');
       $("#cetak_tunai").show();
       
       
       });
 }

else
 {


      if (x > total)
      {
      
      var no_faktur = $(this).attr("data-faktur");
      
      $.post('alert_hutang_pembelian.php',{no_faktur:no_faktur},function(data){
      
      
      $("#modal_alert").modal('show');
      $("#modal-alert").html(data);
      
      });
      
      }

}


 $("form").submit(function(){
    return false;
});

    

  });
            


            
  
        
  </script>

   <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#hutang").click(function(){
       
       var no_faktur = $("#nomorfaktur").val();
       var sisa_pembayaran = $("#sisa_pembayaran_pembelian").val();
       var kredit = $("#kredit").val();
       var suplier = $("#nama_suplier").val();
       var tanggal_jt = $("#tanggal_jt").val();
       var total = $("#total_pembelian").val();
       var potongan = $("#potongan_pembelian").val();
       var potongan_persen = $("#potongan_persen").val();
       var tax = $("#tax").val();
       var cara_bayar = $("#carabayar1").val();
       var jumlah_barang = $("#jumlah_barang").val();
       var pembayaran = $("#pembayaran_pembelian").val();
       var tanggal = $("#tanggal").val();
       var total_1 = $("#total_pembelian1").val();
       var jumlah_bayar_lama = $("#jumlah_bayar_lama").val();
       var tax1 = $("#tax1").val();
       var ppn = $("#ppn").val();
       var ppn_input = $("#ppn_input").val();
       
       var sisa = pembayaran - total;
       var sisa_kredit = total - pembayaran; 

       var jumlah_kredit_baru = parseInt(kredit,10) - parseInt(jumlah_bayar_lama,10);
       var x = parseInt(jumlah_bayar_lama,10) + parseInt(pembayaran,10);
       $("#zxzx").val(x);


      if (kredit == "" )
      {

        alert ("Jumlah Pembayaran Tidak Mencukupi");
      }

       else if (suplier == "") 
       {
       
       alert("Suplier Harus Di Isi");
       
       }
       else if (tanggal_jt == "")
       {

        alert ("Tanggal Jatuh Tempo Harus Di Isi");

       }
       
 else if (jumlah_bayar_lama == 0 || x <= total)
 {


          $("#pembayaran").hide();
          $("#batal").hide();
          $("#hutang").hide();
          $("#transaksi_baru").show();
       
       $.post("proses_bayar_coba.php",{total_1:total_1,tax1:tax1,tanggal:tanggal,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,suplier:suplier,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,jumlah_barang:jumlah_barang,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_1:total_1,jumlah_kredit_baru:jumlah_kredit_baru,x:x,ppn:ppn,ppn_input:ppn_input},function(info) {

       
       $("#alert_berhasil").show();
       $("#result").html(info);
       $("#cetak_hutang").show();
       $("#sisa_pembayaran_pembelian").val('');
       $("#tanggal_jt").val('');
       
       
       
       });
        // #result didapat dari tag span id=result
  }

else
 {


      if (x > total)
      {
      
      var no_faktur = $(this).attr("data-faktur");
      
      $.post('alert_hutang_pembelian.php',{no_faktur:no_faktur},function(data){
      
      
      $("#modal_alert").modal('show');
      $("#modal-alert").html(data);
      
      });
      
      }

}
      


 $("form").submit(function(){
       return false;
       });

  });    
  </script>

  <script type="text/javascript">
  $(document).ready(function(){
$("#cari_produk_pembelian").click(function(){
  var no_faktur = $("#nomorfaktur").val();

  $.post("cek_tbs_coba.php",{no_faktur: "<?php echo $nomor_faktur; ?>"},function(data){
        if (data == "1") {


             $("#ppn").attr("disabled", true);

        }
        else{

             $("#ppn").attr("disabled", false);
        }
    });

});
});
</script>





<script type="text/javascript">



// untuk memunculkan data cek total pembelian
$(document).ready(function(){

var no_faktur = $("#nomorfaktur").val();

$.post("cek_total_coba.php",
    {
        no_faktur: "<?php echo $nomor_faktur; ?>"
    },
    function(data){
        $("#total_pembelian1"). val(data);
        $("#total_pembelian"). val(data);

    });

});


</script>


<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();
 $.post('cek_kode_barang_edit_tbs_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });

    });//penutup click(function()
  });//penutup ready(function()
</script>

<script>

// untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
    $("#pembayaran_pembelian").keyup(function(){
      var pembayaran = $("#pembayaran_pembelian").val();
      var total = $("#total_pembelian").val();
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

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").keyup(function(){

          var kode_barang = $(this).val();
          var no_faktur = $("#nomorfaktur").val();
          
          $.post("cek_barang_pembelian.php",
          {
          kode_barang: kode_barang
          },
          function(data){
          $("#jumlahbarang").val(data);
          });
          
          $.post('cek_kode_barang_edit_tbs_pembelian.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
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
        $('#harga_baru').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#over_stok').val(json.over_stok);
        $('#harga_produk').val(json.harga_beli);
        $('#satuan_produk').val(json.satuan);
        $('#harga_baru').val(json.harga_beli);
      }
                                              
        });
        
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


            
            var suplier = $("#nama_suplier").val();
            
            if (suplier != ""){
            $("#nama_suplier").attr("disabled", true);
            }
            
            
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
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_pembelian1").val()))));
      var pembayaran = $("#pembayaran_pembelian").val();
      var tax = $("#tax").val();

      if (tax == "") {
        tax = 0;
      }

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
             $("#potongan_pembelian").attr("disabled", true);
             }

             else{
              $("#potongan_pembelian").attr("disabled", false);
             }
             
      $("#total_pembelian").val(hasil_akhir);
      $("#potongan_pembelian").val(potongan_rp);

      });
      });

      $(document).ready(function(){
      $("#potongan_pembelian").keyup(function(){
      var potongan_pembelian = $("#potongan_pembelian").val();
      var total = $("#total_pembelian1").val();
      var pembayaran = $("#pembayaran_pembelian").val();
      var tax = $("#tax").val();

      if (tax == "") {
        tax = 0;
      }

      var potongan_persen = ((potongan_pembelian / total) * 100);
      var sisa_potongan = total - potongan_pembelian;

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
             $("#potongan_persen").attr("disabled", true);
             }

             else{
              $("#potongan_persen").attr("disabled", false);
             }

      $("#total_pembelian").val(hasil_akhir);
      $("#potongan_persen").val(potongan_persen);
      });
      });

</script>

    <script type="text/javascript">
      $(document).ready(function(){
      $("#tax").keyup(function(){

              var potongan = $("#potongan_pembelian").val();
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var pembayaran = $("#pembayaran_pembelian").val();
              var total = $("#total_pembelian1").val();
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
      $(document).ready(function(){
      $("#pembayaran_pembelian").focus(function(){

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
 
$(".btn-alert-hapus").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");

    $.post('alert_edit_pembelian.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
    
 
    $("#modal_alert").modal('show');
    $("#modal-alert").html(data); 

});

  });
</script>

<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click', '.btn-hapus-tbs', function (e) {
    var nama_barang = $(this).attr("data-barang");
    var kode_barang = $(this).attr("data-kode-barang");
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


    $.post("hapus_coba.php",{id:id,kode_barang:kode_barang},function(data){
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
//fungsi edit data 
$(document).ready(function(){
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_barang = $(this).attr("data-jumlah-barang");
        var harga = $(this).attr("data-harga");
        var no_faktur = $(this).attr("data-faktur");
        var kode_barang = $(this).attr("data-kode");
        var potongan  = $(this).attr("data-potongan");
        var tax  = $(this).attr("data-tax");
        var id  = $(this).attr("data-id");
        $("#harga_edit").val(harga);
        $("#barang_lama").val(jumlah_barang);
        $("#faktur_edit").val(no_faktur);
        $("#kode_edit").val(kode_barang);
        $("#id_edit").val(id);
        $("#potongan_edit").val(potongan);
        $("#tax_edit").val(tax);
        
        
        });
        
        $("#submit_edit").click(function(){
        var jumlah_barang = $("#barang_lama").val();
        var jumlah_baru = $("#barang_edit").val();
        var harga = $("#harga_edit").val();
        var potongan = $("#potongan_edit").val();
        var tax = $("#tax_edit").val();
        var kode_barang = $("#kode_edit").val();
        var id = $("#id_edit").val();

        $.post("update_coba.php",{id:id,jumlah_barang:jumlah_barang,jumlah_baru:jumlah_baru,harga:harga,potongan:potongan,tax:tax,kode_barang:kode_barang},function(data){

          $("#kode_barang").focus();
        $("#alert").html(data);
        $("#result").load('tabel-coba.php?no_faktur=<?php echo $nomor_faktur; ?>');
        setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
      
        });
        });
//end function edit data

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

                                     $.post("update_pesanan_barang_beli.php",{harga:harga,jumlah_lama:jumlah_lama,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang},function(info){

                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total_pembelian").val(tandaPemisahTitik(subtotal_penjualan));
                                    $("#total_pembelian1").val(tandaPemisahTitik(subtotal_penjualan));         

                                    });


                                    $("#kode_barang").focus();
                                    $("#pembayaran_pembelian").val("");

                                 });

                             </script>


<script type="text/javascript">
  
      $(".edit-jumlah-alert").dblclick(function(){

      var no_faktur = $(this).attr("data-faktur");
      var kode_barang = $(this).attr("data-kode");
                                      
      $.post('alert_edit_pembelian.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){

      $("#modal_alert").modal('show');
      $("#modal-alert").html(data);

                                      
});
});
</script>

<script type="text/javascript">
    $(document).ready(function(){

var ppn_input = $("#ppn_input").val();

      if (ppn_input == "Include"){

      $("#tax").attr("disabled", true);
      $("#tax1").attr("disabled", false);
  }

  else if (ppn_input == "Exclude") {
    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", true);
  }

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

