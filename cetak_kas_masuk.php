<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_faktur = $_GET['no_faktur'];
$user = $_SESSION['nama'];
$querycet = $db->query("SELECT km.id,km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM detail_kas_masuk km INNER JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun WHERE no_faktur = '$no_faktur'");
    

$queryedit = $db->query("SELECT id,user_edit,jumlah,waktu_edit,user_edit,user,no_faktur FROM kas_masuk WHERE no_faktur = '$no_faktur'");
 $edit = mysqli_fetch_array($queryedit);
 $jumlah = rp($edit['jumlah']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);	

?>


<div style="padding-right: 5%; padding-left: 5%; padding-top: 5%; padding-bottom: 5%;" >
    
                 <h3> <b><center>DATA KAS MASUK </center> </b></h3>
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-5">
                 <h5> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h5> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-5">
        <table>
        <tr><td>No. Faktur</td> <td>:</td> <td><?php echo $edit['no_faktur']; ?></td></tr>
        <tr><td>Petugas</td> <td>:</td> <td><?php echo $user; ?></td></tr> 
        <tr><td>Jumlah Total</td> <td>:</td> <td> Rp. <?php echo $jumlah; ?></td></tr>  

        </table>
                 
        </div><!--penutup colsm4-->

    </div><hr>

<br><br><table id="tableuser" class="table table-bordered table-sm">
            <thead>
                <th> No. Faktur </th>
                <th> Dari Akun </th>
                <th> Ke Akun </th>
                <th> Jumlah </th> 
                <th> Tanggal </th>
                <th> Jam </th>
                <th> Keterangan </th>
                <th> User </th>  
                <?php if ($edit['user_edit'] != ''): ?>
                  <th> Waktu Edit </th>
                  <th> User Edit</th>
                <?php endif ?>
            </thead>
            
            <tbody>
            <?php
                while ($datacet = mysqli_fetch_array($querycet))
                {
                  $perintah1 = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM detail_kas_masuk km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun WHERE km.dari_akun = '$datacet[dari_akun]'");
                  $data1 = mysqli_fetch_array($perintah1);

                  echo "<tr>
                  <td>". $datacet['no_faktur'] ."</td>
                  <td>". $data1['nama_daftar_akun'] ."</td>
                  <td>". $datacet['nama_daftar_akun'] ."</td>
                  <td>". rp($datacet['jumlah']) ."</td>
                  <td>". tanggal($datacet['tanggal']) ."</td>
                  <td>". $datacet['jam'] ."</td>
                  <td>". $datacet['keterangan'] ."</td>
                  <td>". $datacet['user'] ."</td>";
                  if ($edit['user_edit'] != '') {
                    echo"<td>". $edit['waktu_edit'] ."</td>
                          <td>". $edit['user_edit'] ."</td>";
                  }
                  echo"</tr>";
                }

//Untuk Memutuskan Koneksi Ke Database



            ?>

            </tbody>
      </table>
<br><br>
      <div class="row"><!--row1-->
        <div class="col-sm-4">
                <center><p>Hormat kami :</p><br><br>
                <p><?php echo $user ?></p></center>
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 <center><p> Manager : </p> <br><br>
                 <p>--------------------</p> </center>
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
                 <center><p> Penerima : </p><br><br>
                 <p>--------------------</p></center>
                 
        </div><!--penutup colsm4-->

    </div>
</div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>




<?php include 'footer.php'; ?>