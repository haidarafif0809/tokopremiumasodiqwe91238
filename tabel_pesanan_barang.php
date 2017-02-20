<?php include 'session_login.php';



include 'db.php';
include 'sanitasi.php';

$no_faktur = $_GET['no_faktur'];

 ?>

                  <table id="tableuser" class="table table-bordered">
                <thead>
                <th> No Faktur </th>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Jumlah Barang </th>
                <th> Satuan </th>
                <th> Harga </th>
                <th> Subtotal </th>
                <th> Potongan </th>
                <th> Pajak </th>
                <th> Hapus </th>
                
                </thead>
                
                <tbody id="tbody">
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr class='tr-id-". $data1['id'] ." tr-kode-". $data1['kode_barang'] ."'>
                <td>". $data1['no_faktur'] ."</td>
                <td>". $data1['kode_barang'] ."</td>
                <td>". $data1['nama_barang'] ."</td>
                <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>
                <td>". $data1['satuan'] ."</td>
                <td>". rp($data1['harga']) ."</td>
                <td><span id='text-subtotal-".$data1['id']."'>". $data1['subtotal'] ."</span></td>
                <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</td>
                <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</td>";

               echo "<td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                
                </tr>";


                }

                ?>
                </tbody>
                
                </table>


  <script>
    
    $(document).ready(function(){
    $('.table').DataTable();
    });
  </script>

<script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    var kode_barang = $(this).attr("data-kode-barang");
    $("#nama-barang").val(nama_barang);
    $("#id_hapus").val(id);
    $("#kode_hapus").val(kode_barang);
    $("#modal_hapus").modal('show');
    
    
    });
    
    $("#btn_jadi_hapus").click(function(){
    
    var id = $("#id_hapus").val();
    var kode_barang = $("#kode_barang").val();
    $.post("hapustbs_penjualan.php",{id:id,kode_barang:kode_barang},function(data){
    if (data == 'sukses') {

        $("#kode_barang").focus();
    $("#table-baru").load('tabel_penjualan.php');
    $("#modal_hapus").modal('hide');
    $("#total_penjualan").val('');
        $("#pembayaran_penjualan").val('');
        $("#potongan_persen").val('');
        $("#potongan_rp").val('');
    
    }
    });
    
    
    });

//end fungsi hapus data


//fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_barang = $(this).attr("data-jumlah-barang");
        var harga = $(this).attr("data-harga");
        var id  = $(this).attr("data-id");
        var kode_barang = $(this).attr("data-kode");
        var potongan  = $(this).attr("data-potongan");
        var tax  = $(this).attr("data-tax");
        $("#harga_edit").val(harga);
        $("#barang_lama").val(jumlah_barang);
        $("#id_edit").val(id);
        $("#kode_edit").val(kode_barang);
        $("#potongan_edit").val(potongan);
        $("#tax_edit").val(tax);
        
        
        });
        
        $("#submit_edit").click(function(){
        var jumlah_barang = $("#barang_lama").val();
        var jumlah_baru = $("#barang_edit").val();
        var harga = $("#harga_edit").val();
        var id = $("#id_edit").val();
        var kode_barang = $("#kode_edit").val();
        var potongan = $("#potongan_edit").val();
        var tax = $("#tax_edit").val();
        var no_faktur = $("#nofaktur").val();

        $.post("update_tbs_penjualan.php",{id:id,jumlah_barang:jumlah_barang,jumlah_baru:jumlah_baru,harga:harga,kode_barang:kode_barang,no_faktur:no_faktur,potongan:potongan,tax:tax},function(data){

$("#kode_barang").focus();
       $("#alert").html(data);
        $("#table-baru").load('tabel_penjualan.php');
        setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
        
      
        });
        });
//end function edit data

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
