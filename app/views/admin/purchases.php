<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform"  class="__full-height-perc">

        <div id="table">
            <table class="table bg-light-alpha">

                <?php if (isset($data['purchases'])): ?>
                    <thead>     
                        <th>ID</th>  
                        <th>ID Cliente</th>
                        <th>ID Linea(s) Compra</th>
                        <th>Fecha</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <?php foreach ($data['purchases'] as $value): ?>
                            <tr>
                                <td><?= $value->getId() ?></td>
                                <td><?= $value->getUserId() ?></td>
                                <td>
                                    <?php foreach ($value->getPurchaseLineArr() as $purchase_line): ?>
                                        <?php print_r($purchase_line->getId()." - "); ?>  
                                    <?php endforeach ?>
                                </td>
                                <td><?= $value->getDate() ?></td>
                                <td><?= $value->getTotal() ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                <?php endif ?>
            </table>
        </div>
    </div>
</div>

<?php require FOOTER ?>