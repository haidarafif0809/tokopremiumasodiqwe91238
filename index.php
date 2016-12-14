<?php

include 'header.php';


?>
<link rel="stylesheet" href="login.css">
<script src="login.js"></script>

<div class="container">
  
  <div class="row" id="pwd-container">
    <div class="col-md-4"></div>
    
    <div class="col-md-4">
      <section class="login-form">
        <form method="post" action="proseslogin.php" role="login">
          <img src="save_picture/Lowongan Kerja Lampung  Terbaru di PT. Andaglos Teknologi.png" style="height: 30%; width: 90%" class="img-responsive" alt="" />
          <h3><center> SILAKAN MASUK </center></h3>
          <input type="text" name="username" placeholder="Username" autocomplete="off" required class="form-control input-lg" value="" />
          
          <input type="password" name="password" class="form-control input-lg" id="password" placeholder="Password  " required="" />
          
          
          <div class="pwstrength_viewport_progress"></div>
          
          
          <button type="submit" name="go" style="background-color: #0d47a1" class="btn btn-lg btn-block">Login</button>
                    
        </form>
        
        <div class="form-links">
          <a href="https://www.andaglos.com" target="blank"> ©Copyright 2016 |  PT.Andaglos Global Teknologi.</a>
        </div>
      </section>  
      </div>
      
      <div class="col-md-4"></div>
      

  </div>
   
  
  
</div>



<?php

include 'footer.php';

?>