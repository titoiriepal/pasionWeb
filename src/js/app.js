//Constantes y variables comunes en toda la página

const ruta = window.location.origin;

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
})

function iniciarApp(){

    
    navegacionFija();
    
}

function navegacionFija(){
    const barra = document.querySelector('.barra');
    const header = document.querySelector('.title-header');
    const box = document.querySelector('.box-header');
    const body = document.querySelector('body');
    

    window.addEventListener('scroll', function(){
        // console.log( noticias.getBoundingClientRect());

    if(header.getBoundingClientRect().bottom < 0){
        barra.classList.add('fijo');
        box.classList.add('fijo');
        body.classList.add('body-scroll');
        
    }else{
        barra.classList.remove('fijo');
        box.classList.remove('fijo');
        body.classList.remove('body-scroll');
        
        
    }
    });
}


