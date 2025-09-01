<?php
?>
<main>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active"><?= $titulo ?></li>
        </ol>



        <div class="card-body">
            <div style="background-color: #e6f2ff; color: blue; border: 1px solid #dee2e6;" class="rounded text-sm p-3 mb-3"><i class="fas fa-info mr-2"></i>
                Los enlaces siguientes sirven para que pueda integrar la agenda del sistema con sus propios canales, como por ejemplo, su sitio web.

            </div>
<div class="mb-4">
                <h5>Servicio de Mediación</h5>
            Link Agenda Pública: <a href="<?=base_url()?>agenda/<?=$datos['id_tienda']?>/<?=$datos['pass']?>" target="_blank"><?=base_url()?>agenda/<?=$datos['id_tienda']?>/<?=$datos['pass']?></a>

<br><br>

Código ejemplo para insertar: <pre><code>
    &lt;iframe src="<?=base_url()?>agenda/<?=$datos['id_tienda']?>/<?=$datos['pass']?>" width="600" height="400" frameborder="0" allowfullscreen&gt; &lt;/iframe&gt;
</code></pre>
            </div>
            <?php foreach ($servicios AS $servicio){ ?>
            <div class="mb-4">
                <h5><?=$servicio['nombre']?></h5>
            Link Agenda Pública: <a href="<?=base_url()?>agenda/<?=$datos['id_tienda']?>/<?=$datos['pass']?>/<?=$servicio['id']?>" target="_blank"><?=base_url()?>agenda/<?=$datos['id_tienda']?>/<?=$datos['pass']?></a>

<br><br>

Código ejemplo para insertar: <pre><code>
    &lt;iframe src="<?=base_url()?>agenda/<?=$datos['id_tienda']?>/<?=$datos['pass']?>" width="600" height="400" frameborder="0" allowfullscreen&gt; &lt;/iframe&gt;
</code></pre>
            </div>
<?php } ?>
       
        </div>
    </div>
</main>

