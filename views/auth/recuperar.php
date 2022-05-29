<h2 class="encabezado_h2">Reestablecer contraseña</h2>
<h4>Coloca tu nueva contraseña a continuación</h4>

<div class="contenedor">
    <?php
        include_once __DIR__ . '/../templates/alertas.php';
    ?>

    <?php if($error) return; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña:</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu nueva contraseña"
        
        />
    </div>
    <div class="campo">
        <label for="password2">Confirma tu contraseña:</label>
        <input 
            type="password"
            id="password2"
            name="password2"
            placeholder="Confirma tu contraseña"
        
        />
    </div>

    <p class="center"><input type="submit" class="boton" value="Guardar nuevo password"></p>
</form>

    <div class="acciones">
        <a href="/auth/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/auth/login">¿Ya tienes una cuenta? Inicia Sesión</a>
        
    </div>

/</div>

<?php
$script = '';
?>