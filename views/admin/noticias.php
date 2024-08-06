<h2 class="encabezado_h2">Desde administración de Noticias</h2>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<div class="contenedor admin_noticias">
    <a href="/admin/noticias/crear" class="boton nueva-noticia">Nueva Noticia</a>
</div>

<div class="contenedor">
    <ul class="listas">
        <?php foreach ($noticiaAutor as $registro): ?>
            <li>
                <div class="listaDatos">
                    <span class="forte"><?php echo $registro->titulo; ?></span>
                    <br>
                    <span><?php echo 'Por' . $registro->autor . ' el '. $registro->fecha; ?></span>
                </div>
                <div class="listaAcciones">
                    <a href="/admin/noticias/actualizar?id=<?php echo $registro->id; ?>"" class="boton-amarillo">Editar</a>
                    <a href="/admin/noticias/eliminar?id=<?php echo $registro->id; ?>" class="boton-rojo">Eliminar</a>
                </div>

            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="contenedor retorno">
<a href="/admin"><button class="boton">Administracion</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>
<?php
$script = '';
?>