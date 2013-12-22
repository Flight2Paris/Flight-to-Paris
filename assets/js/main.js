$(document).ready(function(){

	// .node hover
	$('.node').live("mouseenter", function() {
		$(this).addClass("node-hover"); 
	}).live("mouseleave", function() {
		$(this).removeClass("node-hover"); 
	});

	// .node click
	$('.node').live('click',function(e){
		if ( ['A','SUBMIT','INPUT','IMG','BUTTON'].indexOf(e.target.nodeName) != '-1' ) {
		} else {
			e.preventDefault();
			if ( $(this).find('.node-full').length > 0 ) { 
				$(this).find('.node-short').toggle();
				$(this).find('.node-full').toggle();
			} else {
				node_link = $(this).find('a.uri');
				uri = node_link.attr('href');
				if ( node_link[0].hostname == domain ) {
					$(this).find('.node-short').after('<div class="node-full span12"><img src="/assets/img/loading.gif" alt="Cargando..." /></div>');
					$(this).find('.node-short').hide();
					$(this).find('.node-full').load(uri);
				} else {
					window.location.href=uri;
				}
			}
		}
	});

	// load new nodes
	var loadmore = $('#load-more'), loadtext='';
	var refresh = 60;
	loadNew = function() {
		if ( loadmore.is(':visible') ) {
		$.get('/?q='+query+'&after='+after, function(data,code,xhr) {
			if ( xhr.status == '200' ) {
				$('content').children(':first.node').before(data);
				after += refresh;
			} else if ( xhr.status == '204' ) {
				after += refresh;
			}
		});
		}
	}

	setInterval(loadNew, refresh*1000);

	// Ajax scroll
	$(window).scroll(function() {
		if( ($(window).scrollTop() + $(window).height()) > ($(document).height() - 300) &&
			loadmore.is(':visible')  &&
			!loadmore.hasClass('loading') ) {

			loadmore.addClass('loading');
			loadtext=loadmore.html();
			loadmore.html('<img src="/assets/img/loading.gif" />');
			skip += pagesize;
			$.get('/?skip='+skip+'&q='+query+'&before='+before, function(data) {
				loadmore.html(loadtext);
				loadmore.removeClass('loading');
				loadmore.parent().before(data);
			});
		}
	});


	var promote = function ( node, amount) {

		if ( logged ) {

			newScore = parseInt( node.data('score') ) + parseInt(amount);
			node.data('score', newScore);

			score = node.find('.node-score');
			score.html( '<i class="icon-star"></i> ' + newScore );

			$.post( node.find('.score-form').attr('action'), {"uri": node.data('uri') , "promote": amount}, function(data){} );

		} else {
			// Show login form
			$('#menu-btn').click();
		}
	}

	// If user promotes a node
	$('.promote').live('click',function(e){
		e.preventDefault();
		e.stopPropagation();
		
		node = $(this).closest('.node');
		amount = $(this).val();

		promote(node,amount);
	});

	$('.score-form').live('submit',function(e){
		e.preventDefault();
		e.stopPropagation();

		node = $(this).closest('.node');
		amount = $(this).find('input[type="text"]').val();

		promote(node,amount);
	});
	
	// Enlarge post textarea as needed
	var lastanimate = new Date().getTime(); 
	var postanimate = function(target) {
		l = target.val().length;
		h = parseInt(target.data('height'));

		if ( isNaN(h) ) {
			h = 0;
		}

		if ( l < 30 ) {
			newh = 84;
		} else if ( l < 60 ) {
			newh = 150;
		} else if ( l < 120 ) {
			newh = 280;
		} else {
			newh = 560
		}

		if ( newh > h ) {
			newh = newh + 'px';
			target.data('height',newh);
			target.animate( {'height':newh}, 300);
		}
	}
	
	var render_preview = function ( markdown ) {
		$.post( '/preview', {"markdown": markdown}, function(data){
			$('#preview').html(data);
		});
	}

	$('#post-content').focus(function(event){ 
		postanimate($(event.target).data('height',0));
	});
	$('#post-content').blur(function(event){ 
		$(event.target).animate( {'height':'28px'},300 ); 
	});
	$('#post-content').keyup(function(event){
		d = new Date();
		if ( d.getTime() > lastanimate + 800 ) {
			lastanimate = d.getTime();
			postanimate($(event.target));
			render_preview($(event.target).val());
		}
	});



	// Reload captcha
	var captcha = $('#captcha');
	if ( captcha.length > 0 ) {

	$('#refresh-captcha').on('click',function(e){
		if ( ! captcha.hasClass('loading') ) {
			e.preventDefault();
			captcha.addClass('loading');
			captcha.attr('src','/assets/img/loading.gif');
		}
	});

	captcha.on('load',function(){
		if ( captcha.hasClass('loading') ) {
			d = new Date();
			captcha.removeClass('loading');
			captcha.attr('src','/lib/captcha/?' + d.getTime());
		}
	});

	$('.nosubmit').keydown(function(e){
		if(e.keyCode == 13 ) {
			e.preventDefault();
			e.stopPropagation();
			return false;
		}
	});

	}
});

