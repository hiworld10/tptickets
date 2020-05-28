<?php require HEADER; ?>

<?php if (isset($data['errors'])): ?>
    <h3>Se han producido errores:</h3>
    <br>
    <ul>
    <?php foreach ($data['errors'] as $error): ?>
        <li><?php echo $error ?></li>
    <?php endforeach ?>
    </ul>
<?php endif ?>

<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center mt-5">
            <h2>Iniciá Sesión</h2>        
        </header>
        <form class="login-form bg-dark-alpha p-5 text-white" action="<?=FRONT_ROOT?>/users/login" method="POST">
            <div class="form-group">
                <label for="">Usuario</label>
                <input type="text" name="email" class="form-control form-control-lg" placeholder="Ingresar usuario" value="<?php echo $data['email'] ?>" autofocus required>
            </div>
            <div class="form-group">
                <label for="">Contraseña</label>
                 <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresar contraseña" required>
            </div>
            <button class="btn btn-dark btn-block btn-lg mt-5" type="submit">
                Ingresar
            </button>
        </form>
    </div>
</main>

<?php require(FOOTER); ?>

