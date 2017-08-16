<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$pilih_akses_retur_penjualan = $db->query("SELECT * FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$retur_penjualan = mysqli_fetch_array($pilih_akses_retur_penjualan);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur_retur',
	 1=>'keterangan',
	 2=>'total',
	 3=>'nama_suplier',
	 4=>'tanggal',
	 5=>'tanggal_edit',
	 6=>'jam',
	 7=>'user_buat',
	 8=>'user_edit,',
	 9=>'potongan',
	 10=>'tax',
	 11=>'tunai',
	 12=>'sisa',
	 13=>'cara_bayar',
	 14=>'total_bayar',
	 15=>'potongan_hutang',
	 16=>'nama',
	 17=>'id'
);

// getting total number records without any search
$sql =" SELECT p.nama_pelanggan,rp.id,p.kode_pelanggan AS pelanggan,rp.no_faktur_retur,rp.kode_pelanggan,rp.total,rp.potongan,rp.tax,rp.tanggal,rp.jam,rp.user_buat,rp.user_edit,rp.tanggal_edit,rp.tunai,rp.sisa, rp.potongan_piutang";
$sql.=" FROM retur_penjualan rp INNER JOIN pelanggan p ON rp.kode_pelanggan = p.id ";

$query=mysqli_query($conn, $sql) or die("datatable_retur_penjualan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT p.nama_pelanggan,rp.id,p.kode_pelanggan AS pelanggan,rp.no_faktur_retur,rp.kode_pelanggan,rp.total,rp.potongan,rp.tax,rp.tanggal,rp.jam,rp.user_buat,rp.user_edit,rp.tanggal_edit,rp.tunai,rp.sisa, rp.potongan_piutang";
$sql.=" FROM retur_penjualan rp INNER JOIN pelanggan p ON rp.kode_pelanggan = p.id WHERE 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( rp.p.no_faktur_retur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rp.p.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rp.p.tanggal_edit LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rp.p.jam LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.nama_pelanggan LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_retur_penjualan.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.id ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			//menampilkan data
			$nestedData[] = "<button class='btn btn-sm btn-info detail' no_faktur_retur='". $row['no_faktur_retur'] ."' > Detail </button>";

		if ($retur_penjualan['retur_penjualan_edit'] > 0) {

			$nestedData[] = "<a href='proses_edit_retur_penjualan.php?no_faktur_retur=". $row['no_faktur_retur']."' class='btn btn-sm btn-success'> Edit </a>";
		}

		if ($retur_penjualan['retur_penjualan_hapus'] > 0) {

			$pilih = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$row[no_faktur_retur]' AND sisa != jumlah_kuantitas");
			$row_alert = mysqli_num_rows($pilih);

			if ($row_alert > 0) {
				$nestedData[] = "<button class='btn btn-sm btn-danger btn-alert' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur_retur'] ."' data-pelanggan='". $row['kode_pelanggan'] ."'>  Hapus </button>";
			}
			else {
				$nestedData[] = "<button class='btn btn-sm btn-danger btn-hapus' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur_retur'] ."' data-pelanggan='". $row['kode_pelanggan'] ."'>  Hapus </button>";
			}
		} 
			
			$nestedData[] = "<a href='cetak_lap_retur_penjualan.php?no_faktur_retur=".$row['no_faktur_retur']."' class='btn btn-sm btn-primary' target='blank'> Cetak</a>";

			$nestedData[] = $row['no_faktur_retur'];
			$nestedData[] = $row['pelanggan']." ".$row['nama_pelanggan'];
			$nestedData[] = rp($row['total']);
			$nestedData[] = rp($row['potongan_piutang']);
			$nestedData[] = rp($row['potongan']);
			$nestedData[] = rp($row['tax']);
			$nestedData[] = $row['tanggal'];
			$nestedData[] = $row['jam'];
			$nestedData[] = $row['user_buat'];
			$nestedData[] = $row['user_edit'];
			$nestedData[] = $row['tanggal_edit'];
			$nestedData[] = rp($row['tunai']);
			$nestedData[] = rp($row['sisa']);
			$nestedData[] = $row["id"];

	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
