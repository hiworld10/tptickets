<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform" class="__full-height-perc">
        <?php if (isset($data['bundles'])): ?>
            <div>
                <form name='formulario' action="<?=FRONT_ROOT?>/admin/events/set-bundle" method="POST">
                        <div class="text-center mb-4"><big><?=$data['event']->getId() . ' - ' . $data['event']->getName() ?></big></div>
                        <div class="d-flex">
                            <div class="col-9 form-group">
                                <input type="hidden" name="id_event" value="<?= $data['event']->getId() ?>">
                                <label for="">Paquete</label>
                                <select class="form-control" name="id_bundle" required>
                                    <?php if($data['bundles']): ?> 
                                        <?php foreach ($data['bundles'] as $key => $value): ?>  
                                            <option value="<?= $value->getId() ?>"
                                                <?php if($data['event']->getBundle()) : ?>
                                                    <?= $data['event']->getBundle()->getId() === $value->getId() 
                                                        ? 'selected' 
                                                        : '' 
                                                    ?>
                                                <?php endif ?>
                                                ><?= $value->getDescription() . ' (' . $value->getDiscount() . '%)' ?>
                                            </option> 
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <option >NO HAY PAQUETES</option>
                                    <?php endif ?>   
                                </select>
                            </div>
                            <div class="col-6 mt-4 form-group">
                                <button type="submit" class="btn btn-block btn-lg btn-info">Agregar</button>
                            </div>
                        </div>
                    </div>
                </form>

                <?php if ($data['event']->getBundle()): ?>
                    <form name="formulario" action="<?=FRONT_ROOT?>/admin/events/unset-bundle" method="POST">
                        <div class="col-8 form-group">
                            <input type="hidden" name="id_event" value="<?= $data['event']->getId() ?>">
                            <button type="submit" class="btn-block btn-lg btn-secondary">Remover Paquete</button>
                        </div>
                    </form>
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>
</div>

<?php require FOOTER ?>