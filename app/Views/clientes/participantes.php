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

        <div class="card-body mt-0">
            <form method="POST" action="<?= base_url() ?>clientes/addParticipante" autocomplete="off">
                <?= csrf_field() ?>
                <input type="hidden" name="id_evento" id="id_evento" value="<?= $id_evento ?>" />
                <div class="form-group mt-1">
                    <h5 class="text-primary text-sm">Ingrese los Datos:</h5>
                    <hr class="mt-1 mb-2">

                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <label>RUT<span class="text-danger">*</span> </label>
                            <input required autofocus class="form-control text-right" value="" id="rut" name="rut" type="text" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="control-label">Nombre Completo<span class="text-danger">*</span> </label>
                            <input required  value="" class="form-control" id="nombre" name="nombre" type="text" />
                        </div>


                        <div class="col-12 col-sm-3">
                            <label>Teléfono<span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-text"><img style="padding-right:5px;" width="25" src="<?= base_url() ?>img/chile.png" alt="chile">+56</span>
                                <input required autofocus value="" class="form-control" id="telefono" name="telefono" type="number" />
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <label for="correo_solicitante">E-Mail<span class="text-danger">*</span> </label>
                            <input required class="form-control" value="" id="correo" name="correo" type="email" />
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">

                        <div class="col-12 col-sm-3">

                            <label for="direccion_solicitante">Dirección </label>
                            <input value="" class="form-control" id="direccion" name="direccion" type="text" />
                        </div>

                        <div class="col-12 col-sm-3">
                            <label for="region">Región <span class="text-danger">*</span> </label>
                            <select onchange="mostrar(this.value, 'comuna'); getText(this, 'region1h');" required class="form-control" name="region" id="region" required>
                                <option value="">Selecciona</option>
                            </select>
                            <input type="hidden" id="region1h" name="region1h" value="" />

                        </div>

                        <div class="col-12 col-sm-3">
                            <label>Comuna <span class="text-danger">*</span> </label>
                            <select onchange="getText(this, 'comuna1h');" required class="form-control" name="comuna" id="comuna">
                                <option value="">Selecciona</option>
                            </select>
                            <input type="hidden" id="comuna1h" name="comuna1h" value="" />

                        </div>

                        <div class="col-12 col-sm-3">
                            <label for="tipo">Tipo de participante <span class="text-danger">*</span> </label>
                            <div class="form-radio">
                                <input required class="form-radio-input" type="radio" required name="tipo" value="0" id="tipo0" />
                                <label class="form-radio-label mr-2" for="tipo0">Solicitante</label>
                                <input required class="form-radio-input" type="radio" required name="tipo" value="1" id="tipo1" />
                                <label class="form-radio-label" for="tipo1">Solicitado</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-12 col-sm-3">
                        <button type="submit" class="btn btn-success btn-ok"><i class="fas fa-save"></i> Guardar Datos</button>
                    </div>
                </div>
            </form>
        </div>




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
                                <th></th>
                                <th></th>

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
                                <th></th>
                                <th></th>
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

                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="llamaParticipante(this.value)" value="<?=$dato['id']?>" href="#"> <i class="fas fa-edit"></i></button>
                                            </td>
                                    <td>
                                        <?php if ($dato['id'] != 1) { ?><a data-toggle="modal" data-target="#modal-confirma"
                                                class="btn btn-danger btn-sm" href="#"
                                                data-href="<?= base_url() ?>clientes/eliminar/<?php echo $dato['id']; ?>">
                                                <i class="fas fa-trash-alt"></i></a><?php } ?></td>

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

function llamaParticipante(id){

                        $.ajax({
                    url: '<?= base_url() ?>clientes/getParticipanteByID/' + id,
                    dataType: 'json',
                    success: function(resultado) {
                        if (resultado == 0) {
                            alert('No hay datos');
                        } else {
                            

                            if (resultado.existe) {

                                $("#rut").val(resultado.datos.rut);
                                $("#nombre").val(resultado.datos.nombre);
                                
                                $("#telefono").val(resultado.datos.telefono);
                                $("#correo").val(resultado.datos.correo);
                                $("#direccion").val(resultado.datos.direccion);
                            } else {
                                $("#id_producto").val('');
                                $("#nombre").val('');
                                $("#cantidad").val('');
                                $("#precio").val('');
                                $("#subtotal").val('');
                            }
                        }
                    }
                })

}

</script>