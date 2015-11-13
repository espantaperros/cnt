
function iniciaSlideshow(contenedor,selector,autoplay){
    $("#"+contenedor).slideshow({reposo:5000,transicion:1500,selector:selector,autoplay:autoplay});
}

jQuery.fn.slideshow = function(cfg){
	cfg = cfg || {};
	cfg.selector = cfg.selector || '.slide';
	cfg.reposo = cfg.reposo || 5000;
	cfg.transicion = cfg.transicion || 1000;
	cfg.margen = 10;
	cfg.autoplay = cfg.autoplay;

	var cnt = $(this);
	var interval = 0;
	var ancho = 0;
	var scrAncho = 0
	var imgAncho = 0;
	var moveLong = 0;
	var imgs = 0;
	
	inicia();
	
	function inicia(){
		$(cnt)
			.css('position','relative')
			.hide();
		
		var capas = $(cnt).find(cfg.selector);
		max = $(capas).length;
		var slide = $('<div>').attr('id','Myra_slide')
			.css('position','absolute')
			.appendTo(cnt);

		$(capas).each(function(i){
			imgAncho = $(this).width();
			ancho += (imgAncho + cfg.margen);
			// Retoca css de las capas.
			$(this).css({
					'float' : 'left',
		            'display' : 'block',
		            'margin-right' : cfg.margen
		            })
		            .appendTo(slide);
		});
		$(slide).width(ancho);
				
		if(capas.length>1){
			// Cálculo de la distancia a mover.
			scrAncho = cnt.width();
			moveLong = imgAncho+cfg.margen;
			imgs = capas.length;
			$('#Myra_slide').animate({ "left": "+="+parseInt((scrAncho-imgAncho)/2)+"px" }, cfg.transicion );
			// Añade capas derecha / izquierda.
			$('<div>')
				.attr('id','slideDerecha')
				.click(function(){izquierda(cfg.autoplay&&true);})
				.appendTo(cnt);
			$('<div>')
				.attr('id','slideIzquierda')
				.click(function(){derecha(cfg.autoplay&&true);})
				.appendTo(cnt);
		}
		$(cnt).show();
		if (cfg.autoplay) play();
	}
	
	function derecha(parar){
		parar = parar || false;
		if (parar){
			clearInterval(interval);
			play();
		}
		var myra = $('#Myra_slide') 
		if((myra.position().left+moveLong)>parseInt((scrAncho-imgAncho)/2)){
			myra.animate({ "left": "-="+(moveLong*(imgs-1))+"px" }, cfg.transicion );
		}else{
			myra.animate({ "left": "+="+moveLong+"px" }, cfg.transicion );
		}
	}
	
	function izquierda(parar){
		parar = parar || false;
		if (parar){
			clearInterval(interval);
			play();
		}
		var myra = $('#Myra_slide');
		if (myra.width()+(myra.position().left-moveLong)<=parseInt((scrAncho-imgAncho)/2)){
			myra.animate({ "left": "+="+(moveLong*(imgs-1))+"px" }, cfg.transicion );			
		}else{
			myra.animate({ "left": "-="+moveLong+"px" }, cfg.transicion );
		}
	}
	function play(){
		interval = setInterval(function(){
			izquierda(false);
        }, cfg.reposo);
	}
	function stop(){
		clearInterval(interval);		
	}
}