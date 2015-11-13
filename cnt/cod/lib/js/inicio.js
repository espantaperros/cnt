// constantes.
var URL_BASE = 'http://localhost/myra/cnt/';
$(document).ready( function() {
	var mto = (document.getElementById('mto_cabecera')!=null);
	document.getElementById('hemeroteca').placeholder = now();
	// Entrelineas para la agenda
	if (document.getElementById('agenda_relacion')){
		iniciaEntrelineas('agenda_relacion','p.agenda_fecha','span.inter_agenda');
	}
	// Inicializa fundido de galeria.
	if (document.getElementById('galeria')){
		iniciaFundido('galeria','rollover');
	}
	if (document.getElementById('complementos_relacion')){
		iniciaEntrelineas('complementos_relacion','p.complemento','p.inter_complemento');
	}	
	if (mto){
		iniciaMto();
	}
} );
function now(){
	var ahora = new Date();
	return ''+ahora.getDate()+'/'+ahora.getMonth()+'/'+ahora.getFullYear();
}