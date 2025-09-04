<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

        <?php
        if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <?php
        if (isset($mensaje)) { ?>
            <div class="alert alert-success">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>


        <div class="row mt-0">

            <div class="col-12 col-md-8">
                <textarea class="form-control" cols="80" rows="20">aca el acta</textarea>
            </div>
            <div class="col-6 col-md-4 col-sm-12">

                <div class="card bg-light ">
                    <div class="card-header bg-primary text-white pt-1 pb-1"><i class="fas fa-user"></i> Datos Solicitante</div>
                    <div class="card-body  mt-0 pt-1">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="text-xs text-right">NOMBRE:</td>
                                    <td class="pl-2"><?= $datos->nombre_solicitante ?></td>

                                </tr>
                                <tr>
                                    <td class="text-xs text-right">RUT:</td>
                                    <td class="pl-2"><?= $datos->rut_solicitante ?></td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-right">TELÉFONO:</td>
                                    <td class="pl-2"><?= $datos->telefono_solicitante ?></td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-right">CORREO:</td>
                                    <td class="pl-2"><?= $datos->correo_solicitante ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card bg-light mt-2 ">
                    <div class="card-header bg-primary text-white  pt-1 pb-1"><i class="fas fa-user"></i> Datos Solicitado</div>
                    <div class="card-body  mt-0 pt-1">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="text-xs text-right">NOMBRE:</td>
                                    <td class="pl-2"><?= $datos->nombre_solicitado ?></td>

                                </tr>
                                <tr>
                                    <td class="text-xs text-right">RUT:</td>
                                    <td class="pl-2"><?= $datos->rut_solicitado ?></td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-right">TELÉFONO:</td>
                                    <td class="pl-2"><?= $datos->telefono_solicitado ?></td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-right">CORREO:</td>
                                    <td class="pl-2"><?= $datos->correo_solicitado ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if (count($hijos) > 0) { ?>
                    <div class="card bg-light ">
                        <div class="card-header bg-primary text-white pt-1 pb-1"><i class="fas fa-users"></i> Hijos</div>
                        <div class="card-body  mt-0 pt-1">
                            <table>
                                <tbody>
                                    <ul>
                                        <?php foreach ($hijos as $hijo) { ?>
                                            <li><?= $hijo['nombre'] ?> - <?= $hijo['edad'] ?></li>
                                        <?php } ?>
                                    </ul>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                <div class="card bg-light ">
                    <div style="background-color: #6fe39f;" class="card-header  text-dark pt-1 pb-1"> <span class="group-text"><img style="padding-right:5px;" width="25" src="<?= base_url() ?>img/meet_icon.png" alt="chile">Reunión Virtual</span></div>
                    <div class="card-body  mt-0 pt-1">
                        <table>
                            <tbody>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><a target="_blank" href="<?= $datos->enlace ?>"><?= $datos->enlace ?></a></li>
                                    <li class="list-group-item"><?=$datos->fecha_inicio?></li>        
                                </ul>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

        </div>
        En esta pantalla mostraremos datos pertinentes y realizaremos el acta de mediación con sus correspondientes controles
        <br>
        opciones barajadas:<br>
        <ul>
            <li>Habra acta "digital" creada en editor de sistema o acta documento adjunto una de 2</li>
            <li>Gestion de documentos asociados a la mediacion "archivos para subir y adjuntar"</li>
            <li>popup o enlace para ver todos los datos de la mediación y modificarlos segun necesidad</li>
            <li>Link reunion virtual obvio</li>
            <li>Boton para ir guardando cambios</li>
            <li>Boton principal guardar cambios y cambiar estado a realzada</li>
            <li>Boton frustrar</li>
            <li>COmenzaremos con subida de archivos "acta de mediacion externa" para partir produccion</li>
        </ul>
        <br>
        Mientras mostramos link a la meeting: <br>

    </div>
</main>