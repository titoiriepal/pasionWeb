<h2 class="encabezado_h2">Desde administración de Blogs</h2>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<div class="contenedor admin_noticias">
    <a href="/admin/blogs/crear" class="boton nueva-noticia">Nuevo Blog</a>
</div>

<div class="contenedor">
    <?php if(empty($blogs)){ ?>
        <h3 class="encabezado_h3">No hay blogs que mostrar</h3>
    <?php } ?>
    
    <ul class="listas">
    <?php foreach ($blogs as $blog): ?>
            <li>
                <div class="listaDatos">
                    <span class="forte"><?php echo $blog->titulo; ?></span>
                    <br>
                    <span><?php echo 'Por' . $blog->usuario->nombre . ' '. $blog->usuario->apellidos; ?></span>
                </div>
                <div class="listaAcciones">
                    <a href="/admin/blogs/editar?id=<?php echo $blog->id; ?>"" class="boton-amarillo">Editar</a>
                    <a href="/admin/blogs/eliminar?id=<?php echo $blog->id; ?>" class="boton-rojo boton-eliminar" data-id="<?php echo $blog->id; ?>" >Eliminar</a>
                </div>

            </li>
        <?php endforeach; ?>

    </ul>
    <?php 
    echo $paginacion; 
    ?>  
</div>

<div class="contenedor retorno">
    <a href="/admin"><button class="boton">Administracion</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>
<?php
$script = '';
?>