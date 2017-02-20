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
                <th> Edit </th>
                
                </thead>
                
                <tbody>
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT * FROM tbs_penjualan 
                WHERE no_faktur = '$nomor_faktur'");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
echo "<tr class='tr-id-". $data1['id'] ." tr-kode-". $data1['kode_barang'] ."'>
                <td>". $data1['kode_barang'] ."</td>
                <td>". $data1['nama_barang'] ."</td>
                <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>
                <td>". $data1['satuan'] ."</td>
                <td>". rp($data1['harga']) ."</td>
                <td><span id='text-subtotal-".$data1['id']."'>". $data1['subtotal'] ."</span></td>
                <td>". rp($data1['potongan']) ."</td>";

               echo "<td> <button class='btn btn-danger btn-hapus-tbs' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                
                </tr>";


                }

                    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

                ?>
                </tbody>
                
                </table>


        <script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kd_pelanggan").focus();
    $('.table').DataTable();
});

</script>


 <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
    $(".btn-hapus-tbs").click(function(){
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    $("#nama-barang").val(nama_barang);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });
    


//end fungsi hapus data


//fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_barang = $(this).attr("data-jumlah-barang");
        var harga = $(this).attr("data-harga");
        var id  = $(this).attr("data-id");
        $("#harga_edit").val(harga);
        $("#barang_lama").val(jumlah_barang);
        $("#id_edit").val(id);
        
        
        });
        

//end function edit data

              $('form').submit(function(){
              
              return false;
              });
        });

    </script>