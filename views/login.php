<!DOCTYPE html>
<html lang="en">

<?php include_once(VIEWS_ROOT.HEADER); ?>

  <body>

 <?php include_once(VIEWS_ROOT.NAVBAR); ?>

<style type="text/css">
  main{
    background-image: url("<?= IMG_FRONT_ROOT?>/fondologin.jpg");
    height: auto;
    width: auto;
  }
  h2{
    color: white;
  }
</style>

  <main class="d-flex align-items-center justify-content-center height-100">
          <div class="content">
               <header class="text-center mt-5">
                    <h2>Login!</h2>
                   
               </header>
               <form class="login-form bg-dark-alpha p-5 text-white" action="<?=FRONT_ROOT?>/user/login ?>" method="POST">
                    <div class="form-group">
                         <label for="">Usuario</label>
                         <input type="text" name="email" class="form-control form-control-lg" placeholder="Ingresar usuario">
                    </div>
                    <div class="form-group">
                         <label for="">Contraseña</label>
                         <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña">
                    </div>
                    <button class="btn btn-dark btn-block btn-lg mt-5" type="submit">
                         Iniciar Sesión
                    </button>
               </form>
          </div>
     </main>

    <?php include_once(VIEWS_ROOT.FOOTER); ?>

   
    

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
