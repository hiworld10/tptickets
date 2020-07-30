<?php require HEADER ?>

<div class="container">
    <div>
        <h1><?php echo htmlspecialchars($data['event']->getName()) ?></h1>
        <big><?php echo "Fecha de evento: " . htmlspecialchars($data['date']) ?></big>
    </div>

    <div class="jumbotron">
        <?php if (!empty($data['event_seat'])): ?>
            <div>
                <div><?php echo "Asiento: " . htmlspecialchars($data['event_seat']->getSeatType()->getType()) ?></div>
                <div><?php echo "Precio: $" . htmlspecialchars($data['event_seat']->getPrice()) ?></div>
                <br>
                <div>Seleccioná la cantidad de asientos (Máximo 5)</div>
                <br>
                <form name="form" action="<?= FRONT_ROOT ?>/purchases/add-new-line" method="POST">
                    <input type="hidden" name="id_event_seat" value="<?= $data['event_seat']->getId() ?>">
                    <input type="hidden" name="seat_type" value="<?= $data['event_seat']->getSeatType()->getType() ?>">
                    <input type="hidden" name="id_calendar" value="<?= $data['event_seat']->getCalendarId() ?>">
                    <input type="hidden" name="id_event" value="<?= $data['event']->getId() ?>">
                    <input type="hidden" name="date" value="<?= $data['date'] ?>">
                    <input type="hidden" name="price" value="<?= $data['event_seat']->getPrice() ?>">
                    <input type="number" min="1" max="5" name="amount" value="1" required>
                    <button class="btn btn-info ml-2" type="submit">Añadir a compra</button>
                </form>
            </div>
        <?php else: ?>
            <pre>Tipo de asiento no válido</pre>      
        <?php endif ?>
    </div>
</div>

<?php require FOOTER ?>