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

//NAMA PROGRAM
	$nestedData[] = "<p class='edit-nama' data-id='".$row['id']."'><span id='text-nama-".$row['id']."'>". $row['nama_program'] ."</span> <input type='hidden' data-id='".$row['id']."' data-nama='".$row['nama_program']."' class='edit_nama' id='input-nama-".$row['id']."' autofocus='' value='".$row['nama_program']."' </p>";

//BATAS AKHIR PROGRAM
	$nestedData[] = "<p style='font-size:15px' class='edit-tanggal' data-id='".$row['id']."' data-kode='".$row['kode_program']."'> <span id='text-tanggal-".$row['id']."'> ".$row['batas_akhir']." </span> <input type='hidden' id='input-tanggal-".$row['id']."' value='".$row['batas_akhir']."' class='input_tanggal' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_program']."'> </p>";

//SYARAT PROGRAM
	$nestedData[] = "<p class='edit-syarat' data-id='".$row['id']."'><span id='text-syarat-".$row['id']."'>". rp($row['syarat_belanja']) ."</span> <input type='hidden' data-id='".$row['id']."' data-syarat='".$row['syarat_belanja']."' class='edit_syarat' id='input-syarat-".$row['id']."' autofocus='' value='".$row['syarat_belanja']."' onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);' </p>";

//JENIS BONUS PROGRAM
	$jenis_bonus = "<p class='edit-jenis' data-id='".$row['id']."'><span id='text-jenis-".$row['id']."'>". $row['jenis_bonus'] ."</span>
      <select style='display:none' id='select-jenis-".$row['id']."' value='".$row['jenis_bonus']."' class='select-jenis' data-id='".$row['id']."' autofocus=''>";

      if ($row['jenis_bonus'] == 'Free Produk') {
      	$jenis_bonus .= "
          <option selected>Free Produk</option>  
          <option>Disc. Produk</option>
      </select>";
      }
      else{
      	$jenis_bonus .= "
          <option selected>Disc. Produk</option>  
          <option>Free Produk</option>
      </select>";
      }
      

      $nestedData[] = "<p>".$jenis_bonus."</p>";

	 if ($row["jenis_bonus"] == 'Free Produk') {
      $nestedData[] = "<a href='detail_program_promo.php?id=".$row['id']."&kode=". $row['kode_program']."&nama=". $row['nama_program']."' class='btn btn-success btn-sm'></span> Detail Program </a>";
      }
      else{
      	$nestedData[] = "";
      }

      if ($row["jenis_bonus"] == 'Free Produk') {
      	$nestedData[] = "<a href='detail_bonus_free_program_promo.php?id=".$row['id']."&kode=". $row['kode_program']."&nama=". $row['nama_program']."' class='btn btn-success btn-sm'>Free Produk </a>";
      }
      else{
      	$nestedData[] = "<a href='detail_bonus_disc_program_promo.php?id=".$row['id']."&kode=". $row['kode_program']."&nama=". $row['nama_program']."' class='btn btn-success btn-sm'> Disc Harga </a>";
      }

     if ($program_promo['program_promo_hapus'] > 0) {
        $nestedData[] = "<td><button data-id='".$row['id']."' data-kode='".$row['kode_program']."' data-nama='".$row['nama_program']."' class='btn btn-danger delete btn-sm'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";
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
