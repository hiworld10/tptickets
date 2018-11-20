

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

              <table class="table bg-light-alpha">
                <?php if(!empty($eventArray)) { ?>
                  <thead>     
                     <th>Nombre</th>  
                     <th>Fecha</th> 
                     <th>etc</th>            
                  </thead>
                 <tbody>
            <?php foreach ($eventArray as $value) { ?>
                <tr>
                    <td><?php echo $value->getName(); ?></td>
                    <td><?php echo $value->getCategory()->getType(); ?></td>
                    <td><img src="<?= $value->getImage()->getPath() ?>" height="200" width="350"/></td>
                    <td>BOTON DE COMPRA</td>
      
                </tr>
            <?php } ?>

        </tbody>
    <?php } ?>
</table>




<?php include_once(VIEWS_ROOT.FOOTER); ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
