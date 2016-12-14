<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';
 include 'sanitasi.php';
 
 $session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);




//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(waktu_jurnal) as bulan FROM jurnal_trans ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT nomor_jurnal FROM jurnal_trans ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['nomor_jurnal'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$no_jurnal = "1/JR/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_jurnal = $nomor."/JR/".$data_bulan_terakhir."/".$tahun_terakhir;


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
    $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>





<div class="container">

<h3> <u>FORM TRANSAKSI JURNAL MANUAL </u> </h3>
<br>


<form role="form" method="post" id="formtambahproduk">
<div class="row">

					<div class="form-group col-sm-4">
					<label> Tanggal </label><br>
					<input type="text" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo date("Y/m/d"); ?>" class="form-control" required="" >
					</div>

					<input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >

          <div class="form-group col-sm-4">
          <label> Jenis </label><br>
          <input type="text" name="jenis" autocomplete="off" id="jenis" value="Jurnal Manual" class="form-control" readonly="">
          </div>

          <div class="form-group col-sm-4">
          <label> Keterangan </label><br>
          <input type="text" name="keterangan" autocomplete="off" id="keterangan" placeholder="Keterangan" class="form-control">
          </div>

</div> <!-- tag penutup div row -->

<div class="row">

              <div class="form-group col-sm-3">
          <label style="display: none;"> No. Transaksi </label><br>
          <input type="hidden" name="no_transaksi" id="no_transaksi" value="<?php echo $no_jurnal; ?>" class="form-control" readonly="" >
          </div>

          <div class="form-group col-sm-3">
          <label style="display: none;"> No. Ref </label><br>
          <input type="hidden" name="no_ref" id="no_ref" value="<?php echo $no_jurnal; ?>" class="form-control" readonly="" >
          </div>
</div> 


<div class="row">

					<div class="form-group col-sm-3">
					<label> Kode Akun </label><br>
					<select type="text" name="kode_akun" id="kode_akun" class="form-control chosen" >
					<option value="">--SILAHKAN PILIH--</option>

					 <?php 

    
    $query = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data['kode_daftar_akun']."'>".$data['kode_daftar_akun'] ." || ".$data['nama_daftar_akun']."</option>";
    }
    
    
    ?>
   					</select>
					</div>

          
          <div class="form-group col-sm-3">
          <label> Nama Akun </label><br>
          <input type="text" name="nama_akun" id="nama_akun" autocomplete="off" placeholder="Nama Akun" class="form-control"  readonly="">
          </div>


          <div class="form-group col-sm-3">
          <label> Debit </label><br>
          <input type="text" name="debit" id="debit" autocomplete="off" placeholder="Debit" class="form-control"  >
					</div>

          <div class="form-group col-sm-3">
          <label> Kredit </label><br>
          <input type="text" name="kredit" id="kredit" autocomplete="off" placeholder="Kredit" class="form-control"  >
          </div>

					
					
					
					
</div> <!-- tag penutup div row-->

</form>

          <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah </button>


<form action="proses_kas_masuk.php" id="form_submit" method="POST"><!--tag pembuka form-->
<style type="text/css">
	.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
}
</style>

      
  <!--membuat tombol submit bayar & Hutang-->
     
     

          </form><!--tag penutup form-->
  <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
  <div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Data Kas Masuk Berhasil
</div>

      <span id="result">  
      
        <div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->     
  <table id="tableuser" class="table table-hover">
    <thead>
      <th> Kode Akun </th>
      <th> Nama Akun </th>
      <th> Debit </th>      
      <th> Kredit </th>      
      <th> Hapus </th> 
      
    </thead>
    
    <tbody>
    <?php

    //menampilkan semua data yang ada pada tabel tbs kas masuk dalam DB
     $perintah = $db->query("SELECT * FROM tbs_jurnal WHERE session_id = '$session_id'");

      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {
        //menampilkan data
      echo "<tr class='tr-id-". $data1['id'] ."'>
      <td>". $data1['kode_akun_jurnal'] ."</td>
      <td>". $data1['nama_akun_jurnal'] ."</td>";

if ($data1['debit'] == 0) {
      echo "<td>". rp($data1['debit']) ."</td>   ";
} 

else {
       echo "<td class='edit-debit' data-id='".$data1['id']."'> <span id='text-debit-".$data1['id']."'> ". rp($data1['debit']) ." </span> <input type='hidden' id='input-debit-".$data1['id']."' value='".$data1['debit']."' class='input-debit' data-id='".$data1['id']."' data-debit='".$data1['debit']."' autofocus=''> </td>"; 
}

  
if ($data1['kredit'] == 0) {
      echo "<td>". rp($data1['kredit']) ."</td>   ";
} 

else {
       echo "<td class='edit-kredit' data-id='".$data1['id']."'> <span id='text-kredit-".$data1['id']."'> ". rp($data1['kredit']) ." </span> 
       <input type='hidden' id='input-kredit-".$data1['id']."' value='".$data1['kredit']."' class='input-kredit' data-id='".$data1['id']."' data-kredit='".$data1['kredit']."' autofocus=''> </td>   "; 
}

         

      echo "
      <td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-akun='". $data1['kode_akun_jurnal'] ."' data-nama='". $data1['nama_akun_jurnal'] ."' ><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>

      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
    ?>
    </tbody>

  </table>

  
  <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom Debit atau Kredit jika ingin mengedit.</i></h6>
  </div>
        </span>

<br>


<div class="row">

          <div class="form-group col-sm-6">
          </div>

          <div class="form-group col-sm-3">
          <label>Total Debit </label><br>
          <input type="text" name="t_debit" id="t_debit" autocomplete="off" placeholder="Total Debit" class="form-control" readonly="">
          </div>
          
          <div class="form-group col-sm-3">
          <label>Total Kredit </label><br>
          <input type="text" name="t_kredit" id="t_kredit" autocomplete="off" placeholder="Total Kredit" class="form-control" readonly="">
          </div>
          
</div>

          <div class="form-group col-sm-6">
          </div>

          <div class="form-group col-sm-3">

          <button type="submit" id="submit_jurnal_manual" class="btn btn-info"> <i class='fa fa-send'></i> Submit </a> </button>

          <a href="transaksi_jurnal_manual.php" style="display: none" class="btn btn-primary" id="transaksi_baru" > <i class='fa fa-refresh'></i> Transaksi Baru </a>
          
          </div>
</div> <!-- tag penutup div container -->


<script>

// untk menampilkan datatable atau filter seacrh
$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>

      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

<script>

  
        $(document).ready(function(){
        $("#kode_akun").change(function(){

          var kode_akun = $(this).val();
          
          $.getJSON('lihat_nama_akun.php',{kode_akun:$(this).val()}, function(json){
          
          if (json == null)
          {
          
          $('#nama_akun').val('');
          
          }
          
          else 
          {
          
          $('#nama_akun').val(json.nama_daftar_akun);
          }
                                              
        });

        });

        });


      
      
</script>


<script type="text/javascript">
      $(document).ready(function(){
//saat submit tambah diklik jika salah satu form ada yang tidak terisi maka akan muncul alert , jika sudah terisi semua maka akan masuk ke tabel yang di tuju
      $(document).on('click', '#submit_produk', function (e){
      var tanggal = $("#tanggal").val()
      var keterangan = $("#keterangan").val()
      var jenis = $("#jenis").val()
      var kode_akun = $("#kode_akun").val()
      var nama_akun = $("#nama_akun").val()
      var debit = bersihPemisah($("#debit").val());
      var kredit = bersihPemisah($("#kredit").val());
      var total_kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_kredit").val()))));
      var total_debit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_debit").val()))));
      var session_id = $("#session_id").val();
      var jenis = $("#jenis").val();
      var no_transaksi = $("#no_transaksi").val();
      
      if (total_kredit == '') 
        {
          total_kredit = 0;
        }
        else if(kredit == '')
        {
          kredit = 0;
        };
        var total_kredit_akhir = parseInt(total_kredit,10) + parseInt(kredit,10);

        if (total_debit == '') 
          {
            total_debit = 0;
          }
          else if(debit == '')
          {
            debit = 0;
          };

         var total_debit_akhir = parseInt(total_debit) + parseInt(debit);

          if (total_debit_akhir == '') 
          {
            total_debit_akhir = 0;
          }
          else if(total_kredit_akhir == '')
          {
            total_kredit_akhir = 0;
          };



if (nama_akun == "") {

alert('Nama Akun Masih Kosong');

}

else if(debit == "" & kredit == ""){

alert('Kolom Debit Atau Kredit Masih Kosong');

}
else{

  $("#t_kredit").val(tandaPemisahTitik(total_kredit_akhir))
  $("#t_debit").val(tandaPemisahTitik(total_debit_akhir))

  $.post("proses_tbs_jurnal_manual.php", {session_id:session_id, keterangan:keterangan,kode_akun:kode_akun,jenis:jenis,nama_akun:nama_akun,debit:debit,kredit:kredit}, function(info) {



       $("#result").load('tabel_jurnal_manual.php');
       $("#kode_akun").val('');
       $("#nama_akun").val('');
       $("#debit").val('');
       $("#kredit").val('');
       $("#keterangan").val('');



   });
}


      
     });

      $("form").submit(function() {
      /* Act on the event */
      return false;
      });
});
</script>

<script type="text/javascript">


   $("#submit_produk").click(function(){






      $("form").submit(function(){
      return false;
      });


  });

</script>


<script type="text/javascript">

        
        $(document).ready(function(){
                  var session_id = $("#session_id").val();
        
        $.post("cek_total_debit.php",
        {
        session_id: session_id
        },
        function(data){

        $("#t_debit").val(data);
        });



        $.post("cek_total_kredit.php",
        {
        session_id: session_id
        },
        function(data){

        $("#t_kredit").val(data);
        });

        $(".container").hover(function(){
        
        var session_id = $("#session_id").val();
        
        $.post("cek_total_debit.php",
        {
        session_id: session_id
        },
        function(data){

        $("#t_debit").val(data);
        });



        $.post("cek_total_kredit.php",
        {
        session_id: session_id
        },
        function(data){

        $("#t_kredit").val(data);
        });
        
        
        });
        
        });
</script>s





<script type="text/javascript">
  
$("#submit_jurnal_manual").click(function(){

    var session_id = $("#session_id").val();
    var keterangan = $("#keterangan").val();
    var kode_akun = $("#kode_akun").val();
    var nama_akun = $("#nama_akun").val();
    var jenis = $("#jenis").val();
    var debit = $("#debit").val();
    var kredit = $("#kredit").val();
    var no_transaksi = $("#no_transaksi").val();
    var no_ref = $("#no_ref").val();
    var tanggal = $("#tanggal").val();
    var t_debit = $("#t_debit").val();
    var t_kredit = $("#t_kredit").val();

if(t_debit != t_kredit){

alert('Kolom Total Debit dan Total Kredit Tidak Sama');

}
else{

  $("#submit_jurnal_manual").hide();
  $("#transaksi_baru").show();

  $.post("proses_selesai_jurnal_manual.php", {tanggal:tanggal,session_id:session_id,keterangan:keterangan,kode_akun:kode_akun,jenis:jenis,nama_akun:nama_akun,debit:debit,kredit:kredit,no_transaksi:no_transaksi,no_ref:no_ref,t_debit:t_debit,t_kredit:t_kredit}, function(info) {



       $("#result").load('tabel_jurnal_manual.php');
       $("#nama_akun").val('');
       $("#debit").val('');
       $("#kredit").val('');
       $("#t_debit").val('');
       $("#t_kredit").val('');

   });
}


      $("form").submit(function(){
    return false;
});
  

  });


</script>


<script type="text/javascript">

    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){

    
      var nama_akun_jurnal = $(this).attr("data-nama");
      var kode_akun_jurnal = $(this).attr("data-kode-akun");
      var id = $(this).attr("data-id");
      var debit = bersihPemisah($("#debit").val());
      var kredit = bersihPemisah($("#kredit").val());
      var total_kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_kredit").val()))));
      var total_debit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_debit").val()))));
    
        if (total_kredit == '') 
        {
          total_kredit = 0;
        }
        else if(kredit == '')
        {
          kredit = 0;
        };
        var total_kredit_akhir = parseInt(total_kredit,10) - parseInt(kredit,10);

        if (total_debit == '') 
          {
            total_debit = 0;
          }
          else if(debit == '')
          {
            debit = 0;
          };

         var total_debit_akhir = parseInt(total_debit) - parseInt(debit);

          if (total_debit_akhir == '') 
          {
            total_debit_akhir = 0;
          }
          else if(total_kredit_akhir == '')
          {
            total_kredit_akhir = 0;
          };


    $("#t_kredit").val(tandaPemisahTitik(total_kredit_akhir))
    $("#t_debit").val(tandaPemisahTitik(total_debit_akhir))

    $.post("hapus_jurnal_manual.php",{id:id,kode_akun_jurnal:kode_akun_jurnal},function(data){
    if (data == 'sukses') {
    
    
    $(".tr-id-"+id+"").remove();
    
    }
    });           
    
    });
                  $('form').submit(function(){
                  
                  return false;
                  });


    });
  
//end fungsi hapus data
</script>

      <script>
      

      $(document).ready(function(){
      $("#debit").keyup(function(){
      var debit = $("#debit").val();
      var kredit = $("#kredit").val();
             

             if (debit != ""){
             $("#kredit").attr("readonly", true);
             $("#kredit").val('0');
             }
             else{
              $("#kredit").attr("readonly", false);
              $("#kredit").val('');
             }


      });
      });

      $(document).ready(function(){
      $("#kredit").keyup(function(){
      var debit = $("#debit").val();
      var kredit = $("#kredit").val();
             

             if (kredit != ""){
             $("#debit").attr("readonly", true);
             $("#debit").val('0');
             }
             else{
              $("#debit").attr("readonly", false);
              $("#debit").val('');
             }

      });
      });


      $(document).ready(function(){
      $("#kode_akun").change(function(){


          var session_id = $("#session_id").val();
               
        $.post('cek_tbs_jurnal_manual.php',{kode_akun:$(this).val(), session_id:session_id}, function(data){
                
          if(data == 1){

                alert ("Akun Sudah Ada, Silakan pilih Akun lain.");
                $("#kode_akun").val('');
                $("#nama_akun").val('');
                $("#debit").attr("readonly", true);
                $("#kredit").attr("readonly", true);
            }
                
          else 
            {
              
              $("#debit").attr("readonly", false);
              $("#kredit").attr("readonly", false);
              
              $("#debit").val('');
              $("#kredit").val('');


            }
              
        });





      });
      });

</script>


                             <script type="text/javascript">
                                 
                                 $(".edit-debit").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-debit-"+id+"").hide();

                                    $("#input-debit-"+id+"").attr("type", "text");

                                 });

                                 $(".input-debit").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var debit_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-debit")))));
                                    var total_debit_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_debit").val()))));

                                    var input_debit = $(this).val();

                                    if (total_debit_lama == '') 
                                    {
                                    total_debit_lama = 0;
                                    }
                                    
                                    var total_debit_akhir = parseInt(total_debit_lama,10) - parseInt(debit_lama,10) + parseInt(input_debit,10);



                                    $.post("update_jurnal_manual.php",{id:id, input_debit:input_debit,jenis_edit:"debit"},function(data){

                                    $("#text-debit-"+id+"").show();
                                    $("#text-debit-"+id+"").text(input_debit);
                                    $("#t_debit").val(total_debit_akhir);
                                    $("#input-debit-"+id+"").attr("type", "hidden");           

                                    });

    

                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                 $(".edit-kredit").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-kredit-"+id+"").hide();

                                    $("#input-kredit-"+id+"").attr("type", "text");

                                 });

                                 $(".input-kredit").blur(function(){

                                    var id = $(this).attr("data-id");
                                    var kredit_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-kredit")))));
                                    var total_kredit_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#t_kredit").val()))));

                                    var input_kredit = $(this).val();

                                    if (total_kredit_lama == '') 
                                    {
                                    total_kredit_lama = 0;
                                    }
                                    
                                    var total_kredit_akhir = parseInt(total_kredit_lama,10) - parseInt(kredit_lama,10) + parseInt(input_kredit,10);



                                    $.post("update_jurnal_manual.php",{id:id, input_kredit:input_kredit,jenis_edit:"kredit"},function(data){

                                    $("#text-kredit-"+id+"").show();
                                    $("#text-kredit-"+id+"").text(input_kredit);
                                    $("#t_kredit").val(total_kredit_akhir);
                                    $("#input-kredit-"+id+"").attr("type", "hidden");           
                                    
                                    });
                                    


                                    });

                             </script>

<?php 
include 'footer.php';
 ?>

