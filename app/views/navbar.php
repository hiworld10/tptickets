<?php 
 if(!isset($_SESSION)) 
    session_start();
 ?>
 
<nav class="navbar navbar-light bg-light static-top">
  <div class="container">

    <?php if(isset($_SESSION['userLogedIn']) ){ 
        $user= $_SESSION['userLogedIn'];
       

       if($user->getAdmin()=='true'){
        ?>
    <a class="navbar-brand" href="<?= FRONT_ROOT ?>/users/adminview">IziTicket</a>
  <?php }else{ ?>
    <a class="navbar-brand" href="<?= FRONT_ROOT ?>/home/">IziTicket</a>
  <?php } ?>
    <div class="right">
      	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/logout">Log out</a>
    </div>
      <?php }else{ ?>
        <a class="navbar-brand" href="<?= FRONT_ROOT ?>/home/">IziTicket</a>
    <div class="right">
      	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/loginScreen">Ingresar</a>
      	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/signup">Registrarse</a>
    </div>
      <?php } ?>
    
  </div>
</nav>