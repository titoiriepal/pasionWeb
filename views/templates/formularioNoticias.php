<div class="contenedor noticias">
    <form action="/admin/noticias/foto" method="POST" class="formulario">
    

            <input 
                type="hidden"
                id="id"
                name="id"
                value="<?php if ($noticia->id != null) {echo s($noticia->id);} ?>"
                
            />
        <div class="campo">
            <label for="titulo">Título:</label>
            <input 
                type="text"
                id="titulo"
                name="titulo"
                placeholder="Título de la noticia (Máximo 60 caracteres)"
                maxlength="60"
                value="<?php echo s($noticia->titulo); ?>"
            />
        </div>

        <div class="campo">
            <label for="resumen">Resumen:</label>
            <textarea
                class="resumen"
                id="resumen"
                name="resumen"
                placeholder="Breve Resumen de la noticia. No menos de 50 y no más de 300 caracteres" maxlength="300"><?php echo s($noticia->resumen); ?></textarea>
        </div>

        <div class="campo">
            <label for="cuerpo">Cuerpo:</label>
            <textarea
                class="cuerpo"
                id="cuerpo"
                name="cuerpo"
                placeholder="Cuerpo de la noticia. Hasta 10000 caracteres"
                maxlength="10000"><?php echo s($noticia->cuerpo); ?></textarea>
        </div>
        <div class="campo">
            <label for="titulo">Fotografía:</label>
            <input 
                type="hidden"
                id="idFoto"
                name="idFoto"
                value="<?php echo s($noticia->idFoto); ?>"
                
                
            />
            <input 
                type="hidden"
                id="fecha"
                name="fecha"  
                value="<?php echo s($noticia->fecha); ?>"           
            />
            <input 
                type="hidden"
                id="idUsuario"
                name="idUsuario"
                value="<?php echo s($noticia->idUsuario); ?>"           

                
            />

        </div>
        <div class="campo">
            <input type="submit" class="boton" value="Buscar fotografía" >
        </div>

    </form>
    
</div>

