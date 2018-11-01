<?php 
use controllers\UserController as UserController;

	$userController= new UserController();
	
	$user=$userController->checkSession();
	

// DUDA ESTA MAL INSTANCIAR UNA CONTROLADORA ACA? DE QUE OTRA FORMA SE PUEDE HACER PREGUNTAR
 ?>

<!-- Navigation -->



    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="<?= FRONT_ROOT ?>/home/">IziTicket</a>
        <div class="right">
        	<?php if($userController->checkSession()){ ?>
        	<a class="navbar-brand" href="..."><?= $user->getFirstname(); ?></a>
          	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/user/logout">Log out</a>
          <?php }else{ ?>
          	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/user">Ingresar</a>
          	<a class="btn btn-primary" href="<?= FRONT_ROOT ?>/user/singup">Registrarse</a>
          <?php } ?>
        </div>
      </div>
    </nav>