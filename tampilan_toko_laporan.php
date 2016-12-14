<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>TOKO</title>

  <link rel="stylesheet" href="css/demo-styles.css" />
  <script src="js/modernizr-1.5.min.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
 <header>
 <a href="http://www.andaglos.com"> PT. Andaglos Global Teknologi</a>
 </header>
  <!--===============================Start Demo====================================================-->
<div class="demo-wrapper">
<!-- classnames for the pages should include: 1) type of page 2) page name-->
  <div class="s-page random-restored-page">
    <h2 class="page-title">Some minimized App</h2>
    <div class="close-button s-close-button">x</div>
  </div>
  <div class="s-page custom-page">
    <h2 class="page-title">Thank You!</h2>
    <div class="close-button s-close-button">x</div>
  </div>


  <div class="r-page random-r-page">

    <div class="page-content">
      <h2 class="page-title"></h2>

    </div>
    
    <div class="close-button r-close-button">x</div>
  </div>
<!--each tile should specify what page type it opens (to determine which animation) and the corresponding page name it should open-->
  <div class="dashboard clearfix">
    <ul class="tiles">

    <br><br>
      <div class="col1 clearfix">

<a href="lap_jumlah_fee.php">
        <li class="tile tile-big tile-1 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
          <div>
          <br><p style="font-size: 40px"><img src="images/delivery.png" style="width:100px; height:100px" />Jumlah Komisi</p>
          </div>
          <div>
          <br><p style="font-size: 30px"><img src="images/delivery.png" style="width:100px; height:100px" />Laporan Jumlah Komisi</p>
          </div>
        </li>
</a>

<a href="laporan_cash_flow_perperiode.php">
        <li class="tile tile-small tile tile-2 slideTextRight" data-page-type="s-page" data-page-name ="random-restored-page">
          <div style="background-color:#ff1744">
          
            <td><font color="white"><p  style="font-size: 25px;" ><br>Laporan Cash Flow Per - Periode</p></font></td>
          </div>

          <div style="background-color:#ff1744">
          <tabled >
          	<td><p  style="font-size: 70px;" ><img src="images/delivery.png" style="width:100px; height:100px" /></p></td><br>
          	<td><p  style="font-size: 20px;" >Cash Flow / Periode</p></td>
          </table>
          </div>
        </li>
 </a>

<a href="laporan_cash_flow_pertanggal.php">
        <li class="tile tile-small last tile-15" data-page-type="r-page" data-page-name="random-r-page">
        <div>
        <td><font color="black"> <p style="font-size: 30px"><img src="images/delivery.png" style="width:100px; height:100px" /><br> Komisi Produk  </p> </font></td><br>
        </font>
        </div>
        </li>
    </a>    

  <a href="tampilan_toko_transaksi.php">
        <li class="tile tile-small tile tile-2 slideTextRight" data-page-type="s-page" data-page-name ="random-restored-page">
          <div style="background-color:#1a237e"><br>

          <br><p style="font-size: 25px">Laporan Cash FLow Per - Tanggal</p>
          </div>

          <div style="background-color:#1a237e">
          <tabled >
            <td><p  style="font-size: 70px;" ><img src="images/delivery.png" style="width:100px; height:100px" /></p></td><br>
            <td><p  style="font-size: 20px;" >Cash Flow / tanggal</p></td>
          </table>
          </div>
        </li>
 </a>

<a href="laporan_fee_faktur.php">
        <li class="tile tile-small last tile-13" data-page-type="r-page" data-page-name="random-r-page">
        <div>
        <p style="font-size: 30px"><img src="images/delivery.png" style="width:100px; height:100px" /><br> Komisi Faktur </p><br>

        </div>
        </li>
    </a>   


      </div>


      <div class="col2 clearfix">

      <a href="lap_retur_pembelian.php">
            <li class="tile tile-small tile-21" data-page-type="r-page" data-page-name="random-r-page">
    
          <div><p style="font-size: 20px"> <img src="images/delivery.png" style="width:100px; height:100px" /> <br> Lap. Retur Pembelian </p></div>
        </li>
</a>

<a href="lap_retur_penjualan.php">
        <li class="tile tile-small last tile-21 slideTextLeft" data-page-type="r-page" data-page-name="random-r-page">
          <div><p style="font-size: 20px"><img src="images/delivery.png" style="width:100px; height:100px" /></span><br>Lap. Retur Penjualan</p></div>
          <div><p style="font-size: 20px">User,  Satuan, Jabatan, Pelanggan, Suplier, Item...</p></div>
        </li>
 </a>



<a href="lap_pembelian.php">
        <li class="tile tile-big tile-10 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
        <div><br>
          <tabled>

           <td><p style="font-size: 20px"><span class="glyphicon glyphicon-ok-circle"></span>Laporan Pembelian Detail</p></td><br>
          <td><p style="font-size: 20px"><span class="glyphicon glyphicon-ok-circle"></span>Laporan Pembelian Rekap</p></td><br>
          <td><p style="font-size: 20px"><span class="glyphicon glyphicon-ok-circle"></span>Laporan Pembelian Harian</p></td><br>  

          </table>

          </div>
          <div><p style="font-size: 40px"><img src="images/delivery.png" style="width:100px; height:100px" /></span>Laporan Pembelian</p></div>
        </li>
 </a>

 <a href="lap_penjualan.php">
        <li class="tile tile-big tile-13 slideTextLeft" data-page-type="r-page" data-page-name="random-r-page">
          <div><p style="font-size: 40px"><img src="images/delivery.png" style="width:100px; height:100px" /></span>Laporan Penjualan</p></div>
          
          <div><br>
          <tabled>

           <td><p style="font-size: 20px"><span class="glyphicon glyphicon-ok-circle"></span>Laporan Penjualan Detail</p></td><br>
          <td><p style="font-size: 20px"><span class="glyphicon glyphicon-ok-circle"></span>Laporan Penjualan Rekap</p></td><br>
          <td><p style="font-size: 20px"><span class="glyphicon glyphicon-ok-circle"></span>Laporan Penjualan Harian</p></td><br>  

          </table>

          </div>
        </li>
 </a>

   <a href="laporan_pemasukan_pertanggal.php">
        <li class="tile tile-big tile-5 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
          <div><p  style="font-size: 30px">Laporan Pemasukan / Akun Per - Tanggal </p></div>
          <div><p style="font-size: 23px"><img src="images/delivery.png" style="width:100px; height:100px" /><br>Laporan Pemasukan / Akun Per - Tanggal</p></div>
        </li>
 </a>


      </div>

      <div class="col3 clearfix">

<a href="lap_pembayaran_hutang.php">
            <li class="tile tile-small tile-6" data-page-type="r-page" data-page-name="random-r-page">
    
          <div><p style="font-size: 20px"> <img src="images/delivery.png" style="width:100px; height:100px" /> <br>Lap. Pembayaran Hutang</p></div>
        </li>
</a>

<a href="lap_pembayaran_piutang.php">
            <li class="tile tile-small last tile-13" data-page-type="r-page" data-page-name="random-r-page">
    
          <div><p style="font-size: 20px"> <img src="images/delivery.png" style="width:100px; height:100px" /> <br>Lap. Pembayaran Piutang</p></div>
        </li>
</a>

      <a href="laporan_penjualan_piutang.php">
            <li class="tile tile-big last tile-20" data-page-type="r-page" data-page-name="random-r-page">
    
          <div><p style="font-size: 25px"> <img src="images/delivery.png" style="width:100px; height:100px" /> Laporan Penjualan Piutang </p></div>
        </li>
</a>

 <a href="laporan_pembelian_hutang.php">
        <li class="tile tile-big tile-14 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
          <div><p  style="font-size: 30px">Laporan Pembelian Hutang </p></div>
          <div><p style="font-size: 28px"><img src="images/delivery.png" style="width:100px; height:100px" />Laporan Pembelian Hutang </p></div>
        </li>
 </a>

  <a href="laporan_pemasukan_perperiode.php">
        <li class="tile tile-big tile-15 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
          <div><p  style="font-size: 30px">Laporan Pemasukan / Akun Per - Periode </p></div>
          <div><p style="font-size: 23px"><img src="images/delivery.png" style="width:100px; height:100px" /><br>Laporan Pemasukan / Akun Per - Periode</p></div>
        </li>
 </a>





      </div>
    </ul>
  </div><!--end dashboard-->

</div>
<!--====================================end demo wrapper================================================-->
  <script src="js/jquery-1.8.2.min.js"></script>
  <script src="js/scripts.js"></script>

</body>
</html>
