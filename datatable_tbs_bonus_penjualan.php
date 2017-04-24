<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = session_id();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_produk', 
    1=>'nama_produk',
    2=>'id' 

);

// getting total number records without any search
$sql =" SELECT s.nama,tbp.kode_produk, tbp.nama_produk, tbp.keterangan, tbp.qty_bonus, tbp.harga_disc, tbp.qty_bonus, tbp.harga_disc, tbp.id ";
$sql.=" FROM tbs_bonus_penjualan tbp LEFT JOIN satuan s ON tbp.satuan = s.id WHERE tbp.session_id = '$session_id' AND tbp.kode_pelanggan IS NULL ";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT s.nama,tbp.kode_produk, tbp.nama_produk, tbp.keterangan, tbp.qty_bonus, tbp.harga_disc, tbp.qty_bonus, tbp.harga_disc, tbp.id ";
$sql.=" FROM tbs_bonus_penjualan tbp LEFT JOIN satuan s ON tbp.satuan = s.id WHERE tbp.session_id = '$session_id' AND tbp.kode_pelanggan IS NULL AND 1=1 ";

    $sql.=" AND (tbp.kode_produk LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tbp.nama_produk LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tbp.id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $nestedData[] = $row["kode_produk"];
      $nestedData[] = $row["nama_produk"];
      if ($row['keterangan'] == 'Disc Produk') {
        $nestedData[] = "<p style='font-size:15px' align='right' class='edit-qty-bonus' data-id='".$row['id']."' data-kode-produk-input='".$row['kode_produk']."'> <span id='text-qty-".$row['id']."'>".$row["qty_bonus"]."</span> <input type='hidden' id='input-qty-".$row['id']."' value='".$row['qty_bonus']."' class='input_qty_bonus' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_produk']."' data-harga='".$row['harga_disc']."' data-nama-produk='".$row['nama_produk']."'> </p>";
      }
      else{
        $nestedData[] = rp($row["qty_bonus"]);
      }
      $nestedData[] = $row["nama"];
      $nestedData[] = rp($row["harga_disc"]);
      $nestedData[] = rp($row["qty_bonus"] * $row["harga_disc"]);
      $nestedData[] =  $row["keterangan"];
      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbsbonus' id='hapus-tbs-". $row['id'] ."' data-id='". $row['id'] ."' data-kode-produk='". $row['kode_produk'] ."' data-produk='". $row['nama_produk'] ."' data-qty='". $row['qty_bonus'] ."'>Hapus</button>";
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