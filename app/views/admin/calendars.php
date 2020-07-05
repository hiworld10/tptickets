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
	<div id="divform" class="__full-height-perc">

		<?php if (isset($data['calendar'])): ?>

			<form name='formulario' action="<?=FRONT_ROOT?>/admin/calendars/update"  method="POST">
				<div class="form">
					<div class="form-row col-12 col-md-9 mb-2 mb-md-3" >
						<label><big><big>Id Calendario</big></big></label>
						<input type="text" name="id" class="form-control col-md-1 ml-3" value="<?= $data['calendar']->getId(); ?>" readonly>
					</div>
					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label for=""><big><big>Fecha</big></big></label>
						<input type="date"   class="form-control form-control-lg" name="date" value="<?= $data['calendar']->getDate(); ?>" required>
					</div>
					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label for=""><big><big>Evento</big></big></label>
						<select class="form-control" name="id_event"  required>

							<?php if (isset($data['events'])): ?>

								<option value="<?= $data['calendar']->getEvent()->getId(); ?> "><?= $data['calendar']->getEvent()->getName(); ?></option> 

								<?php foreach ($data['events'] as $value): ?> 

									<?php // con el fin de que no se repita el mismo select ?>
									<?php if ($value->getId() != $data['calendar']->getEvent()->getId()): ?>

									   <option value="<?= $value->getId(); ?> "><?= $value->getName(); ?></option>

								    <?php endif ?> 
							    <?php endforeach ?>
							<?php else: ?>

								<option >NO HAY EVENTOS</option>

							<?php endif ?>
						</select>
					</div>

					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label for=""><big><big>Artistas</big></big></label>
						<br>
						<?php //LOS ARTISTAS QUE INTEGRAN EL CALENDARIO APARECEN checked ?>
						<?php // flag que se fija si esta seteado o no ?>	

						<?php if (isset($data['artists'])): ?>

							<?php foreach ($data['artists'] as $key => $value): ?> 

								<?php $flag = true; ?> 

								<?php foreach ($data['calendar']->getArtistArray() as $v): ?>

									<?php if ($value->getId() == $v->getId()): ?>

										<?php $flag = false; ?>	
										<label>
											<input type="checkbox" name="id_artist_arr[]" value="<?= $value->getId(); ?>" checked >
											<span><?= $value->getName()?></span>
										</label>

									<?php endif ?>

								<?php endforeach ?>

								<?php if ($flag == true): ?>

									<label>
										<input type="checkbox" name="id_artist_arr[]" value="<?= $value->getId(); ?>" >
										<span><?= $value->getName()?></span>
									</label>

								<?php endif ?>

							<?php endforeach ?>	

						<?php else: ?>

							<span>NO HAY ARTISTAS CARGADOS</span>

						<?php endif ?>

					</div>

					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label for=""><big><big>Lugar</big></big></label>
						<div class="col-12 col-md-2 mb-2 mb-md-3">
							<input type="hidden" name="place_event[id_place_event]" class="form-control form-control-lg" value="<?= $data['calendar']->getPlaceEvent()->getId(); ?>" readonly>
						</div>
						<label>Descripcion</label>
						<br>
						<input type="text"   class="form-control form-control-lg" name="place_event[description]" value="<?=$data['calendar']->getPlaceEvent()->getDescription(); ?>" >
						<label>Capacidad</label>
						<br>
						<input type="number"  min="1000" class="form-control form-control-lg" name="place_event[capacity]" value="<?=$data['calendar']->getPlaceEvent()->getCapacity(); ?>">
					</div>	
					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label><big><big>Plazas</big></big></label>

						<?php if (isset($data['event_seats'])): ?>

							<?php foreach ($data['event_seats'] as $value): ?>

								<div class="col-12 col-md-2 mb-2 mb-md-3">
									<input type="hidden" name="event_seats[<?= $value->getSeatType()->getType(); ?>][id_event_seat]" class="form-control form-control-lg" value="<?= $value->getId(); ?>" readonly>
								</div>
								<label><?= $value->getSeatType()->getType(); ?></label>
								<div class="form-row col-12 col-md-9 mb-2 mb-md-3">
									<div class="col-12 col-md-2 mb-2 mb-md-3">
										<input type="hidden" name="event_seats[<?= $value->getSeatType()->getType(); ?>][id_seat_type]" class="form-control form-control-lg" value="<?= $value->getSeatType()->getId(); ?>" readonly>
									</div>
									<label>Capacidad</label>
									<input type="number"  min=0 class="form-control col-md-2 ml-3" name="event_seats[<?= $value->getSeatType()->getType(); ?>][new_quantity]" value="<?= $value->getQuantity(); ?>" >
									<label>Precio</label>
									<input type="number" min=0  class="form-control col-md-2 ml-3" name="event_seats[<?= $value->getSeatType()->getType(); ?>][price]" value="<?= $value->getPrice(); ?>" >
                                    <label>Restante</label>
                                    <input type="number" class="form-control col-md-2 ml-3" name="event_seats[<?= $value->getSeatType()->getType(); ?>][remainder]" value="<?= $value->getRemainder(); ?>" readonly>
                                    <input type="hidden" class="form-control col-md-2 ml-3" name="event_seats[<?= $value->getSeatType()->getType(); ?>][previous_quantity]" value="<?= $value->getQuantity(); ?>" >
								</div>

							<?php endforeach ?>

						<?php endif ?>	

						<?php if ($data['events'] && $data['artists'] && $data['seat_types']): ?>

							<div class="col-11 col-md-3 mt-4">
								<button type="submit" class="btn btn-block btn-lg btn-info">Agregar</button>
							</div>

						<?php else: ?>

							<div class="col-11 col-md-3 mt-4">
								<button type="submit" disabled class="btn btn-block btn-lg btn-info">Agregar</button>
							</div>

						<?php endif ?>
					</div>
				</div>	
			</form>

		<?php else: ?>

			<form name='formulario' action="<?=FRONT_ROOT?>/admin/calendars/add"  method="POST">
				<div class="form">
					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label for=""><big><big>Fecha</big></big></label>
						<input type="date"   class="form-control form-control-lg" name="date" placeholder="Ingrese fecha..." required>
					</div>
					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label for=""><big><big>Evento</big></big></label>
						<select class="form-control" name="id_event" required>

							<?php if (isset($data['events'])): ?>
								<?php foreach ($data['events'] as $key => $value): ?>
									<!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
									<option value="<?= $value->getId(); ?>"><?= $value->getName(); ?></option> 
								<?php endforeach ?>
							<?php else: ?>
								<option >NO HAY EVENTOS</option>
							<?php endif ?>

						</select>
					</div>
					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label for=""><big><big>Artistas</big></big></label>
						<br>

						<?php if(isset($data['artists'])): ?>
							<?php foreach ($data['artists'] as $key => $value): ?>
								<label>
									<input  type="checkbox" name="id_artist_arr[]" value="<?= $value->getId(); ?>" >
									<span><?= $value->getName()?></span>
								</label>
							<?php endforeach ?>
						<?php else: ?>	
								<span>NO HAY ARTISTAS CARGADOS</span>
						<?php endif ?>

					</div>
					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label for=""><big><big>Lugar</big></big></label>
						<input type="text"   class="form-control form-control-lg" name="place_event[description]" placeholder="Ingrese descripcion del lugar..." >
						<input type="number" min="1000"  class="form-control form-control-lg" name="place_event[capacity]" placeholder="Ingrese capacidad del lugar..." >
					</div>
					<div class="col-12 col-md-9 mb-2 mb-md-3">
						<label><big><big>Tipo Plaza</big></big></label>

						<?php if (isset($data['seat_types'])): ?>
							<?php foreach ($data['seat_types'] as $key => $value): ?>

								<br>
								<label><?= $value->getType(); ?></label>
								<div class="form-row col-12 col-md-9 mb-2 mb-md-3">
									<input type="hidden"    name="event_seats[<?= $value->getType(); ?>][id_seat_type]" value=<?= $value->getId(); ?> >
									<label>Capacidad</label>
									<input type="number" min="0"  class="form-control col-md-2 ml-3" name="event_seats[<?= $value->getType(); ?>][quantity]" value=0 >

									<label>Precio</label>
									<input type="number" min="0"  class="form-control col-md-2 ml-3" name="event_seats[<?= $value->getType(); ?>][price]" value=0 >
								</div>
							<?php endforeach ?>
						<?php else: ?>
							<option>NO HAY TIPOS</option>
						<?php endif ?>

					</div>
					<?php if ($data['events'] && $data['artists'] && $data['seat_types']): ?>
						<div class="col-11 col-md-3 mt-4">
							<button type="submit" class="btn btn-block btn-lg btn-info">Agregar</button>
						</div>
					<?php else: ?>
						<div class="col-11 col-md-3 mt-4">
							<button type="submit" disabled class="btn btn-block btn-lg btn-info">Agregar</button>
						</div>
					<?php endif ?>
				</div>
			</form>

		<?php endif ?>

		<div id="table" class="__full-height-perc">
			<table class="table bg-light-alpha">

				<?php if (!empty($data['calendars'])): ?>
					<thead>     
						<th>Id</th>  
						<th>Fecha</th>     
						<th>Evento</th>
						<th>Artistas</th>   
						<th>LugarId</th>     
					</thead>
					<tbody>
						<?php foreach ($data['calendars'] as $value): ?>
							<tr>
								<td><?= $value->getId(); ?></td>
								<td><?= $value->getDate(); ?></td>
								<td><?= $value->getEvent()->getName(); ?></td>
								<td>
									<?php foreach ($value->getArtistArray() as $v): ?>
										<?php print_r($v->getName()." - "); ?>	
									<?php endforeach ?>
								</td>
								<td><?= $value->getPlaceEvent()->getId(); ?></td>
								<td>
									<form action="<?=FRONT_ROOT?>/admin/calendars/delete" method="POST">
										<button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-info btn-sm">Eliminar</button>
									</form>
								</td>
								<td>
                                    <a href="<?=FRONT_ROOT?>/admin/calendars/edit/<?=$value->getId()?>" class="btn btn-block btn-lg btn-info btn-sm">Editar
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

<?php require FOOTER ?>