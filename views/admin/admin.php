<?php 
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IziTicket - Página principal</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= FRONT_ROOT ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?= FRONT_ROOT ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= FRONT_ROOT ?>vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="<?= FRONT_ROOT ?>/css/landing-page.min.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="#">IziTicket</a>

        
        <div class="right">
          <a class="btn btn-primary" href="vistas/registrarse.php">Registrarse</a>
          <a class="btn btn-primary" href="vistas/login2.php">Ingresar</a>
        </div>
        
      </div>
    </nav>

    <!-- Masthead -->
    <header class="masthead text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">La forma mas facil de comprar tus tickets a un solo click!</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">

            <form action="<?php echo FRONT_ROOT ?>/artist/addArtist"  method="POST">
              <div class="form-row">
                <div class="col-12 col-md-9 mb-2 mb-md-0">
                  <input type="text" name="artist" class="form-control form-control-lg" placeholder="Ingrese un artista...">
                </div>
                <div class="col-12 col-md-3">
                  <button type="submit" class="btn btn-block btn-lg btn-primary">Buscar</button>
                </div>
              </div>
            </form>

            <form action="<?php FRONT_ROOT ?>/event/addEvent"  method="POST">
              <div class="form-row">
              
                <div class="form-group">
                  <input type="text" name="eventName" class="form-control form-control-lg" placeholder="Ingrese un nombre...">
                </div>
                <div class="form-group">
                  <input type="date" name="eventDate" class="form-control form-control-lg" placeholder="Ingrese un fecha...">
                </div>
                <div class="col-12 col-md-3">
                  <button type="submit" class="btn btn-block btn-lg btn-primary">Buscar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

<table class="table bg-light-alpha">

        <?php if(!empty($artistArray)) { ?>
            <thead>     
               <th>Nombre</th>            
           </thead>
           <tbody>
            <?php foreach ($artistArray as $value) { ?>
                <tr>
                    <td><?php echo $value->getName(); ?></td>
      
                </tr>
            <?php } ?>

        </tbody>
    <?php  } ?>
</table>


<table class="table bg-light-alpha">
  <?php if(!empty($eventArray)) { ?>
            <thead>     
               <th>Nombre</th>  
               <th>Fecha</th>           
           </thead>
           <tbody>
            <?php foreach ($eventArray as $value) { ?>
                <tr>
                    <td><?php echo $value->getName(); ?></td>
                    <td><?php echo $value->getDate(); ?></td>
      
                </tr>
            <?php } ?>

        </tbody>
    <?php  } ?>
</table>

    

   
    <!-- Footer -->
    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
            <ul class="list-inline mb-2">
              <li class="list-inline-item">
                <a href="#">About</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Contact</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Terms of Use</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="#">Privacy Policy</a>
              </li>
            </ul>
            <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2018. All Rights Reserved.</p>
          </div>
          <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
            <ul class="list-inline mb-0">
              <li class="list-inline-item mr-3">
                <a href="#">
                  <i class="fab fa-facebook fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a href="#">
                  <i class="fab fa-twitter-square fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fab fa-instagram fa-2x fa-fw"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
