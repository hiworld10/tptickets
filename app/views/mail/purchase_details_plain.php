Hola, <?= $data['name'] ?>!

Los detalles de tu compra recientemente efectuada se encuentran aquí.

Código de compra: <?= $data['id_purchase'] ?>

Fecha y hora de compra: <?= $data['purchase_date'] ?>

---------------------
<?php foreach ($data['items'] as $key => $item): ?>
Item <?= $key + 1 ?>

---------------------

Evento: <?= $item['event_name'] ?>

Fecha: <?= $item['date'] ?>

Tipo asiento: <?= $item['seat_type'] ?>

Cantidad: <?= $item['amount'] ?>

Precio x unidad: <?= '$' . number_format((float)$item['price'], 2, ',', '.') ?>

Precio x cantidad: <?= $item['amount'] ?> x <?= '$' . number_format((float)$item['price'], 2, ',', '.') ?> = <?= '$' . number_format((float)$item['subtotal'], 2, ',', '.') ?>


---------------------
<?php endforeach ?>
Total compra: <?= '$' . number_format((float)$data['total'], 2, ',', '.') ?>

---------------------

Los códigos qr correspondientes a tus tickets adquiridos se encuentran adjuntos en este correo.

Muchas gracias por utilizar nuestros servicios.

Visitá nuestra página aquí:

http://localhost/tptickets