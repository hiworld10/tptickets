<?php require HEADER ?>

<div>
    <h1><?php echo htmlspecialchars($data['event_name']) ?></h1>
    <br>
    <?php echo "Fecha de evento: " . htmlspecialchars($data['date']) ?>
</div>

<div class="jumbotron">
    <?php if (!empty($data['event_seats'])): ?>
        <?php foreach ($data['event_seats'] as $event_seat): ?>
            <div>
                <pre><?php echo htmlspecialchars($event_seat->getSeatType()->getType()) ?></pre>
                <pre><?php echo "Precio: $" . htmlspecialchars($event_seat->getPrice()) ?></pre>
                <form name="form" action="<?= FRONT_ROOT ?>/calendars/show-seat" method="POST">
                    <input type="hidden" name="id_event_seat" value="<?= $event_seat->getId() ?>">
                    <button type="submit">Comprar</button>
                </form>
            </div>
        <?php endforeach ?>      
    <?php else: ?>
        <pre>Entradas agotadas</pre>      
    <?php endif ?>
</div>

<?php require FOOTER ?>