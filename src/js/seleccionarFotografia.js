var idFoto = document.getElementById('idFoto');
var fotosSelected = document.getElementsByClassName('foto_selected');
var fotoselected;
if (fotosSelected){
    Array.from(fotosSelected).forEach(function(element){
        fotoselected = element;
    })
}
console.log(fotoselected);

document.addEventListener('DOMContentLoaded', function(){
    iniciarBuscarFotografia();
    


})

function iniciarBuscarFotografia(){
    
    var seleccionarButtons = document.getElementsByClassName('boton_seleccionar');
    Array.from(seleccionarButtons).forEach(function (element){
        element.addEventListener('click',function(){
            idFoto.value = element.dataset.value;
            
            if(fotoselected){
                fotoselected.classList.remove('foto_selected');
            }
            fotoselected = document.getElementById(element.dataset.value);
            fotoselected.classList.add('foto_selected');
            console.log(fotoselected);

        })
    })
}