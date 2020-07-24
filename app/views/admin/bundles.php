<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>

    <div id="divform" class="__full-height-perc">

        <!-- Lista de paquetes -->
        <div id="table">
            <table class="table bg-light-alpha">

                <?php if (isset($data['bundles'])): ?>
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