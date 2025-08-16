<?php
helper('number');
?>
<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

       
       
<div id='calendar'></div>

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

dateClick: function(info) {
    alert('Date: ' + info.dateStr);
    alert('Resource ID: ' + info.resource.id);
  }

        });
        calendar.render();
      });

    </script>