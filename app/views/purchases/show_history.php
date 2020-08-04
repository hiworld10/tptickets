<?php require HEADER ?>

<div class="container">
	<h1 class="mt-3 pb-2">Tu historial de compras</h1>
    <?php if (empty($data['purchases'])): ?>
        <div class="jumbotron">
            Aún no tenés compras efectuadas. Estas aparecerán aquí una vez que las realices.
        </div>
    <?php else: ?>
    	<table class="table">
    		<thead>
    			<tr>
    				<th scope="col">#</th>
    				<th scope="col">Fecha</th>
    				<th scope="col">Monto</th>
    				<th scope="col">Items</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php $i = 1; ?>
    			<?php foreach ($data['purchases'] as $value): ?>
    				<tr>
    					<th scope="row"><?= $i ?></th>
    					<td><?= $value->getDate() ?></td>
    					<td><?= moneyFormat($value->getTotal()) ?></td>
    					<td><a href="<?= FRONT_ROOT ?>/purchases/show-purchase-details/<?= $value->getId() ?>">Ver</a></td>
    				</tr>
    				<?php $i++; ?>
    			<?php endforeach ?>
    		</tbody>
    	</table>
    <?php endif ?>
</div>

<?php require FOOTER ?>