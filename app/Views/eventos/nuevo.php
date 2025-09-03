<?php
//Definimos redireccion
$redireccion = '';
if(isset($desde)){
    if($desde=='agenda_general'){
        $redireccion = 'eventos';
    }
}
?>
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
 <form method="POST" class="pr-3 pl-3" name="formulario" id="formulario" action="<?= base_url() ?>eventos/agendarPrivado" autocomplete="off">
                        <?= csrf_field() ?>
                        <input type="hidden" name="valor" id="valor" value="<?= $config['valor_servicio'] ?>" />
                        <input type="hidden" name="fecha_bd" id="fecha_bd" value="" />
                        <div class="form-group mt-4">
                            <h5 class="text-primary">Datos Solicitante:</h5>
                            <hr class="mt-1 mb-2">

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Nombre Completo<span class="text-danger">*</span> </label>
                                    <input required autofocus value="<?= set_value('nombre_solicitante') ?>" class="form-control" id="nombre_solicitante" name="nombre_solicitante" type="text" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>RUT<span class="text-danger">*</span> </label>
                                    <input required class="form-control" value="<?= set_value('rut_solicitante') ?>" id="rut_solicitante" name="rut_solicitante" type="text" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Teléfono<span class="text-danger">*</span> </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><img style="padding-right:5px;" width="25" src="<?= base_url() ?>img/chile.png" alt="chile">+56</span>
                                        <input required autofocus value="<?= set_value('telefono_solicitante') ?>" class="form-control" id="telefono_solicitante" name="telefono_solicitante" type="number" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>E-Mail<span class="text-danger">*</span> </label>
                                    <input required class="form-control" value="<?= set_value('correo_solicitante') ?>" id="correo_solicitante" name="correo_solicitante" type="email" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label for="direccion_solicitante">Dirección </label>


                                    <input value="<?= set_value('direccion_solicitante') ?>" class="form-control" id="direccion_solicitante" name="direccion_solicitante" type="text" />

                                </div>

                            </div>
                        </div>
                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <label>Región </label>
                                    <select onchange="mostrar(this.value, 'comuna'); getText(this, 'region1h');" required class="form-control" name="region" id="region" required>
                                        <option value="">Selecciona</option>
                                    </select>
                                    <input type="hidden" id="region1h" name="region1h" value="" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Comuna </label>
                                    <select onchange="getText(this, 'comuna1h');" required class="form-control" name="comuna" id="comuna">
                                        <option value="">Selecciona</option>
                                    </select>
                                    <input type="hidden" id="comuna1h" name="comuna1h" value="" />
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-3">
                        <h5 class="text-primary">Datos Solicitado:</h5>
                        <hr class="mt-1 mb-2">
                        <div class="form-group mt-4">


                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Nombre Completo<span class="text-danger">*</span> </label>
                                    <input required autofocus value="<?= set_value('nombre_solicitado') ?>" class="form-control" id="nombre_solicitado" name="nombre_solicitado" type="text" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>RUT </label>
                                    <input class="form-control rut" value="<?= set_value('rut_solicitado') ?>" id="rut_solicitado" name="rut_solicitado" type="text" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Teléfono </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><img style="padding-right:5px;" width="25" src="<?= base_url() ?>img/chile.png" alt="chile">+56</span>
                                        <input required value="<?= set_value('telefono_solicitado') ?>" class="form-control" id="telefono_solicitado" name="telefono_solicitado" type="number" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>E-Mail: </label>
                                    <input required class="form-control" value="<?= set_value('correo_solicitado') ?>" id="correo_solicitado" name="correo_solicitado" type="email" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <label for="direccion_solicitado">Dirección </label>


                                    <input value="<?= set_value('direccion_solicitado') ?>" class="form-control" id="direccion_solicitado" name="direccion_solicitado" type="text" />

                                </div>

                            </div>
                        </div>
                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <label>Región: </label>
                                    <select onchange="mostrar(this.value, 'comuna2'); getText(this, 'region2h');" required class="form-control" name="region2" id="region2" required>
                                        <option value="">Selecciona</option>
                                    </select>
                                    <input type="hidden" id="region2h" name="region2h" value="" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Comuna: </label>
                                    <select onchange="getText(this, 'comuna2h');" required class="form-control" name="comuna2" id="comuna2">
                                        <option value="">Selecciona</option>
                                    </select>
                                    <input type="hidden" id="comuna2h" name="comuna2h" value="" />
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-3">
                        <h5 class="text-primary">Datos de los beneficiarios (hijos)
                            <input type="hidden" id="cuentaHijos" name="cuentaHijos" value="0" />
                        </h5>
                        <hr class="mt-1 mb-2">
                        <?php for ($i = 0; $i <= 5; $i++) { ?>
                            <div id="hijo<?= $i ?>"
                                <?php if ($i != 1) {
                                    echo 'style="display: none;"';
                                } else {
                                    echo 'style="display: block;"';
                                } ?>
                                class="form-group mt-4">


                                <div class="row">

                                    <div class="col-12 col-sm-4">
                                        <label>Nombre Completo: 
                                        <input
                                           
                                             value="<?= set_value('nombre' . $i) ?>" class="form-control" id="nombre<?= $i ?>" name="nombre<?= $i ?>" type="text" />
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <label>RUT:
                                        <input
                                            
                                            class="form-control rut" value="<?= set_value('rut' . $i) ?>" id="rut<?= $i ?>" name="rut<?= $i ?>" type="text" />
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <label>Fecha de Nacimiento:
                                        <input onchange="calcularEdad(this, edad<?= $i ?>)"
                                            
                                            class="form-control" value="<?= set_value('fecha' . $i) ?>" id="fecha<?= $i ?>" name="fecha<?= $i ?>" type="date" />
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <label>Edad: </label>
                                        <input readonly required class="form-control" value="" id="edad<?= $i ?>" name="edad<?= $i ?>" type="text" />
                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>
                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <button id="sumaHijo" class="btn btn-success" type="button"><i class="fas fa-plus"></i> Agregar Beneficiario</button>
                                </div>
                                <div class="col-12 col-sm-6">

                                </div>
                            </div>
                        </div>



                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <hr class="mt-1 mb-3">
                                    <h5 class="text-primary">Seleccione las materias a mediar
                                    </h5>
                                    <hr class="mt-1 mb-2">

                                    <?php $i = 0;
                                    foreach ($materias as $materia) { ?>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="materia<?= $i ?>" value="<?= $materia['id'] ?>" id="materia<?= $materia['id'] ?>" />
                                            <label class="form-check-label" for="materia<?= $i ?>"><?= $materia['nombre'] ?></label>
                                        </div>
                                    <?php $i++;
                                    } ?>


                                </div>

                                <div class="col-12 col-sm-6">
                                    <hr class="mt-1 mb-3">
                                    <h5 class="text-primary">Indique si existe causa vigente o denuncia por violencia intrafamiliar

                                    </h5>
                                    <hr class="mt-1 mb-2">

                                    <div class="form-radio">
                                        <input class="form-radio-input" type="radio" required name="violencia" value="1" id="violencia1" />
                                        <label class="form-radio-label" for="violencia1">Si</label>
                                    </div>
                                    <div class="form-radio">
                                        <input class="form-radio-input" checked type="radio" name="violencia" value="0" id="violencia2" />
                                        <label class="form-radio-label" for="violencia2">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-1 mb-3">
                        <h5 class="text-primary">Fecha y Hora Sesión Telemática de Mediación
                        </h5>
                        <hr class="mt-1 mb-2">

                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-3">
                                    <label>Fecha y Hora de Inicio: </label>
                                    <input readonly class="form-control" value="<?=$fecha_inicio?>" id="fecha" name="fecha" type="datetime" />
                                </div>
                                <div class="col-12 col-sm-3">
                                   <label>Fecha y Hora de Finalización: </label>
                                    <input readonly class="form-control" value="<?=$fecha_fin?>" id="fecha" name="fecha" type="datetime" />
                                </div>
                            </div>
                        </div>

                                        <hr class="mt-1 mb-3">
                <h5 class="text-primary">Datos Administrativos
                </h5>
                <hr class="mt-1 mb-2">

                <div class="form-group mb-4 mt-2">
                    <div class="row ">
                        <div class="col-12 col-sm-2">
                                    <label>Fecha y Hora de Inicio: </label>
                                    <input readonly class="form-control" value="<?=$fecha_inicio?>" id="fecha" name="fecha" type="datetime" />
                                </div>
<div class="col-12 col-sm-3">
                                   <label>Fecha y Hora de Finalización: </label>
                                    <input readonly class="form-control" value="<?=$fecha_fin?>" id="fecha" name="fecha" type="datetime" />
                                </div>
                        <div class="col-12 col-sm-2">
                            <label for="id_usuario">Mediador Asignado: </label>
                            <select class="form-control" name="id_usuario" id="id_usuario">
                                <option value="">Seleccione</option>
                                <?php foreach ($usuarios as $usuario) {
                                   
                                        echo '<option value="' . $usuario['id'] . '">' . $usuario['nombre'] . '</option>';
                                    
                                } ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="reservado">¿Reserva Espacio de Agenda General? </label>
                            <div class="form-radio">
                                <input class="form-radio-input"  type="radio" required name="reservado" value="1" id="reservado1" />
                                <label class="form-radio-label" for="reservado1">Si</label>
                            </div>
                            <div class="form-radio">
                                <input class="form-radio-input" checked type="radio" name="reservado" value="0" id="reservado2" />
                                <label class="form-radio-label" for="reservado2">No</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label>Valor Servicio </label>
                            <input class="form-control text-right" value="" id="valor" name="valor" type="number" />
                        </div>

                    </div>
                </div>

                        <div class="modal-footer">
                            <button id="enviar" type="submit" class="btn btn-primary btn-ok"><i class="fas fa-calendar-check"></i> Agendar</button>
                            <a href="<?=base_url().$redireccion?>" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</a>

                        </div>
                    </form>
       
</div>
</main>