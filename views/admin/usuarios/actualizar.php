<h2 class="encabezado_h2">Actualización de Usuario</h2>

<div class="contenedor">
<form  method="POST" class="formulario">
    <input 
        type="hidden"
        name="id"
        value="<?php echo $usuario->id ?>"
    />
    <table class="tabla">
        <thead>
            <tr>
                <th id="tableNombre">Nombre</th>
                <th id="tableApellidos">Apellidos</th>
                <th id="tableEmail">Email</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th><?php echo $usuario->nombre ?></th>
                <th><?php echo $usuario->apellidos ?></th>
                <th><?php echo $usuario->email ?></th>
            </tr>
        </tbody>
    </table>
    <table class="tabla">
        <thead>
            <tr>
                <th>Bloguero</th>
                <th>Fotografo</th>
                <th>Restringido</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th>
                    <input 
                        type="checkbox"
                        name="blog"
                        id="blog"
                        value="1"
                        <?php if($usuario->blog === '1'): ?>
                            checked
                        <?php endif; ?>                        
                    />                
                </th>
                <th>
                    <input 
                        type="checkbox"
                        name="fotografo"
                        id="fotografo"
                        value="1"
                        <?php if($usuario->fotografo === '1'): ?>
                            checked
                        <?php endif; ?>                        
                    />                
                </th>
                <th>
                    <input 
                        type="checkbox"
                        name="restringido"
                        id="restringido"
                        value="1"
                        <?php if($usuario->restringido === '1'): ?>
                            checked
                        <?php endif; ?>                        
                    />                
                </th>
            </tr>
        </tbody>
    </table>
    <p class="center"><input type="submit" class="boton" value="Actualizar"></p>
</form>

    
</div>

<div class="contenedor retorno">
    <a href="/admin"><button class="boton">Administracion</button></a>
    <a href="javascript:history.back()"><button class="boton" id="volver">Volver</button></a>
            
</div>
<?php
$script = '<script src="/build/js/actualizaUsuarios.js"></script>';
?>