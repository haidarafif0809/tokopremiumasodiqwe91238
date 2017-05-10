
<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
      0 =>'no_faktur', 
      1 => 'tanggal',
      2 => 'jam',
      3 => 'status',
      4 => 'total_selisih',
      5 => 'user',
      5 => 'keterangan',
      6 => 'id'
);

// getting total number records without any search
$sql = "SELECT tio.no_faktur,tio.kode_barang,tio.nama_barang,s.nama,tio.id,tio.stok_sekarang,tio.fisik,tio.selisih_fisik,tio.harga,tio.selisih_harga,tio.hpp ";
$sql.="FROM tbs_stok_opname tio LEFT JOIN satuan s ON tio.satuan = s.id WHERE tio.no_faktur = '' OR tio.no_faktur IS NULL ";
$query=mysqli_query($conn, $sql) or die("datatable_stok_opname.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT tio.no_faktur,tio.kode_barang,tio.nama_barang,s.nama,tio.id,tio.stok_sekarang,tio.fisik,tio.selisih_fisik,tio.harga,tio.selisih_harga,tio.hpp ";
$sql.=" FROM tbs_stok_opname tio LEFT JOIN satuan s ON tio.satuan = s.id WHERE tio.no_faktur = '' OR tio.no_faktur IS NULL AND 1=1 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
      $sql.=" AND ( tio.no_faktur LIKE '".$requestData['search']['value']."%' ";    
      $sql.=" OR tio.tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_stok_opname.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.= " ORDER BY tio.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
      $nestedData=array(); 

      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];
      $nestedData[] = $row["nama"];
      $nestedData[] = "<p><span id='text-stok-sekarang-".$row['id']."'>".$row["stok_sekarang"]."</span></p>";

      $nestedData[] = "<p class='edit-jumlah' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['fisik'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['fisik']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-faktur='".$row['no_faktur']."' data-harga='".$row['harga']."' data-kode='".$row['kode_barang']."' data-selisih-fisik='".$row['selisih_fisik']."' data-stok-sekarang='".$row['stok_sekarang']."'></p>";

      $nestedData[] = "<p><span id='text-selisih-fisik-".$row['id']."'>". rp($row['selisih_fisik']) ."</span></p>";
                  
      $nestedData[] =   "<p> <button class='btn btn-danger btn-hapus-tbs btn-sm' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-nama-barang='". $row['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </p>";
            
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

