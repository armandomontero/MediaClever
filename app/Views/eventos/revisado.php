<?php
?>
<main>
    <div class="container-fluid px-4">



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

        <div class="card-body">
            <form method="POST" action="<?= base_url() ?>eventos/notificar" autocomplete="off">
                <?= csrf_field() ?>
                <input type="hidden" name="fecha_bd" id="fecha_bd" value="" />
               <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="<?=$datos->fecha_inicio?>" />
                 <input type="hidden" name="fecha_fin" id="fecha_fin" value="<?=$datos->fecha_fin?>" />
                  <input type="hidden" name="nombre_mediador" id="nombre_mediador" value="<?=$datos->nombre_mediador?>" />
                   <input type="hidden" name="correo_mediador" id="correo_mediador" value="<?=$datos->correo_mediador?>" />

                <input type="hidden" name="id_evento" id="id_evento" value="<?= $datos->id_evento ?>" />
                <input type="hidden" name="id_solicitante" id="id_solicitante" value="<?= $datos->id_solicitante ?>" />
                <input type="hidden" name="id_solicitado" id="id_solicitado" value="<?= $datos->id_solicitado ?>" />
                <div class="form-group mt-1">
                    <h5 class="text-primary">Datos Solicitante:</h5>
                    <hr class="mt-1 mb-2">

                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label class="control-label">Nombre Completo</label>
                            <input readonly  value="<?= $datos->nombre_solicitante ?>" class="form-control" id="nombre_solicitante" name="nombre_solicitante" type="text" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label>RUT</label>
                            <input readonly class="form-control text-right" value="<?= $datos->rut_solicitante ?>" id="rut_solicitante" name="rut_solicitante" type="text" />
                        </div>

                        <div class="col-12 col-sm-3">
                            <label for="telefono_solicitante">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text"><img style="padding-right:5px;" width="25" src="<?= base_url() ?>img/chile.png" alt="chile">+56</span>
                                <input readonly  value="<?= $datos->telefono_solicitante ?>" class="form-control" id="telefono_solicitante" name="telefono_solicitante" type="number" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="correo_solicitante">E-Mail</label>
                            <input class="form-control" readonly value="<?= $datos->correo_solicitante ?>" id="correo_solicitante" name="correo_solicitante" type="email" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">

                        <div class="col-12 col-sm-5">

                            <label for="direccion_solicitante">Dirección</label>
                            <input readonly value="<?= $datos->direccion_solicitante ?>" class="form-control" id="direccion_solicitante" name="direccion_solicitante" type="text" />
                        </div>

                        <div class="col-12 col-sm-4">
                            <label for="region">Región </label>
                            <select disabled onchange="mostrar(this.value, 'comuna'); getText(this, 'region1h');" required class="form-control" name="region" id="region" required>
                                <option value="">Selecciona</option>
                                <option selected value=""><?= $datos->region_solicitante ?></option>
                            </select>
                            <input type="hidden" id="region1h" name="region1h" value="<?= $datos->region_solicitante ?>" />
                        </div>

                        <div class="col-12 col-sm-3">
                            <label for="comuna">Comuna </label>
                            <select disabled onchange="getText(this, 'comuna1h');" required class="form-control" name="comuna" id="comuna">
                                <option value="">Selecciona</option>
                                <option selected value=""><?= $datos->comuna_solicitante ?></option>
                            </select>
                            <input type="hidden" id="comuna1h" name="comuna1h" value="<?= $datos->comuna_solicitante ?>" />
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4 mt-2">
                    <div class="row ">


                    </div>
                </div>
                <hr class="mt-1 mb-3">
                <h5 class="text-primary">Datos Solicitado:</h5>
                <hr class="mt-1 mb-2">
                <div class="form-group mt-4">


                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label for="nombre_solicitado">Nombre Completo</label>
                            <input readonly autofocus value="<?= $datos->nombre_solicitado ?>" class="form-control" id="nombre_solicitado" name="nombre_solicitado" type="text" />
                        </div>
                        <div class="col-12 col-sm-2">
                            <label for="rut_solicitado">RUT </label>
                            <input readonly class="form-control text-right" value="<?= $datos->rut_solicitado ?>" id="rut_solicitado" name="rut_solicitado" type="text" />
                        </div>

                        <div class="col-12 col-sm-3">
                            <label for="telefono_solicitado">Teléfono </label>
                            <div class="input-group">
                                <span class="input-group-text"><img style="padding-right:5px;" width="25" src="<?= base_url() ?>img/chile.png" alt="chile">+56</span>
                                <input readonly  value="<?= $datos->telefono_solicitado ?>" class="form-control" id="telefono_solicitado" name="telefono_solicitado" type="number" />
                            </div>
                        </div>

                        <div class="col-12 col-sm-3">
                            <label for="correo_solicitado">E-Mail: </label>
                            <input readonly class="form-control" value="<?= $datos->correo_solicitado ?>" id="correo_solicitado" name="correo_solicitado" type="email" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">

                        <div class="col-12 col-sm-5">

                            <label for="direccion_solicitado">Dirección</label>
                            <input readonly value="<?= $datos->direccion_solicitado ?>" class="form-control" id="direccion_solicitado" name="direccion_solicitado" type="text" />
                        </div>


                        <div class="col-12 col-sm-4">
                            <label for="region2">Región: </label>
                            <select disabled onchange="mostrar(this.value, 'comuna2'); getText(this, 'region2h');" required class="form-control" name="region2" id="region2" required>
                                <option value="">Selecciona</option>
                                <option selected value=""><?= $datos->region_solicitado ?></option>
                            </select>
                            <input type="hidden" id="region2h" name="region2h" value="<?= $datos->region_solicitado ?>" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="comuna2">Comuna: </label>
                            <select disabled onchange="getText(this, 'comuna2h');" required class="form-control" name="comuna2" id="comuna2">
                                <option value="">Selecciona</option>
                                <option selected value=""><?= $datos->comuna_solicitado ?></option>
                            </select>
                            <input type="hidden" id="comuna2h" name="comuna2h" value="<?= $datos->comuna_solicitado ?>" />
                        </div>
                    </div>
                </div>
<div id="oculto" class="d-none">
                <div class="form-group mb-4 mt-2">
                    <div class="row ">

                    </div>
                </div>
                <hr class="mt-1 mb-3">
                <h5 class="text-primary">Datos de los beneficiarios (hijos)

                </h5>
                <hr class="mt-1 mb-2">

                <?php $i = 1;
                foreach ($hijos as $hijo) {
                ?>
                    <div id="hijo<?= $i ?>"

                        class="form-group mt-4">


                        <div class="row">

                            <div class="col-12 col-sm-4">
                                <label>Nombre Completo: </label>
                                <input
                                    
                                     value="<?= $hijo['nombre'] ?>" class="form-control" id="nombre<?= $i ?>" name="nombre<?= $i ?>" type="text" />
                            </div>
                            <div class="col-12 col-sm-3">
                                <label>RUT: </label>
                                <input
                                  
                                    class="form-control rut" value="<?= $hijo['rut'] ?>" id="rut<?= $i ?>" name="rut<?= $i ?>" type="text" />
                            </div>
                            <div class="col-12 col-sm-3">
                                <label>Fecha de Nacimiento:<?php if ($i == 1) {
                                                                echo '<span class="text-danger">*</span>';
                                                            } ?> </label>
                                <input onchange="calcularEdad(this, edad<?= $i ?>)"
                                    <?php if ($i == 1) {
                                        echo 'required';
                                    } ?>
                                    class="form-control" value="<?= $hijo['fecha_nac'] ?>" id="fecha<?= $i ?>" name="fecha<?= $i ?>" type="date" />
                            </div>
                            <div class="col-12 col-sm-2">
                                <label>Edad: </label>
                                <input readonly required class="form-control" value="<?= $hijo['edad'] ?>" id="edad<?= $i ?>" name="edad<?= $i ?>" type="text" />
                            </div>
                        </div>
                    </div>
                <?php $i++;
                }
                ?>
                <input type="hidden" id="cuentaHijos" name="cuentaHijos" value="<?= $i - 1 ?>" />
                <?php for ($i = $i; $i <= 6; $i++) { ?>
                    <div id="hijo<?= $i ?>"
                        style="display: none;"

                        class="form-group mt-4">


                        <div class="row">

                            <div class="col-12 col-sm-4">
                                <label>Nombre Completo: </label>
                                <input
                                
                                    autofocus value="<?= set_value('nombre' . $i) ?>" class="form-control" id="nombre<?= $i ?>" name="nombre<?= $i ?>" type="text" />
                            </div>
                            <div class="col-12 col-sm-3">
                                <label>RUT: </label>
                                <input
                                   
                                    class="form-control rut" value="<?= set_value('rut' . $i) ?>" id="rut<?= $i ?>" name="rut<?= $i ?>" type="text" />
                            </div>
                            <div class="col-12 col-sm-3">
                                <label>Fecha de Nacimiento: </label>
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
                            <hr class="mt-1 mb-3">
                            <h5 class="text-primary">Materias a mediar
                            </h5>
                            <hr class="mt-1 mb-2">

                            <?php $i = 0;
                            foreach ($materias as $materia) {

                                $checked = false;
                                foreach ($eventos_materias as $evento_materia) {
                                    if ($materia['id'] == $evento_materia['id_materia']) {
                                        $checked = true;
                                    }
                                }
                            ?>

                                <div class="form-check">
                                    <input class="form-check-input" <?php if ($checked == true) {
                                                                        echo 'checked';
                                                                    } ?> type="checkbox" name="materia<?= $i ?>" value="<?= $materia['id'] ?>" id="materia<?= $materia['id'] ?>" />
                                    <label class="form-check-label" for="materia<?= $materia['id'] ?>"><?= $materia['nombre'] ?></label>
                                </div>
                            <?php $i++;
                            } ?>


                        </div>

                        <div class="col-12 col-sm-6">
                            <hr class="mt-1 mb-3">
                            <h5 class="text-primary">Existe causa vigente o denuncia por violencia intrafamiliar *

                            </h5>
                            <hr class="mt-1 mb-2">

                            <div class="form-radio">
                                <input class="form-radio-input" <?php if ($datos->causa == 1) {
                                                                    echo 'checked';
                                                                } ?> type="radio" required name="violencia" value="1" id="violencia1" />
                                <label class="form-radio-label" for="violencia1">Si</label>
                            </div>
                            <div class="form-radio">
                                <input class="form-radio-input" <?php if ($datos->causa == 0) {
                                                                    echo 'checked';
                                                                } ?> type="radio" name="violencia" value="0" id="violencia2" />
                                <label class="form-radio-label" for="violencia2">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-1 mb-3">
                <h5 class="text-primary">Datos Administrativos
                </h5>
                <hr class="mt-1 mb-2">

                <div class="form-group mb-4 mt-2">
                    <div class="row ">
                        <div class="col-12 col-sm-3">
                            <label>Fecha de Sesión: </label>
                            <input class="form-control" required value="<?= $datos->fecha_inicio ?>" id="fecha" name="fecha" type="datetime-local" />
                        </div>

                        <div class="col-12 col-sm-4">
                            <label for="id_usuario">Mediador Asignado: </label>
                            <select class="form-control" name="id_usuario" id="id_usuario">
                                <option value="">Seleccione</option>
                                <?php foreach ($usuarios as $usuario) {
                                    if ($usuario['id'] == $datos->id_usuario) {
                                        echo '<option selected value="' . $usuario['id'] . '">' . $usuario['nombre'] . '</option>';
                                    } elseif ($usuario['id'] == $user_activo) {
                                        echo '<option selected value="' . $usuario['id'] . '">' . $usuario['nombre'] . '</option>';
                                    } else {
                                        echo '<option value="' . $usuario['id'] . '">' . $usuario['nombre'] . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="reservado">¿Reserva Espacio de Agenda? </label>
                            <div class="form-radio">
                                <input class="form-radio-input" <?php if ($datos->reservado == 1) {
                                                                    echo 'checked';
                                                                } ?> type="radio" required name="reservado" value="1" id="reservado1" />
                                <label class="form-radio-label" for="reservado1">Si</label>
                            </div>
                            <div class="form-radio">
                                <input class="form-radio-input" <?php if ($datos->reservado == 0) {
                                                                    echo 'checked';
                                                                } ?> type="radio" name="reservado" value="0" id="reservado2" />
                                <label class="form-radio-label" for="reservado2">No</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <label>Valor Servicio </label>
                            <input class="form-control text-right" value="<?= $datos->valor ?>" id="valor" name="valor" type="number" />
                        </div>

                    </div>
                </div>
                </div>
<button type="button" id="detalles" class="btn btn-sm btn-secondary">Ver Detalles</button>
                    <button type="button" id="detallesNo" class="btn d-none btn-sm mr-auto btn-secondary">Ocultar Detalles</button>
                <div class="modal-footer">
                    
                    <a href="<?= base_url() ?>eventos/updEstado/<?=$datos->id_evento?>/Agendado" id="editar" class="btn mr-auto btn-warning"><i class="far fa-pencil"></i> Volver y Editar</a>
                    <button type="submit" class="btn btn-success btn-ok"><i class="fas fa-check-double"></i> Notificar Mediación</button>
                    <a href="<?= base_url() ?>eventos" class="btn btn-primary btn-ok"><i class="fas fa-calendar-check"></i> Volver al Calendario</a>

                </div>
            </form>
        </div>
    </div>
</main>

<!-- rut chileno -->
<script src="<?= base_url() ?>js/jquery.rut.js"></script>

<script>
    fetch('<?= base_url() ?>json/regiones.json')
        .then(res => res.json())
        .then(data => {
            //console.log(data);
            // alert(data);
            $.each(data['regions'], function(key, val) {
                $("#region").append("<option value='" + key + "'>" + val['name'] + "</option>");
                $("#region2").append("<option value='" + key + "'>" + val['name'] + "</option>");

            });



            // haz cosas con tus datos json aquí... 
        })


    function mostrar(region, campo) {
        $("#" + campo).find('option').not(':first').remove();
        fetch('<?= base_url() ?>json/regiones.json')
            .then(res => res.json())
            .then(data => {
                $.each(data['regions'][region]['communes'], function(key, val) {
                    $("#" + campo + "").append("<option value='" + key + "'>" + val['name'] + "</option>");

                });

                // haz cosas con tus datos json aquí... 
            })

    }

    $("#sumaHijo").click(function() {
        let cuenta_hijos = parseInt($("#cuentaHijos").val()) + 1;
        $("#hijo" + cuenta_hijos).css("display", "block");
        $("#cuentaHijos").val(cuenta_hijos);
    });

    $("#restaHijo").click(function() {
        let cuenta_hijos = parseInt($("#cuentaHijos").val());
        $("#nombre" + cuenta_hijos).val('');
        $("#rut" + cuenta_hijos).val('');
        $("#fecha" + cuenta_hijos).val('');
        $("#hijo" + cuenta_hijos).css("display", "none");
        $("#cuentaHijos").val(cuenta_hijos - 1);
    });


    function calcularEdad(campoFecha, campoEdad) {
        // Si la fecha es correcta, calculamos la edad
        var fecha = new Date(campoFecha.value);
        // alert(fecha)


        // var values = fecha.split("-");
        var dia = fecha.getDate();
        var mes = fecha.getMonth();
        var ano = fecha.getYear();
        //alert(ano);
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth();
        var ahora_dia = fecha_hoy.getDate();

        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad >= 1900) {
            edad -= 1900;
        }

        // calculamos los meses
        var meses = 0;

        if (ahora_mes > mes && dia > ahora_dia)
            meses = ahora_mes - mes - 1;
        else if (ahora_mes > mes)
            meses = ahora_mes - mes
        if (ahora_mes < mes && dia < ahora_dia)
            meses = 12 - (mes - ahora_mes);
        else if (ahora_mes < mes)
            meses = 12 - (mes - ahora_mes + 1);
        if (ahora_mes == mes && dia > ahora_dia)
            meses = 11;

        // calculamos los dias
        var dias = 0;
        if (ahora_dia > dia)
            dias = ahora_dia - dia;
        if (ahora_dia < dia) {
            ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
        }
        edadFinal = dias + " días";

        if (meses > 1) {
            edadFinal = meses + " meses";
        }
        if (edad >= 1) {
            edadFinal = edad + " años";
        }
        campoEdad.value = edadFinal;
    }


    function esNumero(strNumber) {
        if (strNumber == null) return false;
        if (strNumber == undefined) return false;
        if (typeof strNumber === "number" && !isNaN(strNumber)) return true;
        if (strNumber == "") return false;
        if (strNumber === "") return false;
        var psInt, psFloat;
        psInt = parseInt(strNumber);
        psFloat = parseFloat(strNumber);
        return !isNaN(strNumber) && !isNaN(psFloat);
    }


    function getText(campoIn, campoOut) {
        document.getElementById(campoOut).value = $(campoIn).children(':selected').text();
    }

    $("#rut_solicitante").rut({
            formatOn: 'keyup',
            validateOn: 'keyup'
        })
        .on('rutInvalido', function() {})
        .on('rutValido', function() {});

    $("#rut_solicitante").change(function() {

        if (!$.validateRut($("#rut_solicitante").val())) {
            alert('El RUT ingresado no es válido, favor revisar');
            $("#rut_solicitante").val('');
            $("#rut_solicitante").select();
            $("#rut_solicitante").focus();


        }
    });



    $("#rut_solicitado").rut({
            formatOn: 'keyup',
            validateOn: 'keyup'
        })
        .on('rutInvalido', function() {})
        .on('rutValido', function() {});


    $("#rut_solicitado").change(function() {

        if (!$.validateRut($("#rut_solicitado").val())) {
            alert('El RUT ingresado no es válido, favor revisar');
            $("#rut_solicitado").val('');
            $("#rut_solicitado").select();
            $("#rut_solicitado").focus();


        }
    });


    <?php for ($i = 1; $i <= 6; $i++) { ?>
        $("#rut<?= $i ?>").rut({
                formatOn: 'keyup',
                validateOn: 'keyup'
            })
            .on('rutInvalido', function() {})
            .on('rutValido', function() {});


        $("#rut<?= $i ?>").change(function() {

            if (!$.validateRut($("#rut<?= $i ?>").val())) {
                alert('El RUT ingresado no es válido, favor revisar');
                $("#rut<?= $i ?>").val('');
                $("#rut<?= $i ?>").select();
                $("#rut<?= $i ?>").focus();


            }
        });
    <?php } ?>


    $("#detalles").click(function(){
        $('#oculto').removeClass('d-none');
        $('#detallesNo').removeClass('d-none');
        $("#detalles").addClass('d-none');
    });

        $("#detallesNo").click(function(){
        $('#oculto').addClass('d-none');
        $('#detallesNo').addClass('d-none');
        $("#detalles").removeClass('d-none');
    });
</script>