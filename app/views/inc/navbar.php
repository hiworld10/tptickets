<nav class="navbar navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand" href="<?= FRONT_ROOT ?>/home/">TPTickets</a>
        <div class="right">
            <?php if(!isset($_SESSION['tptickets_user_id'])) : ?>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/login">Ingresar</a>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/register">Registrarse</a>
            <?php else :  ?>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>">Hola, <?php echo htmlspecialchars($_SESSION['tptickets_user_name']) ?></a>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/logout">Salir</a>
            <?php endif; ?>  
        </div>
    </div>
</nav>