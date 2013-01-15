$(document).ready(function(){
	var loadmore = $('#load-more'), loadtext='';

	// Show the score when hovering the node
	$('.node').live("mouseenter", function() {
		$(this).addClass("node-hover"); 
	}).live("mouseleave", function() {
		$(this).removeClass("node-hover"); 
	});

	// If a node is clicked load it's content and show it.
	$('.node').live('click',function(e){
		if ( ['A','SUBMIT','INPUT','IMG'].indexOf(e.target.nodeName) != '-1' ) {
		} else {
			e.preventDefault();
			if ( $(this).children('.node-full').length > 0 ) { 
				$(this).children('.node-short').toggle();
				$(this).children('.node-full').toggle();
			} else {
				node_link = $(this).children('.node-actions').children('a.uri');
				uri = node_link.attr('href');

				if ( node_link[0].hostname == domain ) {
					$(this).children('.node-short').after('<div class="node-full right"><img src="/assets/img/loading.gif" alt="Cargando..." /></div>');
					$(this).children('.node-short').hide();
					$(this).children('.node-full').load(uri);
				} else {
					window.location.href=uri;
				}
			}
		}
	});

	var refresh = 60;

	loadNew = function() {
		$.get('/?q='+query+'&after='+after, function(data,code,xhr) {
			console.log(xhr);
			if ( xhr.status == '200' ) {
				$('content').children(':first.node').before(data);
				after += refresh;
			} else if ( xhr.status == '204' ) {
				after += refresh;
			}
		});
	}

	setInterval(loadNew, refresh*1000);

	// Ajax scroll
	$(window).scroll(function() {
		if( $(window).scrollTop() + $(window).height() > $(document).height() - 300 & !loadmore.hasClass('loading')) {
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


	// If user promotes a node
	$('.promote').live('click',function(e){
		e.preventDefault();
		e.stopPropagation();
		if ( logged ) {
			// Do promote
			form = $(this).closest('form');
			val = $(this).val();
			uri = form.children('input[name="uri"]').val();
			score = form.closest('.node').children('.node-actions').children('.node-score');
			score.text(parseInt(score.text()) + parseInt(val));
			$('#score').text(parseFloat($('#score').text()) - parseFloat(val));
			$.post(form.attr('action'),{"uri": uri, "promote": val},function(data){});

		} else {
			// Show login form
			$('.dropdown-toggle').parent().addClass('open');
		}
	});


	// Enlarge post textarea as needed
	var postanimate = function(target) {
		l = target.val().length;
		if ( l > 60 && l <= 240 ) {
			if ( parseInt(target.css('height')) != 200 ) {
				target.animate( {'height':'200px'},300 ); 
			}
		} else if ( l > 240 ) {
			if ( parseInt(target.css('height')) != 560 ) {
				target.animate( {'height':'560px'},300 ); 
			}
		} else {
			if ( parseInt(target.css('height')) != 84 ) {
				target.animate( {'height':'84px'},300 ); 
			}
		}
	}

	$('#post-content').focus(function(event){ 
		postanimate($(event.target));
	});
	$('#post-content').blur(function(event){ 
		$(event.target).animate( {'height':'28px'},300 ); 
	});
	$('#post-content').keyup(function(event){ 
		postanimate($(event.target));
	});
});

