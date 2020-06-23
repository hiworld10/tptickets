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

<div id="container" class="__full-height-perc">

	<?php require ADMIN_NAVBAR ?>

	<div id="divform"  class="__full-height-perc">
		<div id=edit class="__full-height-perc">
			<!-- Este div aparecerá si un artista debe ser modificado -->
			<?php if (isset($data['user'])): ?>

				<form name='formulario' action="<?=FRONT_ROOT?>/users/update" method="POST">
					<div class="form">
						<div class="col-9 col-md-2 mb-2 mb-md-0 ">
							<label>Id</label>
							<input type="text" name="id_user" class="form-control form-control-lg" value="<?= $data['user']->getId(); ?>" readonly>
						</div>
						<div class="col-12 col-md-9 mb-2 mb-md-0">
							<label>Email</label>
							<input type="email" name="email" class="form-control form-control-lg" value="<?= $data['user']->getEmail(); ?>">
						</div>
						<div class="col-12 col-md-9 mb-2 mb-md-0">
							<label>Nombre</label>
							<input type="text" name="name" class="form-control form-control-lg" value="<?= $data['user']->getName(); ?>" required>
						</div>
						<div class="col-12 col-md-9 mb-2 mb-md-0">
							<label>Apellido</label>
							<input type="text" name="surname" class="form-control form-control-lg" value="<?= $data['user']->getSurname(); ?>" required>
						</div>						
						<div class="col-12 col-md-9 mb-2 mb-md-0">
							<label>Contraseña (dejar en blanco para mantener la previa)</label>
							<input type="password" name="password" class="form-control form-control-lg">
						</div>
						<div class="col-12 col-md-9 mb-2 mb-md-0">
							<label>Confirmar contraseña</label>
							<input type="password" name="confirm_password" class="form-control form-control-lg">
						</div>						
						<div class="col-12 col-md-9 mb-2 mb-md-3">
							<?php /*si el valor devuelve "true", el checkbox queda marcado con el atributo html "checked". Caso contrario, aparece sin marcar*/ ?>
							<label><input type="checkbox" name="admin" class="form-control form-control-lg" value="true"
								<?php if($data['user']->getAdmin() == "true") echo "checked" ?>>Admin</label>
						</div>
						<div class="col-12 col-md-3">
								<button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
						</div>
					</div>
				</form>

			<?php else: ?>

				<!-- De no ser así, se habilitará el formulario para agregar usuarios  -->
				<form name='formulario' action="<?=FRONT_ROOT?>/users/register"  method="POST">
					<div class="form">
						<div class="col-12 col-md-9 mb-2 mb-md-3">
							<input type="email" name="email" class="form-control form-control-lg" placeholder="Email..." required>
						</div>
						</div>        
						<div class="col-12 col-md-9 mb-2 mb-md-3">
							<input type="text" name="name" class="form-control form-control-lg" placeholder="Nombre..." required>
						</div>
						<div class="col-12 col-md-9 mb-2 mb-md-3">
							<input type="text" name="surname" class="form-control form-control-lg" placeholder="Apellido..." required>
						</div>						
						<div class="col-12 col-md-9 mb-2 mb-md-3">
							<input type="password" name="password" class="form-control form-control-lg" placeholder="Contraseña..." required>
						</div>
						<div class="col-12 col-md-9 mb-2 mb-md-3">
							<input type="password" name="confirm_password" class="form-control form-control-lg" placeholder="Confirmar contraseña..." required>
						<div class="col-12 col-md-9 mb-2 mb-md-3">
							<label><input type="checkbox" name="admin" class="form-control form-control-lg" value="true">Admin</label>
						</div>
						<div class="col-12 col-md-3">
							<button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
						</div>
					</div>
				</form>

			<?php endif ?>


			<!-- Lista de usuarios -->
			<div id="table" class="__full-height-perc">
				<table class="table bg-light-alpha">

					<?php if(!empty($data['users'])): ?>
						<thead>     
							<th>Id</th>  
							<th>Email</th> 
							<th>Nombre</th>   
							<th>Apellido</th>
							<th>Admin</th>           
						</thead>
						<tbody>
							<?php foreach ($data['users'] as $value): ?>
								<tr>
									<td><?= $value->getId(); ?></td>
									<td><?= $value->getEmail(); ?></td>
									<td><?= $value->getName(); ?></td>
									<td><?= $value->getSurname(); ?></td>
									<td><?= $value->getAdmin(); ?></td>

									<td>
										<form action="<?=FRONT_ROOT?>/users/delete" method="POST">
											<button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
										</form>
									</td>
									<td>
                                    	<a href="<?=FRONT_ROOT?>/users/edit-as-admin/<?=$value->getId()?>" class="btn btn-block btn-lg btn-primary btn-sm">Editar
                                    	</a>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					<?php endif ?>
				</table>
			</div>
		</div>
	</div>
</div>

<?php require FOOTER ?>
