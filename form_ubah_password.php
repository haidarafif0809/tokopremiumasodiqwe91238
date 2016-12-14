<?php include 'session_login.php';


 
 include 'db.php';
 include 'sanitasi.php';
 include 'header.php';
 include 'navbar.php';
 



 ?>
 <div class="container">
 	<div class="row">



<h1> FORM UBAH PASSWORD </h1> <hr>
<br><br>



<form role="form" method="post">



					<div class="form-group">
					<label> Username</label><br>
					<input type="text" name="username" id="username" value="<?php echo $_SESSION['user_name']; ?>" placeholder="Username" class="form-control" readonly="">
					</div>

					<div class="form-group">
					<label> Password Lama </label><br>
					<input type="password" name="password" id="password" placeholder="Password Lama" class="form-control">
					</div>
          <button type="submit" id="submit" class="btn btn-info"> <i class='fa fa-send'> </i> Submit </button>
         


					<div class="form-group" id="div_pw_baru" style="display: none" >
					<label> Password Baru </label><br>
					<input type="password" name="password_baru" id="password_baru" placeholder="Password Baru" class="form-control">
					</div>
   			
         <button id="ubah_password" type="submit" class="btn btn-primary" style="display: none"> <span class='glyphicon glyphicon-plus'> </span> Edit </button>

</form>

  <div class="alert alert-warning" id="alert_password" style="display:none">
   <strong>Warning! </strong>Password Yang Anda Masukan Salah, Silakan Masukan Kembali Password Anda !
  </div>

  <div class="alert alert-success" id="alert_edit" style="display:none">
   <strong>Berhasil! </strong> Password Berhasil Di Ubah
  </div>

  <span id="demo"></span>

</div><!-- end row -->



</div><!-- end container -->



   <script>
  
    $(document).ready(function(){

   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#submit").click(function(){

       var username = $("#username").val();
       var password = $("#password").val();


    $.post("cek_password_user.php",{username:username,password:password},function(data){

var x = parseInt(data,10);

if (x == 1) {

    $("#submit").hide();
    $("#div_pw_baru").show();
    $("#ubah_password").show();


}

else{


    $("#alert_password").show();
    $("#password").val('');

}



  

   });

              $('form').submit(function(){
              
              return false;
              });

   });




    });

      
  </script>

     <script>
$(document).ready(function(){

   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#ubah_password").click(function(){

       var username = $("#username").val();
       var password_baru = $("#password_baru").val();

    $.post("update_password.php",{username:username,password_baru:password_baru},function(data){
    
    $("#demo").val(data);
    $("#alert_edit").show();
    $("#password").val('');
    $("#password_baru").val('');
  
   });

              $('form').submit(function(){
              
              return false;
              });

   });
   });

      
  </script>

 <?php include 'footer.php'; ?>
  