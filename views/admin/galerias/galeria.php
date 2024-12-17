<?php
    include_once __DIR__ . '/../../templates/cabeceraAdmin.php';
    include_once __DIR__ . '/../../templates/alertas.php';
?>

<div class="contenedor admin_fotos">
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset class="fotos">
            <input 
                type="hidden" 
                id="idGaleria" 
                name="fotografias[idGaleria]" 
                value="<?php echo $idGaleria ?>">
            <input 
                type="hidden" 
                id="idUsuario" 
                name="fotografias[idUsuario]" 
                value="<?php echo $idUsuario ?>">
            <label for="ruta"> Imagen: </label>
            <input 
                type="file" 
                id="ruta" 
                name="foto[]"
                value="Elegir archivo"
                class="boton" 
                accept="image/jpeg, image/png"
                multiple>   
                        
        </fieldset>
        <input 
                type="submit" 
                value="Subir imagen" 
                class="boton">
    </form>
</div>

<div class="muestraFotos">

    <?php foreach($fotografias as $fotografia): ?>
          <!-- <?php
            // debuguear($nombreCarpeta . '/' . trim($fotografia->ruta));
        ?>   -->
        <div class="contienefoto">
            <img src="../../../imagenes/<?php echo $nombreCarpeta . '/' . trim($fotografia->ruta); ?>" class="adminFoto" alt="Foto Galeria">
            <div class="fotoOpciones">
                <form method='POST' action="/admin/galerias/galeria/muestra">
                    <input type="hidden" name="id" value="<?php echo $fotografia->id; ?>">
                    <input type="submit" class="<?php if($fotografia->muestra === '0'):?> fotoMuestra <?php else: ?> fotoSelec <?php endif; ?>" value="Muestra">
                </form>
                
                <form method="POST" action="/admin/galerias/galeria/eliminar">
                    <input type="hidden" name="id" value="<?php echo $fotografia->id; ?>">
                    <input type="submit" class="eliminaFoto" value="Eliminar">
            
                </form>
                
            </div>
            <button class="boton" id="textAlt" data-idfoto="<?php echo $fotografia->id; ?>">Texto Alternativo</button>
        </div>
    <?php endforeach; ?>

</div>

<div class="contenedor retorno">
    <a href="/admin"><button class="boton">Administracion</button></a>  
            
</div>

<?php
$script = '<script src="/build/js/textAlt.js"></script><script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>