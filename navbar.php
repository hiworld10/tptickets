

<!-- Navigation -->

<?php 


 if(!isset($_SESSION)) 
    session_start();


 ?>
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="<?= FRONT_ROOT ?>/home/">IziTicket</a>
        <div class="right">
        	<?php if(isset($_SESSION['userLogedIn']) ){ 
            $user= $_SESSION['userLogedIn'];
           
            ?>



        	
          	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/user/logout">Log out</a>
          <?php }else{ ?>
          	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/user">Ingresar</a>
          	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/user/singup">Registrarse</a>
          <?php } ?>
        </div>
      </div>
    </nav>