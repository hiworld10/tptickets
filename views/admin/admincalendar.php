<!DOCTYPE html>
<!-- NO TERMINADO SOLO COPIADO Y PEGADO OJO -->


<html lang="en" class="__full-height-perc">

<?php include_once(VIEWS_ROOT.HEADER); ?>

<body class="__full-height-perc">

 <?php include_once(VIEWS_ROOT.NAVBAR); ?>


 

 <div id="container" class="__full-height-perc">
  <?php include_once(VIEWS_ROOT.MENUADMIN); ?>



  <div id="divform" class="__full-height-perc">

    <?php if(isset($calendar)){ ?>


      <form name='formulario' action="<?=FRONT_ROOT?>/calendar/updateCalendar"  method="POST">
       <div class="form-row p-2">
        <div class="form-group col-12 col-md-2 mb-2 mb-md-0">
          <label>Id</label>
          <input type="text" name="id" class="form-control form-control-lg" value="<?= $calendar->getId(); ?>" readonly>
        </div>
        <div class="col-md-5 mb-2 mb-md-0 form-row">
          <label>Fecha</label>
          <input type="date" name="date" class="form-control form-control-lg" value="<?= $calendar->getDate(); ?>" required>
        </div>
          <div class="col-lg-4 form-group">

     <label for="">Evento</label>
     <select class="form-control" name="category" required>
      <?php if(isset($eventArray)){ 
       foreach ($eventArray as $key => $value) { 
         ?>
         <!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
         <option value="<?= $value->getId(); ?>"><?= $value->getName(); ?></option> 
       <?php }
     }else{ ?>
      <option >NO HAY EVENTOS</option>
    <?php } ?>
  </select>

</div>

   <div class="form-group">


        <?php if(isset($artistArray)){

        foreach ($artistArray as $key => $value) {  ?>
           <label >
               <input  type="checkbox" name="artistArray" value="<?php $value->getName(); ?>" >
                  <span><?= $value->getName()?></span>
            </label>
        <?php } }else{ ?>
          <span>NO HAY ARTISTAS CARGADOS</span>
        <?php } ?>

     </div>

      

 <div class="col-lg-4 form-group">

     <label for="">Lugar</label>
     <select class="form-control" name="placeEvent" required>
      <?php if(isset($placeEventArray)){ 
       foreach ($placeEventArray as $key => $value) { 
         ?>
         <!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
         <option value="<?= $value->getId(); ?>"><?= $value->getDescription(); ?></option> 
       <?php }
     }else{ ?>
      <option >NO HAY LUGARES</option>
    <?php } ?>
  </select>

</div>
 <div class="col-lg-4 form-group">

     <label for="">Tipo Plaza</label>
     <select class="form-control" name="seatType" required>
      <?php if(isset($seatTypeArray)){ 
       foreach ($seatTypeArray as $key => $value) { 
         ?>
         <!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
         <option value="<?= $value->getId(); ?>"><?= $value->getType(); ?></option> 
       <?php }
     }else{ ?>
      <option >NO HAY TIPOS</option>
    <?php } ?>
  </select>

</div>

      <div class="col-12 col-md-2 form-row">
        <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
      </div>
    </div>
  </form>

<?php   }else{  ?>


  <form name='formulario' action="<?=FRONT_ROOT?>/calendar/addCalendar"  method="POST">
   <div class="form">
    <div class="col-12 col-md-9 mb-2 mb-md-3">
      <label for="">Fecha</label>
      <input type="date"   class="form-control form-control-lg" name="date" placeholder="Ingrese fecha..." required>
    </div>
     <div class="col-12 col-md-9 mb-2 mb-md-3">

     <label for="">Evento</label>
     <select class="form-control" name="event" required>
      <?php if(isset($eventArray)){ 
       foreach ($eventArray as $key => $value) { 
         ?>
         <!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
         <option value="<?= $value->getId(); ?>"><?= $value->getName(); ?></option> 
       <?php }
     }else{ ?>
      <option >NO HAY EVENTOS</option>
    <?php } ?>
  </select>

</div>

   <div class="col-12 col-md-9 mb-2 mb-md-3">


        <?php if(isset($artistArray)){

        foreach ($artistArray as $key => $value) {  ?>
           <label >
               <input  type="checkbox" name="artistArray[]" value="<?= $value->getId(); ?>" >
                  <span><?= $value->getName()?></span>
            </label>
        <?php } }else{ ?>
          <span>NO HAY ARTISTAS CARGADOS</span>
        <?php } ?>

     </div>

      

 <div class="col-12 col-md-9 mb-2 mb-md-3">

     <label for="">Lugar</label>
     <select class="form-control" name="placeEvent" required>
      <?php if(isset($placeEventArray)){ 
       foreach ($placeEventArray as $key => $value) { 
         ?>
         <!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
         <option value="<?= $value->getId(); ?>"><?= $value->getDescription(); ?></option> 
       <?php }
     }else{ ?>
      <option >NO HAY LUGARES</option>
    <?php } ?>
  </select>

</div>

 <div class="col-12 col-md-9 mb-2 mb-md-3">

     <label for="">Tipo Plaza</label>
     <select class="form-control" name="seatType" required>
      <?php if(isset($seatTypeArray)){ 
       foreach ($seatTypeArray as $key => $value) { 
         ?>
         <!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
         <option value="<?= $value->getId(); ?>"><?= $value->getType(); ?></option> 
       <?php }
     }else{ ?>
      <option >NO HAY TIPOS</option>
    <?php } ?>
  </select>

</div>
<?php if($eventArray && $artistArray && $placeEventArray && $seatTypeArray) { ?>
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

    <?php if(!empty($calendarArray)) { ?>
      <thead>     
       <th>Id</th>  
       <th>Fecha</th>     
       <th>EventoId</th>
       <th>Artistas</th>   
       <th>LugarId</th>
       <th>TipoPlazaId</th>         
     </thead>
     <tbody>
      <?php foreach ($calendarArray as $value) { ?>
        <tr>
         <td><?= $value->getId(); ?></td>
         <td><?= $value->getDate(); ?></td>
         <td><?= $value->getEvent()->getId(); ?></td>
         <td><?= $value->getArtistArray(); ?></td>
         <td><?= $value->getPlaceEvent()->getId(); ?></td>
         <td><?= $value->getSeatType()->getId(); ?></td>


         <td>
          <form action="<?=FRONT_ROOT?>/calendar/deleteCalendar" method="POST">
            <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
          </form>
        </td>
        <td>
          <form action="<?=FRONT_ROOT?>/calendar/getCalendar" method="POST">
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
