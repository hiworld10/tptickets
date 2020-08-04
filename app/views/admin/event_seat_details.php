<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform" class="__full-height-perc">
        <div class="text-center mb-2">
            <a href="<?= FRONT_ROOT ?>/admin/calendars"><< Volver</a>    
        </div>
        <hr>
        <dl class="row offset-md-1">
            <dt class="col-sm-7">ID Calendario:</dt>
            <dd class="col-sm-5"><?= $data['calendar']->getId() ?></dd>
            <dt class="col-sm-7">Fecha:</dt>
            <dd class="col-sm-5"><?= $data['calendar']->getDate() ?></dd>
            <dt class="col-sm-7">Evento:</dt>
            <dd class="col-sm-5"><?= $data['calendar']->getEvent()->getName() ?></dd>
            <dt class="col-sm-7">Lugar:</dt>
            <dd class="col-sm-5"><?= $data['place_event']->getDescription() ?></dd>
            <dt class="col-sm-7">Capacidad máxima:</dt>
            <dd class="col-sm-5"><?= $data['place_event']->getCapacity() ?></dd>
        </dl>
        <hr>
        <table class="table bg-light-alpha offset-md-1">
            <thead>     
                <th>ID</th>  
                <th>Asiento</th>     
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Remanente</th>
            </thead>
            <tbody>
                <?php $sold_amount = 0; $total_remainder = 0; ?>
                <?php foreach ($data['event_seats'] as $value): ?>
                    <tr>
                        <td><?= $value->getId() ?></td>
                        <td><?= $value->getSeatType()->getType() ?></td>
                        <td><?= moneyFormat($value->getPrice()) ?></td>
                        <td><?= $value->getQuantity() ?></td>
                        <td><?= $value->getRemainder() ?></td>

                    </tr>
                    <?php $sold_amount += ((double)$value->getQuantity() - (double)$value->getRemainder()) ?>
                    <?php $total_remainder += (double)$value->getRemainder() ?>
                <?php endforeach ?>
            </tbody>
        </table>
        <hr>
        <dl class="row offset-md-1">
            <dt class="col-sm-7">Total asientos vendidos:</dt>
            <dd class="col-sm-5"><?= $sold_amount ?></dd>
            <dt class="col-sm-7">Total remanente:</dt>
            <dd class="col-sm-5"><?= $total_remainder ?></dd>
        </dl>
    </div>
</div>

<?php require FOOTER ?>