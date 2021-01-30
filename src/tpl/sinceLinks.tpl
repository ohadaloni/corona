since:
{foreach from=$sinces item=s}
	{if $s == $since}
		{$s}
	{else}
		<a href="/corona/historyGraph?country={$country}&metric={$metric}&since={$s}">{$s}</a>
	{/if}
{/foreach}
