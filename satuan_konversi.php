<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';
 include 'sanitasi.php';

 $id_produk = angkadoang($_GET['id']);
 $satuan = stringdoang($_GET['satuan']);
 $harga_pokok = stringdoang($_GET['harga']);
 $kode_produk = stringdoang($_GET['kode_barang']);
 
 $select = $db->query("SELECT nama FROM satuan WHERE id = '$satuan' ");
 $ddd = mysqli_fetch_array($select);

 $satuan_konversi = $db->query("SELECT sk.id, sk.id_satuan, sk.id_produk, sk.konversi, sk.harga_pokok, sk.harga_jual_konversi, s.nama FROM satuan_konversi sk INNER JOIN satuan s ON sk.id_satuan = s.id WHERE sk.id_produk = '$id_produk'");



 ?>

 
<style type="text/css">
	.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
}
</style>



<div class="container">

<h3> <u> FORM SATUAN KONVERSI </u> </h3>
<br><br>





  <div class="row">
  
    <div class="form-group col-sm-3">
          <label style="font-size: 20px"> Satuan Dasar </label><br>
          <input type="text" name="satuan_dasar" id="satuan_dasar1" value="<?php echo $ddd['nama']; ?>" style="font-size: 20px" class="form-control" readonly="">
          <input type="hidden" name="satuan_dasar" id="satuan_dasar" value="<?php echo $satuan; ?>" style="font-size: 20px" class="form-control" readonly="">
    </div>
    
    <div class ="form-group col-sm-3">
          <label style="font-size: 20px"> Harga Pokok </label><br>
          <input type="text" name="harga_pokok_dasar" id="harga_pokok_dasar" value="<?php echo rp($harga_pokok); ?>" style="font-size: 20px" class="form-control" readonly="">
    </div>

    <div class="col-sm-6" style='color:red'>
      <div class="card card-block">
      <i>
      <p>**NOTE</p>
        <p>Isikan Data Satuan Produk/Item, contohnya : BOX, PACK.
        Konversi Satuan Dasar adalah Konversi terhadap Satuan Dasar, contoh :</p>
        <p>1 BOX = 20 PCS,
        1 PACK = 10 PCS</p>
        </i>
      </div>
    </div>
    </div>



<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> SATUAN KONVERSI</button>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">SATUAN KONVERSI</h3>
                </div>
                <div class="modal-body">

                    <form role="form">

                        <div class="form-group">
                            <label style="font-size: 20px"> Nama Satuan Konversi </label>
                            <br>
                            <select type="text" name="nama_satuan_konversi" id="nama_satuan_konversi" class="form-control"  required="" >
                            <option value=""> Silahkan Pilih </option>
                            <?php 
                            
                            
                            $query = $db->query("SELECT id, nama  FROM satuan");
                            while($data = mysqli_fetch_array($query))
                            {
                            
                            echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
                            }
                            
                            ?>
                            
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="font-size: 20px"> Konversi </label>
                            <br>
                            <input type="text" placeholder="Konversi" name="konversi" id="konversi" class="form-control" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        </div>

                        <div class="form-group">
                            <label style="font-size: 20px"> Harga Pokok  </label>
                            <br>
                            <input type="text" placeholder="Harga Pokok" name="harga_pokok" id="harga_pokok" class="form-control" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        </div>

                        <div style="display: none" class="form-group">
                            <label style="font-size: 20px"> Harga Jual Konversi  </label>
                            <br>
                            <input type="text" placeholder="Harga Jual Konversi" name="harga_jual_konversi" id="harga_jual_konversi" class="form-control" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="id_produk" id="id_produk" value="<?php echo $id_produk; ?>" class="form-control" autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="kode_produk" id="kode_produk" value="<?php echo $kode_produk; ?>" class="form-control" autocomplete="off" >
                        </div>




</form>


<!-- membuat tombol submit -->
<button type="submit" name="submit" value="submit" id="submit_tambah" class="btn btn-success">Submit</button>

</div>


<!--button penutup-->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


</div>

</div>
</div> <!-- / MYMODAL -->


<div class="table-responsive">
<span id="span">
<table id="tableuser" class="table table-bordered">
    <thead>
      <th> Satuan </th>
      <th> Konversi </th>
      <th> Harga Pokok </th>
      <!--
      <th> Harga Jual Konversi </th>
      -->
      <th> Hapus </th>
    </thead>
    
    <tbody id="tbody">
    <?php

    
    while ($data = mysqli_fetch_array($satuan_konversi))
    {

      $query2 = $db->query("SELECT id, nama FROM satuan");

      echo "<tr class='tr-id-".$data['id']."'>

      <td class='edit-satuan' data-id='".$data['id']."'><span id='text-satuan-".$data['id']."'>". $data['nama'] ."</span>
      <select style='display:none' id='select-satuan-".$data['id']."' value='".$data['id']."' class='select-satuan' data-id='".$data['id']."' autofocus=''>";

      echo '<option value="'. $data['id_satuan'] .'">'. $data['nama'] .'</option>';
      
      
      
      while($data2 = mysqli_fetch_array($query2))
      {
      
      echo '<option value="'. $data2['id'] .'">'. $data2['nama'] .'</option>';
      }
      
      
      echo  '</select>
      </td>';

      echo " <td class='edit-konversi' data-id='".$data['id']."'><span id='text-konversi-".$data['id']."'>". rp($data['konversi'])." ".$ddd['nama']."</span> <input type='hidden' id='input-konversi-".$data['id']."' value='".$data['konversi']."' class='input_konversi' data-id='".$data['id']."' autofocus=''> </td>

      <td class='edit-harga' data-id='".$data['id']."'><span id='text-harga-".$data['id']."'>". rp($data['harga_pokok']) ."</span> <input type='hidden' id='input-harga-".$data['id']."' value='".$data['harga_pokok']."' class='input_harga' data-id='".$data['id']."' autofocus=''> </td>";
/*
      <td class='edit-harga-jual' data-id='".$data['id']."'><span id='text-harga-jual-".$data['id']."'>". rp($data['harga_jual_konversi']) ."</span> <input type='hidden' id='input-harga-jual-".$data['id']."' value='".$data['harga_jual_konversi']."' class='input_harga_jual' data-id='".$data['id']."' autofocus=''> </td>

*/

      echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-satuan='". $data['id_satuan'] ."'> <i class='fa fa-trash'> </i> Hapus </button> </td>

      </tr>";

    }

    ?>
    </tbody>

  </table>
</span>
</div> <!-- responsive-->


                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ; color: red"><i> * Jika sudah ada transaksi, tidak bisa mengubah satuan konversi.</i></h6>

<br>
<a href='barang.php?kategori=semua&tipe=barang' class='btn btn-primary'> <i class="fa fa-save"></i> Simpan</a>

</div> <!-- tag penutup div container -->


<script>

$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>

<script type="text/javascript">
  
$(document).ready(function(){


//fungsi untuk menambahkan data
    $("#submit_tambah").click(function(){
    var nama_satuan_konversi = $("#nama_satuan_konversi").val();
    var konversi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#konversi").val()))));
    var harga_pokok = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_pokok").val()))));
    var harga_jual_konversi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_jual_konversi").val()))));
    var id_produk = $("#id_produk").val();
    var kode_produk = $("#kode_produk").val();

    $("#nama_satuan_konversi").val('');
    $("#konversi").val('');
    $("#harga_pokok").val('');

    if (nama_satuan_konversi == ""){
      alert("Nama Konversi Harus Diisi");
    }
    else if (konversi == ""){
      alert("Dari Satuan Harus Diisi");
    }
    else if (harga_pokok == ""){
      alert("Harga Pokok Harus Diisi");
    }
    else{

    $.post('proses_tambah_satuan_konversi.php',{nama_satuan_konversi:nama_satuan_konversi,konversi:konversi,harga_pokok:harga_pokok,id_produk:id_produk,kode_produk:kode_produk,harga_jual_konversi:harga_jual_konversi},function(data){

    $("#span").load('tabel_satuan_konversi.php?id_produk=<?php echo $id_produk; ?>;');
    $("#nama_satuan_konversi").val('');
    $("#konversi").val('');
    $("#harga_pokok").val('');
    $("#myModal").modal("hide");


    });
    }

    });
              $('form').submit(function(){
              
              return false;
              });


});

// end fungsi tambah data

</script>

<script type="text/javascript">
$(document).ready(function(){
  //fungsi hapus data 
$(document).on('click', '.btn-hapus', function (e) {

    var id = $(this).attr("data-id");

    $.post("hapus_satuan_konversi.php",{id:id},function(data){


    $(".tr-id-"+id+"").remove();
    


    
    });
    
    });
// end fungsi hapus data

            
});
</script>


                             <script type="text/javascript">
                                 
                                 $(".edit-satuan").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-satuan-"+id+"").hide();

                                    $("#select-satuan-"+id+"").show();

                                 });

                                 $(".select-satuan").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var select_satuan = $(this).val();


                                    $.post("update_satuan_konveksi.php",{id:id, select_satuan:select_satuan,jenis_select:"satuan"},function(data){

                                    $("#text-satuan-"+id+"").show();
                                    $("#text-satuan-"+id+"").text(select_satuan);

                                    $("#select-satuan-"+id+"").hide();           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                    
                                    $(".edit-konversi").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-konversi-"+id+"").hide();
                                    
                                    $("#input-konversi-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input_konversi").blur(function(){
                                    
                                    var id = $(this).attr("data-id");

                                    var input_konversi = $(this).val();


                                    $.post("update_konversi_satuan_konveksi.php",{id:id, input_konversi:input_konversi,jenis_edit:"konversi"},function(data){

                       
                                    $("#text-konversi-"+id+"").show();
                                    $("#text-konversi-"+id+"").text(input_konversi);

                                    $("#input-konversi-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                    
                                    $(".edit-harga").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-harga-"+id+"").hide();
                                    
                                    $("#input-harga-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input_harga").blur(function(){
                                    
                                    var id = $(this).attr("data-id");

                                    var input_harga = $(this).val();


                                    $.post("update_harga_satuan_konveksi.php",{id:id, input_harga:input_harga,jenis_edit:"harga"},function(data){

                               
                                    $("#text-harga-"+id+"").show();
                                    $("#text-harga-"+id+"").text(input_harga);

                                    $("#input-harga-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

                             <script type="text/javascript">
                                    
                                    $(".edit-harga-jual").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-harga-jual-"+id+"").hide();
                                    
                                    $("#input-harga-jual-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    $(".input_harga_jual").blur(function(){
                                    
                                    var id = $(this).attr("data-id");

                                    var input_harga_jual = $(this).val();


                                    $.post("update_harga_jual_konversi.php",{id:id, input_harga_jual:input_harga_jual,jenis_edit:"harga_jual"},function(data){

                                    $("#text-harga-jual-"+id+"").show();
                                    $("#text-harga-jual-"+id+"").text(input_harga_jual);

                                    $("#input-harga-jual-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>



<?php 
include 'footer.php';
 ?>