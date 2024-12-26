<div class="contenedor noticias">
    <form method="POST" class="formulario">
    

            <input 
                type="hidden"
                id="id"
                name="id"
                value="<?php if ($blog->id != null) {echo s($blog->id);} ?>"
                
            />

            <div class="campo">
                
                <label for="titulo">Fotografía:</label>
                <span class="boton" id="abrirModalFoto">Seleccionar Fotografia</span>

                <div id="ventanaModal" class="modal">
                <div class="contenido-modal">
                    <span class="close">&times;</span>
                    <h2>Elige una fotografía</h2>
                    <div class="eligeFotos">
                        <div class="muestraFotos" id="listadoFotografias">

                        </div>

                        <div class="paginacion">
                        <button onclick="event.preventDefault()" id="botonAtras" class="paginacion__enlace paginacion__enlace--texto">Anterior &laquo</button>
                        <span id="informacionPaginas"></span>
                        <button onclick="event.preventDefault()" id="botonSiguiente" class="paginacion__enlace paginacion__enlace--texto">Siguiente &raquo</button>
                        </div>
                    </div>
                </div>
  </div>
            </div>

            <div class="campo">
                <label for="titulo">Título:</label>
                <input 
                    type="text"
                    id="titulo"
                    name="titulo"
                    placeholder="Título del Blog (Máximo 100 caracteres)"
                    maxlength="60"
                    value="<?php echo s($blog->titulo); ?>"
                />
            </div>


        <div class="campo">
            <label for="cuerpo">Cuerpo:</label>
            <textarea
                class="cuerpo"
                id="cuerpo"
                name="cuerpo"
                placeholder="Cuerpo del Blog."><?php echo s($blog->cuerpo); ?></textarea>
        </div>

            <input 
                type="hidden"
                id="idFoto"
                name="idFoto"
                value="<?php echo s($blog->idFoto); ?>"  
            />

            <input 
                type="hidden"
                id="fecha"
                name="fecha"  
                value="<?php echo s($blog->fecha); ?>"           
            />

            <input 
                type="hidden"
                id="idUsuario"
                name="idUsuario"
                value="<?php echo s($blog->idUsuario); ?>"           
           />


        <div class="campo_boton">
            <input type="submit" class="boton" 
            <?php 
            if(!$blog->id){ ?>
            value = "Crear"
            <?php }else{ ?>
            value="Editar" >
            <?php } ?>
        </div>

    </form>
    
</div>