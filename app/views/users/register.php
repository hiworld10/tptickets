<?php require(HEADER); ?>

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
            <h2>Registrate aquí</h2> 
        </header>
        <form class="login-form bg-dark-alpha p-5 text-white" action="<?= FRONT_ROOT ?>/users/register" method="POST">
            <div class="form-group">
                 <label for="">Nombre</label>
                 <input type="text" name="name" class="form-control form-control-lg" placeholder="Ingresar nombre" value="<?php echo $data['name'] ?>" autofocus required>
            </div>
            <div class="form-group">
                 <label for="">Apellido</label>
                 <input type="text" name="surname" class="form-control form-control-lg" placeholder="Ingresar apellido" value="<?php echo $data['surname'] ?>" required>
            </div>            
            <div class="form-group">
                 <label for="">Email</label>
                 <input type="email" name="email" class="form-control form-control-lg" placeholder="Ingresar email" value="<?php echo $data['email'] ?>" required>
            </div>
            <div class="form-group">
                 <label for="">Contraseña (min. 6 caracteres)</label>
                 <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresar contraseña" value="" required>
            </div>
            <div class="form-group">
                 <label for="">Confirmar contraseña</label>
                 <input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="Ingresar contraseña" value="" required>
            </div>            
            <button class="btn btn-dark btn-block btn-lg mt-5" type="submit">
                 Registrarse
            </button>
        </form>
    </div>
</main>

<?php require(FOOTER); ?>
