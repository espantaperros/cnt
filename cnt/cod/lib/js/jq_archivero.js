/**
 * Archivero
 * jQuery para la gestión de archivos
 * contra el servidor web
 *
 * Desarrollado por Myra-web
 */

/*
 * Clase Archivero
 */
jQuery.fn.archivero = function(cfg){
	cfg = cfg || {};
	cfg.campo = cfg.campo;
	cfg.imagen = cfg.imagen || '';
	cfg.tipoArchivo = cfg.tipoArchivo || '*'; // '*','img'
	cfg.home = cfg.home || '';
	cfg.contenedor = cfg.contenedor || 'principal';
	cfg.carpeta = cfg.carpeta || '';
		
	$(this).click(show);
	
	function show(){
		if(!$('#archivero').length){
			$('<div>').attr('id','archivero')
				.appendTo($('#'+cfg.contenedor).parent());
			load();
		}else{
			var arch = $('#archivero'); 
			arch.slideDown();
			selectFolder(arch.data('folder'));
		}
	}	
	function load(){
		$('#archivero').load('index.php',{arch:'init'},function(){
			// Inicializa datos.
			$(this).data('folder',cfg.carpeta);
			$(this).data('file','');
			// Funcionalidad de subir ficheros.
			var obj = $("#arch_upload");
			obj.on('dragenter', function (e){
					    e.stopPropagation();
					    e.preventDefault();
					    $(this).css('border', '2px solid #0B85A1');
					});
			obj.on('dragover', function (e){
					     e.stopPropagation();
					     e.preventDefault();
					});
			obj.on('drop', function (e){					 
					     $(this).css('border', '1px dotted #0B85A1');
					     e.preventDefault();
					     var files = e.originalEvent.dataTransfer.files;
					 
					     //We need to send dropped files to Server
					     handleFileUpload(files,obj);
					});
			$(document).on('dragenter', function (e){
					    e.stopPropagation();
					    e.preventDefault();
					});
			$(document).on('dragover', function (e){
					  e.stopPropagation();
					  e.preventDefault();
					  obj.css('border', '1px dotted #0B85A1');
					});
			$(document).on('drop', function (e){
					    e.stopPropagation();
					    e.preventDefault();
					});
			// Funcionalidad de botones.
			$(this).find('#arch_titulo')
				.css('cursor', 'move')
				.on("mousedown", function(e) {
			         var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
			        var z_idx = $drag.css('z-index'),
			            drg_h = $drag.outerHeight(),
			            drg_w = $drag.outerWidth(),
			            pos_y = $drag.offset().top + drg_h - e.pageY,
			            pos_x = $drag.offset().left + drg_w - e.pageX;
			        	$drag
			        		.css('z-index', 1000).parents()
			        		.on("mousemove", function(e) {
					            $('.draggable').offset({
					                top:e.pageY + pos_y - drg_h,
					                left:e.pageX + pos_x - drg_w
					            }).on("mouseup", function() {
					                $(this).removeClass('draggable').css('z-index', z_idx);
					            	});
					        })
							e.preventDefault(); // disable selection
				    })
			    .on("mouseup", function() {
				        if(opt.handle === "") {
				            $(this).removeClass('draggable');
				        } else {
				            $(this).removeClass('active-handle').parent().removeClass('draggable');
				        }
				    });	
			
			//...
			$(this).find('a.newFolder').click(newFolder);
			$(this).find('a.renameFile').click(renameFile);
			$(this).find('a.delFile').click(delFile);
			$(this).find('a.close').click(close);
			loadFolder(),loadFiles(),toolBar();
			});
	}
	function loadFolder(){
		var arch = $('#archivero');
		$('#arch_carpetas').load('index.php',{arch:'folders',folder:arch.data('folder'),file:arch.data('file')},
				function(){
					$(this).find('ul>ul').not('.home').slideToggle();
					$(this).find('.selected').parentsUntil('.home').slideToggle();
					$(this).find('li').click(function(){selectFolder($(this).data('folder'));});
				});
	}
	function loadFiles(){
		var arch = $('#archivero');
		$('#arch_archivos').load('index.php',{arch:'files',folder:arch.data('folder'),file:arch.data('file')},
				function(){
					$(this).find('li').click(function(){selectFile($(this).data('file'))});
				});
		var file = arch.data('file'); 
		if(file!=''){
			arch.data('file','');
			selectFile(file);
		}
	}
	function selectFolder(folder){
		var arch = $('#archivero');
		var li = arch.find('[data-folder="'+folder+'"]');
		arch.data('folder',folder);
		// Marca en la ventana de ficheros.
		$('#arch_carpetas li').removeClass('selected');
		li
			.addClass('selected')
			.next('ul').slideToggle();
		loadFiles();
	}
	function selectFile(file){
		var arch = $('#archivero');
		var li = arch.find('[data-file="'+file+'"]');
		file = (arch.data('file')==file?'':file);
		// Marca.
		arch.data('file',file);
		if(cfg.imagen!=''){
			var img = $('[data-idArchivo="'+cfg.imagen+'"]');
			for(var i=0;i<img.length;i++){
				img.get(i).src = 'cont/'+arch.data('folder')+'/'+arch.data('file');
			}
		}
		$('#arch_archivos li').removeClass('selected');
		if(file!='') li.addClass('selected');
		toolBar();
	}
	function toolBar(){
		var selected = ($('#archivero').data('file')!='');
		$('#arch_botones').find('a.file').each(function(){
			if(selected){
				$(this).show();
			}else{
				$(this).hide();
			}
		});
	}
	function close(){
		var arch = $('#archivero');
		if(arch.data('file')!=''){
			var valor = '';
			if(arch.data('folder')!=''){
				valor = arch.data('folder')+'/'+arch.data('file'); 
			}else{
				valor = arch.data('file');
			}
			$('#'+cfg.campo).val(valor);
		}
		arch.slideUp();
	}
	function newFolder(){
		var arch = $('#archivero');
		var li = $('<li>');
		var input =	$('<input type="text">');
		input
			.val('nueva_carpeta')
			.blur(function(){
				if($(this).val()!=''){
					var carpeta = arch.data('folder')+'/'+$(this).val();
					arch.data('folder',carpeta);
					$('#arch_carpetas').load('index.php',{arch:'newFolder',folder:arch.data('folder'),file:arch.data('file')},
							function(){loadFolder(),selectFolder(carpeta)});
				}
			})
			.appendTo(li);
		$('#arch_carpetas').find('.selected').after(li);
		input
			.focus()
			.select();
	}
	function renameFile(){
		var arch = $('#archivero');
		var li = $('<li>');
		var input =	$('<input type="text">');
		input
			.val(arch.data('file'))
			.blur(function(){
				var name = $(this).val(); 
				if(name!=''){
					$('#arch_archivos').load('index.php',{arch:'renFile',folder:arch.data('folder'),file:arch.data('file'),newName:name},
							function(){
								selectFolder(arch.data('folder'));
								selectFile(name);});
				}
			})
			.appendTo(li);
		$('#arch_archivos').find('.selected')
			.hide()
			.after(li);
		input
			.focus()
			.select();
	}
	function delFile(){
		var arch = $('#archivero');
		$('#arch_archivos').load('index.php',{arch:'delFile',folder:arch.data('folder'),file:arch.data('file')},
				function(){
					selectFolder(arch.data('folder'));
					});
		// DesMarca.
		arch.data('file','');
	}
	// Drag&drop files to upload	
	function sendFileToServer(formData,status){
	    var jqXHR=$.ajax({
	            xhr: function() {
	            var xhrobj = $.ajaxSettings.xhr();
	            if (xhrobj.upload) {
	                    xhrobj.upload.addEventListener('progress', function(event){
	                        var percent = 0;
	                        var position = event.loaded || event.position;
	                        var total = event.total;
	                        if (event.lengthComputable) {
	                            percent = Math.ceil(position / total * 100);
	                        }
	                        //Set progress
	                        status.setProgress(percent);	                    	
	                    }, false);
	                }
	            return xhrobj;
	        },
	    url: "index.php",
	    type: "POST",
	    contentType:false,
	    processData: false,
	        cache: false,
	        data: formData,
	        success: function(data){
	            status.setProgress(100);
	            status.statusbar.click(function(){
	        		var arch = $('#archivero');
	        		arch.data('file',status.statusbar.data('file'));
	            	selectFolder(arch.data('folder'));
	            });		
	        }
	    });	 
	    status.setAbort(jqXHR);
	}
	 
	var rowCount=0;
	function createStatusbar(obj){
	     this.statusbar = $("<li class='statusbar'></li>");
	     this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
	     this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
	     this.abort = $("<div class='abort'>Cancelar</div>").appendTo(this.statusbar);
	     $('#arch_archivos').find('ul').append(this.statusbar);
	 
	    this.setFileNameSize = function(name,size){
	        var sizeStr="";
	        var sizeKB = size/1024;
	        if(parseInt(sizeKB) > 1024){
	            var sizeMB = sizeKB/1024;
	            sizeStr = sizeMB.toFixed(2)+" MB";
	        }else{
	            sizeStr = sizeKB.toFixed(2)+" KB";
	        }	 
	        this.filename.html(name+' '+sizeStr);
            this.statusbar.attr('data-file',name);
	    }
	    this.setProgress = function(progress){      
	        var progressBarWidth =progress*this.progressBar.width()/ 100; 
	        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
	        if(parseInt(progress) >= 100){
	            this.abort.hide();
	        }
	    }
	    this.setAbort = function(jqxhr){
	        var sb = this.statusbar;
	        this.abort.click(function()
	        {
	            jqxhr.abort();
	            sb.hide();
	        });
	    }
	}
	function handleFileUpload(files,obj){
        var file = null;
        var folder = $('#archivero').data('folder');
        for (var i = 0; file = files[i]; i++) {
	        var status = new createStatusbar(obj); //Using this we can set progress.
	        status.setFileNameSize(file.name,file.size);
	        var fd = new FormData();
	        switch (file.type){
        	case 'image/png':
        	case 'image/jpeg':
        	case 'image/gif':
        		var reader = new FileReader();
    	        fd.append('arch','imageUp');
    	        fd.append('folder',folder);
	   			fd.append('file',file.name);
                reader.onload = (function (evt) {
            	   	var img = new Image();
            	   	img.onload = function(){
            	   			fd.append('source', resize(img));
            	   			sendFileToServer(fd,status);	
            	   		}
            	   	img.src = evt.target.result;
                    });
                reader.readAsDataURL(file);
        		break;
        	default:
    	        fd.append('arch','fileUp');
	        	fd.append('folder',folder);
    	        fd.append('file', file);
    	        sendFileToServer(fd,status);
	        }
	   }

	   function resize(img){
		   	var height = 0;
		   	var width = 1024;
		   	if (img.naturalWidth>width){
		   		/* Cálculo del nuevo alto */
		   		height = Math.round(width * img.naturalHeight /img.naturalWidth);
		   	}else{
		   		width = img.naturalWidth;
		   		height = img.naturalHeight;
		   	}

		   	var canvas = null;
		   	canvas = document.createElement("canvas");
		   	canvas.width = width;
		   	canvas.height = height;
		   	var ctx = canvas.getContext("2d"); 
		   	ctx.clearRect(0, 0, canvas.width, canvas.height);
		   	ctx.drawImage(img, 0, 0, width, height);
		   	
		   	var src='';
		   	/* Calcula segun el tipo de imagen */
		   	if (img.src.indexOf('image/jpeg')!=-1){
		   		src = canvas.toDataURL("image/jpeg");
		   	}else if (img.src.indexOf('image/png')!=-1){
		   		src = canvas.toDataURL("image/png");
		   	}else if (img.src.indexOf('image/gif')!=-1){
		   		src = canvas.toDataURL("image/gif");
		   	}
		   	return src;
	   }
	}
}