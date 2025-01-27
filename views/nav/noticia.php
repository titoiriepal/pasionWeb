<h2 class='encabezado_h2'><?php echo $noticia->titulo ?></h2>

<h4 class="infoblog"><?php echo 'Por ' . $noticia->usuario->nombre . ' ' . $noticia->usuario->apellidos . ' el ' . $noticia->fecha; ?></h4>

<div class="contentBlog contenedor">
    <picture class="pictureBlog">
        <source srcset="/imagenes/<?php echo $noticia->foto->url ?>" type="image/jpeg">
        <img loading="lazy" class="imagenBlog" src="/imagenes/<?php echo $noticia->foto->url ?>;" alt="<?php echo $noticia->foto->textAlt;?>" width="auto" height="auto">
    </picture>
        <?php foreach ($noticia->formatResumen as $parrafo) {?>
        <p class="textoBlog resumen"><?php echo $parrafo ?></p>
        <?php  }?>
    <?php foreach ($noticia->formatText as $parrafo) {?>
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