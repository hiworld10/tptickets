<?php require(HEADER); ?>

<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center mt-5">
            <h2>Registrate aquí</h2> 
        </header>
        <form class="login-form bg-dark-alpha p-5 text-white" action="<?=FRONT_ROOT?>/home/add-user" method="POST">
            <div class="form-group">
                 <label for="">Email</label>
                 <input type="email" name="email" class="form-control form-control-lg" placeholder="Ingresar email">
            </div>
            <div class="form-group">
                 <label for="">Contraseña</label>
                 <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresar contraseña">
            </div>
            <div class="form-group">
                 <label for="">Nombre</label>
                 <input type="text" name="name" class="form-control form-control-lg" placeholder="Ingresar nombre">
            </div>
            <div class="form-group">
                 <label for="">Apellido</label>
                 <input type="text" name="lastname" class="form-control form-control-lg" placeholder="Ingresar apellido">
            </div>
            <button class="btn btn-dark btn-block btn-lg mt-5" type="submit">
                 Registrarse
            </button>
        </form>
    </div>
</main>

<?php require(FOOTER); ?>
