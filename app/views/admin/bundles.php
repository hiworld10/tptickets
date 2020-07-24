<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>

    <div id="divform" class="__full-height-perc">
        <p><?php echo '<pre>';
        print_r($data['bundles']);
        echo '</pre>';
        
         ?></p>    
    </div>
</div>

<?php require FOOTER ?>