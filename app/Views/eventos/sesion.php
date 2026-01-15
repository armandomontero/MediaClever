<!-- Begin Page Content -->

<link href='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@4.0.10/js/froala_editor.pkgd.min.js'></script>

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

            <div class="col-12 col-md-7">
                <form method="post" action="<?= base_url() ?>eventos/saveObs">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_evento" id="id_evento" value="<?= $datos->id_evento ?>" />

                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-12 bg-primary text-white p-1" for="obs"><i class="fas fa-book-open"></i> Observaciones (Cuadernillo): </div>
                            <textarea
                                <?php if ($datos->state == 'Realizado') {
                                    echo 'readonly';
                                } ?>
                                class="form-control" name="obs" id="obs" cols="80" rows="10"><?php if ($datos->texto) {
                                                                                                    echo $datos->texto;
                                                                                                } else {
                                                                                                ?>
FECHA :
MATERIAS SOLICITADAS :
MEDIADOR :
NÚMERO DE REGISTRO :
RUN : 
DOMICILIO :

DATOS DEL SOLICITANTE Y
ACTIVIDAD ACTUAL
DATOS DEL SOLICITADO Y
ACTIVIDAD ACTUAL
NECESIDADES DE LOS HIJOS

CAPACIDAD ECÓNOMICA DEL
SOLICITANTE
CAPACIDAD ECÓNOMICA DEL
SOLICITADO
PROPUESTA DE PENSIÓN .
FECHA DE PAGO Y MES :

GASTOS EXTRAORDINARIOS: :
GASTOS EXTRAS: :

REGIMEN ORDINARIO
REGIMEN EXTRAORDINARIO
CAUSA ANTERIOR 
                    <?php } ?>
                </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button id="enviar" type="submit" class="btn btn-primary btn-ok"><i class="fas fa-save"></i> Guardar Datos</button>
                    </div>

                </form>
                <form method="post" action="<?= base_url() ?>eventos/saveActa">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_evento" id="id_evento" value="<?= $datos->id_evento ?>" />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-md-12 bg-primary text-white p-1" for="acta"><i class="fas fa-book-open"></i> Acta de Mediación </div>
                            <div id="acta"></div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6 col-sm-4">
                                <label class="d-inline-block" for="estado_final">Estado: </label>
                                <select required class="form-select" name="estado_final" id="estado_final">
                                    <option value="">Selecciona</option>
                                    <option value="Con Acuerdo">Con Acuerdo</option>
                                    <option value="Acuerdo Parcial">Acuerdo Parcial</option>
                                    <option value="Frustrada">Frustrada</option>
                                </select>
                            </div>
                            <div class="col-4 col-sm-4">
                                <button id="enviar" type="submit" class="btn btn-success btn-ok"><i class="fas fa-save"></i> Marcar Realizada</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-5 col-sm-12 ">
                <div class="card bg-light ">
                    <div class="card-header bg-success text-light pt-1 pb-1"> <i class="fas fa-calendar-check"></i> Datos Generales</div>
                    <div class="card-body  mt-0 pt-1">
                        <table class="table table-striped table-sm mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-xs text-right">MEDIADOR:</td>
                                    <td class="pl-2"><?= strtoupper($datos->nombre_mediador) ?></td>

                                </tr>
                                <tr>
                                    <td class="text-xs text-right">REG:</td>
                                    <td class="pl-2"><?= $datos->registro_mediador ?></td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-right">FECHA:</td>
                                    <td class="pl-2"><?= date('d-m-Y H:i:s', strtotime($datos->fecha_inicio)) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-xs text-right"><span class="group-text"> <img style="padding-right:5px;" width="25" src="<?= base_url() ?>img/meet_icon.png" alt="chile"></span></td>
                                    <td class="pl-2"><a target="_blank" href="<?= $datos->enlace ?>"><?= $datos->enlace ?></a></td>
                                </tr>
                                <tr class="pt-2">
                                    <td class="text-xs text-right align-top pt-2">MATERIAS:</td>
                                    <td class="pl-2 ">
                                        <?php foreach ($materias as $materia) { ?>
                                            <?= $materia['nombre'] ?>
                                        <?php } ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card bg-light ">
                    <div class="card-header bg-primary text-white pt-1 pb-1"><i class="fas fa-user"></i> Datos Solicitante</div>
                    <div class="card-body  mt-0 pt-1">
                        <table class="">
                            <tbody>
                                <tr>
                                    <td class="text-xs text-right">NOMBRE:</td>
                                    <td class="pl-2"><?= strtoupper($datos->nombre_solicitante) ?></td>

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
                                    <td class="pl-2"><?= strtolower($datos->correo_solicitante) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if (count($solicitantes) > 0) { ?>
                            <span>Otros Solicitantes:</span>
                            <table class="table table-sm table-striped table-hover">
                                <thead>
                                    <tr class="bg-primary text-light text-xs text-center">
                                        <th>RUT</th>
                                        <th>NOMBRE</th>
                                        <th>FONO</th>
                                        <th>CORREO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($solicitantes as $solicitante) { ?>
                                        <tr class="text-center text-xs">
                                            <td><?= $solicitante['rut'] ?></td>
                                            <td><?= $solicitante['nombre'] ?></td>
                                            <td><?= $solicitante['telefono'] ?></td>
                                            <td><?= $solicitante['correo'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>

                <div class="card bg-light mt-2 ">
                    <div class="card-header bg-primary text-white  pt-1 pb-1"><i class="fas fa-user"></i> Datos Solicitado</div>
                    <div class="card-body  mt-0 pt-1">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="text-xs text-right">NOMBRE:</td>
                                    <td class="pl-2"><?= strtoupper($datos->nombre_solicitado) ?></td>

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
                                    <td class="pl-2"><?= strtolower($datos->correo_solicitado) ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <?php if (count($solicitados) > 0) { ?>
                            <span>Otros Solicitados:</span>
                            <table class="table table-sm table-striped table-hover">
                                <thead>
                                    <tr class="bg-primary text-light text-xs text-center">
                                        <th>RUT</th>
                                        <th>NOMBRE</th>
                                        <th>FONO</th>
                                        <th>CORREO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($solicitados as $solicitado) { ?>
                                        <tr class="text-center text-xs">
                                            <td><?= $solicitado['rut'] ?></td>
                                            <td><?= $solicitado['nombre'] ?></td>
                                            <td><?= $solicitado['telefono'] ?></td>
                                            <td><?= $solicitado['correo'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>

                <?php if (count($hijos) > 0) { ?>
                    <div class="card bg-light ">
                        <div class="card-header bg-primary text-white pt-1 pb-1"><i class="fas fa-users"></i> Hijos</div>
                        <div class="card-body  mt-0 pt-1">
                            <table>
                                <tbody>
                                    <ul class="" style="list-style-type: none; margin-left: -20px;">
                                        <?php foreach ($hijos as $hijo) { ?>
                                            <li class="ml-0"><?= strtoupper($hijo['nombre']) ?> - <?= $hijo['edad'] ?></li>
                                        <?php } ?>
                                    </ul>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>





            </div>

        </div>


    </div>
</main>

<script> 
      var editor = new FroalaEditor('#acta');
    </script>
