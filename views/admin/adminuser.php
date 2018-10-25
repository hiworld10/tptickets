
<!DOCTYPE html>


<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>IziTicket - Página principal</title>

  <!-- Bootstrap core CSS -->

  <link href="<?=FRONT_ROOT?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="<?=FRONT_ROOT?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="<?=FRONT_ROOT?>/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="<?=FRONT_ROOT?>/css/landing-page.min.css" rel="stylesheet">

</head>

<body>


  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="#">IziTicket</a>
      <div class="right">
        <a class="btn btn-primary" href="vistas/login2.php">Log out</a>
      </div>
    </div>
  </nav>


  <link rel="stylesheet" type="text/css" href="<?=FRONT_ROOT?>/css/admin.css" >

  <div id="container">

    <div id="cssmenu">
     <ul>
      <li><a href="<?=FRONT_ROOT?>/artist/getAll">Artistas</a></li>
      <li><a href="<?=FRONT_ROOT?>/category/getAll" title="...">Categorias</a></li>
      <li><a href="..." title="...">Eventos</a></li>
      <li><a href="..." title="...">Calendario</a></li>
      <li><a href="<?=FRONT_ROOT?>/user/getAll" title="...">Usuarios</a></li>
    </ul>
  </div>

  <?php if(isset($user)) { ?>

    <form name='formulario' action="<?=FRONT_ROOT?>/user/updateUser"  method="POST">
     <div class="form-row">
      <div class="col-12 col-md-9 mb-2 mb-md-0">
        <input type="text" name="id" class="form-control form-control-lg" value="<?= $user->getId(); ?>" readonly>
      </div>
      <div class="col-12 col-md-9 mb-2 mb-md-0">
        <input type="text" name="email" class="form-control form-control-lg" value="<?= $user->getEmail(); ?>">
        <div class="col-12 col-md-9 mb-2 mb-md-0">
          <input type="password" name="password" class="form-control form-control-lg" value="<?= $user->getPassword(); ?>">
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-0">
          <input type="text" name="firstname" class="form-control form-control-lg" value="<?= $user->getFirstName(); ?>">
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-0">
          <input type="text" name="lastname" class="form-control form-control-lg" value="<?= $user->getLastName(); ?>">
        </div>
        <div class="col-12 col-md-3">
          <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
        </div>
      </div>
    </form>

    <div id="divform">

    <?php } else { ?>

      <form name='formulario' action="<?=FRONT_ROOT?>/user/addUser"  method="POST">
       <div class="form">
        <div class="col-12 col-md-9 mb-2 mb-md-3">
          <input type="email" name="email" class="form-control form-control-lg" placeholder="Email...">
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
          <input type="password" name="password" class="form-control form-control-lg" placeholder="Contraseña...">
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
          <input type="text" name="name" class="form-control form-control-lg" placeholder="Nombre...">
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
          <input type="text" name="lastname" class="form-control form-control-lg" placeholder="Apellido...">
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
         <label><input type="checkbox" name="admin" class="form-control form-control-lg" value="true">Admin</label>
       </div>
       <div class="col-12 col-md-3">
        <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
      </div>
    </div>
  </form>
<?php } ?>

<div id="table">
  <table class="table bg-light-alpha">

    <?php if(!empty($userArray)) { ?>
      <thead>     
       <th>Id</th>  
       <th>Email</th> 
       <th>Password</th> 
       <th>Nombre</th>   
       <th>Apellido</th>
       <th>Admin</th>           
     </thead>
     <tbody>
      <?php foreach ($userArray as $value) { ?>
        <tr>
         <td><?= $value->getId(); ?></td>
         <td><?= $value->getEmail(); ?></td>
         <td><?= $value->getPassword(); ?></td>
         <td><?= $value->getFirstname(); ?></td>
         <td><?= $value->getLastname(); ?></td>
         <td><?= $value->getAdmin(); ?></td>

         <td>
          <form action="<?=FRONT_ROOT?>/user/deleteUser" method="POST">
            <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
          </form>
          <form action="<?=FRONT_ROOT?>/user/getUser" method="POST">
            <button name="update" value="<?= $value->getId(); ?>" type="submit" class="btn btn-block btn-lg btn-primary btn-sm">Editar</button></td>
          </form>
        </tr>
      <?php } ?>

    </tbody>
  <?php  } ?>
</table>

</div>

</div>

</div>

</div>











<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
