<?php 
include 'sanitasi.php';
include 'db.php';




$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



//mencari nilai collections
$query = $db->query("SELECT SUM(total) AS jumlah_total FROM penjualan WHERE tanggal <= '$sampai_tanggal'");
$cek =mysqli_fetch_array($query);

$jumlah_total = $cek['jumlah_total'];


$query1 = $db->query("SELECT SUM(sisa) AS jumlah_sisa FROM penjualan WHERE  tanggal <= '$sampai_tanggal'");
$cek1 = mysqli_fetch_array($query1);

$jumlah_sisa = $cek1['jumlah_sisa'];

$collections = $jumlah_total - $jumlah_sisa;

//mencari nilai inventory paid
$query2 = $db->query("SELECT SUM(total) AS total_pembelian FROM pembelian WHERE  tanggal <= '$sampai_tanggal'");
$cek2 = mysqli_fetch_array($query2);

$total_pembelian = $cek2['total_pembelian'];


$query11 = $db->query("SELECT SUM(kredit) AS total_sisa_pembelian FROM pembelian WHERE  tanggal <= '$sampai_tanggal'");
$cek11 = mysqli_fetch_array($query11);

$total_sisa_pembelian = $cek11['total_sisa_pembelian'];



//mencari nilai expanses paid
$query3 = $db->query("SELECT SUM(jumlah) AS expanses_paid FROM detail_kas_keluar WHERE  tanggal <= '$sampai_tanggal' AND ke_akun = 'Expenses'");
$cek3 = mysqli_fetch_array($query3);

$expanses_paid = $cek3['expanses_paid'];

//mencari nilai money borrowed
$query4 = $db->query("SELECT SUM(jumlah) AS money_borrowed FROM detail_kas_masuk WHERE  tanggal <= '$sampai_tanggal' AND dari_akun = 'Notes Payable'");
$cek4 = mysqli_fetch_array($query4);

$money_borrowed = $cek4['money_borrowed'];

//mencari nilai money repaid
$query5 = $db->query("SELECT SUM(jumlah) AS money_repaid FROM detail_kas_keluar WHERE tanggal <= '$sampai_tanggal' AND ke_akun = 'Money Repaid'");
$cek5 = mysqli_fetch_array($query5);

$money_repaid = $cek5['money_repaid'];

//mencari nilai reduce payable
$query6 = $db->query("SELECT SUM(jumlah_bayar) AS reduce_payable FROM detail_pembayaran_hutang WHERE tanggal <= '$sampai_tanggal'");
$cek6 = mysqli_fetch_array($query6);

$reduce_payable = $cek6['reduce_payable'];


$inventory_paid = $total_pembelian - $reduce_payable - $total_sisa_pembelian;

//mencari nilai invesment property
$query8 = $db->query("SELECT SUM(jumlah) AS investment_property FROM detail_kas_keluar WHERE  tanggal <= '$sampai_tanggal' AND ke_akun = 'Property'");
$cek8 = mysqli_fetch_array($query8);

$investment_property = $cek8['investment_property'];

//mencari nilai invesment equipment
$query12 = $db->query("SELECT SUM(jumlah) AS investment_equipment FROM detail_kas_keluar WHERE tanggal <= '$sampai_tanggal' AND ke_akun = 'Equipment'");
$cek12 = mysqli_fetch_array($query12);

$investment_equipment = $cek12['investment_equipment'];


//mencari nilai invesment goodwill
$query13 = $db->query("SELECT SUM(jumlah) AS investment_goodwill FROM detail_kas_keluar WHERE tanggal <= '$sampai_tanggal' AND ke_akun = 'Goodwill'");
$cek13 = mysqli_fetch_array($query13);

$investment_goodwill = $cek13['investment_goodwill'];

//property sales
$query14 = $db->query("SELECT SUM(jumlah) AS property_sales FROM detail_kas_masuk   WHERE tanggal <= '$sampai_tanggal' AND dari_akun = 'Property'");
$cek14 = mysqli_fetch_array($query14);

$property_sales = $cek14['property_sales'];


//equipment sales
$query15 = $db->query("SELECT SUM(jumlah) AS equipment_sales FROM detail_kas_masuk   WHERE tanggal <= '$sampai_tanggal' AND dari_akun = 'Equipment'");
$cek15 = mysqli_fetch_array($query15);

$equipment_sales = $cek15['equipment_sales'];


$query7 = $db->query("SELECT SUM(jumlah) AS original_invesment FROM detail_kas_masuk WHERE  tanggal <= '$sampai_tanggal' AND dari_akun = 'Original Investment'");
$cek7 = mysqli_fetch_array($query7);

$original_investment = $cek7['original_invesment'];


//mencari nilai change in cash
$change_in_cash = $collections - $inventory_paid + $money_borrowed - $money_repaid - $reduce_payable - $investment_property - $investment_equipment - $investment_goodwill + $property_sales + $equipment_sales + $original_investment - $expanses_paid ;


// MENCARI JUMLAH KAS

            $query007 = $db->query("SELECT * FROM kas");
            $data = mysqli_fetch_array($query007);
      

            $query0 = $db->query("SELECT SUM(total) AS total_penjualan FROM penjualan WHERE cara_bayar = '$data[nama]'");
            $cek0 = mysqli_fetch_array($query0);
            $total_penjualan = $cek0['total_penjualan'];

            $query0000 = $db->query("SELECT SUM(kredit) AS kredit_penjualan FROM penjualan WHERE cara_bayar = '$data[nama]'");
            $cek0000 = mysqli_fetch_array($query0000);
            $kredit_penjualan = $cek0000['kredit_penjualan'];

            $query1 = $db->query("SELECT SUM(total) AS total_piutang FROM pembayaran_piutang WHERE dari_kas = '$data[nama]'");
            $cek1 = mysqli_fetch_array($query1);
            $total_piutang = $cek1['total_piutang'];

            $query2 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk FROM kas_masuk WHERE ke_akun = '$data[nama]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_kas_masuk = $cek2['jumlah_kas_masuk'];

            $query20 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk_mutasi FROM kas_mutasi WHERE ke_akun = '$data[nama]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_kas_masuk_mutasi = $cek20['jumlah_kas_masuk_mutasi'];

            $query200 = $db->query("SELECT SUM(total) AS total_retur_pembelian FROM retur_pembelian WHERE cara_bayar = '$data[nama]'");
            $cek200 = mysqli_fetch_array($query200);
            $total_retur_pembelian = $cek200['total_retur_pembelian'];

//total kas 1

            $kas_1 = $total_penjualan - $kredit_penjualan + $total_piutang + $jumlah_kas_masuk + $jumlah_kas_masuk_mutasi + $total_retur_pembelian;




            $query3 = $db->query("SELECT SUM(total) AS total_pembelian FROM pembelian WHERE cara_bayar = '$data[nama]'");
            $cek3 = mysqli_fetch_array($query3);
            $total_pembelian = $cek3['total_pembelian'];

            $query0001 = $db->query("SELECT SUM(kredit) AS kredit_pembelian FROM pembelian WHERE cara_bayar = '$data[nama]'");
            $cek0001 = mysqli_fetch_array($query0001);
            $kredit_pembelian = $cek0001['kredit_pembelian'];


            $query4 = $db->query("SELECT SUM(total) AS total_hutang FROM pembayaran_hutang WHERE dari_kas = '$data[nama]'");
            $cek4 = mysqli_fetch_array($query4);
            $total_hutang = $cek4['total_hutang'];

            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM kas_keluar WHERE dari_akun = '$data[nama]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar = $cek5['jumlah_kas_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar_mutasi FROM kas_mutasi WHERE dari_akun = '$data[nama]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_kas_keluar_mutasi = $cek5['jumlah_kas_keluar_mutasi'];

            $query5 = $db->query("SELECT SUM(total) AS total_retur_penjualan FROM retur_penjualan WHERE cara_bayar = '$data[nama]'");
            $cek5 = mysqli_fetch_array($query5);
            $total_retur_penjualan = $cek5['total_retur_penjualan'];



//total barang 2
            $kas_2 = $total_pembelian - $kredit_pembelian + $total_hutang + $jumlah_kas_keluar + $jumlah_kas_keluar_mutasi + $total_retur_penjualan;






            $ending_cash = $kas_1 - $kas_2;



//mencari nilai beginning scash
$beginning_cash = $ending_cash - $change_in_cash;


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>

<br><h3> Cash Statement Periode  <?php echo $sampai_tanggal; ?> </h3>
 <table id="table_cash_statement" class="table table-bordered">
                  <thead>
                  
                  <th bgcolor="#F39C12" style="color:white"> Cash Flow Statement </th>

                  </thead>

                  <tbody>
                  <tr>
                        <td> (+) Collections From Sales: <?php echo rp($collections); ?></td>
                  </tr>

                  <tr>
                        <td> (-) Inventory Paid : <?php echo rp($inventory_paid); ?></td>
                  </tr>
                  <tr>
                        <td> (+) Money Borrowed : <?php echo rp($money_borrowed); ?></td>
                  </tr>
                  <tr>
                        <td> (-) Money Repaid : <?php echo rp($money_repaid); ?></td>
                  </tr>

                  <tr>
                        <td> (-) Reduce Payable : <?php echo rp($reduce_payable); ?></td>
                  </tr>

                  <tr>
                  	<td> (-) Investment In Property  : <?php echo rp($investment_property); ?> </td>
                  </tr>

                  <tr>
                        <td> (-) Investment In Equipment  : <?php echo rp($investment_equipment); ?> </td>
                  </tr>

                  <tr>
                        <td> (-) Investment In Goodwill  : <?php echo rp($investment_goodwill); ?> </td>
                  </tr>

                  <tr>
                        <td> (+) Property Sales  :  <?php echo rp($property_sales); ?></td>
                  </tr>

                  <tr>
                        <td> (+) Equipment Sales  : <?php echo rp($equipment_sales); ?></td>
                  </tr>

                  <tr>
                        <td> (+) Original Investment : <?php echo rp($original_investment); ?></td>
                  </tr>

                  <tr>
                        <td> (-) Expenses Paid : <?php echo rp($expanses_paid); ?></td>
                  </tr>

                  <tr>
                        <td><h3><b>Change In Cash : <?php echo rp($change_in_cash); ?></b></h3></td>
                  </tr>

                  <tr>
                        <td><h3><b>Beginning Cash : <?php echo rp($beginning_cash); ?></b></h3></td>
                  </tr>

                  <tr>
                        <td><h3><b> Ending Cash : <?php echo rp($ending_cash); ?> </b></h3></td>
                  </tr>



                  </tbody>
</table>