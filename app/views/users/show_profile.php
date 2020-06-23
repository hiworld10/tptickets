<?php require HEADER; ?>

<div class="container">
    <h1>Tu Perfil</h1><br>
    <dl class="dl-horizontal">
        <dt>Nombre</dt>
        <dd><?php echo htmlspecialchars($data['user']->getName()) ?></dd>
        <dt>Apellido</dt>
        <dd><?php echo htmlspecialchars($data['user']->getSurname()) ?></dd>
        <dt>E-mail</dt>
        <dd><?php echo htmlspecialchars($data['user']->getEmail()) ?></dd>
    </dl>
    <a href="<?= FRONT_ROOT ?>/users/edit-profile">Editar perfil</a>
</div>
<?php require FOOTER ?>