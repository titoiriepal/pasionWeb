document.addEventListener('DOMContentLoaded', function(){
    activarBotones();
})

function activarBotones(){
    var btnUsuarios = document.getElementById('btnUsuarios');
    var btnNoticias = document.getElementById('btnNoticias');
    var btnGalerias = document.getElementById('btnGalerias');
    var btnBlogs = document.getElementById('btnBlogs');
    var btnElenco = document.getElementById('btnElenco');
    var btnAnteriores = document.getElementById('btnAnteriores');
    if(session.admin === '1'){
        btnUsuarios.href="admin/usuarios?type=all&page=1"
        btnUsuarios.classList.remove('inactivo');
        btnNoticias.href="admin/noticias"
        btnNoticias.classList.remove('inactivo');
        btnGalerias.href="admin/galerias"
        btnGalerias.classList.remove('inactivo');
        btnBlogs.href="admin/blogs"
        btnBlogs.classList.remove('inactivo');
        btnElenco.href="admin/elenco"
        btnElenco.classList.remove('inactivo');
        btnAnteriores.href="admin/anteriores"
        btnAnteriores.classList.remove('inactivo');
    }else{ 
        if(session.blog === '1'){
            btnBlogs.href="admin/blogs"
            btnBlogs.classList.remove('inactivo');
        }
        if(session.fotografo === '1'){
            btnGalerias.href="admin/galerias"
            btnGalerias.classList.remove('inactivo');
        }
        
    }
    
}
