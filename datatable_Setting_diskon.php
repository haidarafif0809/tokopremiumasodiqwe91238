<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id_barang']);
$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_data = 0;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

	0 =>'kode_barang', 
	1 =>'syarat_jumlah', 
	2 => 'potongan',
	3=> 'hapus',
	4 => 'id'

);
// data yang akan di tampilkan di table


// getting total number records without any search

$sql = "SELECT kode_barang,id,syarat_jumlah,potongan FROM setting_diskon_jumlah WHERE kode_barang = '$kode_barang' AND id_barang = '$id' ";
$query = mysqli_query($conn, $sql) or die("eror 1");

if( !empty($requestData['search']['value']) ) { 
  // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND (syarat_jumlah LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR potongan LIKE '".$requestData['search']['value']."%')   ";
}

$query=mysqli_query($conn, $sql) or die("eror 2");

while($hitung_data = mysqli_fetch_array($query)) {
		
	$jumlah_data = $jumlah_data + 1;

}

$totalData = $jumlah_data;

$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                              

$sql.=" ORDER BY id ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."  ";
 /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query= mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while($row = mysqli_fetch_array($query))
	{

$nestedData=array();

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)

		$nestedData[] = "<span id='text-kode-".$row['id']."'>".$row["kode_barang"]."<span/>";
		$nestedData[] = "<p class='edit-jumlah' align='right' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>".rp($row["syarat_jumlah"])."<span/></p>
		<input type='hidden' data-id='".$row['id']."' data-jumlah='".$row['syarat_jumlah']."' class='edit-jumlah' id='input-jumlah-".$row['id']."' autofocus='' 
		onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' value='".$row['syarat_jumlah']."'>";
		$nestedData[] = "<p class='edit-potongan' align='right' data-id='".$row['id']."'><span id='text-potongan-".$row['id']."'>".rp($row["potongan"])."<span/></p>
		<input type='hidden' data-id='".$row['id']."' data-potongan='".$row['potongan']."' class='edit-potongan' id='input-potongan-".$row['id']."' autofocus='' 
		onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' value='".$row['potongan']."'>";	
		$nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus' id='hapus-tbs-". $row['id'] ."' data-id='". $row['id'] ."'>Hapus</button>";	
		$nestedData[] = $row["id"];	
	
		$data[] = $nestedData;	

} // end while

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format
?>


