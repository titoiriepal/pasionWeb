
<h2 class="encabezado_h2">Nuestros Blogs</h2>

<h4 class="infoblog">Aquí tienes todos nuestros blogs hasta la fecha</h4>

<div class="contenedor">
    <ul class="listaBlog">
        <?php foreach ($blogs as $blog): ?>
            <li class="entradaBlog">
                <!-- <div class="blog_element"> -->
                    <div class="imagen_blog">
                        <picture class="picture_Blog">
                            <source srcset="/imagenes/<?php echo $blog->foto->url ?>" type="image/jpeg">
                            <img loading="lazy" class="imagenBlog" src="/imagenes/<?php echo $blog->foto->url ?>;" alt="<?php echo $blog->foto->textAlt;?>" width="auto" height="auto">
                        </picture>
                    </div>
                    <div class="cuerpo_blog">
                        <h3 class="titulo_blog"><?php echo $blog->titulo; ?></h3>
                        <h4 class="info_blog"><?php echo 'Por ' . $blog->usuario->nombre . ' ' . $blog->usuario->apellidos . ' el ' . $blog->fecha; ?></h4>
                        <p class="center">
                            <a class="boton" href="/blogs/blog?id=<?php echo $blog->id ?>">Ver más ></a>
                        </p>
                    </div>
                <!-- </div> -->

            </li>
        <?php endforeach; ?>
    </ul>

    <?php 
    echo $paginacion; 
    ?> 
</div>

<div class="contenedor retorno">
    <a href="/"><button class="boton">Página principal</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>

<?php
$script = '';
?>

