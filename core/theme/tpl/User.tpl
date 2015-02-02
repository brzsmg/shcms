{* Smarty *}
{*
Эта страница выводит всю информацию о пользователе,
Если пользователь смотрит информацию о себе, ему доступно редактирование.
*}
{if $exists}
	<h4>Информация о пользователе</h4>
	<br/>
	<div class="left">
		<div class="frame-s64 avatar" style="background-image: url('{$person->getAvatar()}');">
			<div class="frame-s64" style="background-image: url('{theme path='img/frame.png'}');">
			</div>
		</div>
		<br/>
		{if $user->id != $person->id}
		<a class="button" {link path='/messages?create&to='|cat:$person->id popup='true'}>Сообщение</a>
		<br/>
		{else}
		<a class="button" {link path='/messages' popup='true'}>Сообщения</a>
		<br/>
		{/if}
	</div>
	<div class="left">
	{if $debug.enable == True}
	Идентификатор: {$person->id}<br/>
	{/if}
	ФИО: <b>{$person->last_name} {$person->first_name} {$person->middle_name}</b><br/>
	Дата регистрации: {$person->create_date|date_format} <br/>
	Дата изменений: {$person->update_date|date_format} <br/>
	{if $user->id == $person->id}
		{if $person->balance != NULL}Баланс: {$person->balance} <br/>{/if}
	{/if}
	</div>
{else}
	<h2>Неизвестный</h2>
	Такого пользователя не существует.
{/if}
