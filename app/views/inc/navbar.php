<nav class="navbar navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand" href="<?= FRONT_ROOT ?>/">TPTickets</a>
        <div class="right">
            <?php if(!isset($_SESSION['tptickets_user_id'])) : ?>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/login">Ingresar</a>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/register">Registrarse</a>
            <?php else :  ?>
                <?php if (isset($_SESSION['tptickets_purchase'])): ?>
                    <a href="">Tu Compra: <?php echo htmlspecialchars('$' . number_format((float)$_SESSION['tptickets_purchase']['subtotal'], 2, ',', '')) ?></a>
                <?php endif ?>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/show/<?= $_SESSION['tptickets_user_id'] ?>">Mi cuenta</a>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/logout">Salir</a>
            <?php endif; ?>  
        </div>
    </div>
</nav>