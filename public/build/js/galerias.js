const usuariosPorPagina=25,BreakException="Usuarios máximos alcanzados";var paginaActual=1,muestraUsuarios=[],tablaUsuarios=[],paginas=0;async function iniciarUsuarios(){document.querySelectorAll(".boton--crearGaleria").forEach(a=>a.addEventListener("click",creaGaleria))}async function creaGaleria(a){const e=a.target.dataset.idusuario;Swal.fire({title:"¿Quieres crear una nueva galería para este usuario?",text:"Esta acción no se podrá deshacer",icon:"warning",color:"#5a023197",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",cancelButtonText:"Cancelar",confirmButtonText:"Si, Crear"}).then(async a=>{if(a.isConfirmed){const a=await creaNuevaGaleria(e);a?Swal.fire("Nueva Galería creada con Éxito","Has generado una nueva galería para el usuario "+a.nombre+" "+a.apellidos,"success").then(()=>location.href="/admin/galerias?page=1"):Swal.fire({title:"Error",text:"Hubo un error",icon:"error",confirmButtonText:"OK"}).then(()=>location.reload())}})}async function creaNuevaGaleria(a){const e=new FormData;e.append("id",a);try{const a="/admin/galerias/nueva",r=await fetch(a,{method:"POST",body:e}),n=await r.text();if(n)return console.log(n),n}catch(a){console.log(a)}}document.addEventListener("DOMContentLoaded",(function(){iniciarUsuarios()}));