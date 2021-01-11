<tr style="background-color: #ddd">
	<td>
		<a href="#viewSource" title="View PHP Source Code">#</a>
	</td>
	<td>
	</td>
	<td>
		{if $links}
			<a target="legend" href="/corona/legend" title="Explanation of the column titles/metrics" style="color: red">Legend</a>
			{if $by == 'country'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=country"><img src="/images/arrowDown.png"></a>
			{/if}
		{else}
			<a target="legend" href="/corona/legend" title="Explanation of the column titles/metrics" style="color: #f88">Legend</a>
			{if $by == 'country'}
				<img src="/images/circles/fade/green.png">
			{/if}
		{/if}
	</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td>
		cases
		{if $links}
			{if $by == 'cases'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=cases"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'cases'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Cases Yesterday">y</a>
		{if $links}
			{if $by == 'yesterday'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=yesterday"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'yesterday'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		growth
		{if $links}
			{if $by == 'growth'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=growth"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'growth'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Doubling Time (in days)">dt</a>
		{if $links}
			{if $by == 'doubles'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=doubles"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'doubles'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		today
		{if $links}
			{if $by == 'today'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=today"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'today'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td>
		deaths
		{if $links}
			{if $by == 'deaths'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=deaths"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'deaths'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Deaths Yesterday">dy</a>
		{if $links}
			{if $by == 'deathsYesterday'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=deathsYesterday"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'deathsYesterday'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		growth
		{if $links}
			{if $by == 'deathsGrowth'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=deathsGrowth"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'deathsGrowth'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Doubling Time (in days)">ddt</a>
		{if $links}
			{if $by == 'deathsDoubles'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=deathsDoubles"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'deathsDoubles'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		today
		{if $links}
			{if $by == 'deathsToday'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=deathsToday"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'deathsToday'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td>
		recovered
		{if $links}
			{if $by == 'recovered'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=recovered"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'recovered'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		closed
		{if $links}
			{if $by == 'closed'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=closed"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'closed'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		active
		{if $links}
			{if $by == 'active'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=active"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'active'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		tests
		{if $links}
			{if $by == 'tests'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=tests"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'tests'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<!--
	<td>
		<a title="Tests Yesterday">ty</a>
		{if $links}
			{if $by == 'testsYesterday'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=testsYesterday"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'testsYesterday'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	-->
	<td>
		<a title="Vaccinated">v</a>
		{if $links}
			{if $by == 'vaccinated'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=vaccinated"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'vaccinated'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Vaccinated Yesterday">vy</a>
		{if $links}
			{if $by == 'vaccinatedYesterday'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=vaccinatedYesterday"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'vaccinatedYesterday'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td>
		<a title="Death Rate per Cases (%)">d%</a>
		{if $links}
			{if $by == 'casesDeathRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=casesDeathRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'casesDeathRate'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Death Rate per Closed Cases (%)">cd%</a>
		{if $links}
			{if $by == 'closedDeathRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=closedDeathRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'closedDeathRate'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td style="background-color: #ddd;" width="20px"> </td>
	<td>
		population
		{if $links}
			{if $by == 'population'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=population"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'population'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Cases Rate">CR</a>
		{if $links}
			{if $by == 'casesRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=casesRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'casesRate'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Population Death Rate">DR</a>
		{if $links}
			{if $by == 'populationDeathRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=populationDeathRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'populationDeathRate'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Active Cases Rate">AR</a>
		{if $links}
			{if $by == 'activeRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=activeRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'activeRate'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<!--
	<td>
		<a title="Test Rate">TR</a>
		{if $links}
			{if $by == 'testRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=testRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'testRate'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	-->
	<td>
		<a title="Vaccinated Rate">VR</a>
		{if $links}
			{if $by == 'vaccinatedRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=vaccinatedRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'vaccinatedRate'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Vaccinations Last Week Daily Average">VLWA</a>
		{if $links}
			{if $by == 'vaccinationLastWeekAverage'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=vaccinationLastWeekAverage"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'vaccinationLastWeekAverage'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		<a title="Vaccination Days Left">VDL</a>
		{if $links}
			{if $by == 'vaccinationDaysLeft'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=vaccinationDaysLeft"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'vaccinationDaysLeft'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
</tr>
