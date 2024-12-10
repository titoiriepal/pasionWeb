

<?php  include_once __DIR__ . '/../templates/noticias.php'; ?>


<?php  include_once __DIR__ . '/../templates/regresivo.php'; ?>

<section class="seccion-galerias" id="galeria">
    <h2 class="titulo">Galerías fotográficas</h2>
    <div class="contenedor galerias">

    <?php  
        $arrayIndex = 0;
        foreach($galerias as $galeria):
    ?>
        <a href="/galerias/galeria?galery=<?php echo $galeria->id ?>">
            <div class="galeria">
                <h3><?php echo $galeria->usuario->nombre . ' ' . $galeria->usuario->apellidos ?></h3>
                <div class="slider">
                    <div class="slide-track2">
                        <?php foreach($arrayMuestras[$arrayIndex] as $muestra):
                            $ruta = $arrayCarpetas[$arrayIndex] . trim($muestra->ruta);
                        ?>
                            <div class="slide">
                                <img src="<?php echo $ruta ?>" height="217" width="325" alt="" />
                            </div>
                        <?php    
                        endforeach;    
                        ?>
                        <?php foreach($arrayMuestras[$arrayIndex] as $muestra):
                            $ruta = $arrayCarpetas[$arrayIndex] . trim($muestra->ruta);
                        ?>
                            <div class="slide">
                                <img src="<?php echo $ruta ?>" height="217" width="325" alt="" />
                            </div>
                        <?php    
                        endforeach;    
                        ?>
                    
                    </div>
                </div>
            </div>
        </a>
    

    <?php
        $arrayIndex += 1;
        endforeach;
    ?>




    

    </div>

</section>

<section class="section-blogs" id="blogs">
    <h2 class="titulo">Blogs</h2>
    <div class="contenedor-blogs">
        <div class="imagen parallax">

        </div>
        <div class="blogs">
            <div class="blog">
                <h3>Blog 1</h3>
                <h4>Autor</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                <p><a href="#">Ver más</a></p>
            </div>
            <div class="blog">
                <h3>Blog 2</h3>
                <h4>Autor</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                <p><a href="#">Ver más</a></p>
            </div>
            <div class="blog">
                <h3>Blog 3</h3>
                <h4>Autor</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                <p><a href="#">Ver más</a></p>
            </div>
        </div>
    </div>

</section>

<section class="elenco-section" id="elenco-section">
    <h2 class="titulo">Elenco</h2>
    <div class="contenedor elenco">
        <div class="actor jesus">
            <p class="nombre">Miguel Redondo</p>
            <p class="personaje">Jesús de Nazaret</p>
        </div>
        <div class="actor maria">
            <p class="nombre">Nines Andrés</p>
            <p class="personaje">María</p>
        </div>
        <div class="actor pedro">
            <p class="nombre">José Cuadrado</p>
            <p class="personaje">Pedro</p>
        </div>
        <div class="actor caifas">
            <p class="nombre">Marco de Mesa</p>
            <p class="personaje">Caifas</p>
        </div>
        <div class="actor pilatos">
            <p class="nombre">Félix Martínez</p>
            <p class="personaje">Poncio Pilatos</p>
        </div>
        <div class="actor juan">
            <p class="nombre">Andrés Cristobal</p>
            <p class="personaje">Juan</p>
        </div>
    </div>
    <p class="center"><a href="#" class="boton">Ver Todo</a></p>
    
        <h3>Dirección</h3>
    <div class="contenedor direction">
        <div class="direccion arte">
            <p class="nombre">Ana Velez</p>
            <p class="personaje">Dirección Artística</p>
        </div>
        <div class="direccion tecnica">
            <p class="nombre">Cesar Maroto</p>
            <p class="personaje">Dirección Técnica</p>
        </div>
        <div class="direccion cordinacion">
            <p class="nombre">Julio Prego</p>
            <p class="personaje">Dirección de Cordinación</p>
        </div>
    </div>
    <p class="center"><a href="#" class="boton">Ver Todo</a></p>
</section>

<section class="edicionesAnteriores" id="edicionesAnteriores">
    <h2 class="titulo">Ediciones Anteriores</h2>
    <div class="contenedor-ediciones">
        <div class="lista-ediciones">
            <p>
                <a href="#" class="btnedicion">Pasión Viviente 2019</a>
            </p>
            <p>
                <a href="#" class="btnedicion">Pasión Viviente 2018</a>
            </p>
            <p>
                <a href="#" class="btnedicion">Pasión Viviente 2017</a>
            </p>

        </div>
        <div class="imagen-ediciones">
            <picture>
                <source srcset="/build/img/crucificado.webp" type="image/webp">
                <img loading="lazy" src="/build/img/crucificado.jpg" alt="Cristo Crucificado" class="imgEdiciones">
            </picture>

        </div>

    </div>

</section>





<?php
$script = '
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/build/js/noticias.js"></script>  
    
   
';
?>