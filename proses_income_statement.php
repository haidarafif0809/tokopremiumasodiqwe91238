<?php 

include 'db.php';
include 'sanitasi.php';


$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

//mencari nilai sales
$query = $db->query("SELECT SUM(total) AS sales FROM penjualan WHERE tanggal <= '$sampai_tanggal'");
$cek =mysqli_fetch_array($query);

$sales = $cek['sales'];

//mencari nilai purshase
$query1 = $db->query("SELECT SUM(total) AS purchase FROM pembelian WHERE tanggal <= '$sampai_tanggal'");
$cek1 = mysqli_fetch_array($query1);
$purchase = $cek1['purchase'];

//mencari nilai hpp
$query2 = $db->query("SELECT SUM(total_hpp) AS hpp FROM penjualan WHERE tanggal <= '$sampai_tanggal'");
$cek2 = mysqli_fetch_array($query2);
$hpp = $cek2['hpp'];

$gross_profit = $sales - $hpp;


$query3 =$db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM detail_kas_keluar WHERE  tanggal <= '$sampai_tanggal' AND ke_akun = 'Expenses'");
$cek3 = mysqli_fetch_array($query3);
$expenses = $cek3['jumlah_kas_keluar'];

$net_profit = $gross_profit - $expenses;


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>

<br><h3> Income Statement Periode <?php echo $sampai_tanggal; ?> </h3>
<table id="table_income_statement" class="table table-bordered">
                  <thead>
                  
                  <th bgcolor="#F39C12" style="color:white"> Profit And Lose Statement </th>

                  </thead>

                  <tbody>
                  <tr>
                        <td> <h4><b>Sales : <?php echo rp($sales); ?> </b> </td>

                  </tr>

                  <tr>
                        <td><h4><b> Cost Of Good Sold : <?php echo rp($hpp); ?></b></td>
                  </tr>

                  <tr>
                        <td><h4><b>Gross Profit : <?php echo rp($gross_profit); ?></b></td>
                  </tr>

                  <tr>
                        <td>Expenses : <?php echo rp($expenses); ?></td>
                  </tr>

                  <tr>
                        <td>Net Profit :<h3><b> <?php echo rp($net_profit); ?></b></td>
                  </tr>



                  </tbody>
</table>
