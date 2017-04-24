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

<a href="kas_masuk.php">
        <li class="tile tile-big tile-10 slideTextUp" data-page-type="s-page" data-page-name="custom-page">
          <div><p style="font-size: 30px"><img src="images/payment-method-2.png" style="width:100px; height:100px" />Transaksi Kas Masuk</p></div>
          <div><p style="font-size: 30px"><img src="images/payment-method-2.png" style="width:100px; height:100px" />Transaksi Kas Masuk</p></div>
          
        </li>
</a>

<a href="kas_keluar.php">
        <li class="tile tile-big tile-15 slideTextLeft" data-page-type="s-page" data-page-name="custom-page">
          <div><p style="font-size: 30px"><img src="images/payment-method-2.png" style="width:100px; height:100px" />Transaksi Kas Keluar</p></div>
          <div><p style="font-size: 30px"><img src="images/payment-method-2.png" style="width:100px; height:100px" />Transaksi Kas Keluar</p></div>
          
        </li>
</a>

        <!--Tiles with a 3D effect should have the following structure:
            1) a container inside the tile with class of .faces
            2) 2 figure elements, one with class .front and the other with class .back-->
<a href="kas_mutasi.php">
          <li class="tile tile-big tile-5" data-page-type="r-page" data-page-name="random-r-page">
            <div class="front"><p style="font-size: 30px"><img src="images/payment-method-2.png" style="width:100px; height:100px" />Transaksi Kas Mutasi</p></div>
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
