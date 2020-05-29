<?php require HEADER; ?>

<div id="container" class="__full-height-perc">
    <?php require(ADMIN_NAVBAR); ?>
    <div id="divform"  class="__full-height-perc">
        <div id=edit>
            <!-- Este div aparecerá si un artista debe ser modificado -->
            <?php if(isset($data['artist'])): ?>

                <form name='formulario' action="<?=FRONT_ROOT?>/artists/update/<?=$data['artist']->getId()?>" method="POST">
                    <div class="form-row">
                        <div class="col-md-1 mb-2 mb-md-0 form-row">
                            <label>Id</label>
                            <input type="text" name="id" class="form-control form-control-lg" value="<?= $data['artist']->getId(); ?>" readonly>
                        </div>
                        <div class="col-md-7 mb-2 mb-md-0 form-row">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control form-control-lg" value="<?= $data['artist']->getName(); ?>" required>
                        </div>
                        <div class="col-12 col-md-2 mt-4">
                            <button type="submit"  class="btn btn-lg btn-primary">Aceptar</button>
                        </div>
                    </div>
                </form>

            <?php else : ?>
                <!-- De no ser así, se habilitará el formulario para agregar artistas  -->
                <form name='formulario' action="<?=FRONT_ROOT?>/artists/add"  method="POST">
                    <div class="form-row">
                        <div class="col-12 col-md-9 mb-2 mb-md-0">
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Ingrese nombre del artista..." required>
                        </div>
                        <div class="col-12 col-md-3">
                            <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <!-- Lista de artistas -->
        <div id="table">
            <table class="table bg-light-alpha">

                <?php if (isset($data['artist_list'])): ?>
                    <?php echo "Estoy aca"; ?>
                    <thead>     
                        <th>Id</th>  
                        <th>Nombre</th>            
                    </thead>
                    <tbody>
                        <?php foreach ($data['artist_list'] as $value): ?>
                            <tr>
                                <td><?= $value->getId(); ?></td>
                                <td><?= $value->getName(); ?></td>
                                <td>
                                    <form action="<?=FRONT_ROOT?>/artists/delete" method="POST">
                                        <button name="iddelete" value="<?= $value->getId();  ?>" id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
                                    </form>
                                </td>
                                <td>          
                                    <a href="<?=FRONT_ROOT?>/artists/edit/<?=$value->getId()?>" class="btn btn-block btn-lg btn-primary btn-sm">Editar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<?php require FOOTER; ?>