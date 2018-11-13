

<!DOCTYPE html>
<html lang="en">

 <?php include_once(VIEWS_ROOT.HEADER); ?>

  <body>



<?php include_once(VIEWS_ROOT.NAVBAR); ?>



    <!-- Masthead -->
    <header class="masthead text-white text-center">

      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">La forma mas facil de comprar tus tickets a un solo click!</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">

            <form action="<?php  FRONT_ROOT ?>/home/search"  method="POST">
              <div class="form-row">
                <div class="col-12 col-md-9 mb-2 mb-md-0">
                  <input type="text" name="artist" class="form-control form-control-lg" placeholder="Por evento, lugar o artista...">
                </div>
                <div class="col-12 col-md-3">
                  <button type="submit" class="btn btn-block btn-lg btn-primary">Buscar</button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>

    <!-- Masthead -->
    <header class="masthead text-white text-center">

      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
              <table class="table bg-light-alpha">
                <?php if(isset($eventArray)) { ?>
                  <thead>     
                     <th>Nombre</th>  
                     <th>Fecha</th>        

                  </thead>
                 <tbody>
            <?php foreach ($eventArray as $value) { ?>
                <tr>
                    <td><?php echo $value->getName(); ?></td>
                    <td><?php echo $value->getDate(); ?></td>
                    <td>BOTON SEARCH</td><?php // oara mostrar las fechas donde aparece este evento ?>
      
                </tr>
            <?php } ?>

        </tbody>
    <?php  } ?>
</table>





<?php include_once(VIEWS_ROOT.FOOTER); ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
