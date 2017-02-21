<?php include_once 'session_login.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Material Design Bootstrap Template</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap4.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">

</head>

<body class="hidden-sn deep-orange-skin">

<div id="modal_logout" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: black">Konfirmasi LogOut</h4>
      </div>

      <div class="modal-body">
   
   <h3 style="color: black">Apakah Anda Yakin Ingin Keluar ?</h3>
 

     </div>

      <div class="modal-footer">
        <a href="logout.php"> <button class="btn btn-warning" ><i class="fa  fa-check "></i> Ya </button></a>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa  fa-close "></i> Batal</button>
      </div>
    </div>

  </div>
</div>

    <!--Double navigation-->
    <header>

        <!-- Sidebar navigation -->
        <ul id="slide-out" class="side-nav custom-scrollbar">

            <!-- Logo -->
            <li>
                <div class="logo-wrapper waves-light">
                    <a href="http://www.andaglos.com"><img src="save_picture/andaglos_logo.png" class="img-fluid flex-center"></a>
                </div>
            </li>
            <!--/. Logo -->

            <!--Social-->
            <li>
                <ul class="social">
                    <li><a class="icons-sm fb-ic" href="#"><i class="fa fa-facebook"> </i></a></li>
                    <li><a class="icons-sm gplus-ic" href="#"><i class="fa fa-google-plus"> </i></a></li>
                </ul>
            </li>
            <!--/Social-->

          
            <!-- Side navigation links -->
            <li>
                <ul class="collapsible collapsible-accordion">


                <li><a href="penjualan.php?status=semua" class="waves-effect"> <i class="fa fa-cart-plus"></i> Penjualan </a></li>

                <li><a href="pembelian.php" class="waves-effect"> <i class="fa fa-cart-plus"></i> Pembelian </a></li>

                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-server"></i> Master Data <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="user.php" class="waves-effect">User</a></li>
                                <li><a href="jabatan.php" class="waves-effect">Jabatan</a></li>
                                <li><a href="hak_otoritas.php" class="waves-effect">Otoritas</a></li>
                                <li><a href="suplier.php" class="waves-effect">Suplier</a></li>
                                <li><a href="pelanggan.php" class="waves-effect">Pelanggan</a></li>
                                <li><a href="barang.php?kategori=semua" class="waves-effect">Item</a></li>
                                <li><a href="satuan.php" class="waves-effect">Satuan</a></li>
                                <li><a href="kategori_barang.php" class="waves-effect">Kategori</a></li>
                                <li><a href="fee_produk.php" class="waves-effect">Komisi Produk</a></li>
                                <li><a href="fee_faktur.php" class="waves-effect">Komisi Faktur</a></li>
                                <li><a href="gudang.php" class="waves-effect">Gudang</a></li>
                                <li><a href="daftar_akun.php" class="waves-effect">Daftar Akun</a></li>
                                <li><a href="daftar_group_akun.php" class="waves-effect">Group Akun</a></li>
                                <li><a href="setting_akun_data_item.php" class="waves-effect">Setting Akun</a></li>
                                <li><a href="setting_perusahaan.php" class="waves-effect">Data Perusahaan</a></li>
                                <li><a href="set_diskon_tax.php" class="waves-effect">Default Diskon & Pajak</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-chevron-right"></i> Pembayaran <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="pembayaran_hutang.php" class="waves-effect">Hutang</a></li>
                                <li><a href="pembayaran_piutang.php" class="waves-effect">Piutang</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-chevron-right"></i> Transaksi <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="kas_masuk.php" class="waves-effect">Kas Masuk</a></li>
                                <li><a href="kas_keluar.php" class="waves-effect">Kas Keluar</a></li>
                                <li><a href="kas_mutasi.php" class="waves-effect">Kas Mutasi</a></li>
                            </ul>
                        </div>
                    </li>

                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-chevron-right"></i> Persediaan <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="barang.php?kategori=semua" class="waves-effect">Item</a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Item Masuk</a></li>
                                <li><a href="item_keluar.php" class="waves-effect">Item Keluar</a></li>
                                <li><a href="stok_awal.php" class="waves-effect">Stok Awal</a></li>
                                <li><a href="stok_opname.php" class="waves-effect">Stok Opname</a></li>
                                <li><a href="lap_mutasi_stok.php" class="waves-effect">Lap. Mutasi Stok</a></li>
                            </ul>
                        </div>
                    </li>


                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-exchange"></i> Retur <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="retur_penjualan.php" class="waves-effect">Retur Penjualan</a></li>
                                <li><a href="retur_pembelian.php" class="waves-effect">Retur Pembelian</a></li>
                            </ul>
                        </div>
                    </li>


                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-balance-scale"></i> Akuntansi <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="barang.php?kategori=semua" class="waves-effect">Buku Besar</a></li>
                                <li><a href="stok_awal.php" class="waves-effect">Lap. Neraca</a></li>
                                <li><a href="lap_mutasi_stok.php" class="waves-effect">Lap. Laba Rugi</a></li>
                                <li><a href="item_keluar.php" class="waves-effect">Lap. Laba Kotor </a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Lap. Jurnal</a></li>
                                <li><a href="stok_opname.php" class="waves-effect">Transaksi Jurnal Manual</a></li>
                            </ul>
                        </div>
                    </li>


                    <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-book"></i> Laporan <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="lap_mutasi_stok.php" class="waves-effect">Lap. Penjualan</a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Lap. Pembelian</a></li>
                                <li><a href="item_keluar.php" class="waves-effect">Lap. Piutang Beredar </a></li>
                                <li><a href="stok_opname.php" class="waves-effect">Lap. Hutang Beredar</a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Lap. Retur Penjualan</a></li>
                                <li><a href="stok_opname.php" class="waves-effect">Lap. Retur Pembelian</a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Lap. Pembayaran Piutang</a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Lap. Pembayaran Hutang</a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Lap. Komisi </a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Lap. Komisi / Produk</a></li>
                                <li><a href="item_masuk.php" class="waves-effect">Lap. Komisi / Faktur </a></li>
                            </ul>
                        </div>
                    </li>



                <li><a href="kas.php" class="waves-effect"> <i class="fa fa-money"></i> Posisi Kas </a></li>

                <li><a href="http://www.andaglos.com" class="waves-effect"> <i class="fa fa-envelope"></i> Contact Us </a></li>
                    


                </ul>
            </li>
            <!--/. Side navigation links -->

        </ul>
        <!--/. Sidebar navigation -->

        <!--Navbar-->
        <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

            <!-- SideNav slide-out button -->
            <div class="pull-left">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
            </div>





          <?php 

			include_once 'db.php';
			
			$perusahaan = $db->query("SELECT * FROM perusahaan ");
			$ambil_perusahaan = mysqli_fetch_array($perusahaan);


           ?>


            <div class="breadcrumb-dn">
                <p><?php echo $ambil_perusahaan['nama_perusahaan']; ?></p>
            </div>

            <ul class="nav navbar-nav pull-right">
				
				<li class="nav-item">
				<a class="nav-link" href="form_ubah_password.php"> Ubah Password</a>

				</li>

				<li class="nav-item ">
                    <a href="http://www.andaglos.com" class="nav-link"><i class="fa fa-envelope"></i> <span class="hidden-sm-down">Contact Us</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link"><i class="fa fa-user"></i> <span class="hidden-sm-down"><?php echo $_SESSION['nama'];?></span>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link" id="loguot"><i class="fa  fa-sign-out" data-toggle="modal" ></i> <span class="hidden-sm-down">LogOut</span>
                    </a>

                </li>
                
                
            </ul>

        </nav>
        <!--/.Navbar-->

    </header>
    <!--/Double navigation-->

    <main>
       
    </main>

    <!-- SCRIPTS -->

    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>

    <!-- Tooltips -->
    <script type="text/javascript" src="js/tether.min.js"></script>

    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap4.min.js"></script>

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <script>
         // SideNav init
        $(".button-collapse").sideNav();

        // Custom scrollbar init
        var el = document.querySelector('.custom-scrollbar');
        Ps.initialize(el);
    </script>


    <script type="text/javascript">

  
    $("#loguot").click(function(){

    $("#modal_logout").modal('show');
    

    
    });

</script>

</body>

</html>