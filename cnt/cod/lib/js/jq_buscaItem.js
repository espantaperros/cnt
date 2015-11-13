/**
 * jQuery para la búsqueda Interactiva
 *
 * Desarrollado por Myra
 */
var objBusqueda = null;

/*
 * Clase Busqueda Interactiva
 */
 function BusquedaInteractiva(nombre,idCampo,clase,idRes){
	this.nombre = nombre;
	this.idCampo = idCampo;
	this.campo = $('#'+idCampo);
	this.clase = clase; // estilo que se va a aplicar según un class definido en css.
	this.capaRes = null;
	if(idRes!=null){
		this.capaRes = $('#'+idRes);
	}
	this.selected = -1;
	this.sinRespuesta = false;
	this.postBusqueda = this.postBusqueda;
}
 BusquedaInteractiva.prototype.show = function(){
	// Construye capa de resultados.
	if(this.capaRes==null){
		resultado = $('#res_'+objBusqueda.idCampo);
		if (resultado.length==0){
			objBusqueda.campo.before('<div id="res_'+objBusqueda.idCampo+'" class="'+objBusqueda.clase+'"></div>');
			var resultado = $('#res_'+objBusqueda.idCampo);
			resultado.css('position','absolute')
			.css('top',''+(objBusqueda.campo.position().top+objBusqueda.campo.outerHeight())+'px')
			.css('left',''+(objBusqueda.campo.position().left)+'px')
			.css('width',''+objBusqueda.campo.outerWidth()+'px')
			.css('height','auto')
			.css('max-height','300px')
			.css('overflow-y','auto')
			.css('display','none')
			.css('z-index',100)
			.click(cierraInt);
		}
		objBusqueda.capaRes = resultado;
	}else{
		objBusqueda.busca();
	}
}
BusquedaInteractiva.prototype.busca = function(){
	objBusqueda.sinRespuesta = false;
	objBusqueda.selected = -1;
	var capaRes = objBusqueda.capaRes;
	capaRes.css('display','block')
		.html('<img src="cod/img/espiral.gif/>"');
		$.get(URL_BASE+'index.php','ll='+objBusqueda.clase+'&'+objBusqueda.nombre+'='+objBusqueda.campo.val(), function(respuesta){
			if(respuesta==''){
				objBusqueda.sinRespuesta = true;
				objBusqueda.close();
			}else{
				capaRes.html(respuesta);
				capaRes.find('[data-iditem]').each(function(i){
					$(this).click(function(){objBusqueda.selecciona($(this));})
						   .data('index',i);
				});
			}
			if ($.type(objBusqueda.postBusqueda)!='undefined') objBusqueda.postBusqueda();
		});
}
BusquedaInteractiva.prototype.selecciona = function(item){
	if (objBusqueda.selected>-1){
		var ant = objBusqueda.capaRes.find('[data-iditem]').get(objBusqueda.selected);
		$(ant).toggleClass('selected')
	}		
	var datos = $(item).data();
	$.each(datos, function(key, value) {
		if(key=='index'){
			objBusqueda.selected = value;
		}else if (key!='iditem'){
			var input = $('#'+key);
			if (input.attr('type')=='checkbox'){
				input.prop('checked',value);
			}else{
				input.val(value);
			}
		}
	});
	$(item).addClass('selected');
}
BusquedaInteractiva.prototype.navega = function(direccion){
	var rows = objBusqueda.capaRes.find('[data-iditem]');
	var item = null;
	if (objBusqueda.selected>-1){
		item = rows.get(objBusqueda.selected);
		if($(item).hasClass('selected')){
			$(item).toggleClass('selected');
		}
	}
	if(direccion=='down'){
		if (++objBusqueda.selected>=rows.length){
			objBusqueda.selected = rows.length-1;
		}
	}else{
		if (--objBusqueda.selected<0){
			objBusqueda.selected = 0;
		}		
	}
	item = rows.get(objBusqueda.selected);
	objBusqueda.selecciona(item);
	$(item).addClass('selected');	
}
BusquedaInteractiva.prototype.postBusqueda = function(){
	return false;
}
BusquedaInteractiva.prototype.close = function(){
	this.capaRes.css('display','none');
}
 
 /*
  * Interfaz de usuario.
  */
 function buscaInteractiva(e,nombre,clase,postBusqueda){	 // Para colocar en el evento onkeyup
	 if (objBusqueda==null){
		 objBusqueda = new BusquedaInteractiva(nombre,e.currentTarget.id,clase);
		 objBusqueda.postBusqueda = postBusqueda;
		 objBusqueda.show();
	 }
	 var keyCode = document.all ? e.which : e.keyCode;
	 if (keyCode==40){ // flecha abajo.
		 objBusqueda.navega('down');
	 }else if (keyCode==38){ // flecha arriba.
		 objBusqueda.navega('up');
 	 }else if (keyCode==13){
 		 objBusqueda.close();
 	 }else{
		 objBusqueda.busca();
	 }
 }
 function cierraInt(){
	 objBusqueda.close();
 }