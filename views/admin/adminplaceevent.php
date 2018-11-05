
  <!DOCTYPE html>


  <html lang="en" class="__full-height-perc">

    <?php include_once(VIEWS_ROOT.HEADER); ?>

    <body class="__full-height-perc">

       <?php include_once(VIEWS_ROOT.NAVBAR); ?>


 

  <div id="container" class="__full-height-perc">
      <?php include_once(VIEWS_ROOT.MENUADMIN); ?>



    <div id="divform" class="__full-height-perc">

      <?php if(isset($placeevent)){ ?>


        <form name='formulario' action="<?=FRONT_ROOT?>/placeevent/updatePlaceEvent"  method="POST">
             <div class="form-row">
                  <div class="col-md-1 mb-2 mb-md-0 form-row">
                    <label>Id</label>
                    <input type="text" name="id" class="form-control form-control-lg" value="<?= $placeevent->getId(); ?>" readonly>
                  </div>
                  <div class="col-md-7 mb-2 mb-md-0 form-row">
                    <label>Capacidad</label>
                    <input type="text" name="capacity" class="form-control form-control-lg" value="<?= $placeevent->getCapacity(); ?>" required>
                  </div>
                  <div class="col-md-7 mb-2 mb-md-0 form-row">
                    <label>Descripcion</label>
                    <input type="text" name="description" class="form-control form-control-lg" value="<?= $placeevent->getDescription(); ?>" required>
                  </div>
                  <div class="col-12 col-md-2 mt-4">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
                  </div>
                </div>
    </form>

    <?php   }else{   ?>

    <form name='formulario' action="<?=FRONT_ROOT?>/placeevent/addPlaceEvent  method="POST">
             <div class="form-row">
                  <div class="col-12 col-md-9 mb-2 mb-md-0">
                    <input type="text" name="capacity" class="form-control form-control-lg" placeholder="Ingrese la capacidad del evento..." required>
                  </div>
                  <div class="col-12 col-md-9 mb-2 mb-md-0">
                    <input type="text" name="description" class="form-control form-control-lg" placeholder="Ingrese descripcion del evento..." required>
                  </div>
                  <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                  </div>
                </div>
    </form>

  <?php } ?>

  <div id="table">
    <table class="table bg-light-alpha">

          <?php if(!empty($placeEventArray)) { ?>
              <thead>     
                 <th>Id</th>  
                 <th>Capacidad</th> 
                 <th>Descripcion</th>              
             </thead>
             <tbody>
              <?php foreach ($placeEventArray as $value) { ?>
                  <tr>
                     <td><?= $value->getId(); ?></td>
                      <td><?= $value->getCapacity(); ?></td>
                      <td><?= $value->getDescription(); ?></td>
                      <td>
                        <form action="<?=FRONT_ROOT?>/placeevent/deletePlaceEvent" method="POST">
                        <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
                        </form>
                      </td>
                      <td>
                        <form action="<?=FRONT_ROOT?>/placeevent/getPlaceEvent" method="POST">
                        <button name="update" value="<?= $value->getId(); ?>" id="boton1" type="submit" class="btn btn-block btn-lg btn-primary btn-sm">Editar</button></td>
                        </form>
                      </td>
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
