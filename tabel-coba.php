<?php 

    include 'db.php';
    include 'sanitasi.php';
    
 $nomor_faktur = $_GET['no_faktur'];


    ?>

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

  <script>
    // untuk memunculkan data tabel 
    $(document).ready(function(){
    $(".table").DataTable();
    
    
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

                                    });


                                    $("#kode_barang").focus();
                                    $("#pembayaran_pembelian").val("");

                                 });

                             </script>