<h2 class="encabezado_h2">Selecciona una fotografia</h2>

    
    
    <div class="muestraFotos">

    <?php
        
        foreach($fotografias as $fotografia): 
        ?>
        <!-- <?php
            // debuguear($nombreCarpeta . '/' . trim($fotografia->ruta));
        ?>   -->
            <div class="contienefoto">
                
                <img src="/imagenes/<?php echo $fotografia->carpeta . '/' . trim($fotografia->ruta); ?>" id="<?php echo$fotografia->id ?>"class="adminFoto <?php if($fotografia->id == $idFoto) {echo 'foto_selected';} ?>" alt="Foto Galeria">
                <div class="fotoOpciones">
                    <a 
                        <?php 
                        if($idNoticia){
                        ?>
                        href="/admin/noticias/actualizar?<?php echo 'id=' . $idNoticia . '&idFoto='. $fotografia->id?>";
                        
                        <?php }else{ ?>
                        href="/admin/noticias/crear?<?php echo 'idFoto='. $fotografia->id?>";
                        <?php } ?>
                        

                        class="boton boton_seleccionar" data-value="<?php echo $fotografia->id ?>">Seleccionar</a>
                    
                </div>
                
            </div>
        
        <?php 
        endforeach; 
        ?>
        </div>
        <div class="contenedor">
        <?php
        echo $paginacion; 
        ?>  
        <!-- <form action="<?php if ($_POST['id']){ echo '/admin/noticias/actualizar?id=' . $_POST['id'];} else { echo '/admin/noticias/crear';} ?>" method="POST" class="formulario">
        
            <input 
                type="hidden"
                id="id"
                name="id"
                value = "<?php echo $_POST['id']?>"

            />
            <input 
                type="hidden"
                id="titulo"
                name="titulo"
                value = "<?php echo $_POST['titulo']?>"

            />
            <input 
                type="hidden"
                id="resumen"
                name="resumen"
                value = "<?php echo $_POST['resumen']?>"

            />
            <input 
                type="hidden"
                id="cuerpo"
                name="cuerpo"
                value = "<?php echo $_POST['cuerpo']?>"

            />
            <input 
                type="hidden"
                id="fecha"
                name="fecha"
                value = "<?php echo $_POST['fecha']?>"

            />
            <input 
                type="hidden"
                id="idUsuario"
                name="idUsuario"
                value = "<?php echo $_POST['idUsuario']?>"

            />
            <input 
                type="hidden"
                id="idFoto"
                name="idFoto"
                value = "<?php echo $_POST['idFoto']?>"

            />
            <input type="submit" class="boton" value="<?php if ($_POST['id']){ echo 'Actualizar noticia';} else { echo 'Crear Noticia';} ?>">
        </form>-->
    </div> 

    <div class="contenedor retorno">
    <a href="/admin"><button class="boton">Administracion</button></a>
        <a href="/admin/noticias"><button class="boton" id="volver">Volver</button></a>
                
    </div>
<?php
$script = '<script src="/build/js/seleccionarFotografia.js">';
?>

