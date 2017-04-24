<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$pilih_akses = $db->query("SELECT program_promo_tambah, program_promo_edit, program_promo_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$program_promo = mysqli_fetch_array($pilih_akses);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'id',
	1 => 'kode_program',
	3 => 'nama_program',
	4 => 'batas_akhir',
	5 => 'syarat_belanja',
	6 => 'jenis_bonus',
	7 => 'tanggal'
);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM program_promo";
$query=mysqli_query($conn, $sql) or die("datatable_program_promo.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM program_promo WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( kode_program LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR nama_program LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR syarat_belanja LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR batas_akhir LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR jenis_bonus LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatableee_program_promo.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	$nestedData[] = $row["kode_program"];
	$nestedData[] = $row["nama_program"];
	$nestedData[] = $row["batas_akhir"];
	$nestedData[] = rp($row["syarat_belanja"]);
	$nestedData[] = $row["jenis_bonus"];

	 if ($row["jenis_bonus"] == 'Free Produk') {
      $nestedData[] = "<a href='detail_program_promo.php?id=".$row['id']."&kode=". $row['kode_program']."&nama=". $row['nama_program']."' class='btn btn-success'></span> Detail Program </a>";
      }
      else{
      	$nestedData[] = "";
      }

      if ($row["jenis_bonus"] == 'Free Produk') {
      	$nestedData[] = "<a href='detail_bonus_free_program_promo.php?id=".$row['id']."&kode=". $row['kode_program']."&nama=". $row['nama_program']."' class='btn btn-success'>Free Produk </a>";
      }
      else{
      	$nestedData[] = "<a href='detail_bonus_disc_program_promo.php?id=".$row['id']."&kode=". $row['kode_program']."&nama=". $row['nama_program']."' class='btn btn-success'> Disc Harga </a>";
      }

	 if ($program_promo['program_promo_edit'] > 0) {
        $nestedData[] = "<td><button data-id='".$row['id']."' data-kode='".$row['kode_program']."' data-nama='".$row['nama_program']."' data-batas='".$row['batas_akhir']."' data-syarat='".$row['syarat_belanja']."' data-jenis='".$row['jenis_bonus']."' class='btn btn-warning edit'><span class='glyphicon glyphicon-edit'></span> Edit </button></td>";
      }

     if ($program_promo['program_promo_hapus'] > 0) {
        $nestedData[] = "<td><button data-id='".$row['id']."' data-kode='".$row['kode_program']."' data-nama='".$row['nama_program']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";
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
