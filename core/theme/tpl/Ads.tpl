{* Smarty *}
{if $page == 'add'}
	<form>
		
	</form>
{else if $page == 'advert'}
	{if $advert !== NULL}
		{if $user->id}
			Ваше объявление
			<form>

			</form>
		{/if}
	{else}
		Объявление не найдено.
	{/if}	
{else if $page == 'ads'}
	Список
{else if $page == 'fav'}
	Список избранного
{else if $page == 'my'}
	Список моих
{/if}