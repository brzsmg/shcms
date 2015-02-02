{* Smarty *}
<div>
Пользователей: {$statistic->registrations.count} |
Всего запросов: {$statistic->queries.count} |

{if $user->id == $config.core.guest_id}
<a class="button" href="/enter">Войти</a> |
<a class="button" href="/registration">Регистрация</a>
{else}
	{$user->first_name} <a class="button" href="?exit">Выход</a>
{/if}
</div>
