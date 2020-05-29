
<?php require HEADER; ?>

<div id="container" class="__full-height-perc">
    <?php require(ADMIN_NAVBAR); ?>
    <div id="divform" class="__full-height-perc">
        <!--  <?php if(isset($eventSeat)): ?>


            <form name='formulario' action="<?=FRONT_ROOT?>/eventseat/updateEventSeat"  method="POST">
                <div class="form-row">
                    <div class="col-md-1 mb-2 mb-md-0 form-row">
                        <label>Id</label>
                        <input type="text" name="id" class="form-control form-control-lg" value="<?= $eventSeat->getId(); ?>" readonly>
                    </div>
                    <div class="col-md-5 mb-2 mb-md-0 form-row">
                        <label>Asientos</label>
                        <input type="number" name="seats" class="form-control form-control-lg" value="<?= $eventSeat->getAvailableSeats(); ?>" required>
                    </div>
                    <div class="col-md-5 mb-2 mb-md-0 form-row">
                        <label>Precio</label>
                        <input type="number" name="price" class="form-control form-control-lg" value="<?= $eventSeat->getPrice(); ?>" required>
                    </div>
                    <div class="col-md-5 mb-2 mb-md-0 form-row">
                        <label>Calendario</label>
                        <select class="form-control" name="calendar" required>
                            <?php if($calendarArray): ?>
                                <?php foreach ($calendarArray as $key => $value): ?>
                                    <option value="<?= $value->getId(); ?>"><?= $value->getDate(); ?></option> 
                                <?php endforeach ?>
                            <?php else: ?>
                                <option >NO HAY CALENDARIO</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-md-5 mb-2 mb-md-0 form-row">
                        <label>Tipo Plaza</label>
                        <select class="form-control" name="seattype" required>
                            <?php if($seatTypeArray): ?> 
                                <?php foreach ($seatTypeArray as $key => $value): ?>
                                    <option value="<?= $value->getId(); ?>"><?= $value->getType(); ?></option> 
                                <?php endforeach ?>
                            <?php else: ?>
                                <option >NO HAY TIPOS DE PLAZA</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-2 form-row">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>

        <?php else: ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/eventseat/addEventSeatAndView"  method="POST">
                <div class="form-row p-2">
                    <div class="form-group col-12 col-md-9 mb-2 mb-md-0">
                        <input type="number"  class="form-control form-control-lg" name="availableseat" placeholder="Ingrese cantidad de asientos..." required>
                    </div>
                    <div class="form-group col-12 col-md-9 mb-2 mb-md-0">
                        <input type="number"  class="form-control form-control-lg" name="price" placeholder="Ingrese precio..." required>
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="">Calendario</label>
                        <select class="form-control" name="calendar" required>
                            <?php if ($calendarArray): ?> 
                                <?php foreach ($calendarArray as $key => $value): ?>
                                    <option value="<?= $value->getId(); ?>"><?= $value->getDate(); ?></option> 
                                <?php endforeach ?>
                            <?php else: ?>
                                <option >NO HAY CALENDARIO</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="">Tipo Plaza</label>
                        <select class="form-control" name="seattype" required>
                            <?php if($seatTypeArray): ?> 
                                <?php foreach ($seatTypeArray as $key => $value): ?>
                                    <option value="<?= $value->getId(); ?>"><?= $value->getType(); ?></option> 
                                <?php endforeach ?>
                            <?php else: ?>
                                <option >NO HAY TIPOS DE PLAZA</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-11 col-md-3 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                    </div>
                </div>
            </form>
        <?php endif ?> -->

        <div id="table">
            <table class="table bg-light-alpha">
                <?php if (!empty($data['event_seats'])): ?>
                    <thead>     
                        <th>Id</th>  
                        <th>Asientos</th>     
                        <th>Precio</th>
                        <th>Calendario</th>
                        <th>Tipo Plaza</th>       
                        <th>Calendar Id</th>
                    </thead>
                    <tbody>
                        <?php foreach ($data['event_seats'] as $value): ?>
                            <tr>
                                <td><?= $value->getId(); ?></td>
                                <td><?= $value->getQuantity(); ?></td>
                                <td><?= $value->getPrice(); ?></td>
                                <td><?= $value->getCalendarId(); ?></td>
                                <td><?= $value->getSeatType()->getType(); ?></td>
                                <td><?= $value->getCalendarId(); ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                <?php endif ?>
            </table>
        </div>
    </div>
</div>

<?php require FOOTER ?>