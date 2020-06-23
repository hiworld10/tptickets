<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform"  class="__full-height-perc">

        <div id="table">
            <table class="table bg-light-alpha">

                <?php if (isset($data['tickets'])): ?>
                    <thead>     
                        <th>ID</th>  
                        <th>Linea compra</th>
                        <th>Cantidad</th>
                    </thead>
                    <tbody>
                        <?php foreach ($data['tickets'] as $value): ?>
                            <tr>
                                <td><?= $value->getId() ?></td>
                                <td><?= $value->getPurchaseLineId() ?></td>
                                <td><?= $value->getNumber() ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                <?php endif ?>
            </table>
        </div>
    </div>
</div>

<?php require FOOTER ?>