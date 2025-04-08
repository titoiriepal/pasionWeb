


document.addEventListener('DOMContentLoaded', function(){
    iniciar();
    


})

async function iniciar(){

    const cajas = document.querySelectorAll('.oculto');
    cajas.forEach(caja=>caja.addEventListener('change',ocultarGaleria));
    
}

async function ocultarGaleria(e){
    value = e.target.value;
    const activo = e.target.checked ? 0 : 1;
    if (activo === 0){
        Swal.fire({
            title: '¿Quieres ocultar esta galería ?',
            text: "La galería ya no será visible en la página web",
            icon: 'warning',
            color:'#5a023197',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Ocultar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const resultado = await ocultaGaleria(value);
                if(resultado){
                    Swal.fire(
                        'Galería Oculta',
                        'Has ocultado la galería en la página principal ',
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
        })
    }else{
        Swal.fire({
            title: '¿Quieres mostrar esta galería ?',
            text: "La galería será visible en la página web",
            icon: 'warning',
            color:'#5a023197',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Mostrar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const resultado = await ocultaGaleria(value);
                if(resultado){
                    Swal.fire(
                        'Galería Visible',
                        'Has mostrado la galería en la página principal ',
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
        })

    };
    
}

async function ocultaGaleria(id){
    const datos = new FormData();
    datos.append('id' , id);
    try{
        const url ='/admin/galerias/ocultar'; 
        
        
        const resultado = await fetch(url, {
            method: 'POST',
            body:datos
            });
            const respuesta = await resultado.json();
            if(respuesta){
                console.log(respuesta);
                return(respuesta);
            }
    }catch (error){
        console.log(error);
    }
}