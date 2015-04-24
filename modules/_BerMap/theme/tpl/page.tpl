{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
{if $session->device_type == Desktop}
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
{else}
    <meta content='width=device-width,initial-scale=1,user-scalable=no' name='viewport'>
{/if}
	<meta name="autor" content="javof">
	<meta name="generator" content="NetBeans">
	<link rel="shortcut icon" href="{theme path='images/favicon.png'}" type="image/png" />
	<title>{if $section->name == 'home'}{$section->title}{else}{$title}{/if}</title>
	<link rel="stylesheet" href="{theme path='styles/bootstrap.min.css'}" type="text/css" />
	<link rel="stylesheet" href="{theme path='styles/font-awesome.min.css'}" type="text/css" />
	<script src="{theme path='scripts/jquery-1.11.2.min.js'}" ></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
	
	<script src="{theme path='morris/morris.min.js'}"></script>
	<link rel="stylesheet" href="{theme path='morris/morris.css'}">
	{if $debug.enable == True}
		<script>
			$(function() {
				history.replaceState( { link: 'main' }, 'Main');
			} );
			var pages = { main: function(){ modal_popup_hide(); } };
			
			var debug_enable = true;
			var debug_info = '{$debug.info}';
			var debug_log  = '{$debug.log}';
			var debug_dump = '{$debug.dump}';
			var debug_show = '{$debug.console_show}';
		</script>
		<script src="{theme path='js/debug.js'}"></script>
	{else}
		<script>
			var debug_enable = false;
		</script>
	{/if}
<!--[if (gte IE 6)&(lte IE 8)]>
    <script type="text/javascript" src="{theme path='scripts/selectivizr-min.js'}"></script>
<![endif]-->
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>

	
	<link rel="stylesheet" href="{theme path='ionslider/css/ion.rangeSlider.css'}" type="text/css" />
	<link rel="stylesheet" href="{theme path='ionslider/css/ion.rangeSlider.skinNice.css'}" type="text/css" />
	<script src="{theme path='ionslider/js/ion.rangeSlider.min.js'}" type="text/javascript"></script>
	
	<link rel="stylesheet" href="{theme path='styles/layout.css'}" type="text/css" />
	<link rel="stylesheet" href="{theme path='styles/main.css'}" type="text/css" />

	
	<script>
		//"use strict";
	//Убирает дергание скролбара
		$(function() {
			// Элемент-обертка
			var pageWrapper = $('.page-scroll');
			// Функция для вычисления ширины скроллбара
			function getScrollWidth(){
			  var measure = $('<div />').css({
				  width: 100,
				  height: 100,
				  overflowY: 'scroll',
				  visibility: 'hidden'
				}).appendTo('body'),
				  sw = measure.prop('offsetWidth') - measure.prop('clientWidth');
			  measure.remove();    
			  return sw;
			}
			// Собственно, сама функция компенсатора скролла
			function scrollCompensation() {
				var d = document;
				var rootEl = d.compatMode == 'BackCompat'? d.body : d.documentElement;
				var hasScroll = rootEl.scrollHeight > rootEl.clientHeight;
				var scrollW = getScrollWidth();
				pageWrapper.css('padding-left', (hasScroll ? scrollW : 0));
				return false;
			}
			// Вызываем функцию при загрузке, а так же, если размеры окна поменялись
			//$(window).on('load', scrollCompensation);
			//$(window).on('resize', scrollCompensation);
			//$('menu li a').on('click', scrollCompensation);
		});
    </script>
	<script>
	{literal}
		var layers = [];
		layers['mapboxLayer'] = L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'данные &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'изображения © <a href="http://mapbox.com">Mapbox</a>',
			id: 'examples.map-i875mjb7'
		});
		layers['osmLayer'] = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Автор данных и изображений &copy; <a href="http://openstreetmap.org">OpenStreetMap</a>, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
		});
		var map = null;
		$(function() {
			function onMapClick(e) {

			}
			map = L.map('map');
			map.addLayer(layers['mapboxLayer']);
			map.setView([59.4205, 56.793], 18);
			map.on('click', onMapClick);
		});
		function update_map() {
			map.invalidateSize();
		}
	{/literal}
    </script>
	<script>
		//"use strict";
		$(function() {
			var sidebar_collapse = function(){
				$('html').addClass('sidebar-collapse');
				$('body').addClass('sidebar-collapse');
				setTimeout(function(){
					update_map();
				}, 300);
			};
			$('.body-column.content').on('click', function(){
				if($('body').hasClass('sidebar-collapse') !== true) {
					sidebar_collapse();
				}
			});
			$('.btn-menu').on('click', function(){
				if($('body').hasClass('sidebar-collapse')) {
					$('html').removeClass('sidebar-collapse');
					$('body').removeClass('sidebar-collapse');
					update_map();
				} else {
					sidebar_collapse();
				}
			});
			$('.menu-item').on('click', function(){
					$('.section').css('display','none');
					$('.menu-item').removeClass('active');
				if($(this).hasClass('map')) {
					$('#map').css('display','block');
					$('.menu-item.map').addClass('active');
				} else if($(this).hasClass('articles')) {
					$('#articles').css('display','block');
					$('.menu-item.articles').addClass('active');
				} else if($(this).hasClass('chart')) {
					$('#chart').css('display','block');
					$('.menu-item.chart').addClass('active');
					print_chart();
				} else {
					$('#estate').css('display','block');
					$('.menu-item.estate').addClass('active');
				}
			});
			$('.user-bar').on('click', function() {
				if($('.user-panel').css('display')=='none') {
					$('.user-bar').addClass('active');
					$('.user-panel').css('display','block');
				} else {
					$('.user-bar').removeClass('active');
					$('.user-panel').css('display','none');
				}
			});
		});
    </script>
</head>
{if $session->device_type == Desktop}
<body>
{else}
<body class="mobile sidebar-collapse">
{/if}
	<div class="page-scroll">
		<div class="page-wrapper">
			<div class="page-header">
				<div class="btn-menu">
				</div>
				<a href="/" class="btn-home">
				BerMap.RU
				</a>
				<div class="find-bar" style="display: none;">
					<input type="text" placeholder="Поиск" />
				</div>
				<div class="user-bar">
					<!--IF(USER)THEN>
						<div class="user-avatar" style="background-image: url('user.png')"></div>
						<span>Имя</span>
					<!--ELSE-->
						
						<div class="user-avatar guest"></div>
						<span>Вход</span>
					<!--END IF-->
					
				</div>
				<div class="user-panel" style="display: none;">
					<!--IF(USER)THEN>
						<a class="btn" href="#">Профиль</a>
						<a class="btn" href="#">Выход</a>
					<--ELSE-->
						<input type="login" placeholder="Логин"/><br/>
						<input type="password" placeholder="Пароль"/><br/>
						<a class="btn" href="#">Войти</a>
					<!--END IF-->
				</div>
			</div>
			<div class="page-body">
				<ul class="body-menu menu">
					<div class="nav">
						<li class="menu-item map"><span><i class="fa fa-road"></i>Карта</span></li>
						<li class="menu-item articles"><span><i class="fa fa-inbox"></i>Новости</span></li>
						<li class="menu-item ads"><span><i class="fa fa-pencil-square-o"></i>Объявления</span></li>
						<li class="menu-item estate active"><span><i class="fa fa-home"></i>Аренда</span></li>
						<li class="menu-item transport"><span><i class="fa fa-truck"></i>Транспорт</span></li>
						<li class="menu-item poster"><span><i class="fa fa-bullhorn"></i>Афиша</span></li>
						<li class="menu-item poster"><span><i class="fa fa-comments-o"></i>Форум</span></li>
						<li class="menu-item chart"><span><i class="fa fa-bar-chart-o"></i>График</span></li>
					<div>
				</ul>
				<div class="body-wrapper">
					<div class="body-layout">
						<div class="body-column content">
							<div id="map" class="section" style="display: none;"></div>
							<div id="articles" class="section" style="display: none;">
								<div class="article">
									<span>сегодня в 14:22</span>
									<h1>Закрыта регистрация</h1>
									<p>Регистрироваться пока нельзя. Это необходимо для безопасности во время разработки. После открытия регистрации будут доступны: форум, публикация объявлений, статей, и дополнительные возможности.
									</p>
								</div>
								<div class="article">
									<span>сегодня в 10:20</span>
									<h1>Запуск BerMap в демонстрационном режиме</h1>
									<p>Сайт запущен в демонстрационном режиме, до завершения работ над всеми необходимыми разделами. Планируются следующие разделы: «Карта событий города», «Аренда недвижимости», «Карта общественного транспорта», «Афиша города», «Форум».
									</p>
								</div>
								<div class="top-button"></div>
							</div>
							<div id="chart" class="section" style="display: none;">
								<script>
								var chart1 = true;
								function print_chart(){
									if(chart1) {
										Morris.Area({
										  element: 'chart1',
										  behaveLikeLine: true,
										  data: [
											{ x: '2011 Q1', y: 3, z: 3 },
											{ x: '2011 Q2', y: 2, z: 1 },
											{ x: '2011 Q3', y: 2, z: 4 },
											{ x: '2011 Q4', y: 3, z: 1 }
										  ],
										  xkey: 'x',
										  ykeys: ['y', 'z'],
										  labels: ['Y', 'Z']
										});
									}
									chart1 = false;
								};
								</script>
								<div id="chart1" style="min-width: 200px; min-height:200px;"></div>
							</div>
							<div id="estate" class="section" style="display: block;">
								<div class="box">
									<div class="box-header">
										<h3>Поиск жилья</h3>
										<div class="btn-group">
											<button type="button" class="btn btn-default" title="список">
												<i class="fa fa-fw fa-align-justify"></i>
											</button>
											<button type="button" class="btn btn-default" title="плитка">
												<i class="fa fa-fw fa-th"></i>
											</button>
											<button type="button" class="btn btn-default" title="карта">
												<i class="fa fa-fw fa-map-marker"></i>
											</button>
										</div>
									</div>
									<div class="box-body find-rent">
										<div class="block">
											<span class="form-label">Сниму</span>
											<div class="btn-group">
												<button type="button" class="btn btn-default">Квартиру</button>
												<button type="button" class="btn btn-default">Комнату</button>
											</div>
											<br/>
											<span class="form-label">Комнат</span>
											<div class="btn-group">
												<button type="button" class="btn btn-default">1</button>
												<button type="button" class="btn btn-default">2</button>
												<button type="button" class="btn btn-default">3</button>
												<button type="button" class="btn btn-default">4</button>
												<button type="button" class="btn btn-default">?</button>
											</div>
										</div>
										<div class="block">
											<!--IF(MOBILE)>
											<div class="block-table">
												<div class="block-row">
													<div class="block-cell">
														
													</div>
													<div class="block-cell">
														мин.
													</div>
													<div class="block-cell">
														
													</div>
													<div class="block-cell">
														макс.
													</div>
												</div>
												<div class="block-row">
													<div class="block-cell">
														<span class="form-label">Цена</span>
													</div>
													<div class="block-cell">
														<div class="input-price min">
															<input type="text" value="0"/>
														</div>
													</div>
													<div class="block-cell">
														 - 
													</div>
													<div class="block-cell">
														<div class="input-price max">
															<input type="text" value="100 000"/>
														</div>
													</div>
												</div>
											</div>
											<!--ELSE-->
											<div class="block-table">
												<div class="block-row">
													<div class="block-cell">
														<span class="form-label">Цена</span>
													</div>
													<div class="block-cell rent-slider">
														<input type="text" id="example_id" name="example_name" value="0;30000" />
														<script>
															$(function(){
																$("#example_id").ionRangeSlider({
																	min: 0,
																	max: 30000,
																	step: 100,
																	drag_interval: false,
																	type: 'double',
																	postfix: " руб",
																	grid: true,
																	grid_num: 4
																});
															});
														</script>
													</div>
												</div>
											</div>
											<!--END IF-->
										</div>
									</div>
								</div>
								<div class="objects">
								
									<div class="box object">
										<div class="box-body find-rent">
											<h3>ул. Ленина, 48</h3>
											Цена: 0 руб
										</div>
									</div>
									
									<div class="box object">
										<div class="box-body find-rent">
											<h3>ул. Пятилетки, 48</h3>
											Цена: 0 руб
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<body>
</html>