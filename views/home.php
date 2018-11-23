
<!DOCTYPE html>
<html lang="en">

 <?php include_once(HEADER); ?>

  <body>
<style type="text/css">
  main{
    background-image: url("<?= IMG_FRONT_ROOT?>/fondologin.jpg");
    height: auto;
    width: auto;
  }
  h2{
    color: white;
  }
</style>


<?php include_once(NAVBAR); ?>



    <!-- Masthead -->
    <header class="masthead text-white text-center">
      

      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">La forma mas facil de comprar tus tickets a un solo click!</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">

            <form action="<?=  FRONT_ROOT ."/home/search"?>"  method="POST">
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

</header>
<div  >
  <a href="<?= FRONT_ROOT ?>/home/search/ " >
  <table class="table bg-light-alpha text-center mt-5">

    <?php if(!empty($eventArray)) { ?>
   
     <tbody>
      <?php foreach ($eventArray as $value) { ?>
        <a href="<?= FRONT_ROOT ?>/home/search/ " >
        <tr>
        
         <td><img src="<?= $value->getImage()->getPath() ?>" height="200" width="350"/></td>
        <td>
          <div class="mt-5">
             <big><big><?= $value->getName(); ?></big></big>
          </div>
        </td>
      </tr>
      </a>
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
