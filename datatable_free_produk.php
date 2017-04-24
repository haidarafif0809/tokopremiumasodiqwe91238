<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$id = angkadoang($_POST['id_nya']);

$pilih_akses = $db->query("SELECT program_promo_free_tambah, program_promo_free_edit, program_promo_free_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$produk_promo = mysqli_fetch_array($pilih_akses);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'id',
	1 => 'nama_produk',
	2 => 'nama_program',
	3 => 'qty'
);

// getting total number records without any search
$sql = "SELECT pfp.id,pfp.qty,pfp.nama_program,pfp.nama_produk,b.kode_barang, b.nama_barang,b.id AS id_barang, pro2.kode_program, pro2.nama_program AS napro, pro2.id AS id_program ";
$sql.=" FROM promo_free_produk pfp INNER JOIN barang b ON pfp.nama_produk = b.id INNER JOIN program_promo pro2 ON pfp.nama_program = pro2.id WHERE pfp.nama_program = '$id'";
$query=mysqli_query($conn, $sql) or die("datatable_free_produk.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT pfp.id,pfp.qty,pfp.nama_program,pfp.nama_produk,b.kode_barang, b.nama_barang, b.id AS id_barang, pro2.kode_program, pro2.nama_program AS napro, pro2.id AS id_program ";
$sql.=" FROM promo_free_produk pfp INNER JOIN barang b  ON pfp.nama_produk = b.id INNER JOIN program_promo pro2 ON pfp.nama_program = pro2.id WHERE pfp.nama_program = '$id' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( b.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pro2.nama_program LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pro2.kode_program LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR b.kode_barang LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatableee_free_produk.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY pfp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	$nestedData[] = $row["nama_barang"] . "(" . $row["kode_barang"] .")";
	$nestedData[] = rp($row["qty"]);
	$nestedData[] = $row["napro"] . "(" . $row["kode_program"] .")";

	 if ($produk_promo['program_promo_free_edit'] > 0) {
        $nestedData[] = "<button data-id='".$row['id']."' data-nama_produk='".$row['nama_barang']."' data-id_produk='".$row['id_barang']."' data-kode_program='".$row['napro'] ."' data-id_program='".$row['id_program']."' data-qty='".$row['qty']."' class='btn btn-warning edit'><span class='fa fa-edit'></span> Edit </button>";
      }
     if ($produk_promo['program_promo_free_hapus'] > 0) {
        $nestedData[] = "<td><button data-id='".$row['id']."' data-nama_produk='".$row['nama_barang']."' data-nama_program='".$row['napro']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";
      }
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
