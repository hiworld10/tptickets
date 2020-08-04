<?php require HEADER ?>
<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform"  class="__full-height-perc">
        <div id=edit>

            <div class="col-lg-4 offset-md-3">
                <div class="card mb-3" style="width: 18rem;">
                    
                    <div class="card-body">
                        <h3 class="card-title text-center">Total ventas</h3>
                        <hr>
                        <h4 class="card-text text-center text-primary"><?= moneyFormat($data['total_sales']) ?></h4>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex offset-md-2">
                <form action="<?= FRONT_ROOT ?>/admin/sales/by-category" method="GET">
                    <div class="col-7 form-group">
                        <label for="">Ventas por categoría</label>
                        <select name="id" id="category-search">
                            <?php foreach ($data['categories'] as $category): ?>
                                <option value="<?= $category->getId() ?>">
                                    <?= $category->getType() ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <button type="submit" class=" mt-2 btn btn-info">Buscar</button>
                    </div>
                </form>
                <form action="<?= FRONT_ROOT ?>/admin/sales/by-date" method="GET">
                    <div class="col-7 form-group">
                        <label for="">Ventas por fecha</label>
                        <input type="date" name="date">
                        <button type="submit" class=" mt-2 btn btn-info">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require FOOTER ?>
