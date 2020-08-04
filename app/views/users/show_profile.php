<?php require HEADER; ?>

<div class="container">
    <h1>Tu Perfil</h1><br>
    <h3>Información personal</h3><br>
    <dl class="row">
        <dt class="col-sm-3">Nombre</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($data['user']->getName()) ?></dd>
        <dt class="col-sm-3">Apellido</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($data['user']->getSurname()) ?></dd>
        <dt class="col-sm-3">E-mail</dt>
        <dd class="col-sm-9"><?php echo htmlspecialchars($data['user']->getEmail()) ?></dd>
    </dl>
    <a href="<?= FRONT_ROOT ?>/users/edit-profile">Editar perfil</a>
    <br><br>
    <h3>Historial de compras</h3>
    <a href="<?= FRONT_ROOT ?>/purchases/show-history">Ver historial</a>
</div>
<?php require FOOTER ?>