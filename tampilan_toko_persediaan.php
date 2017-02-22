<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
    <br><br><br><br>
      <div class="col1 clearfix">



      </div>


      <div class="col2 clearfix">

      <a href="stok_awal.php">
        <li class="tile tile-small tile-1 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
          <div><p style="font-size: 30px"> <img src="images/commerce.png" style="width:100px; height:100px" /><br> Stok Awal </p></div>
          <div><p style="font-size: 30px"> <img src="images/commerce.png" style="width:100px; height:100px" /><br> Stok Awal </p></div>
        </li>
</a>

 <a href="barang.php?kategori=semua">
        <li class="tile tile-small last tile tile-2 slideTextRight" data-page-type="s-page" data-page-name ="random-restored-page">
          <div style="background-color:#ff8a80"><br>
          <tabled>

<td><p  style="font-size: 25px;" > ...</p></td>
          </table>

          </div>
          <div style="background-color:#ff3d00">
          <tabled >
            <td><p  style="font-size: 70px;" ></p></td><br>
            <td><p  style="font-size: 25px;" > Item </p></td>
          </table>
          </div>
        </li>
 </a>
     


      <a href="stok_opname.php">
        <li class="tile tile-small  tile-5 slideTextLeft" data-page-type="r-page" data-page-name="random-r-page">
          <div><p  style="font-size: 25px"> <img src="images/cart.png" style="width:100px; height:100px" /><br> Stok Opname </p></div>
          <div><p  style="font-size: 25px"> <img src="images/cartpng" style="width:100px; height:100px" /><br> Stok Opname </p></div>
        </li>
 </a>  



<a href="item_masuk.php">
        <li class="tile tile-small last tile-6 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
          <div><p style="font-size: 30px"><img src="images/add.png" style="width:100px; height:100px" /><br> Item Masuk</p></div>
          <div><p style="font-size: 30px"><img src="images/add.png" style="width:100px; height:100px" /><br> Item Masuk</p></div>
        </li>
 </a>

       <a href="kartu_stok.php">
        <li class="tile tile-small tile-10 right" data-page-type="s-page" data-page-name="custom-page">
          <div><p style="font-size: 50px;">Kartu Stok</p></div>
        </li>
</a>

<a href="item_keluar.php">
        <li class="tile tile-small last tile-11 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
          <div><p style="font-size: 30px"><img src="images/up-arrow.png" style="width:100px; height:100px" /> Item Keluar</p></div>
          <div><p style="font-size: 30px"><img src="images/up-arrow.png" style="width:100px; height:100px" /> Item Keluar</p></div>
        </li>
</a>

      </div>

      <div class="col3 clearfix">  





      </div>
    </ul>
  </div><!--end dashboard-->

</div>
<!--====================================end demo wrapper================================================-->
  <script src="js/jquery-1.8.2.min.js"></script>
  <script src="js/scripts.js"></script>

</body>
</html>
