<p>&iexcl;Hola, <?= $data['name'] ?>!</p>
<p>Los detalles de tu compra recientemente efectuada se encuentran aqu&iacute;.</p>
<pre><big>C&oacute;digo de compra: <b><?= $data['id_purchase'] ?></b></big></pre>
<pre><big>Fecha y hora de compra: <b><?= $data['purchase_date'] ?></b></big></pre>
<p>-----------------------------</p>
<?php foreach ($data['items'] as $key => $item): ?>
    <p>Item <?= $key + 1 ?></p>
    <p>-----------------------------</p>

    <pre><big>Evento: <?= $item['event']->getName() ?></big></pre>

    <pre><big>Fecha: <?= $item['date'] ?></big></pre>

    <pre><big>Tipo asiento: <?= $item['seat_type'] ?></big></pre>

    <pre><big>Cantidad: <?= $item['amount'] ?></big></pre>

    <pre><big>Precio x unidad: <?= '$' . number_format((float)$item['price'], 2, ',', '.') ?></big></pre>

    <pre><big>Precio x cantidad: <?= $item['amount'] ?> x <?= '$' . number_format((float)$item['price'], 2, ',', '.') ?> = <?= '$' . number_format((float)$item['subtotal'], 2, ',', '.') ?></big></pre>
    <pre><big>C&oacute;digo de ticket: <?= $item['id_ticket'] ?></big></pre>

    <pre><big>C&oacute;digo QR:</big></pre>

     <img src="cid:<?= $data['qr_cid'][$key] ?>"> 
    <p>-----------------------------</p>
<?php endforeach ?>


<pre><big>Total compra: <?= '$' . number_format((float)$data['total'], 2, ',', '.') ?></big></pre>
<p>-----------------------------</p>
<p>Para tu conveniencia, los c&oacute;digos qr correspondientes a tus tickets tambi&eacute;n se encuentran adjuntos en este correo.</p>
<p>Muchas gracias por utilizar nuestros servicios.</p>
<p>Visit&aacute; nuestra p&aacute;gina <a href="<?= FRONT_ROOT ?>">aqu&iacute;</a>.</p>