<?php require HEADER; ?>

<header class="masthead text-black text-center">
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
                        <button type="submit" class="btn btn-block btn-lg btn-info">Buscar</button>
                    </div>
                </div>
            </form>
        </div> 
    </div>
</header>

<div>
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
            <?php endforeach ?>
                </tr>
            </tbody>
        <?php else: ?>
            <div class="container">
                <p>¡Vaya! Parece ser que no hay eventos disponibles en este momento. Esto significa que o hemos llegado a la quiebra o algun virus infeccioso rebelde está suelto ahí afuera, que hará que indefectiblemente lleguemos a la quiebra de igual manera. ¡Manténgase sanos! Y si quieren entradas mejor vayan a ticketek. Bye </p>
            </div>
        <?php endif ?>    
    </table>
</div>

<?php require FOOTER; ?>