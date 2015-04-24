if (typeof modal_popup_update != 'function') {
	var modal_popup_showing = false;
	var subhistory_count = 0;
	var pages = { main: function(){ modal_popup_hide(); } };
	var main = false;
	var modal_popup_update = function()
	{
		//$('#modal_popup_box').css('width',500);
		//$('#modal_popup_box').css('height',370);
		var viewport_w = $( window ).width();
		var viewport_h = $( window ).height();
		var mb_w = $('#modal_popup_box').width();
		var mb_h = $('#modal_popup_box').height();
		var newleft = (viewport_w - mb_w) / 2;
		var newtop = (viewport_h - mb_h) / 2;
		$('#modal_popup_box').css('margin-left',newleft);
		$('#modal_popup_box').css('margin-top',newtop);
	};
	var modal_popup_show = function()
	{
		$('#modal_popup_background').css('display','block');
		modal_popup_showing = true;
	};
	var modal_popup_hide = function()
	{
		$('#modal_popup_background').css('display','none');
		modal_popup_showing = false;
	};
	var modal_popup_open = function()
	{
		history.pushState( { link: 'debug' } , 'Debug', '?debug');
		subhistory_count++;
		modal_popup_show();
	};
	var modal_popup_close = function()
	{
		modal_popup_hide();
		window.history.go(-1);
		subhistory_count--;
	};
	$(function(){
		if($('#modal_popup_background').length == 0) {
			var css = '<style type="text/css">';
			css +='#modal_popup_background{overflow: hidden;background-color: rgba(0,0,0,.5);position: fixed;z-index:1001;right: 0px;top: 0px;display: none;width:100%;height:100%;}';
			css +='#modal_popup_box{cursor:default;height: 370px;width:500px;background-color: #EEEEEE;border: 1px solid #AAAAAA;border-radius: 6px;box-shadow: 0 5px 7px rgba(0, 0, 0, 0.4);}';
			css +='</style>';
			$('head').append(css);
			$('body').append('<div id="modal_popup_background"></div>');
			$('#modal_popup_background').append('<div id="modal_popup_box"></div>');
		}
		modal_popup_update();
		$(window).resize(function(e)
		{
			modal_popup_update();
		});
		/*$(function(){
			$('#modal_popup_background').click(function(){
				modal_popup_close();
			});
		});*/
	});
	$(document).keyup(function(e) {
		var event = event || e;
		//[Esc]
		if((event.keyCode == 27)&&(modal_popup_showing)) {
			if(subhistory_count != 0) {
				if(main != true) {
					history.pushState( { link: '/' } , '/', '/');
					//Открываем главное окно
				}else {
					window.history.go(-subhistory_count);
					//Закрываем все окна
				}
				modal_popup_hide();
				subhistory_count = 0;
			} else {

			}
		}
	});
}

function lurl(url) {
	if(url.indexOf('?') != -1) {
		url = url+'&block';
	} else {
		url = url+'?block';
	}
	$.ajax( {
		url: url,
		dataType : "json",
		success: function (data, textStatus) {
			//$('#popup').html(data);
			$('#modal_popup_box').html(data.body);
			if(window.debug_log) {
				debug_log = debug_log + data.debug_log;
			}
			modal_popup_show();
			//$('#modal_popup_background').css('display','block');
			//modal_popup_showing = true;
			//modal_popup_update();
		},
		error: function (data, textStatus) {
			alert(textStatus);
		}
	} );
}

function link(url) {
	lurl(url);
	history.pushState( { link: url } , url, url);
	subhistory_count++;
}

function send(id_form, ispopup) {
	if(ispopup) {
		var formData = new FormData($('#'+id_form)[0]);
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "?block");
		xhr.setRequestHeader( "Content-Type",  "application/x-www-form-urlencoded" );
		xhr.onload = function(event) {
			if (xhr.status == 200) {
				$('#modal_popup_box').html(xhr.responseText);
			} else {
				alert(xhr.status);
			}
		};
		xhr.send(formData);
	} else {
		$('#'+id_form).submit();
	}
}

$(function() {
	if(window.location.pathname == '/') {
		main = true;
		history.replaceState( { link: 'main' }, 'Main');
	} else {
	
	}
	
	window.addEventListener('popstate', function(e) {
		var event = event || e;
		if (event.state !== null) {
			if(event.state.link in pages) {
				pages[event.state.link]();
			} else {
				lurl(event.state.link);
			}
		}
	}, false);
} );





