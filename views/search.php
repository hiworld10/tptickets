
<!DOCTYPE html>
<html lang="en">

 <?php include_once(HEADER); ?>

  <body>


<?php include_once(NAVBAR); ?>




<div class="__full-height-perc" >
  <table class="table bg-light-alpha text-center mt-5">

    <?php if(!empty($eventArray)) { ?>
   
     <tbody>
      <?php foreach ($eventArray as $value) { ?>
        <tr>
        
         <td><img src="<?= $value->getImage()->getPath() ?>" height="200" width="350"/></td>
        <td>
          <div class="mt-5">
             <big><big><?= $value->getName(); ?></big></big>
          </div>
        </td>
      
        <td>
          <div class="mt-5">
          <form action="<?=FRONT_ROOT?>/purchaseline/addPurchaseLine" method="POST">
            <button name="buy" value="<?= $value->getId();  ?>" id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Comprar</button>
          </form>
        </div>
        </td>
      </tr>
    <?php } ?>

  </tbody>
<?php  } ?>
</table>

</div>

 </body>



<?php include_once(FOOTER); ?>

    <!-- Bootstrap core JavaScript -->
    <script src="/tptickets/vendor/jquery/jquery.min.js"></script>
    <script src="/tptickets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 

</html>
