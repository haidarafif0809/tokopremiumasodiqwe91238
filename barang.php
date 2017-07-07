<?php  include 'session_login.php';
    // memasukan file login, header, navbar, dan db.
    
    include 'header.php';
    include 'navbar.php';
    include 'sanitasi.php';
    include 'db.php';

$kategori = stringdoang($_GET['kategori']);
$tipe = stringdoang($_GET['tipe']); 
 


    ?>


<div class="container">
<h3><b>DATA ITEM</b></h3><hr>


<div class="row">
    <div class="col-sm-4">
        
<?php  

$pilih_akses_barang = $db->query("SELECT item_tambah ,item_hapus ,
item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_tambah = '1'");
$data_akses = mysqli_fetch_array($pilih_akses_barang);


    if ($data_akses['item_tambah'] > 0){

echo '<br><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> ITEM </button>   
    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#my_Modal"><i class="fa fa-upload"> </i> Import Data Excell</button>

    <a href="export_barang.php" style="width: 170px;" type="submit" id="btn-export" class="btn btn-danger"><i class="fa fa-download"> </i> Download Excel</a>
        ';
    }
?>
    </div>

    <div class="col-sm-8">
       

<?php  

        if ($tipe == 'barang') {
        
        echo "<ul class='nav nav-tabs md-pills pills-ins' role='tablist'>
        <li class='nav-item'><a class='nav-link active' href='barang.php?kategori=semua&tipe=barang'> Semua Item </a></li>";
        
        }
        
        else{
        echo "<ul class='nav nav-tabs md-pills pills-ins' role='tablist'>
        <li class='nav-item'><a class='nav-link active' href='barang.php?kategori=semua&tipe=barang_jasa'> Semua Item </a></li>";        
        }

    
          $pilih_kategori = $db->query("SELECT id,nama_kategori FROM kategori");
          
          while ($cek = mysqli_fetch_array($pilih_kategori)) 
          {
          

        if ($tipe == 'barang') {

          echo "<li class='nav-item'>
          <a class='nav-link active' href='barang.php?kategori=". $cek['id'] ."&tipe=barang' > ". $cek['nama_kategori'] ." </a>
          </li>";

        }

        else{
            echo "<li class='nav-item'>
          <a class='nav-link active' href='barang.php?kategori=". $cek['id'] ."&tipe=barang_jasa' > ". $cek['nama_kategori'] ." </a>
          </li>";
        }

         }


          echo "</ul>";

?> 
    </div>
</div>




    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Tambah Barang</h3>
                </div>
                <div class="modal-body">

                    <form enctype="multipart/form-data" role="form" action="prosesbarang.php" method="post">

                         <div class="form-group">
                            <label>Kode Barang </label>
                            <br>
                            <input type="text" placeholder="Kode Barang" name="kode_barang" id="kode_barang" class="form-control" autocomplete="off" required="">
                        </div>


                        <div class="form-group">
                            <label>Nama Barang </label>
                            <br>
                            <input type="text" placeholder="Nama Barang" name="nama_barang" id="nama_barang" class="form-control" autocomplete="off" required="">
                        </div>


                            <div class="form-group">
                            <label> Golongan Produk </label>
                            <br>
                            <select type="text" name="golongan_produk" class="form-control" required="">
                            <option value=""> -- SILAHKAN PILIH -- </option>
                            <option> Barang </option>
                            <option> Jasa </option>
                            </select>
                            </div>


                           

                                    <div class="form-group">
                                    <label> Kategori Produk </label>
                                    <br>
                                    <select type="text" name="kategori_obat" id="kategori_obat" class="form-control" required="">
                                    <option value=""> -- SILAHKAN PILIH -- </option>
                                    <?php 
                                    
                                    $ambil_kategori = $db->query("SELECT id,nama_kategori FROM kategori");
                                    
                                    while($data_kategori = mysqli_fetch_array($ambil_kategori))
                                    {
                                    
                                    echo "<option value='".$data_kategori['id']."'>".$data_kategori['nama_kategori'] ."</option>";
                                    
                                    }
                                    
                                    ?>
                                    </select>
                                    </div>


                        <div class="form-group">
                            <label> Harga Beli </label>
                            <br>
                            <input type="text" placeholder="Harga Beli" name="harga_beli" id="harga_beli" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 1</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 1" name="harga_jual" id="harga_jual" class="form-control" autocomplete="off" required="">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 2</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 2" name="harga_jual_2" id="harga_jual2" class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label> Harga Jual Level 3</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 3" name="harga_jual_3" id="harga_jual3" class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label> Harga Jual Level 4</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 4" name="harga_jual_4" id="harga_jual4" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 5</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 5" name="harga_jual_5" id="harga_jual5" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 6</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 6" name="harga_jual_6" id="harga_jual6" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Harga Jual Level 7</label>
                            <br>
                            <input type="text" placeholder="Harga Jual Level 7" name="harga_jual_7" id="harga_jual7" class="form-control" autocomplete="off">
                        </div>

                   <div class="form-group">
                            <label> Satuan </label>
                            <br>
                            <select type="text" name="satuan" class="form-control" required="">
                            <?php 
                            // memasukan file db.php
                           
                            // menampilkan seluruh data yang ada di tabel satuan
                            $query = $db->query("SELECT id,nama FROM satuan ");
                            
                            // menyimpan data sementara yang ada pada $query
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
                            }
                            
                            
                            ?>
                            </select>
                            </div>

                            

                        <div class="form-group" style="display: none">
                            <label> Gudang </label>
                            <br>
                            <select type="text" name="gudang" class="form-control" >
                            <option value=""> -- SILAHKAN PILIH -- </option>
                    
                            <?php 
                            
                            // memasukan file db.php
                     
                            // menampilkan seluruh data yang ada di tabel satuan
                            $query = $db->query("SELECT kode_gudang , nama_gudang FROM gudang ");
                            
                            // menyimpan data sementara yang ada pada $query
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
                            }
                            
                            
                            ?>
                            </select>
                            </div>

                            
                            <!-- label STATUS & SUPLIER berada pada satu form group -->
                            <div class="form-group">
                            <label> Status </label>
                            <br>
                            <select type="text" name="status" class="form-control" required="">
                            <option value=""> -- SILAHKAN PILIH -- </option>
                            <option> Aktif </option>
                            <option> Tidak Aktif</option>
                            </select>
                            </div>

                       




                            <div class="form-group">
                            <label> Suplier </label>
                            <br>
                            <select type="text" name="suplier" class="form-control">                            
                            <?php 
                  
                            
                            // menampilkan data yang ada pada tabel suplier
                            $query = $db->query("SELECT nama FROM suplier ");
                            
                            // menyimpan data sementara yang ada pada $query
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option>".$data['nama'] ."</option>";
                            }
                            
                            
                            ?>
                            </select>
                            </div>

                        <div class="form-group">
                            <label> Limit Stok </label>
                            <br>
                            <input type="text" placeholder="Limit Stok" name="limit_stok" id="limit_stok" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label> Over Stok </label>
                            <br>
                            <input type="text" placeholder="Over Stok" name="over_stok" id="over_stok" class="form-control" autocomplete="off">
                        </div>
                            
                            
                            
                            

                       


<!-- membuat tombol submit -->
<button type="submit" name="submit" value="submit" id="tambah" class="btn btn-info">Tambah</button>
</form>
</div>


<!--button penutup-->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


</div>

</div>
</div>


<div id="my_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Data Excell</h4>
      </div>

      <div class="modal-body">
   
   
   <form enctype="multipart/form-data" action="proses_import.php?" method="post" >
    <div class="form-group">
        <label> Import Data Excell</label><br>
        <input type="file" id="file_import" name="import_excell" required=""> 
        <br>
        

        <!-- membuat tombol submit -->
        
         
    </div>
   <button type="submit" name="submit" value="submit" class="btn btn-info">Import</button>
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

    <div class="modal-footer">

    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

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
        <h4 class="modal-title">Konfirmasi Hapus Data Barang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
        <label> Nama Barang :</label>
        <input type="text" id="data_barang" class="form-control" autocomplete="off" readonly=""> 
        <input type="hidden" id="id_hapus" class="form-control" > 
                <input type="hidden" id="kode_barang_hapus" class="form-control" > 

    </div>
    
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>
<input type="hidden" placeholder="" id="tipe" value="<?php echo $tipe; ?>"class="form-control" autocomplete="off">
<input type="hidden" placeholder="" id="kategori" value="<?php echo $kategori; ?>"class="form-control" autocomplete="off">
          <ul class="nav nav-tabs md-pills pills-ins" role="tablist">
          <?php if ($tipe == 'barang'): ?>

          <li class="nav-item"><a class="nav-link active" href='barang.php?kategori=semua&tipe=barang'> Umum </a></li>
          <li class="nav-item"><a class="nav-link" href='barang_2.php?kategori=semua&tipe=barang' > Lain - lain </a></li> 
          <?php else: ?>

          <li class="nav-item"><a class="nav-link active" href='barang.php?kategori=semua&tipe=barang_jasa'> Umum </a></li>
          <li class="nav-item"><a class="nav-link" href='barang_2.php?kategori=semua&tipe=barang_jasa' > Lain - lain </a></li> 
          <?php endif ?>
          
          
          
          </ul>
<!-- membuat table dan garis tabel-->
<div class="table-responsive">
          
<span id="table_baru">
    <table id="table_barang" class="table table-bordered table-sm">

        <!-- membuat nama kolom tabel -->
        <thead>
<?php  




    if ($data_akses['item_hapus'] > 0){

            echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";
        }
    ?>

<?php  


    if ($data_akses['item_edit'] > 0){
                            echo    "<th style='background-color: #4CAF50; color: white'> Edit </th>";

                        }
             ?>
            <th style='background-color: #4CAF50; color: white'> Kode Barang </th>
            <th style='background-color: #4CAF50; color: white'> Nama Barang </th>
            <th style='background-color: #4CAF50; color: white'> Harga Beli </th>
            <th style='background-color: #4CAF50; color: white'> Margin</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 1</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 2</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 3</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 4</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 5</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 6</th>
            <th style='background-color: #4CAF50; color: white'> Harga Jual Level 7</th>
            <th style='background-color: #4CAF50; color: white'> HPP</th>
            <th style='background-color: #4CAF50; color: white'> Jumlah Barang </th>
            <th style='background-color: #4CAF50; color: white'> Satuan </th>
            <th style='background-color: #4CAF50; color: white'> Satuan Konversi </th>
            <th style='background-color: #4CAF50; color: white'> Kategori </th>
            <!--
            <th> Gudang </th>
            -->
        
           </thead>

    </table>
</span>

</div> <!-- penutup table responsive -->

<?php 

        //perhitungan total hpp 
  
        
        $teks_hpp = 'Total Hpp' ;
 
        if ($kategori == 'semua') {

            $teks_hpp .= ' Keseluruhan';

            $hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total_hpp  FROM hpp_masuk");
            $data_hpp_masuk = mysqli_fetch_array($hpp_masuk);
                
            $hpp_keluar = $db->query("SELECT SUM(total_nilai) AS  total_hpp  FROM hpp_keluar");
            $data_hpp_keluar = mysqli_fetch_array($hpp_keluar);

            $total_hpp = $data_hpp_masuk['total_hpp'] - $data_hpp_keluar['total_hpp'];
        }
        else {
        
            $teks_hpp .= ' ' .$kategori ;

            $hpp_masuk = $db->query("SELECT SUM(hm.total_nilai) AS total_hpp  FROM hpp_masuk hm INNER JOIN barang b ON hm.kode_barang = b.kode_barang WHERE b.kategori = '$kategori'");
            $data_hpp_masuk = mysqli_fetch_array($hpp_masuk);
                
            $hpp_keluar = $db->query("SELECT SUM(hk.total_nilai) AS  total_hpp  FROM hpp_keluar hk INNER JOIN barang b ON hk.kode_barang = b.kode_barang WHERE b.kategori = '$kategori'");
            $data_hpp_keluar = mysqli_fetch_array($hpp_keluar);

            $total_hpp = $data_hpp_masuk['total_hpp'] - $data_hpp_keluar['total_hpp'];
        }


        
        //end perhitungan total hpp 
  
 ?>
<h3 style="color:red"><?php echo $teks_hpp ?> : <?php echo koma($total_hpp,2); ?></h3>

</div><!-- penutup tag div clas="container" -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#tipe_produk').change(function(){
            var tipe_produk = $('#tipe_produk').val();

            
             if(tipe_produk == 'Jasa')
             {
                $("#golongan_obat").attr("disabled", true);
                $("#kategori_obat").attr("disabled", true);
                $("#jenis_obat").attr("disabled", true);
                $("#harga_beli").attr("disabled", true);
                $("#limit_stok").attr("disabled", true);
                $("#over_stok").attr("disabled", true);
            }

            else{

                $("#golongan_obat").attr("disabled", false);
                $("#kategori_obat").attr("disabled", false);
                $("#jenis_obat").attr("disabled", false);
                $("#harga_beli").attr("disabled", false);
                $("#limit_stok").attr("disabled", false);
                $("#over_stok").attr("disabled", false);

            }
            
            
        });
        });
</script>

<script type="text/javascript">

               $(document).ready(function(){
               $("#kode_barang").blur(function(){
               var kode_barang = $("#kode_barang").val();

              $.post('cek_kode_barang.php',{kode_barang:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Kode Barang Sudah Ada");
                    $("#kode_barang").val('');
                }
                else {
                    
                }
              });
                
               });
               });

</script>

                             

                             <script type="text/javascript">
                                 
//fungsi hapus data 
                                $(document).on('click', '.btn-hapus', function (e) {
                                var nama = $(this).attr("data-nama");
                                var id = $(this).attr("data-id");
                                var kode = $(this).attr("data-kode");
                                $("#data_barang").val(nama);
                                $("#kode_barang_hapus").val(kode);
                                $("#id_hapus").val(id);
                                $("#modal_hapus").modal('show');
                                
                                });
                                
                                $("#btn_jadi_hapus").click(function(){
                                
                                var id = $("#id_hapus").val();
                                var kode = $("#kode_barang_hapus").val();

                                 $(".tr-id-"+id).remove();
                                $("#modal_hapus").modal('hide');
                                $.post("hapusbarang.php",{id:id,kode:kode},function(data){
                             
                                
                                });
                                
                                });
                        // end fungsi hapus data



                             </script>




<script type="text/javascript">
    $(document).ready(function(){
    // Tooltips Initialization
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    });
    });
</script>


<script type="text/javascript">
   $("#tambah").click(function(){

var harga_beli = $("#harga_beli").val();
var harga_jual1 = $("#harga_jual").val();
var harga_jual2 = $("#harga_jual2").val();
var harga_jual3 = $("#harga_jual3").val();
var harga_jual4 = $("#harga_jual4").val();
var harga_jual5 = $("#harga_jual5").val();
var harga_jual6 = $("#harga_jual6").val();
var harga_jual7 = $("#harga_jual7").val();


if (harga_jual1 < harga_beli)
{
    alert("Harga Jual 1 lebih kecil dari harga beli");
}

   
   });
</script>


                             <script type="text/javascript">
                                 
                                 $(document).on('dblclick', '.edit-beli', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-beli-"+id+"").hide();

                                    $("#input-beli-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_beli', function (e) {

                                    var id = $(this).attr("data-id");

                                    var input_beli = $(this).val();
                                    var input_bei_lama = $("#text-beli-"+id+"").text();
                                    var ber_stok = $(this).attr("data-berstok");
                                    var input_jual = $(this).attr("data-jual-1");
                                   

                                    if (input_jual < input_beli )
                                    {
                                        alert("Harga Beli lebih Besar dari Harga Jual 1");
                                    
                                    $("#input-beli-"+id+"").val(input_bei_lama);
                                    $("#text-beli-"+id+"").text(input_bei_lama);
                                    $("#text-beli-"+id+"").show();
                                    $("#input-beli-"+id+"").attr("type", "hidden");

                                    }
                                    else if (ber_stok == 'Jasa')
                                    {
                                        alert("Tipe Barang Jasa Tidak Bisa Edit Harga Beli");
                                        $("#input-beli-"+id+"").val(input_bei_lama);
                                    $("#text-beli-"+id+"").text(input_bei_lama);
                                    $("#text-beli-"+id+"").show();
                                    $("#input-beli-"+id+"").attr("type", "hidden");
                                    }
                                    
                                    else
                                    {
                                        // update barang 
                                    $.post("update_barang.php",{id:id, input_beli:input_beli,jenis_edit:"harga_beli"},function(data){

                                    $("#text-beli-"+id+"").show();
                                    $("#text-beli-"+id+"").text(input_beli);

                                    $("#input-beli-"+id+"").attr("type", "hidden");           

                                    });
                                    }// else update barang

                                 });

                             </script>



                             <script type="text/javascript">
                                 //edit harga jual 1
                                 $(document).on('dblclick', '.edit-jual', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-jual-"+id+"").hide();

                                    $("#input-jual-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_jual', function (e) {

                                    var id = $(this).attr("data-id");

                                    var input_jual = $(this).val();

                                    var input_beli = $(this).attr("data-beli");
                                    
                                    var input_jual_lama = $("#text-jual-"+id+"").text();

                                    if (input_jual < input_beli )
                                    {
                                        alert("Harga Jual 1 lebih Kecil dari Harga Beli ");
                                    
                                    $("#input-jual-"+id+"").val(input_jual_lama);
                                    $("#text-jual-"+id+"").text(input_jual_lama);
                                    $("#text-jual-"+id+"").show();
                                    $("#input-jual-"+id+"").attr("type", "hidden");

                                    }
                                    else
                                    {
                                    $.post("update_barang.php",{id:id, input_jual:input_jual,jenis_edit:"harga_jual"},function(data){

                                    $("#text-jual-"+id+"").show();
                                    $("#text-jual-"+id+"").text(input_jual);

                                    $("#input-jual-"+id+"").attr("type", "hidden");           

                                    });
                                     }// end else update barang
                                 });

                             </script>

                             <script type="text/javascript">
                                 //edit harga jual 2
                                 $(document).on('dblclick', '.edit-jual-2', function (e) {

                                    var id = $(this).attr("data-id-2");

                                    $("#text-jual-2-"+id+"").hide();

                                    $("#input-jual-2-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_jual_2', function (e) {

                                    var id = $(this).attr("data-id-2");

                                    var input_jual_2 = $(this).val();
                                    var input_beli = $(this).attr("data-beli");

                                    var input_jual_lama = $("#text-jual-2-"+id+"").text();


                                    if (input_jual_2 < input_beli )
                                    {
                                        alert("Harga Jual 2 lebih Kecil dari Harga Beli ");
                                        $("#input-jual-2-"+id+"").val(input_jual_lama);
                                    $("#text-jual-2-"+id+"").text(input_jual_lama);
                                    $("#text-jual-2-"+id+"").show();
                                    $("#input-jual-2-"+id+"").attr("type", "hidden");

                                    }
                                    else
                                    {

                                    $.post("update_barang.php",{id:id, input_jual_2:input_jual_2,jenis_edit:"harga_jual_2"},function(data){

                                    $("#text-jual-2-"+id+"").show();
                                    $("#text-jual-2-"+id+"").text(input_jual_2);

                                    $("#input-jual-2-"+id+"").attr("type", "hidden");           

                                    });
                                    }// end else update barang
                                 });

                             </script>

                            <script type="text/javascript">
                                 //edit harga jual 3
                                 $(document).on('dblclick', '.edit-jual-3', function (e) {

                                    var id = $(this).attr("data-id-3");

                                    $("#text-jual-3-"+id+"").hide();

                                    $("#input-jual-3-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_jual_3', function (e) {

                                    var id = $(this).attr("data-id-3");

                                    var input_jual_3 = $(this).val();

                                    var input_beli = $(this).attr("data-beli");

                                    var input_jual_lama = $("#text-jual-3-"+id+"").text();

                                    if (input_jual_3 < input_beli )
                                    {
                                        alert("Harga Jual 3 lebih Kecil dari Harga Beli ");
                                        $("#input-jual-3-"+id+"").val(input_jual_lama);
                                    $("#text-jual-3-"+id+"").text(input_jual_lama);
                                    $("#text-jual-3-"+id+"").show();
                                    $("#input-jual-3-"+id+"").attr("type", "hidden");

                                    }
                                    else
                                    {

                                    $.post("update_barang.php",{id:id, input_jual_3:input_jual_3,jenis_edit:"harga_jual_3"},function(data){

                                    $("#text-jual-3-"+id+"").show();
                                    $("#text-jual-3-"+id+"").text(input_jual_3);

                                    $("#input-jual-3-"+id+"").attr("type", "hidden");           

                                    });

                                    }// else update barang

                                 });

                             </script>

                             <script type="text/javascript">
                                 //edit harga jual 4
                                 $(document).on('dblclick', '.edit-jual-4', function (e) {

                                    var id = $(this).attr("data-id-4");

                                    $("#text-jual-4-"+id+"").hide();

                                    $("#input-jual-4-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_jual_4', function (e) {

                                    var id = $(this).attr("data-id-4");

                                    var input_jual_4 = $(this).val();
                                    var input_beli = $(this).attr("data-beli");
                                    var input_jual_lama = $("#text-jual-4-"+id+"").text();


                                    if (input_jual_4 < input_beli )
                                    {
                                        alert("Harga Jual 4 lebih Kecil dari Harga Beli ");
                                         $("#input-jual-4-"+id+"").val(input_jual_lama);
                                    $("#text-jual-4-"+id+"").text(input_jual_lama);
                                    $("#text-jual-4-"+id+"").show();
                                    $("#input-jual-4-"+id+"").attr("type", "hidden");

                                    }
                                    else
                                    {

                                    $.post("update_barang.php",{id:id, input_jual_4:input_jual_4,jenis_edit:"harga_jual_4"},function(data){

                                    $("#text-jual-4-"+id+"").show();
                                    $("#text-jual-4-"+id+"").text(input_jual_4);

                                    $("#input-jual-4-"+id+"").attr("type", "hidden");           

                                    });
                                    }//else udpate barang
                                 });
                             </script>

                             <script type="text/javascript">
                                 //edit harga jual 5
                                 $(document).on('dblclick', '.edit-jual-5', function (e) {

                                    var id = $(this).attr("data-id-5");

                                    $("#text-jual-5-"+id+"").hide();

                                    $("#input-jual-5-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_jual_5', function (e) {

                                    var id = $(this).attr("data-id-5");

                                    var input_jual_5 = $(this).val();
                                    var input_beli = $(this).attr("data-beli");
                                    var input_jual_lama = $("#text-jual-5-"+id+"").text();

                                    if (input_jual_5 < input_beli )
                                    {
                                        alert("Harga Jual 5 lebih Kecil dari Harga Beli ");
                                         $("#input-jual-5-"+id+"").val(input_jual_lama);
                                    $("#text-jual-5-"+id+"").text(input_jual_lama);
                                    $("#text-jual-5-"+id+"").show();
                                    $("#input-jual-5-"+id+"").attr("type", "hidden");

                                    }
                                    else
                                    {

                                    $.post("update_barang.php",{id:id, input_jual_5:input_jual_5,jenis_edit:"harga_jual_5"},function(data){

                                    $("#text-jual-5-"+id+"").show();
                                    $("#text-jual-5-"+id+"").text(input_jual_5);

                                    $("#input-jual-5-"+id+"").attr("type", "hidden");           

                                    });
                                    }//else update barang
                                 });
                             </script>

                             <script type="text/javascript">
                                 //edit harga jual 6
                                 $(document).on('dblclick', '.edit-jual-6', function (e) {

                                    var id = $(this).attr("data-id-6");

                                    $("#text-jual-6-"+id+"").hide();

                                    $("#input-jual-6-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_jual_6', function (e) {

                                    var id = $(this).attr("data-id-6");

                                    var input_jual_6 = $(this).val();
                                    var input_beli = $(this).attr("data-beli");
                                    var input_jual_lama = $("#text-jual-6-"+id+"").text();

                                    if (input_jual_6 < input_beli )
                                    {
                                        alert("Harga Jual 6 lebih Kecil dari Harga Beli ");
                                         $("#input-jual-6-"+id+"").val(input_jual_lama);
                                    $("#text-jual-6-"+id+"").text(input_jual_lama);
                                    $("#text-jual-6-"+id+"").show();
                                    $("#input-jual-6-"+id+"").attr("type", "hidden");

                                    }
                                    else
                                    {

                                    $.post("update_barang.php",{id:id, input_jual_6:input_jual_6,jenis_edit:"harga_jual_6"},function(data){

                                    $("#text-jual-6-"+id+"").show();
                                    $("#text-jual-6-"+id+"").text(input_jual_6);

                                    $("#input-jual-6-"+id+"").attr("type", "hidden");           

                                    });
                                    }// else update barang   
                                 });
                             </script>

                             <script type="text/javascript">
                                 //edit harga jual 7
                                 $(document).on('dblclick', '.edit-jual-7', function (e) {

                                    var id = $(this).attr("data-id-7");

                                    $("#text-jual-7-"+id+"").hide();

                                    $("#input-jual-7-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_jual_7', function (e) {

                                    var id = $(this).attr("data-id-7");

                                    var input_jual_7 = $(this).val();
                                    var input_beli = $(this).attr("data-beli");
                                    var input_jual_lama = $("#text-jual-7-"+id+"").text();

                                    if (input_jual_7 < input_beli )
                                    {
                                        alert("Harga Jual 7 lebih Kecil dari Harga Beli ");
                                         $("#input-jual-7-"+id+"").val(input_jual_lama);
                                    $("#text-jual-7-"+id+"").text(input_jual_lama);
                                    $("#text-jual-7-"+id+"").show();
                                    $("#input-jual-7-"+id+"").attr("type", "hidden");

                                    }
                                    else
                                    {

                                    $.post("update_barang.php",{id:id, input_jual_7:input_jual_7,jenis_edit:"harga_jual_7"},function(data){

                                    $("#text-jual-7-"+id+"").show();
                                    $("#text-jual-7-"+id+"").text(input_jual_7);

                                    $("#input-jual-7-"+id+"").attr("type", "hidden");           

                                    });
                                    }//else update barang
                                 });
                             </script>


                              <script type="text/javascript">
                                 
                                 $(document).on('dblclick', '.edit-kategori', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-kategori-"+id+"").hide();

                                    $("#select-kategori-"+id+"").show();

                                 });

                                 $(document).on('blur', '.select-kategori', function (e) {

                                    var id = $(this).attr("data-id");

                                    var select_kategori = $(this).val();


                                    $.post("update_barang.php",{id:id, select_kategori:select_kategori,jenis_edit:"kategori"},function(data){

                                    $("#text-kategori-"+id+"").show();
                                    $("#text-kategori-"+id+"").text(select_kategori);

                                    $("#select-kategori-"+id+"").hide();           

                                    });
                                 });

                             </script>


                              <script type="text/javascript">
                                 
                                 $(document).on('dblclick', '.edit-gudang', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-gudang-"+id+"").hide();

                                    $("#select-gudang-"+id+"").show();

                                 });

                                 $(document).on('blur', '.select-gudang', function (e) {

                                    var id = $(this).attr("data-id");

                                    var select_gudang = $(this).val();
                                    var nama_gudang = $(this).attr('');

                                    $.post("update_barang.php",{id:id, select_gudang:select_gudang,jenis_edit:"gudang"},function(data){

                                    $("#text-gudang-"+id+"").show();
                                    $("#text-gudang-"+id+"").text(select_gudang);

                                    $("#select-gudang-"+id+"").hide();           

                                    });
                                 });

                             </script>



         <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-satuan',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-satuan-"+id+"").hide();

                                    $("#select-satuan-"+id+"").show();

                                 });

                                $(document).on('blur','.select-satuan',function(e){

                                    var id = $(this).attr("data-id");

                                    var select_satuan = $(this).val();
                                    var kode_barang = $("#select-satuan-"+id).attr("data-kode");

                                    var nama_satuan = $("#nama-satuan-"+select_satuan).attr("data-nama");


                                    $.post("update_barang.php",{id:id, select_satuan:select_satuan,kode_barang:kode_barang,jenis_edit:"satuan"},function(data){

                                    $("#text-satuan-"+id+"").show();
                                    $("#text-satuan-"+id+"").text(nama_satuan);


                                    $("#select-satuan-"+id+"").hide();           

                                    });
                                 });

                             </script>



                             <script type="text/javascript">
                                 
                                 $(document).on('dblclick', '.edit-status', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-status-"+id+"").hide();

                                    $("#select-status-"+id+"").show();

                                 });

                                 $(document).on('blur', '.select-status', function (e) {

                                    var id = $(this).attr("data-id");

                                    var select_status = $(this).val();


                                    $.post("update_barang.php",{id:id, select_status:select_status,jenis_edit:"status"},function(data){

                                    $("#text-status-"+id+"").show();
                                    $("#text-status-"+id+"").text(select_status);

                                    $("#select-status-"+id+"").hide();           

                                    });
                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                $(document).on('dblclick', '.edit-berstok', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-berstok-"+id+"").hide();

                                    $("#select-berstok-"+id+"").show();

                                 });

                                 $(document).on('blur', '.select-berstok', function (e) {

                                    var id = $(this).attr("data-id");

                                    var select_berstok = $(this).val();


                                    $.post("update_barang.php",{id:id, select_berstok:select_berstok,jenis_edit:"berkaitan_dgn_stok"},function(data){

                                    $("#text-berstok-"+id+"").show();
                                    $("#text-berstok-"+id+"").text(select_berstok);

                                    $("#select-berstok-"+id+"").hide();           

                                    });
                                 });

                             </script>



                              <script type="text/javascript">
                                 
                                 $(document).on('dblclick', '.edit-suplier', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-suplier-"+id+"").hide();

                                    $("#select-suplier-"+id+"").show();

                                 });

                                 $(document).on('blur', '.select-suplier', function (e) {

                                    var id = $(this).attr("data-id");

                                    var select_suplier = $(this).val();


                                    $.post("update_barang.php",{id:id, select_suplier:select_suplier,jenis_edit:"suplier"},function(data){

                                    $("#text-suplier-"+id+"").show();
                                    $("#text-suplier-"+id+"").text(select_suplier);

                                    $("#select-suplier-"+id+"").hide();           

                                    });
                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                 $(document).on('dblclick', '.edit-limit', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-limit-"+id+"").hide();

                                    $("#input-limit-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_limit', function (e) {
                                    var id = $(this).attr("data-id");

                                    var input_limit = $(this).val();


                                    $.post("update_barang.php",{id:id, input_limit:input_limit,jenis_edit:"limit_stok"},function(data){

                                    $("#text-limit-"+id+"").show();
                                    $("#text-limit-"+id+"").text(input_limit);

                                    $("#input-limit-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                 
                                 $(document).on('dblclick', '.edit-over', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-over-"+id+"").hide();

                                    $("#input-over-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_over', function (e) {
                                    var id = $(this).attr("data-id");

                                    var input_over = $(this).val();


                                    $.post("update_barang.php",{id:id, input_over:input_over,jenis_edit:"over_stok"},function(data){

                                    $("#text-over-"+id+"").show();
                                    $("#text-over-"+id+"").text(input_over);

                                    $("#input-over-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>


                     <!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_barang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            "url" :"datatable_cari_barang.php", // json datasource
         "data": function ( d ) {
                
                d.tipe =  '<?php echo $tipe ?>' ;       
                d.kategori = '<?php echo $kategori; ?>';   
               
                // d.custom = $('#myInput').val();
                // etc
            },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_barang").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[18]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
            


<?php  include 'footer.php'; ?>