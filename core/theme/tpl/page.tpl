{* Smarty *}
<!DOCTYPE html>
<html>
<head>
<!-- Meta -->
	<meta charset="utf-8"/>
{if $session->device_type == Desktop}
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
{else}
	<meta content='width=device-width,initial-scale=1,user-scalable=no' name='viewport'>
{/if}
    <meta name="autor" content="javof">
    <meta name="generator" content="NetBeans">
	<title>{$title}</title>
<!-- Source -->
	<link rel="shortcut icon" href="{theme path='img/lab.png'}" type="image/png" />
    <link rel="stylesheet" type="text/css" href="{theme path='css/page.css'}">

	<script src="http://www.google.com/jsapi"></script>
	<!--script src="{theme path='js/Chart.js'}" charset="utf-8"></script!-->
	<!--script src="geoip.js"></script-->
	<script src="{theme path='js/jquery.min.js'}"></script>
<script src="{theme path='js/modal.js'}"></script>
{if $debug.enable == True}
	<script>
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
</head>
<body>
	<div id="modal_popup_background">
		<div id="modal_popup_box"></div>
	</div>
	<div id="page-wrapper">
		<div id="page-header">
			<div id="header">
			{*Пользователей: {$statistic->registrations.count} |
			Всего запросов: {$statistic->queries.count} |*}
			<a class="button" href="/">Главная</a> |
{if $user->id == $config.core.guest_id}
			<a class="button" {link path='/enter' popup='true'}>Войти</a> |
			<a class="button" href="/registration">Регистрация</a>
{else}
			<a class="button" {link path='/users/'|cat:$user->id}>{$user->first_name}</a> |
			<a class="button" href="?exit">Выход</a>
{/if}
			{*use data='Authentication'}
			{view name='Authentication'}
			{view name='Article'*}
			</div>
		</div>
		<div id="page-content">
			{$block.content}
		</div>
		<div id="page-buffer"></div>
	</div>
	<div id="page-footer">
		<div id="footer">
			{if $session->device_type != Desktop}
			<div class="text-info-mobile">Мобильная версия</div>
			{else}
			<div class="text-info-mobile">Десктопная версия</div>
			{/if}
			<div id="regions_div"></div>
		</div>
	</div>
</body>
</html>