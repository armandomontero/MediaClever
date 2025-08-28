<?php
helper('number');
?>
<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

       
       
<div id='calendar' class="calendar"></div>

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
                    
                    <form method="POST" action="<?= base_url() ?>eventos/agendar" autocomplete="off">
                        <?= csrf_field() ?>
                        <input type="hidden" name="idEvento" id="idEvento" value=""/>
                        
                         <input type="hidden" name="fecha_bd" id="fecha_bd" value=""/>
                        <div class="form-group mt-4">
                            <h5 class="text-primary">Datos Solicitante:</h5>
                            <hr class="mt-1 mb-2">

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Nombre Completo<span class="text-danger">*</span> </label>
                                    <input readonly autofocus value="" class="form-control" id="nombre_solicitante" name="nombre_solicitante" type="text" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>RUT<span class="text-danger">*</span> </label>
                                    <input readonly class="form-control" value="" id="rut_solicitante" name="rut_solicitante" type="text" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <label>Teléfono<span class="text-danger">*</span> </label>
                                    <div class="input-group">
                                    <span class="input-group-text"><img style="padding-right:5px;" width="25" src="<?=base_url()?>img/chile.png" alt="chile">+56</span>
                                    <input required autofocus value="" class="form-control" id="telefono_solicitante" name="telefono_solicitante" type="number" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>E-Mail<span class="text-danger">*</span> </label>
                                    <input class="form-control" value="" id="correo_solicitante" name="correo_solicitante" type="email" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4 mt-2">
                            <div class="row ">
                                <div class="col-12 col-sm-6">
                                    <label>Región </label>
                                    
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label>Comuna </label>
                                    
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

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-ok"><i class="fas fa-calendar-check"></i> Confirmar y Notificar</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-pencil"></i> Editar Detalles</button>
                            <button type="button" class="btn btn-danger" ><i class="fas fa-ban"></i> Anular</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-arrow-right"></i> Salir</button>

                        </div>
                    </form>

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
                today:    'Hoy',
  month:    'month',
  week:     'week',
  day:      'day',
  list:     'list'
            },


  events: [

                    <?php
                    foreach($eventos as $evento){
                       if($evento['state']=='Agendado'){
                        echo "{ 
                        id: '".$evento['id']."',
                        start: '".$evento['fecha_inicio']."',
                        end: '".$evento['fecha_fin']."',
                        overlap: false,
                       
                        title: 'Mediación',
                        color: '#f0f25c',
                        textColor: '#28292f'
                        
                    },";
                       }

                       if($evento['state']=='Confirmado'){
                        echo "{ 
                        id: '".$evento['id']."',
                        start: '".$evento['fecha_inicio']."',
                        end: '".$evento['fecha_fin']."',
                        overlap: false,
                       
                        title: 'Mediación',
                        color: '#1a7e2b'
                        
                    },";
                       }

                    } ?>
                   
                    
                ],

                eventClick: function(info) {
                    $("#idEvento").val(info.event.id);

//funcion ajax para lla,ar datos del formulario
                $.ajax({
                    url: '<?= base_url() ?>eventos/getDatosId/' + info.event.id,
                    dataType: 'json',
                    success: function(resultado) {
                        if (resultado == 0) {
                            //$(tagCodigo).val('');
                        } else {
                            //$(tagCodigo).removeClass('has-error');
                            //$("#resultado_error").html(resultado.error);

                            if (resultado.existe) {
                                //alert(resultado.nombre_solicitante);
                                $("#nombre_solicitante").val(resultado.datos.nombre_solicitante);
                                 $("#rut_solicitante").val(resultado.datos.rut_solicitante);
                                $("#modal-formulario").modal('show');

                            } else {
                                $("#nombre_solicitante").val('');
                               
                            }
                        }
                    }
                });



                    
   // alert('Event: ' + info.event.id);
                  
   

    // change the border color just for fun
    info.el.style.borderColor = 'red';
  }

        });
        calendar.render();
      });

    </script>