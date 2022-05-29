<header>
    <div class="contenedor backimg">
        <div class="title-header">
            <div class="box-header">
                <pre><a href="/"><h1>pasion viviente de iriepal</h1></a></pre>
                <div class="menu-bars">
                    <input type="checkbox">
                    <i class="fa-solid fa-bars menu-bars"></i>
                    <i class="fas fa-times"></i>
                    <nav>
                        <ul>
                            <li><a href="/noticias">noticias</a></li>
                            <li><a href="/galerias">galería</a></li>
                            <li><a href="/blogs">blog</a></li>
                            <li><a href="/elenco">elenco</a></li>
                            <li><a href="/ediciones">ediciones anteriores</a></li>
                            <li><a href="/auth/login">iniciar sesion</a></li>

                        </ul>
                    </nav>
                </div>
                
            </div> 
            <?php  include_once __DIR__ . '/redes_sociales.php'; ?>         
        </div>
    </div>
    <div class="barra">
        <nav class="menu-principal">
            <a href="/noticias" class="btn-menu">noticias</a>
            <a href="/galerias" class="btn-menu">galeria</a>
            <a href="/blogs" class="btn-menu">blog</a>
            <a href="/elenco" class="btn-menu">elenco</a>
            <a href="/ediciones" class="btn-menu">ediciones anteriores</a>
            <a href="/auth/login" class="btn-menu">Iniciar Sesion</a>
        </nav>
    </div>

        
        
<?php
if (!(empty($_SESSION))):

?>
    <div class="div-sesion">
        <h4 class="saludo">Hola, <?php echo $_SESSION['nombre'] ?></h4>
        <a href="/auth/logout" class="boton">Cerrar sesion</a>
    </div>
    

<?php endif ?>

        

</header>