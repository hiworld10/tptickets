<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container">
        
        <a class="navbar-brand d-flex" href="<?= FRONT_ROOT ?>/">
            <?php if (\app\Auth::isAdmin()): ?>
                <div class="pl-2 pt-1">TPTickets <small>Admin Area</small></div>
            <?php else: ?>
                <div><img src="<?= FRONT_ROOT ?>/tickets-blue.png" style="height: 34px;" alt=""></div>
                <div class="pl-2">TPTickets</div>
            <?php endif ?>
        </a>
        <div class="right">
            <?php if(!\app\Auth::getUser()) : ?>
                <a class="btn btn-info" href="<?= FRONT_ROOT ?>/users/login">Ingresar</a>
                <a class="btn btn-info" href="<?= FRONT_ROOT ?>/users/register">Registrarse</a>
            <?php else :  ?>
                <?php if (isset($_SESSION['tptickets_items'])): ?>
                    <a title="Ver carro" class="btn btn-<?= ($_SESSION['tptickets_subtotal'] > 0) ? 'success' : 'secondary'  ?>" style="color: #fafafa" href="<?= FRONT_ROOT ?>/purchases/show-cart">
                    <img src="<?= FRONT_ROOT ?>/img/cart-icon.png" style="height: 23px;" alt="">
                    <?php echo htmlspecialchars('$' . number_format((float)$_SESSION['tptickets_subtotal'], 2, ',', '')) ?></a>
                <?php endif ?>
                <?php if (!\app\Auth::isAdmin()): ?>
                    <a class="btn btn-info" href="<?= FRONT_ROOT ?>/users/show-profile">Mi cuenta</a>
                <?php endif ?>
                <a class="btn btn-info" href="<?= FRONT_ROOT ?>/users/logout">Salir</a>
            <?php endif; ?>  
        </div>
    </div>
</nav>