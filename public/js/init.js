(function($) {

	skel.init({
		reset: 'full',
		breakpoints: {
			global: { href: 'css/style.css', containers: 1400, grid: { gutters: ['2em', 0] } },
			xlarge: { media: '(max-width: 1680px)', href: 'css/style-xlarge.css', containers: 1200 },
			large: { media: '(max-width: 1280px)', href: 'css/style-large.css', containers: 960, grid: { gutters: ['1.5em', 0] }, viewport: { scalable: false } },
			medium: { media: '(max-width: 980px)', href: 'css/style-medium.css', containers: '90%', grid: { zoom: 2 } },
			small: { media: '(max-width: 736px)', href: 'css/style-small.css', containers: '90%!', grid: { gutters: ['1.25em', 0], zoom: 3 } },
			xsmall: { media: '(max-width: 480px)', href: 'css/style-xsmall.css' }
		},
		plugins: {
			layers: {
				
				// Config.
					config: {
						transformTest: function() { return skel.vars.isMobile; }
					},
				
				// Navigation Button.
					navButton: {
						breakpoints: 'medium',
						height: '4em',
						html: '<span class="toggle" data-action="toggleLayer" data-args="navPanel"></span>',
						position: 'top-left',
						side: 'top',
						width: '6em'
					},

				// Navigation Panel.
					navPanel: {
						animation: 'overlayX',
						breakpoints: 'medium',
						clickToHide: true,
						height: '100%',
						hidden: true,
						html: '<div data-action="navList" data-args="nav"></div>',
						orientation: 'vertical',
						position: 'top-left',
						side: 'left',
						width: 250
					}

			}
		}
	});

	$(function() {
		
		var $window = $(window),
			$body = $('body'),
			$banner = $('#banner'),
			$header = $('#header');

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');
			
			$window.on('load', function() {
				window.setTimeout(function() {
					$body.removeClass('is-loading');
				}, 500);
			});

		// Forms (IE<10).
			var $form = $('form');
			if ($form.length > 0) {

				$form.find('.form-button-submit')
					.on('click', function() {
						$(this).parents('form').submit();
						return false;
					});
		
				if (skel.vars.IEVersion < 10) {
					$.fn.n33_formerize=function(){var _fakes=new Array(),_form = $(this);_form.find('input[type=text],textarea').each(function() { var e = $(this); if (e.val() == '' || e.val() == e.attr('placeholder')) { e.addClass('formerize-placeholder'); e.val(e.attr('placeholder')); } }).blur(function() { var e = $(this); if (e.attr('name').match(/_fakeformerizefield$/)) return; if (e.val() == '') { e.addClass('formerize-placeholder'); e.val(e.attr('placeholder')); } }).focus(function() { var e = $(this); if (e.attr('name').match(/_fakeformerizefield$/)) return; if (e.val() == e.attr('placeholder')) { e.removeClass('formerize-placeholder'); e.val(''); } }); _form.find('input[type=password]').each(function() { var e = $(this); var x = $($('<div>').append(e.clone()).remove().html().replace(/type="password"/i, 'type="text"').replace(/type=password/i, 'type=text')); if (e.attr('id') != '') x.attr('id', e.attr('id') + '_fakeformerizefield'); if (e.attr('name') != '') x.attr('name', e.attr('name') + '_fakeformerizefield'); x.addClass('formerize-placeholder').val(x.attr('placeholder')).insertAfter(e); if (e.val() == '') e.hide(); else x.hide(); e.blur(function(event) { event.preventDefault(); var e = $(this); var x = e.parent().find('input[name=' + e.attr('name') + '_fakeformerizefield]'); if (e.val() == '') { e.hide(); x.show(); } }); x.focus(function(event) { event.preventDefault(); var x = $(this); var e = x.parent().find('input[name=' + x.attr('name').replace('_fakeformerizefield', '') + ']'); x.hide(); e.show().focus(); }); x.keypress(function(event) { event.preventDefault(); x.val(''); }); });  _form.submit(function() { $(this).find('input[type=text],input[type=password],textarea').each(function(event) { var e = $(this); if (e.attr('name').match(/_fakeformerizefield$/)) e.attr('name', ''); if (e.val() == e.attr('placeholder')) { e.removeClass('formerize-placeholder'); e.val(''); } }); }).bind("reset", function(event) { event.preventDefault(); $(this).find('select').val($('option:first').val()); $(this).find('input,textarea').each(function() { var e = $(this); var x; e.removeClass('formerize-placeholder'); switch (this.type) { case 'submit': case 'reset': break; case 'password': e.val(e.attr('defaultValue')); x = e.parent().find('input[name=' + e.attr('name') + '_fakeformerizefield]'); if (e.val() == '') { e.hide(); x.show(); } else { e.show(); x.hide(); } break; case 'checkbox': case 'radio': e.attr('checked', e.attr('defaultValue')); break; case 'text': case 'textarea': e.val(e.attr('defaultValue')); if (e.val() == '') { e.addClass('formerize-placeholder'); e.val(e.attr('placeholder')); } break; default: e.val(e.attr('defaultValue')); break; } }); window.setTimeout(function() { for (x in _fakes) _fakes[x].trigger('formerize_sync'); }, 10); }); return _form; };
					$form.n33_formerize();
				}

			}

		// Scrolly links.
			$('.scrolly').scrolly();
		
		// Header.
		// If the header is using "alt" styling and #banner is present, use scrollwatch
		// to revert it back to normal styling once the user scrolls past the banner.
			if ($header.hasClass('alt')
			&&	$banner.length > 0) {

				$window.on('load', function() {

					$banner.scrollwatch({
						delay:		0,
						range:		0.98,
						anchor:		'top',
						on:			function() { $header.addClass('alt reveal'); },
						off:		function() { $header.removeClass('alt'); }
					});

					skel.change(function() {
						
						if (skel.isActive('medium'))
							$banner.scrollwatchSuspend();
						else
							$banner.scrollwatchResume();
						
					});

				});
			
			}
			
		// Dropdowns.
			$('#nav > ul').dropotron({
				alignment: 'right'
			});
			
		// Slider.
			var $sliders = $('.slider');
			
			if ($sliders.length > 0) {
				
				$sliders.slidertron({
					mode: 'fadeIn',
					seamlessWrap: true,
					viewerSelector: '.viewer',
					reelSelector: '.viewer .reel',
					slidesSelector: '.viewer .reel .slide',
					advanceDelay: 0,
					speed: 400,
					fadeInSpeed: 1000,
					autoFit: true,
					autoFitAspectRatio: (840 / 344),
					navPreviousSelector: '.nav-previous',
					navNextSelector: '.nav-next',
					indicatorSelector: '.indicator ul li',
					slideLinkSelector: '.link'
				});

				$window
					.on('resize load', function() {
						$sliders.trigger('slidertron_reFit');
					})
					.trigger('resize');				
			
			}
		
	});

})(jQuery);
var testAjax = null;
function runTest(){
	if(testAjax==null) {
        $('#results_container').slideUp();
        $('#run_test').html('Running...');
        $('#domain_value').val($('#test_url').val());
        testAjax = $.ajax({
            url: "api.php",
            type:"POST",
            dataType: "json",
            data: {action: "get_report", url: $('#test_url').val()},
            success: function (data) {
                $('#run_test').html('Run Test');
                testAjax = null;
                if(typeof data.error!=="undefined"){
                	showError(data.error);
				}
				if(typeof data.rates!=="undefined"){
                	$('#test_res_container').empty();
                	for(var i=0;i<data.rates.length;i++){
                		var box = '';
                		if(data.rates[i].price>0){
                			box = '<input type="checkbox" onchange="recalculateTotal(\'.test_result_input\',\'#upgrades_total\')" class="test_result_input" name="'+data.rates[i].key+'" value="'+data.rates[i].price+'" id="'+data.rates[i].key+'" checked><label style="margin-bottom: 0px;" for="'+data.rates[i].key+'">'+data.rates[i].price+data.rates[i].currency+'</label>';
						}
                		var option = '<tr><td>'+data.rates[i].name+'</td><td>'+data.rates[i].status+'</td><td>'+data.rates[i].comment+'</td><td>'+box+'</td> </tr>';
                        $('#test_res_container').append(option);
					}
					$('#results_container').slideDown();
				}
                $('#test_res_container').append('<br><button onclick="$(\'#order_form\').submit();" class="button special fit">ORDER UPGRADES for <span id="upgrades_total"></span>$</button><a href="'+data.pdf+'" >PDF report</a>');
                recalculateTotal('.test_result_input','#upgrades_total');
            },
            error: function () {
                $('#run_test').html('Run Test');
                testAjax = null;
            }
        });
    }
}
function recalculateTotal(selector,target){
	var total = 0;
	$(selector+':checked').each(function(){
		total+=parseFloat($(this).val());
	});
	$(target).html(Math.round(total*100)/100);
}
function showError(msg) {
	alert(msg);
}
function createUser(){
    $.ajax({
        url: "api.php",
        type: "POST",
        dataType: "json",
        data: {action: "register", email: $('#reglogin').val(), pass: $('#regpass').val(), pass2: $('#regpass2').val()},
        success: function (data) {
			if(data.status==0){
				location.reload(); return;
			}
            if(typeof data.error !== "undefined"){
                showError(data.error);
            }

        },
        error: function () {
        	showError("Check your Internec connection");
        }
    });
}
function loginUser(){
	$.ajax({
        url: "api.php",
        type: "POST",
        dataType: "json",
        data: {action: "login", login: $("input[name='loginlogin']").last().val(), pass: $("input[name='loginpass']").last().val()},
        success: function (data) {
            if(data.status==0){
                location.reload(); return;
            }
            if(typeof data.error !== "undefined"){
                showError(data.error);
            }

        },
        error: function () {
            showError("Check your Internec connection");
        }
    });
}
