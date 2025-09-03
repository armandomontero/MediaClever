<!-- Begin Page Content -->
<main>
    <div class="container-fluid">

        <?php
        if (isset($validation)) { ?>
            <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>
            </div>
        <?php } ?>

        <?php
        if (isset($mensaje)) { ?>
            <div class="alert alert-success">
                <?php echo $mensaje; ?>
            </div>
        <?php } ?>

        En esta pantalla mostraremos datos pertinentes y realizaremos el acta de mediación con sus correspondientes controles
        <br>
        opciones barajadas:<br>
        <ul>
            <li>Habra acta "digital" creada en editor de sistema o acta documento adjunto una de 2</li>
            <li>Gestion de documentos asociados a la mediacion "archivos para subir y adjuntar"</li>
            <li>popup o enlace para ver todos los datos de la mediación y modificarlos segun necesidad</li>
            <li>Link reunion virtual obvio</li>
            <li>Boton para ir guardando cambios</li>
            <li>Boton principal guardar cambios y cambiar estado a realzada</li>
            <li>Boton frustrar</li>
            <li>COmenzaremos con subida de archivos "acta de mediacion externa" para partir produccion</li>
        </ul>
<br>
        Mientras mostramos link a la meeting: <br>
        <a target="_blank" href="<?=$datos->enlace ?>"><?=$datos->enlace ?></a>
</div>
</main>