<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

$filter = stringdoang($_POST['filter']);

if ($filter == 'Antara') {     
      $dari_jumlah = stringdoang($_POST['dari_jumlah']);
      $sampai_jumlah = stringdoang($_POST['sampai_jumlah']);

		if ($dari_jumlah == "") {
			$dari_jumlah = 0;
		}

		if ($sampai_jumlah	 == "") {
			$sampai_jumlah	 = 0;
		}
}
else{
      $filter_jumlah = stringdoang($_POST['filter_jumlah']);      

		if ($filter_jumlah == "") {
			$filter_jumlah = 0;
		}

}

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'id', 
	1 => 'kode_barang',
	2 => 'nama_barang',
	3 => 'jumlah_barang',
	4 => 'satuan',
	5 => 'kategori'

);

$query_barang = $db->query("SELECT kode_barang, nama_barang FROM barang WHERE berkaitan_dgn_stok = 'Barang' ");
while ($data_barang = mysqli_fetch_array($query_barang)) {
	
	$stok_produk = cekStokHpp($data_barang['kode_barang']);
	$query_update = $db->query("UPDATE barang SET stok_barang = '$stok_produk' WHERE kode_barang = '$data_barang[kode_barang]' ");

// getting total number records without any search
	if ($filter == "Kurang Dari") {
		$sql =" SELECT b.id, b.kode_barang, b.nama_barang, b.satuan, b.kategori, s.nama AS nama_satuan ";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = 'Barang' AND b.stok_barang < '$filter_jumlah'";
	}
	elseif ($filter == "Lebih Dari") {
		$sql =" SELECT b.id, b.kode_barang, b.nama_barang, b.satuan, b.kategori, s.nama AS nama_satuan ";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = 'Barang' AND b.stok_barang > '$filter_jumlah'";
	}
	else{
		$sql =" SELECT b.id, b.kode_barang, b.nama_barang, b.satuan, b.kategori, s.nama AS nama_satuan ";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = 'Barang' AND b.stok_barang >= '$dari_jumlah' AND b.stok_barang <= '$sampai_jumlah'";
	}

		$query=mysqli_query($conn, $sql) or die("error 1");
		$totalData = mysqli_num_rows($query);
		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
	
	if ($filter == "Kurang Dari") {
		$sql =" SELECT b.id, b.kode_barang, b.nama_barang, b.satuan, b.kategori, s.nama AS nama_satuan ";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = 'Barang' AND b.stok_barang < '$filter_jumlah'";
	}
	elseif ($filter == "Lebih Dari") {
		$sql =" SELECT b.id, b.kode_barang, b.nama_barang, b.satuan, b.kategori, s.nama AS nama_satuan ";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = 'Barang' AND b.stok_barang > '$filter_jumlah'";
	}
	else{
		$sql =" SELECT b.id, b.kode_barang, b.nama_barang, b.satuan, b.kategori, s.nama AS nama_satuan ";
		$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok = 'Barang' AND b.stok_barang >= '$dari_jumlah' AND b.stok_barang <= '$sampai_jumlah'";
	}

		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


			$sql.=" AND ( b.kode_barang LIKE '".$requestData['search']['value']."%' "; 
			$sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
			$sql.=" OR b.kategori LIKE '".$requestData['search']['value']."%' )";

		}
		$query=mysqli_query($conn, $sql) or die("eror 2");
		$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


		$sql.= " ORDER BY b.kategori DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

		/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
		$query=mysqli_query($conn, $sql) or die("1-grid-data.php: get employees");

		$data = array();

		while( $row=mysqli_fetch_array($query) ) {	
			
			$stok = cekStokHpp($row['kode_barang']);
			    $nestedData=array();

			      $nestedData[] = $row['kode_barang'];
			      $nestedData[] = $row['nama_barang'];
			      $nestedData[] = "<h6 align='right'>". gantiKoma($stok) ." </h6>";
			      $nestedData[] = $row['nama_satuan'];
			      $nestedData[] = $row['kategori'];
				
				$data[] = $nestedData;
		}

}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>