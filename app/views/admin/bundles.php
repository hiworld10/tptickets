<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>

    <div id="divform" class="__full-height-perc">
    
        <?php if(isset($data['bundle'])): ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/admin/bundles/update"  enctype="multipart/form-data" method="POST">
                <div class="form-row p-2 mt-4">
                    <input type="hidden" name="id_bundle" value="<?= $data['bundle']->getId() ?>">
                    <div class="col-lg-8 form-group mt-4">
                        <label for="">Paquete</label>
                        <input type="text"  class="form-control form-control-lg" name="description" value="<?= $data['bundle']->getDescription() ?>"placeholder="Ingrese nombre del paquete..." required>
                    </div>
                    <div class="col-lg-2 form-group mt-4">
                        <label for="">Descuento (%)</label>
                        <input type="number" min="5" max="50" class="form-control form-control-lg" name="discount" value="<?= $data['bundle']->getDiscount() ?>" required>
                    </div>
                    <div class="col-11 col-md-3 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-info">Agregar</button>
                    </div>
                </div>
            </form>

        <?php else: ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/admin/bundles/add"  enctype="multipart/form-data" method="POST">
                <div class="form-row p-2 mt-4">
                    <div class="col-lg-8 form-group mt-4">
                        <label for="">Paquete</label>
                        <input type="text"  class="form-control form-control-lg" name="description" placeholder="Ingrese nombre del paquete..." required>
                    </div>
                    <div class="col-lg-2 form-group mt-4">
                        <label for="">Descuento (%)</label>
                        <input type="number" min="5" max=30 class="form-control form-control-lg" name="discount" required>
                    </div>
                    <div class="col-11 col-md-3 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-info">Agregar</button>
                    </div>
                </div>
            </form>

        <?php endif ?>
        
        <!-- Lista de paquetes -->
        <div id="table">
            <table class="table bg-light-alpha">

                <?php if (!empty($data['bundles'])): ?>
                    <thead>     
                        <th>Id</th>  
                        <th>Descripción</th>        
                        <th>Descuento</th>        
                    </thead>
                    <tbody>
                        <?php foreach ($data['bundles'] as $value): ?>
                            <tr>
                                <td><?= $value->getId() ?></td>
                                <td><?= $value->getDescription() ?></td>
                                <td><?= $value->getDiscount() ?></td>
                                <td>
                                    <form action="<?=FRONT_ROOT?>/admin/bundles/delete" method="POST">
                                        <button name="iddelete" value="<?= $value->getId() ?>" id="boton1" type="submit"class="btn btn-block btn-lg btn-info btn-sm">Eliminar</button>
                                    </form>
                                </td>
                                <td>          
                                    <a href="<?=FRONT_ROOT?>/admin/bundles/edit/<?= $value->getId() ?>" class="btn btn-block btn-lg btn-info btn-sm">Editar
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