

<h2 class="encabezado_h2">Administración de Usuarios</h2>


<div class="contenedor">
    <form action="" class="formulario">
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
        <p class="center"><span id=btnBusqueda class="boton">Buscar</span></p>
    </form>
    <table class="tabla">
        <thead>
            <tr>
                <th id="tableNombre">Nombre</th>
                <th id="tableEmail">Email</th>
                <th id="tableAdministrador">Administrador</th>
                <th id="tableBloguero">Blogero</th>
                <th id="tableFoto">Fotografo</th>
                <th id="tableRest">Restringido</th>
            </tr>
        </thead>

        <tbody id="cuerpoTabla">
        </tbody>
    </table>
</div>

<!-- Paginacion de usuarios -->
<div  class="paginas">
    <p><i id="btnPrev"class="fa-solid fa-circle-chevron-left"></i><span id="numeroPagina"></span><i id="btnNext" class="fa-solid fa-circle-chevron-right"></i></p>
    
</div>    <!--  fin Paginación de usuarios -->

<div class="contenedor retorno">
    <a href="/admin"><button class="boton">Administracion</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>
<?php
$script = '<script src="/build/js/usuarios.js"></script><script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
?>