<?php require HEADER; ?>

<h1 class="text-center mt-2">Búsqueda Avanzada</h1>

<header class="text-white text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <form action="<?=  FRONT_ROOT ."/search"?>"  method="GET">
                    <div class="form-row">
                        <div class="col-12 col-md-9 mb-2 mb-md-0 mt-5">
                            <input type="text" name="q" class="form-control form-control-lg" placeholder="Buscar por evento o artista... " autofocus>
                        </div>
                        <div class="col-12 col-md-3 mt-5">
                            <button type="submit" class="btn btn-block btn-lg btn-info">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="container mt-5">
    <div class="row ml-5 pl-5 pt-2">
        <div class="col-4">
            <div>Buscar por Artista</div>
            <br>
            
        </div>
        <div class="col-4">
            <div>Buscar por Categoría</div>
            <br>
        </div>
        <div class="col-4">
            <div>Buscar por Fecha</div>
            <br>
        </div>
    </div>
</div>

<?php require FOOTER ?>
