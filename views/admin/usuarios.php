

<h2 class="encabezado_h2">Desde administración de usuarios</h2>


<div class="contenedor">
    <table class="tabla">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Administrador</th>
                <th>Blogero</th>
                <th>Fotografo</th>
                <th>Restringido</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario->nombre . " " . $usuario->apellidos ?></td>
                    <td><?php echo $usuario->email ?></td>
                    <td><?php echo $usuario->admin === "1" ? "Si" : "No" ?></td>
                    <td><?php echo $usuario->blog === "1" ? "Si" : "No" ?></td>
                    <td><?php echo $usuario->fotografo === "1" ? "Si" : "No" ?></td>
                    <td><?php echo $usuario->restringido === "1" ? "Si" : "No" ?></td>
                    <td>
                        <form method="POST" action="admin/usuarios/eliminar">
                            <input type="hidden" name="id" value="1">
                            <input type="submit" class="boton-rojo" value="Eliminar">
                        </form>

                        <a href="usuarios/actualizar?id=1" class="boton-amarillo">Actualizar</a>
                    </td>
                </tr>

            <?php 
                endforeach; 
                
            ?>
        </tbody>
    </table>
</div>

<!-- Paginacion de usuarios -->
<div class="paginas">
    <?php  
        if ($page > 6){
            $enlace = "/admin/usuarios?type=" . $type . "&page=" . $page - 5;

            $inicio = $page - 5;
            ?>
            <a href="<?php echo $enlace ?>">...</a>
            <?php
        }else{
            $inicio = 1;
        }
    
        for($i=$inicio; $i <= $paginasTotales; $i++):
            if($i === $page + 6){
                $enlace = "/admin/usuarios?type=" . $type . "&page=" . $page + 6;
                ?>
                <a href="<?php echo $enlace ?>">...</a>
                <?php
                break;
            }
            $enlace = "/admin/usuarios?type=" . $type . "&page=" .  $i;
            
    ?>
        <a href="<?php echo $enlace ?>"><?php echo $i ?></a>
        

    <?php 
        
        endfor; 
        
    ?>
</div>    <!--  fin Paginación de usuarios -->

<div class="contenedor retorno">
    <a href="/admin"><button class="boton">Administracion</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>
<?php
$script = '';
?>