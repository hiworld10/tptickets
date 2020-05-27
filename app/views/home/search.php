<?php require HEADER; ?>

<header class="text-white text-center">
    <?php if(!isset($data['calendars'])){ ?>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form action="<?=  FRONT_ROOT ."/home/search"?>"  method="POST">
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0 mt-5">
                                <input type="text" name="artist" class="form-control form-control-lg" placeholder="Encontraste lo que buscabas? ">
                            </div>
                            <div class="col-12 col-md-3 mt-5">
                                <button type="submit" class="btn btn-block btn-lg btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php  } ?>
</header>

<div class="__full-height-perc" >
    <table class="table bg-light-alpha text-center mt-5">
    <?php if(!empty($data['calendars'])) { ?>
        <tbody>
        <?php foreach ($data['calendars'] as $value) { ?>
            <tr>
                <td><img src="<?= $value->getEvent()->getImage()->getPath() ?>" height="200" width="350"/></td>
                <td>
                    <div class="mt-5">
                        <big><big><?= $value->getEvent()->getName(); ?></big></big>
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

<?php require(FOOTER); ?>
