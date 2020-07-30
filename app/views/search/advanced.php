<?php require HEADER; ?>

<h1 class="text-center mt-2">Búsqueda Avanzada</h1>

<header class="text-white text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <form action="<?=  FRONT_ROOT ."/search"?>"  method="GET">
                    <div class="form-row">
                        <div class="col-12 col-md-9 mb-2 mb-md-0 mt-5">
                            <input type="text" name="q" class="form-control form-control-lg" placeholder="Buscar por evento" autofocus required>
                        </div>
                        <div class="col-12 col-md-3 mt-5">
                            <button type="submit" class="btn btn-block btn-lg btn-info">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="container mt-5">
    <div class="row ml-5 pl-5 pt-2">
        <div class="col-4">
            <div>Buscar por Artista</div>
            <br>
            <form action="<?=FRONT_ROOT?>/search/by-artist" method="POST">
                <select class="form-control" name="id_artist" required>
                    <?php if($data['artists']): ?> 
                        <?php foreach ($data['artists'] as $value): ?> 
                            <option value="<?= $value->getId() ?>"><?= $value->getName() ?></option> 
                        <?php endforeach ?>
                    <?php else: ?>
                        <option>NO HAY CATEGORIAS</option>
                    <?php endif ?>
                </select>
                <button class="btn btn-info mt-4" type="submit">Buscar</button>
            </form>
        </div>
        <div class="col-4">
            <div>Buscar por Categoría</div>
            <br>
            <form action="<?=FRONT_ROOT?>/search/by-category" method="POST">
                <select class="form-control" name="id_category" required>
                    <?php if($data['categories']): ?> 
                        <?php foreach ($data['categories'] as $value): ?> 
                            <option value="<?= $value->getId() ?>"><?= $value->getType() ?></option> 
                        <?php endforeach ?>
                    <?php else: ?>
                        <option>NO HAY CATEGORIAS</option>
                    <?php endif ?>
                </select>
                <button class="btn btn-info mt-4" type="submit">Buscar</button>
            </form>
        </div>
        <div class="col-4">
            <form action="<?=FRONT_ROOT?>/search/by-date" method="POST">
                <label class="mb-3" for="">Buscar por Fecha</label>
                <input type="date" class="form-control form-control-lg" name="date" required>
                <button class="btn btn-info mt-4" type="submit">Buscar</button>
            </form>
        </div>
    </div>
</div>

<?php require FOOTER ?>
