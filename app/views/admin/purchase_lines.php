<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform"  class="__full-height-perc">

        <div id="table">
            <table class="table bg-light-alpha">

                <?php if (isset($data['purchase_lines'])): ?>
                    <thead>     
                        <th>ID</th>  
                        <th>ID Plaza</th>    
                        <th>ID compra</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </thead>
                    <tbody>
                        <?php foreach ($data['purchase_lines'] as $value): ?>
                            <tr>
                                <td><?= $value->getId() ?></td>
                                <td><?= $value->getEventSeatId() ?></td>
                                <td><?= $value->getPurchaseId() ?></td>
                                <td><?= $value->getQuantity() ?></td>
                                <td><?= $value->getPrice() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<?php require FOOTER ?>