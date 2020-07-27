<?php require HEADER ?>

<div class="container">
    <h1 class="text-center">Tu compra</h1>
    <hr>

    <?php if (!empty($data['items'])): ?>
    	<?php foreach ($data['items'] as $item): ?>
    		<div class="jumbotron">
    			<div>
    				<div>
    					<big><big><big><?php echo htmlspecialchars($item['event']->getName()) ?></big></big></big><br>
    					<big>Fecha: <?php echo htmlspecialchars($item['date']) ?></big><br>
                        <big>Tipo asiento: <?php echo htmlspecialchars($item['seat_type']) ?></big><br>
    					<big>Cantidad: <?php echo htmlspecialchars($item['amount']) ?></big><br>
    					<big>Precio (c/u): <?php echo htmlspecialchars(number_format($item['subtotal'], 2, ',', '')) ?></big><br>
                        <hr>
    					<form name="form" action="<?= FRONT_ROOT ?>/purchases/remove-line" method="POST">
    						<input type="hidden" name="id_event_seat" value="<?= $item['id_event_seat'] ?>">
    						<button class="btn btn-danger" type="submit">Eliminar item</button>
    					</form>
    				</div>
    			</div>
    		</div>
    	<?php endforeach ?>
    	<div class="jumbotron">
    		<big><big>Total compra: $<?php echo htmlspecialchars(number_format($data['subtotal'], 2, ',', '')) ?></big></big>
            <hr>
            <div class="d-flex mt-4">
                <form name="form" action="<?= FRONT_ROOT ?>/purchases/confirm" method="POST">
                    <button class="btn btn-primary" type="submit">Confirmar compra</button>
                </form>
        		<form name="form" action="<?= FRONT_ROOT ?>/purchases/empty-cart" method="POST">
        			<button class="btn btn-danger ml-5" type="submit">Eliminar todos los items</button>
        		</form>
            </div>
    	</div>
    <?php else: ?>
    	<div class="jumbotron">
    		<div class="text-center"><big>Aún no tenés items añadidos a tu carro. Buscá eventos disponibles <a href="<?= FRONT_ROOT ?>">aquí.</a></big></div>
    	</div>
<?php endif ?>
</div>
<?php require FOOTER ?>