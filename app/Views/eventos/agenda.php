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
                <div class="modal-body p-4">
                    <div class="text-info text-sm"><i class="fas fa-info"></i> Nuestro servicio de mediación privada le permite agendar mediación en un plazo máximo de 48 horas. Considerar que este servicio no es gratuito y tiene un costo asociado, un mediador se contactará para coordinar su día y hora de mediación.</div>
                    <form method="POST" action="<?= base_url() ?>/clientes/insertar" autocomplete="off">
                        <?= csrf_field() ?>
                        <div class="form-group mt-4">
                            <div class="">Datos Solicitante:</div>
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

<div class="form-group mt-4">
                            <div class="">Datos Solicitado:</div>
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



                        <div class="d-flex gap-3 justify-content-center align-items-center">
                            <a href="<?= base_url() ?>clientes" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Volver</a>
                            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Guardar</button>
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
                        $("#"+campo+"").append("<option value='" + key + "'>" + val['name'] + "</option>");

                    });

                    // haz cosas con tus datos json aquí... 
                })

        }
    </script>
</body>

</html>