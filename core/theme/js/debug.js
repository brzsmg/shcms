/////////
if (typeof modal_popup_update != 'function') {
	var modal_popup_showing = false;
	var modal_popup_update = function()
	{
		$('#modal_popup_box').css('width',500);
		$('#modal_popup_box').css('height',370);
		var viewport_w = $( window ).width();
		var viewport_h = $( window ).height();
		var mb_w = $('#modal_popup_box').width();
		var mb_h = $('#modal_popup_box').height();
		var newleft = (viewport_w - mb_w) / 2;
		var newtop = (viewport_h - mb_h) / 2;
		$('#modal_popup_box').css('margin-left',newleft);
		$('#modal_popup_box').css('margin-top',newtop);
	}
	var modal_popup_show = function()
	{
		$('#modal_popup_background').css('display','block');
		modal_popup_showing = true;
	}
	var modal_popup_hide = function()
	{
		$('#modal_popup_background').css('display','none');
		modal_popup_showing = false;
	}
	var modal_popup_open = function()
	{
		history.pushState( { link: 'debug' } , 'Debug', '?debug');
		subhistory_count++;
		modal_popup_show();
	}
	var modal_popup_close = function()
	{
		modal_popup_hide();
		window.history.go(-1);
		subhistory_count--;
	}
	$(function(){
		if($('#modal_popup_background').length == 0) {
			var css = '<style type="text/css">';
			css +='#modal_popup_background{overflow: hidden;background-color: rgba(0,0,0,.5);position: fixed;z-index:1001;right: 0px;top: 0px;display: none;width:100%;height:100%;}';
			css +='#modal_popup_box{cursor:default;height: 350px;width:400px;background-color: #EEEEEE;border: 1px solid #AAAAAA;border-radius: 6px;box-shadow: 0 5px 7px rgba(0, 0, 0, 0.4);}';
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
				modal_popup_hide();
				window.history.go(-subhistory_count);
				subhistory_count = 0;
			}
		}
	});
}
/////////


var debug_init_state = false;
function debug_show_tab(t)
{
	var tab = 'Info';
	if (t==0){ tab = 'Info'; }else
	if (t==1){ tab = 'Log'; }else
	if (t==2){ tab = 'Dump' };
	$('#DebugInfo').css('display','none');
	$('#DebugLog').css('display','none');
	$('#DebugDump').css('display','none');
    $('#DebugBtnInfo').removeClass('debug-btn-act');
    $('#DebugBtnLog').removeClass('debug-btn-act');
    $('#DebugBtnDump').removeClass('debug-btn-act');
    
	$('#Debug'+tab).css('display','block');
    $('#DebugBtn'+tab).addClass('debug-btn-act');
    if(tab == 'Log') {
		objDiv = $('#DebugLog')[0];
		objDiv.scrollTop = objDiv.scrollHeight;
	}
}

function debug_popup_show(t)
{
	$('#modal_popup_box').html('<div style="opacity: 1;padding: 10px;"><b style="font-size: 20px;">Console</b><input type="button" value="x" onClick="modal_popup_close();" style="padding: 0px;width:15px;float:right;"/></div><div id="debug_btns"></div><div style="background-color:#FFFFFF;border: 1px solid #AAAAAA;border-width: 1px 0px;height:250px;font-size: 15px;padding: 10px;"><div id="DebugInfo" style="overflow: auto;height:250px;display: block;">Info</div><div id="DebugLog" style="cursor:text;overflow: auto;height:250px;display: none;">Log</div><div id="DebugDump" style="cursor:text;overflow: auto;height:250px;display: none;">Dump</div></div><input type="button" onClick="modal_popup_close();" style="margin:4px 0px 0px 4px;" value="Ok">');
	$('#debug_btns').append('<div id="DebugBtnInfo" class="debug-btn debug-btn-act" onClick="debug_show_tab(0)">Information</div>');
	$('#debug_btns').append('<div id="DebugBtnLog" class="debug-btn" onClick="debug_show_tab(1)">Log</div>');
	$('#debug_btns').append('<div id="DebugBtnDump" class="debug-btn" onClick="debug_show_tab(2)">Dump</div>');
	
	$('#DebugInfo').html('<p>'+debug_info+'</p>');
	$('#DebugLog').html('<p>'+debug_log+'</p>');
	$('#DebugDump').html('<p>'+debug_dump+'</p>');
	
	modal_popup_update();
    modal_popup_show();
	debug_show_tab(t);
}

function debug_popup_open(t)
{
	history.pushState( { link: 'debug' } , 'Debug', '?debug');
	subhistory_count++;
	debug_popup_show(t);
}
function debug()
{
    if(modal_popup_showing) {
        modal_popup_close();
    } else {
        debug_popup_open(0);
    }
}

$(function(){
	if(!debug_init_state) {
		debug_init_state = true;
		var css = '<style type="text/css">';
		css +='.debug-info{color: #000022;white-space: nowrap;}';
		css +='.debug-error{color: #880000;white-space: nowrap;}';
		css +='.debug-warning{color: #666600;}';
		css +='.debug-btn{cursor:pointer;background-color: #DDDDDD;border: 1px solid #AAAAAA;border-radius: 6px 6px 0 0;display:inline;margin-right:10px;padding: 1px;margin-bottom:2px; }';
		css +='.debug-btn-act{background-color: #FFFFFF;border-bottom: 0px;margin-bottom:0px;padding: 2px;}';
		css +='</style>';
		$('head').append(css);
    }
	if(pages) {
		pages.debug =function () {
			debug_popup_show(0);
		};
	}
	if((debug_show == 'Y') || (document.location.search == '?debug')) {
		debug_popup_open(1);
	}
});

$(document).keyup(function(e) {
	var event = event || e;
	//[ctrl] + [~]
	if((e.ctrlKey)&&(event.keyCode == 192)) {
		debug();
	}
});


