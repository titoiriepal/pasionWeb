

<?php
    include_once __DIR__ . '/../templates/cabeceraAdmin.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<div class="contenedor admin_noticias">
    <a href="/admin/galerias/crear" class="boton nueva-noticia">Nueva Galeria</a>
</div>
<div class="contenedor">
    <ul class="listas">
        <?php foreach ($galerias as $galeria): ?>
            <li>
                <div class="listaDatos">
                    <span class="forte"><?php echo 'Galeria de ' . $galeria->usuario->nombre . ' '. $galeria->usuario->apellidos ; ?></span>
                    
                </div>
                <div class="listaAcciones">
                    <a href="/admin/galerias/galeria?id=<?php echo $galeria->id; ?>"" class="boton-amarillo">Editar</a>
                    <a href="/admin/galerias/eliminar?id=<?php echo $galeria->id; ?>" class="boton-rojo">Eliminar</a>
                    <label for="oculto">Oculta:</label>
                    <input 
                        type="checkbox"
                        name="oculto"
                        class="oculto"
                        id="oculto<?php echo $galeria->id; ?>"
                        value="<?php echo $galeria->id; ?>"
                        <?php if($galeria->oculto === '1'): ?>
                            checked
                        <?php endif; ?>                        
                    />                
                </div>


            </li>
        <?php endforeach; ?>
    </ul>

    <?php 
    echo $paginacion; 
    ?>  

</div>



<?php
    include_once __DIR__ . '/../templates/navAdministracion.php';
?>

<?php
$script = '<script src="/build/js/ocultarGaleria.js"></script><script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>