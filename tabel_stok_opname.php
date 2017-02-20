<?php 
                  
              
                  include 'db.php';
                  include 'sanitasi.php';
                  
                  $perintah = $db->query("SELECT * FROM stok_opname");
                  
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
                  //ambil bulan dari tanggal stok_opname terakhir
                  
                  $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM stok_opname ORDER BY id DESC LIMIT 1");
                  $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);
                  
                  //ambil nomor  dari stok_opname terakhir
                  $no_terakhir = $db->query("SELECT no_faktur FROM stok_opname ORDER BY id DESC LIMIT 1");
                  $v_no_terakhir = mysqli_fetch_array($no_terakhir);
                  $ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);
                  
                  /*jika bulan terakhir dari stok_opname tidak sama dengan bulan sekarang, 
                  maka nomor nya kembali mulai dari 1 ,
                  jika tidak maka nomor terakhir ditambah dengan 1
                  
                  */
                  if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
                  # code...
                  $no_faktur = "1/SO/".$data_bulan_terakhir."/".$tahun_terakhir;
                  
                  }
                  
                  else
                  {
                  
                  $nomor = 1 + $ambil_nomor ;
                  
                  $no_faktur = $nomor."/SO/".$data_bulan_terakhir."/".$tahun_terakhir;
                  
                  
                  }
                  
                  

                  ?>

                  <table id="tableuser" class="table table-bordered">
                  <thead>
                  
                  <th> Nomor Faktur </th>
                  <th> Kode Barang </th>
                  <th> Nama Barang </th>
                  <th> Satuan </th>
                  <th> Stok Komputer </th>
                  <th> Jumlah Fisik </th>
                  <th> Selisih Fisik </th>
                  <th> Hpp </th>
                  <th> Selisih Harga </th>
                  <th> Harga </th>
                  <th> Hapus </th>
                  
                  </thead>
                  
                  <tbody>
                  <?php
                  
                  
      $perintah = $db->query("SELECT * FROM tbs_stok_opname");
                  
                  //menyimpan data sementara yang ada pada $perintah
                  while ($data1 = mysqli_fetch_array($perintah))
                  {
                  
                  
                  
                  
                  echo "<tr class='tr-id-".$data1['id']."'>
                  
                  <td>". $data1['no_faktur'] ."</td>
                  <td>". $data1['kode_barang'] ."</td>
                  <td>". $data1['nama_barang'] ."</td>
                  <td>". $data1['satuan'] ."</td>
                  <td><span id='text-stok-sekarang-".$data1['id']."'>". rp($data1['stok_sekarang']) ."</span></td>";

     $pilih = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]' AND sisa != jumlah_kuantitas");
        $row_alert = mysqli_num_rows($pilih);

                  if ($row_alert > 0){
                  
                  echo "<td class='btn-alert' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur'] ."' >". $data1['fisik'] ."  </td>";
                  }
                  
                  else{
                  
                  echo "<td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['fisik'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['fisik']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-faktur='".$data1['no_faktur']."' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' data-selisih-fisik='".$data1['selisih_fisik']."' data-stok-sekarang='".$data1['stok_sekarang']."'> </td>";
                      }


                  echo "<td><span id='text-selisih-fisik-".$data1['id']."'>". rp($data1['selisih_fisik']) ."</span></td>
                  <td><span id='text-hpp-".$data1['id']."'>". rp($data1['hpp']) ."</span></td>
                  <td><span id='text-selisih-".$data1['id']."'>". rp($data1['selisih_harga']) ."</span></td>
                  <td>". rp($data1['harga']) ."</td>";

             
                  
                  if ($row_alert > 0) {
                  
                  echo "<td> <button class='btn btn-danger btn-alert' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-faktur='". $data1['no_faktur'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> ";
                }
                else{
                  echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
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

                                  
//fungsi hapus data 
    $(".btn-hapus").click(function(){
    var nama_barang = $(this).attr("data-nama-barang");
    var kode_barang = $(this).attr("data-kode-barang");
    var id = $(this).attr("data-id");

    $.post("hapus_tbs_stok_opname.php",{kode_barang:kode_barang},function(data){
    if (data == "sukses") {
    $(".tr-id-"+id).remove();
    $("#modal_hapus").modal('hide');
    
    }

    
    });
    
    });
// end fungsi hapus data


                                  
                                  $('form').submit(function(){
                                  
                                  return false;
                                  });

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
                                    var harga = $(this).attr("data-harga");
                                    var kode_barang = $(this).attr("data-kode");

                                    var stok_sekarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-stok-sekarang-"+id+"").text()))));
                                    var hpp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-hpp-"+id+"").text()))));

                                    var selisih_fisik = parseInt(jumlah_baru,10) - parseInt(stok_sekarang,10);
                                    var selisih_harga = parseInt(selisih_fisik,10) * parseInt(hpp,10);


                              
                                  $.post("update_tbs_stok_opname.php", {jumlah_baru:jumlah_baru,id:id,kode_barang:kode_barang,selisih_harga:selisih_harga,selisih_fisik:selisih_fisik}, function(info){


                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-selisih-"+id+"").text(tandaPemisahTitik(selisih_harga));
                                    $("#text-selisih-fisik-"+id+"").text(tandaPemisahTitik(selisih_fisik));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");   
                                   $("#kode_barang").focus();     
                                    
                                    
                                    });
                                    
                                 });

                             </script>

                             

<script type="text/javascript">
  
    $(document).on('click', '.btn-alert', function (e) {
    var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode-barang");

    $.post('modal_alert_hapus_data_edit_stok_opname.php',{no_faktur:no_faktur,kode_barang:kode_barang},function(data){


    $("#modal_alert").modal('show');
    $("#modal-alert").html(data);

    });

    
    });

</script>