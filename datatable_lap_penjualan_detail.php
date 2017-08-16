<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


$total_jumlah = 0;
$total_harga = 0;
$total_subtotal = 0;
$total_potongan = 0;
$total_tax = 0;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'nama', 
	1 => 'no_faktur',
	2 => 'kode_barang',
	3=> 'nama_barang',
	4=> 'jumlah_barang',
	5=> 'satuan',
	6=> 'harga',
	7=> 'subtotal',
	8=> 'potongan',
	9=> 'tax',
	10=> 'hpp',
	11=> 'sisa',
	12=> 'status',
	13=> 'id'
);

// getting total number records without any search
$sql ="SELECT s.nama,dp.id,p.status,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.hpp,dp.sisa ";
$sql.="FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN penjualan p ON dp.no_faktur = p.no_faktur WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_penjualan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql ="SELECT s.nama,dp.id,p.status,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.hpp,dp.sisa ";
$sql.=" FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN penjualan p ON dp.no_faktur = p.no_faktur WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( dp.no_faktur LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR dp.kode_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_penjualan.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY dp.no_faktur DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

				$pilih_konversi = $db->query("SELECT $row[jumlah_barang] / sk.konversi AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$row[satuan]' AND sk.kode_produk = '$row[kode_barang]'");
					      $data_konversi = mysqli_fetch_array($pilih_konversi);

					      if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
					        
					         $jumlah_barang = $data_konversi['jumlah_konversi'];
					      }
					      else{
					        $jumlah_barang = $row['jumlah_barang'];
					      }


					      $total_jumlah = $jumlah_barang + $total_jumlah;
						  $total_harga = $row['harga'] + $total_harga;
						  $total_subtotal = $row['subtotal'] + $total_subtotal;
						  $total_potongan = $row['potongan'] + $total_potongan;
						  $total_tax = $row['tax'] + $total_tax;

					//menampilkan data
					$nestedData[] = $row['no_faktur'];
					$nestedData[] = $row['kode_barang'];
					$nestedData[] = $row['nama_barang'];
					$nestedData[] = koma($jumlah_barang,3);
					$nestedData[] = $row['nama'];
					$nestedData[] = koma($row['harga'],2);
					$nestedData[] = koma($row['subtotal'],2);
					$nestedData[] = koma($row['potongan'],2);
					$nestedData[] = koma($row['tax'],2);

        if ($_SESSION['otoritas'] == 'Pimpinan'){

                $nestedData[] = koma($row['hpp'],2);
        }

					$nestedData[] = $row['sisa'];
					$nestedData[] = $row['status'];
				$nestedData[] = $row["id"];
				$data[] = $nestedData;
			}

$nestedData=array(); 
					$nestedData[] = "<p></p>";
					$nestedData[] = "<p></p>";
					$nestedData[] = "<p></p>";
					$nestedData[] = "<p style='color:red;'>".koma($total_jumlah,3)."</p>";
					$nestedData[] = "<p></p>";
					$nestedData[] = "<p style='color:red;'>".koma($total_harga,2)."</p>";
					$nestedData[] = "<p style='color:red;'>".koma($total_subtotal,2)."</p>";
					$nestedData[] = "<p style='color:red;'>".koma($total_potongan,2)."</p>";
					$nestedData[] = "<p style='color:red;'>".koma($total_tax,2)."</p>";
					$nestedData[] = "<p></p>";
					$nestedData[] = "<p></p>";
					$nestedData[] = "<p></p>";

$data[] = $nestedData;


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

