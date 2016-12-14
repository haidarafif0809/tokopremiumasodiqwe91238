<?php session_start();


include 'sanitasi.php';
include 'db.php';



$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_retur = angkadoang($_POST['jumlah_retur']);
$jumlah_potongan = angkadoang($_POST['jumlah_potongan']);
$harga = angkadoang($_POST['harga']);
$jumlah_tax = angkadoang($_POST['jumlah_tax']);


$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);

echo $subtotal = $harga * $jumlah_baru - $jumlah_potongan;


$query00 = $db->query("SELECT * FROM tbs_retur_pembelian WHERE id = '$id'");
$data = mysqli_fetch_array($query00);
$kode = $data['kode_barang'];
$nomor = $data['no_faktur_retur'];

$query = $db->prepare("UPDATE tbs_retur_pembelian SET jumlah_retur = ?, subtotal = ?, tax = ? , potongan = ? WHERE id = ?");


$query->bind_param("iiiii",
    $jumlah_baru, $subtotal, $jumlah_tax, $jumlah_potongan, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else
    {

    }

    

                //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>

<script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){
    var no_faktur_pembelian = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode-barang");
    var id = $(this).attr("data-id");
    var subtotal_tbs = $(this).attr("data-subtotal");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_retur_pembelian1").val()))));

    if (total == '') 
        {
          total = 0;
        };
      var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10);

      $("#total_retur_pembelian").val(tandaPemisahTitik(total_akhir));
      $("#total_retur_pembelian1").val(tandaPemisahTitik(total_akhir));



    $.post("hapus_tbs_retur_pembelian.php",{id:id,kode_barang:kode_barang,no_faktur_pembelian:no_faktur_pembelian},function(data){

    $("#kode_barang").focus();
    $(".tr-id-"+id+"").remove();
    

    
    });
    
    
    });
//end fungsi hapus data
   

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
