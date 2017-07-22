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
                            <label style="font-size: 20px"> Barcode </label>
                            <input type="text" placeholder="Barcode" name="barcode" id="barcode" class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label style="font-size: 20px"> Konversi </label>
                            <input type="text" placeholder="Konversi" name="konversi" id="konversi" class="form-control" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        </div>

                        <div class="form-group">
                            <label style="font-size: 20px"> Harga Pokok  </label>
                            <input type="text" placeholder="Harga Pokok" name="harga_pokok" id="harga_pokok" class="form-control" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        </div>

                        <div class="form-group">
                            <label style="font-size: 20px"> Harga Jual Konversi  </label>
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

  <input type="hidden" name="satuan_dasar" id="satuan_dasar" value="<?php echo $satuan; ?>" class="form-control" autocomplete="off" >


<div class="table-responsive">
<span id="span">
<table id="table-satuan" class="table table-bordered">
    <thead>
      <th> Barcode </th>
      <th> Satuan </th>
      <th> Konversi </th>
      <th> Harga Pokok </th>

      <th> Harga Jual Konversi </th>

      <th> Hapus </th>
    </thead>
  </table>
</span>
</div> <!-- responsive-->


                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ; color: red"><i> * Jika sudah ada transaksi, tidak bisa mengubah satuan konversi.</i></h6>

<br>
<a href='barang.php?kategori=semua&tipe=barang' class='btn btn-primary'> <i class="fa fa-save"></i> Simpan</a>

</div> <!-- tag penutup div container -->



<script type="text/javascript">
$(document).ready(function(){
    $('#table-satuan').DataTable().destroy();
                        var dataTable = $('#table-satuan').DataTable( {
                        "processing": true,
                        "serverSide": true,
                        "info":     true,
                        "language": {
                        "emptyTable":     "My Custom Message On Empty Table"},
                        "ajax":{
                          url :"datatable_satuan_konversi.php", // json datasource
                           "data": function ( d ) {
                              d.id_produk = $("#id_produk").val();
                              d.satuan_dasar = $("#satuan_dasar").val();
                              // d.custom = $('#myInput').val();
                              // etc
                          },
                              type: "post",  // method  , by default get
                          error: function(){  // error handling
                            $(".table-satuan").html("");
                            $("#table-satuan").append('<tbody class="tbody_lap"><tr><th colspan="3"></th></tr></tbody>');
                            $("#table-satuan_processing").css("display","none");
                            
                       
                          }
                        },
                          "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                          $(nRow).attr('class','tr-id-'+aData[6]);
                        },
                  
                  });
                  });
</script>




<script type="text/javascript">  
$(document).ready(function(){

//fungsi untuk menambahkan data
    $(document).on('click','#submit_tambah',function(e){
    var nama_satuan_konversi = $("#nama_satuan_konversi").val();
    var barcode = $("#barcode").val();
    var konversi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#konversi").val()))));
    var harga_pokok = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_pokok").val()))));
    var harga_jual_konversi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_jual_konversi").val()))));
    var id_produk = $("#id_produk").val();
    var kode_produk = $("#kode_produk").val();
    var satuan_dasar = $("#satuan_dasar").val();

    if (satuan_dasar == nama_satuan_konversi) {
        alert("Nama Satuan  Konversi Tidak bisa sama dengan Satuan Dasar ");
      $("#nama_satuan_konversi").focus();
    }
    else if (nama_satuan_konversi == ""){
      alert("Nama Satuan Konversi Harus Diisi");
      $("#nama_satuan_konversi").focus();
    }
  
    else if (konversi == ""){
      alert("JUmlah Konversi Harus Diisi");
      $("#konversi").focus()
    }
    else if (harga_pokok == ""){
      alert("Harga Pokok Harus Diisi");
      $("#harga_pokok").focus();
    }
    else if (harga_jual_konversi == ""){
      alert("Harga Jual Konversi Harus Diisi");
      $("#harga_jual_konversi").focus();
    }
    else{

    $.post('proses_tambah_satuan_konversi.php',{barcode:barcode,nama_satuan_konversi:nama_satuan_konversi,konversi:konversi,harga_pokok:harga_pokok,id_produk:id_produk,kode_produk:kode_produk,harga_jual_konversi:harga_jual_konversi},function(data){
    
    var table_satuan = $('#table-satuan').DataTable();
    table_satuan.draw();
    $("#nama_satuan_konversi").val('');
    $("#barcode").val('');
    $("#konversi").val('');
    $("#harga_pokok").val('');
    $("#harga_jual_konversi").val('')
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
$(document).on('click', '#btn-hapus', function (e) {

    var id = $(this).attr("data-id");
    var satuan = $(this).attr("data-satuan");

    var alert = confirm("Anda yakin mau menghapus "+satuan+" ?");

    if (alert == true) {

      $.post("hapus_satuan_konversi.php",{id:id},function(data){


      $(".tr-id-"+id).remove();
          
      });
    };
    
    });
// end fungsi hapus data


$(document).on('blur', '#barcode', function (e) {

    var barcode = $(this).val();

    if (barcode != '') {
      $.post("cek_barcode_satuan_konversi.php",{barcode:barcode},function(data){

          if (data == 1) {
            alert("Barcode yang anda masukan sudah ada!");
            $("#barcode").focus();
            $("#barcode").val('');
            };
      });

    };


    
    });
// end fungsi hapus data

            
});
</script>


                             <script type="text/javascript">
                             $(document).ready(function(){
                             // edit barcode
                                 $(document).on('dblclick','.edit_barcode',function(e){
                                    var id = $(this).attr("data-id");

                                    $("#text-barcode-"+id).hide();
                                    $("#input-barcode-"+id).attr("type", "text");

                                 });

                                $(document).on('blur','.input_barcode',function(e){
                                    var id = $(this).attr("data-id");
                                    var barcode_lama = $(this).attr("data-barcode");
                                    var barcode = $("#input-barcode-"+id).val();


                                    if (barcode == barcode_lama) {

                                                if (barcode_lama == '') {

                                                  $("#text-barcode-"+id).text('Tidak Ada barcode');
                                                  $("#text-barcode-"+id).show();
                                                  $("#input-barcode-"+id).attr('value','');
                                                  $("#input-barcode-"+id).attr("type", "hidden");
                                                }else{

                                                  $("#text-barcode-"+id).text(barcode_lama);
                                                  $("#text-barcode-"+id).show();
                                                  $("#input-barcode-"+id).val(barcode_lama);
                                                  $("#input-barcode-"+id).attr("type", "hidden");
                                                };
                                    }else{


                                          $.post("cek_barcode_satuan_konversi.php",{barcode:barcode},function(data){

                                              if (data == 1) {
                                                alert("Barcode yang anda masukan sudah ada!");
                                                $("#text-barcode-"+id).text(barcode_lama);
                                                $("#text-barcode-"+id).show();
                                                $("#input-barcode-"+id).val(barcode_lama);
                                                $("#input-barcode-"+id).attr("type", "hidden");
                                                $("#input-barcode-"+id).attr("data-barcode",barcode_lama);


                                                }else{

                                                    $.post("update_satuan_konveksi.php",{id:id, barcode:barcode,jenis_edit:"Barcode"},function(data){

                                                      if (barcode == '') {

                                                          $("#text-barcode-"+id).text('Tidak Ada Barcode');
                                                          $("#text-barcode-"+id).show();
                                                          $("#input-barcode-"+id).attr('value','');
                                                          $("#input-barcode-"+id).attr("type", "hidden");  
                                                          $("#input-barcode-"+id).attr("data-barcode",'');    
                                                      }else{
                                                          $("#text-barcode-"+id).text(barcode);
                                                          $("#text-barcode-"+id).show();
                                                          $("#input-barcode-"+id).val(barcode);
                                                          $("#input-barcode-"+id).attr("type", "hidden");  
                                                          $("#input-barcode-"+id).attr("data-barcode",barcode);    
                                                      };

   

                                                    });

                                                };
                                          });

                                    }


                                 });



                             // edit barcode
                                 
                                 $(document).on('dblclick','.edit-satuan',function(e){

                                    var id = $(this).attr("data-id");
                                    var nama = $(this).attr("data-nama");
                                    var satuan = $(this).attr("data-satuan");

                                    $("#text-satuan-"+id+"").hide();

                                    $.getJSON("cek_data_satuan.php", function(result){

                                            $("#option_satuan-"+id).remove();
                                            var option_barang = "<option id='option_satuan-"+id+"' value='"+satuan+"' data-nama='"+nama+"'>"+nama+"</option>"
                                            $("#select-satuan-"+id).show().append(option_barang);

                                            $.each(result.satuan, function(i, item) {//  $.each(result.barang, 
                                              
                                            $("#option_satuan-"+result.satuan[i].id).remove();
                                            var option_barang = "<option id='option_satuan-"+result.satuan[i].id+"' value='"+result.satuan[i].id+"' data-nama='"+result.satuan[i].nama+"'>"+result.satuan[i].nama+"</option>"
                                            $("#select-satuan-"+id).show().append(option_barang);

                                        });//  $.each(result.barang, 
                                              
                                    });

                                 });

                                 $(document).on('blur','.select-satuan',function(e){

                                    var id = $(this).attr("data-id");

                                    var select_satuan = $("#select-satuan-"+id).val();
                                    var nama_satuan = $("#option_satuan-"+select_satuan).attr("data-nama");


                                    $.post("update_satuan_konveksi.php",{id:id, select_satuan:select_satuan,jenis_edit:"satuan"},function(data){

                                    $("#text-satuan-"+id).show();
                                    $("#text-satuan-"+id).text(nama_satuan);
                                    $("#select-satuan-"+id).hide();  
                                    $(".edit-satuan").attr("data-nama", nama_satuan);          

                                    });
                                 });
                              })
                             </script>

                             <script type="text/javascript">
                             $(document).ready(function(){
                             // edit konversi
                                 $(document).on('dblclick','.edit-konversi',function(e){
                                    var id = $(this).attr("data-id");

                                    $("#text-konversi-"+id).hide();
                                    $("#input-konversi-"+id).attr("type", "text");

                                 });

                                $(document).on('blur','.input_konversi',function(e){
                                    var id = $(this).attr("data-id");
                                    var konversi_lama = $(this).attr("data-konversi");
                                    var satuan_dasar = $(this).attr("data-satuan-dasar");
                                    var konversi = $("#input-konversi-"+id).val();
                                    var konversi_satuan = konversi + " " + satuan_dasar;

                                    if (konversi == konversi_lama) {

                                                $("#text-konversi-"+id).text(konversi_lama +" "+ satuan_dasar);
                                                $("#text-konversi-"+id).show();
                                                $("#input-konversi-"+id).val(konversi_lama);
                                                $("#input-konversi-"+id).attr("type", "hidden");
                                    }else{

                                                  $.post("update_satuan_konveksi.php",{id:id, konversi:konversi,jenis_edit:"Konversi"},function(data){

                                                  $("#text-konversi-"+id).text(konversi_satuan);
                                                  $("#text-konversi-"+id).show();
                                                  $("#input-konversi-"+id).val(konversi);
                                                  $("#input-konversi-"+id).attr("type", "hidden");  
                                                  $("#input-konversi-"+id).attr("data-konversi",konversi);       

                                                    });
                                          
                                    }


                                 });                              


                             // edit konversi


                             // edit harga_pokok
                                 $(document).on('dblclick','.edit-harga_pokok',function(e){
                                    var id = $(this).attr("data-id");

                                    $("#text-harga_pokok-"+id).hide();
                                    $("#input-harga_pokok-"+id).attr("type", "text");

                                 });

                                $(document).on('blur','.input_harga_pokok',function(e){
                                    var id = $(this).attr("data-id");
                                    var harga_pokok_lama = $(this).attr("data-harga_pokok");
                                    var harga_pokok = $("#input-harga_pokok-"+id).val();

                                    if (harga_pokok == harga_pokok_lama) {

                                                $("#text-harga_pokok-"+id).text(harga_pokok_lama);
                                                $("#text-harga_pokok-"+id).show();
                                                $("#input-harga_pokok-"+id).val(harga_pokok_lama);
                                                $("#input-harga_pokok-"+id).attr("type", "hidden");
                                    }else{

                                                  $.post("update_satuan_konveksi.php",{id:id, harga_pokok:harga_pokok,jenis_edit:"harga_pokok"},function(data){

                                                  $("#text-harga_pokok-"+id).text(harga_pokok);
                                                  $("#text-harga_pokok-"+id).show();
                                                  $("#input-harga_pokok-"+id).val(harga_pokok);
                                                  $("#input-harga_pokok-"+id).attr("type", "hidden");  
                                                  $("#input-harga_pokok-"+id).attr("data-harga_pokok",harga_pokok);       

                                                    });
                                          
                                    }


                                 });                              


                             // edit harga pokok
                             

                                                    // edit harga_pokok
                                 $(document).on('dblclick','.edit-harga_jual',function(e){
                                    var id = $(this).attr("data-id");

                                    $("#text-harga_jual-"+id).hide();
                                    $("#input-harga_jual-"+id).attr("type", "text");

                                 });

                                $(document).on('blur','.input_harga_jual',function(e){
                                    var id = $(this).attr("data-id");
                                    var harga_jual_lama = $(this).attr("data-harga_jual");
                                    var harga_jual = $("#input-harga_jual-"+id).val();

                                    if (harga_jual == harga_jual_lama) {

                                                $("#text-harga_jual-"+id).text(harga_jual_lama);
                                                $("#text-harga_jual-"+id).show();
                                                $("#input-harga_jual-"+id).val(harga_jual_lama);
                                                $("#input-harga_jual-"+id).attr("type", "hidden");
                                    }else{

                                                  $.post("update_satuan_konveksi.php",{id:id, harga_jual:harga_jual,jenis_edit:"harga_jual"},function(data){

                                                  $("#text-harga_jual-"+id).text(harga_jual);
                                                  $("#text-harga_jual-"+id).show();
                                                  $("#input-harga_jual-"+id).val(harga_jual);
                                                  $("#input-harga_jual-"+id).attr("type", "hidden");  
                                                  $("#input-harga_jual-"+id).attr("data-harga_jual",harga_jual);       

                                                    });
                                          
                                    }


                                 });                              


                             // edit harga pokok

                            });

                             </script>

<!--                             <script type="text/javascript">
                                    
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

                             </script>-->



<?php 
include 'footer.php';
 ?>