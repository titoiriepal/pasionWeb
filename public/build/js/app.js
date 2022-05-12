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
    

    window.addEventListener('scroll', function(){
        // console.log( noticias.getBoundingClientRect());

    if(header.getBoundingClientRect().bottom < 0){
        barra.classList.add('fijo');
        box.classList.add('fijo');
        
    }else{
        barra.classList.remove('fijo');
        box.classList.remove('fijo');
        
        
    }
    });
}