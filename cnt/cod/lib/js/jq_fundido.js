
function iniciaFundido(contenedor,selector){
    $("#"+contenedor).fundido({reposo:5000,transicion:2000,selector:selector});
}
jQuery.fn.fundido = function(cfg){
	cfg = cfg || {};
	cfg.selector = cfg.selector || '.rollover';
	cfg.reposo = cfg.reposo || 5000;
	cfg.transicion = cfg.transicion || 1000;
	cfg.claseCtrl = cfg.claseCtrl || 'panel';
	cfg.activo = 0;

	var cnt = $(this);
	var nombre = $(cnt).attr('id');
	var max = 0;
	var stop = -1;
	var itrvalFundido = null;
	var stanby = false;
	
	// Crea ctrl y retoca css.
	aspecto();
	
	// Inicia rollover.
	if(max>1){
		inicia();		
	}else{
		display(0,false);
	}
	
	function inicia(){
		itrvalFundido = setInterval(function(){
			display(cfg.activo+1<max?cfg.activo+1:0,false);
        }, cfg.reposo);
	}
	
	function display(numero,stop){
		$('#'+nombre).data('activo',numero);
		$('#'+nombre).data('stop',stop);
		$('[id^="'+nombre+'_ctrl_"]').attr('class','off');
		$('#'+nombre+'_'+cfg.activo).animate({opacity: 0}, cfg.transicion);
		stanby = true;
		var $ctrl = $('#'+nombre+'_ctrl_'+numero).attr('class','stanby');
		var $siguiente = $('#'+nombre+'_'+numero).animate({opacity: 1}, cfg.transicion, function(){
				cfg.activo = numero;
				stanby = false;
				$ctrl.attr('class',stop?'stop':'on')
			});
	}
	
	function starStop(capa){
		var parada = $(capa).data('numero');
		if(stop<0){
			stop = parada;
			clearInterval(itrvalFundido);
		}else if(stop==parada){
			stop = -1;
		}else{
			stop = parada;
		}
		if(stop<0){
			var $ctrl = $('#'+nombre+'_ctrl_'+cfg.activo).attr('class','on');
			inicia();
		}else if(stanby){
			setTimeout(function(){display(stop,true)},cfg.transicion);
		}else{
			display(stop,true);
		}
	}
	
	function aspecto(){
		var capas = $(cnt).find('.'+cfg.selector);
		max = $(capas).length;
		$(cnt).css('position','relative');
		// Crea capa de control
		if(max>1){
			var ctrl= $('<div>').attr('id',nombre+'_ctrl')
				.addClass(cfg.claseCtrl)
				.appendTo(cnt);
		}
		$(capas).each(function(i){
			// Retoca css de las capas.
			$(this).css({
					'position'  : 'absolute',
		            'top'       : '0px',
		            'left'      : '0px',
		            'opacity'   : i==0?1.0:0.0});
			$(this)
				.attr('id',nombre+'_'+i)
				.data('numero',i);
			// Crea botones de la capa de control.
			if(max>1){
				$('<span>',{
					class:i==0?'on':'off',
					text: i+1})
						.attr('id',nombre+'_ctrl_'+i)
						.data('numero',i)
						.click(function(){starStop($(this))})
						.appendTo(ctrl);
			}
		});
	}
}