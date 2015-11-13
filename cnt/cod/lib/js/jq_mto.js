/**
 * Mantenimiento
 */

function iniciaMto(){
	var usuario = $('#perfil').data('usuario');
	var admin = ($('#perfil').data('super')=='si');
	$('#perfil').click( showUsuario );
	if($('#user_display').prop('value')=='si'){
		showUsuario();
	}
	
	// Prepara botones de formularios.
	$('#dialogo').find('form').each(function(){
		var form = $(this);
		switch (form.attr('id')){
			case 'form_imagen':
				form.find("[name='reset']").click(function(){form.find('input[type="text"]').val('')});
				break;
			case 'form_relacion':
				form.find("[name='titulo']").keyup( function(event){buscaInteractiva(event,'relacion','buscaItem')});
				break;
			case 'form_etiqueta':
				form.find("[name='nombre']").keyup(function(event){buscaInteractiva(event,'etiqueta','buscaItem',function(){nuevaEtiqueta()})});
				break;
		}
		form.find("[type='text']").focus(function(){
			this.select();});
		form.find("[name='cancel']").click(function(){
			switchDisplay(null)});
		form.find("[name='ok']").click(function(event){
			event.preventDefault();
			actualiza();
			switchDisplay(null);
			normaliza($(this).closest('[data-tipo]'))});
		
	});

	// Coloca la barra de herramientas
	$('[data-tipo]').each(function(){
		var article = $(this);
		if(admin || article.data('usuario')==usuario){
		creaCtrl(article)
		article
			.mouseover(displayCtrlOn)
			.mouseout(displayCtrlOff);
			normaliza($(this));
		}
	});
	// Funciones de edición sobre textareas sin TinyMCE
	$('textarea.titulo').each(function(){
		var campo = $(this);
		campo.css('height',''+campo.prop('scrollHeight')+'px');
		campo.blur(function(){actualizaTexto(this.id.substr(7),'titulo')});
	});
	// Funciones de edición sobre textareas con TinyMCE
	tinymce.init({
		skin : 'myra',
		content_css : "cod/img/mto/tinymce.css",
        mode : "textareas",
	    selector: "textarea.descripcion",
	    menubar:false,
	    statusbar: false,
	    plugins : 'save autoresize code autolink link',
		toolbar: "save | undo redo | bold italic | link | bullist numlist outdent indent | code",
    	save_onsavecallback: function() { actualizaTexto(this.id.substr(12),'descripcion')},
		setup: function(editor) {
        	editor.on('focus', function () {
        		$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").show();
        	});
        	editor.on('blur', function () {
        		$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").hide();
        	});
        	editor.on('init',function () {
        		$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").hide();	        		
        	});
	    }
	 });
	tinymce.init({
		skin : 'myra',
		content_css : "cod/img/mto/tinymce.css",
        mode : "textareas",
	    selector: "textarea.texto",
	    menubar:false,
	    statusbar: false,
	    plugins : 'save autoresize code autolink link image',
		toolbar: "save | undo redo | bold italic | link image | bullist numlist outdent indent | code",
    	save_onsavecallback: function() { actualizaDesarrollo(this.id);},
		setup: function(editor) {
        	editor.on('focus', function () {
        		$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").show();
        	});
        	editor.on('blur', function () {
        		$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").hide();
        	});
        	editor.on('init',function () {
        		$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").hide();	        		
        	});
	    	}
		});
	function creaCtrl(article){ //
		// Prepara formularios.
		var id = article.data('id');
		var idEstilo = article.data('idestilo');
		var tipo = article.data('tipo');
		// Crea barra de herramientas.
		var bar = $('<span>')
					.attr('id','ctrl_'+idEstilo)
					.addClass('ctrl');
		// Hay varios tipos de barra de herramientas
		if(tipo=='edit'){
			var campo = article.data('campo'); 	
			switch (campo){
				case 'desarrollo':
					bar.append($('<a>')
							.attr('title','eliminar texto')
							.click(function(){elimina(article.data('id'),'desarrollo')})
							.addClass('menos'));
					break;
				case 'galeria':
					bar.append($('<a>')
							.attr('title','añadir una imágen')
							.click(function(){insertaDesarrollo('galeria')})
							.addClass('mas'));
					bar.append($('<a>')
							.attr('title','eliminar la imágen')
							.click(function(){borraImg()})
							.addClass('menos'));
					bar.append($('<a>')
							.attr('title','cambiar la imágen')
							.click(function(e){switchDisplay(e,article,'foto')})
							.addClass('edita'));
					break;
				default:
					bar.append($('<a>')
							.attr('title','añadir '+(campo=='link'?'enlace':campo))
							.click(function(){insertaDesarrollo(campo)})
							.addClass('mas'));
					bar.append($('<a>')
							.attr('title','eliminar '+(campo=='link'?'enlace':campo))
							.click(function(){elimina(article.data('id'),campo)})
							.addClass('menos'));
					bar.append($('<a>')
							.attr('title','cambiar '+campo)
							.click(function(e){switchDisplay(e,article,campo)})
							.addClass('edita'));
			}
		}else{
			bar.append($('<a>')
					.attr('title','retirar')
					.click(function(){publicar(article,0)})
					.addClass('up'));				// Retirar
			bar.append($('<a>')
					.attr('title','publicar')
					.click(function(){publicar(article,1)})
					.addClass('down'));				// Publicar
			bar.append($('<a>')
					.attr('title','establecer vigencia')
					.click(function(e){switchDisplay(e,article,'vigencia')})
					.addClass('vida'));				// Vigencia
			bar.append($('<a>')
					.attr('title','eliminar')
					.click(function(e){switchDisplay(e,article,'borra')})
					.addClass('del'));				// Borrar
			if(tipo!='contacto'&&tipo!='somos'){
				bar.append($('<a>')
						.attr('href','index.php?id='+id)
						.attr('title','editar')
						.addClass('edit'));				// Editar
			}
			bar.append($('<a>')
					.attr('title','incorporar estilos de presentación')
					.click(function(e){switchDisplay(e,article,'estilos')})
					.addClass('estilo'));			// Estilos
			if(tipo=='rollover' || tipo=='anuncio'){
				bar.append($('<a>')
						.attr('title','editar anuncio')
						.click(function(e){switchDisplay(e,article,'anuncio')})
						.addClass('ilu'));				// Anuncio
			}else if (tipo!='contacto'){
				bar.append($('<a>')
						.attr('title','editar imágen')
						.click(function(e){switchDisplay(e,article,'imagen')})
						.addClass('ilu'));				// Imágen			
			}
			if(tipo!='somos'){
			if(tipo!='rollover'){
				bar.append($('<a>')
						.attr('title','codigo embebido')
						.click(function(e){switchDisplay(e,article,'embebido')})
						.addClass('emb'));				// Código embebido
			}
			bar.append($('<a>')
					.attr('title','editar enlace')
					.click(function(e){switchDisplay(e,article,'enlace')})
					.addClass('link'));				// Enlace
			}
		}
		// Incorpora barra de herramientas
		article.append(bar);
	}
	function displayCtrlOn(){
		$(this)
			.width('-=4px')
			.height('-=4px')
			.css('border','2px solid #2a3588')
			.find('.ctrl').show();
	}
	function displayCtrlOff(){
		$(this)
		.width('+=4px')
		.height('+=4px')
		.css('border','0')
		.find('.ctrl').hide();
	}
	function ajustaAlto(){
		// los 20 que le quita son del padding
		this.style.height = ''+(this.scrollHeight-20)+'px';
	}
}
function switchDisplay(e,article,campo){ //
	var force = (e===null);
	if(!force) e.preventDefault();
	var dia = $('#dialogo');
	var idEstilo = dia.data('idestilo');
	var form = $('#form_'+(campo=='anuncio'||campo=='foto'?'imagen':campo));
	dia.find('form').css('display','none');
	if(force ||
		(idEstilo==article.data('idestilo')&&campo==dia.data('campo'))){
		dia.css('display','none');
		dia.data('idestilo',0);
	}else{
		cargaForm();
	    var top = e.pageY+30;
	    var left = e.pageX-400 ;
		dia.css({
			'left':left,
			'top':top,
			'width':(form.width()),
			'height':(form.height())
		});
		form.css('display','block');
		dia
			.css('display','block')
			.data('idestilo',article.data('idestilo'))
			.data('article',article)
			.data('campo',campo);
	}
	function cargaForm(){
		// campos.
		switch (campo){
			case 'imagen':
			case 'anuncio':
				form.find("[name='archivero']").archivero({campo:'imagen',imagen:'img_'+article.data('id'),carpeta:$('#dialogo').data('carpeta')});
				form.find("[name='imagen']").val(article.data(campo));
				form.find("[name='comentario_imagen']").val(article.data('comentario_imagen'));
				break;
			case 'estilos':
				form.find("[name='id']").val(article.data('id'));
				$('#estilos').load('index.php?ll=estilos&id='+article.data('id'));
				break;
			case 'borra':
				break;
			case 'vigencia':
				form.find("[name='fecha_publicacion']").val(article.data('fecha_publicacion'));
				form.find("[name='fecha_caducidad']").val(article.data('fecha_caducidad'));
				break;
			case 'foto':
				if(!$('#galeria').data('stop')){
					$('#galeria_ctrl_0').click();
				}
				var activo = $('#galeria').data('activo');
				var img = $('#galeria_'+activo).find('img');
				form.find("[name='archivero']").archivero({campo:'imagen',imagen:'img_'+img.data('idfoto'),carpeta:$('#dialogo').data('carpeta')});
				form.find("[name='imagen']").val(img.data('imagen'));
				form.find("[name='comentario_imagen']").val(img.data('comentario'));
				break;
			case 'adjunto':
				form.find("[name='archivero']").archivero({campo:'documentoAdjunto',tipoArchivo:'*',carpeta:$('#dialogo').data('carpeta')});
				form.find('[name="titulo"]').val(article.data('titulo'));
				form.find('[name="descripcion"]').val(article.data('descripcion'));
				form.find('[name="documento"]').val(article.data('documento'));
				break;
			case 'link':
				form.find('[name="nombre"]').val(article.data('nombre'));
				form.find('[name="enlace"]').val(article.data('enlace'));
				form.find('[name="target"]').prop( "checked", (article.data('target')=='1'));
				break;
			case 'relacion':
				form.find('[name="id_relacion"]').val(article.data('idrelacion'));
				form.find('[name="titulo"]').val(article.data('titulo'));
				break;
			case 'etiqueta':
				form.find('[name="nombre"]').val(article.data('nombre'));
				break;
			case 'evento':
				form.find('[name="fecha_inicio"]').val(article.data('fecha_inicio'));
				form.find('[name="fecha_final"]').val(article.data('fecha_final'));
				form.find('[name="titulo"]').val(article.data('titulo'));
				form.find('[name="descripcion"]').val(article.data('descripcion'));
				form.find('[name="lugar"]').val(article.data('lugar'));
				form.find('[name="localidad"]').val(article.data('localidad'));
				break;
			default:
				form.find("[name='"+campo+"']").val(article.data(campo));			
		}
		form.find("input:first").focus();
	}
}
	function actualiza(){
		var dia = $('#dialogo');
		var campo = dia.data('campo');
		var article = dia.data('article');
		var id = 0;
		var valor = '';
		switch (campo){
			case 'imagen':
			case 'anuncio':
				id = article.data('id');
				valor = $('#form_imagen').find('[name="imagen"]').val();
				article.data(campo,valor);
				$('#resultado').load('index.php',{op: 55,id: id,campo: campo,valor: valor});
				valor = $('#form_imagen').find('[name="comentario_imagen"]').val();
				article.data('comentario_imagen',valor);
				$('#resultado').load('index.php',{op: 55,id: id,campo: 'comentario_imagen',valor: valor});
				break;
			case 'foto':
				if(!$('#galeria').data('stop')){
					$('#galeria_ctrl_0').click();
				}
				var activo = $('#galeria').data('activo');
				var img = $('#galeria_'+activo).find('img');
				
				id = img.data('idfoto');
				valor = $('#form_imagen').find('[name="imagen"]').val();
				img.data('imagen',valor);
				$('#resultado').load('index.php',{op: 205,id: id,campo: 'imagen',valor: valor});
				valor = $('#form_imagen').find('[name="comentario_imagen"]').val();
				img.data('comentario',valor);
				$('#resultado').load('index.php',{op: 205,id: id,campo: 'descripcion',valor: valor});
				break;
			case 'estilos':
				var form = $('#form_estilos');
				if (form.find('input[type="checkbox"]:checked').length==0){
					alert('¡Selecciona al menos uno!');
				}else{
					form.submit();
				}
				break;
			case 'borra':
				elimina(article.data('id'),'contenidos');
				break;
			case 'vigencia':
				id = article.data('id');
				valor = $('#form_vigencia').find('[name="fecha_publicacion"]').val();
				article.data('fecha_publicacion',valor);
				$('#resultado').load('index.php',{op: 55,id: id,campo: 'fecha_publicacion',valor: valor});
				valor = $('#form_vigencia').find('[name="fecha_caducidad"]').val();
				article.data('fecha_caducidad',valor);
				$('#resultado').load('index.php',{op: 55,id: id,campo: 'fecha_caducidad',valor: valor});
				break;
			case 'adjunto':
				id = article.data('id');
				valor = $('#form_adjunto').find('[name="titulo"]').val();
				article.data('titulo',valor);
				$('#resultado').load('index.php',{op: 115,id: id,campo: 'titulo',valor: valor});
				valor = $('#form_adjunto').find('[name="descripcion"]').val();
				article.data('descripcion',valor);
				$('#resultado').load('index.php',{op: 115,id: id,campo: 'descripcion',valor: valor});
				valor = $('#form_adjunto').find('[name="documento"]').val();
				article.data('documento',valor);
				$('#resultado').load('index.php',{op: 115,id: id,campo: 'documento',valor: valor});
				//Pinta.
				var bar = $('#adjunto_'+id).find('span.ctrl');
				$('#adjunto_'+id)
					.html(article.data('titulo')+'<br/>'+article.data('descripcion'))
					.append(bar);
				break;
			case 'link':
				id = article.data('id');
				valor = $('#form_link').find('[name="nombre"]').val();
				article.data('nombre',valor);
				$('#resultado').load('index.php',{op: 145,id: id,campo: 'nombre',valor: valor});
				valor = $('#form_link').find('[name="enlace"]').val();
				article.data('enlace',valor);
				$('#resultado').load('index.php',{op: 145,id: id,campo: 'enlace',valor: valor});
				valor = $('#form_link').find('[name="target"]').val();
				article.data('target',valor);
				$('#resultado').load('index.php',{op: 145,id: id,campo: 'target',valor: valor});
				//Pinta.
				var bar = $('#enlace_'+id).find('span.ctrl');
				$('#enlace_'+id)
					.html(article.data('nombre'))
					.append(bar);
				break;
			case 'relacion':
				id = article.data('id');
				valor = $('#form_relacion').find('[name="id_relacion"]').val();
				article.data('idrelacion',valor);
				$('#resultado').load('index.php',{op: 215,id: id,campo: 'id_relacion',valor: valor});
				valor = $('#form_relacion').find('[name="titulo"]').val();
				article.data('titulo',valor);
				$('#resultado').load('index.php',{op: 215,id: id,campo: 'titulo',valor: valor});
				//Pinta.
				var bar = $('#relacion_'+id).find('span.ctrl');
				$('#relacion_'+id)
					.html(article.data('titulo'))
					.append(bar);
				break;
			case 'etiqueta':
				id = article.data('id');
				valor = $('#form_etiqueta').find('[name="nombre"]').val();
				article.data('nombre',valor);
				$('#resultado').load('index.php',{op: 155,id: id,campo: 'nombre',valor: valor});
				//Pinta.
				var bar = $('#etiqueta_'+id).find('span.ctrl');
				$('#etiqueta_'+id)
					.html(article.data('nombre'))
					.append(bar);
				break;
			case 'evento':
				id = article.data('id');
				valor = $('#form_evento').find('[name="fecha_inicio"]').val();
				article.data('fecha_inicio',valor);
				$('#resultado').load('index.php',{op: 185,id: id,campo: 'fecha_inicio',valor: valor});
				valor = $('#form_evento').find('[name="fecha_final"]').val();
				article.data('fecha_final',valor);
				$('#resultado').load('index.php',{op: 185,id: id,campo: 'fecha_final',valor: valor});
				valor = $('#form_evento').find('[name="titulo"]').val();
				article.data('titulo',valor);
				$('#resultado').load('index.php',{op: 185,id: id,campo: 'titulo',valor: valor});
				valor = $('#form_evento').find('[name="descripcion"]').val();
				article.data('descripcion',valor);
				$('#resultado').load('index.php',{op: 185,id: id,campo: 'descripcion',valor: valor});
				valor = $('#form_evento').find('[name="lugar"]').val();
				article.data('lugar',valor);
				$('#resultado').load('index.php',{op: 185,id: id,campo: 'lugar',valor: valor});
				valor = $('#form_evento').find('[name="localidad"]').val();
				article.data('localidad',valor);
				$('#resultado').load('index.php',{op: 185,id: id,campo: 'localidad',valor: valor});
				//Refresca.
				$.ajax({
					url: "",context: document.body,success: function(s,x){$(this).html(s);}
			});
				break;
			default:
				id = article.data('id');
				valor = $('#form_'+campo).find('[name="'+campo+'"]').val();
				article.data(campo,valor);
				$('#resultado').load('index.php',{op: 55,id: id,campo: campo,valor: valor});
		}
	}
	function publicar(article,up){
		var id = article.data('id');
		$('#resultado').load('index.php',{op:55,id:id,campo:'publicado',valor:up},function(){article.data('publicado',up);normaliza(article)});
	}
	function actualizaTexto(idEstilo,campo){ 
		var texto = $('#'+campo+(idEstilo==''?'':('_'+idEstilo)));
		var id = texto.data('id');
		var valor = texto.val();
		$('#resultado').load('index.php',{op:55,id:id,campo:campo,valor:valor});		
	}
	function normaliza(article){ //
		/** Aplica normas de visualización del bloque*/
		// Barra de herramientas
		var id = article.data('id');
		var barra = article.find('span.ctrl a');
		var botones = 0;
		barra.each(function(){
				var clase = $(this).attr('class');
				switch(clase){
				case 'up':
					if(article.data('publicado')=='0'){
						$(this).css('display','none');
					}else{
						$(this).css('display','block');						
					}
					break;
				case 'down':
					if(article.data('publicado')=='1'){
						$(this).css('display','none');
					}else{
						$(this).css('display','block');
					}
					botones--;
					break;
				case 'edit':
					if(article.data('enlace')!=''){
						$(this).css('display','none');
						botones--;
					}
					break;
				case 'img':
					if(article.data('embebido')!=''){
						$(this).css('display','none');	
						botones--;
					}
					break;
				}
				botones++;
		});
		// Ajusta visualización la barra de herramientas.
		if(article.data('campo')=='desarrollo'){
			barra.parent()
				.offset({top:0})
				.width(33);
		}else if(article.data('tipo')=='edit'){
			barra.parent().width(99);
		}else{
			barra.parent().css("width",botones*33);
		}
		if(article.data('tipo')=='rollover'){
			barra.parent().css('top','0px');
		}
		
		// Despliegue de datos del bloque.
		$('#img_'+id).prop('title',$('form_imagen_'+id).find('[name="comentario_imagen"]').val());		
	}
	// Elimina genérico.
	function elimina(id,tabla){
		var op= 0;
		switch (tabla){
		case 'contenidos':
			op = 33;
			break;
		case 'desarrollo':
			op = 57;
			break;
		case 'galeria':
			op = 123;
			break;
		case 'adjunto':
			op = 69;
			break;
		case 'link':
			op = 87;
			break;
		case 'relacion':
			op = 129;
			break;
		case 'etiqueta':
			op = 93;
			break;
		case 'evento':
			op = 111;
			break;
		}
		var form = $('#mto');
		form.find('[name="op"]').val(op);
		form.find('[name="id"]').val(id);
		form.submit();
	}
	// Inserción de complementos al contenido.
	function insertaDesarrollo(tabla){ //
		var op= 0;
		switch (tabla){
		case 'desarrollo':
			op = 38;
			break;
		case 'galeria':
			op = 82;
			break;
		case 'adjunto':
			op = 46;
			break;
		case 'link':
			op = 58;
			break;
		case 'relacion':
			op = 86;
			break;
		case 'etiqueta':
			op = 62;
			break;
		case 'evento':
			op = 74;
			break;
		}
		var form = $('#mto');
		form.find('[name="op"]').val(op);
		form.submit();
	}
	// Si se teclea una etiqueta que no se encuentra
	function nuevaEtiqueta(){ //
		$('#form_etiqueta').find('[name="nombre"]').css('background-color',objBusqueda.sinRespuesta?'yellow':'white');
	}
	// Actualización.
	function actualizaDesarrollo(idText){ //
		var id = $('#'+idText).data('id');
		var valor = $('#'+idText).val();
		$('#resultado').load('index.php',{op:95,id:id,campo:'desarrollo',valor:valor});
	}
	// Borrado.
	function borraImg(){ //
		if(!$('#galeria').data('stop')){
			$('#galeria_ctrl_0').click();
		}
		var activo = $('#galeria').data('activo');
		var id = $('#galeria_'+activo).find('img').data('idfoto');
		elimina(id,'galeria');
	}
	/**
	 * Funciones desplegadas en la barra de herramientas de cabecera
	 */
	//* Gestión de Usuarios 
	function showUsuario(){ //
		var form = $('#form_perfil'); 
		if(form.css('display')!='block'){
			form.css('display','block');
			objBusqueda = new BusquedaInteractiva('usuario','user_busqueda','buscaItem','user_lista');
			objBusqueda.show();
			$('#user_busqueda').keyup(function(event){buscaInteractiva(event,'usuario','buscaItem','user_lista')});
		}else{
			form.css('display','none');			
		}
	}
	function insertaUsuario(){
		var form = $('#mto');
		form.find('[name=op]').val(26);
		form.submit();
		return true;
	}
	function editaUsuario(){
		var form = $('#form_perfil');
		var edit = form.data('edit');
		edit = (edit=='0'?'1':'0');
		form.data('edit',edit);
		campos = $(form).find('input,textarea,img');
		$(campos).each(function(){
			if (this.id=='user_enviar'){
				$(this).css('display',(edit=='0'?'none':'block'));			
			}else if (this.type=='checkbox'){
				this.disabled = (edit=='0');
			}
			this.readOnly = (edit=='0');
			$(this).css('color',(edit=='0'?'grey':'black')); 
		});
	}
	function eliminaUsuario(){
		if($('#perfil').data('usuario')==$('#user_usuario').val()){
			$('#resultado').text('Un usuario no puede borrarse a si mismo');
		}else{
			var form = $('#mto');
			form.find('[name="op"]').val(39);
			form.find('[name="id"]').val($('#user_id').val());
			form.submit();
		}
	}
	// Inserta nuevo contenido
	function insertaContenido(estilo){
		var form = $('#mto');
		form.find('[name=op]').val(34);
		form.find('[name=id]').val(estilo);
		form.submit();
	}