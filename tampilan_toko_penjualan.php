<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>TOKO</title>

  <link rel="stylesheet" href="css/demo-styles.css" />
  <script src="js/modernizr-1.5.min.js"></script>

</head>

<body>
 <header>
 <a href="www.andaglos.com"> PT. Andaglos Global Teknologi</a>
 </header>
  <!--===============================Start Demo====================================================-->
<div class="demo-wrapper">
<!-- classnames for the pages should include: 1) type of page 2) page name-->

<!--each tile should specify what page type it opens (to determine which animation) and the corresponding page name it should open-->
  <div class="dashboard clearfix">
    <ul class="tiles">

<div class="col1 clearfix">

</div>
      
      <div class="col2 clearfix">

<a href="penjualan.php?status=semua">
        <li class="tile tile-big tile-10 slideTextUp" data-page-type="s-page" data-page-name="custom-page">
          <div><p style="font-size: 45px"><img src="images/shopping-cart-2.png" style="width:100px; height:100px" />Penjualan</p></div>
          <div><p style="font-size: 45px"><img src="images/shopping-cart-2.png" style="width:100px; height:100px" />POS</p></div>
          
        </li>
</a>

<a href="pembayaran_piutang.php">
        <li class="tile tile-big tile tile-1 slideTextRight" data-page-type="s-page" data-page-name ="random-restored-page">
          <div><p  style="font-size: 25px"><img src="images/money-68.png" style="width:100px; height:100px" />Pembayaran Piutang</p></div>
          <div><p><p style="font-size: 35px"><img src="images/money-68.png" style="width:100px; height:100px" />Pembayaran </p></div>
        </li>
</a>

        <!--Tiles with a 3D effect should have the following structure:
            1) a container inside the tile with class of .faces
            2) 2 figure elements, one with class .front and the other with class .back-->
<a href="retur_penjualan.php">
          <li class="tile tile-big tile-5" data-page-type="r-page" data-page-name="random-r-page">
            <div class="front"><p style="font-size: 35px"><img src="images/shopping.png" style="width:100px; height:100px" />Retur Penjualan</p></div>
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
