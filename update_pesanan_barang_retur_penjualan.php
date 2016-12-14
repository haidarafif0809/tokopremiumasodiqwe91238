<?php session_start();


include 'sanitasi.php';
include 'db.php';



$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$potongan = angkadoang($_POST['potongan']);
$jumlah_tax = angkadoang($_POST['jumlah_tax']);
$harga = angkadoang($_POST['harga']);
$jumlah_retur = angkadoang($_POST['jumlah_retur']);

$subtotal = angkadoang($_POST['subtotal']);

$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);



$query00 = $db->query("SELECT * FROM tbs_retur_penjualan WHERE id = '$id'");
$data = mysqli_fetch_array($query00);
$kode = $data['kode_barang'];
$nomor = $data['no_faktur_retur'];

$query = $db->prepare("UPDATE tbs_retur_penjualan SET jumlah_retur = ?, subtotal = ?, tax = ? WHERE id = ?");


$query->bind_param("iiii",
    $jumlah_baru, $subtotal, $jumlah_tax, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else
    {

    }

    
    $query9 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$user' AND kode_produk = '$kode'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];

        if ($prosentase != 0)

            {
            
            $fee_prosentase_produk = $prosentase * $subtotal / 100;
            
            $query1 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_prosentase_produk' WHERE nama_petugas = '$user' AND kode_produk = '$kode' AND no_faktur = '$nomor'");
                 
            
            }

   elseif ($nominal != 0) 

            {
            
            $fee_nominal_produk = $nominal * $jumlah_baru;

            $query01 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_nominal_produk' WHERE nama_petugas = '$user' AND kode_produk = '$kode' AND no_faktur = '$nomor'");

            }

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
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#text-tax-"+id+"").text(jumlah_tax);
                                    $("#total_retur_pembelian").val(tandaPemisahTitik(subtotal_penjualan)); 
                                    $("#total_retur_pembelian1").val(tandaPemisahTitik(subtotal_penjualan));         

                                    });

                                   }

                                 });


       
                                    $("#kode_barang").focus();

                                 });

                             </script>