
  <!DOCTYPE html>


  <html lang="en" class="__full-height-perc">

    <?php require(VIEWS_ROOT.HEADER); ?>

    <body class="__full-height-perc">

       <?php require(VIEWS_ROOT.NAVBAR); ?>


 

  <div id="container" class="__full-height-perc">
      <?php require(VIEWS_ROOT.MENUADMIN); ?>



    <div id="divform" class="__full-height-perc">

      <?php if(isset($category)){ ?>


        <form name='formulario' action="<?=FRONT_ROOT?>/category/updateCategory"  method="POST">
             <div class="form-row">
                  <div class="col-md-1 mb-2 mb-md-0 form-row">
                    <label>Id</label>
                    <input type="text" name="id" class="form-control form-control-lg" value="<?= $category->getId(); ?>" readonly>
                  </div>
                  <div class="col-md-7 mb-2 mb-md-0 form-row">
                    <label>Nombre</label>
                    <input type="text" name="category" class="form-control form-control-lg" value="<?= $category->getType(); ?>" required>
                  </div>
                  <div class="col-12 col-md-2 mt-4">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
                  </div>
                </div>
    </form>

    <?php   }else{   ?>

    <form name='formulario' action="<?=FRONT_ROOT?>/category/addCategory"  method="POST">
             <div class="form-row">
                  <div class="col-12 col-md-9 mb-2 mb-md-0">
                    <input type="text" name="category" class="form-control form-control-lg" placeholder="Ingrese nombre de la categoria..." required>
                  </div>
                  <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                  </div>
                </div>
    </form>

  <?php } ?>

  <div id="table">
    <table class="table bg-light-alpha">

          <?php if(!empty($categoryArray)) { ?>
              <thead>     
                 <th>Id</th>  
                 <th>Nombre</th>            
             </thead>
             <tbody>
              <?php foreach ($categoryArray as $value) { ?>
                  <tr>
                     <td><?= $value->getId(); ?></td>
                      <td><?= $value->getType(); ?></td>
                      <td>
                        <form action="<?=FRONT_ROOT?>/category/deleteCategory" method="POST">
                        <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
                        </form>
                      </td>
                      <td>
                        <form action="<?=FRONT_ROOT?>/category/getCategory" method="POST">
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
