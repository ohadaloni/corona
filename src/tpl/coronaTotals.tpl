<tr style="background-color: #ddd">
	<td>*</td>
	<td><img src="/images/flags/world.png" /></td>
	<td>World</td>
	<td style="background-color: #ddd;" width="20px"></td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=cases"
			title="history graph"
			target="_blank"
		>{$totals.cases|numberFormat:0}</a>
	</td>
	<td align="right">{$totals.yesterday|numberFormat:0}</td>
	<td align="right">{$totals.R|numberFormat:2:'%'}</td>
	<td align="right">{$totals.today|numberFormat:0}</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td align="right">{$totals.deaths|numberFormat:0}</td>
	<td align="right">{$totals.deathsYesterday|numberFormat:0}</td>
	<td align="right">{$totals.deathsToday|numberFormat:0}</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td align="right">{$totals.recovered|numberFormat:0}</td>
	<td align="right">{$totals.closed|numberFormat:0}</td>
	<td align="right">{$totals.active|numberFormat:0}</td>
	<td align="right">{$totals.tests|numberFormat:0}</td>
	<td align="right">{$totals.vaccinated|numberFormat:0}</td>
	<td align="right">{$totals.vaccinatedYesterday|numberFormat:0}</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td align="right">{$totals.casesDeathRate|numberFormat:3:'%'}</td>
	<td align="right">{$totals.closedDeathRate|numberFormat:3:'%'}</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td align="right">{$totals.population|numberFormat:0}</td>
	<td align="right">{$totals.casesRate|numberFormat:3:'%'}</td>
	<td align="right">{$totals.populationDeathRate|numberFormat:4:'%'}</td>
	<td align="right">{$totals.activeRate|numberFormat:3:'%'}</td>
	<td align="right">{$totals.vaccinatedRate|numberFormat:1:'%'}</td>
	<td align="right">{$totals.vaccinationLastWeekAverage|numberFormat:0}</td>
	<td align="right">{$totals.vaccinationDaysLeft|numberFormat:0}</td>
</tr>
