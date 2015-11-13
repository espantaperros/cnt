function iniciaEntrelineas(contenedor,selectorOpcion,selectorInter){
    $("#"+contenedor).entrelineas({transicion:800,selectorOpcion:selectorOpcion,selectorInter:selectorInter});
}

jQuery.fn.entrelineas = function(cfg){
	cfg = cfg || {};
	cfg.selectorOpcion = cfg.selectorOpcion;
	cfg.selectorInter = cfg.selectorInter || 'div';
	cfg.transicion = cfg.transicion || 800;
	
	// Prepara.
	$(this).find(cfg.selectorInter).css('display','none');
	
	this.each(function(){
		var capa = $(this);
		$(cfg.selectorOpcion,capa).click(function(event){
			event.preventDefault();
			var inter = $(this).next();
			capa.find(cfg.selectorInter+':visible').not(inter).not(inter.parents(cfg.selectorOpcion+':visible')).slideUp(cfg.transicion);
			$(inter).slideToggle(cfg.transicion);
		});
	});
}