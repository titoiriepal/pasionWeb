
const usuariosPorPagina = 25;
const BreakException = 'Usuarios máximos alcanzados';
var paginaActual = 1;
var muestraUsuarios = [];
var tablaUsuarios = [];
var paginas = 0;



document.addEventListener('DOMContentLoaded', function(){
    iniciarUsuarios();
    


})


async function iniciarUsuarios(){

    const botones = document.querySelectorAll('.boton--crearGaleria');
    botones.forEach(boton=>boton.addEventListener('click',creaGaleria));
    
}

async function creaGaleria(e){
    const id = e.target.dataset.idusuario;
    
    Swal.fire({
        title: '¿Quieres crear una nueva galería para este usuario?',
        text: "Esta acción no se podrá deshacer",
        icon: 'warning',
        color:'#5a023197',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, Crear'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const resultado = await creaNuevaGaleria(id);
            if(resultado){
                Swal.fire(
                    'Nueva Galería creada con Éxito',
                    'Has generado una nueva galería para el usuario ' + resultado.nombre + ' ' + resultado.apellidos,
                    'success'
                ).then(() => location.href = `/admin/galerias?page=1`)
            }else{
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            
            }      
        }
    });

}

async function creaNuevaGaleria(id) {
    const datos = new FormData();
        datos.append('id', id);
        try{
            const url = ruta + `/admin/galerias/nueva`; 
            const resultado = await fetch(url, {
                method: 'POST',
                body:datos
                });
                const respuesta = await resultado.json();
                if(respuesta){
                    return(respuesta);
                }
        }catch (error){
            console.log(error);
        }
}

