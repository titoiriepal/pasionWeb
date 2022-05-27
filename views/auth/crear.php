<h2>Crear cuenta</h2>
<h4>Rellena el formulario para crear una nueva cuenta de Usuario</h4>

<div class="contenedor">

<form action="/auth/crear" class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu nombre"
            
        />
    </div>

    <div class="campo">
        <label for="apellidos">Apellidos:</label>
        <input 
            type="text"
            id="apellidos"
            name="apellidos"
            placeholder="Tus Apellidos"

        />
    </div>

    <div class="campo">
        <label for="email">Email:</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu E-mail"

        />
    </div>

    <div class="campo">
        <label for="password">Password:</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu Password"

        />
    </div>

    <div class="campo">
        <label for="password2">Confirma tu Password: </label>
        <input 
            type="password"
            id="password2"
            placeholder="Repite Tu Password"
            name="password2"                
        />
    </div>

    <p class="center"><input type="submit" value="Crear Cuenta" class="boton"></p>

</form>

<div class="acciones">
    <a href="/auth/login">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/auth/olvide">¿Olvidaste tu password?</a>
</div>

</div>

<?php
$script = '';
?>