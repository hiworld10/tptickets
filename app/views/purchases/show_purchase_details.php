<?php require HEADER ?>

<div class="container">
    <h1 class="mt-3 pb-2">Detalles de items de compra</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Evento</th>
                <th scope="col">Fecha</th>
                <th scope="col">Tipo Asiento</th>
                <th scope="col">Precio x U</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Monto</th>
                <th scope="col">Ticket QR</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; $subtotal = 0; ?>
            <?php foreach ($data['purchase']->getPurchaseLineArr() as $key => $value): ?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $data['event_names'][$key] ?></td>
                    <td><?= $data['dates'][$key] ?></td>
                    <td><?= $data['seat_types'][$key] ?></td>
                    <td><?= moneyFormat($data['event_seat_prices'][$key]) ?></td>
                    <td><?= $value->getQuantity() ?></td>
                    <td><?= moneyFormat($value->getPrice()) ?></td>
                    <td><img src="<?= $value->getTicket()->getQr()->writeDataUri() ?>" alt=""></td>
                </tr>
                <?php $i++; $subtotal += $value->getPrice();  ?>
            <?php endforeach ?>
        </tbody>
    </table>
    <hr>
    <?php if ($subtotal != $data['purchase']->getTotal()): ?>
        <dl class="row">
            <dt class="col-sm-9">Subtotal:</dt>
            <dd class="col-sm-3 text-right pr-5"><?= moneyFormat($subtotal) ?></dd>
        </dl>
        <hr>
        <dl class="row">
            <dt class="col-sm-9">Descuentos:</dt>
            <dd class="col-sm-3 text-right pr-5"><?= '-' . moneyFormat($subtotal - $data['purchase']->getTotal()) ?></dd>
        </dl>
        <hr>
    <?php endif ?>
    <dl class="row">
        <dt class="col-sm-9"><big>Total compra:</big></dt>
        <dd class="col-sm-3 text-right pr-5"><big><?= moneyFormat($data['purchase']->getTotal()) ?></big></dd>
    </dl>
    <hr>
</div>

<?php require FOOTER ?>