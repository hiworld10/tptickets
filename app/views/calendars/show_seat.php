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
            <form name="form" action="<?= FRONT_ROOT ?>/purchases/add-new-line" method="POST">
                <input type="hidden" name="id_event_seat" value="<?= $data['event_seat']->getId() ?>"><br>
                <input type="hidden" name="price" value="<?= $data['event_seat']->getPrice() ?>"><br>
                <input type="number" min="1" max="5" name="amount" value="1" required><br>
                <button type="submit">Añadir a compra</button>
            </form>
        </div>
    <?php else: ?>
        <pre>Tipo de asiento no válido</pre>      
    <?php endif ?>
</div>

<?php require FOOTER ?>