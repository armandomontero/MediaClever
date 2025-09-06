<?php
?>


<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

        <!-- Page Heading -->

<ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url()?>">Inicio</a></li>
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
                            <tr class="bg-primary text-white">
                                <th>ID</th>
                                <th>Fecha Sesión</th>
                                <th>Solicitante</th>
                                 <th>Solicitado</th>
                                <th>Estado</th>
                                
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="bg-primary text-white">
                                <th>ID</th>
                                <th>Fecha Inicio</th>
                                <th>Solicitante</th>
                                 <th>Solicitado</th>
                                <th>Estado</th>
                                
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach ($eventos as $evento) {

                            ?>
                                <tr>
                                    <td><?php echo $evento['id_evento']; ?></td>
                                    <td><?php  echo date('d-m-Y H:i:s', strtotime($evento['fecha_inicio'])); ?></td>
                                    <td><?=$evento['nombre_solicitante'] ?></td>
                                    <td><?=$evento['nombre_solicitado'] ?></td>
                                   <td><?=$evento['state'] ?></td>
                                    <td><?php if($evento['id_evento']!=1){?><a class="btn btn-warning btn-sm" href="<?= base_url() ?>archivos/getEvento/<?php echo $evento['id_evento']; ?>"><i class="fas fa-edit"></i></a><?php } ?></td>
                                    <td><?php if($evento['id_evento']!=1){?><a data-toggle="modal" data-target="#modal-confirma" 
                                        class="btn btn-danger btn-sm" href="#" 
                                        data-href="<?= base_url() ?>unidades/eliminar/<?php echo $evento['id_evento']; ?>">
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
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


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
