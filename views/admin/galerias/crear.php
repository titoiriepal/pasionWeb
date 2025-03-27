<h2 class="encabezado_h2">Nueva Galeria</h2>


<?php
    include_once __DIR__ . '/../../templates/alertas.php';
    
?>
<div class="contenedor">
    <form action="/admin/galerias/busquedaCrear?page=1" class="formulario">
        <div class="campo">
            <label for="busqueda">Buscar:</label>
            <input 
                type="text"
                id="busqueda"
                name="busqueda"
                placeholder="Texto a buscar"
            />
            <br>
            
        </div>
        <p class = "center"><input type="submit" id=btnBusqueda class="center boton" value="Buscar"></p>
        <!-- <p class="center"><span id=btnBusqueda class="boton">Buscar</span></p> -->
    </form>
    <table class="tabla">
        <thead>
            <tr>
                <th id="tableNombre">Nombre</th>
                <th id="tableAcciones">Acciones</th>
                <!-- <th id="tableAdministrador">Administrador</th>
                <th id="tableBloguero">Blogero</th>
                <th id="tableFoto">Fotografo</th>
                <th id="tableRest">Restringido</th> -->
            </tr>
        </thead>

        <tbody id="cuerpoTabla">
            <?php foreach($usuarios as $usuario){ ?>
            <tr>
                <td>
                    <?php echo $usuario->nombre . ' ' . $usuario->apellidos; ?>
                </td>
                <td>
                    <p class="boton boton--crearGaleria" data-idusuario='<?php echo $usuario->id ?>'>Crear Galeria</p>
                </td>
            </tr>

    <?php } ?>
        </tbody>
    </table>
</div>

<!-- Paginacion de usuarios -->
<div  class="paginas">
<?php 
    echo $paginacion; 
?>  


    <!-- <p><i id="btnPrev"class="fa-solid fa-circle-chevron-left"></i><span id="numeroPagina"></span><i id="btnNext" class="fa-solid fa-circle-chevron-right"></i></p> -->
    
</div>    <!--  fin Paginación de usuarios -->
<!-- <div class="contenedor">
    <ul class="listas">
        <?php foreach ($usuarios as $usuario): ?>
            <li>
                <div class="listaDatos">
                    <span class="forte"><?php echo $usuario->nombre . ' '. $usuario->apellidos; ?></span>
                    
                </div>
                <div class="listaAcciones">
                    <a href="/admin/galerias/actualizar?id=<?php echo $galeria->id; ?>"" class="boton-amarillo">Editar</a>
                    <a href="/admin/galerias/eliminar?id=<?php echo $galeria->id; ?>" class="boton-rojo">Eliminar</a>
                </div> 

            </li>
        <?php endforeach; ?>
    </ul>
</div> -->



<div class="contenedor retorno">
<a href="/admin"><button class="boton">Administracion</button></a>
    <a href="/admin/galerias"><button class="boton" id="volver">Volver</button></a>
            
</div>
<?php
$script = '<script src="/build/js/galerias.js"></script><script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>