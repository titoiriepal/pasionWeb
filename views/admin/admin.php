<h2 class="encabezado_h2">Administración web</h2>

<div class="contenedor-admin">
    <a class="boton inactivo" id="btnUsuarios">Usuarios</a>
    <a class="boton inactivo" id="btnNoticias">Noticias</a>
    <a class="boton inactivo" id="btnGalerias">Galerias</a>
    <a class="boton inactivo" id="btnBlogs">Blogs</a>
    <a class="boton inactivo" id="btnElenco">Elenco</a>
    <a class="boton inactivo" id="btnAnteriores">Ediciones anteriores</a>
</div>



<?php
$script ='
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="/build/js/adminGeneral.js"></script>
    ';
?>

<script>

    var session= {
       id : '<?=$_SESSION['id']?>',
       nombre : '<?=$_SESSION['nombre']?>',
       email : '<?=$_SESSION['email']?>',
       admin : '<?=$_SESSION['admin']?>',
       blog : '<?=$_SESSION['blog']?>',
       fotografo : '<?=$_SESSION['fotografo']?>'

    };
</script>