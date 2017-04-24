<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


$pilih_akses_stok_awal = $db->query("SELECT * FROM otoritas_stok_awal WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$stok_awal = mysqli_fetch_array($pilih_akses_stok_awal);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id',
	1 =>'nama_satuan',
	2 =>'kode_barang',
	3 =>'nama_barang',
	4 =>'no_faktur',
	5 =>'jumlah_awal',
	6 =>'harga',
	7 =>'satuan',
	8 =>'total',
	9 =>'tanggal',
	10 =>'jam',
	11 =>'user'
);

// getting total number records without any search
$sql ="SELECT s.nama AS nama_satuan,sa.id,sa.kode_barang,sa.nama_barang,sa.no_faktur,sa.jumlah_awal,sa.harga,sa.satuan,sa.total,sa.tanggal,sa.jam,sa.user ";
$sql.="FROM stok_awal sa INNER JOIN satuan s ON sa.satuan = s.id ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql ="SELECT s.nama AS nama_satuan,sa.id,sa.kode_barang,sa.nama_barang,sa.no_faktur,sa.jumlah_awal,sa.harga,sa.satuan,sa.total,sa.tanggal,sa.jam,sa.user ";
$sql.="FROM stok_awal sa INNER JOIN satuan s ON sa.satuan = s.id where 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( sa.kode_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR sa.nama_barang LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR sa.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR sa.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR sa.jam LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_pembelian.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY sa.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

			
			//menampilkan data
			$nestedData[] = $row['kode_barang'];
			$nestedData[] = $row['nama_barang'];

       $hpp_keluar = $db->query("SELECT * FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$row[no_faktur]' AND kode_barang = '$row[kode_barang]'");
       $row_hpp = mysqli_num_rows($hpp_keluar);

       if ($row_hpp > 0 ) {
        $nestedData[] = "<p style='font-size:15px' align='right' class='edit-alert' data-id='".$row['id']."' data-kode-barang='". $row['kode_barang'] ."' data-faktur='". $row['no_faktur'] ."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_awal'] ."</span><input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_awal']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-harga='".$row['harga']."' data-kode='".$row['kode_barang']."' ></p>";
       }

       else{
         $nestedData[] = "<p style='font-size:15px' align='right' class='edit-jumlah' data-id='".$row['id']."'> <span id='text-jumlah-".$row['id']."'>". $row['jumlah_awal'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_awal']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-harga='".$row['harga']."' data-kode='".$row['kode_barang']."' ></p>";
       }

			$nestedData[] = $row['nama_satuan'];
			$nestedData[] = rp($row['harga']);
			$nestedData[] = "<span id='text-total-".$row['id']."'>". rp($row['total']) ."</span>";
			$nestedData[] = tanggal($row['tanggal']);
			$nestedData[] = $row['jam'];
			$nestedData[] = $row['user'];


if ($stok_awal['stok_awal_hapus'] > 0) {

        if ($row_hpp > 0 ) {
          $nestedData[] = "<button class='btn btn-danger btn-alert' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-nama-barang='". $row['nama_barang'] ."' data-faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
        } 

        else {
          $nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-nama-barang='". $row['nama_barang'] ."' data-faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
        }
        
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
