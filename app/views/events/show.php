<?php require HEADER; ?>

<header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
    <div class="row">
        <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">La forma mas facil de comprar tus tickets a un solo click!</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <form action="<?=  FRONT_ROOT ."/home/search"?>"  method="GET">
                <div class="form-row">
                    <div class="col-12 col-md-9 mb-2 mb-md-0">
                        <input type="text" name="q" class="form-control form-control-lg" placeholder="Buscar por evento o artista..." autofocus>
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
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
                                </a>
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