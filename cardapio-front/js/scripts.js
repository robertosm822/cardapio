// execute callback when the page is ready:
$(document).ready(function(){

	$('.produto').append('<div class="clear"></div>');

	// ----- Carregar Paginas
	$('.loadAjax').on("click", function(){
		var hrefLink		= $(this).attr('href');
		var wAll			= $('#all').width();
		var header			= $('#header');
		var corpo			= $('#corpo');
		var footer			= $('#footer');
		var transicao		= 'fade';
		var timeTransition	= 300;

		splitHref	= hrefLink.split('#');
		if (splitHref[1]) {
			pagina	= splitHref[1];
		} else {
			pagina	= splitHref[0];
		}
		if ( (pagina=='') || (pagina=='inicio') ) { pagina = 'home'; }
		
		splitPagina	= pagina.split('_');
		if ( splitPagina[1] ) {
			idioma	= splitPagina[0] + '_';
			arquivo	= splitPagina[1];
		} else {
			idioma	= '';
			arquivo	= splitPagina[0];
		}
		var link	= idioma + arquivo;
		
		// Conteudos a carregar na página
		if(arquivo=='menu')	{ linkHeader= 'topo';			}
		else				{ linkHeader= idioma + 'topo';	}
		linkCorpo	= idioma + arquivo;
		linkFooter	= idioma + 'rodape';
		//alert(linkHeader);	alert(linkCorpo);	alert(linkFooter);

		// ------------------------------------------- Transition: 'fade'
		if (transicao == 'fade') {
			// Topo
			header.find('.content').fadeOut(timeTransition/2);
			setTimeout( function() {
				header.find('#'+ linkHeader +'').fadeIn(timeTransition);
			}, timeTransition*2);
			// Corpo
			corpo.find('.content').fadeOut(timeTransition/2);
			setTimeout( function() {
				corpo.find('#'+ linkCorpo +'').fadeIn(timeTransition);
				setTimeout(function(){
					var alturaTopo		= $('#header').height();
					var alturaBgHome	= corpo.find('.bg_home').height();
					var alturaRodape	= $('#footer').height();
					var larguraTela		= $(window).width();		// Altura da Tela
					var alturaTela		= $(window).height();		// Altura da Tela
					
					if (larguraTela < 800) {
						var alturaMargem	= ((alturaTela-alturaTopo-alturaBgHome-alturaRodape-8) / 2);
						if (alturaMargem <= '20') { alturaMargem = '20px'; }
						corpo.css('min-height', ''+( (alturaTela - alturaTopo - alturaRodape-8) +'px') );
						corpo.find('.bg_home').css('margin-top', alturaMargem);
						corpo.find('.bg_home').css('margin-bottom', alturaMargem);
					} else {
						var alturaMargem	= ((alturaTela-alturaBgHome-alturaRodape) / 2);
						if (alturaMargem <= '0') { alturaMargem = '20px'; }
						corpo.find('.bg_home').css('margin-top', alturaMargem);
					}
				}, timeTransition);
			}, timeTransition);
			// Rodape
			footer.css('margin-bottom', '0px').find('.content').fadeOut(timeTransition/2);
			setTimeout( function() {
				footer.find('#'+ linkFooter +'').fadeIn(timeTransition/2);
			}, timeTransition);
		}
		
		// // Destacando Menu
		header.find("#"+idioma+"topo").find("nav").find("ul").find("li a").removeClass("titulo");
		header.find("#"+idioma+"topo").find("nav").find("ul").find("li a").removeClass("titulo");
		header.find("#"+idioma+"topo").find("nav").find("ul").find("li a.subtitulo").each(function () {
			var esteHref = $(this).attr("href");
			$(".titulo");

			if ( ('#'+linkCorpo) == esteHref) {
				$(this).addClass("titulo");
				header.find("#"+idioma+"topo").find("nav").hide();
				return false;
			}
		});
	});
	
	//----------------------------------------------- Scripts Internos
	var header			= $('#header');
	var corpo			= $('#corpo');
	var footer			= $('#footer');
	var larguraTela		= $(window).width();	// Altura da Tela
	var alturaTela		= $(window).height();	// Altura da Tela
	var alturaTopo		= header.height();		// Altura do Rodape '#header'
	var alturaCorpo		= corpo.height();		// Altura do Rodape '#corpo'
	var alturaBgHome	= '525';				// Altura das Divs '.bg_home'
	var alturaRodape	= footer.height();		// Altura do Rodape '#footer'
	var alturaMargem	= ((alturaTela-alturaTopo-alturaCorpo-alturaRodape) / 2);
	
	if (larguraTela < 800) {
		var alturaMargem	= ((alturaTela-alturaTopo-alturaBgHome-alturaRodape-8) / 2);
		if (alturaMargem <= '20') { alturaMargem = '20px'; }
		corpo.css('min-height', ''+( (alturaTela - alturaTopo - alturaRodape-8) +'px') );
		corpo.find('.bg_home').css('margin-top', alturaMargem);
		corpo.find('.bg_home').css('margin-bottom', alturaMargem);
	} else {
		var alturaMargem	= ((alturaTela-alturaBgHome-alturaRodape) / 2);
		if (alturaMargem <= '0') { alturaMargem = '20px'; }
		corpo.find('.bg_home').css('margin-top', alturaMargem);
	}
	
	// ----- Foto (.photo)
	// Quando estiver em tamanho normal
	var photozoom			= $('#photoZoom');		// Caixa que comporta a foto grande
	var livre				= 'sim';				// livre para realizar uma acao
	
	// ------------------------------------------------------------
	$(window).resize(function(){ if ( $('#imgZoom').length ) { resizeFoto('ajustar'); } });
	$(window).scroll(function(){ if ( $('#imgZoom').length ) { resizeFoto('ajustar'); } });
	
	// Redefinir tamanho da foto
	function resizeFoto (acao) {
		var larguraTela		= $(window).width();		// Largura da tela
		var alturaTela		= $(window).height();		// Altura da Tela
		var topo			= $(window).scrollTop();	// Distancia do Topo
		var bt_close		= photozoom.find('.close');	// Botao fechar foto
		var img				= photozoom.find('img');	// Imagem grande
		var topo			= $(window).scrollTop();	// Distancia do Topo
		var widthG			= 672;						// Largura da foto pixels
		var heightG			= 447;						// Altura da foto pixels
		var paddingG		= 3;						// Padding da imagem
		var marginG			= '0px 0px 10px 0px';		// Margem da foto
		var proporcao		= (heightG / widthG);		// Proporcao Largura x Altura
		var proporcaoH		= (widthG / heightG);		// Proporcao Altura x Largura
		var widthG_98		= (widthG	* 0.98);
		var heightG_98		= (heightG	* 0.98);
		var widthG_99		= (widthG	* 0.99);
		var heightG_99		= (heightG	* 0.99);

		var alturaHeader	= $('#header').height();
		var alturaCorpo		= $('#corpo').height();
		var alturaFooter	= $('#footer').height();
		var totalAlturaTela	= (alturaCorpo + alturaFooter);
		//alert(totalAlturaTela);

		// alert('LarguraTela: '+larguraTela+'\nAlturaTela: '+alturaTela+'\nProporcao: '+proporcao+'\nProporcaoH: '+proporcaoH);

		if ((larguraTela-50) <= widthG) {
			widthG			= (larguraTela-50);
			heightG			= (widthG * proporcao);
		}
		if ((alturaTela-50) <= heightG) {
			heightG			= (alturaTela-50);
			widthG			= (heightG * proporcaoH);
		}
		if ( larguraTela < 800) {
			totalAlturaTela = (totalAlturaTela + alturaHeader);
		}

		if (livre == 'sim') {
			if ( (acao == 'abrir') || (acao == 'ajustar') ) {
				livre = 'nao';
				photozoom.css('height', totalAlturaTela);
				if (acao == 'abrir') { photozoom.fadeIn(600); }

				bt_close.css({
					'margin-top':	(topo + ((alturaTela/2) - (heightG/2) - (paddingG)) - 22 ) +'px',
					'margin-left':	((larguraTela/2) + (widthG/2) - (paddingG/2) - 20 )+'px'
				});
				bt_close.fadeIn();
				img.css({
					'width':		widthG+'px',
					'height':		heightG+'px',
					'margin-top':	(topo + ((alturaTela/2) - (heightG/2) - (paddingG)) ) +'px',
					'margin-left':	((larguraTela/2) - (((widthG)/2)) ) +'px'
				});
				livre = 'sim';
			}
			if (acao == 'fechar') {
				livre = 'nao';
				bt_close.fadeOut();
				photozoom.fadeOut();
				photozoom.find('img').remove();
				livre = 'sim';
			}
		}
	}

	function abreFoto(x) {
		var nomemini		= $(x).attr('src');
		//var vetorfoto		= nomemini.split('_thumb');
		//var nomefoto		= vetorfoto[0] + vetorfoto[1];		
		var bt_close		= photozoom.find('.close');	// Botao fechar foto
		//var img				= photozoom.find('img');	// Imagem grande
		//var imagem			= '<img src="' + nomefoto + '" width="1px" height="1px" id="imgZoom" />';
		var imagem			= '<img src="' + nomemini + '" id="imgZoom" />';
		photozoom.append(imagem);
		//alert(photozoom.find('img').width());
		resizeFoto('abrir');
	}

	function fechaFoto() {
		resizeFoto('fechar');
	}

	// Close - Clica para fechar
	photozoom.bind('click', function(){
		fechaFoto();
	});
	
	// ----- Itens (.item)
	$('.item').click(function(){
		if ( $(this).hasClass('ativo') ) {
			var imagemAberta = photozoom.find('img').attr('id');
			if ( !imagemAberta ) {
				$(this).removeClass('ativo');
			}
		} else {
			var imagemAberta = photozoom.find('img').attr('id');
			if ( !imagemAberta ) {
				$(this).addClass('ativo');
			}
		}
	});
	// Photo - Clica para abrir
	$('.photo').bind('click', function(){
		abreFoto( this );
	});
	// ----- Menu Mobile
	// --- Abrir e Fechar a caixa de menu -------------------------
	$('.menu-mobile').click(function(){
		$('nav.categ').toggle();
	});
	// ----- Ajuda
	// --- Abrir e Fechar a caixa de ajuda ------------------------
	$('.help-question').click(function(){
		var idPergunta	= this.id;
		var idResposta	= idPergunta.split('-').pop();
		
		if ( $(this).hasClass('active') ) {
			$('.help-question').removeClass('active');
			$('.help-answer').fadeOut(200);
		} else {
			$('.help-question').removeClass('active');
			$(this).addClass('active');
			$('.help-answer').fadeOut(200);
			setTimeout( function() {
				$('#ha-'+idResposta+'').fadeIn(300);
			}, 250);
		}
	});
	
	
});
