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
                <form method="post" action="<?=base_url()?>eventos/saveObs">
                     <?= csrf_field() ?>
                                     <input type="hidden" name="id_evento" id="id_evento" value="<?= $datos->id_evento ?>" />

                     <div class="form-group">
                <div class="row">
                <div class="col-12 col-md-12 bg-primary text-white p-1" for="obs"><i class="fas fa-book-open"></i> Observaciones (Cuadernillo): </div>
                <textarea class="form-control" name="obs" id="obs" cols="80" rows="10"><?php if($datos->texto){echo $datos->texto;}
                    else{
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

                <textarea class="form-control" cols="80" rows="15">Aca si irá el acta final... en desarrollo...</textarea>
            </div>
            <div class="col-6 col-md-4 col-sm-12">
                <div class="card bg-light ">
                    <div style="background-color: #6fe39f;" class="card-header  text-dark pt-1 pb-1"> <span class="group-text"><img style="padding-right:5px;" width="25" src="<?= base_url() ?>img/meet_icon.png" alt="chile">Reunión Virtual</span></div>
                    <div class="card-body  mt-0 pt-1">
                        <table>
                            <tbody>
                                <ul class="list-group list-group-flush ">
                                    <li class="list-group-item pb-1 pt-1">Mediador: <?=$datos->nombre_mediador?></li>
                                    <li class="list-group-item pb-1 pt-1">Link: <a target="_blank" href="<?= $datos->enlace ?>"><?= $datos->enlace ?></a></li>
                                    <li class="list-group-item pb-1 pt-1">Fecha: <?=date('d-m-Y H:i:s', strtotime($datos->fecha_inicio))?></li>        
                                </ul>
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
                        <?php if(count($solicitantes)>0){ ?>
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
                            <?php foreach($solicitantes AS $solicitante){ ?>
                            <tr class="text-center text-xs">
                                 <td><?=$solicitante['rut']?></td>
                                <td><?=$solicitante['nombre']?></td>
                                <td><?=$solicitante['telefono']?></td>
                                <td><?=$solicitante['correo']?></td>
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

                         <?php if(count($solicitados)>0){ ?>
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
                            <?php foreach($solicitados AS $solicitado){ ?>
                            <tr class="text-center text-xs">
                                 <td><?=$solicitado['rut']?></td>
                                <td><?=$solicitado['nombre']?></td>
                                <td><?=$solicitado['telefono']?></td>
                                <td><?=$solicitado['correo']?></td>
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
                                    <ul class=" text-xs" style="list-style-type: none; margin-left: -20px;">
                                        <?php foreach ($hijos as $hijo) { ?>
                                            <li class="ml-0"><?= strtoupper($hijo['nombre']) ?> - <?= $hijo['edad'] ?></li>
                                        <?php } ?>
                                    </ul>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>


                 <?php if (count($materias) > 0) { ?>
                    <div class="card bg-light ">
                        <div class="card-header bg-primary text-white pt-1 pb-1"><i class="fas fa-list"></i> Materias</div>
                        <div class="card-body  mt-0 pt-1">
                            <table>
                                <tbody>
                                    <ul class=" text-sm" style="list-style-type: none; margin-left: -20px;">
                                        <?php foreach ($materias as $materia) { ?>
                                            <li class="ml-0"><?= strtoupper($materia['nombre'])?></li>
                                        <?php } ?>
                                    </ul>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
                


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