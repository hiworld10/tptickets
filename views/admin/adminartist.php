
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
    <li><a href="..." title="...">Eventos</a></li>
    <li><a href="..." title="...">Calendario</a></li>
    <li><a href="..." title="..."></a></li>
   </ul>
    </div>



    <div id="divform">

    <form name='formulario' action="<?=FRONT_ROOT?>/artist/addArtist"  method="POST">
             <div class="form-row">
                  <div class="col-12 col-md-9 mb-2 mb-md-0">
                    <input type="text" name="artist" class="form-control form-control-lg" placeholder="Ingrese nombre del artista...">
                  </div>
                  <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                  </div>
                </div>
    </form>

  <div id="table">
    <table class="table bg-light-alpha">

          <?php if(!empty($artistArray)) { ?>
              <thead>     
                 <th>Id</th>  
                 <th>Nombre</th>            
             </thead>
             <tbody>
              <?php foreach ($artistArray as $value) { ?>
                  <tr>
                     <td><?= $value->getId(); ?></td>
                      <td><?= $value->getName(); ?></td>
                      <td>
                        <form action="<?=FRONT_ROOT?>/artist/deleteArtist" method="POST">
                        <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
                        </form>
                      <td><button id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Editar</button></td>
        
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
