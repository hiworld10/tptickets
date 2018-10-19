<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registrarse</title>
</head>
<body>
    <form id="registrarse-form" class="m-2" action="../acciones/registrarse.php" method="POST">
            <div class="text-center mb-4">
                <strong>LOGIN</strong>
            </div>

            <?php if(isset($alert)) { ?>
                <div class="alert alert-danger text-center">
                    <?= $alert ?>
                </div>
            <?php } ?>

            <fieldset>
                <div class="form-group">
                    <label for="">E-mail</label>
                    <input type="email" name="email" value="mi@email.com" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Contraseña</label>
                    <input type="password" name="pass" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Nombre</label>
                    <input type="nombre" name="nombre" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Apellido</label>
                    <input type="apellido" name="apellido" value="" class="form-control">
                </div>
                
            </fieldset>
            <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
        </form>

</body>
</html>

