<!--
$data contents:

['name']        // nombre del cliente

['id_purchase'] // id de compra

['total']       // total de compra

['items'] ->
    
        [id_event_seat] => 10
        [seat_type] => Campo VIP
        [amount] => 2
        [price] => 2000
        [subtotal] => 4000
        [event_name] => Woodstock 2021
        [date] => 2020-07-10
        [qr] => Endroid\QrCode\QrCode Object
    
-->

<p>&iexcl;Hola, <?= $data['name'] ?>!</p>
<p>Detalles de compra:</p>
<pre><big>Código de compra: <b><?= $data['id_purchase'] ?></b></big></pre>
<br>
<p>---------------------</p>

<?php foreach ($data['items'] as $key => $item): ?>
    <p>Item <?= $key + 1 ?></p>
    <p>---------------------</p>
    <pre><big>Evento: <?= $item['event_name'] ?></big></pre>
    <pre><big>Fecha: <?= $item['date'] ?></big></pre>
    <pre><big>Tipo asiento: <?= $item['seat_type'] ?></big></pre>
    <pre><big>Cantidad: <?= $item['amount'] ?></big></pre>
    <pre><big>Precio x unidad: <?= '$' . number_format((float)$item['price'], 2, ',', '.') ?></big></pre>
    <pre><big>Precio x cantidad: <?= $item['amount'] ?> x <?= '$' . number_format((float)$item['price'], 2, ',', '.') ?> = <?= '$' . number_format((float)$item['subtotal'], 2, ',', '.') ?></big></pre>
    <pre><big>Código QR:</big></pre>
    <?php 

     ?>
     <!-- PARA PRUEBAS EN EL NAVEGADOR -->
     <img src="<?php echo $item['qr']->writeDataUri() ?>" alt="qrcode">

     <!-- PARA E-MAIL -->
     <?php /* <img src="cid:<?= $qr['cid'] ?>"> */ ?> 
    <p>---------------------</p>
    
<?php endforeach ?>


<pre><big>Total compra: <?= '$' . number_format((float)$data['total'], 2, ',', '.') ?></big></pre>
<br>
<p>Visit&aacute; nuestra p&aacute;gina <a href="<?= FRONT_ROOT ?>">aqu&iacute;</a>.</p>