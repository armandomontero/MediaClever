<main>
    <div class="container-fluid px-4 covered">
        <div class="covered-img"></div>


        <div class="row mt-0">
            <div class="col-lg-4 col-md-2 mb-2">
                <div class="card bg-primary text-white">
                    <div class="card-body ">
                         Mediaciones Realizadas: <?=$eventos_realizados?> 
                         
                    </div>
                    <a class="card-footer " href="<?=base_url()?>archivo/actas">Ver Detalle</a>
                </div >
            </div>

            <div class="col-lg-4 col-md-2 mb-2">
                <div class="card bg-success text-white">
                    <div class="card-body">
                         Se han vendido $<?=number_format($total_dia, 0, ',', '.')?> en <?=$ventas_dia?> ventas
                    </div>
                    <a class="card-footer" href="<?=base_url()?>ventas">Ver Detalle</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-2 col-sm-12 mb-2">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <?=$eventos_pendientes?> agendas pendientes de confirmación
                    </div>
                    <a class="card-footer" href="<?=base_url()?>eventos">Ver Calendario</a>
                </div>
            </div>
            
        </div>
        
 <div class="covered bg-white mt-4" style="width: 400px;"><canvas id="ventas"></canvas></div>
       
    </div>
</main>

<div class="modal fade" id="modal-alerta" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Atención</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="text-alerta">Aún no ha sincronizado su cuenta con Google Calendar para poder realizar notificaciones y agendamiento de reuniones de Google Meet, ¿desea conectar con su cuenta de Google?</p>
                    <p class="text-xs">*Esto solo debe realizarlo una vez</p>
                </div>
                <div class="modal-footer">
                  <a href="<?=base_url()?>google" class="btn btn-success" >Conectar con Google</a>
                    <button type="button" class="btn btn-secundary" data-dismiss="modal">Más tarde</button>
                </div>
            </div>
        </div>
    </div>

<script>
    (async function() {
  const data = <?=$string_grafico?>;

  new Chart(
    document.getElementById('ventas'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.dia),
        datasets: [
          {
            label: 'Ventas por día ($)',
            data: data.map(row => row.count)
          }
        ]
      }
    }
  );
})();
 $(document).ready(function() {
            <?php if ($google==0) {
                echo '$("#modal-alerta").modal("show");';
            } ?>

        });

</script>