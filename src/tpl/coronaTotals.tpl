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
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=yesterday"
			title="history graph"
			target="_blank"
		>{$totals.yesterday|numberFormat:0}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=R"
			title="history graph"
			target="_blank"
		>{$totals.R|numberFormat:2:'%'}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=Rplus"
			title="history graph"
			target="_blank"
		>{$totals.Rplus|numberFormat:2:'%'}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=today"
			title="history graph"
			target="_blank"
		>{$totals.today|numberFormat:0}</a>
	</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=deaths"
			title="history graph"
			target="_blank"
		>{$totals.deaths|numberFormat:0}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=deathsYesterday"
			title="history graph"
			target="_blank"
		>{$totals.deathsYesterday|numberFormat:0}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=deathsToday"
			title="history graph"
			target="_blank"
		>{$totals.deathsToday|numberFormat:0}</a>
	</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=recovered"
			title="history graph"
			target="_blank"
		>{$totals.recovered|numberFormat:0}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=closed"
			title="history graph"
			target="_blank"
		>{$totals.closed|numberFormat:0}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=active"
			title="history graph"
			target="_blank"
		>{$totals.active|numberFormat:0}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=vaccinated"
			title="history graph"
			target="_blank"
		>{$totals.vaccinated|numberFormat:0}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=vaccinatedYesterday"
			title="history graph"
			target="_blank"
		>{$totals.vaccinatedYesterday|numberFormat:0}</a>
	</td>
	<td align="right">
		<a
			href="/corona/historyGraph?country=World&metric=vaccinatedToday"
			title="history graph"
			target="_blank"
		>{$totals.vaccinatedToday|numberFormat:0}</a>
	</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td align="right">{$totals.casesDeathRate|numberFormat:3:'%'}</td>
	<td align="right">{$totals.closedDeathRate|numberFormat:3:'%'}</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td align="right">{$totals.population|numberFormat:0}</td>
	<td align="right">{$totals.casesRate|numberFormat:3:'%'}</td>
	<td align="right">{$totals.populationDeathRate|numberFormat:5:'%'}</td>
	<td align="right">{$totals.activeRate|numberFormat:3:'%'}</td>
	<td align="right">{$totals.vaccinatedRate|numberFormat:1:'%'}</td>
	<td align="right">{$totals.vaccinationLastWeekAverage|numberFormat:0}</td>
	<td align="right">{$totals.vaccinationDaysLeft|numberFormat:0}</td>
</tr>
