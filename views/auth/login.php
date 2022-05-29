
<h2 class="encabezado_h2">Iniciar Sesión</h2>

<h4>Inicia Sesión con tus datos</h4>

<div class="contenedor">

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/auth/login" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email:</label>
        <input 
            type="email"
            id="email"
            placeholder="Tu email"
            name="email"
            value="<?php echo s($auth->email); ?>"

        />
    </div>

    <div class="campo">
        <label for="password">Password:</label>
        <input 
            type="password"
            id="password"
            placeholder="Tu Password"
            name="password"
        />

    </div>

    <p class="center"><input type="submit" class="center boton" value="Iniciar Sesión"></p>


</form>

<div class="acciones">
    <a href="/auth/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
    <a href="/auth/olvide">¿Olvidaste tu password?</a>
</div>

</div>



<?php
$script = '';
?>