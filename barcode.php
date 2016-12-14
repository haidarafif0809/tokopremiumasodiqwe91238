<?php
include 'db.php';
include 'sanitasi.php';
session_start();

$session_id = session_id();


    require_once 'cache_folder/cache.class.php';

    // setup 'default' cache
    $c = new Cache();

     // store a string

    $kode_barang = stringdoang($_POST['kode_barang']);
    $sales = stringdoang($_POST['sales']);
    $level_harga = stringdoang($_POST['level_harga']);

    $tipe = $db->query("SELECT berkaitan_dgn_stok FROM barang WHERE kode_barang = '$kode_barang'");
    $data_tipe = mysqli_fetch_array($tipe);
    $ber_stok = $data_tipe['berkaitan_dgn_stok'];

    $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$kode_barang'");
    $ambil_sisa = mysqli_fetch_array($select);

    $query = $db->query("SELECT SUM(jumlah_barang) AS jumlah_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");
    $jumlah = mysqli_fetch_array($query);
    $jumlah_tbs = $jumlah['jumlah_barang'];
    
    if ($jumlah_tbs == ""){
    	$jumlah_tbs = 0;
    	}
   


    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:sa');


    // generate a new cache file with the name 'newcache'
    $c->setCache('produk');


if($c->isCached($kode_barang)) {
 // get cached data by its key
    $result = $c->retrieve($kode_barang);
    // grab array entry
    $nama_barang = stringdoang($result['nama_barang']);
    $harga_jual1 = angkadoang($result['harga_jual']);
    $harga_jual2 = angkadoang($result['harga_jual2']);
    $harga_jual3 = angkadoang($result['harga_jual3']);
    $jumlah_barang = angkadoang(1);
    $satuan = stringdoang($result['satuan']);
}
else {
$query = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");
while ($data = $query->fetch_array()) {
 # code...
    // store an array
    $c->store($data['kode_barang'], array(
      'nama_barang' => $data['nama_barang'],
      'harga_beli' => $data['harga_beli'],
      'harga_jual' => $data['harga_jual'],
      'harga_jual2' => $data['harga_jual2'],
      'harga_jual3' => $data['harga_jual3'],
      'satuan' => $data['satuan'],
      'kategori' => $data['kategori'],
      'gudang' => $data['gudang'],
      'status' => $data['status'],
      'suplier' => $data['suplier'],
      'stok_awal' => $data['stok_awal'],
      'stok_opname' => $data['stok_opname'],
      'foto' => $data['foto'],
      'limit_stok' => $data['limit_stok'],
      'over_stok' => $data['over_stok'],


    ));

}
    $result = $c->retrieve($kode_barang);
        // grab array entry
    $nama_barang = stringdoang($result['nama_barang']);
    $harga_jual1 = angkadoang($result['harga_jual']);
    $harga_jual2 = angkadoang($result['harga_jual2']);
    $harga_jual3 = angkadoang($result['harga_jual3']);
    $jumlah_barang = angkadoang(1);
    
    $satuan = stringdoang($result['satuan']);
}

if ($level_harga == 'Level 1')
{
  $harga = $harga_jual1;
}
else if ($level_harga == 'Level 2')
{
  $harga = $harga_jual2;
}
else if ($level_harga == 'Level 3')
{
  $harga = $harga_jual3;
}

$stok_barang = $ambil_sisa['jumlah_barang'] - $jumlah_barang;


if ($ber_stok == 'Barang' OR $ber_stok == 'barang') {
    
    if ($stok_barang <= 0 ) {
      
    }

    else{
    

      $a = $harga * $jumlah_barang;
    // display the cached array

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
            '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");

      }


    }

        elseif ($nominal != 0) {

              $query900 = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' AND kode_barang = '$kode_barang'");
              $cek011 = mysqli_num_rows($query900);

              $cek900 = mysqli_fetch_array($query900);
              $jumlah1 = $cek900['jumlah_barang'];
              $jumlah0 = $jumlah_barang + $jumlah1;

              $fee_nominal_produk = $nominal * $jumlah0;

              $komisi0 = $fee_nominal_produk;

          if ($cek011 > 0) {

                $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi0' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
              }

          else
              {

                $fee_nominal_produk = $nominal * $jumlah_barang;

                $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$session_id', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
              }

        }

        else
        {

        }


 
$cek = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");

$jumlah = mysqli_num_rows($cek);
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND session_id = ?");

        $query1->bind_param("iisss",
            $jumlah_barang,$a, $potongan_tampil, $kode_barang, $session_id);


        $query1->execute();

    }
    else
    {
            $perintah = $db->prepare("INSERT INTO tbs_penjualan (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal) VALUES (?,?,
            ?,?,?,?,?)");
            
            
            $perintah->bind_param("sssisii",
            $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $a);
           
            
            
            $perintah->execute();

    }


    } // END ELSE dari IF ($stok_barang < 0) {

} // END berkaitan dgn stok == Barang

else{


  $a = $harga * $jumlah_barang;
    // display the cached array

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
            '$nama_barang', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang')");

      }


    }

        elseif ($nominal != 0) {

              $query900 = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' AND kode_barang = '$kode_barang'");
              $cek011 = mysqli_num_rows($query900);

              $cek900 = mysqli_fetch_array($query900);
              $jumlah1 = $cek900['jumlah_barang'];
              $jumlah0 = $jumlah_barang + $jumlah1;

              $fee_nominal_produk = $nominal * $jumlah0;

              $komisi0 = $fee_nominal_produk;

          if ($cek011 > 0) {

                $query911 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$komisi0' WHERE nama_petugas = '$user' AND kode_produk = '$kode_barang'");
              }

          else
              {

                $fee_nominal_produk = $nominal * $jumlah_barang;

                $query10 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, session_id, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$user', '$session_id', '$kode_barang', '$nama_barang', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang')");
              }

        }

        else
        {

        }


 
$cek = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");

$jumlah = mysqli_num_rows($cek);
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND session_id = ?");

        $query1->bind_param("iisss",
            $jumlah_barang,$a, $potongan_tampil, $kode_barang, $session_id);


        $query1->execute();

    }
    else
    {
            $perintah = $db->prepare("INSERT INTO tbs_penjualan (session_id,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal) VALUES (?,?,
            ?,?,?,?,?)");
            
            
            $perintah->bind_param("sssisii",
            $session_id, $kode_barang, $nama_barang, $jumlah_barang, $satuan, $harga, $a);
           
            
            
            $perintah->execute();

    }


}// END berkaitan dgn stok == Jasa




    ?>



<?php
    if ($ber_stok == 'Jasa' OR ($ber_stok == 'Barang' AND $stok_barang >= 0)){

  //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.session_id = '$session_id' AND tp.kode_barang = '$kode_barang'");
                
                //menyimpan data sementara yang ada pada $perintah
                
               $data1 = mysqli_fetch_array($perintah);

                //menampilkan data
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>
                <td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' > </td>
                <td style='font-size:15px'>". $data1['nama'] ."</td>
                <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>";

               echo "<td style='font-size:15px'> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."'>Hapus</button> </td> 

                </tr>";

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
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;
                                    
                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;


                                    $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){

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
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));


                                    });

                                   }

                                 });


       
                                    $("#kode_barang").focus();
                                    

                                 });

                             </script>
