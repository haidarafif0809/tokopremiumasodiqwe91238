<?php 
include 'sanitasi.php';
include 'db.php';




$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);




$kas = $db->query("SELECT * FROM kas");
$data = mysqli_fetch_array($kas);

               

            
// MENCARI JUMLAH KAS
            $query010 = $db->query("SELECT SUM(total) AS total_penjualan FROM penjualan WHERE cara_bayar = '$data[nama]'");
            $cek010 = mysqli_fetch_array($query010);
            $total_penjualan = $cek010['total_penjualan'];

            $query0000 = $db->query("SELECT SUM(kredit) AS kredit_penjualan FROM penjualan WHERE cara_bayar = '$data[nama]'");
            $cek0000 = mysqli_fetch_array($query0000);
            $kredit_penjualan = $cek0000['kredit_penjualan'];

            $query1010 = $db->query("SELECT SUM(total) AS total_piutang FROM pembayaran_piutang WHERE dari_kas = '$data[nama]'");
            $cek1010 = mysqli_fetch_array($query1010);
            $total_piutang = $cek1010['total_piutang'];

            $query2020 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk FROM kas_masuk WHERE ke_akun = '$data[nama]'");
            $cek2020 = mysqli_fetch_array($query2020);
            $jumlah_kas_masuk = $cek2020['jumlah_kas_masuk'];

            $query202 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_masuk_mutasi FROM kas_mutasi WHERE ke_akun = '$data[nama]'");
            $cek202 = mysqli_fetch_array($query202);
            $jumlah_kas_masuk_mutasi = $cek202['jumlah_kas_masuk_mutasi'];

            $query200 = $db->query("SELECT SUM(total) AS total_retur_pembelian FROM retur_pembelian WHERE cara_bayar = '$data[nama]'");
            $cek200 = mysqli_fetch_array($query200);
            $total_retur_pembelian = $cek200['total_retur_pembelian'];

//total kas 1

            $kas_1 = $total_penjualan - $kredit_penjualan + $total_piutang + $jumlah_kas_masuk + $jumlah_kas_masuk_mutasi + $total_retur_pembelian;




            $query303 = $db->query("SELECT SUM(total) AS total_pembelian FROM pembelian WHERE cara_bayar = '$data[nama]'");
            $cek303 = mysqli_fetch_array($query303);
            $total_pembelian = $cek303['total_pembelian'];

            $query0001 = $db->query("SELECT SUM(kredit) AS kredit_pembelian FROM pembelian WHERE cara_bayar = '$data[nama]'");
            $cek0001 = mysqli_fetch_array($query0001);
            $kredit_pembelian = $cek0001['kredit_pembelian'];


            $query404 = $db->query("SELECT SUM(total) AS total_hutang FROM pembayaran_hutang WHERE dari_kas = '$data[nama]'");
            $cek404 = mysqli_fetch_array($query404);
            $total_hutang = $cek404['total_hutang'];

            $query505 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM kas_keluar WHERE dari_akun = '$data[nama]'");
            $cek505 = mysqli_fetch_array($query505);
            $jumlah_kas_keluar = $cek505['jumlah_kas_keluar'];

            $query015 = $db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar_mutasi FROM kas_mutasi WHERE dari_akun = '$data[nama]'");
            $cek015 = mysqli_fetch_array($query015);
            $jumlah_kas_keluar_mutasi = $cek015['jumlah_kas_keluar_mutasi'];

            $query515 = $db->query("SELECT SUM(total) AS total_retur_penjualan FROM retur_penjualan WHERE cara_bayar = '$data[nama]'");
            $cek515 = mysqli_fetch_array($query515);
            $total_retur_penjualan = $cek515['total_retur_penjualan'];



//total barang 2
            $kas_2 = $total_pembelian - $kredit_pembelian + $total_hutang + $jumlah_kas_keluar + $jumlah_kas_keluar_mutasi + $total_retur_penjualan;







            $cash = $kas_1 - $kas_2;












//mencari nilai AR
$query1 = $db->query("SELECT SUM(kredit) AS jumlah_sisa FROM penjualan WHERE tanggal <= '$sampai_tanggal'");
$cek1 = mysqli_fetch_array($query1);

$account_receivable = $cek1['jumlah_sisa'];

//mencari nilai inventory
$query2 = $db->query("SELECT SUM(total) AS total_pembelian FROM pembelian WHERE tanggal <= '$sampai_tanggal'");
$cek2 = mysqli_fetch_array($query2);

$total_pembelian = $cek2['total_pembelian'];


$query3 = $db->query("SELECT SUM(total_hpp) AS jumlah_total_hpp FROM penjualan WHERE tanggal <= '$sampai_tanggal'");
$cek3 = mysqli_fetch_array($query3);

$jumlah_total_hpp = $cek3['jumlah_total_hpp'];

$inventory = $total_pembelian - $jumlah_total_hpp;

//mencari nilai equipment
$query16 = $db->query("SELECT SUM(jumlah) AS jumlah_equipment FROM detail_kas_masuk WHERE tanggal <= '$sampai_tanggal' AND dari_akun = 'Equipment'");
$cek16 = mysqli_fetch_array($query16);

$equipment_masuk = $cek16['jumlah_equipment'];

$query4 = $db->query("SELECT SUM(jumlah) AS jumlah_equipment FROM detail_kas_keluar WHERE tanggal <= '$sampai_tanggal' AND ke_akun = 'Equipment'");
$cek4 = mysqli_fetch_array($query4);

$equipment = $cek4['jumlah_equipment'];

$total_equipment = $equipment - $equipment_masuk;

//mencari nilai goodwill
$query20 = $db->query("SELECT SUM(jumlah) AS jumlah_goodwill FROM detail_kas_masuk WHERE tanggal <= '$sampai_tanggal' AND dari_akun = 'Goodwill'");
$cek20 = mysqli_fetch_array($query20);

$goodwill_masuk = $cek20['jumlah_goodwill'];

$query21 = $db->query("SELECT SUM(jumlah) AS jumlah_goodwill FROM detail_kas_keluar WHERE tanggal <= '$sampai_tanggal' AND ke_akun = 'Goodwill'");
$cek21 = mysqli_fetch_array($query21);

$goodwill = $cek21['jumlah_goodwill'];

$total_goodwill = $goodwill - $goodwill_masuk;

//mencari nilai money repaid
$query5 = $db->query("SELECT SUM(jumlah) AS money_repaid FROM detail_kas_keluar WHERE tanggal <= '$sampai_tanggal' AND ke_akun = 'Money Repaid'");
$cek5 = mysqli_fetch_array($query5);

$money_repaid = $cek5['money_repaid'];


$query5 = $db->query("SELECT SUM(jumlah) AS notes_payable  FROM detail_kas_masuk WHERE tanggal <= '$sampai_tanggal' AND dari_akun = 'Notes Payable'");
$cek5 = mysqli_fetch_array($query5);

$notes_payable = $cek5['notes_payable'] - $money_repaid;



$query6 = $db->query("SELECT SUM(jumlah) AS original_investment  FROM detail_kas_masuk WHERE tanggal <= '$sampai_tanggal' AND dari_akun = 'Original Investment'");
$cek6 = mysqli_fetch_array($query6);

$original_investment = $cek6['original_investment'];


// EARNING WEEK TO DATE
$query9 = $db->query("SELECT SUM(total) AS sales FROM penjualan WHERE tanggal <= '$sampai_tanggal'");
$cek9 =mysqli_fetch_array($query9);

$sales = $cek9['sales'];

$query7 = $db->query("SELECT SUM(total_hpp) AS hpp FROM penjualan WHERE tanggal <= '$sampai_tanggal'");
$cek7 = mysqli_fetch_array($query7);
$hpp = $cek7['hpp'];
$gross_profit = $sales - $hpp;

$query8 =$db->query("SELECT SUM(jumlah) AS jumlah_kas_keluar FROM detail_kas_keluar WHERE tanggal <= '$sampai_tanggal' AND ke_akun = 'Expenses'");
$cek8 = mysqli_fetch_array($query8);
$expenses = $cek8['jumlah_kas_keluar'];

$earnign_week_to_date = $gross_profit - $expenses;

// EARNING WEEK TO DATE

//
$query10 =$db->query("SELECT SUM(kredit) AS total_sisa FROM pembelian WHERE tanggal <= '$sampai_tanggal'");
$cek10 = mysqli_fetch_array($query10);
$account_payable = $cek10['total_sisa'];

$query15 =$db->query("SELECT SUM(jumlah) AS total_jumlah FROM detail_kas_masuk WHERE tanggal <= '$sampai_tanggal' AND dari_akun = 'Property'");
$cek15 = mysqli_fetch_array($query15);
$property_masuk = $cek15['total_jumlah'];

$query13 =$db->query("SELECT SUM(jumlah) AS total_jumlah FROM detail_kas_keluar WHERE tanggal <= '$sampai_tanggal' AND ke_akun = 'Property'");
$cek13 = mysqli_fetch_array($query13);
$property = $cek13['total_jumlah'];

$total_property = $property - $property_masuk;
//nilai TOTAL asset
$total_asset = $cash + $account_receivable + $inventory + $total_equipment + $total_property + $total_goodwill;

$total_liability = $account_payable + $notes_payable;

$total_equity = $original_investment +$earnign_week_to_date;

$total_seluruh = $total_liability + $total_equity;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>

<br><h3> Neraca Periode <?php echo $sampai_tanggal; ?> </h3>

 <table id="tableuser" class="table table-bordered">
                  <thead>
                  
                  <th bgcolor="#F39C12" style="color:white"> Asset </th>
                  <th bgcolor="#F39C12" style="color:white"> Liability  </th>
            
                  </thead>

                  <tbody>
                        <tr>
                         <td id="cash_statement">Cash : <?php echo rp($cash); ?> </td>
                         <td id="account_payable"> Account Payable : <?php echo rp($account_payable); ?></td>     

                        </tr>
                        <tr>
                          <td id="account_receivable"> Account Receivable : <?php echo rp($account_receivable); ?></td>
                          <td id="notes_payable"> Notes Payable : <?php echo rp($notes_payable); ?></td>    

                        </tr>
                        <tr>
                          <td id="inventory"> Inventory : <?php echo rp($inventory); ?></td>
                          <td> Tax Payable : </td>


                        </tr>

                        <tr>
                              <td id="equipment"> Equipment : <?php echo rp($total_equipment); ?></td>
                              <td> <h3><b>Total Liability : <?php echo rp($total_liability); ?></b></h3></td>
                        </tr>
                        <tr>

                        <td id="property">Property : <?php echo rp($total_property); ?></td>
                        <td bgcolor="#F39C12" style="color:white"> <b> Equity </b></td>

                        </tr>
                        <tr>
                              
                              <td> (Depresiasi) : </td>
                              <td id="original_investment"> Original Investment : <?php echo rp($original_investment); ?></td>
                        </tr>
                        <tr>
                             <td id="goodwill"> Goodwill : <?php echo rp($total_goodwill); ?></td> 
                             <td> Retained Earning :</td>
                        </tr>
                        <tr>
                              <td> (Amortisasi) :</td>
                              <td id="earning_week"> Earning Week To Date : <?php echo rp($earnign_week_to_date); ?></td>
                        </tr>
                        <tr>
                              <td></td>
                              <td> <h3><b>Total Equity : <?php echo rp($total_equity); ?></b></h3></td>
                        </tr>
                        <tr>

                              <td bgcolor="#6C7A89"> <h3> <b>Total Asset : <?php echo rp($total_asset); ?></b></h3></td>

                              <td bgcolor="#6C7A89"> <h3><b> Liability + Equity : <?php echo rp($total_seluruh); ?></b></h3></td>
                        </tr>

                  </tbody>
</table>
<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
<span id="demo"> </span>

       <script>
       
       
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#earning_week").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();

       $.post("proses_income_statement.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       
       
       
       });
       
       });
       
       </script>


       <script type="text/javascript">
       $("#submit_close").click(function(){
       
       $('#demo').hide();
       $('#submit_close').hide();
       
       });
       
       </script>
       
       <script type="text/javascript">
       $("#cash_statement").click(function() {
       
       $("#submit_close").show();
       $("#demo").show();
       $.post("proses_cash_statement.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       
       
       
       });
       
       });
       
       </script>


       <script>
       
 
       $("#equipment").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_equipment.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script>

       <script>
       
       
       $("#property").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_property.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script>

       <script>
    
       $("#notes_payable").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_notes_payable.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script>


       <script>
       
       
       $("#notes_payable").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_notes_payable.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script>

       <script>
       
       
       $("#original_investment").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_original_investment.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script>       

       <script>
       
       
       $("#goodwill").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_goodwill.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script>         

       <script>
       
       
       $("#account_payable").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_account_payable.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script> 

       <script>
       
       
       $("#account_receivable").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_account_receivable.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script>

       <script>
       
       
       $("#inventory").click(function(){
       
       $("#submit_close").show();
       $("#demo").show();


       $.post("proses_inventory.php",{sampai_tanggal:'<?php echo $sampai_tanggal; ?>'},function(info) {
       $("#demo").html(info);
       
       });
       
       });
       
       </script>
       