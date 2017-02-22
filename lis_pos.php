<?php session_start();

    include 'sanitasi.php';
    include 'db.php';


$session_id = session_id();

//ambil 2 angka terakhir dari tahun sekarang 
$tahun = $db->query("SELECT YEAR(NOW()) as tahun");
$v_tahun = mysqli_fetch_array($tahun);
 $tahun_terakhir = substr($v_tahun['tahun'], 2);
//ambil bulan sekarang
$bulan = $db->query("SELECT MONTH(NOW()) as bulan");
$v_bulan = mysqli_fetch_array($bulan);
$v_bulan['bulan'];


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($v_bulan['bulan']);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$v_bulan['bulan'];
 }
 else
 {
  $data_bulan_terakhir = $v_bulan['bulan'];

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }




    //mengirim data sesuai dengan variabel denagn metode POST 

    $kode_barang = stringdoang($_POST['kode_barang']);
    $harga = angkadoang($_POST['harga']);
    $jumlah_barang = 1;
    $nama_barang = stringdoang($_POST['nama_barang']);
    $user = $_SESSION['nama'];
    $sales = stringdoang($_POST['sales']);




    $query9 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];



    if ($prosentase != 0){
      
      $query90 = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' AND kode_barang = '$kode_barang'");
      $cek01 = mysqli_num_rows($query90);

      $cek90 = mysqli_fetch_array($query90);
      $jumlah1 = $cek90['jumlah_barang'];
      $jumlah0 = $jumlah_barang + $jumlah1;

          $subtotal_prosentase = $harga * $jumlah0;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

      $komisi = $fee_prosentase_produk;

      if ($cek01 > 0) {
        $query91 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
      }

      else
      {

          $subtotal_prosentase = $harga * $jumlah_barang;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

          $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$session_id', '$kode_barang',
            '$nama_barang', '$fee_prosentase_produk', now(), now())");

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

        $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi0' WHERE nama_petugas = '$sales' AND kode_produk = '$kode_barang'");
      }

      else
        {

      $fee_nominal_produk = $nominal * $jumlah_barang;

      $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$sales', '$no_faktur', '$kode_barang', 
        '$nama_barang', '$fee_nominal_produk', now(), now())");
      }

    }

    else
    {

    }



    $kode_barang = stringdoang($_POST['kode_barang']);
    $jumlah_barang = 1;
        





        $query020 = $db->query("SELECT SUM(jumlah_barang) AS total_barang FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
        $hasil1 = mysqli_fetch_array($query020);
        $jumlah_masuk_pembelian = $hasil1['total_barang'];


        $query303 = $db->query("SELECT SUM(jumlah) AS jumlah_item FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
        $hasil2 = mysqli_fetch_array($query303);
        $jumlah_detail_masuk_pembelian = $hasil2['jumlah_item'];

        $hasil_masuk = $jumlah_masuk_pembelian + $jumlah_detail_masuk_pembelian;


/*
        $query7 = $db->query("SELECT SUM(subtotal) AS harga_total FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
        $hasil6 = mysqli_fetch_array($query7);
        $harga_total = $hasil6['harga_total'];

        $hpp = $harga_total / $hasil_masuk;


        if ($hasil_masuk != 0 AND $harga_total != 0) 
        {
         
         $total_hpp = $hpp * $jumlah_barang;

        }
        else 
        {
          $total_hpp = 0;
        }
*/



// MENGAMBIL DATA STOK BARANG-->
       
// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$kode_barang'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$kode_barang'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$kode_barang'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$kode_barang'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$kode_barang'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];


 



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;



           $stok_barang = $total_1 - $total_2;




// MENGAMBIL DATA STOK BARANG--<

  
    $cek = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");

    $tes = mysqli_fetch_array($cek);
    $jumlah = mysqli_num_rows($cek);

 $jumlah_pos = $tes['jumlah_barang'];

$a = $stok_barang - $jumlah_pos - 1;


$perintah0 = $db->query("SELECT limit_stok FROM barang WHERE kode_barang = '$kode_barang'");
        
$ambil_limit = mysqli_fetch_array($perintah0);

$limit_stok = $ambil_limit['limit_stok'];


$ber_stok = stringdoang($_POST['ber_stok']);



if ($ber_stok == 'Jasa') {

          if ($jumlah > 0)
            {
                
                $query01 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ? WHERE kode_barang = ? AND session_id = ?");
                
                $query01->bind_param("iiss",
                $jumlah_barang, $subtotal, $kode_barang, $session_id);
                
                $harga = angkadoang($_POST['harga']);
                $subtotal = $harga * $jumlah_barang;
                $kode_barang = stringdoang($_POST['kode_barang']);    
                $jumlah_barang = 1;
                
                $query01->execute();

            }

        else
            {
                $perintah02 = $db->prepare("INSERT INTO tbs_penjualan (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal) VALUES (?,?,
                ?,?,?,?,?)");
                
                
                $perintah02->bind_param("sssisii",
                $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $subtotal);
                
                $session_id = stringdoang($_POST['session_id']);
                $kode_barang = stringdoang($_POST['kode_barang']);
                $jumlah_barang = 1;
                $nama_barang = stringdoang($_POST['nama_barang']);
                $satuan = stringdoang($_POST['satuan']);
                $harga = angkadoang($_POST['harga']);
                $subtotal = $harga * $jumlah_barang;
                
                
                $perintah02->execute();

            }

}

else{

 if ($jumlah_pos >= $stok_barang) 

    {
      
    }

else if ($limit_stok > $a){


          if ($jumlah > 0)
            {
                
                $query01 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ? WHERE kode_barang = ? AND session_id = ?");
                
                $query01->bind_param("iiss",
                $jumlah_barang, $subtotal, $kode_barang, $session_id);
                
                $harga = angkadoang($_POST['harga']);
                $subtotal = $harga * $jumlah_barang;
                $kode_barang = stringdoang($_POST['kode_barang']);    
                $jumlah_barang = 1;
                
                $query01->execute();

            }

        else
            {
                $perintah02 = $db->prepare("INSERT INTO tbs_penjualan (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal) VALUES (?,?,
                ?,?,?,?,?)");
                
                
                $perintah02->bind_param("sssisii",
                $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $subtotal);
                
                $session_id = stringdoang($_POST['session_id']);
                $kode_barang = stringdoang($_POST['kode_barang']);
                $jumlah_barang = 1;
                $nama_barang = stringdoang($_POST['nama_barang']);
                $satuan = stringdoang($_POST['satuan']);
                $harga = angkadoang($_POST['harga']);
                $subtotal = $harga * $jumlah_barang;
                
                
                $perintah02->execute();

            }

      echo '<div class="alert alert-warning">
            <strong>PERHATIAN!</strong> Persediaan Barang Mencapai Batas Limit Stok, Segera Melakukan Pembelian!
        </div>';
}



    else
    {

        if ($jumlah > 0)
            {
                
                $query01 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ? WHERE kode_barang = ? AND session_id = ?");
                
                $query01->bind_param("iiss",
                $jumlah_barang, $subtotal, $kode_barang, $session_id);
                
                $harga = angkadoang($_POST['harga']);
                $subtotal = $harga * $jumlah_barang;
                $kode_barang = stringdoang($_POST['kode_barang']);    
                $jumlah_barang = 1;
                
                $query01->execute();

            }

        else
            {
                $perintah02 = $db->prepare("INSERT INTO tbs_penjualan (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal) VALUES (?,?,
                ?,?,?,?,?)");
                
                
                $perintah02->bind_param("sssisii",
                $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $subtotal);
                
                $session_id = stringdoang($_POST['session_id']);
                $kode_barang = stringdoang($_POST['kode_barang']);
                $jumlah_barang = 1;
                $nama_barang = stringdoang($_POST['nama_barang']);
                $satuan = stringdoang($_POST['satuan']);
                $harga = angkadoang($_POST['harga']);
                $subtotal = $harga * $jumlah_barang;
                
                
                $perintah02->execute();

            }


    }

}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>


                     
          <script type="text/javascript">
                             
          $(document).ready(function(){

          
          //fungsi edit data 
          $(".hapus_edit").click(function(){
          
          $("#modal_edit").modal('show');
          var jumlah_barang = $(this).attr("data-jumlah-barang");
          var harga = $(this).attr("data-harga");
          var id  = $(this).attr("data-id");
          var kode_barang = $(this).attr("data-kode");
                                     var nama_barang = $(this).attr("data-pesanan");
          $("#harga_edit").val(harga);
          $("#barang_lama").val(jumlah_barang);
          $("#id_edit").val(id);
          $("#kode_edit").val(kode_barang);
                                    $("#data_nama_barang").val(nama_barang);
          
          
          });
          
          $("#submit_edit").click(function(){
          var jumlah_barang = $("#barang_lama").val();
          var jumlah_baru = $("#barang_edit").val();
          var harga = $("#harga_edit").val();
          var id = $("#id_edit").val();
          var kode_barang = $("#kode_edit").val();
          var no_faktur = $("#nofaktur").val();
          
          $.post("update_tbs_pos.php",{id:id,jumlah_barang:jumlah_barang,jumlah_baru:jumlah_baru,harga:harga,kode_barang:kode_barang,no_faktur:no_faktur},function(data){
          
          $("#alert").html(data);
          $("#result").load('tabel-pesanan.php');
          
          setTimeout(tutupmodal, 2000);
          setTimeout(tutupalert, 2000);
          
                  
          });
                  
          });


                $("#btn_jadi_hapus").click(function(){
                
                var id = $("#id_edit").val();
                var kode_barang = $("#kode_edit").val();
                $.post("hapus_pos_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
                if (data != "") {
                $(".tr-id-"+id+"").remove();
                $("#modal_edit").modal('hide');
                
                }
                
                
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
                  
                  
                  </script>
