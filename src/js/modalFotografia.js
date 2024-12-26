// Seleccionamos el input oculto donde vamos a mandar la información de la fotografía seleccionada
const idFoto = document.getElementById("idFoto");
const listadoFotografiasDOM = document.getElementById("listadoFotografias");
const botonAtrasDOM = document.querySelector('#botonAtras');
const botonSiguienteDOM = document.querySelector('#botonSiguiente');
const informacionPaginaDOM = document.querySelector("#informacionPaginas");
const modal = document.getElementById("ventanaModal");

const elementosPorPagina = 15;
let paginaActual = 1;
let totalFotos = 0;
let fotos = [];

document.addEventListener('DOMContentLoaded', function(){
    iniciarModal();
    


})

function iniciarModal(){
    // Seleccionamos el input oculto donde vamos a mandar la información de la fotografía seleccionada




    botonAtrasDOM.addEventListener("click", retrocederPagina)
    botonSiguienteDOM.addEventListener("click", avanzarPagina)

    // Ventana modal
    

    // Botón que abre el modal
    var boton = document.getElementById("abrirModalFoto");

    // Hace referencia al elemento <span> que tiene la X que cierra la ventana
    var span = document.getElementsByClassName("close")[0];

    // Cuando el usuario hace clic en el botón, se abre la ventana
    boton.addEventListener("click",function(e) {
        e.preventDefault;
        modal.style.display = "block";
        renderizar();
    });
    // Si el usuario hace clic en la x, la ventana se cierra
    span.addEventListener("click",function() {
        modal.style.display = "none";
    });
    // Si el usuario hace clic fuera de la ventana, se cierra.
    window.addEventListener("click",function(event) {
        if (event.target == modal) {
        modal.style.display = "none";
        }
    });
}

function avanzarPagina(){
    paginaActual = paginaActual + 1;

    renderizar();
}

function retrocederPagina(){
    paginaActual = paginaActual -1;

    renderizar();
}

async function obtenerFotografias(pagina = 1){
    const corteDeInicio = (paginaActual - 1) * elementosPorPagina;
    const datos = new FormData();
    datos.append('registros', elementosPorPagina);
    datos.append('inicio', corteDeInicio);
    try {
        const url = '/admin/api/obtenerFotografias';
        const resultado = await fetch(url,{
            method: 'POST',
            body: datos
        });
        const respuesta = await resultado.json();
        if(respuesta){
            return (respuesta);
        }
    } catch (error) {
        console.log(error);
    }
    
}

async function renderizar(){
    //limpiamos el div
    listadoFotografiasDOM.innerHTML = "";

    //Obtenemos las fotos y el número de páginas totales y iniciamos los botones
    const listaFotos = await obtenerFotografias(paginaActual);
    const paginasTotales = await obtenerPaginasTotales();
    gestionarBotones(paginasTotales);
    informacionPaginaDOM.textContent = `${paginaActual}/${paginasTotales}`;

    //Creamos cada foto con su botón para seleccionar. Si estamos en el modo editar, la foto que tenga seleccionada aparecerá con un recuadro amarillo
    listaFotos.forEach(foto => {
        //El div que contiene todo el conjunto
        const caja = document.createElement('DIV');
        const imagen = document.createElement('IMG');
        const divOpciones = document.createElement('DIV');
        const botonSeleccionar = document.createElement('BUTTON');
        caja.classList.add('contienefoto');
        divOpciones.classList.add('fotoOpciones');
        botonSeleccionar.classList.add('boton');
        if ( foto.id === idFoto.value){
            imagen.classList.add('foto_selected');
        }
        botonSeleccionar.innerHTML = 'Seleccionar';
        botonSeleccionar.onclick = function(e){
            e.preventDefault();
            idFoto.value = foto.id;
            modal.style.display = 'none';
        }
        divOpciones.appendChild(botonSeleccionar);
        imagen.setAttribute("src",foto.carpeta);
        imagen.classList.add('adminFoto');
        imagen.setAttribute("id", foto.id);
        caja.appendChild(imagen);
        caja.appendChild(divOpciones)
        listadoFotografiasDOM.appendChild(caja);
    });
}

function gestionarBotones(paginasTotales){

    //No se puede retroceder
    if(paginaActual === 1){
        botonAtrasDOM.setAttribute("disabled", true);
    } else{
        botonAtrasDOM.removeAttribute("disabled");
    }

    //No se puede avanzar
    if(paginaActual === paginasTotales){
        botonSiguienteDOM.setAttribute("disabled", true);
    } else{
        botonSiguienteDOM.removeAttribute("disabled");
    }

}

async function obtenerPaginasTotales(){
    try {
        const url = '/admin/api/obtenerFotosTotales';
        const resultado = await fetch(url,{
            method: 'POST'
        });
        const respuesta = await resultado.json();
        if(respuesta){
            return Math.ceil(respuesta / elementosPorPagina);
        }
        
    } catch (error) {
        console.log(error);
    }
}

