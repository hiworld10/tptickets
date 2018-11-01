<!DOCTYPE html>
<!-- NO TERMINADO SOLO COPIADO Y PEGADO OJO -->


  <html lang="en" class="__full-height-perc">

    <?php include_once(VIEWS_ROOT.HEADER); ?>

    <body class="__full-height-perc">

       <?php include_once(VIEWS_ROOT.NAVBAR); ?>


 

  <div id="container" class="__full-height-perc">
      <?php include_once(VIEWS_ROOT.MENUADMIN); ?>



    <div id="divform" class="__full-height-perc">

      <?php if(isset($event)){ ?>


        <form name='formulario' action="<?=FRONT_ROOT?>/event/updateEvent"  method="POST">
             <div class="form-row">
                  <div class="col-md-1 mb-2 mb-md-0 form-row">
                    <label>Id</label>
                    <input type="text" name="id" class="form-control form-control-lg" value="<?= $event->getId(); ?>" readonly>
                  </div>
                  <div class="col-md-5 mb-2 mb-md-0 form-row">
                    <label>Nombre</label>
                    <input type="text" name="event" class="form-control form-control-lg" value="<?= $event->getName(); ?>" required>
                  </div>
                  <div class="col-md-5 mb-2 mb-md-0 form-row">
                    <label>Categoria</label>
                         <select class="form-control" name="category" required>
                                        <?php if($categoryArray){ 
                                             foreach ($categoryArray as $key => $value) { 
                                         ?>
                                        <option value="<?= $value; ?>"><?= $value->getType(); ?></option> 
                                        <?php }
                                         }else{ ?>
                                        <option >NO HAY CATEGORIAS</option>
                                   <?php } ?>
                          </select>
                  </div>
                  <div class="col-12 col-md-2 form-row">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
                  </div>
                </div>
    </form>

    <?php   }else{  ?>

    <form name='formulario' action="<?=FRONT_ROOT?>/event/addEvent"  method="POST">
             <div class="form-row p-2">
                  <div class="form-group col-12 col-md-9 mb-2 mb-md-0">
                    <input type="text"  class="form-control form-control-lg" name="name" placeholder="Ingrese nombre del evento..." required>
                  </div>
                  <div class="col-lg-4 form-group">
                        
                                   <label for="">Categoria</label>
                                   <select class="form-control" name="category" required>
                                        <?php if($categoryArray){ 
                                             foreach ($categoryArray as $key => $value) { 
                                         ?>
                                        <option value="<?= $value->getId(); ?>"><?= $value->getType(); ?></option> 
                                        <?php }
                                         }else{ ?>
                                        <option >NO HAY CATEGORIAS</option>
                                   <?php } ?>
                                   </select>
                        
                      </div>
                  <div class="col-11 col-md-3 mt-4">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                  </div>
           </div>
   </form>

  <?php } ?>

  <div id="table">
    <table class="table bg-light-alpha">

          <?php if(!empty($eventArray)) { ?>
              <thead>     
                 <th>Id</th>  
                 <th>Nombre</th>     
                 <th>Categoria</th>          
             </thead>
             <tbody>
              <?php foreach ($eventArray as $value) { ?>
                  <tr>
                     <td><?= $value->getId(); ?></td>
                      <td><?= $value->getName(); ?></td>
                       <td><?= $value->getCategory()->getId(); ?></td>

                      <td>
                        <form action="<?=FRONT_ROOT?>/event/deleteEvent" method="POST">
                        <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
                        </form>
                      </td>
                      <td>
                        <form action="<?=FRONT_ROOT?>/event/getEvent" method="POST">
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
