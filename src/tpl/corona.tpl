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
			<td>{$No}</td>
			<td>
				{if $row.country == 'Israel' || $row.country == 'Philippines' || $row.country == $myCountry}
					<span style="color: blue">{$row.country}</span>
				{else}
					<a title="{$row.country}" style="text-decoration: none; color: black;">{$row.country|truncate:12}</a>
					<a href="/corona/myCountry?country={$row.country}&by={$by}" title="My Country"><span style="color: blue">*</span></a>
				{/if}
			</td>
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=cases"
					target="_blank"
				>{$row.cases|numberFormat:0}</a>
			</td>
			<td align="right">{$row.yesterday|numberFormat:0}</td>
			<td align="right">{$row.growth|numberFormat:2:'%'}</td>
			<td align="right">{$row.doubles|numberFormat:0}</td>
			<td align="right">{$row.today|numberFormat:0}</td>
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">
				<a
					href="/corona/historyGraph?country={$row.country}&metric=deaths"
					target="_blank"
				>{$row.deaths|numberFormat:0}</a>
			</td>
			<td align="right">{$row.deathsYesterday|numberFormat:0}</td>
			<td align="right">{$row.deathsGrowth|numberFormat:2:'%'}</td>
			<td align="right">{$row.deathsDoubles|numberFormat:0}</td>
			<td align="right">{$row.deathsToday|numberFormat:0}</td>
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">{$row.recovered|numberFormat:0}</td>
			<td align="right">{$row.closed|numberFormat:0}</td>
			<td align="right">{$row.active|numberFormat:0}</td>
			<!--	<td align="right">{$row.yActive|numberFormat:0}</td>	-->
			<!--	<td align="right">{$row.activeDelta|numberFormat:0}</td>	-->
			<td align="right">{$row.tests|numberFormat:0}</td>
			<!--	<td align="right">{$row.testsYesterday|numberFormat:0}</td>	-->
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">{$row.casesDeathRate|numberFormat:3:'%'}</td>
			<td align="right">{$row.closedDeathRate|numberFormat:3:'%'}</td>
			<td style="background-color: #ddd;" width="20px"> </td>
			<td align="right">{$row.population|numberFormat:0}</td>
			<td align="right">{$row.casesRate|numberFormat:3:'%'}</td>
			<td align="right">{$row.EcasesRate|numberFormat:1:'%'}</td>
			<td align="right">{$row.activeRate|numberFormat:3:'%'}</td>
			<td align="right">{$row.populationDeathRate|numberFormat:3:'%'}</td>
			<td align="right">{$row.EpopulationDeathRate|numberFormat:4:'%'}</td>
			<td align="right">{$row.testRate|numberFormat:1:'%'}</td>
		</tr>
	{/foreach}
	</table>
</center>
