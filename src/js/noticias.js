// //Opción  Scrollin vertical automático

//     // determina el numero de pixeles que se moveran las noticias para
//             // cada iteracion en milisegundos de "speedjump"
//             var scrollspeed=1;
//             // determina la velocidad en milisgundos
//             var speedjump=30;
//             // segundos antes de empezar el movimiento
//             var startdelay= 1;
//             // posicion inicial superior en pixeles para cuando inicia
//             var topspace=-10;
//             // altura del marco donde se mostraran las noticias
//             // Si se modifica la altura del contenedor de las noticas hay que
//             // modificar tambien este valor
//             var frameheight=270;
    
//             // variable temporal que variara su valor en función de si estan las
//             // noticias en movimiento o paradas
//             current=scrollspeed;

//             document.addEventListener('DOMContentLoaded', function(){
//                 scrollStart();
//             })
    
//             /**
//              * Inicio del scroll
//              * Esta función es llamada en el body de la pagina.
//              * Tiene que recibir el id del scroll
//              */
//             function scrollStart()
//             {
//                 dataobj = document.getElementById("scroll");
//                 // cogemos la altura maxima de la capa de las noticias
//                 alturaNoticias = dataobj.offsetHeight;
//                 // posicionamos la capa del scroll en su posicion inicial
//                 dataobj.style.top = topspace + 'px';
    
//                 setTimeout("scrolling()", (startdelay * 1000));
//             }
    
//             /**
//              * Funcion que realiza el movimiento
//              */
//             function scrolling() {
//                 // Restamos a la propiedad top de la capa el valor en pixeles
//                 // establecido en la variable "scrollspeed", para hacer el
//                 // movimiento hacia arriba.
//                 dataobj.style.top = parseInt(dataobj.style.top) - scrollspeed + 'px';
//                 // Si la capa ha sobrepasado la altura del area por donde se muestran
//                 // las noticias ("alturaNoticias")
//                 if (parseInt(dataobj.style.top) < alturaNoticias * (-1))
//                 {
//                     // Posicionamos la capa en la parte inferior del recuadro, para
//                     // que simule que vienen las noticias de la parte inferior
//                     dataobj.style.top = frameheight + 'px';
//                     setTimeout("scrolling()", 0);
//                 }else{
//                     setTimeout("scrolling()", speedjump);
//                 }
//             }

var timer = 10000;

var i = 0;
var max = $('#lista-noticias > li').length;
 
	$("#lista-noticias > li").eq(i).addClass('active').css('left','25%');
	
	
 

	setInterval(function(){ 

		$("#lista-noticias > li").removeClass('active');

		$("#lista-noticias > li").eq(i).css('transition-delay','0.50s');
		

		if (i < max-1) {
			i = i+1; 
		}

		else { 
			i = 0; 
		}  

		$("#lista-noticias > li").eq(i).css('left','25%').addClass('active').css('transition-delay','1.25s');
		
		
	
	}, timer);