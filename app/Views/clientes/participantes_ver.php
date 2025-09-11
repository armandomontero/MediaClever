<?php
helper('number');

?>
<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

        <!-- Page Heading -->
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>






        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="bg-primary text-light">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>

                                <th>Teléfono</th>
                                <th>E-mail</th>
                                <th>Tipo</th>
                         

                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-primary text-light">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Dirección</th>

                                <th>Teléfono</th>
                                <th>E-mail</th>
                                <th>Tipo</th>
                            
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($datos as $dato) {

                            ?>
                                <tr>
                                    <td><?php echo $dato['id']; ?></td>
                                    <td><?php echo $dato['nombre']; ?></td>
                                    <td><?php echo $dato['direccion']; ?></td>

                                    <td><?php echo $dato['telefono']; ?></td>
                                    <td><a href="mailto:<?= $dato['correo'] ?>" target="_blank"><?php echo $dato['correo']; ?></a></td>
                                    <td>
                                        <?php if ($dato['tipo'] == '0') {
                                            echo 'Solicitante';
                                        } ?>
                                        <?php if ($dato['tipo'] == '1') {
                                            echo 'Solicitado';
                                        } ?>

                                    </td>

                                   

                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 justify-content-center align-items-center">
            <a href="<?= base_url() ?>eventos/getEvento/<?= $id_evento ?>" class="btn btn-primary mr-2"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </div>
</main>


<div id="spinner" class="spinner-overlay  d-none">
    <div class="spinner-border text-primary" role="status">
        <span class="">Procesando...</span>
    </div>
    <span class="">Procesando...</span>
</div>

<!-- Modal confirmación -->
<div class="modal fade" id="modal-confirma" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar el registro?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a type="button" class="btn btn-danger btn-ok">Eliminar</a>
            </div>
        </div>
    </div>
</div>

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



    function mostrarSelected(region, campo, seleccion) {
        $("#" + campo).find('option').not(':first').remove();
        fetch('<?= base_url() ?>json/regiones.json')
            .then(res => res.json())
            .then(data => {
                $.each(data['regions'][region]['communes'], function(key, val) {
                    $("#" + campo + "").append("<option value='" + key + "'>" + val['name'] + "</option>");

                });

                // haz cosas con tus datos json aquí... 
                $("#" + campo).val(seleccion);
            })



    }

    $("#rut").rut({
            formatOn: 'keyup',
            validateOn: 'keyup'
        })
        .on('rutInvalido', function() {})
        .on('rutValido', function() {});


    $("#rut").change(function() {

        if (!$.validateRut($("#rut").val())) {
            alert('El RUT ingresado no es válido, favor revisar');
            $("#rut").val('');
            $("#rut").select();
            $("#rut").focus();


        }
    });


    function getText(campoIn, campoOut) {
        document.getElementById(campoOut).value = $(campoIn).children(':selected').text();
    }

    function llamaParticipante(id) {
        $("#spinner").removeClass('d-none');
        $("#alert-mensaje").addClass('d-none');
        $.ajax({
            url: '<?= base_url() ?>clientes/getParticipanteByID/' + id,
            dataType: 'json',
            success: function(resultado) {
                if (resultado == 0) {
                    alert('No hay datos');
                    $("#spinner").addClass('d-none');
                } else {


                    if (resultado.existe) {

                        $("#rut").val(resultado.datos.rut);
                        $("#nombre").val(resultado.datos.nombre);

                        $("#telefono").val(resultado.datos.telefono);
                        $("#correo").val(resultado.datos.correo);
                        $("#direccion").val(resultado.datos.direccion);
                        $("#region").append($('<option>', {
                            value: resultado.datos.region,
                            text: resultado.datos.region
                        }));
                        $("#region").val(resultado.datos.region);
                         $("#region1h").val(resultado.datos.region);

                          $("#comuna").append($('<option>', {
                            value: resultado.datos.comuna,
                            text: resultado.datos.comuna
                        }));
                        $("#comuna").val(resultado.datos.comuna);
                         $("#comuna1h").val(resultado.datos.comuna);


                        // mostrarSelected(resultado.datos.region, 'comuna', resultado.datos.comuna);


                        if (resultado.datos.tipo == 0) {
                            $("#tipo0").prop("checked", true);
                        }
                        if (resultado.datos.tipo == 1) {
                            $("#tipo1").prop("checked", true);
                        }

                        $("#id_cliente").val(resultado.datos.id_cliente);
                        $("#id_participa").val(resultado.datos.id);

                        $("#spinner").addClass('d-none');
                    } else {
                        $("#id_producto").val('');
                        $("#nombre").val('');
                        $("#cantidad").val('');
                        $("#precio").val('');
                        $("#subtotal").val('');
                        $("#spinner").addClass('d-none');
                    }
                }
            }
        })

    }
</script>