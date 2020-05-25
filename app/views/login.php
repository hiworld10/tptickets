<?php require HEADER; ?>

<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center mt-5">
            <h2>Iniciá Sesión</h2>        
        </header>
        <form class="login-form bg-dark-alpha p-5 text-white" action="<?=FRONT_ROOT?>/home/login" method="POST">
            <div class="form-group">
                <label for="">Usuario</label>
                <input type="text" name="email" class="form-control form-control-lg" placeholder="Ingresar usuario">
            </div>
            <div class="form-group">
                <label for="">Contraseña</label>
                 <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresar contraseña">
            </div>
            <button class="btn btn-dark btn-block btn-lg mt-5" type="submit">
                Ingresar
            </button>
        </form>
    </div>
</main>

<?php require(FOOTER); ?>

