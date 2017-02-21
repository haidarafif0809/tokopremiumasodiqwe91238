<?php 

function persen($persen){
	$hasil = "". $persen."%";
	return $hasil;
}

function rp($rupiah){
$rp = number_format($rupiah,0,',','.');
$rpp = $rp;
return $rpp;
}


function angkadoang($angka){

$angka1 = filter_var($angka, FILTER_SANITIZE_NUMBER_INT);
 return $angka1;
}

function emaildoang($email){

$angka1 = filter_var($email, FILTER_SANITIZE_EMAIL);
 return $angka1;
}
function stringdoang($string){

$angka1 = filter_var($string, FILTER_SANITIZE_STRING);

$angka1 =  str_replace("SELECT", "", $angka1);
$angka1 =  str_replace("select", "", $angka1);
$angka1 =  str_replace("DELETE FROM", "", $angka1);
$angka1 =  str_replace("delete from", "", $angka1);
$angka1 =  str_replace("DELETE", "", $angka1);
$angka1 =  str_replace("delete", "", $angka1);
$angka1 =  str_replace("UPDATE", "", $angka1);
$angka1 =  str_replace("update", "", $angka1);
$angka1 =  str_replace("where", "", $angka1);
$angka1 =  str_replace("WHERE", "", $angka1);
$angka1 =  str_replace("(", "", $angka1);
$angka1 =  str_replace(")", "", $angka1);
$angka1 =  str_replace(";", "", $angka1);
$angka1 =  str_replace("=", " ", $angka1);
$angka1 =  str_replace("CREATE", " ", $angka1);
$angka1 =  str_replace("create", " ", $angka1);
$angka1 =  str_replace("TABLE", " ", $angka1);
$angka1 =  str_replace("table", " ", $angka1);
$angka1 =  str_replace("INSERT", " ", $angka1);
$angka1 =  str_replace("VALUES", " ", $angka1);
$angka1 =  str_replace("insert", " ", $angka1);
$angka1 =  str_replace("INTO", " ", $angka1);
$angka1 =  str_replace("values", " ", $angka1);
$angka1 =  str_replace("FROM", " ", $angka1);
$angka1 =  str_replace("from", " ", $angka1);



 return $angka1;
}
function urldoang($string){

$angka1 = filter_var($string, FILTER_SANITIZE_URL);
 return $angka1;
}



function enkripsi($password){
$baru = password_hash($password, PASSWORD_DEFAULT);

return $baru;

}
// Untuk membuat angka menjadi tulisan huruf
		function kekata($x) {
		$x = abs($x);
		$angka = array("", "satu", "dua", "tiga", "empat", "lima",
		"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($x <12) {
		$temp = " ". $angka[$x];
		} else if ($x <20) {
		$temp = kekata($x - 10). " belas";
		} else if ($x <100) {
		$temp = kekata($x/10)." puluh". kekata($x % 10);
		} else if ($x <200) {
		$temp = " seratus" . kekata($x - 100);
		} else if ($x <1000) {
		$temp = kekata($x/100) . " ratus" . kekata($x % 100);
		} else if ($x <2000) {
		$temp = " seribu" . kekata($x - 1000);
		} else if ($x <1000000) {
		$temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
		} else if ($x <1000000000) {
		$temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
		} else if ($x <1000000000000) {
		$temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
		} else if ($x <1000000000000000) {
		$temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
		}     
		return $temp;
		}

function tanggal($tanggal){

 $date= date_create($tanggal);
 $date_format =  date_format($date,"d/m/Y");
 return $date_format;
}

function cek_stok($kode_barang){


include 'db.php';

$kode_barang = stringdoang($kode_barang);


// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$kode_barang'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$kode_barang'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$kode_barang'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$kode_barang'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$kode_barang'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];


 



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;



            $stok_barang = $total_1 - $total_2;
	
	return $stok_barang;

}



//NOMOR JURNAL

function no_jurnal(){

	include 'db.php';


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);

//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }



 $jurnal_bulan_terakhir = $db->query("SELECT MONTH(waktu_jurnal) as bulan FROM jurnal_trans ORDER BY id DESC LIMIT 1");
 $v_jurnal_bulan_terakhir = mysqli_fetch_array($jurnal_bulan_terakhir);

$no_jurnal_terakhir = $db->query("SELECT nomor_jurnal FROM jurnal_trans ORDER BY id DESC LIMIT 1");
 $v_no_jurnal_terakhir = mysqli_fetch_array($no_jurnal_terakhir);
$ambil_nomor_jurnal = substr($v_no_jurnal_terakhir['nomor_jurnal'],0,-8);

 if ($v_jurnal_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$nomor_jurnal = "1/JR/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor_jurnal = 1 + $ambil_nomor_jurnal ;

$nomor_jurnal = $nomor_jurnal."/JR/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

return $nomor_jurnal;
}




//NOMOR FAKTUR JURNAL MANUAL

function no_faktur_jurnal(){

	include 'db.php';


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);

//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }



 $jurnal_bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM nomor_faktur_jurnal ORDER BY id DESC LIMIT 1");
 $v_jurnal_bulan_terakhir = mysqli_fetch_array($jurnal_bulan_terakhir);

$no_jurnal_terakhir = $db->query("SELECT no_faktur_jurnal FROM nomor_faktur_jurnal ORDER BY id DESC LIMIT 1");
 $v_no_jurnal_terakhir = mysqli_fetch_array($no_jurnal_terakhir);
$ambil_nomor_jurnal = substr($v_no_jurnal_terakhir['no_faktur_jurnal'],0,-8);

 if ($v_jurnal_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$nomor_faktur_jurnal = "1/JM/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor_faktur_jurnal = 1 + $ambil_nomor_jurnal ;

$nomor_faktur_jurnal = $nomor_faktur_jurnal."/JM/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

return $nomor_faktur_jurnal;
}



//NOMOR FAKTUR STOK AWAL

function no_faktur_stok_awal(){

include 'db.php';


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);

//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }



 $jurnal_bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM nomor_faktur_stok_awal ORDER BY id DESC LIMIT 1");
 $v_jurnal_bulan_terakhir = mysqli_fetch_array($jurnal_bulan_terakhir);

$no_jurnal_terakhir = $db->query("SELECT no_stok_awal FROM nomor_faktur_stok_awal ORDER BY id DESC LIMIT 1");
 $v_no_jurnal_terakhir = mysqli_fetch_array($no_jurnal_terakhir);
$ambil_nomor_jurnal = substr($v_no_jurnal_terakhir['no_stok_awal'],0,-8);

 if ($v_jurnal_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$nomor_faktur_stok_awal = "1/SA/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor_faktur_stok_awal = 1 + $ambil_nomor_jurnal ;

$nomor_faktur_stok_awal = $nomor_faktur_stok_awal."/SA/".$data_bulan_terakhir."/".$tahun_terakhir;


 }

return $nomor_faktur_stok_awal;
}



//telegram (BOT)
function url_get_contents ($url) {
        if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
        }
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt ($ch, CURLOPT_CAINFO, "C:/xampp/htdocs/toko-full/cacert.pem");


        $output = curl_exec($ch);

        if(curl_errno($ch)){
        echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);

        return $output;
}

 ?>