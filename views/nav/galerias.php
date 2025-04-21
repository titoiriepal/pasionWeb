
<section class="seccion-galerias" id="galeria">
    <h2 class="encabezado_h2">Galerías Fotográficas</h2>
    <div class="contenedor">
        <a href="/videos"><button class="boton">Videos</button></a>
    </div>
    

    <h4 class="infoblog">Echa un vistazo a todas nuestras galerías fotográficas</h4>
        <?php  
            if(empty($galerias)){ ?>
            <h3 class="center">No hay resultados disponibles</h3>
        <?php
            }
        ?>
    
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

    <div class="contenedor retorno">
    <a href="/"><button class="boton">Página principal</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>

</section>


<?php
$script = '
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
   
';
?>