
<!DOCTYPE html>


<html lang="en" class="__full-height-perc">

  <?php include_once(VIEWS_ROOT.HEADER); ?>

<body class="__full-height-perc">


  <?php include_once(VIEWS_ROOT.NAVBAR); ?>

  <div id="container" class="__full-height-perc">

   <?php include_once(VIEWS_ROOT.MENUADMIN); ?>

  <?php if(isset($user)) { ?>

    <form name='formulario' action="<?=FRONT_ROOT?>/user/updateUser"  method="POST">
     <div class="form-row">
      <div class="col-12 col-md-9 mb-2 mb-md-0">
        <input type="text" name="id" class="form-control form-control-lg" value="<?= $user->getId(); ?>" readonly>
      </div>
      <div class="col-12 col-md-9 mb-2 mb-md-0">
        <input type="email" name="email" class="form-control form-control-lg" value="<?= $user->getEmail(); ?>" required>
        <div class="col-12 col-md-9 mb-2 mb-md-0">
          <input type="password" name="password" class="form-control form-control-lg" value="<?= $user->getPassword(); ?>" required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-0">
          <input type="text" name="firstname" class="form-control form-control-lg" value="<?= $user->getFirstName(); ?>" required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-0">
          <input type="text" name="lastname" class="form-control form-control-lg" value="<?= $user->getLastName(); ?>" required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
         <label><input type="checkbox" name="admin" class="form-control form-control-lg" value="<?= $user->isAdmin(); ?>">Admin</label>
       </div>
        <div class="col-12 col-md-3">
          <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
        </div>
      </div>
    </form>

    <div id="divform" class="__full-height-perc">

    <?php } else { ?>

      <form name='formulario' action="<?=FRONT_ROOT?>/user/addUser"  method="POST">
       <div class="form">
        <div class="col-12 col-md-9 mb-2 mb-md-3">
          <input type="email" name="email" class="form-control form-control-lg" placeholder="Email..." required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
          <input type="password" name="password" class="form-control form-control-lg" placeholder="Contraseña..." required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
          <input type="text" name="name" class="form-control form-control-lg" placeholder="Nombre..." required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
          <input type="text" name="lastname" class="form-control form-control-lg" placeholder="Apellido..." required="">
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
         <td><?= $value->isAdmin(); ?></td>

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
