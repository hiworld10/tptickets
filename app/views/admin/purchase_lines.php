<?php require HEADER; ?>

 <div id="container" class="__full-height-perc">
  <?php require ADMIN_NAVBAR ?>



  <div id="divform" class="__full-height-perc">

    <?php if(isset($purcharseline)){ ?>


      <form name='formulario' action="<?=FRONT_ROOT?>/admin/purchase-lines/updatePurcharseLine"  method="POST">
       <div class="form-row">
        <div class="col-md-1 mb-2 mb-md-0 form-row">
          <label>Id</label>
          <input type="text" name="id" class="form-control form-control-lg" value="<?= $purcharseline->getId(); ?>" readonly>
        </div>
        <div class="col-md-5 mb-2 mb-md-0 form-row">
          <label>Monto</label>
          <input type="date" name="amount" class="form-control form-control-lg" value="<?= $purcharseline->getAmount(); ?>" required>
        </div>
        <div class="col-md-5 mb-2 mb-md-0 form-row">
          <label>IdTicket</label>
          <select class="form-control" name="ticket" required>
            <?php if($ticketArray){ 
             foreach ($ticketArray as $key => $value) { 
               ?>
               <option value="<?= $value->getId(); ?>"><?= $value->getId(); ?></option> 
             <?php }
           }else{ ?>
            <option >NO HAY TICKETS</option>
          <?php } ?>
        </select>
      </div>
        <div class="col-md-5 mb-2 mb-md-0 form-row">
          <label>IdCompra</label>
          <select class="form-control" name="purchase" required>
            <?php if($purchaseArray){ 
             foreach ($purchaseArray as $key => $value) { 
               ?>
               <option value="<?= $value->getId(); ?>"><?= $value->getId(); ?></option> 
             <?php }
           }else{ ?>
            <option >NO HAY COMPRAS</option>
          <?php } ?>
        </select>
      </div>
      <div class="col-12 col-md-2 form-row">
        <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
      </div>
    </div>
  </form>

<?php   }else{  ?>

  <form name='formulario' action="<?=FRONT_ROOT?>/admin/purchase-lines/addPurchaseLine"  method="POST">
   <div class="form-row p-2">
    <div class="form-group col-12 col-md-9 mb-2 mb-md-0">
      <input type="text"   class="form-control form-control-lg" name="amount" placeholder="Ingrese monto..." required>
    </div>
    <div class="col-lg-4 form-group">
     <label for="">Ticket</label>
     <select class="form-control" name="ticket" required>
      <?php if($ticketArray){ 
       foreach ($ticketArray as $key => $value) { 
         ?>
         <option value="<?= $value->getId(); ?>"><?= $value->getId(); ?></option> 
       <?php }
     }else{ ?>
      <option >NO HAY TICKETS</option>
    <?php } ?>
    </select>
  </div>
  <div class="col-lg-4 form-group">
     <label for="">Compra</label>
     <select class="form-control" name="event" required>
      <?php if($purchaseArray){ 
       foreach ($purchaseArray as $key => $value) { 
         ?>
         <option value="<?= $value->getId(); ?>"><?= $value->getId(); ?></option> 
       <?php }
     }else{ ?>
      <option >NO HAY COMPRAS</option>
    <?php } ?>
    </select>
  </div>
<?php if($ticketArray && $purcheseArray) { ?>
  <div class="col-11 col-md-3 mt-4">
    <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
  </div>
<?php }else{ ?>
  <div class="col-11 col-md-3 mt-4">
    <button type="submit" disabled class="btn btn-block btn-lg btn-primary">Agregar</button>
  </div>
<?php } ?>

</div>
</form>


<?php } ?>

<div id="table" class="__full-height-perc">
  <table class="table bg-light-alpha">

    <?php if(!empty($purchaseLineArray)) { ?>
      <thead>     
       <th>Id</th>  
       <th>Monto</th>     
       <th>Ticket</th>  
       <th>Compra</th>         
     </thead>
     <tbody>
      <?php foreach ($purchaseLineArray as $value) { ?>
        <tr>
         <td><?= $value->getId(); ?></td>
         <td><?= $value->getAmount(); ?></td>
         <td><?= $value->getTicket()->getId(); ?></td>
         <td><?= $value->getPurchaseId(); ?></td>

         <td>
          <form action="<?=FRONT_ROOT?>/admin/purchase-lines/deletePurchaseLine" method="POST">
            <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
          </form>
        </td>
        <td>
          <form action="<?=FRONT_ROOT?>/admin/purchase-lines/getPurchaseLine" method="POST">
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
