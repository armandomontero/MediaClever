<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Media Clever - Agenda</title>

    <!-- Custom fonts for this template-->
    <link rel="icon" type="image/vnd.icon" href="<?= base_url() ?>favicon.ico" />
    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>css/sb-admin-2.css" rel="stylesheet" />
    <!-- Jquery-Ui -->
    <link href="<?= base_url() ?>js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

    <link href="<?= base_url() ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <!--Jquery y JQuery-Ui -->
    <script src="<?= base_url() ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>js/jquery-ui/jquery-ui.min.js"></script>

    <!-- Bootstrap core JavaScript-->

    <script src="<?= base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!--Charts -->
    <script src="<?= base_url() ?>js/chart.js"></script>

    <!--fullcalandar-->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script>

    <!-- rut chileno -->
    <script src="js/jquery.rut.js"></script>

    <style>
        .fc-bg-event {

            z-index: 1 !important;
            background-color: #000000 !important;
            pointer-events: none !important;
        }

        .fc-event {
            background-color: #9e9f9b !important;
            width: 100% !important;
            /* Force full width */
            left: 0 !important;
            /* Ensure it starts at the left edge */
        }

        .fc-timegrid-event {
            position: relative;
            width: 103% !important;
            /* Force full width */
            left: 0px !important;
            right: 0px !important;
            /* Ensure it starts at the left edge */
        }
    </style>
</head>

<body>
    <!-- Begin Page Content -->
    <main>
        <div class="container-fluid">



            <div id='calendar'></div>

        </div>
    </main>


    <!-- Modal confirmación -->
    <div class="modal fade" id="modal-alerta" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Atención</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="text-alerta"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-alerta-formulario" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Atención</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="text-alert-form">El RUT ingresado no es</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="ok_form" class="btn btn-danger" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal formulario -->
    <div class="modal fade" id="modal-formulario" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar Mediación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4 pl-4 ml-4 mr-4">
                    <div style="background-color: #e6f2ff; color: blue; border: 1px solid #dee2e6;" class="rounded text-sm p-3 "><i class="fas fa-info mr-2"></i>
                        Nuestro servicio de mediación privada le permite agendar mediación en un plazo máximo de <b>48 horas</b>. Considerar que este servicio
                        <b>no es gratuito</b> y tiene un costo asociado, un mediador se contactará para coordinar su día y hora de mediación.
                    </div>
                    <form method="POST" action="<?= base_url() ?>eventos/agendar" autocomplete="off">
                        <?= csrf_field() ?>
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
                                    <span class="input-group-text"><img style="padding-right:5px;" width="25" src="<?=base_url()?>img/chile.png" alt="chile">+56</span>
                                    <input required autofocus value="<?= set_value('telefono_solicitante') ?>" class="form-control" id="telefono_solicitante" name="telefono_solicitante" type="number" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>E-Mail<span class="text-danger">*</span> </label>
                                    <input class="form-control" value="<?= set_value('correo_solicitante') ?>" id="correo_solicitante" name="correo_solicitante" type="email" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <label>Región </label>
                                    <select onchange="mostrar(this.value, 'comuna');" required class="form-control" name="region" id="region" required>
                                        <option value="">Selecciona</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Comuna </label>
                                    <select required class="form-control" name="comuna" id="comuna">
                                        <option value="">Selecciona</option>
                                    </select>
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
                                    <span class="input-group-text"><img style="padding-right:5px;" width="25" src="<?=base_url()?>img/chile.png" alt="chile">+56</span>
                                    <input required autofocus value="<?= set_value('telefono_solicitado') ?>" class="form-control" id="telefono_solicitado" name="telefono_solicitado" type="number" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>E-Mail: </label>
                                    <input class="form-control" value="<?= set_value('correo_solicitado') ?>" id="correo_solicitado" name="correo_solicitado" type="email" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <label>Región: </label>
                                    <select onchange="mostrar(this.value, 'comuna2');" required class="form-control" name="region2" id="region2" required>
                                        <option value="">Selecciona</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Comuna: </label>
                                    <select required class="form-control" name="comuna2" id="comuna2">
                                        <option value="">Selecciona</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-3">
                        <h5 class="text-primary">Datos de los beneficiarios (hijos)
                            <input type="hidden" id="cuentaHijos" name="cuentaHijos" value="1" />
                        </h5>
                        <hr class="mt-1 mb-2">
                        <?php for ($i = 1; $i <= 6; $i++) { ?>
                            <div id="hijo<?= $i ?>"
                                <?php if ($i != 1) {
                                    echo 'style="display: none;"';
                                } else {
                                    echo 'style="display: block;"';
                                } ?>
                                class="form-group mt-4">


                                <div class="row">

                                    <div class="col-12 col-sm-4">
                                        <label>Nombre Completo:  <?php if($i==1){echo '<span class="text-danger">*</span>';} ?></label>
                                        <input 
                                        <?php if($i==1){echo 'required';} ?>
                                        autofocus value="<?= set_value('nombre' . $i) ?>" class="form-control" id="nombre<?= $i ?>" name="nombre<?= $i ?>" type="text" />
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <label>RUT:<?php if($i==1){echo '<span class="text-danger">*</span>';} ?> </label>
                                        <input 
                                        <?php if($i==1){echo 'required';} ?>
                                        class="form-control rut" value="<?= set_value('rut' . $i) ?>" id="rut<?= $i ?>" name="rut<?= $i ?>" type="text" />
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <label>Fecha de Nacimiento:<?php if($i==1){echo '<span class="text-danger">*</span>';} ?> </label>
                                        <input onchange="calcularEdad(this, edad<?= $i ?>)"
                                        <?php if($i==1){echo 'required';} ?>
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
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alimentos" value="" id="alimentos" />
                                        <label class="form-check-label" for="alimentos">Alimentos</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alimentos_aumento" value="" id="alimentos_aumento" />
                                        <label class="form-check-label" for="alimentos_aumento">Alimentos Aumento</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alimentos_rebaja" value="" id="alimentos_rebaja" />
                                        <label class="form-check-label" for="alimentos_rebaja">Alimentos Rebaja</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="deuda_alimentos" value="" id="deuda_alimentos" />
                                        <label class="form-check-label" for="deuda_alimentos">Deuda por Pensión de Alimentos</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cese_alimentos" value="" id="cese_alimentos" />
                                        <label class="form-check-label" for="cese_alimentos">Cese Alimentos</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cuidado_personal" value="" id="cuidado_personal" />
                                        <label class="form-check-label" for="cuidado_personal">Cuidado Personal del Niño</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cuidado_modifica" value="" id="cuidado_modifica" />
                                        <label class="form-check-label" for="cuidado_modifica">Cuidado Personal Modificación</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="relacion_directa" value="" id="relacion_directa" />
                                        <label class="form-check-label" for="relacion_directa">Relación Directa y Regular (Visitas)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="relacion_modifica" value="" id="relacion_modifica" />
                                        <label class="form-check-label" for="relacion_modifica">Relación Directa y Regular (Modificación)</label>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <hr class="mt-1 mb-3">
                                    <h5 class="text-primary">Indique si existe causa vigente o denuncia por violencia intrafamiliar *

                                    </h5>
                                    <hr class="mt-1 mb-2">

                                    <div class="form-radio">
                                        <input class="form-radio-input" type="radio" required name="violencia" value="si" id="violencia1" />
                                        <label class="form-radio-label" for="violencia1">Si</label>
                                    </div>
                                    <div class="form-radio">
                                        <input class="form-radio-input" type="radio" name="violencia" value="no" id="violencia2" />
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
                                    <label>Fecha de Sesión: </label>
                                    <input required class="form-control" value="" id="fecha" name="fecha" type="datetime" />
                                </div>
                                <div class="col-12 col-sm-6">
<div style="background-color: #e6f2ff; color: blue; border: 1px solid #dee2e6;" class="form-check mb-3 rounded text-sm p-3">
        <input class="form-check-input ml-2" type="checkbox" value="" id="acepto" required="">
        <label class="form-check-label ml-4" for="acepto"><b>NO AGENDES</b> sin estar en conocimiento de que el servicio de mediación está asociado a un cobro.</label>
      </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-ok"><i class="fas fa-calendar-check"></i> Agendar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div style="position: absolute; top:10%; right:30%;" class="toast  m-2" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Atención</strong>
            <small></small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body alert alert-danger">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'timeGridWeek',
                slotEventOverlap: false,


                allDaySlot: false,
                slotMinTime: "09:00:00",
                slotMaxTime: "20:00:00",
                locale: "esLocale",
                firstDay: 1,
                //initialDate: '2025-08-22', 
                expandRows: true,
                height: '90%',

                selectable: false,
                slotDuration: '01:00', // 2 hours
                themeSystem: 'bootstrap',
                buttonText: {
                    today: 'Hoy',
                    month: 'month',
                    week: 'week',
                    day: 'day',
                    list: 'list'
                },
                displayEventEnd: true,
                dateClick: function(info) {
                    let ahora = new Date();
                    //alert(ahora);
                    //alert(info.date);
                    if (info.date <= ahora) {
                        $("#text-alerta").html('No se puede agendar para un horario anterior a la fecha y hora actual, por favor seleccione una fecha y horario posterior.');
                        $("#modal-alerta").modal('show');
                    } else {
                        let date_selected = info.date.toLocaleString("es-ES");
                        //alert(info);
                        $("#modal-formulario").modal('show');
                        // const opciones = { year: 'numeric', month: '2-digit', day: '2-digit' };


                        // alert(date_selected);
                        // alert('Date: ' + info.dateStr);
                        $("#fecha").val(date_selected);
                    }
                    // alert('Resource ID: ' + info.resource.id);
                },
                events: [{ // this object will be "parsed" into an Event Object

                        start: '2025-08-22T10:00:00',
                        end: '2025-08-22T11:00:00',
                        overlap: false,
                        display: 'background',
                        color: '#ff9f89'
                    },
                    { // this object will be "parsed" into an Event Object

                        start: '2025-08-22T11:00:00',
                        end: '2025-08-22T12:00:00',
                        overlap: true,
                        // display: 'block',
                        color: '#9e9f9b',
                        textColor: '#9e9f9b'
                    }
                ],
                selectOverlap: false,
                eventOverlap: false,
                slotEventOverlap: false,
                eventClick: function(info) {



                    // change the border color just for fun
                    //info.el.style.borderColor = 'red';
                },


            });
            calendar.render();
        });



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
         $("#rut<?=$i?>").rut({
                formatOn: 'keyup',
                validateOn: 'keyup'
            })
            .on('rutInvalido', function() {})
            .on('rutValido', function() {});
            

        $("#rut<?=$i?>").change(function() {

            if (!$.validateRut($("#rut<?=$i?>").val())) {
                alert('El RUT ingresado no es válido, favor revisar');
                $("#rut<?=$i?>").val('');
                $("#rut<?=$i?>").select();
                $("#rut<?=$i?>").focus();


            }
        });

        <?php } ?>

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
            $("#"+campo).find('option').not(':first').remove();
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

        $(document).ready(function() {

            $(".fc-timegrid-event").css('width', '100% !important');

            $(".fc-timegrid-bg-harness").click(function(event) {
                alert('pq no funca');
                $(".fc-timegrid-bg-harness").css('pointerEvents', 'none');
                event.preventDefault();
            });
        });


        function calcularEdad(campoFecha, campoEdad) {
        // Si la fecha es correcta, calculamos la edad
            var fecha = new Date(campoFecha.value);
           // alert(fecha)
       

       // var values = fecha.split("-");
        var dia = fecha.getDate();
        var mes = fecha.getMonth();
        var ano =fecha.getYear();
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

if( meses>1){
    edadFinal = meses + " meses";
}
if(edad>=1){
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
    </script>
</body>

</html>