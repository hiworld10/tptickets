<?php require HEADER; ?>

<header class="text-white text-center">
    <?php if(!isset($data['calendars'])): ?>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form action="<?=  FRONT_ROOT ."/search"?>"  method="GET">
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0 mt-5">
                                <input type="text" name="q" class="form-control form-control-lg" placeholder="Buscar por nombre de evento... " autofocus required>
                            </div>
                            <div class="col-12 col-md-3 mt-5">
                                <button type="submit" class="btn btn-block btn-lg btn-info">Buscar</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-row pt-1">
                        <a href="<?= FRONT_ROOT ?>/search/advanced">Búsqueda avanzada</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</header>

<div class="__full-height-perc" >
    <table class="table bg-light-alpha text-center mt-5">
    <?php if(!empty($data['events'])): ?>
        <tbody>
        <?php foreach ($data['events'] as $value): ?>
            <tr>
                <td><img src="<?= $value->getImage()->getPath() ?>" height="200" width="350"/></td>
                    <td>
                        <div class="mt-5">
                            <a href="<?php echo FRONT_ROOT . "/events/show/" . $value->getId() . "/" . \app\utils\StringUtils::lowercaseAndUnderscores($value->getName()) ?>">    
                                <input type="hidden" name="id_calendar" value="<?=$value->getId();  ?>">
                                <big><big><?= $value->getName(); ?></big></big><br>
                            </a>
                        </div>
                    </td>
                </tr>
        <?php endforeach ?>
        </tbody>
    <?php else: ?>
        <br>
        <p class="text-center">No se encontraron resultados. Prueba con una búsqueda diferente.</p>
    <?php endif ?>
    </table>
</div>

<?php require FOOTER ?>
