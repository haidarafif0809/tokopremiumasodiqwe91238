<?php session_start(); 

    include 'sanitasi.php';
    include 'db.php';
    $session_id = session_id();
    //mengirim data sesuai dengan variabel denagn metode POST 
    $no_faktur = stringdoang($_POST['no_faktur']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $harga = angkadoang($_POST['harga']);
    $jumlah_barang = angkadoang($_POST['jumlah_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    echo $sales = stringdoang($_POST['sales']);
    $user = $_SESSION['nama'];
    $potongan = stringdoang($_POST['potongan']);
    $a = $harga * $jumlah_barang;$tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:s');
    $tahun_terakhir = substr($tahun_sekarang, 2);
    $ppn = stringdoang($_POST['ppn']);

    if ($potongan == '') {
      $potongan_jadi = 0;
      $potongan_tampil = 0;
    }
    else
    {
           if(strpos($potongan, "%") !== false)
          {
              $potongan_jadi = $a * $potongan / 100;
              $potongan_tampil = $potongan_jadi;
          }
          else{

             $potongan_jadi = $potongan;
             $potongan_tampil = $potongan;
          }
    }


    $tax = stringdoang($_POST['tax']);
    $subtotal = $harga * $jumlah_barang;
if ($ppn == 'Exclude') {
             $a = $harga * $jumlah_barang;

              
              $x = $a - $potongan_tampil;

              $hasil_tax = $x * ($tax / 100);

              $tax_persen = round($hasil_tax);
            }
            else{
                        $a = $harga * $jumlah_barang;

              $satu = 1;

              $x = $a - $potongan_tampil;

              $hasil_tax = $satu + ($tax / 100);

              $hasil_tax2 = $x / $hasil_tax;

              $tax_persen1 = $x - round($hasil_tax2);

              $tax_persen = round($tax_persen1);
            }



    if ($ppn == 'Exclude') {
  # code...

              $abc = $subtotal - $potongan_tampil;

              $hasil_tax411 = $abc * ($tax / 100);

              $subtotaljadi = $harga * $jumlah_barang - $potongan_tampil + round($hasil_tax411); 

}
else
{
  $subtotaljadi = $harga * $jumlah_barang - $potongan_tampil; 
}
//PPN END

    $query9 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];



    if ($prosentase != 0){
      
      $query90 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
      $cek01 = mysqli_num_rows($query90);

      $cek90 = mysqli_fetch_array($query90);
      $jumlah1 = $cek90['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $subtotal_prosentase = $harga * $jumlah0;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

      $komisi = $fee_prosentase_produk;

      if ($cek01 > 0) {
        $query91 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang' AND no_faktur = '$no_faktur'");
      }

      else
      {

          $subtotal_prosentase = $harga * $jumlah_barang;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

          $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_faktur) VALUES ('$sales', '$session_id',
            '$kode_barang','$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang',
            '$jam_sekarang','$no_faktur')");

      }
      
      



    }

    elseif ($nominal != 0) {

      $query900 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
      $cek011 = mysqli_num_rows($query900);

      $cek900 = mysqli_fetch_array($query900);
      $jumlah1 = $cek900['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $fee_nominal_produk = $nominal * $jumlah0;

      $komisi0 = $fee_nominal_produk;

      if ($cek011 > 0) {

        $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi0' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang' AND no_faktur = '$no_faktur'");
      }

      else
        {

      $fee_nominal_produk = $nominal * $jumlah_barang;

      $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_faktur) VALUES ('$sales','$session_id',
        '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang',
        '$jam_sekarang','$no_faktur')");
      }


    }

    else
    {

    }




$cek = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");

$jumlah = mysqli_num_rows($cek);

  
$cek = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");

$jumlah = mysqli_num_rows($cek);
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND no_faktur = ? ");

        $query1->bind_param("iisss",
            $jumlah_barang, $subtotal, $potongan_tampil, $kode_barang, $no_faktur);

            
            $jumlah_barang = angkadoang($_POST['jumlah_barang']);
            $kode_barang = stringdoang($_POST['kode_barang']);
            $tax = angkadoang($_POST['tax']);
            if ($tax == '') {
              $tax = 0;
            }
            $subtotal = $harga* $jumlah_barang - $potongan_jadi;

        $query1->execute();

    }
    else
    {
            $perintah = $db->prepare("INSERT INTO tbs_penjualan (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,tanggal,jam,no_faktur) VALUES (?,?,
            ?,?,?,?,?,?,?,?,?,?)");
            
            
            $perintah->bind_param("sssisiiissss",
            $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga,
            $subtotaljadi, $potongan_tampil, $tax_persen,$tanggal_sekarang,$jam_sekarang,
            $no_faktur);
            
            
            $kode_barang = stringdoang($_POST['kode_barang']);
            $jumlah_barang = angkadoang($_POST['jumlah_barang']); 
            $nama_barang = stringdoang($_POST['nama_barang']);
            $satuan = stringdoang($_POST['satuan']);
            $harga = angkadoang($_POST['harga']);
            $tax = angkadoang($_POST['tax']);
            if ($tax == '') {
              $tax = 0;
            }
            $subtotal = $harga * $jumlah_barang - $potongan_jadi;
            
            
            $perintah->execute();

    }



    ?>

    <?php
  //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$no_faktur' AND tp.kode_barang = '$kode_barang' AND tp.no_faktur_order IS NULL ");
                
                //menyimpan data sementara yang ada pada $perintah
                
               $data1 = mysqli_fetch_array($perintah);

                //menampilkan data
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td>". $data1['kode_barang'] ."</td>
                <td>". $data1['nama_barang'] ."</td>
                <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' > </td>
                <td>". $data1['nama'] ."</td>
                <td>". rp($data1['harga']) ."</td>
                <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>";

                echo "<td style='font-size:15px'> <button class='btn btn-danger btn-hapus-tbs' id='hapus-tbs-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."'>Hapus</button> </td> 

                </tr>";



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
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var ber_stok = $(this).attr("data-berstok");

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));
                                    var tax_fak = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                                    if (tax_fak == '')
                                    {
                                      tax_fak = 0;
                                    }

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                   

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;



                                     var potongan_persen = $("#potongan_persen").val();
                                      if (potongan_persen == '')
                                    {
                                      potongan_persen = 0;
                                    }
                                    potongaaan = subtotal_penjualan * potongan_persen / 100;
                                    $("#potongan_penjualan").val(potongaaan);
                                    
                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;

                                    var sub_total = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10);

                                    var tax_fakt = parseInt(tax_fak,10) * parseInt(sub_total,10) / 100;

                                    var pajak_faktur = Math.round(tax_fakt);

                                    var sub_akhir = (parseInt(subtotal_penjualan,10) + parseInt(pajak_faktur,10)) - parseInt(potongaaan,10);


                      if (ber_stok == 'Jasa'){

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#btn-hapus-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));       
                                    $("#total1").val(tandaPemisahTitik(sub_akhir));
                                    $("#tax_rp").val(pajak_faktur); 

                      $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){


                                   

                                    });        
                            }

                          else{

                              $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){
                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                    $("#input-jumlah-"+id+"").val(jumlah_lama);
                                    $("#text-jumlah-"+id+"").text(jumlah_lama);
                                    $("#text-jumlah-"+id+"").show();
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    
                                     }

                                      else{

                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#btn-hapus-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));       
                                    $("#total1").val(tandaPemisahTitik(sub_akhir));    
                                    $("#tax_rp").val(pajak_faktur);  

                                     $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){


                                    
                                         


                                    });

                                   }



                                 });

                            }
       
                                    $("#kode_barang").focus();
                                    

                                 });

                             </script>
