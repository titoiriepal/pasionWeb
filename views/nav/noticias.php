
<h2 class="encabezado_h2">Noticias</h2>



<div class="contenedor">
    <ul class="listaNoticias">
        <?php foreach ($noticias as $registro): ?>
            <li class="navNoticias">
                <div class="noticiaNav">
                    <div class="imagenNoticia">
                        <img src="/imagenes/<?php echo $registro->foto->url; ?>" height="217" width="auto" alt="<?php echo $registro->foto->textAlt; ?>" />
                    </div>
                    <div class="cuerpoNoticia">
                        <h3 class="tituloNoticia"><?php echo $registro->titulo; ?></h3>
                        <h4 class="infoNoticia"><?php echo 'Por ' . $registro->usuario->nombre . ' ' . $registro->usuario->apellidos . ' el ' . $registro->fecha; ?></h4>
                        <p class="resumenNoticia"><?php echo $registro->resumen; ?></p>
                        <div class="noticias_acciones">
                            <a href="/noticia?id=<?php echo $registro->id; ?>"" class="boton">Ver Noticia</a> 
                        </div>
                    </div>
                    <!-- <span class="forte"><?php echo $registro->titulo; ?></span>
                    <br>
                    <span><?php echo 'Por ' . $registro->usuario->nombre . ' '. $registro->usuario->apellidos . ' el '. $registro->fecha; ?></span>
                </div>-->
               
         
                </div>


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