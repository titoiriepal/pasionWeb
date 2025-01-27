<h2 class='encabezado_h2'><?php echo $blog->titulo ?></h2>

<h4 class="infoblog"><?php echo 'Por ' . $blog->usuario->nombre . ' ' . $blog->usuario->apellidos . ' el ' . $blog->fecha; ?></h4>

<div class="contentBlog contenedor">
    <picture class="pictureBlog">
        <source srcset="/imagenes/<?php echo $blog->foto->url ?>" type="image/jpeg">
        <img loading="lazy" class="imagenBlog" src="/imagenes/<?php echo $blog->foto->url ?>;" alt="<?php echo $blog->foto->textAlt;?>" width="auto" height="auto">
    </picture>
    <?php foreach ($blog->formatText as $parrafo) {?>
    <p class="textoBlog"><?php echo $parrafo ?></p>
    <?php  }?>
</div>

<div class="contenedor retorno">
    <a href="/"><button class="boton">Inicio</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>

<?php
$script = '';
?>