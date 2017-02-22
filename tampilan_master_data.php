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
      <div class="col1 clearfix">

<a href="user.php">
        <li class="tile tile-big tile-1 slideTextUp" data-page-type="r-page" data-page-name="random-r-page">
        
          <div><p style="font-size: 60px"><img src="images/businessman-8.png" style="width:100px; height:100px" >User </p></div>
          <div><p style="font-size: 60px"><img src="images/businessman-8.png" style="width:100px; height:100px" >User </p></div>
        </li>
</a>

<a href="setting_perusahaan.php">
        <li class="tile tile-small tile-1 slideTextLeft" data-page-type="r-page" data-page-name="random-r-page">
        
          <div style="background-color:#69f0ae"><p style="font-size: 25px"><img src="images/gears-triangle.png" style="width:100px; height:100px"><img src="images/urban-buildings.png" style="width:50px; height:50px">Set. Perusahaan </p></div>
          <div style="background-color:#69f0ae"><p style="font-size: 25px"><img src="images/gears-triangle.png" style="width:100px; height:100px"><img src="images/urban-buildings.png" style="width:50px; height:50px">Set. Perusahaan </p></div>
        </li>
</a>

<a href="set_diskon_tax.php">
        <li class="tile tile-small last tile-10" data-page-type="s-page" data-page-name="custom-page">
          <div><p><img src="images/gears-triangle.png" style="width:100px; height:100px"><img src="images/percentage-sign.png" style="width:30px; height:30px"><br>Set. Diskon/Pajak</p></div>
        </li>
</a>

<a href="satuan.php">
        <li class="tile tile-small tile tile-2 slideTextRight" data-page-type="s-page" data-page-name ="random-restored-page">
          <div style="background-color:#e6ee9c"><p class="icon-arrow-right"></p></div>
          <div style="background-color:#e6ee9c"><p  style="font-size: 50px;" >Satuan</p></div>
        </li>
</a> 

<a href="jabatan.php">
        <li class="tile tile-small last tile-20" data-page-type="r-page" data-page-name="random-r-page">
          <center><p style="font-size: 30px;"><img src="images/hierarchical-structure.png" style="width:120px; height:120px"><br>Jabatan</p></center>
        </li>
</a>


   <a href="barang.php?kategori=semua">
        <li class="tile tile-big tile tile-2 slideTextRight" data-page-type="s-page" data-page-name ="random-restored-page">
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


      

      </div>


      <div class="col2 clearfix">
<a href="pelanggan.php">
        <li class="tile tile-big tile-5 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
          <div><p><img src="images/networking-20.png" style="width:120px; height:120px">Pelanggan </p></div>
          <div><p><img src="images/networking-20.png" style="width:120px; height:120px">Pelanggan </p></div>
        </li>
 </a>

 <a href="suplier.php">
        <li class="tile tile-big tile-13 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
          <div><p style="font-size: 50px;" ><img src="images/businessman-13.png" style="width:120px; height:120px">Suplier </p></div>
          <div><p style="font-size: 50px;" ><img src="images/businessman-13.png" style="width:120px; height:120px">Suplier </p></div>
        </li>
 </a>


        <!--Tiles with a 3D effect should have the following structure:
            1) a container inside the tile with class of .faces
            2) 2 figure elements, one with class .front and the other with class .back-->
<a href="pemasukan.php">
        <li class="tile tile-small tile-7 rotate3d rotate3dX" data-page-type="r-page" data-page-name="random-r-page">
          <div class="faces">
            <div class="front"><p style="font-size: 25px;"><img src="images/money-126.png" style="width:100px; height:100px"> Pemasukan </p></div>
            <div class="back"></div>
          </div>
        </li>
</a>

<a href="pengeluaran.php">
        <li class="tile tile-small last tile-8 rotate3d rotate3dY" data-page-type="r-page" data-page-name="random-r-page">
          <div class="faces">
            <div class="front"><p style="font-size: 25px;"><img src="images/money-132.png" style="width:100px; height:100px">Pengeluaran</p></div>
            <div class="back"></div>
          </div>
        </li>
</a>

 <a href="hak_otoritas.php">
        <li class="tile tile-big tile-13 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
          <div><p style="font-size: 50px;" ><img src="images/businessman-13.png" style="width:120px; height:120px">Hak Otoritas </p></div>
          <div><p style="font-size: 50px;" ><img src="images/businessman-13.png" style="width:120px; height:120px">Hak Otoritas </p></div>
        </li>
 </a>

      </div>

<div class="col3 clearfix">

<a href="fee_produk.php">      
        <li class="tile tile-2xbig tile-21 fig-tile" data-page-type="custom-page" data-page-name="random-r-page">

            <div><p style="font-size: 50px;"><img src="images/hierarchy.png" style="width:150px; height:150px"><br>Komisi Produk </p></div>
          <div><p style="font-size: 50px;"><img src="images/hierarchy.png" style="width:150px; height:150px"><br>Komisi Produk </p></div>   

        </li>
</a>

<a href="fee_faktur.php">
        <li class="tile tile-big tile-10" data-page-type="s-page" data-page-name="custom-page">
          <div><p style="font-size: 35px;"><img src="images/hierarchy.png" style="width:120px; height:120px">Komisi Faktur</p></div>
        </li>
</a>


<a href="kategori_barang.php">
        <li class="tile tile-big tile-12 slideTextRight" data-page-type="r-page" data-page-name="random-r-page">
          <div ><p class="front"><p style="font-size: 35px;"><img src="images/signature.png" style="width:100px; height:100px">Kategori Barang </p></div>
          <div><p class="front"><p style="font-size: 35px;"><img src="images/signature.png" style="width:100px; height:100px">Kategori Barang </p></div>
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
