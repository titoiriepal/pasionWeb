

document.addEventListener('DOMContentLoaded', function(){
    iniciartextAlt();
    


});

function iniciartextAlt(){
    const botonText = document.querySelectorAll('#textAlt');
    botonText.forEach(boton=>boton.addEventListener('click',introducirTextoAlternativo));
}


function introducirTextoAlternativo(e){
    const idFoto = e.target.dataset.idfoto;

    Swal.fire({
        title: "TEXTO ALTERNATIVO",
        text: "Establece un texto alternativo para esta foto",
        icon: 'info',
        iconColor: '#5a023197',
        color:'#5a023197',
        html:'<p class="swalText">Establece un texto alternativo para esta foto</p><input class="inputSwal" maxlength="500" type="text" id="inputText">',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Ok'
    }).then(async (result)=>{
        if (result.isConfirmed) {
            const texto=document.querySelector('#inputText').value;
            const resultado = await editarTexto(idFoto,texto);
            if(resultado){
                Swal.fire(
                    'Éxito',
                    'Has cambiado el texto alternativo de la fotografía ' + idFoto,
                    'success'
                ).then(() => location.reload())
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
}

async function editarTexto(id,texto) {
    const datos = new FormData();
        datos.append('id', id);
        datos.append('texto', texto)
        try{
            const url = '/admin/galerias/textoAlt'; 
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