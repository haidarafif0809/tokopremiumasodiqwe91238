<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$no_faktur = $_GET['no_faktur_retur'];

$perintah = $db->query("SELECT * FROM retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
$ambil = mysqli_fetch_array($perintah);  

    $data_potongan = $db->query("SELECT potongan, tax, ppn FROM retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
    $ambil_potongan = mysqli_fetch_array($data_potongan);
    $potongan = $ambil_potongan['potongan'];
    $tax = $ambil_potongan['tax'];
    $ppn = $ambil_potongan['ppn'];


    $data_potongan_persen = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
    $ambil_potongan_persen = mysqli_fetch_array($data_potongan_persen);
    $subtotal_persen = $ambil_potongan_persen['subtotal'];

    $potongan_persen = $potongan / $subtotal_persen * 100;
    $hasil_persen = intval($potongan_persen);

    $subtotal_tax = $subtotal_persen - $potongan;
    $hasil_sub = intval($subtotal_tax);

    $potongan_tax = $tax / $hasil_sub * 100;
    $hasil_tax = intval($potongan_tax);
 ?>

      <script>
      $(function() {
      $( ".tgl" ).datepicker({dateFormat: "yy-mm-dd"});
      });
      </script>

<!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
<div class="container">


<!--membuat agar tabel berada dalam baris tertentu-->
 <div class="row">

 <!--membuat tampilan halaman menjadi 8 bagian-->


  <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="form_retur_penjualan.php" method="post ">
					
          <!-- membuat teks dengan ukuran h3 -->
    			<h3> <u> FORM EDIT RETUR PENJUALAN </u> </h3><br> 


  <div class="row">



    <div class="col-sm-3">
          <label> Kode Pelanggan </label><br><br>
          <select data-placeholder="--SILAHKAN PILIH--" name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="" >
          <option value="<?php echo $ambil['kode_pelanggan']; ?>"><?php echo $ambil['kode_pelanggan']; ?></option>
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM pelanggan");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['kode_pelanggan'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
          
          }
          
          
          ?>
          </select>
    </div>


    <div class="col-sm-2">
          <label> Tanggal </label><br>
          <input style="height: 25px" type="text" value="<?php echo $ambil['tanggal']; ?>" name="tanggal" id="tanggal" placeholder="Tanggal"  class="form-control tgl" required="" >
    </div>

    <div class="col-sm-2">
          <label> No Faktur </label><br>
					<input style="height: 25px" type="text" name="no_faktur_retur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
		</div>			



    <div class="col-sm-1">
          <label> User </label><br>
          <input style="height: 25px" type="text" name="user" class="form-control" readonly="" value="<?php echo $_SESSION['user_name']; ?>" required="">
    </div>

</div>

<div class="col-sm-8">

<div class="row">

    <div class="col-sm-4">
          <label>PPN</label>
          <select name="ppn" id="ppn" class="form-control">
            <option value="<?php echo $ppn; ?>"><?php echo $ppn; ?></option>  
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
    </div>

    <div class="col-sm-4">
      <label> Cara Bayar </label><br>
      <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required="" >
      <option value=""> --SILAHKAN PILIH-- </option>
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
    </div>


</div>

          </form> <!-- tag penutup form -->

				



<!-- membuat tombol agar menampilkan modal -->
<button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari</button>


<!-- Tampilan Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Detail Penjualan</h4>

        
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->


<span class="modal_retur_baru">

      <!--perintah agar modal update-->

      <div class="table-responsive">
      <!-- membuat agar ada garis pada tabel, disetiap kolom-->
        <table id="tableuser" class="table table-bordered">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah Beli </th>
      <th> Satuan </th>
      <th> Harga Barang  </th>
      <th> Subtotal </th>
      <th> Potongan </th>
      <th> Tax </th>
      <th> Sisa Barang </th>
      
    </thead> <!-- tag penutup tabel -->
    
    <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
    <?php

    // menampilkan seluruh data yang ada pada tabel barang yang terdapat pada DB
    $perintah = $db->query("SELECT * FROM detail_penjualan");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."'
      satuan='". $data1['satuan'] ."' no_faktur='". $data1['no_faktur'] ."' harga='". $data1['harga'] ."' jumlah-barang='". $data1['jumlah_barang'] ."' sisa='". $data1['sisa'] ."' >
      
      <td>". $data1['no_faktur'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['jumlah_barang'] ."</td>
      <td>". $data1['satuan'] ."</td>
      <td>". $data1['harga'] ."</td>
      <td>". $data1['subtotal'] ."</td>
      <td>". $data1['potongan'] ."</td>
      <td>". $data1['tax'] ."</td>
      <td>". $data1['sisa'] ."</td></tr>";
      
       }

    ?>
    </tbody> <!--tag penutup tbody-->

  </table> <!-- tag penutup table-->

</div>
        	</span>
      </div> <!-- tag penutup modal body -->

      <!-- tag pembuka modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> <!--tag penutup moal footer -->
    </div>

  </div>
</div>


<!-- membuat form -->
 <form action="proses_edit_tbs_retur_penjualan.php" role="form" id="formtambahproduk">
  
<div class="row">

    <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="kode_barang" autocomplete="off" id="kode_barang" placeholder="Kode Produk">
    </div>


  <div class="form-group col-sm-4"> <!-- agar tampilan berada pada satu group -->
  <!-- memasukan teks pada kolom kode barang -->
  <input type="text" class="form-control" readonly="" name="nama_barang" id="nama_barang" placeholder="Nama Barang">
  </div>
  

  <div class="form-group col-sm-1" >
    <input type="text" class="form-control" name="jumlah_retur" id="jumlah_retur" autocomplete="off" placeholder="0" >
  </div>


<div class="form-group col-sm-2">
          
        <select name="satuan_konversi" id="satuan_konversi" class="form-control"  required=""  >
          
          <?php 
                  
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
          </select>

        </div>


</div>


<div class="row">
  
   <div class="form-group col-sm-3">
  <input type="text" id="harga_produk" name="harga" class="form-control" autocomplete="off" value="" placeholder="Harga Barang" required="">
  </div>

      <div class="form-group col-sm-3">
  <input type="text" id="potongan1" name="potongan1" class="form-control" autocomplete="off" value="" placeholder="Potongan" required="">
  </div>

    <div class="form-group col-sm-2">
  <input type="text" id="tax1" style="width: " name="tax1" class="form-control" autocomplete="off" value="" placeholder="Pajak (%)" required="">
  </div>
<div class="col-sm-4">

  <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
  
</div>

</div>
 
  
  <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
<!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
  <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
  <input type="hidden" id="harga_lama" name="harga_lama" class="form-control" value="" required="">
  <input type="hidden" id="harga_baru" name="harga_baru" class="form-control" value="" required="">
  <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">
  <input type="hidden" id="satuan_jual" name="satuan" class="form-control" value="" required="">
    <input type="hidden" id="harga_pcs" name="harga_pcs" class="form-control" value="" required="">  
   <input type="text" id="satuan_pcs" name="satuan_pcs" class="form-control" value="" required="">
  <input type="hidden" name="no_faktur_retur" id="noretur_jl" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
  <input type="hidden" id="no_faktur2" name="no_faktur_penjualan" class="form-control" value="" required="">

  <input type="hidden" name="jumlah_beli" class="form-control" value="<?php echo $data1['jumlah_barang']; ?>" required="" >
  <input type="hidden" id="sisabarang" name="sisa" class="form-control" value="" required="" >
  <!-- membuat tombol submit-->




</form>



<div class="table-responsive"><!--tag untuk membuat garis pada tabel-->   

  <span id="result">      
  <table id="table" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Retur </th>
      <th> Nomor Faktur Penjualan </th>
      <th> Nama Barang</th>
      <th> Kode Barang </th>
      <th> Jumlah Jual </th>
      <th> Satuan Jual</th>
      <th> Jumlah Retur </th>
      <th> Satuan Retur</th>
      <th> Harga </th>
      <th> Potongan </th>
      <th> Pajak </th>
      <th> Subtotal </th>
      <th> Hapus </th>
      
      
    </thead>
    
    <tbody id="tbody">
     <?php

    //untuk menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
    $perintah = $db->query("SELECT tp.id, tp.no_faktur_penjualan, tp.no_faktur_retur, tp.nama_barang, tp.kode_barang, tp.jumlah_beli, tp.jumlah_retur, tp.satuan, tp.harga, tp.harga, tp.potongan, tp.tax, tp.subtotal, s.nama AS satuan_retur,ss.nama AS satuan_jual FROM tbs_retur_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id INNER JOIN satuan ss ON tp.satuan_jual = ss.id  WHERE tp.no_faktur_retur = '$no_faktur'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur_retur'] ."</td>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". rp($data1['jumlah_beli']) ."</td>
      <td>". $data1['satuan_jual'] ."</td>";


      $pilih = $db->query("SELECT * FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$data1[no_faktur_retur]' AND kode_barang = '$data1[kode_barang]'");
      $row_retur = mysqli_num_rows($pilih);



if ($row_retur > 0) {

                echo"<td class='edit-jumlah-alert' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur_retur']."'  data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_retur'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_retur']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' data-faktur-jual='".$data1['no_faktur_penjualan']."' data-faktur='".$data1['no_faktur_retur']."'> </td>";  

}
else {

  echo"<td class='edit-jumlah' data-id='".$data1['id']."'   data-faktur='".$data1['no_faktur_retur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_retur'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_retur']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' data-faktur-jual='".$data1['no_faktur_penjualan']."' data-faktur='".$data1['no_faktur_retur']."'> </td>";  

}

echo "<td>". $data1['satuan_retur'] ."</td>
      <td>". rp($data1['harga']) ."</td>


<td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
      <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>


      
      <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>";
      

if ($row_retur > 0) {

      echo "<td> <button class='btn btn-danger btn-alert-hapus' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur_retur']."' data-kode='".$data1['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";

} 

else{
      echo "<td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur_penjualan'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

      echo "</tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database
      
      mysqli_close($db); 
    ?>
    </tbody>

  </table>
</span> <!--tag penutup span-->

  </div>

									

	</div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

  <div class="col-sm-4"> <!--tag pembuka col sm 4-->

  <form action="proses_bayar_edit_retur_jual.php" id="form_beli" method="POST"><!--tag pembuka form-->

      <label><b> Subtotal</b></label><br>
      <input style="height: 20px" type="text" name="total1" id="total_retur_pembelian1" class="form-control" placeholder="Subtotal" readonly=""  >

			<label><b> Total Akhir </b></label><br>
      <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
			<input style="font-size: 25px" type="text" name="total" id="total_retur_pembelian" class="form-control" placeholder="Total" readonly=""  >

<div class="row">
  <div class="col-sm-4">
    
      <label><b> Potongan (Rp) </b></label><br>
      <input style="height: 20px" type="text" name="potongan" id="potongan_pembelian" value="<?php echo $potongan; ?>" class="form-control" placeholder="Potongan" autocomplete="off">

  </div>

  <div class="col-sm-4">
    
      <label><b> Potongan (%) </b></label><br>
      <input style="height: 20px" type="text" name="potongan_persen" id="potongan_persen" value="<?php echo $hasil_persen; ?>" class="form-control" placeholder="Potongan" autocomplete="off">

  </div>

  <div class="col-sm-4">
    
      <label><b> Tax </b></label><br>
      <input style="height: 20px" type="text" name="tax" id="tax" class="form-control" value="<?php echo $hasil_tax; ?>" placeholder="Tax" autocomplete="off">

  </div>
</div>
          

      <label><b> Pembayaran </b></label><br>
      <input style="font-size: 25px" type="text" name="pembayaran" id="pembayaran_pembelian" autocomplete="off" class="form-control" placeholder="Pembayaran" >

      <label><b> Kembalian </b></label><br>
      <input style="font-size: 25px" type="text" name="sisa" id="sisa_pembayaran_pembelian" class="form-control" placeholder="Sisa Pembayaran" readonly="" >

      <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah"><br> 

      <input type="hidden" name="ppn_input" id="ppn_input" value="<?php echo $ppn; ?>" class="form-control" placeholder="ppn input">
      


<!-- memasukan teks pada kolom suplier, dan nomor faktur namun disembunyikan -->
      <input type="hidden" name="no_faktur_retur" id="nofaktur_jl" class="form-control" value="<?php echo $no_faktur; ?>" required="" >

      <input type="hidden" name="kode_pelanggan" id="kd_pelanggan1" class="form-control" required="" >
  
  

		
      <input type="hidden" name="tanggal" id="tanggal_hidden" class="form-control tgl" value="<?php echo $ambil['tanggal']; ?>" >
                              
      <!--membuat tombol submit bayar & Hutang-->
			<button type="submit" id="pembayaran" class="btn btn-info"> <i class='fa fa-send'> </i> Bayar </button>
      
      <a class="btn btn-info" href="form_retur_penjualan.php" id="transaksi_baru" style="display: none"> <i class="fa fa-refresh"></i> Transaksi Baru</a>


      <a href='batal_retur_penjualan.php?no_faktur_retur=<?php echo $no_faktur;?>' id='batal_transaksi' class='btn btn-danger'><i class='fa fa-close'> </i> Batal </a>



      <a href='cetak_retur_penjualan.php' id="cetak_retur" style="display: none;" class="btn btn-success" target="blank"><span class="fa fa-print"> </span> Cetak Retur Penjualan </a>
     

					</form><!--tag penutup form-->
<div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Pembayaran Berhasil
</div>
  </div><!-- end of col sm 4 -->
</div><!-- end of row -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Kode Barang :</label>
     <input type="text" id="hapus_kode" class="form-control" readonly=""> 
     <input type="hidden" id="hapus_faktur" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
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
        <h4 class="modal-title">Edit Data Retur Penjualan</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
    <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">
     <input type="hidden" class="form-control" id="harga_edit" readonly="">
     <input type="hidden" class="form-control" id="id_edit">

     <input type="hidden" class="form-control" id="jumlah_edit">
     <input type="hidden" class="form-control" id="kode_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-primary">Submit</button>
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
        <h4>Maaf No Transaksi <strong><?php echo $no_faktur; ?></strong> tidak dapat dihapus atau di edit, karena telah terdapat Transaksi dibawah ini. Dengan daftar sebagai berikut :</h4>
      </div>

      <div class="modal-body">
      <span id="modal-alert">
       </span>


     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi diatas</i></h6>
        <button type="button" class="btn btn-warning btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<span id="demo"> </span>

</div><!-- end of container -->


    
<script>
// untuk memunculkan data tabel 
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
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("no_faktur2").value = $(this).attr('no_faktur');
  document.getElementById("harga_produk").value = $(this).attr('harga');
  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');
  document.getElementById("sisabarang").value = $(this).attr('sisa');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id_produk');
  document.getElementById("satuan_pcs").value = $(this).attr('asal_satuan');
  document.getElementById("harga_pcs").value = $(this).attr('harga_pcs');
  document.getElementById("satuan_jual").value = $(this).attr('satuan');
  
  $('#myModal').modal('hide');
  });
   

// tabel lookup table_barang
  $(function () {
  $("#table_barang").dataTable();
  });

   
  </script> <!--tag penutup perintah java script-->


   <script>
   //perintah javascript yang diambil dari form tbs penjualan dengan id=form tambah produk

  
   $("#submit_produk").click(function(){

    var sisabarang = $("#sisabarang").val();
    var kode_pelanggan = $("#kd_pelanggan").val();
    var nama_barang = $("#nama_barang").val();
    var satuan_produk = $("#satuan_konversi").val();
    var kode_barang = $("#kode_barang").val();
    var no_faktur = $("#no_faktur2").val();
    var tax1 = $("#tax1").val();
    var ppn = $("#ppn").val();
    var satuan_jual = $("#satuan_jual").val();
    var no_faktur_retur = $("#nomorfaktur").val();

    var jumlah_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_retur").val()))));
    var jumlahbarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahbarang").val()))));
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
    var potongan1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));


    var sisa = sisabarang - jumlah_retur;

          if (potongan1 == '') 
          {
             potongan1 = 0;
          }

        else
          {
            var pos = potongan1.search("%");
           if (pos > 0) 
            {
               var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
               potongan_persen = potongan_persen.replace("%","");
               potongan1 = jumlah_retur * harga * potongan_persen / 100 ;
            };
          }

          var subtotal = parseInt(jumlah_retur, 10) *  parseInt(harga, 10) - parseInt(potongan1, 10);
          
          
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
          if (total == '') 
          {
          total = 0;
          };

    var total_akhir = parseInt(total,10) + parseInt(subtotal,10);


  
if (jumlah_retur == ""){
  alert("Jumlah Barang Harus Diisi");
  }
  else if (kode_pelanggan == ""){
  alert("Kode Pelanggan Harus Dipilih");
  }
  else
  {


    $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));
    $("#total_retur_pembelian1").val(tandaPemisahTitik(total_akhir));

    $.post("proses_edit_tbs_retur_penjualan.php",{no_faktur_retur:no_faktur_retur,no_faktur_penjualan:no_faktur,kode_barang:kode_barang,jumlah_retur:jumlah_retur,satuan_produk:satuan_produk,nama_barang:nama_barang,harga:harga,potongan1:potongan1,tax1:tax1,satuan_jual:satuan_jual},function(info) {


     $("#kode_barang").focus();
     $("#ppn").attr("disabled", true);
     $("#tbody").prepend(info);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_retur").val('');
     $("#no_faktur2").val('');
     $("#harga_produk").val('');


       
   });
 
}


  });

      $("#formtambahproduk").submit(function(){
    return false;
});
  


  
      $("#cari_produk_pembelian").click(function() {  

      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      /* Act on the event */
      
  var kode_pelanggan = $("#kd_pelanggan").val();
    var no_faktur_retur = $("#nomorfaktur").val();


   $.post("modal_edit_retur_jual_baru.php", {kode_pelanggan:kode_pelanggan,no_faktur_retur:no_faktur_retur}, function(info) {


  $(".modal_retur_baru").html(info);
      
      
      });

  });
  
      
  </script>

  <script type="text/javascript">
    
            $(".container").hover(function(){
            var no_faktur_retur = $("#nomorfaktur").val();
            
            $.post("cek_total_edit_retur_penjualan.php",
            {
            no_faktur_retur: no_faktur_retur
            },
            function(data){
            $("#total_retur_pembelian"). val(data);
            $("#total_retur_pembelian1"). val(data);
            });
            
            
            });

  </script>


 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){


  var sisa = $("#sisa_pembayaran_pembelian").val();
  var kode_pelanggan = $("#kd_pelanggan").val();
  var total = $("#total_retur_pembelian").val();
  var carabayar = $("#carabayar1").val();
  var potongan = $("#potongan_pembelian").val();
  var tax = $("#tax").val();
  var pembayaran = $("#pembayaran_pembelian").val();
  var no_faktur_retur = $("#nomorfaktur").val();
  var total1 = $("#total_retur_pembelian1").val();
  var ppn_input = $("#ppn_input").val();
  var tanggal = $("#tanggal").val();

 if (sisa < 0 )
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }

  else if (total == "")
 {

  alert("Jumlah Total Kosong! Anda Belum Melakukan Pemesan");

 }

 else if (sisa == "")
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


 else if ( kode_pelanggan == "") 
 {

alert("Kode Pelanggan Harus Di Isi");

 }


 else if (jumlah_retur == "0")
 {

  alert("jumlah Retur Harus Di Isi");

 }


 else

 {

  $("#transaksi_baru").show();
  $("#pembayaran").hide();
  $("#batal_transaksi").hide();
  $("#batal").hide();

 $.post("proses_bayar_edit_retur_jual.php",{no_faktur_retur:no_faktur_retur,sisa:sisa,kode_pelanggan:kode_pelanggan,total:total,cara_bayar:carabayar,potongan:potongan,tax:tax,pembayaran:pembayaran,total1:total1,ppn_input:ppn_input,tanggal:tanggal},function(info) {

     $("#demo").html(info);
     $("#result").load("tabel_retur_edit_penjualan.php?no_faktur_retur=<?php echo $no_faktur; ?>");
     $("#alert_berhasil").show();
     $("#cetak_retur").show();    
     $("#total_retur_pembelian").val('');
     $("#pembayaran_pembelian").val('');
     $("#sisa_pembayaran_pembelian").val('');
     $("#potongan_pembelian").val('');
     $("#tax").val('');
     $("#total_retur_pembelian1"). val('');
  
    
       
   });

 }

 $("form").submit(function(){
    return false;
});



  });



                 $("#pembayaran").mouseleave(function(){
               
               $.get('no_faktur_rj.php', function(data) {
               /*optional stuff to do after getScript */ 

               
               $("#noretur_jl").val(data);
               
               });
               });
  
  
      
  </script>

  <script type="text/javascript">
  
  // untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
    $("#pembayaran_pembelian").focus(function(){
      var total_retur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val()))));
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));

      var diskon_lama = $("#potongan_pembelian").attr('data-diskon');
      $("#potongan_pembelian").attr('data-diskon', potongan);

      if (diskon_lama == "") {

        diskon_lama = 0;
      }

      if (potongan == "") {
        potongan = 0;
      }

      var hasil = parseInt(total_retur,10) - parseInt(potongan,10);

      $("#total_retur_pembelian").val(hasil);


      
      });
    });


</script>

<script type="text/javascript">
      
      $(document).ready(function(){


    $("#pembayaran_pembelian").focus(function(){

              var potongan = $("#potongan_pembelian").val();
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var total = $("#total_retur_pembelian1").val();
              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
              }
              
              var t_tax = ((parseInt(t_total,10) * parseInt(tax,10)) / 100);
              var total_akhir = parseInt(t_total,10) + parseInt(t_tax,10);
              
              
              $("#total_retur_pembelian").val(parseInt(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }

      });
    });
      
</script>

<script type="text/javascript">

// perintah javascript yang diambil dari form tbs penjualan dengan id=total_pembelian
$("#kode_barang").focus(function(){

$.post("cek_total_edit_retur_penjualan.php",
    {
        no_faktur_retur: "<?php echo $no_faktur; ?>"
    },
    function(data){
        $("#total_retur_pembelian"). val(data);
        $("#total_retur_pembelian1"). val(data);
    });




});


// untuk memunculkan data cek total penjualan
$(document).ready(function(){
$.post("cek_total_edit_retur_penjualan.php",
    {
        no_faktur_retur: "<?php echo $no_faktur; ?>"
    },
    function(data){
        $("#total_retur_pembelian"). val(data);
        $("#total_retur_pembelian1"). val(data);
    });

});


</script>

<script type="text/javascript">


// untuk memunculkan data cek total penjualan
$(document).ready(function(){
$.post("cek_total_edit_retur_penjualan.php",
    {
        no_faktur_retur: "<?php echo $no_faktur; ?>"
    },
    function(data){
        $("#total_retur_pembelian"). val(data);
        $("#total_retur_pembelian1"). val(data);
    });

});


</script>

<script type="text/javascript">
  
  // untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
$("#potongan_pembelian").keyup(function(){

        var potongan_pembelian =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_pembelian").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));
        var potongan_persen = ((potongan_pembelian / total) * 100);
        var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
        }

        if (potongan_pembelian != ""){
             $("#potongan_pembelian").attr("readonly", false);
              $("#potongan_persen").attr("readonly", true);

             }

        else{
              $("#potongan_persen").attr("readonly", true);
             $("#potongan_pembelian").attr("readonly", false);
             }

             
             var sisa_potongan = total - potongan_pembelian;
             
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);

        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_persen").val(parseInt(potongan_persen));

      });
    });


</script>

<script type="text/javascript">
  
  $(document).ready(function(){
        
        $("#potongan_persen").keyup(function(){

        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total_retur_pembelian1").val() ))));
        var potongan_rupiah = ((total * potongan_persen) / 100);
        var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
        }

        if (potongan_persen != ""){
              $("#potongan_persen").attr("readonly", false);
              $("#potongan_pembelian").attr("readonly", true);
             }

        else{
              $("#potongan_pembelian").attr("readonly", true);
              $("#potongan_persen").attr("readonly", false);
             }

      
             var sisa_potongan = total - potongan_rupiah;             
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_pembelian").val(tandaPemisahTitik(parseInt(potongan_rupiah)));

      });

  });

</script>

<script type="text/javascript">
      
      $(document).ready(function(){


      $("#tax").keyup(function(){

        var potongan_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val() ))));
       
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - potongan_rupiah;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
                 $("#potongan_persen").val('');
              }
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10));
              
              
              $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }



        });
        });
      
</script>

<script>

// untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
    $("#pembayaran_pembelian").keyup(function(){
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_pembelian").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
      var sisa = pembayaran - total;

      $("#sisa_pembayaran_pembelian").val(sisa);
    });
  });
</script>

<!--membuat menampilkan no faktur dan suplier pada tax-->
<script>

$(document).ready(function(){
    $("#kd_pelanggan").change(function(){
      var kode_pelanggan = $("#kd_pelanggan").val();
      $("#kd_pelanggan1").val(kode_pelanggan);
        
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
        
    });
});
</script>

<script>
 $(document).ready(function(){

// untuk memunculkan jumlah kas secara otomatis
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
  
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  

</script>




 <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){
    var kode_barang = $(this).attr("data-kode-barang");
    var no_faktur = $(this).attr("data-faktur");
    var id = $(this).attr("data-id");
    $("#hapus_faktur").val(no_faktur);
    $("#hapus_kode").val(kode_barang);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
    
    $("#btn_jadi_hapus").click(function(){
    
    var id = $("#id_hapus").val();
    var kode_barang = $("#hapus_kode").val();
    var no_faktur = $("#hapus_faktur").val();
    $.post("hapus_tbs_retur_penjualan.php",{id:id,kode_barang:kode_barang,no_faktur:no_faktur},function(data){
    if (data != "") {
      $(".tr-id-"+id).remove();

    $("#modal_hapus").modal('hide');
    
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


//end fungsi hapus data
</script>

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){


    var no_faktur_retur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();
    var no_faktur_penjualan = $("#no_faktur2").val();

    $.post('cek_kode_barang_edit_tbs_retur_penjualan.php',{kode_barang:kode_barang,no_faktur_retur:no_faktur_retur,no_faktur_penjualan:no_faktur_penjualan}, function(data){
    
    if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
    }//penutup if
    
    });////penutup function(data)


      $.getJSON('lihat_retur_penjualan.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
                $('#nama_barang').val('');
                $('#jumlahbarang').val('');
                $('#satuan_produk').val('');
                $('#harga_produk').val('');
                $('#no_faktur2').val('');
                $('#sisabarang').val('');
      }





      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#jumlahbarang').val(json.jumlah_barang);
        $('#satuan_produk').val(json.satuan);
        $('#harga_produk').val(json.harga);
        $('#no_faktur2').val(json.no_faktur);
        $('#sisabarang').val(json.sisa);
      }
                                              
        });
        
        });
        });

      
      
</script>

<script>

$(document).ready(function(){
    $(".container").hover(function(){

      var tanggal = $("#tanggal").val();

      $("#tanggal_hidden").val(tanggal);

    });
});

</script> 

  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur_retur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();
    var no_faktur_penjualan = $("#no_faktur2").val();

 $.post('cek_kode_barang_edit_tbs_retur_penjualan.php',{kode_barang:kode_barang,no_faktur_retur:no_faktur_retur,no_faktur_penjualan:no_faktur_penjualan}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

   $("#jumlah_barang").val(data);  
    });//penutup click(function()
  });//penutup ready(function()
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
                                    var no_faktur = $(this).attr("data-faktur");
                                    var no_faktur_jual = $(this).attr("data-faktur-jual");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_retur = $("#text-jumlah-"+id+"").text();

                                    if (jumlah_baru == "") {
                                      jumlah_baru = 0;
                                    }
                                    var satuan = $(this).attr("data-satuan");

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                   
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));

                                    var subtotal = parseInt(harga,10) * parseInt(jumlah_baru,10) - parseInt(potongan,10);
                                    
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
                                    
                                    subtotal_penjualan = parseInt(subtotal_penjualan,10) - parseInt(subtotal_lama,10) + parseInt(subtotal,10);

                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = tax_tbs * subtotal / 100;

                                    if (jumlah_baru == 0) {
                                      alert ("Jumlah Retur Tidak Boleh 0!");

                                      $("#input-jumlah-"+id+"").val(jumlah_retur);
                                       $("#text-jumlah-"+id+"").text(jumlah_retur);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    }

                                    else{

                                    $.post("cek_edit_stok_pesanan_barang_retur_penjualan.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru, no_faktur_jual:no_faktur_jual,satuan:satuan,no_faktur:no_faktur},function(data){

                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Transaksi Penjualan !");

                                        $("#input-jumlah-"+id+"").val(jumlah_retur);
                                        $("#text-jumlah-"+id+"").text(jumlah_retur);
                                        $("#text-jumlah-"+id+"").show();
                                        $("#input-jumlah-"+id+"").attr("type", "hidden");

                                     }

                                      else{

                                     $.post("update_pesanan_barang_retur_penjualan.php",{harga:harga,jumlah_retur:jumlah_retur,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,subtotal:subtotal},function(info){

                                  
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#total_retur_pembelian").val(tandaPemisahTitik(subtotal_penjualan)); 
                                    $("#total_retur_pembelian1").val(tandaPemisahTitik(subtotal_penjualan)); 



                                    });

                                   }

                                 });

                                  }
       
                                    $("#kode_barang").focus();

                                 });

                             </script>


<script type="text/javascript">
  
                                      $(".edit-jumlah-alert").dblclick(function(){

                                      var no_faktur = $(this).attr("data-faktur");
                                      var kode_barang = $(this).attr("data-kode");
                                      
                                      $.post('alert_edit_retur_penjualan.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
                                      
                                        $("#modal_alert").modal('show');
                                        $("#modal-alert").html(data);
              
                                      });
                                    });
</script>


<script type="text/javascript">
 
$(".btn-alert-hapus").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");

    $.post('alert_edit_retur_penjualan.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
    
 
    $("#modal_alert").modal('show');
    $("#modal-alert").html(data); 

});

  });
</script>

<script type="text/javascript">
  
  // untuk memunculkan sisa pembayaran secara otomatis
  $(document).ready(function(){
$("#pembayaran_pembelian").focus(function(){

        var potongan_pembelian =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_pembelian").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));
        var potongan_persen = ((potongan_pembelian / total) * 100);
        var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
        }

        if (potongan_pembelian != ""){
             $("#potongan_pembelian").attr("readonly", false);
              $("#potongan_persen").attr("readonly", true);

             }

        else{
              $("#potongan_persen").attr("readonly", true);
             $("#potongan_pembelian").attr("readonly", false);
             }

             
             var sisa_potongan = total - potongan_pembelian;
             
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);

        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_persen").val(parseInt(potongan_persen));



        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total_retur_pembelian1").val() ))));
        var potongan_rupiah = ((total * potongan_persen) / 100);
        var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
        }

        if (potongan_persen != ""){
              $("#potongan_persen").attr("readonly", false);
              $("#potongan_pembelian").attr("readonly", true);
             }

        else{
              $("#potongan_pembelian").attr("readonly", true);
              $("#potongan_persen").attr("readonly", false);
             }

      
             var sisa_potongan = total - potongan_rupiah;             
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total_retur_pembelian").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_pembelian").val(tandaPemisahTitik(parseInt(potongan_rupiah)));


        var potongan_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_pembelian").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val() ))));
       
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - potongan_rupiah;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_pembelian").val('');
                 $("#potongan_persen").val('');
              }
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10));
              
              
              $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }



        });
        });
      
</script>


<!-- cek stok satuan konversi change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_retur = $("#jumlah_retur").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      var no_faktur = $("#no_faktur2").val();
      var harga_lama = $("#harga_lama").val();

      $.post("cek_stok_konversi_retur_penjualan.php",
        {jumlah_retur:jumlah_retur,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk,no_faktur:no_faktur},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Transaksi Penjualan");
            $("#jumlah_retur").val('');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);
          }

      });
    });
  });
</script>
<!-- end cek stok satuan konversi change-->

<!-- cek stok satuan konversi keyup-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_retur").keyup(function(){
      var jumlah_retur = $("#jumlah_retur").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      var no_faktur = $("#no_faktur2").val();
      var harga_lama = $("#harga_lama").val();

      $.post("cek_stok_konversi_retur_penjualan.php",
        {jumlah_retur:jumlah_retur,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk,no_faktur:no_faktur},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Transaksi Penjualan");
            $("#jumlah_retur").val('');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);
          }

      });
    });
  });
</script>
<!-- cek stok satuan konversi keyup-->



<script>
$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      var harga_produk = $("#harga_lama").val();
      var jumlah_retur = $("#jumlah_retur").val();
      var kode_barang = $("#kode_barang").val();
      var satuan_pcs = $("#satuan_pcs").val();
      var harga_pcs = $("#harga_pcs").val();


      $.getJSON("cek_konversi_retur_penjualan.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi, id_produk:id_produk,harga_produk:harga_produk,jumlah_retur:jumlah_retur,harga_pcs:harga_pcs},function(info){

        if (satuan_konversi == satuan_pcs) {
          $("#harga_produk").val(harga_pcs);
          $("#harga_baru").val(harga_pcs);

        }
        else
        {

          if (satuan_konversi == prev) {
          
              $("#harga_produk").val(harga_lama);
              $("#harga_baru").val(harga_lama);


            }

            else if (info.jumlah_total == 0) {


             
              alert('Satuan Yang Anda Pilih Tidak Tersedia Untuk Produk Ini !');
              $("#satuan_konversi").val(prev);
              $("#harga_produk").val(harga_lama);
              $("#harga_baru").val(harga_lama);
            }

            else{
              $("#harga_produk").val(info.harga_pokok);
              $("#harga_baru").val(info.harga_pokok);
            }
        }
          

      });

        
    });

});
</script>



<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>

