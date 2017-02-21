<?php session_start();



include 'db.php';
include 'sanitasi.php';

$session_id = session_id();

//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM retur_penjualan");

 ?>
  <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Nomor Faktur Penjualan </th>
      <th> Nama Barang</th>
      <th> Kode Barang </th>
      <th> Jumlah Beli </th>
      <th> Jumlah Retur </th>
      <th> Harga </th>
      <th> Potongan </th>
      <th> Pajak </th>
      <th> Subtotal </th>
      <th> Hapus </th>
      
      
    </thead>
    
    <tbody>
     <?php

    //untuk menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
    $perintah = $db->query("SELECT * FROM tbs_retur_penjualan 
                WHERE session_id = '$session_id'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {

        // menampilkan data
      echo "<tr>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". rp($data1['jumlah_beli']) ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur_penjualan']."' data-kode='".$data1['kode_barang']."'> <span id='text-jumlah-".$data1['id']."'> ".$data1['jumlah_retur']." </span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_retur']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."'> </td>

      <td>". rp($data1['harga']) ."</td>
      <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
      <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
      <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>


      <td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur_penjualan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 



      </tr>";
      }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </tbody>

  </table>
<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>

 <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){
    var kode_barang = $(this).attr("data-kode-barang");
    var no_faktur = $(this).attr("data-faktur");
    var id = $(this).attr("data-id");
    $("#hapus_kode").val(kode_barang);
    $("#hapus_faktur").val(no_faktur);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
    
    $("#btn_jadi_hapus").click(function(){
    
    var id = $("#id_hapus").val();
    var kode_barang = $("#hapus_kode").val();
    var no_faktur = $("#hapus_faktur").val();
    $.post("hapus_tbs_retur_penjualan.php",{id:id,kode_barang:kode_barang,no_faktur:no_faktur},function(data){
    if (data != "") {

      $("#kode_barang").focus();

    $("#result").load('tabel_retur_penjualan.php');
    $("#modal_hapus").modal('hide');
    $("#cek_total_retur_penjualan").val('');
    
    }
    });
    
    
    });

//fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_retur = $(this).attr("data-jumlah-barang");
        var harga = $(this).attr("data-harga");
        var id  = $(this).attr("data-id");
        var kode_barang  = $(this).attr("kode-edit");
        var jumlah_beli  = $(this).attr("kode-jumlah");
        $("#harga_edit").val(harga);
        $("#barang_lama").val(jumlah_retur);
        $("#id_edit").val(id);
        $("#jumlah_edit").val(jumlah_beli);
        $("#kode_edit").val(kode_barang);
    
        });
        
        $("#submit_edit").click(function(){
        var jumlah_retur = $("#barang_lama").val();
        var jumlah_baru = $("#barang_edit").val();
        var harga = $("#harga_edit").val();
        var id = $("#id_edit").val();
        var jumlah_beli = $("#jumlah_edit").val();
        var kode_barang = $("#kode_edit").val();

        $.post("update_tbs_retur_penjualan.php",{id:id,jumlah_beli:jumlah_beli,jumlah_retur:jumlah_retur,jumlah_baru:jumlah_baru,harga:harga,kode_barang:kode_barang},function(data){

          $("#kode_barang").focus();
            
        $("#alert").html(data);
        $("#result").load('tabel_retur_penjualan.php');
        setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
        $("#cek_total_retur_penjualan").val('');
            
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
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_retur = $("#text-jumlah-"+id+"").text();

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                   
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));

                                    var subtotal = parseInt(harga,10) * parseInt(jumlah_baru,10) - parseInt(potongan,10);
                                    
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian").val()))));
                                    
                                    subtotal_penjualan = parseInt(subtotal_penjualan,10) - parseInt(subtotal_lama,10) + parseInt(subtotal,10);

                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = tax_tbs * subtotal / 100;


                                    $.post("cek_stok_pesanan_barang_retur_penjualan.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru, no_faktur:no_faktur},function(data){

                                       if (data == "ya") {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                       $(this).val($(".text-jumlah-"+id+"").text());

                                     }

                                      else{

                                     $.post("update_pesanan_barang_retur_penjualan.php",{harga:harga,jumlah_retur:jumlah_retur,jumlah_tax:jumlah_tax,potongan:potongan,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,subtotal:subtotal},function(info){

                                  
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#total_retur_pembelian").val(tandaPemisahTitik(subtotal_penjualan));         

                                    });

                                   }

                                 });


       
                                    $("#kode_barang").focus();

                                 });

                             </script>
