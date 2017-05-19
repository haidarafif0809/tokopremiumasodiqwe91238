<?php include_once 'session_login.php';
 

// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$kategori = $_GET['kategori'];

$pilih_akses_akun = $db->query("SELECT daftar_akun_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$daftar_akun = mysqli_fetch_array($pilih_akses_akun);

$pilih_akses_akun = $db->query("SELECT grup_akun_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$grup_akun = mysqli_fetch_array($pilih_akses_akun);

?>


<style>
  tr:nth-child(even){background-color: #f2f2f2}

  .padding-25{
    padding-left: 25px;
  }
  .padding-50{
    padding-left: 50px;
  }
  .padding-75{
    padding-left: 75px;
  }
</style>

<div class="container">

<h3><b>DATA DAFTAR AKUN</b></h3><hr>



<input type="hidden" name="kategori" id="kategori" class="form-control" value="<?php echo $kategori; ?>" readonly="">

    <ul class='nav nav-tabs yellow darken-4' role='tablist'>

       <?php if ($kategori == 'Aktiva'): ?>

        <li class='nav-item'><a class='nav-link active' href ='daftar_akun.php?kategori=Aktiva' >  Aktiva </a></li>
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Kewajiban' >  Kewajiban </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Modal' >  Modal </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan' >  Pendapatan </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=HPP' >  HPP </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya' >  Biaya </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan Lain' >  Pendapatan Lain </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya Lain' >  Biaya Lain </a></li>
        
       <?php endif ?>


       <?php if ($kategori == 'Kewajiban'): ?>
        
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Aktiva' >  Aktiva </a></li>
        <li class='nav-item'><a class='nav-link active' href ='daftar_akun.php?kategori=Kewajiban' >  Kewajiban </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Modal' >  Modal </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan' >  Pendapatan </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=HPP' >  HPP </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya' >  Biaya </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan Lain' >  Pendapatan Lain </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya Lain' >  Biaya Lain </a></li>
        
       <?php endif ?>


       <?php if ($kategori == 'Modal'): ?>
        
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Aktiva' >  Aktiva </a></li>
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Kewajiban' >  Kewajiban </a></li>
        <li class='nav-item'><a class='nav-link active' href='daftar_akun.php?kategori=Modal' >  Modal </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan' >  Pendapatan </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=HPP' >  HPP </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya' >  Biaya </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan Lain' >  Pendapatan Lain </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya Lain' >  Biaya Lain </a></li>
        
       <?php endif ?>


       <?php if ($kategori == 'Pendapatan'): ?>

        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Aktiva' >  Aktiva </a></li>
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Kewajiban' >  Kewajiban </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Modal' >  Modal </a></li>
        <li class='nav-item'><a class='nav-link active' href='daftar_akun.php?kategori=Pendapatan' >  Pendapatan </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=HPP' >  HPP </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya' >  Biaya </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan Lain' >  Pendapatan Lain </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya Lain' >  Biaya Lain </a></li>
        
       <?php endif ?>


       <?php if ($kategori == 'HPP'): ?>

        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Aktiva' >  Aktiva </a></li>
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Kewajiban' >  Kewajiban </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Modal' >  Modal </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan' >  Pendapatan </a></li>
        <li class='nav-item'><a class='nav-link active' href='daftar_akun.php?kategori=HPP' >  HPP </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya' >  Biaya </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan Lain' >  Pendapatan Lain </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya Lain' >  Biaya Lain </a></li>
        
       <?php endif ?>


       <?php if ($kategori == 'Biaya'): ?>

        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Aktiva' >  Aktiva </a></li>
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Kewajiban' >  Kewajiban </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Modal' >  Modal </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan' >  Pendapatan </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=HPP' >  HPP </a></li>
        <li class='nav-item'><a class='nav-link active' href='daftar_akun.php?kategori=Biaya' >  Biaya </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan Lain' >  Pendapatan Lain </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya Lain' >  Biaya Lain </a></li>
        
       <?php endif ?>


       <?php if ($kategori == 'Pendapatan Lain'): ?>

        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Aktiva' >  Aktiva </a></li>
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Kewajiban' >  Kewajiban </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Modal' >  Modal </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan' >  Pendapatan </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=HPP' >  HPP </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya' >  Biaya </a></li>
        <li class='nav-item'><a class='nav-link active' href='daftar_akun.php?kategori=Pendapatan Lain' >  Pendapatan Lain </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya Lain' >  Biaya Lain </a></li>
        
       <?php endif ?>


       <?php if ($kategori == 'Biaya Lain'): ?>

        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Aktiva' >  Aktiva </a></li>
        <li class='nav-item'><a class='nav-link' href ='daftar_akun.php?kategori=Kewajiban' >  Kewajiban </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Modal' >  Modal </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan' >  Pendapatan </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=HPP' >  HPP </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Biaya' >  Biaya </a></li>
        <li class='nav-item'><a class='nav-link' href='daftar_akun.php?kategori=Pendapatan Lain' >  Pendapatan Lain </a></li>
        <li class='nav-item'><a class='nav-link active' href='daftar_akun.php?kategori=Biaya Lain' >  Biaya Lain </a></li>
        
       <?php endif ?>
    </ul>

<br><br>
<?php 

if ($daftar_akun['daftar_akun_tambah'] > 0){
  echo '<a href="form_tambah_daftar_akun.php" class="btn btn-info"><i class="fa fa-plus"> </i> DAFTAR AKUN</a>';
}

if ($grup_akun['grup_akun_tambah'] > 0){
  echo '<a href="form_tambah_grup_akun.php" class="btn btn-primary"><i class="fa fa-plus"> </i> GROUP AKUN</a>';
}

?>

                <br><br>
                <span id="span_daftar_akun">            
                  <div class="table-responsive">
                    <table id="tabel_daftar_akun" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th style="background-color: #4CAF50; color:white"> Kode Akun  </th>
                              <th style="background-color: #4CAF50; color:white"> Nama AKun </th>
                              <th style="background-color: #4CAF50; color:white"> Kategori Akun </th>
                              <th style="background-color: #4CAF50; color:white"> Sub Akun </th>
                              <th style="background-color: #4CAF50; color:white"> Tipe Akun </th>

                              <th style="background-color: #4CAF50; color:white"> Hapus </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>
                </span>
                <h6 style="text-align: left ; color: red"><i><b> * Klik 2x Pada Kolom Jika Ingin Mengedit. </b></i></h6>

<script type="text/javascript">
  $(document).ready(function(){
    // Daftar Akun

      $('#tabel_daftar_akun').DataTable().destroy();
            var dataTable = $('#tabel_daftar_akun').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"datatable_daftar_akun.php", // json datasource
               "data": function ( d ) {
                  d.kategori = $("#kategori").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_daftar_akun").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    // EDIT KOLOM DAFTAR AKUN

    //NAMA AKUN
      $(document).on("dblclick",".edit-nama",function(){

          var id = $(this).attr("data-id");

          $("#text-nama-"+id+"").hide();

          $("#input-nama-"+id+"").attr("type", "text");

      });


      $(document).on("blur",".input_nama_akun",function(){

          var id = $(this).attr("data-id");

          var input_nama = $(this).val();

          $.post("update_daftar_akun.php",{id:id, input_nama:input_nama,jenis_select:"nama_daftar_akun"},function(data){

          $("#text-nama-"+id+"").show();
          $("#text-nama-"+id+"").text(input_nama);

          $("#input-nama-"+id+"").attr("type", "hidden");  

          var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
              tabel_daftar_akun.draw();         

          });
      });

    //PARENT
      $(document).on("dblclick",".edit-parent",function(){

          var id = $(this).attr("data-id");

          $("#text-parent-"+id+"").hide();

          $("#select-parent-"+id+"").show();

      });


      $(document).on("blur",".select-parent-akun",function(){

          var id = $(this).attr("data-id");

          var select_parent = $(this).val();

          $.post("update_daftar_akun.php",{id:id, select_parent:select_parent,jenis_select:"grup_akun"},function(data){

          $("#text-parent-"+id+"").show();
          $("#text-parent-"+id+"").text(select_parent);

          $("#select-parent-"+id+"").hide(); 

          var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
              tabel_daftar_akun.draw();         

          });
      });

    //KATEGORI AKUN
      $(document).on("dblclick",".edit-kategori-akun",function(){

          var id = $(this).attr("data-id");

          $("#text-kategori-"+id+"").hide();

          $("#select-kategori-"+id+"").show();

      });


      $(document).on("blur",".select-kategori-akun",function(){

          var id = $(this).attr("data-id");

          var select_kategori = $(this).val();

          $.post("update_daftar_akun.php",{id:id, select_kategori:select_kategori,jenis_select:"kategori_akun"},function(data){

          $("#text-kategori-"+id+"").show();
          $("#text-kategori-"+id+"").text(select_kategori);

          $("#select-kategori-"+id+"").hide(); 

          var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
              tabel_daftar_akun.draw();         

          });
      });

    //TIPE AKUN
      $(document).on("dblclick",".edit-tipe-akun",function(){

          var id = $(this).attr("data-id");

          $("#text-tipe-"+id+"").hide();

          $("#select-tipe-"+id+"").show();

      });


      $(document).on("blur",".select-tipe-akun",function(){

          var id = $(this).attr("data-id");

          var select_tipe = $(this).val();

          $.post("update_daftar_akun.php",{id:id, select_tipe:select_tipe,jenis_select:"tipe_akun"},function(data){

          $("#text-tipe-"+id+"").show();
          $("#text-tipe-"+id+"").text(select_tipe);

          $("#select-tipe-"+id+"").hide(); 

          var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
              tabel_daftar_akun.draw();         

          });
      });



// EDIT KOLOM GROUP AKUN

    //NAMA AKUN
      $(document).on("dblclick",".edit-nama",function(){

          var id = $(this).attr("data-id");

          $("#text-nama-"+id+"").hide();

          $("#input-nama-"+id+"").attr("type", "text");

      });


      $(document).on("blur",".input_nama",function(){

          var id = $(this).attr("data-id");

          var input_nama = $(this).val();

          $.post("update_grup_akun.php",{id:id, input_nama:input_nama,jenis_select:"nama_grup_akun"},function(data){

          $("#text-nama-"+id+"").show();
          $("#text-nama-"+id+"").text(input_nama);

          $("#input-nama-"+id+"").attr("type", "hidden");  

          var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
              tabel_daftar_akun.draw();         

          });
      });

    //PARENT
      $(document).on("dblclick",".edit-parent",function(){

          var id = $(this).attr("data-id");

          $("#text-parent-"+id+"").hide();

          $("#select-parent-"+id+"").show();

      });


      $(document).on("blur",".select-parent",function(){

          var id = $(this).attr("data-id");

          var select_parent = $(this).val();

          $.post("update_grup_akun.php",{id:id, select_parent:select_parent,jenis_select:"parent"},function(data){

          $("#text-parent-"+id+"").show();
          $("#text-parent-"+id+"").text(select_parent);

          $("#select-parent-"+id+"").hide(); 

          var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
              tabel_daftar_akun.draw();         

          });
      });

    //KATEGORI AKUN
      $(document).on("dblclick",".edit-kategori",function(){

          var id = $(this).attr("data-id");

          $("#text-kategori-"+id+"").hide();

          $("#select-kategori-"+id+"").show();

      });


      $(document).on("blur",".select-kategori",function(){

          var id = $(this).attr("data-id");

          var select_kategori = $(this).val();

          $.post("update_grup_akun.php",{id:id, select_kategori:select_kategori,jenis_select:"kategori_akun"},function(data){

          $("#text-kategori-"+id+"").show();
          $("#text-kategori-"+id+"").text(select_kategori);

          $("#select-kategori-"+id+"").hide(); 

          var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
              tabel_daftar_akun.draw();         

          });
      });

    //TIPE AKUN
      $(document).on("dblclick",".edit-tipe",function(){

          var id = $(this).attr("data-id");

          $("#text-tipe-"+id+"").hide();

          $("#select-tipe-"+id+"").show();

      });


      $(document).on("blur",".select-tipe",function(){

          var id = $(this).attr("data-id");

          var select_tipe = $(this).val();

          $.post("update_grup_akun.php",{id:id, select_tipe:select_tipe,jenis_select:"tipe_akun"},function(data){

          $("#text-tipe-"+id+"").show();
          $("#text-tipe-"+id+"").text(select_tipe);

          $("#select-tipe-"+id+"").hide(); 

          var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
              tabel_daftar_akun.draw();         

          });
      });

  });
</script>

<script type="text/javascript">

  $(document).ready(function(){

    //HAPUS DAFTAR AKUN
    $(document).on('click','.btn-hapus-akun',function(e){

      var kode_akun = $(this).attr("kode-akun");
      var nama_akun = $(this).attr("data-akun");
      var id = $(this).attr("data-id");

      var pesan_alert = confirm('Apakah Anda Yakin Ingin Menghapus Akun "'+nama_akun+'" ?');
      if (pesan_alert == true) {

                $.post("lihat_kode_akun.php",{kode_akun:kode_akun},function(data){

                  if (data > 0) {
                    alert('Anda Tidak Bisa Menghapus Akun "'+nama_akun+'". Karena Sudah Terpakai !');
                    var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
                        tabel_daftar_akun.draw(); 
                  }
                  else{
                    $.post("hapus_daftar_akun.php",{id:id},function(data){

                      var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
                        tabel_daftar_akun.draw();

                    });
                  }
              
              });
      }
      else{

      }
    });

    //HAPUS GROUP AKUN
    $(document).on('click','.btn-hapus',function(e){

      var kode_akun = $(this).attr("kode-akun");
      var nama_akun = $(this).attr("data-akun");
      var id = $(this).attr("data-id");

      var pesan_alert = confirm('Apakah Anda Yakin Ingin Menghapus Akun "'+nama_akun+'" ?');
      if (pesan_alert == true) {

                $.post("lihat_detail_akun.php",{kode_akun:kode_akun},function(data){

                  if (data > 0) {
                    alert('Anda Tidak Bisa Menghapus Akun "'+nama_akun+'". Karena Sudah Terpakai !');
                    var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
                        tabel_daftar_akun.draw(); 
                  }
                  else{
                    $.post("hapus_group_akun.php",{id:id},function(data){

                      var tabel_daftar_akun = $('#tabel_daftar_akun').DataTable();
                        tabel_daftar_akun.draw();

                    });
                  }
              
              });
      }
      else{

      }
    });
  });
</script>

<?php 
  include 'footer.php';
?>