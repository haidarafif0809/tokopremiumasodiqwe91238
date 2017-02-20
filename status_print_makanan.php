<?php include 'session_login.php';


include 'header.php';
include 'sanitasi.php';
include 'db.php';

 ?>

<span id="demo">
	

</span>

 <script>
var myVar = setInterval(myTimer, 1000);

function myTimer() {

	$.get('cek_print.php', function(data) {
		$("#demo").html(data);
	});
    
}
</script>


<?php 
include 'footer.php';
 ?>