<?php require HEADER; ?>

  <div id="container" class="__full-height-perc">

       <?php require(ADMIN_NAVBAR); ?>


    <div id="divform"  class="__full-height-perc">

    <div id=edit class="__full-height-perc">
      <!-- Este div aparecerá si un artista debe ser modificado -->
      <?php if(isset($user)) { ?>

        <form name='formulario' action="<?=FRONT_ROOT?>/users/updateUser"  method="POST">
     <div class="form">
      <div class="col-9 col-md-2 mb-2 mb-md-0 ">
        <label>Id</label>
        <input type="text" name="id" class="form-control form-control-lg" value="<?= $user->getId(); ?>" readonly>
      </div>
      <div class="col-12 col-md-9 mb-2 mb-md-0">
        <label>Email</label>
        <input type="email" name="email" class="form-control form-control-lg" value="<?= $user->getEmail(); ?>" readonly>
      </div>
        <div class="col-12 col-md-9 mb-2 mb-md-0">
           <label>Password</label>
          <input type="password" name="password" class="form-control form-control-lg" value="<?= $user->getPassword(); ?>" required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-0">
           <label>Nombre</label>
          <input type="text" name="firstname" class="form-control form-control-lg" value="<?= $user->getFirstName(); ?>" required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-0">
           <label>Apellido</label>
          <input type="text" name="lastname" class="form-control form-control-lg" value="<?= $user->getLastName(); ?>" required>
        </div>
        <div class="col-12 col-md-9 mb-2 mb-md-3">
         <label><input type="checkbox" name="admin" class="form-control form-control-lg" value="true"
          <?php 
          /*si el valor devuelve "true", el checkbox queda marcado con el 
          atributo html "checked". Caso contrario, aparece sin marcar*/
          if($user->getAdmin() == "true") 
            echo "checked" ?>
          >Admin</label>
       </div>
        <div class="col-12 col-md-3">
          <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
        </div>
      </div>
    </form>
    <?php   } else {   ?>

        <!-- De no ser así, se habilitará el formulario para agregar usuarios  -->
        <form name='formulario' action="<?=FRONT_ROOT?>/home/addUser"  method="POST">
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

    
<!-- Lista de usuarios -->
  <div id="table" class="__full-height-perc">
    <table class="table bg-light-alpha">

          <?php if(!empty($data['users'])) { ?>
      <thead>     
       <th>Id</th>  
       <th>Email</th> 
       <th>Password</th> 
       <th>Nombre</th>   
       <th>Apellido</th>
       <th>Admin</th>           
     </thead>
     <tbody>
      <?php foreach ($data['users'] as $value) { ?>
        <tr>
         <td><?= $value->getId(); ?></td>
         <td><?= $value->getEmail(); ?></td>
         <td><?= $value->getName(); ?></td>
         <td><?= $value->getSurname(); ?></td>
         <td><?= $value->getAdmin(); ?></td>

         <td>
          <form action="<?=FRONT_ROOT?>/users/deleteUser" method="POST">
            <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
          </form>
        </td>
        <td>
          <form action="<?=FRONT_ROOT?>/users/getUser" method="POST">
            <button name="update" value="<?= $value->getId(); ?>" type="submit" id="boton1" class="btn btn-block btn-lg btn-primary btn-sm">Editar</button>
        </td>
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
