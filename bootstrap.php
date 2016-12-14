<?php 



function filebootstrap(){


	$file = '<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';
  return $file;
}
function input($type,$id,$name,$placeholder){

$input = '                  <div class="form-group">
		  <input type="'.$type. '" name="'.$name.'" id="'.$id.'" class="form-control" placeholder="'.$placeholder.'">
		  </div>';


return $input;
}

function input_label($label,$type,$id,$name,$placeholder){

$input = '                  <div class="form-group"><label for="'.$id.'">'.$label.'</label>
		  <input type="'.$type. '" name="'.$name.'" id="'.$id.'" class="form-control" placeholder="'.$placeholder.'">
		  </div>';


return $input;
}

//kode untuk membuat text area

function textarea($label,$rows,$id,$nama){

	$ha = '<div class="form-group">
  <label for="'.$id.'">'.$label.'</label>
  <textarea class="form-control" rows="'.$rows.'" id="'.$rows.'" name="'.$nama.'"></textarea>
</div>';
return $ha;


}

function radio($label,$nama,$value){
$as = '<div class="radio">
  <label><input type="radio" name="'.$nama.'" value="'.$value.'">'.$label.'</label>
</div>';
return $as;

}

function radioinline($label,$nama,$value){
$as = '
  <label class="radio-inline"><input type="radio" name="'.$nama.'" value="'.$value.'">'.$label.'</label>
';
return $as;

}

function formbuka($action, $method,$jenis){

$form = '<form action="'.$action.'" method="'.$method.'" class="'. $jenis.'">';

return $form;

}


function formtutup(){

	$tutup = '</form>';
 return $tutup; 
}
function bukacontainer(){

	$container = '<div class="container">';
	return $container;
}

function tutupcontainer(){

	$tutup = '</div>';
	return $tutup;
}

function select($nama,$id){

	$select = '<select id="'.$id.'" name="'.$nama.'" class="form-control" >';
 	return $select;
}

function option($value,$label){

	$as = '<option value="'.$value.'">'.$label.'</option>';
	return $as;
}
function tutupselect(){

	$select = "</select>";
	return $select;
}
function alert($depan,$isi,$tipe){

$alert = '<div class="alert alert-'.$tipe.'">
  <strong>'.$depan.'</strong> '.$isi.'
</div>';

return $alert;

}

function tombol($tipe, $class,$tulisan){

	$tombol = '<button type="'.$tipe.'" class="btn btn-'.$class.'">'.$tulisan.'</button>';
	return $tombol;
}

function tombolbesar($tipe,$class,$tulisan){

	$tombol = '<button type="'.$tipe.'" class="btn btn-'.$class.' btn-lg">'.$tulisan.'</button>';
	return $tombol;
}
function tombolmedium($tipe,$class,$tulisan){

	$tombol = '<button type="'.$tipe.'" class="btn btn-'.$class.' btn-md">'.$tulisan.'</button>';
	return $tombol;
}

function tombolkecil($tipe,$class,$tulisan){

	$tombol = '<button type="'.$tipe.'" class="btn btn-'.$class.' btn-sm">'.$tulisan.'</button>';
	return $tombol;
}

function tombolsangatkecil($tipe,$class,$tulisan){

	$tombol = '<button type="'.$tipe.'" class="btn btn-'.$class.' btn-xs">'.$tulisan.'</button>';
	return $tombol;
}
function tombolblok($tipe,$class,$tulisan){

	$tombol = '<button type="'.$tipe.'" class="btn btn-'.$class.' btn-block">'.$tulisan.'</button>';
	return $tombol;
}
function tombolaktif($tipe,$class,$tulisan){

	$tombol = '<button type="'.$tipe.'" class="btn btn-'.$class.' active">'.$tulisan.'</button>';
	return $tombol;
}
function tomboldisable($tipe,$class,$tulisan){

	$tombol = '<button type="'.$tipe.'" class="btn btn-'.$class.' disable">'.$tulisan.'</button>';
	return $tombol;
}


function modalpembuka($id,$judul){


$modal = '<div id="'.$id.'" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">'.$judul.'</h4>
      </div>
      <div class="modal-body">';

      return $modal;
}
// kode untuk tutup modal
function modalpenutup($judul){

 $penutup = '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">'.$judul.'</button>
      </div>
    </div>

  </div>
</div>';
return $penutup;
}
///////////////////////////////////

// kode untuk membuat tombol modal
function tombolmodal($class,$ukuran,$target,$judul){

$modal = '<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-'.$class.' btn-'.$ukuran.'" data-toggle="modal" data-target="#'.$target.'">'.$judul.'</button>';

return $modal;

}
//////////////////////////////////////


function panelpembuka(){

$panel = '<div class="panel panel-default">
  <div class="panel-body">';
  return $panel;

}


function panelpenutup(){

$panel = '</div>
</div>';
return $panel;
}

function tombolcollapse($class,$judul,$target){

	$tombol = '<button class="'.$class.'" data-toggle="collapse" data-target="#'.$target.'">'.$judul.'</button>';
	return $tombol;
}

function collapsepembuka($id){

	$tom = '<div id="'.$id.'" class="collapse">';
	return $tom;
}

function collapsepenutup(){

	$tom = '</div>';
	return $tom;
}

function gambarsuduttumpul($src,$alt,$lebar,$tinggi){

	$ha = '<img src="'.$src.'" class="img-rounded" alt="'.$alt.'" width="'.$lebar.'" height="'.$tinggi.'">';
	return $ha;
}
function gambarbulat($src,$alt,$lebar,$tinggi){

	$ha = '<img src="'.$src.'" class="img-circle" alt="'.$alt.'" width="'.$lebar.'" height="'.$tinggi.'">';
	return $ha;
}

function gambarthumbnail($src,$alt,$lebar,$tinggi){

	$ha = '<img src="'.$src.'" class="img-thumbnail" alt="'.$alt.'" width="'.$lebar.'" height="'.$tinggi.'">';
	return $ha;
}

function gambarresponsif($src,$alt){

	$ha = '<img src="'.$src.'" class="img-responsive" alt="'.$alt.'" >';
	return $ha;
}
 ?>