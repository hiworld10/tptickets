<nav class="navbar navbar-light bg-light static-top">
    <div class="container">
        <a class="navbar-brand" href="<?= FRONT_ROOT ?>/home/">TPTickets</a>
        <div class="right">
            <?php if(!isset($_SESSION['userLogedIn'])) : ?>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/loginScreen">Ingresar</a>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/signup">Registrarse</a>
            <?php else :  ?>
                <a class="btn btn-primary" href="<?= FRONT_ROOT ?>/users/logout">Salir</a>
            <?php endif; ?>  
        </div>
    </div>
</nav>