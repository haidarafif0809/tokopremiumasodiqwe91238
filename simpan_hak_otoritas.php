<?php
include 'sanitasi.php';
include 'db.php';

// satu pilihan
$id = stringdoang($_POST['id']);
$nama = stringdoang($_POST['nama']);



$setting_lihat = stringdoang(isset($_POST['setting_lihat']));
$master_data_lihat = stringdoang(isset($_POST['master_data_lihat']));
$set_akun_lihat = stringdoang(isset($_POST['set_akun_lihat']));
$pembayaran_lihat = stringdoang(isset($_POST['pembayaran_lihat']));
$persediaan_lihat = stringdoang(isset($_POST['persediaan_lihat']));
$transaksi_kas_lihat = stringdoang(isset($_POST['transaksi_kas_lihat']));
$retur_lihat = stringdoang(isset($_POST['retur_lihat']));
$posisi_kas_lihat = stringdoang(isset($_POST['posisi_kas_lihat']));
$akuntansi_lihat = stringdoang(isset($_POST['akuntansi_lihat']));
$laporan_mutasi_stok_lihat = stringdoang(isset($_POST['laporan_mutasi_stok_lihat']));
$laporan_lihat = stringdoang(isset($_POST['laporan_lihat']));
$buku_besar_lihat = stringdoang(isset($_POST['buku_besar_lihat']));
$laporan_jurnal_lihat = stringdoang(isset($_POST['laporan_jurnal_lihat']));
$laporan_laba_kotor_lihat = stringdoang(isset($_POST['laporan_laba_kotor_lihat']));
$laporan_laba_rugi_lihat = stringdoang(isset($_POST['laporan_laba_rugi_lihat']));
$laporan_neraca_lihat = stringdoang(isset($_POST['laporan_neraca_lihat']));

$set_hal_khusus_pelanggan_lihat = stringdoang(isset($_POST['set_hal_khusus_pelanggan_lihat']));
$set_setting_halaman_promo_lihat = stringdoang(isset($_POST['set_setting_halaman_promo_lihat']));

$set_timbangan = stringdoang(isset($_POST['set_timbangan']));
$set_registrasi_lihat = stringdoang(isset($_POST['set_registrasi_lihat']));
$set_penetapan_petugas_lihat = stringdoang(isset($_POST['set_penetapan_petugas_lihat']));
$printer_lihat = stringdoang(isset($_POST['printer_lihat']));

// empat pilihan
$program_promo_lihat = stringdoang(isset($_POST['program_promo_lihat']));
$program_promo_tambah = stringdoang(isset($_POST['program_promo_tambah']));
$program_promo_edit = stringdoang(isset($_POST['program_promo_edit']));
$program_promo_hapus = stringdoang(isset($_POST['program_promo_hapus']));
$produk_promo_tambah = stringdoang(isset($_POST['produk_promo_tambah']));
$produk_promo_edit = stringdoang(isset($_POST['produk_promo_edit']));
$produk_promo_hapus = stringdoang(isset($_POST['produk_promo_hapus']));
$program_promo_free_tambah = stringdoang(isset($_POST['program_promo_free_tambah']));
$program_promo_free_edit = stringdoang(isset($_POST['program_promo_free_edit']));
$program_promo_free_hapus = stringdoang(isset($_POST['program_promo_free_hapus']));
$program_promo_disc_tambah = stringdoang(isset($_POST['program_promo_disc_tambah']));
$program_promo_disc_edit = stringdoang(isset($_POST['program_promo_disc_edit']));
$program_promo_disc_hapus = stringdoang(isset($_POST['program_promo_disc_hapus']));

$target_penjualan_lihat = stringdoang(isset($_POST['target_jual_lihat']));
$target_penjualan_edit = stringdoang(isset($_POST['target_jual_edit']));
$target_penjualan_hapus = stringdoang(isset($_POST['target_jual_hapus']));

$biaya_admin_lihat = stringdoang(isset($_POST['biaya_admin_lihat']));
$biaya_admin_tambah = stringdoang(isset($_POST['biaya_admin_tambah']));
$biaya_admin_edit = stringdoang(isset($_POST['biaya_admin_edit']));
$biaya_admin_hapus = stringdoang(isset($_POST['biaya_admin_hapus']));

$order_lihat = stringdoang(isset($_POST['order_lihat']));
$order_tambah = stringdoang(isset($_POST['order_tambah']));
$order_edit = stringdoang(isset($_POST['order_edit']));
$order_hapus = stringdoang(isset($_POST['order_hapus']));


$tombol_submit_order = stringdoang(isset($_POST['tombol_submit']));
$tombol_order = stringdoang(isset($_POST['tombol_order']));
$edit_produk_order = stringdoang(isset($_POST['edit_produk']));
$hapus_produk_order = stringdoang(isset($_POST['hapus_produk']));

$transaksi_jurnal_manual_lihat = stringdoang(isset($_POST['transaksi_jurnal_manual_lihat']));
$transaksi_jurnal_manual_tambah = stringdoang(isset($_POST['transaksi_jurnal_manual_tambah']));
$transaksi_jurnal_manual_edit = stringdoang(isset($_POST['transaksi_jurnal_manual_edit']));
$transaksi_jurnal_manual_hapus = stringdoang(isset($_POST['transaksi_jurnal_manual_hapus']));
$penjualan_lihat = stringdoang(isset($_POST['penjualan_lihat']));
$penjualan_tambah = stringdoang(isset($_POST['penjualan_tambah']));
$penjualan_edit = stringdoang(isset($_POST['penjualan_edit']));
$penjualan_hapus = stringdoang(isset($_POST['penjualan_hapus']));
$pembelian_lihat = stringdoang(isset($_POST['pembelian_lihat']));
$pembelian_tambah = stringdoang(isset($_POST['pembelian_tambah']));
$pembelian_edit = stringdoang(isset($_POST['pembelian_edit']));
$pembelian_hapus = stringdoang(isset($_POST['pembelian_hapus']));
$user_lihat = stringdoang(isset($_POST['user_lihat']));
$user_tambah = stringdoang(isset($_POST['user_tambah']));
$user_edit = stringdoang(isset($_POST['user_edit']));
$user_hapus = stringdoang(isset($_POST['user_hapus']));
$jabatan_lihat = stringdoang(isset($_POST['jabatan_lihat']));
$jabatan_tambah = stringdoang(isset($_POST['jabatan_tambah']));
$jabatan_edit = stringdoang(isset($_POST['jabatan_edit']));
$jabatan_hapus = stringdoang(isset($_POST['jabatan_hapus']));
$suplier_lihat = stringdoang(isset($_POST['suplier_lihat']));
$suplier_tambah = stringdoang(isset($_POST['suplier_tambah']));
$suplier_edit = stringdoang(isset($_POST['suplier_edit']));
$suplier_hapus = stringdoang(isset($_POST['suplier_hapus']));
$pelanggan_lihat = stringdoang(isset($_POST['pelanggan_lihat']));
$pelanggan_tambah = stringdoang(isset($_POST['pelanggan_tambah']));
$pelanggan_edit = stringdoang(isset($_POST['pelanggan_edit']));
$pelanggan_hapus = stringdoang(isset($_POST['pelanggan_hapus']));
$satuan_lihat = stringdoang(isset($_POST['satuan_lihat']));
$satuan_tambah = stringdoang(isset($_POST['satuan_tambah']));
$satuan_edit = stringdoang(isset($_POST['satuan_edit']));
$satuan_hapus = stringdoang(isset($_POST['satuan_hapus']));
$item_lihat = stringdoang(isset($_POST['item_lihat']));
$item_tambah = stringdoang(isset($_POST['item_tambah']));
$item_edit = stringdoang(isset($_POST['item_edit']));
$item_hapus = stringdoang(isset($_POST['item_hapus']));
$pemasukan_lihat = stringdoang(isset($_POST['pemasukan_lihat']));
$pemasukan_tambah = stringdoang(isset($_POST['pemasukan_tambah']));
$pemasukan_edit = stringdoang(isset($_POST['pemasukan_edit']));
$pemasukan_hapus = stringdoang(isset($_POST['pemasukan_hapus']));
$pengeluaran_lihat = stringdoang(isset($_POST['pengeluaran_lihat']));
$pengeluaran_tambah = stringdoang(isset($_POST['pengeluaran_tambah']));
$pengeluaran_edit = stringdoang(isset($_POST['pengeluaran_edit']));
$pengeluaran_hapus = stringdoang(isset($_POST['pengeluaran_hapus']));
$komisi_faktur_lihat = stringdoang(isset($_POST['komisi_faktur_lihat']));
$komisi_faktur_tambah = stringdoang(isset($_POST['komisi_faktur_tambah']));
$komisi_faktur_edit = stringdoang(isset($_POST['komisi_faktur_edit']));
$komisi_faktur_hapus = stringdoang(isset($_POST['komisi_faktur_hapus']));
$komisi_produk_lihat = stringdoang(isset($_POST['komisi_produk_lihat']));
$komisi_produk_tambah = stringdoang(isset($_POST['komisi_produk_tambah']));
$komisi_produk_edit = stringdoang(isset($_POST['komisi_produk_edit']));
$komisi_produk_hapus = stringdoang(isset($_POST['komisi_produk_hapus']));
$hak_otoritas_lihat = stringdoang(isset($_POST['hak_otoritas_lihat']));
$hak_otoritas_tambah = stringdoang(isset($_POST['hak_otoritas_tambah']));
$hak_otoritas_edit = stringdoang(isset($_POST['hak_otoritas_edit']));
$hak_otoritas_hapus = stringdoang(isset($_POST['hak_otoritas_hapus']));
$kategori_lihat = stringdoang(isset($_POST['kategori_lihat']));
$kategori_tambah = stringdoang(isset($_POST['kategori_tambah']));
$kategori_edit = stringdoang(isset($_POST['kategori_edit']));
$kategori_hapus = stringdoang(isset($_POST['kategori_hapus']));
$gudang_lihat = stringdoang(isset($_POST['gudang_lihat']));
$gudang_tambah = stringdoang(isset($_POST['gudang_tambah']));
$gudang_edit = stringdoang(isset($_POST['gudang_edit']));
$gudang_hapus = stringdoang(isset($_POST['gudang_hapus']));
$grup_akun_lihat = stringdoang(isset($_POST['grup_akun_lihat']));
$grup_akun_tambah = stringdoang(isset($_POST['grup_akun_tambah']));
$grup_akun_edit = stringdoang(isset($_POST['grup_akun_edit']));
$grup_akun_hapus = stringdoang(isset($_POST['grup_akun_hapus']));
$daftar_akun_lihat = stringdoang(isset($_POST['daftar_akun_lihat']));
$daftar_akun_tambah = stringdoang(isset($_POST['daftar_akun_tambah']));
$daftar_akun_edit = stringdoang(isset($_POST['daftar_akun_edit']));
$daftar_akun_hapus = stringdoang(isset($_POST['daftar_akun_hapus']));
$pembayaran_hutang_lihat = stringdoang(isset($_POST['pembayaran_hutang_lihat']));
$pembayaran_hutang_tambah = stringdoang(isset($_POST['pembayaran_hutang_tambah']));
$pembayaran_hutang_edit = stringdoang(isset($_POST['pembayaran_hutang_edit']));
$pembayaran_hutang_hapus = stringdoang(isset($_POST['pembayaran_hutang_hapus']));
$pembayaran_piutang_lihat = stringdoang(isset($_POST['pembayaran_piutang_lihat']));
$pembayaran_piutang_tambah = stringdoang(isset($_POST['pembayaran_piutang_tambah']));
$pembayaran_piutang_edit = stringdoang(isset($_POST['pembayaran_piutang_edit']));
$pembayaran_piutang_hapus = stringdoang(isset($_POST['pembayaran_piutang_hapus']));
$kas_masuk_lihat = stringdoang(isset($_POST['kas_masuk_lihat']));
$kas_masuk_tambah = stringdoang(isset($_POST['kas_masuk_tambah']));
$kas_masuk_edit = stringdoang(isset($_POST['kas_masuk_edit']));
$kas_masuk_hapus = stringdoang(isset($_POST['kas_masuk_hapus']));
$kas_keluar_lihat = stringdoang(isset($_POST['kas_keluar_lihat']));
$kas_keluar_tambah = stringdoang(isset($_POST['kas_keluar_tambah']));
$kas_keluar_edit = stringdoang(isset($_POST['kas_keluar_edit']));
$kas_keluar_hapus = stringdoang(isset($_POST['kas_keluar_hapus']));
$kas_mutasi_lihat = stringdoang(isset($_POST['kas_mutasi_lihat']));
$kas_mutasi_tambah = stringdoang(isset($_POST['kas_mutasi_tambah']));
$kas_mutasi_edit = stringdoang(isset($_POST['kas_mutasi_edit']));
$kas_mutasi_hapus = stringdoang(isset($_POST['kas_mutasi_hapus']));
$retur_penjualan_lihat = stringdoang(isset($_POST['retur_penjualan_lihat']));
$retur_penjualan_tambah = stringdoang(isset($_POST['retur_penjualan_tambah']));
$retur_penjualan_edit = stringdoang(isset($_POST['retur_penjualan_edit']));
$retur_penjualan_hapus = stringdoang(isset($_POST['retur_penjualan_hapus']));
$retur_pembelian_lihat = stringdoang(isset($_POST['retur_pembelian_lihat']));
$retur_pembelian_tambah = stringdoang(isset($_POST['retur_pembelian_tambah']));
$retur_pembelian_edit = stringdoang(isset($_POST['retur_pembelian_edit']));
$retur_pembelian_hapus = stringdoang(isset($_POST['retur_pembelian_hapus']));
$item_masuk_lihat = stringdoang(isset($_POST['item_masuk_lihat']));
$item_masuk_tambah = stringdoang(isset($_POST['item_masuk_tambah']));
$item_masuk_edit = stringdoang(isset($_POST['item_masuk_edit']));
$item_masuk_hapus = stringdoang(isset($_POST['item_masuk_hapus']));
$item_keluar_lihat = stringdoang(isset($_POST['item_keluar_lihat']));
$item_keluar_tambah = stringdoang(isset($_POST['item_keluar_tambah']));
$item_keluar_edit = stringdoang(isset($_POST['item_keluar_edit']));
$item_keluar_hapus = stringdoang(isset($_POST['item_keluar_hapus']));
$stok_awal_lihat = stringdoang(isset($_POST['stok_awal_lihat']));
$stok_awal_tambah = stringdoang(isset($_POST['stok_awal_tambah']));
$stok_awal_edit = stringdoang(isset($_POST['stok_awal_edit']));
$stok_awal_hapus = stringdoang(isset($_POST['stok_awal_hapus']));
$stok_opname_lihat = stringdoang(isset($_POST['stok_opname_lihat']));
$stok_opname_tambah = stringdoang(isset($_POST['stok_opname_tambah']));
$stok_opname_edit = stringdoang(isset($_POST['stok_opname_edit']));
$stok_opname_hapus = stringdoang(isset($_POST['stok_opname_hapus']));
$daftar_pajak_lihat = stringdoang(isset($_POST['daftar_pajak_lihat']));
$daftar_pajak_tambah = stringdoang(isset($_POST['daftar_pajak_tambah']));
$daftar_pajak_edit = stringdoang(isset($_POST['daftar_pajak_edit']));
$daftar_pajak_hapus = stringdoang(isset($_POST['daftar_pajak_hapus']));

// tiga pilihan
$laporan_pemasukan_tanggal_lihat = stringdoang(isset($_POST['laporan_pemasukan_tanggal_lihat']));
$laporan_pemasukan_rekap_lihat = stringdoang(isset($_POST['laporan_pemasukan_rekap_lihat']));
$laporan_pemasukan_periode_lihat = stringdoang(isset($_POST['laporan_pemasukan_periode_lihat']));
$laporan_pengeluaran_tanggal_lihat = stringdoang(isset($_POST['laporan_pengeluaran_tanggal_lihat']));
$laporan_pengeluaran_rekap_lihat = stringdoang(isset($_POST['laporan_pengeluaran_rekap_lihat']));
$laporan_pengeluaran_periode_lihat = stringdoang(isset($_POST['laporan_pengeluaran_periode_lihat']));
$laporan_komisi_lihat = stringdoang(isset($_POST['laporan_komisi_lihat']));
$laporan_komisi_produk_lihat = stringdoang(isset($_POST['laporan_komisi_produk_lihat']));
$laporan_komisi_faktur_lihat = stringdoang(isset($_POST['laporan_komisi_faktur_lihat']));

// dua pilihan

$set_diskon_tax_lihat = stringdoang(isset($_POST['set_diskon_tax_lihat']));
$set_diskon_tax_edit = stringdoang(isset($_POST['set_diskon_tax_edit']));
$set_perusahaan_lihat = stringdoang(isset($_POST['set_perusahaan_lihat']));
$set_perusahaan_edit = stringdoang(isset($_POST['set_perusahaan_edit']));
$kas_lihat = stringdoang(isset($_POST['kas_lihat']));
$kas_edit = stringdoang(isset($_POST['kas_edit']));
$cash_flow_tanggal_lihat = stringdoang(isset($_POST['cash_flow_tanggal_lihat']));
$cash_flow_periode_lihat = stringdoang(isset($_POST['cash_flow_periode_lihat']));
$laporan_retur_pembelian_lihat = stringdoang(isset($_POST['laporan_retur_pembelian_lihat']));
$laporan_retur_penjualan_lihat = stringdoang(isset($_POST['laporan_retur_penjualan_lihat']));
$laporan_pembayaran_hutang_lihat = stringdoang(isset($_POST['laporan_pembayaran_hutang_lihat']));
$laporan_pembayaran_piutang_lihat = stringdoang(isset($_POST['laporan_pembayaran_piutang_lihat']));
$laporan_pembelian_lihat = stringdoang(isset($_POST['laporan_pembelian_lihat']));
$laporan_penjualan_lihat = stringdoang(isset($_POST['laporan_penjualan_lihat']));
$laporan_hutang_beredar_lihat = stringdoang(isset($_POST['laporan_hutang_beredar_lihat']));
$laporan_piutang_beredar_lihat = stringdoang(isset($_POST['laporan_piutang_beredar_lihat']));

$peringatan_jatuh_tempo_hutang = stringdoang(isset($_POST['peringatan_jatuh_tempo_hutang']));



$tombol_cash_drawer = stringdoang(isset($_POST['tombol_cash_drawer']));

$update_otoritas_item_keluar = $db->prepare("UPDATE otoritas_item_keluar SET item_keluar_lihat = ?, item_keluar_tambah = ?, item_keluar_edit = ?, item_keluar_hapus = ? WHERE id_otoritas = ?");

$update_otoritas_item_keluar->bind_param("iiiii",
	$item_keluar_lihat, $item_keluar_tambah, $item_keluar_edit, $item_keluar_edit, $id);

$update_otoritas_item_keluar->execute();



$update_otoritas_item_masuk = $db->prepare("UPDATE otoritas_item_masuk SET item_masuk_lihat = ?, item_masuk_tambah = ?, item_masuk_edit = ?, item_masuk_hapus = ? WHERE id_otoritas = ?");

$update_otoritas_item_masuk->bind_param("iiiii",
    $item_masuk_lihat, $item_masuk_tambah, $item_masuk_edit, $item_masuk_edit, $id);

$update_otoritas_item_masuk->execute();


$update_otoritas_kas = $db->prepare("UPDATE otoritas_kas SET kas_lihat = ?, kas_edit = ?, posisi_kas_lihat = ? WHERE id_otoritas = ?");

$update_otoritas_kas->bind_param("iiii",
    $kas_lihat, $kas_edit, $posisi_kas_lihat, $id);

$update_otoritas_kas->execute();


$update_otoritas_kas_masuk = $db->prepare("UPDATE otoritas_kas_masuk SET kas_masuk_lihat = ?, kas_masuk_tambah = ?, kas_masuk_edit = ?, kas_masuk_hapus = ? WHERE id_otoritas = ?");

$update_otoritas_kas_masuk->bind_param("iiiii",
    $kas_masuk_lihat, $kas_masuk_tambah, $kas_masuk_edit, $kas_masuk_edit, $id);

$update_otoritas_kas_masuk->execute();


$update_otoritas_kas_keluar = $db->prepare("UPDATE otoritas_kas_keluar SET kas_keluar_lihat = ?, kas_keluar_tambah = ?, kas_keluar_edit = ?, kas_keluar_hapus = ? WHERE id_otoritas = ?");

$update_otoritas_kas_keluar->bind_param("iiiii",
    $kas_keluar_lihat, $kas_keluar_tambah, $kas_keluar_edit, $kas_keluar_edit, $id);

$update_otoritas_kas_keluar->execute();


$update_otoritas_kas_mutasi = $db->prepare("UPDATE otoritas_kas_mutasi SET kas_mutasi_lihat = ?, kas_mutasi_tambah = ?, kas_mutasi_edit = ?, kas_mutasi_hapus = ? WHERE id_otoritas = ?");

$update_otoritas_kas_mutasi->bind_param("iiiii",
    $kas_mutasi_lihat, $kas_mutasi_tambah, $kas_mutasi_edit, $kas_mutasi_edit, $id);

$update_otoritas_kas_mutasi->execute();

$update_otoritas_setting = $db->prepare("UPDATE otoritas_setting SET setting_lihat = ?,set_hal_khusus_pelanggan_lihat = ?,
set_setting_halaman_promo_lihat = ?,set_timbangan = ?,setting_registrasi_lihat = ?,penetapan_petugas_lihat = ?,printer_lihat = ?,tombol_cash_drawer = ?, peringatan_jatuh_tempo_hutang = ? WHERE id_otoritas = ?");

$update_otoritas_setting->bind_param("iiiiiiiiii",
    $setting_lihat,$set_hal_khusus_pelanggan_lihat,$set_setting_halaman_promo_lihat,$set_timbangan,$set_registrasi_lihat,$set_penetapan_petugas_lihat,$printer_lihat,$tombol_cash_drawer, $peringatan_jatuh_tempo_hutang, $id);

$update_otoritas_setting->execute();


$update_otoritas_laporan = $db->prepare("UPDATE otoritas_laporan SET laporan_mutasi_stok_lihat = ?, akuntansi_lihat = ?, laporan_lihat = ?, buku_besar_lihat = ?, laporan_jurnal_lihat = ?, laporan_laba_kotor_lihat = ?, laporan_laba_rugi_lihat = ?, laporan_neraca_lihat = ?, transaksi_jurnal_manual_lihat = ?, transaksi_jurnal_manual_tambah = ?, transaksi_jurnal_manual_edit = ?, transaksi_jurnal_manual_hapus = ?, cash_flow_tanggal_lihat = ?, cash_flow_periode_lihat = ?, laporan_pemasukan_tanggal_lihat = ?, laporan_pemasukan_rekap_lihat = ?, laporan_pemasukan_periode_lihat = ?, laporan_pengeluaran_tanggal_lihat = ?, laporan_pengeluaran_rekap_lihat = ?, laporan_pengeluaran_periode_lihat = ?, laporan_komisi_produk_lihat = ?, laporan_komisi_faktur_lihat = ?, laporan_komisi_lihat = ?, laporan_pembelian_lihat = ?, laporan_hutang_beredar_lihat = ?, laporan_penjualan_lihat = ?, laporan_piutang_beredar_lihat = ?, laporan_retur_pembelian_lihat = ?, laporan_retur_penjualan_lihat = ?, laporan_pembayaran_hutang_lihat = ?, laporan_pembayaran_piutang_lihat = ? WHERE id_otoritas = ?");

$update_otoritas_laporan->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii",
    $laporan_mutasi_stok_lihat, $akuntansi_lihat, $laporan_lihat, $buku_besar_lihat, $laporan_jurnal_lihat, $laporan_laba_kotor_lihat, $laporan_laba_rugi_lihat, $laporan_neraca_lihat, $transaksi_jurnal_manual_lihat, $transaksi_jurnal_manual_tambah, $transaksi_jurnal_manual_edit, $transaksi_jurnal_manual_hapus, $cash_flow_tanggal_lihat, $cash_flow_periode_lihat, $laporan_pemasukan_tanggal_lihat, $laporan_pemasukan_rekap_lihat, $laporan_pemasukan_periode_lihat, $laporan_pengeluaran_tanggal_lihat, $laporan_pengeluaran_rekap_lihat, $laporan_pengeluaran_periode_lihat, $laporan_komisi_produk_lihat, $laporan_komisi_faktur_lihat, $laporan_komisi_lihat, $laporan_pembelian_lihat, $laporan_hutang_beredar_lihat, $laporan_penjualan_lihat, $laporan_piutang_beredar_lihat, $laporan_retur_pembelian_lihat, $laporan_retur_penjualan_lihat, $laporan_pembayaran_hutang_lihat, $laporan_pembayaran_piutang_lihat, $id);

$update_otoritas_laporan->execute();


$update_otoritas_master_data = $db->prepare("UPDATE otoritas_master_data SET master_data_lihat = ?, user_lihat = ?, user_tambah = ?, user_edit = ?, user_hapus = ?, satuan_lihat = ?, satuan_tambah = ?, satuan_edit = ?, satuan_hapus = ?, jabatan_lihat = ?, jabatan_tambah = ?, jabatan_edit = ?, jabatan_hapus = ?, suplier_lihat = ?, suplier_tambah = ?, suplier_edit = ?, suplier_hapus = ?, pelanggan_lihat = ?, pelanggan_tambah = ?, pelanggan_edit = ?, pelanggan_hapus = ?, item_lihat = ?, item_tambah = ?, item_edit = ?, item_hapus = ?, pemasukan_lihat = ?, pemasukan_tambah = ?, pemasukan_edit = ?, pemasukan_hapus = ?, pengeluaran_lihat = ?, pengeluaran_tambah = ?, pengeluaran_edit = ?, pengeluaran_hapus = ?, komisi_faktur_lihat = ?, komisi_faktur_tambah = ?, komisi_faktur_edit = ?, komisi_faktur_hapus = ?, komisi_produk_lihat = ?, komisi_produk_tambah = ?, komisi_produk_edit = ?, komisi_produk_hapus = ?, set_perusahaan_lihat = ?, set_perusahaan_edit = ?, set_diskon_tax_lihat = ?, set_diskon_tax_edit = ?, hak_otoritas_lihat = ?, hak_otoritas_tambah = ?, hak_otoritas_edit = ?, hak_otoritas_hapus = ?, kategori_lihat = ?, kategori_tambah = ?, kategori_edit = ?, kategori_hapus = ?, gudang_lihat = ?, gudang_tambah = ?, gudang_edit = ?, gudang_hapus = ?, grup_akun_lihat = ?, grup_akun_tambah = ?, grup_akun_edit = ?, grup_akun_hapus = ?, daftar_akun_lihat = ?, daftar_akun_tambah = ?, daftar_akun_edit = ?, daftar_akun_hapus = ?, set_akun_lihat = ?, daftar_pajak_lihat = ?, daftar_pajak_tambah = ?, daftar_pajak_edit = ?, daftar_pajak_hapus = ?, biaya_admin_lihat = ?, biaya_admin_tambah = ?, biaya_admin_edit = ?, biaya_admin_hapus = ?, program_promo_lihat = ?, program_promo_tambah = ?, program_promo_edit = ?, program_promo_hapus = ? , produk_promo_tambah = ?, produk_promo_edit = ?, produk_promo_hapus = ?, program_promo_free_tambah = ?, program_promo_free_edit = ?, program_promo_free_hapus = ?, program_promo_disc_tambah = ?, program_promo_disc_edit = ?, program_promo_disc_hapus = ? WHERE id_otoritas = ?");



$update_otoritas_master_data->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii",
    $master_data_lihat, $user_lihat, $user_tambah, $user_edit, $user_hapus, $satuan_lihat, $satuan_tambah, $satuan_edit, $satuan_hapus, $jabatan_lihat, $jabatan_tambah, $jabatan_edit, $jabatan_hapus, $suplier_lihat, $suplier_tambah, $suplier_edit, $suplier_hapus, $pelanggan_lihat, $pelanggan_tambah, $pelanggan_edit, $pelanggan_hapus, $item_lihat, $item_tambah, $item_edit, $item_hapus, $pemasukan_lihat, $pemasukan_tambah, $pemasukan_edit, $pemasukan_hapus, $pengeluaran_lihat, $pengeluaran_tambah, $pengeluaran_edit, $pengeluaran_hapus, $komisi_faktur_lihat, $komisi_faktur_tambah, $komisi_faktur_edit, $komisi_faktur_hapus, $komisi_produk_lihat, $komisi_produk_tambah, $komisi_produk_edit, $komisi_produk_hapus, $set_perusahaan_lihat, $set_perusahaan_edit, $set_diskon_tax_lihat, $set_diskon_tax_edit, $hak_otoritas_lihat, $hak_otoritas_tambah, $hak_otoritas_edit, $hak_otoritas_hapus, $kategori_lihat, $kategori_tambah, $kategori_edit, $kategori_hapus, $gudang_lihat, $gudang_tambah, $gudang_edit, $gudang_hapus, $grup_akun_lihat, $grup_akun_tambah, $grup_akun_edit, $grup_akun_hapus, $daftar_akun_lihat, $daftar_akun_tambah, $daftar_akun_edit, $daftar_akun_hapus, $set_akun_lihat, $daftar_pajak_lihat, $daftar_pajak_tambah, $daftar_pajak_edit, $daftar_pajak_hapus, $biaya_admin_lihat, $biaya_admin_tambah, $biaya_admin_edit,$biaya_admin_hapus, $program_promo_lihat, $program_promo_tambah, $program_promo_edit,$program_promo_hapus, $produk_promo_tambah, $produk_promo_edit, $produk_promo_hapus, $program_promo_free_tambah, $program_promo_free_edit, $program_promo_free_hapus, $program_promo_disc_tambah, $program_promo_disc_edit, $program_promo_disc_hapus, $id);

$update_otoritas_master_data->execute();


$update_otoritas_pembayaran = $db->prepare("UPDATE otoritas_pembayaran SET pembayaran_lihat = ?, pembayaran_hutang_lihat = ?, pembayaran_hutang_tambah = ?, pembayaran_hutang_edit = ?, pembayaran_hutang_hapus = ?, pembayaran_piutang_lihat = ?, pembayaran_piutang_tambah = ?, pembayaran_piutang_edit = ?, pembayaran_piutang_hapus = ? WHERE id_otoritas = ? ");

$update_otoritas_pembayaran->bind_param("iiiiiiiiii",
    $pembayaran_lihat, $pembayaran_hutang_lihat, $pembayaran_hutang_tambah, $pembayaran_hutang_edit, $pembayaran_hutang_hapus, $pembayaran_piutang_lihat, $pembayaran_piutang_tambah, $pembayaran_piutang_edit, $pembayaran_piutang_hapus, $id);

$update_otoritas_pembayaran->execute();


$update_otoritas_pembelian = $db->prepare("UPDATE otoritas_pembelian SET pembelian_lihat = ?, pembelian_tambah = ?, pembelian_edit = ?, pembelian_hapus = ?, retur_pembelian_lihat = ?, retur_pembelian_tambah = ?, retur_pembelian_edit = ?, retur_pembelian_hapus = ? WHERE id_otoritas = ?");

$update_otoritas_pembelian->bind_param("iiiiiiiii",
    $pembelian_lihat, $pembelian_tambah, $pembelian_edit, $pembelian_hapus, $retur_pembelian_lihat, $retur_pembelian_tambah, $retur_pembelian_edit, $retur_pembelian_hapus, $id);

$update_otoritas_pembelian->execute();


$update_otoritas_penjualan = $db->prepare("UPDATE otoritas_penjualan SET penjualan_lihat = ?, penjualan_tambah = ?, penjualan_edit = ?, penjualan_hapus = ?, retur_lihat = ?, retur_penjualan_lihat = ?, retur_penjualan_tambah = ?, retur_penjualan_edit = ?, retur_penjualan_hapus = ? WHERE id_otoritas = ? ");

$update_otoritas_penjualan->bind_param("iiiiiiiiii",
    $penjualan_lihat, $penjualan_tambah, $penjualan_edit, $penjualan_hapus, $retur_lihat, $retur_penjualan_lihat, $retur_penjualan_tambah, $retur_penjualan_edit, $retur_penjualan_hapus, $id);

$update_otoritas_penjualan->execute();


// oredr penjualan
$update_otoritas_order_penjualan = $db->prepare("UPDATE otoritas_order_penjualan SET order_lihat = ?, order_tambah = ?, order_edit = ?, order_hapus = ? WHERE id_otoritas = ? ");

$update_otoritas_order_penjualan->bind_param("iiiii",
    $order_lihat, $order_tambah, $order_edit, $order_hapus, $id);

$update_otoritas_order_penjualan->execute();
// order penjualan


// target penjualan
$update_otoritas_target_penjualan = $db->prepare("UPDATE otoritas_target_penjualan SET target_jual_lihat = ?, target_jual_edit = ?, target_jual_hapus = ? WHERE id_otoritas = ? ");

$update_otoritas_target_penjualan->bind_param("iiii",
    $target_penjualan_lihat,  $target_penjualan_edit, $target_penjualan_hapus, $id);

$update_otoritas_target_penjualan->execute();
// target penjualan

//form order penjualan
$update_otoritas_form_order_penjualan = $db->prepare("UPDATE otoritas_form_order_penjualan SET  tombol_submit = ?, tombol_order = ?, edit_produk = ?, hapus_produk = ? WHERE id_otoritas = ? ");

$update_otoritas_form_order_penjualan->bind_param("iiiii",
    $tombol_submit_order, $tombol_order, $edit_produk_order, $hapus_produk_order , $id);

$update_otoritas_form_order_penjualan->execute();
//form order penjualan


$update_otoritas_stok_awal = $db->prepare("UPDATE otoritas_stok_awal SET stok_awal_lihat = ?, stok_awal_tambah = ?, stok_awal_edit = ?, stok_awal_hapus = ? WHERE id_otoritas = ?");

$update_otoritas_stok_awal->bind_param("iiiii",
    $stok_awal_lihat, $stok_awal_tambah, $stok_awal_edit, $stok_awal_hapus, $id);

$update_otoritas_stok_awal->execute();



$update_otoritas_stok_opname = $db->prepare("UPDATE otoritas_stok_opname SET stok_opname_lihat = ?, stok_opname_tambah = ?, stok_opname_edit = ?, stok_opname_hapus = ? WHERE id_otoritas = ?");

$update_otoritas_stok_opname->bind_param("iiiii",
    $stok_opname_lihat, $stok_opname_tambah, $stok_opname_edit, $stok_opname_hapus, $id);

$update_otoritas_stok_opname->execute();


$update_otoritas_persediaan = $db->prepare("UPDATE otoritas_persediaan SET persediaan_lihat = ? WHERE id_otoritas = ?");

$update_otoritas_persediaan->bind_param("ii",
    $persediaan_lihat, $id);

$update_otoritas_persediaan->execute();


$update_otoritas_transaksi_kas = $db->prepare("UPDATE otoritas_transaksi_kas SET transaksi_kas_lihat = ? WHERE id_otoritas = ?");

$update_otoritas_transaksi_kas->bind_param("ii",
    $transaksi_kas_lihat, $id);

$update_otoritas_transaksi_kas->execute();


header('location: form_hak_akses.php?nama='.$nama.'&id='.$id.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>