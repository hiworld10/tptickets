<?php require HEADER; ?>

<header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
    <div class="row">
        <div class="col-md-10 col-lg-8 col-xl-7 pt-5 mx-auto">
            <form action="<?=  FRONT_ROOT ."/search"?>"  method="GET">
                <div class="form-row">
                    <div class="col-12 col-md-9 mb-2 mb-md-0">
                        <input type="text" name="q" class="form-control form-control-lg" placeholder="Buscar por nombre de evento..." autofocus required>
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-block btn-lg btn-info">Buscar</button>
                    </div>
                </div>
            </form>
            <div class="form-row pt-1">
                <a href="<?= FRONT_ROOT ?>/search/advanced">Búsqueda avanzada</a>
            </div>
        </div> 
    </div>
</header>

<div>
    <table class="table bg-light-alpha text-center mt-5">
        <tbody>
            <?php if(!empty($data['calendars'])): ?>
                <?php foreach ($data['calendars'] as $value): ?>
                    <tr>       
                        <td><img src="<?= $value->getEvent()->getImage()->getPath() ?>" height="200" width="350"/></td>
                        <td>
                            <div class="mt-5">
                                <a href="<?php echo FRONT_ROOT . "/calendars/list-seats/" . $value->getId() ?>">    
                                    <input type="hidden" name="id_calendar" value="<?=$value->getId();  ?>">
                                    <big><big><?= $value->getEvent()->getName(); ?></big></big>
                                    <br>
                                    <big><?= $value->getDate(); ?></big>
                                    <br>                                
                                </a>
                                <?php if ($value->isSoldOut() == true): ?>
                                    <big>ENTRADAS AGOTADAS</big>
                                <?php endif ?>                                    
                            </div>
                        </td>
                    </tr>    
                <?php endforeach ?>  
            <?php else: ?>
                <p>No hay fechas disponibles para este evento</p>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?php require FOOTER; ?>