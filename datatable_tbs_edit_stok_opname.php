<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_faktur = stringdoang($_POST['no_faktur']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'satuan',
    3=>'stok_komputer',
    4=>'jumlah_fisik',
    5=>'selisih_fisik',
    6=>'hpp',
    7=>'selisih_harga',
    8=>'harga', 
    9=>'hapus',
    10=>'id' 

);




// getting total number records without any search
$sql =" SELECT tio.no_faktur,tio.kode_barang,tio.nama_barang,s.nama,tio.id,tio.stok_sekarang,tio.fisik,tio.selisih_fisik,tio.harga,tio.selisih_harga,tio.hpp ";
$sql.=" FROM tbs_stok_opname tio LEFT JOIN satuan s ON tio.satuan = s.id";
$sql.=" WHERE tio.no_faktur = '$no_faktur'  ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tio.no_faktur,tio.kode_barang,tio.nama_barang,s.nama,tio.id,tio.stok_sekarang,tio.fisik,tio.selisih_fisik,tio.harga,tio.selisih_harga,tio.hpp ";
$sql.=" FROM tbs_stok_opname tio LEFT JOIN satuan s ON tio.satuan = s.id";
$sql.=" WHERE tio.no_faktur = '$no_faktur' AND 1=1  ";

    $sql.=" AND ( tio.no_faktur LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tio.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tio.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR tio.selisih_fisik LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tio.no_faktur ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];
      $nestedData[] = $row["nama"];
      $nestedData[] = "<p><span id='text-stok-sekarang-".$row['id']."'>". rp($row['stok_sekarang']) ."</span></p>";

      $pilih = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$row[no_faktur]' AND kode_barang = '$row[kode_barang]' AND sisa != jumlah_kuantitas");
        $row_alert = mysqli_num_rows($pilih);

                  if ($row_alert > 0){
                  
                  $nestedData[] = "<p class='btn-alert' data-kode-barang='". $row['kode_barang'] ."' data-faktur='". $row['no_faktur'] ."' >". $row['fisik'] ."  </p>";
                  }
                  
                  else{
                  
                  $nestedData[] = "<p class='edit-jumlah' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['fisik'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['fisik']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-faktur='".$row['no_faktur']."' data-harga='".$row['harga']."' data-kode='".$row['kode_barang']."' data-selisih-fisik='".$row['selisih_fisik']."' data-stok-sekarang='".$row['stok_sekarang']."'> </p>";
                      }


                  $nestedData[] = "<p><span id='text-selisih-fisik-".$row['id']."'>". rp($row['selisih_fisik']) ."</span></p>";
                  $nestedData[] = "<p><span id='text-hpp-".$row['id']."'>". rp($row['hpp']) ."</span></p>";
                  $nestedData[] = "<p><span id='text-selisih-".$row['id']."'>". rp($row['selisih_harga']) ."</span></p>";
                  $nestedData[] = "<p>". rp($row['harga']) ."</p>";

             
                  
                  if ($row_alert > 0) {
                  
                  $nestedData[] = "<p> <button class='btn btn-danger btn-alert btn-sm' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-faktur='". $row['no_faktur'] ."' data-nama-barang='". $row['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </p> ";
                }
                else{
                  $nestedData[] = "<p> <button class='btn btn-danger btn-hapus btn-sm' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-nama-barang='". $row['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </p>";
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