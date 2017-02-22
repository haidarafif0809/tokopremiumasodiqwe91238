<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data sesuai dengan variabel denagn metode POST 

    $session_id = session_id();


    $kode_barang = stringdoang($_POST['kode_barang']);
    



    //menampilkan data yang ada pada tbs penjualan berdasarkan kode barang
    $cek = $db->query("SELECT * FROM tbs_item_keluar WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");
    //menyimpan data sementara berupa baris dari variabel cek
    $jumlah1 = mysqli_num_rows($cek);
    
    if ($jumlah1 > 0)
    {
        # code...
        $query1 = $db->prepare("UPDATE tbs_item_keluar SET jumlah = jumlah + ?,
             subtotal = subtotal + ? WHERE kode_barang = ? 
             AND session_id = ?");

    $query1->bind_param("iiss",
    $jumlah, $subtotal, $kode_barang, $session_id);
    
    $jumlah = angkadoang($_POST['jumlah_barang']);
    $subtotal = $harga * $jumlah;
    $kode_barang = stringdoang($_POST['kode_barang']);

    $query1->execute();


    }
    else
    {
        $perintah = $db->prepare("INSERT INTO tbs_item_keluar (session_id,kode_barang,nama_barang,jumlah,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");


    $perintah->bind_param("sssisii",
    $session_id, $kode_barang, $nama_barang, $jumlah, $satuan, $harga, $subtotal);
    
    $jumlah = angkadoang($_POST['jumlah_barang']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $satuan = stringdoang($_POST['satuan']);
    $harga = angkadoang($_POST['harga']);
    $subtotal = $harga * $jumlah;

    $perintah->execute();


if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}


    }

    ?>
 <table id="tableuser" class="table table-bordered">
    <thead>
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah </th>
      <th> Satuan </th>
      <th> Harga </th>
      <th> Subtotal </th>
    
      <th> Hapus </th>
      
    </thead>
    
    <tbody>
    <?php

    //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
     $perintah = $db->query("SELECT * FROM tbs_item_keluar
                WHERE session_id = '$session_id'");

      //menyimpan data sementara yang ada pada $perintah

      while ($data1 = mysqli_fetch_array($perintah))
      {
        //menampilkan data
      echo "<tr>
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>

      <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-harga='".$data1['harga']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."' > </td>
      
      <td>". $data1['satuan'] ."</td>
      <td>". rp($data1['harga']) ."</td>
      <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-nama-barang='". $data1['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
      
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
    $('.table').DataTable();
});

</script>


              <script type="text/javascript">
            $(document).ready(function(){
            
            
            //fungsi hapus data 
            $(".btn-hapus").click(function(){
            var nama_barang = $(this).attr("data-nama-barang");
            var id = $(this).attr("data-id");
            $("#hapus_nama").val(nama_barang);
            $("#id_hapus").val(id);
            $("#modal_hapus").modal('show');
            
            
            })
       //fungsi edit data 
            $(".btn-edit").click(function(){
            
            $("#modal_edit").modal('show');
            var jumlah_lama = $(this).attr("data-jumlah"); 
            var harga = $(this).attr("data-harga"); 
            var id  = $(this).attr("data-id");
            $("#edit_jumlah_lama").val(jumlah_lama);
            $("#edit_harga").val(harga);
            $("#id_edit").val(id);
            
            
            });
            $('form').submit(function(){
            
            return false;
            });
            
            });
            

   </script> 

