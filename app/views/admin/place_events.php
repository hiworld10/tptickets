<?php require HEADER; ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform" class="__full-height-perc">

        <!-- <?php if (isset($placeEvent)): ?>
            <form name='formulario' action="<?=FRONT_ROOT?>/placeevent/updatePlaceEvent"  method="POST">
                <div class="form-row">
                    <div class="col-md-1 mb-2 mb-md-0 form-row">
                        <label>Id</label>
                        <input type="text" name="id" class="form-control form-control-lg" value="<?= $placeEvent->getId(); ?>" readonly>
                    </div>
                    <div class="col-md-2 mb-2 mb-md-0 form-row">
                        <label>Capacidad</label>
                        <input type="text" name="capacity" class="form-control form-control-lg" value="<?= $placeEvent->getCapacity(); ?>" required>
                    </div>
                    <div class="col-md-5 mb-2 mb-md-0 form-row">
                        <label>Descripcion</label>
                        <input type="text" name="description" class="form-control form-control-lg" value="<?= $placeEvent->getDescription(); ?>" required>
                    </div>
                    <div class="col-12 col-md-2 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <form name='formulario' action="<?=FRONT_ROOT?>/placeevent/addPlaceEventAndView"  method="POST">
                <div class="form-row">
                    <div class="col-12 col-md-9 mb-2 mb-md-0">
                        <input type="text" name="capacity" class="form-control form-control-lg" placeholder="Ingrese la capacidad del evento..." required>
                    </div>
                    <div class="col-12 col-md-9 mb-2 mb-md-0">
                        <input type="text" name="description" class="form-control form-control-lg" placeholder="Ingrese descripcion del evento..." required>
                    </div>
                        <div class="col-12 col-md-3">
                            <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                        </div>
                    </div>
            </form>
        <?php endif ?> -->

        <div id="table">
            <table class="table bg-light-alpha">

                <?php if(!empty($data['place_events'])) { ?>
                    <thead>     
                        <th>Id</th>  
                        <th>Capacidad</th> 
                        <th>Descripcion</th> 
                        <th>Calendar Id</th>             
                    </thead>
                    <tbody>
                        <?php foreach ($data['place_events'] as $value) { ?>
                            <tr>
                                <td><?= $value->getId(); ?></td>
                                <td><?= $value->getCapacity(); ?></td>
                                <td><?= $value->getDescription(); ?></td>
                                <td><?= $value->getCalendarId(); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<?php require FOOTER ?>