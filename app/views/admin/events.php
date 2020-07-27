<?php require HEADER ?>

<div id="container" class="__full-height-perc">
    <?php require ADMIN_NAVBAR ?>
    <div id="divform" class="__full-height-perc">

        <?php if(isset($data['event'])): ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/admin/events/update"  enctype="multipart/form-data" method="POST">
                <div class="form">
                    <div class="col-md-2 mb-2 mb-md-0 form">
                        <label>Id</label>
                        <input type="text" name="id" class="form-control form-control-lg" value="<?= $data['event']->getId(); ?>" readonly>
                    </div>
                    <div class="col-md-7 mb-2 mb-md-0 form">
                        <label>Nombre</label>
                        <input type="text" name="name" class="form-control form-control-lg" value="<?= $data['event']->getName(); ?>" required>
                    </div>
                    <div class="col-md-7 mb-2 mb-md-0  mt-2 form">
                        <label>Categoria</label>
                        <select class="form-control" name="category" required>
                            <?php if($data['categories']): ?> 
                                <?php foreach ($data['categories'] as $key => $value): ?> 
                                    <option value="<?= $value->getId(); ?>"><?= $value->getType(); ?></option> 
                                <?php endforeach ?>
                            <?php else: ?>
                                <option>NO HAY CATEGORIAS</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-lg-7 form-group mt-2">
                        <label>Imagen</label>
                        <input type="file" name="image" class="form-control form-control-lg"  required>
                    </div>
                    <div class="col-11 col-md-3 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-info">Aceptar</button>
                    </div>
                </div>
            </form>

        <?php else: ?>

            <form name='formulario' action="<?=FRONT_ROOT?>/admin/events/add"  enctype="multipart/form-data" method="POST">
                <div class="form-row p-2">
                    <div class="form-group col-12 col-md-9 mb-2 mb-md-0">
                        <input type="text"  class="form-control form-control-lg" name="name" placeholder="Ingrese nombre del evento..." required>
                    </div>
                    <div class="col-lg-4 form-group">

                        <label for="">Categoria</label>
                        <select class="form-control" name="category" required>
                            <?php if($data['categories']): ?> 
                                <?php foreach ($data['categories'] as $key => $value): ?>  
                                    <!--No es posible pasar un objeto mediante HTML (ej. '$value')-->
                                    <option value="<?= $value->getId() ?>"><?= $value->getType() ?></option> 
                                <?php endforeach ?>
                            <?php else: ?>
                                <option >NO HAY CATEGORIAS</option>
                            <?php endif ?>   
                        </select>
                    </div>
                    <div class="col-lg-4 form-group mt-4">
                        <input type="file"  class="form-control form-control-lg" name="image" required>
                    </div>
                    <div class="col-11 col-md-3 mt-4">
                        <button type="submit" class="btn btn-block btn-lg btn-info">Agregar</button>
                    </div>
                </div>
            </form>

        <?php endif ?>

        <div id="table">
            <table class="table bg-light-alpha">

                <?php if(!empty($data['events'])): ?>
                    <thead>     
                        <th>Id</th>  
                        <th>Nombre</th>     
                        <th>Categoria</th>
                        <th>Imagen</th>            
                    </thead>
                    <tbody>
                        <?php foreach ($data['events'] as $value): ?>
                            <tr>
                                <td><?= $value->getId(); ?></td>
                                <td><?= $value->getName(); ?></td>
                                <td><?= $value->getCategory()->getId(); ?></td>
                                <td><img src="<?= $value->getImage()->getPath() ?>" height="100" width="100"/></td>
                                <td>    
                                    <a href="<?=FRONT_ROOT?>/admin/events/add-bundle/<?=$value->getId()?>" class="btn btn-block btn-lg <?= $value->getBundle() ? 'btn-primary' : 'btn-outline-primary' ?> btn-sm">Paquete</a>
                                </td>
                                <td>
                                    <a href="<?=FRONT_ROOT?>/admin/events/edit/<?=$value->getId()?>" class="btn btn-block btn-lg btn-info btn-sm">Editar
                                    </a>
                                </td>
                                <td>
                                    <form action="<?=FRONT_ROOT?>/admin/events/delete" method="POST">
                                        <button name="iddelete" value="<?= $value->getId();  ?>"id="boton1" type="submit"class="ml-5 btn btn-block btn-lg btn-danger btn-sm">Eliminar</button>
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
