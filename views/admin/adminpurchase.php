<!DOCTYPE html>
<!-- NO TESTEADO -->


<html lang="en" class="__full-height-perc">

<?php include_once(VIEWS_ROOT.HEADER); ?>

<body class="__full-height-perc">

 <?php include_once(VIEWS_ROOT.NAVBAR); ?>


 

 <div id="container" class="__full-height-perc">
  <?php include_once(VIEWS_ROOT.MENUADMIN); ?>



  <div id="divform" class="__full-height-perc">

    <?php if(isset($purchase)){ ?>


      <form name='formulario' action="<?=FRONT_ROOT?>/purchase/updatePurchase"  method="POST">
       <div class="form-row">
        <div class="col-md-1 mb-2 mb-md-0 form-row">
          <label>Id</label>
          <input type="text" name="id" class="form-control form-control-lg" value="<?= $purchase->getId(); ?>" readonly>
        </div>
        <div class="col-md-5 mb-2 mb-md-0 form-row">
          <label>Fecha</label>
          <input type="date" name="date" class="form-control form-control-lg" value="<?= $purchase->getDate(); ?>" required>
        </div>
        <div class="col-md-5 mb-2 mb-md-0 form-row">
          <label>LineaCompra</label>
              <input type="" name="purchaseline" class="form-control form-control-lg" value="<?= $purchase->getPurchaseLine(); ?>" required>
      </div>
      <div class="col-12 col-md-2 form-row">
        <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
      </div>
    </div>
  </form>

<?php   }else{  ?>

  <form name='formulario' action="<?=FRONT_ROOT?>/purchase/addPurchaseLine"  method="POST">
   <div class="form-row p-2">
    <div class="form-group col-12 col-md-9 mb-2 mb-md-0">
      <input type="date"   class="form-control form-control-lg" name="date" placeholder="Ingrese fecha..." required>
    </div>
    <div class="col-lg-4 form-group">
      
     <label for="">LineaCompra</label>
     <input type=""   class="form-control form-control-lg" name="purchaseline" placeholder="Ingrese lineas de compra..." required>
     
    </div>

  <div class="col-11 col-md-3 mt-4">
    <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
  </div>



</div>
</form>


<?php } ?>

<div id="table" class="__full-height-perc">
  <table class="table bg-light-alpha">

    <?php if(!empty($purchaseArray)) { ?>
      <thead>     
       <th>Id</th>  
       <th>Fecha</th>     
       <th>LineaCompra</th>          
     </thead>
     <tbody>
      <?php foreach ($purchaseArray as $value) { ?>
        <tr>
         <td><?= $value->getId(); ?></td>
         <td><?= $value->getDate(); ?></td>
         <td><?= $value->getPurchaseLine(); ?></td><!-- SI ES UN OBJETO HAY Q AGREGAR (getId()) -->

         <td>
          <form action="<?=FRONT_ROOT?>/purchase/deletePurchase" method="POST">
            <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
          </form>
        </td>
        <td>
          <form action="<?=FRONT_ROOT?>/purchase/getPurchase" method="POST">
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
