<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Formularios de actualización de contenidos en portada
 */
 
 global $bloques;?>
<form method="post" class="enlace" id="form_enlace">
	<label for="enlace">Enlace:</label> <input type="text" name="enlace" maxlength="150" id="enlace"/>
	<input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>
</form>
<form method="post" class="embebido" id="form_embebido">
	<label for="embebido">Código embebido:</label> <textarea name="embebido" id="embebido"></textarea>
	<input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>
</form>
<form method="post" class="imagen" id="form_imagen">
	<label for="imagen">Imágen:</label> <input type="text" maxlength="150" name="imagen" id="imagen" readonly/>
	<img src="cod/img/archivero.gif" name="archivero" title="archivero"/><br/>
	<label for="comentario_imagen">Comentario:</label><input type="text" name="comentario_imagen" maxlength="200"/><br/>
	<input type="button" name="reset" value="borrar"/> <input type="reset" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>
</form>
<form method="post" class="estilos" id ="form_estilos">
 <h2>Estilos disponibles</h2>
 <input type="hidden" name="op" value="85"/>
 <input type="hidden" name="id"/>
 <div id="estilos"></div>
 <input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>
</form>
<form method="post" class="borra" id="form_borra">
 <h2>¿Desea con seguridad eliminar este artículo?</h2>
 <input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>
</form>
<form method="post" class="vigencia" id="form_vigencia">
	<label for="fecha_publicacion">Fecha de publicacion:</label><input type="text" name="fecha_publicacion" id="fecha_publicacion"readonly /><img src="cod/lib/js/jscalendar/img.gif" id="trigger_fecha_publicacion" style="cursor: pointer; border: 1px solid red;" title="selector de fecha" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br/>
	<label for="fecha_caducidad">Fecha de caducidad: &nbsp;</label><input type="text" name="fecha_caducidad" id="fecha_caducidad" readonly /><img src="cod/lib/js/jscalendar/img.gif" id="trigger_fecha_caducidad" style="cursor: pointer; border: 1px solid red;" title="selector de fecha" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br/>
	<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_publicacion",
        ifFormat       :    "%Y-%m-%d %H:%M:%S",
        button         :    "trigger_fecha_publicacion",
        align          :    "Bl",
		showsTime      :    true,
        singleClick    :    true
    });
    Calendar.setup({
        inputField     :    "fecha_caducidad",
        ifFormat       :    "%Y-%m-%d %H:%M:%S",
        button         :    "trigger_fecha_caducidad",
        align          :    "Bl",
		showsTime      :    true,
        singleClick    :    true
    });
</script>
<input type="button" name="cancel" value="cancelar"/> <input type="button" name="ok" value="OK"/>
</form>