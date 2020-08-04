<?php require HEADER ?>
<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform"  class="__full-height-perc">
        <div id=edit>

            <div class="col-lg-4 offset-md-0">
                <div class="card mb-3" style="width: 18rem;">
                    
                    <div class="card-body">
                        <h3 class="card-title text-center">Ventas por fecha <?= $data['date'] ?> </h3>
                        <hr>
                        <h4 class="card-text text-center text-primary"><?= moneyFormat($data['total']) ?></h4>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <a href="<?= FRONT_ROOT ?>/admin/sales">Regresar</a>
            </div>
        </div>
    </div>
</div>
<?php require FOOTER ?>
