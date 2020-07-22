<?php require HEADER ?>

<div class="container-fluid" style="background-color:#F8F9FA;">
    <h1 class="text-center mb-0"><?php echo htmlspecialchars($data['event_name']) ?></h1>
    <p class="text-center mt-1">
        <big><?php echo "Fecha de evento: " . htmlspecialchars($data['date']) ?></big>
    </p>
    <hr>
</div>

<div class="container">
    <h3 class="text-center">Seleccioná tu asiento:</h3>
    <hr>     

    <div class="row">
    
        <?php if (!empty($data['event_seats'])): ?>
            <?php foreach ($data['event_seats'] as $event_seat): ?>

                <div class="col-lg-4">
                    <div class="card mb-3" style="width: 18rem;">
                        
                        <div class="card-body">
                            <h3 class="card-title text-center"><?php echo htmlspecialchars($event_seat->getSeatType()->getType()) ?></h3>
                            <hr>
                            <p class="card-text text-center"><?php echo "Precio: $" . htmlspecialchars($event_seat->getPrice()) ?></p>
                            <a href="#" class="text-center">
                                <form name="form" action="<?= FRONT_ROOT ?>/calendars/show-seat" method="POST">
                                    <input type="hidden" name="id_event_seat" value="<?= $event_seat->getId() ?>">
                                    <button type="submit" class="btn btn-info text-center">Comprar</button>
                                </form>
                            </a>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>
        <?php else: ?>
            <pre>Entradas agotadas</pre>      
        <?php endif ?>          
    </div>
</div>

<?php require FOOTER ?>
