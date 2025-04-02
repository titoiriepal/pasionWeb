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

    try{
        const url = ruta + '/admin/api/usuarios';
        const resultado = await fetch(url);
        const usuarios = await resultado.json();
        tablaUsuarios = usuarios;
        paginas = conseguirNumeroPaginas(tablaUsuarios.length);
        crearPaginacion(tablaUsuarios, paginaActual);
        iniciaBotonPaginacion();
        ordenarNombre(tablaUsuarios);
        ordenarEmail(tablaUsuarios);
        ordenarAdmin(tablaUsuarios);
        ordenarBlog(tablaUsuarios);
        ordenarFoto(tablaUsuarios);
        ordenarRest(tablaUsuarios);
        busqueda();
        
        
        
    } catch (error) {
        console.log(error);
    }
    
}

function crearMuestraUsuarios(usuarios, inicio){
    
    muestraUsuarios = [];
    for (var i = inicio; i < inicio+usuariosPorPagina; i++){
        if(usuarios[i]){
            muestraUsuarios.push(usuarios[i]);
        }
    }
}


//Funciones para ordenar la tabla de usuarios



function ordenarNombre(usuarios){
    const thNombre = document.querySelector('#tableNombre')
    thNombre.addEventListener('click',() =>{
        
        tablaUsuarios = tablaUsuarios.sort(SortArrayNombre);
         
        crearPaginacion(tablaUsuarios);
    });
}

function ordenarEmail(usuarios){
    const thEmail = document.querySelector('#tableEmail')
    thEmail.addEventListener('click',() =>{ 
        tablaUsuarios = tablaUsuarios.sort(SortArrayEmail);
        
        crearPaginacion(tablaUsuarios);
    });
}

function ordenarAdmin(usuarios){
    const thAdmin = document.querySelector('#tableAdministrador')
    thAdmin.addEventListener('click',() =>{ 
        tablaUsuarios = tablaUsuarios.sort(SortArrayAdmin);
        
        crearPaginacion(tablaUsuarios);
    });
}

function ordenarBlog(usuarios){
    const thBlog = document.querySelector('#tableBloguero')
    thBlog.addEventListener('click',() =>{ 
        tablaUsuarios = tablaUsuarios.sort(SortArrayBlog);
        
        crearPaginacion(tablaUsuarios);
    });
}
function ordenarFoto(usuarios){
    const thFoto = document.querySelector('#tableFoto')
    thFoto.addEventListener('click',() =>{ 
        tablaUsuarios = tablaUsuarios.sort(SortArrayFoto);
        
        crearPaginacion(tablaUsuarios);
    });
}
function ordenarRest(usuarios){
    const thRest = document.querySelector('#tableRest')
    thRest.addEventListener('click',() =>{ 
        tablaUsuarios = tablaUsuarios.sort(SortArrayRest);
        

        crearPaginacion(tablaUsuarios);
    });
}

function busqueda(){
    const busqueda = document.querySelector('#btnBusqueda');
    const textBox = document.querySelector('#busqueda');
    busqueda.addEventListener('click',function(){
        const cadena = textBox.value;
        buscarUsuarios(cadena);
    });
}

async function buscarUsuarios(cadena){
    const datos = new FormData();
    datos.append('cadena', cadena);
    try{
        const url = '/admin/api/buscaUsuarios';
        const resultado = await fetch(url, {
            method: 'POST',
            body:datos
        });
        const usuarios = await resultado.json();
        tablaUsuarios = usuarios;
        paginas = conseguirNumeroPaginas(tablaUsuarios.length);
        crearPaginacion(tablaUsuarios, paginaActual);
    } catch (error) {
        console.log(error);
    }

}


//Crea los botones de la paginacion

function crearPaginacion(usuarios,pagina = 1){

    
    const numeroPagina = document.querySelector('#numeroPagina');
    numeroPagina.textContent = pagina;

    crearMuestraUsuarios(usuarios, ((pagina - 1) * usuariosPorPagina) ?? 0);
    mostrarUsuarios(muestraUsuarios);
    paginaActual = pagina;
    
}

function iniciaBotonPaginacion(){

    
    btnNext = document.querySelector('#btnNext');
    btnNext.addEventListener('click', ()=>{
        if(paginaActual < paginas){
            
            paginaActual += 1;
            crearPaginacion(tablaUsuarios,paginaActual);
        }
    });

    btnPrev = document.querySelector('#btnPrev');
    btnPrev.addEventListener('click', ()=>{
        if(paginaActual > 1){
            
            paginaActual -= 1;
            crearPaginacion(tablaUsuarios,paginaActual);
        }
    });
}

//Mostrar los usuarios en pantalla

function mostrarUsuarios(usuarios){



    const tabla =document.querySelector('#cuerpoTabla');
    borrarTabla();
        usuarios.forEach( usuario =>{
            const { id, nombre, apellidos, email, admin, blog, fotografo, restringido, fechaCreacion, confirmado, token, password} = usuario;

            const fila = document.createElement('TR');
            fila.dataset.idUsuario = id;

            const nombreUsuario = document.createElement('TD');
            nombreUsuario.textContent = nombre + " " + apellidos;
            const emailUsuario = document.createElement('TD');
            emailUsuario.textContent = email;
            const adminUsuario = document.createElement('TD');
            if (admin === "1"){
                adminUsuario.textContent = "Si";
            }else{
                adminUsuario.textContent = "No";
            }

            const blogUsuario = document.createElement('TD');
            if (blog === "1"){
                blogUsuario.textContent = "Si";
            }else{
                blogUsuario.textContent = "No";
            }

            const fotografoUsuario = document.createElement('TD');
            if (fotografo === "1"){
                fotografoUsuario.textContent = "Si";
            }else{
                fotografoUsuario.textContent = "No";
            }

            const restringidoUsuario = document.createElement('TD');
            if (restringido === "1"){
                restringidoUsuario.textContent = "Si";
            }else{
                restringidoUsuario.textContent = "No";
            }

            const acciones = document.createElement('TD');
            const botonBorrar = document.createElement('A');
            botonBorrar.classList.add("boton-rojo");
            botonBorrar.textContent = "Eliminar";
            botonBorrar.addEventListener('click', ()=>{
                Swal.fire({
                    title: '¿Estas seguro de eliminar este registro?',
                    text: "Esta acción no se podrá deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, Borrar'
                  }).then((result) => {
                        if (result.isConfirmed) {
                            borrarUsuario(id);
                            var nuevaTabla = tablaUsuarios.filter((item) => item.id !== usuario.id);
                            tablaUsuarios = nuevaTabla;
                            borrarTabla();
                            crearPaginacion(tablaUsuarios, 1);
                            
                            Swal.fire(
                                '¡Registro Borrado!',
                                'El usuario ha sido eliminado correctamente.',
                                'success'
                            )
                            
                        
                        }
                    });
                    

                  
            });
            

            const botonActualizar = document.createElement('A');
            botonActualizar.setAttribute('href', `usuarios/actualizar?id=${id}`);
            botonActualizar.classList.add("boton-amarillo");
            botonActualizar.textContent = "Actualizar";

            

            acciones.appendChild(botonBorrar);
            acciones.appendChild(botonActualizar);

            fila.appendChild(nombreUsuario);
            fila.appendChild(emailUsuario);
            fila.appendChild(adminUsuario);
            fila.appendChild(blogUsuario);
            fila.appendChild(fotografoUsuario);
            fila.appendChild(restringidoUsuario);
            fila.appendChild(acciones);

            tabla.appendChild(fila);

            


            
        });
   
}



function borrarTabla(){
    const tabla =document.querySelector('#cuerpoTabla');
    tabla.innerHTML="";
}

async function borrarUsuario(id){
    
    try{
        
        const url = `/admin/usuarios/eliminar?id=${id}`;
        const resultado = await fetch(url);
        const respuesta = await resultado.json();
        
    }catch (error) {
        console.log(error)


    }

}


function SortArrayNombre(x, y){
    if (x.nombre < y.nombre) {return -1;}
    if (x.nombre > y.nombre) {return 1;}
    return 0;
}

function SortArrayEmail(x, y){
    if (x.email < y.email) {return -1;}
    if (x.email > y.email) {return 1;}
    return 0;
}

function SortArrayAdmin(x, y){
    if (x.admin < y.admin) {return 1;}
    if (x.admin > y.admin) {return -1;}
    return 0;
}

function SortArrayBlog(x, y){
    if (x.blog < y.blog) {return 1;}
    if (x.blog > y.blog) {return -1;}
    return 0;
}
function SortArrayFoto(x, y){
    if (x.fotografo < y.fotografo) {return 1;}
    if (x.fotografo > y.fotografo) {return -1;}
    return 0;
}
function SortArrayRest(x, y){
    if (x.restringido < y.restringido) {return 1;}
    if (x.restringido > y.restringido) {return -1;}
    return 0;
}


function conseguirNumeroPaginas(elementos){
    if (elementos % usuariosPorPagina === 0){
        paginas = elementos / usuariosPorPagina;
    }else{
        paginas = parseInt((elementos / usuariosPorPagina), 10) + 1;
    }
    return paginas;
}

