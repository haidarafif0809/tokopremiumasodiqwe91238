
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
                    <li><a class="icons-sm fb-ic" href="https://www.facebook.com/andaglos/?fref=ts"><i class="fa fa-facebook"> </i></a></li>
                    <li><a class="icons-sm gplus-ic" href="#"><i class="fa fa-google-plus"> </i></a></li>
                </ul>
            </li>
            <!--/Social-->

          
            <!-- Side navigation links -->
            <li>
                <ul class="collapsible collapsible-accordion">

<?php 
include 'db.php';

$pilih_akses_lihat = $db->query("SELECT open.penjualan_lihat, open.retur_lihat, open.retur_penjualan_lihat, opemb.pembelian_lihat, opemb.retur_pembelian_lihat, omd.master_data_lihat, omd.user_lihat, omd.satuan_lihat, omd.pelanggan_lihat, omd.jabatan_lihat, omd.suplier_lihat, omd.master_data_lihat, omd.item_lihat, omd.komisi_faktur_lihat, omd.komisi_produk_lihat, omd.set_perusahaan_lihat, omd.set_diskon_tax_lihat, omd.hak_otoritas_lihat, omd.kategori_lihat, omd.gudang_lihat, omd.daftar_akun_lihat, omd.grup_akun_lihat, omd.set_akun_lihat, omd.daftar_pajak_lihat, p.pembayaran_lihat, p.pembayaran_hutang_lihat, p.pembayaran_piutang_lihat, otk.transaksi_kas_lihat, okm.kas_masuk_lihat, okk.kas_keluar_lihat, okmu.kas_mutasi_lihat, op.persediaan_lihat, oim.item_masuk_lihat, oik.item_keluar_lihat, osa.stok_awal_lihat, oso.stok_opname_lihat, okas.kas_lihat, olap.akuntansi_lihat, olap.laporan_mutasi_stok_lihat, olap.laporan_lihat, olap.buku_besar_lihat, olap.laporan_jurnal_lihat, olap.laporan_laba_rugi_lihat, olap.laporan_laba_kotor_lihat, olap.laporan_neraca_lihat, olap.transaksi_jurnal_manual_lihat, olap.cash_flow_tanggal_lihat, olap.cash_flow_periode_lihat, olap.laporan_komisi_lihat, olap.laporan_komisi_produk_lihat, olap.laporan_komisi_faktur_lihat, olap.laporan_pembelian_lihat, olap.laporan_hutang_beredar_lihat, olap.laporan_penjualan_lihat, olap.laporan_piutang_beredar_lihat, olap.laporan_retur_penjualan_lihat, olap.laporan_retur_pembelian_lihat, olap.laporan_pembayaran_hutang_lihat, olap.laporan_pembayaran_piutang_lihat FROM hak_otoritas AS ho INNER JOIN otoritas_penjualan AS open ON ho.id = open.id_otoritas INNER JOIN otoritas_pembelian AS opemb ON ho.id = opemb.id_otoritas INNER JOIN otoritas_master_data AS omd ON ho.id = omd.id_otoritas INNER JOIN otoritas_pembayaran AS p ON ho.id = p.id_otoritas INNER JOIN otoritas_transaksi_kas AS otk ON ho.id = otk.id_otoritas INNER JOIN otoritas_kas_masuk AS okm ON ho.id = okm.id_otoritas INNER JOIN otoritas_kas_keluar AS okk ON ho.id = okk.id_otoritas INNER JOIN otoritas_kas_mutasi AS okmu ON ho.id = okmu.id_otoritas INNER JOIN otoritas_persediaan AS op ON ho.id = op.id_otoritas INNER JOIN otoritas_item_masuk AS oim ON ho.id = oim.id_otoritas INNER JOIN otoritas_item_keluar AS oik ON ho.id = oik.id_otoritas INNER JOIN otoritas_stok_awal AS osa ON ho.id = osa.id_otoritas INNER JOIN otoritas_stok_opname AS oso ON ho.id = oso.id_otoritas INNER JOIN otoritas_laporan AS olap ON ho.id = olap.id_otoritas INNER JOIN otoritas_kas AS okas ON ho.id = okas.id_otoritas WHERE ho.id = '$_SESSION[otoritas_id]'");
$lihat = mysqli_fetch_array($pilih_akses_lihat);



if ($lihat['penjualan_lihat'] > 0){
                echo '<li><a href="penjualan.php?status=semua" class="waves-effect"> <i class="fa fa-shopping-cart"></i> Penjualan </a></li>';
}

if ($lihat['pembelian_lihat'] > 0){

                echo '<li><a href="pembelian.php" class="waves-effect"> <i class="fa fa-shopping-basket"></i> Pembelian </a></li>';
}

if ($lihat['master_data_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-server"></i> Master Data <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

if ($lihat['user_lihat'] > 0){
                                echo '<li><a href="user.php" class="waves-effect">User</a></li>';
}

if ($lihat['jabatan_lihat'] > 0){                               
                                echo '<li><a href="jabatan.php" class="waves-effect">Jabatan</a></li>';
}

if ($lihat['hak_otoritas_lihat'] > 0){
                                echo '<li><a href="hak_otoritas.php" class="waves-effect">Otoritas</a></li>';
}

if ($lihat['suplier_lihat'] > 0){
                                echo '<li><a href="suplier.php" class="waves-effect">Suplier</a></li>';
}

if ($lihat['pelanggan_lihat'] > 0){
                                echo '<li><a href="pelanggan.php" class="waves-effect">Pelanggan</a></li>';
}

if ($lihat['item_lihat'] > 0){
                                echo '<li><a href="barang.php?kategori=semua&tipe=barang_jasa" class="waves-effect" >Produk</a></li>';
}

if ($lihat['satuan_lihat'] > 0){
                                echo '<li><a href="satuan.php" class="waves-effect">Satuan</a></li>';
}

if ($lihat['kategori_lihat'] > 0){
                                echo '<li><a href="kategori_barang.php" class="waves-effect">Kategori</a></li>';
}

if ($lihat['komisi_produk_lihat'] > 0){
                                echo '<li><a href="fee_produk.php" class="waves-effect">Komisi Produk</a></li>';
}

if ($lihat['komisi_faktur_lihat'] > 0){
                                echo '<li><a href="fee_faktur.php" class="waves-effect">Komisi Faktur</a></li>';
}

if ($lihat['gudang_lihat'] > 0){
                                echo '<li><a href="gudang.php" class="waves-effect">Gudang</a></li>';
}

if ($lihat['daftar_akun_lihat'] > 0){
                                echo '<li><a href="daftar_akun.php?kategori=semua" class="waves-effect">Daftar Akun</a></li>';
}

if ($lihat['grup_akun_lihat'] > 0){
                                echo '<li><a href="daftar_group_akun.php" class="waves-effect">Group Akun</a></li>';
}

if ($lihat['set_akun_lihat'] > 0){
                                echo '<li><a href="setting_akun_data_item.php" class="waves-effect">Setting Akun</a></li>';
}
?>

<li><a href="setting_antrian_pelanggan.php" class="waves-effect">Setting Antrian</a></li>

<?php
if ($lihat['set_perusahaan_lihat'] > 0){
                                echo '<li><a href="setting_perusahaan.php" class="waves-effect">Data Perusahaan</a></li>';
}

if ($lihat['set_diskon_tax_lihat'] > 0){
                                echo '<li><a href="set_diskon_tax.php" class="waves-effect">Default Diskon & Pajak</a></li>';
}

if ($lihat['daftar_pajak_lihat'] > 0){
                                echo '<li><a href="daftar_pajak.php" class="waves-effect">Daftar Pajak</a></li>';
}
 
  if ($lihat['master_data_lihat'] > 0){                           
                          echo ' </ul>
                        </div>
                    </li>';
}


if ($lihat['pembayaran_lihat'] > 0){
                    echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-credit-card"></i> Pembayaran <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

if ($lihat['pembayaran_hutang_lihat'] > 0){
                                echo '<li><a href="pembayaran_hutang.php" class="waves-effect">Hutang</a></li>';
}

 if ($lihat['pembayaran_piutang_lihat'] > 0){
                                echo '<li><a href="pembayaran_piutang.php" class="waves-effect">Piutang</a></li>';
}

 if ($lihat['pembayaran_lihat'] > 0){
                       echo '</ul>
                        </div>
                    </li>';
}

 if ($lihat['transaksi_kas_lihat'] > 0){
                    echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-credit-card-ALT"></i> Transaksi <i class="fa fa-angle-down rotate-icon"></i></a>

                        <div class="collapsible-body">
                            <ul>';
}

 if ($lihat['kas_masuk_lihat'] > 0){
                                echo '<li><a href="kas_masuk.php" class="waves-effect">Kas Masuk</a></li>';
}

 if ($lihat['kas_keluar_lihat'] > 0){
                                echo '<li><a href="kas_keluar.php" class="waves-effect">Kas Keluar</a></li>';
}

 if ($lihat['kas_mutasi_lihat'] > 0){
                                echo '<li><a href="kas_mutasi.php" class="waves-effect">Kas Mutasi</a></li>';
}
 if ($lihat['transaksi_kas_lihat'] > 0){
                        echo '</ul>
                        </div>
                    </li>';

}

 if ($lihat['persediaan_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-archive"></i> Persediaan <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

 if ($lihat['item_lihat'] > 0){
                            echo '<li><a href="persediaan_barang.php?kategori=semua&tipe=barang" class="waves-effect" style="font-size: 16px">Persediaan Barang</a></li>';
}

 if ($lihat['item_masuk_lihat'] > 0){
                            echo '<li><a href="item_masuk.php" class="waves-effect">Item Masuk</a></li>';
}

 if ($lihat['item_keluar_lihat'] > 0){
                            echo '<li><a href="item_keluar.php" class="waves-effect">Item Keluar</a></li>';
}

 if ($lihat['stok_awal_lihat'] > 0){
                            echo '<li><a href="stok_awal.php" class="waves-effect">Stok Awal</a></li>';
}

 if ($lihat['stok_opname_lihat'] > 0){
                            echo '<li><a href="stok_opname.php" class="waves-effect">Stok Opname</a></li>';
}

echo '<li><a href="kartu_stok.php" class="waves-effect" style="font-size: 16px">Kartu Stok</a></li>';

 if ($lihat['laporan_mutasi_stok_lihat'] > 0){
                            echo '<li><a href="lap_mutasi_stok.php" class="waves-effect">Lap. Mutasi Stok</a></li>';
}

if ($lihat['persediaan_lihat'] > 0){
                        echo '</ul>
                        </div>
                    </li>';
}

 if ($lihat['retur_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-exchange"></i> Retur <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

 if ($lihat['retur_penjualan_lihat'] > 0){
                            echo '<li><a href="retur_penjualan.php" class="waves-effect">Retur Penjualan</a></li>';
}

 if ($lihat['retur_pembelian_lihat'] > 0){
                            echo '<li><a href="retur_pembelian.php" class="waves-effect">Retur Pembelian</a></li>';
}

if ($lihat['retur_lihat'] > 0){
                        echo '</ul>
                        </div>
                    </li>';
}

 if ($lihat['akuntansi_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-balance-scale"></i> Akuntansi <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}


 if ($lihat['buku_besar_lihat'] > 0){
                            echo '<li><a href="laporan_buku_besar.php" class="waves-effect">Buku Besar</a></li>';
}

 if ($lihat['laporan_neraca_lihat'] > 0){
                            echo '<li><a href="laporan_neraca.php" class="waves-effect"> Neraca</a></li>';
}

 if ($lihat['laporan_laba_rugi_lihat'] > 0){
                            echo '<li><a href="lap_laba_rugi_penjualan.php" class="waves-effect"> Laba Rugi</a></li>';
}

 if ($lihat['laporan_laba_kotor_lihat'] > 0){
                            echo '<li><a href="lap_laba_kotor_penjualan.php" class="waves-effect"> Laba Kotor </a></li>';
}

 if ($lihat['laporan_jurnal_lihat'] > 0){
                            echo '<li><a href="laporan_jurnal_transaksi.php" class="waves-effect"> Jurnal</a></li>';
}

 if ($lihat['transaksi_jurnal_manual_lihat'] > 0){
                            echo '<li><a href="transaksi_jurnal_manual.php" class="waves-effect">Transaksi Jurnal Manual</a></li>';
}

if ($lihat['akuntansi_lihat'] > 0){       
                        echo '</ul>
                        </div>
                    </li>';
}

 if ($lihat['laporan_lihat'] > 0){
                echo '<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-book"></i> Laporan <i class="fa fa-angle-down rotate-icon"></i></a>
                        <div class="collapsible-body">
                            <ul>';
}

 if ($lihat['laporan_penjualan_lihat'] > 0){
                            echo '<li><a href="lap_penjualan.php" class="waves-effect">Lap. Penjualan</a></li>';
}

 if ($lihat['laporan_pembelian_lihat'] > 0){
                            echo '<li><a href="lap_pembelian.php" class="waves-effect">Lap. Pembelian</a></li>';
}

 if ($lihat['laporan_piutang_beredar_lihat'] > 0){
                            echo '<li><a href="laporan_penjualan_piutang.php" class="waves-effect">Lap. Piutang Beredar </a></li>';
}

 if ($lihat['laporan_hutang_beredar_lihat'] > 0){
                            echo '<li><a href="laporan_pembelian_hutang.php" class="waves-effect">Lap. Hutang Beredar</a></li>';
}

 if ($lihat['laporan_retur_penjualan_lihat'] > 0){
                            echo '<li><a href="lap_retur_penjualan.php" class="waves-effect">Lap. Retur Penjualan</a></li>';
}

 if ($lihat['laporan_retur_pembelian_lihat'] > 0){
                            echo '<li><a href="lap_retur_pembelian.php" class="waves-effect">Lap. Retur Pembelian</a></li>';
}

 if ($lihat['laporan_pembayaran_piutang_lihat'] > 0){
                            echo '<li><a href="lap_pembayaran_piutang.php" class="waves-effect" style="font-size: 15px">Lap. Pembayaran Piutang</a></li>';
}

 if ($lihat['laporan_pembayaran_hutang_lihat'] > 0){
                            echo '<li><a href="lap_pembayaran_hutang.php" class="waves-effect" style="font-size: 15px">Lap. Pembayaran Hutang</a></li>';
}

 if ($lihat['laporan_komisi_lihat'] > 0){
                            echo '<li><a href="lap_jumlah_fee.php" class="waves-effect">Lap. Komisi </a></li>';
}

 if ($lihat['laporan_komisi_produk_lihat'] > 0){
                            echo '<li><a href="laporan_fee_produk.php" class="waves-effect">Lap. Komisi / Produk</a></li>';
}

 if ($lihat['laporan_komisi_faktur_lihat'] > 0){
                            echo '<li><a href="laporan_fee_faktur.php" class="waves-effect">Lap. Komisi / Faktur </a></li>';
}

if ($lihat['laporan_lihat'] > 0){
                        echo '</ul>
                        </div>
                    </li>';
}


 if ($lihat['kas_lihat'] > 0){
                echo '<li><a href="kas.php" class="waves-effect"> <i class="fa fa-money"></i> Posisi Kas </a></li>';
}
?>
                <li><a href="https://www.andaglos.com" class="waves-effect"> <i class="fa fa-envelope"></i> Contact Us </a></li>
                    


            </ul>
            </li>
            <!--/. Side navigation links -->

        </ul>
        <!-- Sidebar navigation -->


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
                <p style="font-size: 100%"><?php echo $ambil_perusahaan['nama_perusahaan']; ?></p>
            </div>

            <ul class="nav navbar-nav pull-right">
        
        <li class="nav-item">
        <a class="nav-link" href="form_ubah_password.php"> Ubah Password</a>

        </li>

        <li class="nav-item ">
                    <a href="https://www.andaglos.com" class="nav-link"><i class="fa fa-envelope"></i> <span class="hidden-sm-down">Contact Us</span></a>
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