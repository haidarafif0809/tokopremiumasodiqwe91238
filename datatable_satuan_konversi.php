<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */
$id_produk =  stringdoang($_POST['id_produk']);
$satuan =  stringdoang($_POST['satuan_dasar']);

 $select = $db->query("SELECT nama FROM satuan WHERE id = '$satuan' ");
 $ddd = mysqli_fetch_array($select);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

    0=>'barcode', 
    1=>'satuan',
    2=>'konversi',
    3=>'harga_pokok',
    4=>'hapus',
    5=>'id'
   


);
// getting total number records without any search
$sql_data = "SELECT count(*)  AS jumlah_data ";
$sql_data.=" FROM satuan_konversi WHERE id_produk = '$id_produk'";
                              
$sql = "SELECT sk.kode_barcode,sk.id, sk.id_satuan, sk.id_produk, sk.konversi, sk.harga_pokok, sk.harga_jual_konversi, s.nama ";
$sql.="FROM satuan_konversi sk LEFT JOIN satuan s ON sk.id_satuan = s.id WHERE sk.id_produk = '$id_produk'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                                                  
    $sql.=" AND (s.nama LIKE '".$requestData['search']['value']."%' ) "; 

}


$sql.= " ORDER BY sk.id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

$query_data = $db->query($sql_data);
$query_jumlah_data = mysqli_fetch_array($query_data);

$totalData = $query_jumlah_data['jumlah_data'];

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = $query_jumlah_data['jumlah_data']; // when there is a search parameter then we have to modify total number filtered rows as per search result. 
   

$data = array();


while($row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 

    $nestedData[] = "<p class='edit_barcode' data-id='".$row['id']."'><span id='text-barcode-".$row['id']."'>".$row["kode_barcode"]."</span></p>
					<input type='hidden' id='input-barcode-".$row['id']."' data-barcode='".$row['kode_barcode']."' value='".$row['kode_barcode']."' class='input_barcode' data-id='".$row['id']."' autofocus=''>";
    
    $nestedData[] = "<p class='edit-satuan' data-id='".$row['id']."' data-nama='".$row['nama']."'><span id='text-satuan-".$row['id']."'>".$row["nama"]."</span></p>
                    <select style='display:none' id='select-satuan-".$row['id']."' class='select-satuan' data-id='".$row['id']."' autofocus=''>
                    </select>";

    $nestedData[] = "<p class='edit-konversi' data-id='".$row['id']."'><span id='text-konversi-".$row['id']."'>". rp($row['konversi'])." ".$ddd['nama']."</span></p>
                    <input type='hidden' id='input-konversi-".$row['id']."' data-satuan-dasar='".$ddd['nama']."' data-konversi='".$row['konversi']."' value='".$row['konversi']."' class='input_konversi' data-id='".$row['id']."' autofocus=''
                    onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'>";
    $nestedData[] = "<p align='right'  class='edit-harga_pokok' data-id='".$row['id']."'><span id='text-harga_pokok-".$row['id']."'>".rp($row['harga_pokok'])."</span></p>
                    <input type='hidden' id='input-harga_pokok-".$row['id']."'  data-harga_pokok='".$row['harga_pokok']."' value='".$row['harga_pokok']."' class='input_harga_pokok' data-id='".$row['id']."' autofocus=''
                    onkeydown='return numbersonly(this, event);' onkeyup='javascript:tandaPemisahTitik(this);'>"; 
    $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus' data-id='". $row['id'] ."' data-satuan='". $row['nama'] ."' data-satuan='". $row['id_satuan'] ."'> <i class='fa fa-trash'> </i> Hapus </button> ";         
    $nestedData[] = $row['id'];
    $data[] = $nestedData;

}

$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data  // total data array                       
            );

echo json_encode($json_data);  // send data as json format

 ?>


