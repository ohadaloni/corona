<center>
	<table>
	{foreach from=$rows key=key item=row}
		{assign var=No value=`$key+1`}
		{if $key == 0}
			{msuShowTpl file="coronaTitles.tpl" links=true}
			{msuShowTpl file="coronaTotals.tpl"}
		{elseif  $key % 10 == 0}
			{msuShowTpl file="coronaTitles.tpl" links=false}
			{msuShowTpl file="coronaTotals.tpl"}
		{/if}
		{if $row.country == 'Israel' || $row.country == 'Philippines' || $row.country == $myCountry}
			<tr style="background-color:#aff;">
		{else}
			<tr class="coronaRow">
		{/if}
			<td>
				<a name="{$row.country}" style="color:black;">{$No}</a>
			</td>
			<td> {if $row.flag}<img src="/images/flags/{$row.flag}" />{/if}</td>
			<td>
				<a target="news" title="{$row.country} (click for news)" style="text-decoration: none; color: black;" href="https://google.com/search?q={$row.country} corona news">{$row.country|truncate:12}</a>
				<a href="/corona/myCountry?country={$row.country}&by={$by}" title="My Country"><span style="color: blue">*</span></a>
			</td>
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=cases"
					title="history graph"
					target="_blank"
				>{$row.cases|numberFormat:0}</a>
			</td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=yesterday"
					title="history graph"
					target="_blank"
				>{if $row.yesterday}{$row.yesterday|numberFormat:0}{else}---{/if}</a>
			</td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=R"
					title="history graph"
					target="_blank"
				>{if $row.R}{$row.R|numberFormat:2:'%'}{else}---{/if}</a>
			</td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=Rplus"
					title="history graph"
					target="_blank"
				>{if $row.Rplus}{$row.Rplus|numberFormat:2:'%'}{else}---{/if}</a>
			</td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=today"
					title="history graph"
					target="_blank"
				>{if $row.today}{$row.today|numberFormat:0}{else}---{/if}</a>
			</td>
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=deaths"
					title="history graph"
					target="_blank"
				>{$row.deaths|numberFormat:0}</a>
			</td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=deathsYesterday"
					title="history graph"
					target="_blank"
				>{if $row.deathsYesterday}{$row.deathsYesterday|numberFormat:0}{elseif $row.deaths}---{/if}</a>
			</td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=deathsToday"
					title="history graph"
					target="_blank"
				>{if $row.deathsToday}{$row.deathsToday|numberFormat:0}{elseif $row.deaths}---{/if}</a>
			</td>
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=recovered"
					title="history graph"
					target="_blank"
				>{$row.recovered|numberFormat:0}</a>
			</td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=closed"
					title="history graph"
					target="_blank"
				>{$row.closed|numberFormat:0}</a>
			</td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=active"
					title="history graph"
					target="_blank"
				>{$row.active|numberFormat:0}</a>
			</td>
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">{$row.casesDeathRate|numberFormat:3:'%'}</td>
			<td align="right">{$row.closedDeathRate|numberFormat:3:'%'}</td>
			<td style="background-color: #ddd;" width="20px"> </td>

			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=population"
					title="rates history graph"
					target="_blank"
				>{$row.population|numberFormat:0}</a>
			</td>

			<td align="right">{$row.casesRate|numberFormat:3:'%'}</td>
			<td align="right">{$row.populationDeathRate|numberFormat:5:'%'}</td>
			<td align="right">{$row.activeRate|numberFormat:3:'%'}</td>
		</tr>
	{/foreach}
	</table>
</center>
