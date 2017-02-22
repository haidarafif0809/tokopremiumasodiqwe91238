<?php include 'session_login.php';

include 'bootstrap.php';
include 'header.php';
include 'navbar.php';
include 'db.php';


?>


<?php 

echo bukacontainer();

echo filebootstrap();
echo input('text','bootstrap','bootstrap','Bootstrap');
echo input_label('Nama','text','bootstrap','bootstrap','Bootstrap');
echo textarea('Keterangan','bootstrap','bootstrap','bootstrap');

echo radioinline('Basing','Alasan','Izin');
echo radioinline('Basing','Alasan','Izin');

echo formbuka('kas.php','post','form-group');


echo select('amin','modal');
echo option('','Silahkan Pilih');
echo tutupselect();



echo modalpembuka('modal','submit');
echo modalpenutup('submit');
echo tombolmodal('default','lg','modal','submit');
echo alert('Hayoo','Jangan Macem Macem','danger');

echo tutupcontainer();
 ?>

