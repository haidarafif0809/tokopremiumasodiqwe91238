<?php session_start();
 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $nomor_faktur = $_POST['no_faktur'];
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $satuan = $_POST['satuan'];
    $harga = $_POST['harga'];
    $potongan = $_POST['potongan'];
    $tax = $_POST['tax'];
    $subtotal = $harga * $jumlah_barang - $potongan;


    $tax = stringdoang($_POST['tax']);
    $satu = 1;

    $hasil_tax = $satu + ($tax / 100);

    $hasil_tax2 = $subtotal / $hasil_tax;

    $tax_jadi = $subtotal - $hasil_tax2;

    



    // menampilkan data yang ada dari tabel tbs_pembelian berdasarkan kode barang
    $cek = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$nomor_faktur'");

    // menyimpan data sementara berupa baris yang dijalankan dari $cek
    $jumlah = mysqli_num_rows($cek);
    
    // jika $jumlah >0 maka akan menjalakan perintah $query1 jika tidak maka akan menjalankan perintah $perintah
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->query("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + '$jumlah_barang', subtotal = subtotal + '$subtotal' WHERE kode_barang = '$kode_barang' AND no_faktur = '$nomor_faktur'");

    }

    else

    {
        $perintah = "INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax)VALUES ('$nomor_faktur','$kode_barang','$nama_barang','$jumlah_barang','$satuan','$harga','$subtotal','$potongan','$tax_jadi')";
        
        if ($db->query($perintah) === TRUE)
        {
        }
        else
        {
            echo "Error: " . $perintah . "<br>" . $db->error;
        }

    }


                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.id,tp.no_faktur,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$nomor_faktur' AND tp.kode_barang = '$kode_barang'");
                
                $data1 = mysqli_fetch_array($perintah);
                //menampilkan data
                echo "<tr class='tr-id-". $data1['id'] ." tr-kode-". $data1['kode_barang'] ."'>
                <td>". $data1['kode_barang'] ."</td>
                <td>". $data1['nama_barang'] ."</td>";

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]'");
$row_retur = mysqli_num_rows($pilih);

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$data1[no_faktur]'");
$row_piutang = mysqli_num_rows($pilih);

if ($row_retur > 0 || $row_piutang > 0) {

                echo"<td class='edit-jumlah-alert' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' > </td>";  

}
else {

  echo"<td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' > </td>";  

}

                echo"<td>". $data1['nama'] ."</td>
                <td>". rp($data1['harga']) ."</td>
                <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
                <td><span id='text-subtotal-".$data1['id']."'>". $data1['subtotal'] ."</span></td>";




if ($row_retur > 0 || $row_piutang > 0) {

      echo "<td> <button class='btn btn-danger btn-alert-hapus' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";

} 

else{
      echo "<td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

               

                
                echo"</tr>";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>


<script type="text/javascript">

//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){
    var nama_barang = $(this).attr("data-barang");
    var kode_barang = $(this).attr("data-kode-barang");
    var id = $(this).attr("data-id");
    
    $.post("hapus_edit_tbs_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
    
    $(".tr-id-"+id+"").remove();
    $("#kode_barang").focus();
    $("#pembayaran_penjualan").val('');

    
    
    });
    
                  $('form').submit(function(){
              
              return false;
              });

    });

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
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var potongan_persen = $("#potongan_persen").val();
                                    var no_faktur = $("#no_faktur0").val();

                                     var satuan_konversi = $(this).attr("data-satuan");

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));


                                    var subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;

                                    var diskon_rupiah = parseInt(subtotal_penjualan,10) * parseInt(potongan_persen,10) / 100;
                                    

                                    var total1_akhir = subtotal_penjualan - diskon_rupiah;
                                    
                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = tax_tbs * subtotal / 100;


                                    $.post("cek_stok_edit_penjualan.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi,no_faktur:no_faktur},function(data){

                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                       $("#input-jumlah-"+id+"").val(jumlah_lama);
                                       $("#text-jumlah-"+id+"").text(jumlah_lama);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");

                                     }

                                      else{

                                     $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){


                                    
                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));
                                    $("#potongan_penjualan").val(tandaPemisahTitik(diskon_rupiah));    
                                    $("#total1").val(tandaPemisahTitik(total1_akhir));         

                                    });

                                   }

                                 });


       
                                    $("#kode_barang").focus();
                                    

                                 });

                             </script>