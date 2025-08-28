<?php
?>
<main>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>materias">materias</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>

        <?php
        if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <div class="card-body">
            <form method="POST" action="<?= base_url() ?>/materias/actualizar" autocomplete="off">
                  <?=csrf_field()?>
                <input type="hidden" id="id" name="id" value="<?= $datos['id'] ?>" ?>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre: </label>
                            <input required autofocus class="form-control" value="<?= $datos['nombre'] ?>" id="nombre" name="nombre" type="text" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Orden: </label>
                            <input required class="form-control" value="<?= $datos['orden'] ?>" id="orden" name="orden" type="number" />
                        </div>
                    </div>
                </div>

                <a href="<?= base_url() ?>materias" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Volver</a>
                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>

            </form>
        </div>
    </div>
</main>