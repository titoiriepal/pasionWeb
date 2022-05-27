<h2>Olvide mi Password</h2>
<h4>Introduce tus datos para poder cambiar tu password</h4>

<div class="contenedor">
    <form action="/auth/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email:</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"
        />
    </div>

        <p class="center"><input type="submit" value="Enviar enlace" class="boton"></p>
    </form>

    <div class="acciones">
        <a href="/auth/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
        <a href="/auth/login">¿Ya tienes una cuenta? Inicia Sesión</a>
        
    </div>
</div>

<?php
$script = '';
?>