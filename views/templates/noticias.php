

<section class="contenedor noticias">
    <h2>Noticias</h2>
    <br>
    <br>

<!-- Opción frame vertical deslizante -->

<!--    <div class="contenedor" id="noticias">
    
    <div class="scrollWrapper" onMouseover="scrollspeed=0" onMouseout="scrollspeed=current">
        <div class="scrollTitle">Últimas Noticias</div>
            <div id="scroll" >
    
                <div class="titulo-noticia"><h4>Primera Noticia<h4></div>
                <div class="noticia-cuerpo"><p>Contenido de ejemplo para el scroll de noticias personalizable. En el contenido puedes añadir cualquier codigo HTML, incluidos enlaces <a href="http://www.lawebdelprogramador.com" target="_top">La Web del programador</a></p>
                 </div>
        
                <div class="titulo-noticia"><h4> Segunda Noticia </h4></div>
                <div class="noticia-cuerpo"><p>Contenido de ejemplo para el scroll de noticias personalizable. En el contenido puedes añadir cualquier codigo HTML, incluidos enlaces <a href="http://www.lawebdelprogramador.com">La Web del programador</a></p>
                </div>
        
                <div class="titulo-noticia"><h4>Tercera Noticia</h4></div>
                <a href="http://Google.es"><div class="noticia-cuerpo"><p>Contenido de ejemplo para el scroll de noticias personalizable. En el contenido puedes añadir cualquier codigo HTML, incluidos enlaces </p></a>
                </div>
        
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>-->
    <div class="contenedor contenedor-slider">

        <ul id="lista-noticias"> 

            <?php 
            $contador = 0;
            foreach($noticias as $noticia):
                

            ?>
                <li><p><strong><?php echo $noticia->titulo ?></strong></p><p><?php echo $noticia->resumen ?></p>

                
                <a href="#"><img class="imagen-noticia" src="/imagenes/<?php echo $noticia->foto->url ?>" alt="<?php echo $noticia->foto->textAlt ?>"></a>
                
                </li>



            <?php 
            if($contador >=10){
                break;
            }
            endforeach; 
            ?>
            
            <!-- <li><p><strong>1</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis, possimus sed! Est optio adipisci ducimus vitae eos deleniti suscipit in vel illum quasi. Harum, laudantium nesciunt! Natus deserunt consequuntur soluta.</p>
                <a href="#"><img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia"></a>
                
            </li>
            
            

            <li><p><strong>2</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li>

            <li><p><strong>3</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li>

            <li><p><strong>4</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li>

    
            <li><p><strong>5</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li>

            <li><p><strong>6</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li>

            <li><p><strong>7</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li>

            <li><p><strong>8</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li> 

    
            <li><p><strong>9</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li>

            <li><p><strong>10</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <a href="#"><img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia"></a>
                
            </li>

            <li><p><strong>11</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
               
            </li>

            <li><p><strong>12</strong></p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem consequuntur necessitatibus eum laborum porro ullam, sapiente earum error quo, molestiae recusandae suscipit repudiandae quaerat inventore numquam mollitia! Vitae, tempora. Odit?</p>
                <img class="imagen-noticia" src="build/img/noticia.jpeg" alt="Noticia">
                
            </li>  -->

        </ul>

        
    </div>
    <div class="enlace">
        <a href="/noticias" class="boton">Ver más</a>

    </div>
    

</section> 


   
