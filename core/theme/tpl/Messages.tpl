{* Smarty *}
{*
Эта страница для работы с сообщениями
*}
<style>
#message {
	background-color: #FFFFFF;height: 250px;
}
.text-bold {
	font-weight: bold;
}
</style>
{if $create !== NULL && $to !== NULL}
	<h4>Отправка сообщения</h4>
	Пользователю <u>{$to}</u><br/>
	<textarea></textarea>
{else}
	{if $message != NULL}
		<h4>Сообщение</h4>
		От: {$message.to}<br/>
		Дата: {$message.date_send|date_format}<br/>
		Тема: {$message.title}<br/>
		<br/>
		<div id="message">
		{$message.message}
		</div>
	{else}
		<h4>Сообщения</h4>
		{foreach $messages as $msg}
			<div class="{if $msg.date_read == 0}text-bold{/if}">
				<a {link path="/messages/"|cat:$msg.id popup='true'}>Открыть</a>
				{$msg.to} -
				{$msg.date_send|date_format} -
				{$msg.title}
			</div>
		{/foreach}
	{/if}
{/if}
<br/>
