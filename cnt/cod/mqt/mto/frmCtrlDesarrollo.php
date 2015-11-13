<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Formularios de actualización de complementos en desarrollo
 */?>

<form method="post" class="adjunto" id="form_adjunto">
	<label for="titulo">Título:</label><input type="text" name="titulo" maxlength="250"/><br/>
	<label for="descripcion">Descripción:</label><input type="text" name="descripcion" maxlength="250"/><br/>							
	<label for="documento">Documento:</label> <input id="documentoAdjunto" type="text" maxlength="150" name="documento" readonly/>
	<img src="cod/img/archivero.gif" name="archivero" title="archivero"/><br/>
	<input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>						
</form>
<form method="post" class="weblink" id="form_link">
	<label for="nombre">Título:</label><input type="text" name="nombre" maxlength="250"/><br/>
	<label for="enlace">Enlace:</label><input type="text" name="enlace" maxlength="250"/><br/>							
	<label for="target">Abre en otra ventana:</label> <input type="checkbox" name="target"/><br/>
	<input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>						
</form>
<form method="post" class="relacion" id="form_relacion">
	<input type="hidden" name="id_relacion" id="id_relacion"/>
	<label for="titulo">Título:</label><input id="titulo_relacion" type="search" maxlength="250" name="titulo" autocomplete="off" autofocus/>
	<input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>						
</form>
<form method="post" class="etiqueta" id="form_etiqueta">
	<label for="nombre">Etiqueta:</label><input id="nombre" type="search" maxlength="250" name="nombre" autocomplete="off" autofocus/>
	<input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>						
</form>
<form method="post" class="evento" id="form_evento">
	<label for="fecha_inicio">Fecha de inicio:</label><input type="text" name="fecha_inicio" id="fecha_inicio" value="" readonly /><img src="cod/lib/js/jscalendar/img.gif" id="trigger_fecha_inicio" style="cursor: pointer; border: 1px solid red;" title="selector de fecha" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br/>
	<label for="fecha_final">Fecha de finalización: &nbsp;</label><input type="text" name="fecha_final" id="fecha_final" value="" readonly /><img src="cod/lib/js/jscalendar/img.gif" id="trigger_fecha_final" style="cursor: pointer; border: 1px solid red;" title="selector de fecha" onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br/>
	<script type="text/javascript">
    Calendar.setup({
        inputField     :    "fecha_inicio",
        ifFormat       :    "%Y-%m-%d %H:%M:%S",
        button         :    "trigger_fecha_inicio",
        align          :    "Bl",
		showsTime      :    true,
        singleClick    :    true
    });
    Calendar.setup({
        inputField     :    "fecha_final",
        ifFormat       :    "%Y-%m-%d %H:%M:%S",
        button         :    "trigger_fecha_final",
        align          :    "Bl",
		showsTime      :    true,
        singleClick    :    true
    });
	</script>
	<label for="titulo">Título:</label><input type="text" name="titulo" value="" maxlength="250"/><br/>
	<label for="descripcion">Descripción:</label><input type="text" name="descripcion" value="" maxlength="250"/><br/>
	<label for="lugar">Lugar:</label><input type="text" name="lugar" value="" maxlength="250"/><br/>
	<label for="localidad">Localidad:</label><input type="text" name="localidad" value="" maxlength="150"/><br/>
	<input type="button" name="cancel" value="cancelar"/> <input type="submit" name="ok" value="OK"/>
</form>