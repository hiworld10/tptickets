<?php require HEADER ?>

<h1>Tu compra</h1>

<pre>
    <?php foreach ($data['items'] as $item): ?>
        <?php print_r($item); ?>
    <?php endforeach ?>
</pre>

<p>Subtotal: $<?php echo htmlspecialchars(number_format($data['subtotal'], 2, ',', '')) ?></p>

<?php require FOOTER ?>