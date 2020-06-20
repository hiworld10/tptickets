<?php require HEADER ?>

<h1>Confirmar compra</h1>

<h3>Por favor verificá tu compra.</h3>

<?php if (!empty($data['items'])): ?>
    <?php foreach ($data['items'] as $item): ?>
        <div class="jumbotron">
            <div>
                <div>
                    <big><big><big><?php echo htmlspecialchars($item['event_name']) ?></big></big></big><br>
                    <big>Fecha: <?php echo htmlspecialchars($item['date']) ?></big><br>
                    <big>Cantidad: <?php echo htmlspecialchars($item['amount']) ?></big><br>
                    <big>Precio (c/u): <?php echo htmlspecialchars(number_format($item['subtotal'], 2, ',', '')) ?></big><br>
                    <form name="form" action="<?= FRONT_ROOT ?>/purchases/remove-line" method="POST">
                        <input type="hidden" name="id_event_seat" value="<?= $item['id_event_seat'] ?>">
                        <button type="submit">Eliminar item</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <div class="jumbotron">
        <big><big>Total compra: $<?php echo htmlspecialchars(number_format($data['subtotal'], 2, ',', '')) ?></big></big>
    </div>
    <div class="jumbotron">
        <big><big>¿Deseas confirmar la compra?</big></big>
        <form name="form" action="<?= FRONT_ROOT ?>/purchases/checkout" method="POST">
            <button type="submit">Sí, efectuar compra</button>
        </form><br>
        <form name="form" action="<?= FRONT_ROOT ?>/purchases/show-cart" method="POST">
            <button type="submit">No, volver</button>
        </form>
    </div>
<?php else: ?>
    <div class="jumbotron">
        <big>Aún no tenés items añadidos a tu carro. Buscá eventos disponibles <a href="<?= FRONT_ROOT ?>">aquí.</a></big>
    </div>
<?php endif ?>

<?php require FOOTER ?>