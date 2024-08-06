
<h2 class="encabezado_h2">Noticias</h2>



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
                    <a href="/noticia?id=<?php echo $registro->id; ?>"" class="boton">Ver Noticia</a>
                </div>

            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="contenedor retorno">
    <a href="/"><button class="boton">Página principal</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>
<?php
$script = '';
?>