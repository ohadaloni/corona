since:
{foreach from=$sinces item=since}
	<a href="/corona/historyGraph?country={$country}&metric={$metric}&since={$since}">{$since}</a>
{/foreach}
