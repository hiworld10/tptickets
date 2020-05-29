<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require(ADMIN_NAVBAR); ?>
    <div id="divform" class="__full-height-perc">

        <?php if(isset($event)): ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/events/update"  enctype="multipart/form-data" method="POST">
                <div class="form">
                    <div class="col-md-2 mb-2 mb-md-0 form">
                        <label>Id</label>
                        <input type="text" name="id" class="form-control form-control-lg" value="<?= $event->getId(); ?>" readonly>
                    </div>
                    <div class="col-md-7 mb-2 mb-md-0 form">
                        <label>Nombre</label>
                        <input type="text" name="event" class="form-control form-control-lg" value="<?= $event->getName(); ?>" required>
                    </div>
                    <div class="col-md-7 mb-2 mb-md-0  mt-2 form">
                        <label>Categoria</label>
                        <select class="form-control" name="category" required>
                            <?php if($categoryArray): ?> 
                                <?php foreach ($categoryArray as $key => $value): ?> 
                                    <option value="<?= $value->getId(); ?>"><?= $value->getType(); ?></option> 
                                <?php endforeach ?>
                            <?php else: ?>
                                <option>NO HAY CATEGORIAS</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-lg-7 form-group mt-2">
                        <label>Imagen</label>
                        <input type="file" name="photo" class="form-control form-control-lg"required>
                    </div>
                    <div class="col-11 col-md-3 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Aceptar</button>
                    </div>
                </div>
            </form>

        <?php else: ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/events/add"  enctype="multipart/form-data" method="POST">
                <div class="form-row p-2">
                    <div class="form-group col-12 col-md-9 mb-2 mb-md-0">
                        <input type="text"  class="form-control form-control-lg" name="name" placeholder="Ingrese nombre del evento..." required>
                    </div>
                    <div class="col-lg-4 form-group">

                        <label for="">Categoria</label>
                        <select class="form-control" name="category" required>
                            <?php if($categoryArray): ?> 
                                <?php foreach ($categoryArray as $key => $value): ?>  
                                    <!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
                                    <option value="<?= $value->getId(); ?>"><?= $value->getType(); ?></option> 
                                <?php endforeach ?>
                            <?php else: ?>
                                <option >NO HAY CATEGORIAS</option>
                            <?php endif ?>   
                        </select>
                    </div>
                    <div class="col-lg-4 form-group mt-4">
                        <input type="file"  class="form-control form-control-lg" name="photo" required>
                    </div>
                    <div class="col-11 col-md-3 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Agregar</button>
                    </div>
                </div>
            </form>

        <?php endif ?>

        <div id="table">
            <table class="table bg-light-alpha">

                <?php if(!empty($eventArray)): ?>
                    <thead>     
                        <th>Id</th>  
                        <th>Nombre</th>     
                        <th>Categoria</th>
                        <th>Imagen</th>            
                    </thead>
                    <tbody>
                        <?php foreach ($eventArray as $value): ?>
                            <tr>
                                <td><?= $value->getId(); ?></td>
                                <td><?= $value->getName(); ?></td>
                                <td><?= $value->getCategory()->getId(); ?></td>
                                <td><img src="<?= $value->getImage()->getPath() ?>" height="100" width="100"/></td>
                                <td>
                                    <form action="<?=FRONT_ROOT?>/events/delete" method="POST">
                                        <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="btn btn-block btn-lg btn-primary btn-sm">Eliminar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="<?=FRONT_ROOT?>/events/edit" method="POST">
                                        <button name="update" value="<?= $value->getId(); ?>" id="boton1" type="submit" class="btn btn-block btn-lg btn-primary btn-sm">Editar</button></td>
                                    </form>
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