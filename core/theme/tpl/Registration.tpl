<div style="width: 300px">
	<h3>Регистрация пользователя</h3>
	<br/>
{if $user->id == $config.core.guest_id}
	{if $error != NULL}
	<div style="color: #440000;border: 1px solid black;background-color: #FFFFEE">{$error}</div>
	<br/>
	{/if}
	<form method="POST" action="{$query}">
{foreach $inputs as $input}
	{if $input.type == 'hidden'}
		<input type="hidden" name="{$input.name}" value="{$input.value}" style="width: 150px" />
	{else if $input.type == 'checkbox'}
		<div {if $input.error != NULL}class="form-check-error"{/if}>
		<input type="checkbox" name="{$input.name}"{if $input.value == 'on'} checked{/if} />
		{$input.title}
		</div>
	{else if $input.type == 'captcha'}
		<div {if $input.error != NULL}class="form-check-error"{/if}>
		<input type="text" name="captcha" style="width: 150px" />
		<br/>
		<img src="/captcha" width="160" height="80" />
		</div>
	{else}
		{$input.title}
		<div {if $input.error != NULL}class="form-check-error"{/if}>
		<input type="{$input.type}" name="{$input.name}" value="{$input.value}" style="width: 150px" />
		</div>
	{/if}
	{if $input.error != NULL}
		<div style="color:red;">{$input.error}</div>
	{/if}
{/foreach}
	<br/>
	<input type="submit" value="Отправить" />
	<input type="submit" value="Отменить" />
	</form>
{else}
	Регистрация прошла успешно.
{/if}
</div>