

<?php
    include_once __DIR__ . '/../templates/cabeceraAdmin.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<div class="contenedor admin_noticias">
    <a href="/admin/galerias/crear" class="boton nueva-noticia">Nueva Galeria</a>
</div>
<div class="contenedor">
    <ul class="listas">
        <?php foreach ($galeriaAutor as $galeria): ?>
            <li>
                <div class="listaDatos">
                    <span class="forte"><?php echo 'Galeria de ' . $galeria->autor; ?></span>
                    
                </div>
                <div class="listaAcciones">
                    <a href="/admin/galerias/galeria?id=<?php echo $galeria->id; ?>"" class="boton-amarillo">Editar</a>
                    <a href="/admin/galerias/eliminar?id=<?php echo $galeria->id; ?>" class="boton-rojo">Eliminar</a>
                </div>

            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php
    include_once __DIR__ . '/../templates/navAdministracion.php';
?>

<?php
$script = '';
?>