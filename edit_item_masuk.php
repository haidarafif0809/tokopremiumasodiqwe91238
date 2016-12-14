<?php include 'session_login.php';

                              
                              //memasukkan file session login, header, navbar, db
                              include 'header.php';
                              include 'navbar.php';
                              include 'db.php';
                              include 'sanitasi.php';

                              $no_faktur = $_GET['no_faktur'];
                              
//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM item_masuk WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($perintah);                             


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
                              <div class="col-sm-8">
                              
                              <!-- membuat form menjadi beberpa bagian -->
                              <form enctype="multipart/form-data" role="form" action="proses_bayar_edit_item_masuk.php" method="post ">
                              
                              <!-- membuat teks dengan ukuran h3 -->
                              <h3> Edit Data Item Masuk </h3><br>
                              
                              <label> Tanggal </label><br>
                              <input type="text" value="<?php echo $ambil['tanggal']; ?>" name="tanggal" id="tanggal" placeholder="Tanggal"  class="form-control tgl" required="" >
                               <br>

                              <label> No Faktur </label><br>
                              
                              <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
                              <input type="text" name="no_faktur" id="nomorfaktur" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
                              
                              </form>
                              
                              
                              <!-- membuat tombol agar menampilkan modal -->
                              <button type="button" class="btn btn-info" id="cari_item_masuk" data-toggle="modal" data-target="#myModal"> <span class='glyphicon glyphicon-search'> </span> Cari</button>
                              <br><br>
                              <!-- Tampilan Modal -->
                              <div id="myModal" class="modal fade" role="dialog">
                              <div class="modal-dialog  modal-lg">
                              
                              <!-- Isi Modal-->
                              <div class="modal-content">
                              <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Data Barang</h4>
                              </div>
                              <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
                              
                              <span class="modal_baru">

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
                              <form class="form-inline" action="proses_edit_tbs_item_masuk.php" role="form" id="formtambahproduk">
                              
                              
                              <!-- agar tampilan berada pada satu group -->
                              <!-- memasukan teks pada kolom kode barang -->
                              <div class="form-group">
                              <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Produk">
                              </div>

                              <div class="form-group">
                              <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
                              </div>
                              

                              
                              <div class="form-group">
                              <input type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" placeholder="Jumlah Barang" autocomplete="off">
                              </div>
                              
                              <br><br>
                              <div class="form-group">
                              <input type="text" class="form-control" name="hpp_item_masuk" id="hpp_item_masuk" placeholder="Hpp Item Masuk" autocomplete="off">
                              </div>
                              
                              <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
                              <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
                              <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
                              <input type="hidden" name="no_faktur" id="nomorfaktur1" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
                              
                              
                              <!-- membuat tombol submit-->
                              <button type="submit" id="submit_produk" class="btn btn-success"> <span class='glyphicon glyphicon-plus'> </span>Tambah Produk</button>
                              </form>
                              
                              
                              </div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

                              
                              <br><br><br>
                              <div class="col-sm-4" id="col_sm_4">. <!--tag pembuka col sm 4-->
                              
                              <form action="proses_bayar_edit_item_masuk.php" id="form_item_masuk" method="POST"><!--tag pembuka form-->
                              
                              <label> Total </label><br>
                              <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
                              <input type="text" name="total" id="total_item_masuk" class="form-control" placeholder="Total" readonly=""  >
                              
                              
                              <label> Keterangan </label><br>
                              <textarea name="keterangan" id="keterangan" class="form-control" ></textarea> 
                              
                              
                              <br>
                              
                              <input type="hidden" name="no_faktur" id="nomorfaktur" class="form-control" value="<?php echo $no_faktur; ?>">
                              <input type="hidden" name="tanggal" id="tanggal_hidden" class="form-control tgl" value="<?php echo $ambil['tanggal']; ?>" >
                              <!--membuat tombol submit bayar & Hutang-->
                              <button type="submit" id="pembayaran_item_masuk" class="btn btn-info"> <span class='glyphicon glyphicon-ok'> </span> Selesai </a> </button>
                              
                              
                              <!--membuaat link pada tombol batal-->
                              <a href='batal_item_masuk.php?no_faktur=<?php echo $no_faktur;?>' id='batal' class='btn btn-danger'><span class='glyphicon glyphicon-remove-sign'></span> Batal </a>

                              <a class="btn btn-primary" href="form_item_masuk.php" id="transaksi_baru" style="display: none"> Transaksi Baru</a>
                              
                              
                              </form><!--tag penutup form-->
                              
                              <div class="alert alert-success" id="alert_berhasil" style="display:none">
                              <strong>Success!</strong> Data Item Masuk Berhasil
                              </div>
                              </div><!-- end of col sm 4 -->
                              </div><!-- end of row -->


<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info!</span></h3>
      
      </div>

      <div class="modal-body">
      <span id="modal-alert">
       </span>


     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Penjualan atau Item Keluar</i></h6>
        <button type="button" class="btn btn-warning btn-close" data-dismiss="modal">Close</button>
      </div>
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
        <h4 class="modal-title">Konfirmasi Hapus Data Item Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Barang :</label>
     <input type="text" id="hapus_nama" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
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
        <h4 class="modal-title">Edit Data Item Masuk</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
                  <label> Jumlah Barang Baru </label> <br>
                  <input type="text" name="jumlah_baru" id="edit_jumlah" class="form-control" autocomplete="off" required="" >

                  <input type="hidden" name="jumlah_lama" id="edit_jumlah_lama" readonly="">

                  <input type="hidden" name="harga" id="edit_harga">

                  <input type="hidden" class="form-control" id="id_edit">
                              
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>

</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

</div>

  </div>
</div><!-- end of modal edit data  -->

                              
                              
                              <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                              <span id="result">  
                              
                              <div class="table-responsive">
                              <!--tag untuk membuat garis pada tabel-->     
                              <table id="tableuser" class="table table-bordered">
                              <thead>
                              <th> Nomor Faktur </th>
                              <th> Kode Barang </th>
                              <th> Nama Barang </th>
                              <th> Jumlah </th>
                              <th> Satuan </th>
                              <th> Harga </th>
                              <th> Subtotal </th>
                              
                              <th> Hapus </th>
                              
                              </thead>
                              
                              <tbody>
                              <?php
                              
                              //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                              $perintah = $db->query("SELECT * FROM tbs_item_masuk
                              WHERE no_faktur = '$no_faktur'");
                              
                              //menyimpan data sementara yang ada pada $perintah
                              
                              while ($data1 = mysqli_fetch_array($perintah))
                              {
                              //menampilkan data
                              echo "<tr class='tr-id-".$data1['id']."'>
                              <td>". $data1['no_faktur'] ."</td>
                              <td>". $data1['kode_barang'] ."</td>
                              <td>". $data1['nama_barang'] ."</td>";

                               $hpp_masuk = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$no_faktur' AND kode_barang = '$data1[kode_barang]' AND sisa != jumlah_kuantitas");
                               $row = mysqli_num_rows($hpp_masuk);

                               if ($row > 0) 
                               {
                                
                                 echo "<td class='edit-jumlah-alert' data-id='".$data1['id']."' data-kode='".$data1['kode_barang']."' data-faktur='".$data1['no_faktur']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' > </td>";
                               } 

                               else 
                               {

                                 echo "<td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-subtotal='". $data1['subtotal'] ."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."' > </td>";
                               }
                               

                              


                              echo"<td>". $data1['satuan'] ."</td>
                              <td>". rp($data1['harga']) ."</td>
                              <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>";
                              



                               if ($row > 0) 

                               {
                                echo"<td> <button class='btn btn-danger btn-alert' data-id='". $data1['id'] ."' data-faktur='". $data1['no_faktur'] ."' data-kode='". $data1['kode_barang'] ."' > <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
                               } 

                               else

                               {
                                echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-subtotal='". $data1['subtotal'] ."' data-nama-barang='". $data1['nama_barang'] ."' id='btn-hapus-".$data1['id']."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
                               }

                              echo"</tr>";
                              }
                              
                              //Untuk Memutuskan Koneksi Ke Database
                              
                              mysqli_close($db); 
                              ?>
                              </tbody>
                              
                              </table>
                              </div>
                              </span>
                              
                              <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                              
                              <span id="demo"> </span>

                              
                              </div><!-- end of container -->
                              
                              
                              <script>
                              //untuk menampilkan data tabel
                              $(document).ready(function(){
                              $('.table').dataTable();
                              });
                              
                              </script>
                              
                              <!--untuk memasukkan perintah java script-->
                              <script type="text/javascript">
                              
                              // jika dipilih, nim akan masuk ke input dan modal di tutup
                              $(document).on('click', '.pilih', function (e) {
                              document.getElementById("kode_barang").value = $(this).attr('data-kode');
                              document.getElementById("nama_barang").value = $(this).attr('nama-barang');
                              document.getElementById("satuan_produk").value = $(this).attr('satuan');
                              document.getElementById("harga_produk").value = $(this).attr('harga');
                              
                              
                              
                              $('#myModal').modal('hide');
                              });
                              
 
                              
                              
                              </script>
                              
                              
                              <script>
                              //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk

                              $("#submit_produk").click(function(){

                                    var kode_barang = $("#kode_barang").val();
                                    var satuan = $("#satuan_produk").val();
                                    var nama_barang = $("#nama_barang").val();
                                    var harga = $("#harga_produk").val();
                                    var no_faktur = $("#nomorfaktur").val();
                                    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
                                    var hpp_item_masuk = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#hpp_item_masuk").val()))));
                                    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
                              
                                        
                                        if (total == '') 
                                        {
                                        total = 0;
                                        }
                                        
                                        if (hpp_item_masuk == "") {
                                          harga = harga;
                                        }
                                        else{
                                          harga = hpp_item_masuk;
                                        }


                                        

                                        var sub_tbs = parseInt(harga,10) * parseInt(jumlah_barang,10);
                                        
                                        var subtotal = parseInt(total,10) + parseInt(sub_tbs,10);
                                        
                                        
                                        $("#kode_barang").val('');
                                        $("#nama_barang").val('');
                                        $("#jumlah_barang").val('');
                                        $("#hpp_item_masuk").val('');
                                        
                                    if (jumlah_barang == ""){
                                    alert("Jumlah Barang Harus Diisi");
                                    }
                                    else if (kode_barang == ""){
                                    alert("Kode Harus Diisi");
                                    }
                                    
                                    else
                                    {

                                      
                                      $("#total_item_masuk").val(tandaPemisahTitik(subtotal));

                                      
                                      $.post("proses_edit_tbs_item_masuk.php",{hpp_item_masuk:hpp_item_masuk,no_faktur:no_faktur,kode_barang:kode_barang,jumlah_barang:jumlah_barang,satuan:satuan,nama_barang:nama_barang,harga:harga},function(info) {
                                      

                                      $("#result").load('tabel_edit_item_masuk.php?no_faktur=<?php echo $no_faktur; ?>');
                                      $("#hpp_item_masuk").val('');
                                      $("#kode_barang").val('');
                                      $("#nama_barang").val('');
                                      $("#jumlah_barang").val('');
                                      
                                      });

                                    }
                              
                                      $("form").submit(function(){
                                      return false;
                                      });
                              
                              
                              
                                  });

                              
                              //menampilkan no urut faktur setelah tombol click di pilih
                              $("#cari_item_masuk").click(function() {
                              
                              //menyembunyikan notif berhasil
                              $("#alert_berhasil").hide();
                              /* Act on the event */
                              
                              $.get('modal_item_masuk_baru.php', function(data) {
                              
                              $(".modal_baru").html(data);
                              
                              
                              });
                              
                              });
                              
                              
                              </script>
                              
                              <script>
                              
                              
                              //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
                              $("#pembayaran_item_masuk").click(function(){
                              
                                    var total = $("#total_item_masuk").val();
                                    var keterangan = $("#keterangan").val();
                                    var no_faktur = $("#nomorfaktur").val();
                                    var tanggal = $("#tanggal").val();

                                    $("#keterangan").val('');
                                    $("#total_item_masuk").val('');
                              

                                    if (total == ""){
                                    alert("Tidak Ada Total Item Masuk");
                                    }

                                   
                                    else
                                    {

                                      $("#pembayaran_item_masuk").hide();
                                      $("#batal").hide();
                                      $("#transaksi_baru").show();


                              
                              $.post("proses_bayar_edit_item_masuk.php",{no_faktur:no_faktur,total:total,keterangan:keterangan,tanggal:tanggal},function(info) {
                              
                                  
                              $("#result").html(info);
                              $("#alert_berhasil").show();
                              $("#total_item_masuk").val('');
                              $("#keterangan").val('');
                              
                              
                              
                              
                              });

                                }
                              
                              // #result didapat dari tag span id=result
                              
                              //mengambil no_faktur pembelian agar berurutan
                              
                              $("#form_item_masuk").submit(function(){
                              return false;
                              });
                              });
                              
                              
                              
                              </script>
                              
                              
                              <script>

                              $(document).ready(function(){
                              $.post("cek_total_edit_item_masuk.php",
                              {
                              no_faktur: "<?php echo $no_faktur; ?>"
                              },
                              function(data){
                              $("#total_item_masuk"). val(data);
                              });
                              
                              });
                              
                              
                              </script>

                              
   <script type="text/javascript">
            $(document).ready(function(){


//fungsi hapus data 
            $(document).on('click', '.btn-hapus', function (e) {

            var nama_barang = $(this).attr("data-nama-barang");
            var id = $(this).attr("data-id");

            var sub_total = $(this).attr("data-subtotal");
            var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));

            if (total == '') 
              {
                total = 0;
              }
                                        
            else if (sub_total == '') {
                sub_total = 0;
              }

            
            
           
            
            var subtotal = parseInt(total,10) - parseInt(sub_total,10);

            $("#total_item_masuk").val(tandaPemisahTitik(subtotal))

            $.post("hapus_tbs_item_masuk.php",{id:id},function(data){

            if (data != "") {

            $(".tr-id-"+id).remove();
            
            }
            
            });

             });



            $('form').submit(function(){
            
            return false;
            });
            
            });
            

   </script>

   <script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){
        
        var no_faktur = $("#nomorfaktur").val();
        var kode_barang = $("#kode_barang").val();
        
        $.post('cek_kode_barang_edit_tbs_item_masuk.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
        
        if(data == 1){
        alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
        $("#kode_barang").val('');
        $("#nama_barang").val('');
        }//penutup if
        
        });////penutup function(data)


      $.getJSON('lihat_item_masuk.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#satuan_produk').val('');
        $('#harga_produk').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#satuan_produk').val(json.satuan);
        $('#harga_produk').val(json.harga_jual);
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
                                    
                                    $(".edit-jumlah").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-jumlah-"+id+"").hide();
                                    
                                    $("#input-jumlah-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    
                                    $(".input_jumlah").blur(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var harga = $(this).attr("data-harga");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
                                    var subtotal = harga * jumlah_baru;
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
                                    
                                    var total_akhir = parseInt(subtotal_penjualan) - parseInt(subtotal_lama) + parseInt(subtotal);
                                    
                                    $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));
                                    $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                                    
                                    $.post("update_jumlah_barang_tbs_item_masuk.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){
                                    

                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    
                                    
                                    });
                                    
                                    $("#kode_barang").focus();
                                    
                                    });
                                    
                                    </script>   
               
<script type="text/javascript">
 
$(".btn-alert").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");

    $.post('alert_edit_item_masuk.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
    
 
    $("#modal_alert").modal('show');
    $("#modal-alert").html(data); 

    });

});
</script>

<script type="text/javascript">

  $(".edit-jumlah-alert").dblclick(function(){
  
        var no_faktur = $(this).attr("data-faktur");
        var kode_barang = $(this).attr("data-kode");
                                      
      $.post('alert_edit_item_masuk.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
                                      
        $("#modal_alert").modal('show');
        $("#modal-alert").html(data);
              
      });
    });

</script>


  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_faktur = $("#nomorfaktur").val();
    var kode_barang = $("#kode_barang").val();

 $.post('cek_kode_barang_edit_tbs_item_masuk.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>       
                              <!-- memasukan file footer.php -->
 <?php include 'footer.php'; ?>