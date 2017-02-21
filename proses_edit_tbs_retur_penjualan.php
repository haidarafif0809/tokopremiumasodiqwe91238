<?php 
// memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';

    $kode_barang = stringdoang($_POST['kode_barang']);    
    $harga = angkadoang($_POST['harga']);
    $no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
              
              $jumlah_retur = angkadoang($_POST['jumlah_retur']);              
              $potongan = angkadoang($_POST['potongan1']);
              $pajak = angkadoang($_POST['tax1']);

               $no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
               $nama_barang = stringdoang($_POST['nama_barang']);
               $harga = angkadoang($_POST['harga']);
               $satuan_jual = stringdoang($_POST['satuan_jual']);
               $satuan_produk = stringdoang($_POST['satuan_produk']);
              
              $a = $harga * $jumlah_retur;
              
              
              if(strpos($potongan, "%") !== false)
              {
              $potongan_jadi = $a * $potongan / 100;
              echo $potongan_tampil = $potongan_jadi;
              }
              else
              {
              
              $potongan_jadi = $potongan;
              echo $potongan_tampil = $potongan;
              }

              $satu = 1;
              $x = $a - $potongan_tampil;
              
              $hasil_tax = $satu + ($pajak / 100);
              
              $hasil_tax2 = $x / $hasil_tax;
              
              $tax_persen1 = $x - $hasil_tax2;
              
              $tax_persen = round($tax_persen1);
              
              $subtotal = $harga * $jumlah_retur - $potongan_jadi;

    
    $cek2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur_penjualan' AND kode_barang = '$kode_barang'");
    $data= mysqli_fetch_array($cek2); 

$konversi = $db->query("SELECT $data[jumlah_barang] / konversi AS jumlah_jual FROM satuan_konversi WHERE kode_produk = '$kode_barang' AND id_satuan = '$data[satuan]' ");
    $num_rows = mysqli_num_rows($konversi);
    $data_konversi = mysqli_fetch_array($konversi); 

if ($num_rows > 0 ){

  $jumlah_jual = $data_konversi['jumlah_jual'];
}
else{ 
  
  $jumlah_jual = $data['jumlah_barang'];
}

   $perintah = $db->prepare("INSERT INTO tbs_retur_penjualan (no_faktur_retur,no_faktur_penjualan,nama_barang,kode_barang,jumlah_beli,jumlah_retur,harga,subtotal,potongan,tax,satuan,satuan_jual) VALUES (?,?,?,?,'$jumlah_jual',?,?,?,?,?,?,?)");

   $perintah->bind_param("ssssiiiiiss",
    $no_faktur_retur, $no_faktur_penjualan, $nama_barang, $kode_barang, $jumlah_retur,$harga, $subtotal, $potongan_tampil, $tax_persen,$satuan_produk,$satuan_jual);

    $perintah->execute();

        
if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}

   

    //untuk menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
    $perintah = $db->query("SELECT tp.id, tp.no_faktur_penjualan, tp.no_faktur_retur, tp.nama_barang, tp.kode_barang, tp.jumlah_beli, tp.jumlah_retur, tp.satuan, tp.harga, tp.harga, tp.potongan, tp.tax, tp.subtotal, s.nama AS satuan_retur,ss.nama AS satuan_jual FROM tbs_retur_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id INNER JOIN satuan ss ON tp.satuan_jual = ss.id  WHERE tp.no_faktur_retur = '$no_faktur_retur' ORDER BY id DESC LIMIT 1");

    //menyimpan data sementara yang ada pada $perintah
      $data1 = mysqli_fetch_array($perintah);
                // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur_retur'] ."</td>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['kode_barang'] ."</td>
      <td>". rp($data1['jumlah_beli']) ."</td>
      <td>". $data1['satuan_jual'] ."</td>";


      $pilih = $db->query("SELECT no_faktur_hpp_masuk FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$data1[no_faktur_penjualan]' AND kode_barang = '$data1[kode_barang]'");
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


      //Untuk Memutuskan Koneksi Ke Database
      
      mysqli_close($db); 
    ?>

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
  });

</script>