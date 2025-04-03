

<h2 class="encabezado_h2">Administración de Usuarios</h2>


<div class="contenedor">
    <form action="/admin/buscausuario?page=1" class="formulario">
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

    <?php 
        if(!empty($usuarios)) {
    ?>
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
        <?php 
                    foreach ($usuarios as $usuario) {
                ?>
                <tr class="table__tr">

                    <td class="table__td">
                        <?php 
                            echo $usuario->nombre . ' ' . $usuario->apellidos;
                        ?>
                    </td>

                    <td class="table__td">
                        <?php 
                            echo $usuario->email;
                        ?>
                    </td>
                    <td class="table__td">
                        <?php 
                            $bool = ($usuario->admin === '1') ?  'Si' :  'No';
                            echo $bool
                        ?>
                    </td>

                    <td class="table__td">
                        <?php 
                            $bool = ($usuario->blog === '1') ?  'Si' :  'No';
                            echo $bool
                        ?>
                    </td>

                    <td class="table__td">
                        <?php 
                            $bool = ($usuario->fotografo === '1') ?  'Si' :  'No';
                            echo $bool
                        ?>
                    </td>

                    <td class="table__td">
                        <?php 
                            $bool = ($usuario->restringido === '1') ?  'Si' :  'No';
                            echo $bool
                        ?>
                    </td>

                    <td class="table__td--acciones">

                        <a class="table__accion table__accion--editar" href="/admin/usuarios/actualizar?id=<?php echo $usuario->id;?>">
                        <i class="fa-solid fa-user-pen"></i>
                         Editar 
                        </a>

                        <form action="/admin/ponentes/eliminar" class="table__formulario" method="POST">
                            <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
                            <button class="table__accion table__accion--eliminar" type="submit">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Eliminar
                            </button>

                        </form>
                    </td>
                </tr>

                <?php } ?>

        </tbody>
    </table>
    <?php } else { ?>
        <p class="text-center">No hay Ponentes registrados</p>

    <?php } ?>

    <?php 
    echo $paginacion; 
    ?>  
</div>

<!-- Paginacion de usuarios --> 


<div class="contenedor retorno">
    <a href="/admin"><button class="boton">Administracion</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>
