<?php require HEADER ?>

<div>
    <h1><?php echo htmlspecialchars($data['event_name']) ?></h1>
    <br>
    <?php echo "Fecha de evento: " . htmlspecialchars($data['date']) ?>
</div>

<div class="jumbotron">
    <?php if (!empty($data['event_seat'])): ?>
        <div>
            <pre><?php echo htmlspecialchars($data['event_seat']->getSeatType()->getType()) ?></pre>
            <pre><?php echo "Precio: $" . htmlspecialchars($data['event_seat']->getPrice()) ?></pre>
            <p>Seleccioná la cantidad de asientos (Máximo 5)</p>
            <form name="form" action="<?= FRONT_ROOT ?>/purchases/add-new" method="POST">
                <input type="hidden" name="id_event_seat" value="<?= $data['event_seat']->getId() ?>"><br>
                <input type="number" max="5" name="amount"><br>
                <button type="submit">Añadir a compra</button>
            </form>
        </div>
    <?php else: ?>
        <pre>Tipo de asiento no válido</pre>      
    <?php endif ?>
</div>

<?php require FOOTER ?>