<html lang="es">

<head>
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

</head>

<body>
    <!-- Begin Page Content -->
    <main>
        <div class="container-fluid">



            <div id='calendar'></div>

        </div>
    </main>

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
                    <form method="POST" action="<?= base_url() ?>/clientes/insertar" autocomplete="off">
                        <?= csrf_field() ?>
                        <div class="form-group mt-4">
                            <h5 class="text-primary">Datos Solicitante:</h5>
                            <hr class="mt-1 mb-2">

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Nombre Completo: </label>
                                    <input required autofocus value="<?= set_value('nombre') ?>" class="form-control" id="nombre" name="nombre" type="text" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>RUT: </label>
                                    <input required class="form-control" value="<?= set_value('direccion') ?>" id="direccion" name="direccion" type="text" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Teléfono: </label>
                                    <input required autofocus value="<?= set_value('telefono') ?>" class="form-control" id="telefono" name="telefono" type="text" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>E-Mail: </label>
                                    <input class="form-control" value="<?= set_value('correo') ?>" id="correo" name="correo" type="email" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <label>Región: </label>
                                    <select onchange="mostrar(this.value, 'comuna');" required class="form-control" name="region" id="region" required>
                                        <option value="">Selecciona</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Comuna: </label>
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
                                    <label>Nombre Completo: </label>
                                    <input required autofocus value="<?= set_value('nombre') ?>" class="form-control" id="nombre2" name="nombre2" type="text" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>RUT: </label>
                                    <input required class="form-control" value="<?= set_value('direccion') ?>" id="rut2" name="rut2" type="text" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Teléfono: </label>
                                    <input required autofocus value="<?= set_value('telefono2') ?>" class="form-control" id="telefono2" name="telefono2" type="text" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>E-Mail: </label>
                                    <input class="form-control" value="<?= set_value('correo2') ?>" id="correo2" name="correo2" type="email" />
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
                            <input type="hidden" id="cuentaHijos" name="cuentaHijos" value="1"/>
                        </h5>
                        <hr class="mt-1 mb-2">
                        <?php for($i = 1; $i<=6; $i++){ ?>
                        <div id="hijo<?=$i?>"
                        <?php if($i!=1){
                        echo 'style="display: none;"';
                        }else{
                            echo 'style="display: block;"';
                        } ?>
                         class="form-group mt-4">

                    
                            <div  class="row">
                               
                                <div class="col-12 col-sm-4">
                                    <label>Nombre Completo: </label>
                                    <input required autofocus value="<?= set_value('nombre1') ?>" class="form-control" id="nombre1" name="nombre1" type="text" />
                                </div>
                                <div class="col-12 col-sm-3">
                                    <label>RUT: </label>
                                    <input required class="form-control" value="<?= set_value('rut1') ?>" id="rut1" name="rut2" type="text" />
                                </div>
                                <div class="col-12 col-sm-3">
                                    <label>Fecha de Nacimiento: </label>
                                    <input required class="form-control" value="<?= set_value('direccion') ?>" id="rut2" name="rut2" type="date" />
                                </div>
                                <div class="col-12 col-sm-2">
                                    <label>Edad: </label>
                                    <input required class="form-control" value="<?= set_value('direccion') ?>" id="rut2" name="rut2" type="text" />
                                </div>
                            </div>
                        </div>
                        <?php }
                        ?>
<div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <button id="sumaHijo" class="btn btn-success" type="button">Agregar Beneficiario</button>
                                </div>
                                <div class="col-12 col-sm-6">
                                    
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a type="button" class="btn btn-danger btn-ok">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                allDaySlot: false,
                slotMinTime: "08:00:00",
                slotMaxTime: "19:30:00",
                locale: "esLocale",
                firstDay: 1,
                selectable: true,
                themeSystem: 'bootstrap',
                buttonText: {
                    today: 'Hoy',
                    month: 'month',
                    week: 'week',
                    day: 'day',
                    list: 'list'
                },

                dateClick: function(info) {

                    $("#modal-formulario").modal('show');
                    alert('Date: ' + info.dateStr);
                    // alert('Resource ID: ' + info.resource.id);
                }

            });
            calendar.render();
        });



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
            $("#comuna").find('option').not(':first').remove();
            fetch('<?= base_url() ?>json/regiones.json')
                .then(res => res.json())
                .then(data => {
                    $.each(data['regions'][region]['communes'], function(key, val) {
                        $("#" + campo + "").append("<option value='" + key + "'>" + val['name'] + "</option>");

                    });

                    // haz cosas con tus datos json aquí... 
                })

        }

        $("#sumaHijo").click(function(){
            let cuenta_hijos = parseInt($("#cuentaHijos").val())+1;
            $("#hijo"+cuenta_hijos).css("display", "block");
            $("#cuentaHijos").val(cuenta_hijos);
        });
    </script>
</body>

</html>