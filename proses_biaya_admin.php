<?php session_start();
include 'db.php';
include_once 'sanitasi.php';


$nama = stringdoang($_POST['nama']);
$persentase = angkadoang($_POST['persentase']);


$query = $db->prepare("INSERT INTO biaya_admin (nama,persentase) VALUES (?,?) ");

$query->bind_param("si",$nama, $persentase);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
	    else{

	 }

$query = $db->query("SELECT * FROM biaya_admin WHERE nama = '$nama'");
   $data = mysqli_fetch_array($query);   
      
      echo "<tr class='tr-id-".$data['id']."'>";
  $pilih_akses_biaya_admin_edit = $db->query("SELECT biaya_admin_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND biaya_admin_edit = '1'");
$biaya_admin_edit = mysqli_num_rows($pilih_akses_biaya_admin_edit);
  if ($biaya_admin_edit > 0) {
      
      echo "<td class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['nama'] ."</span> <input type='hidden' id='input-nama-".$data['id']."' value='".$data['nama']."' class='input_nama' data-id='".$data['id']."' data-nama='".$data['nama']."' autofocus=''> </td>";

      echo "<td class='edit-persen' data-id='".$data['id']."'><span id='text-persen-".$data['id']."'>". $data['persentase'] ."</span> <input type='hidden' id='input-persen-".$data['id']."' value='".$data['persentase']."' class='input_persen' data-id='".$data['id']."' data-persen='".$data['persentase']."' autofocus=''> %</td>";
}
else{

  echo "<td>". $data['nama'] ." </td>";
  echo "<td>". $data['persentase'] ." %</td>";

}

$pilih_akses_biaya_admin_hapus = $db->query("SELECT biaya_admin_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND biaya_admin_hapus = '1'");
$biaya_admin_hapus = mysqli_num_rows($pilih_akses_biaya_admin_hapus);
  if ($biaya_admin_hapus > 0) {

    echo "<td><button data-id='".$data['id']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";
    
  }
  else{

    echo "<td> </td>";

  }
      echo "
      </tr>";
    
    ?>

<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  
  $("#modale-delete").modal('show');
  $("#id2").val(id);  

});


</script>
                            
     