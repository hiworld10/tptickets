<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require(ADMIN_NAVBAR); ?>

    <div id="divform" class="__full-height-perc">

        <?php if(isset($data['category'])): ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/categories/update"  method="POST">
                <div class="form-row">
                    <div class="col-md-1 mb-2 mb-md-0 form-row">
                        <label>Id</label>
                        <input type="text" name="id" class="form-control form-control-lg" value="<?= $data['category']->getId(); ?>" readonly>
                    </div>
                    <div class="col-md-7 mb-2 mb-md-0 form-row">
                        <label>Nombre</label>
                        <input type="text" name="type" class="form-control form-control-lg" value="<?= $data['category']->getType(); ?>" required>
                    </div>
                    <div class="col-12 col-md-2 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>

        <?php else: ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/categories/add"  method="POST">
                <div class="form-row">
                    <div class="col-12 col-md-9 mb-2 mb-md-0">
                        <input type="text" name="type" class="form-control form-control-lg" placeholder="Ingrese nombre de la categoria..." required>
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                    </div>
                </div>
            </form>

        <?php endif ?>

        <div id="table">
            <table class="table bg-light-alpha">

                <?php if (!empty($data['categories'])): ?>
                    <thead>     
                        <th>Id</th>  
                        <th>Nombre</th>            
                    </thead>
                    <tbody>
                        <?php foreach ($data['categories'] as $value): ?>
                            <tr>
                                <td><?= $value->getId(); ?></td>
                                <td><?= $value->getType(); ?></td>
                                <td>
                                    <form action="<?=FRONT_ROOT?>/categories/delete" method="POST">
                                        <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit" class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="<?=FRONT_ROOT?>/categories/edit/<?=$value->getId()?>" class="btn btn-block btn-lg btn-primary btn-sm">Editar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                <?php endif ?>
            </table>
        </div>    
    </div>
</div>

<?php require FOOTER ?>