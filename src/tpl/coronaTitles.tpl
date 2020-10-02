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
		yesterday
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
		yesterday
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
	<!--
	<td>
		yesterday
		{if $links}
			{if $by == 'yActive'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=yActive"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'yActive'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		change
		{if $links}
			{if $by == 'activeDelta'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=activeDelta"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'activeDelta'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	-->
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
	<td style="background-color: #ddd;" width="20px"> </td>
	<td>
		<a title="Death Rate per Cases (%)">death%</a>
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
		<a title="Death Rate per Closed Cases (%)">Cdeath%</a>
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
		<a title="Effective Cases Rate = Heard Immunity Factor if 90% asymptomatic were never tested">ECR</a>
		{if $links}
			{if $by == 'EcasesRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=EcasesRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'EcasesRate'}
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
	<td>
		<a title="Death Rate from Population (%)">Pdeath%</a>
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
		<a title="Effective Death Rate from Population (%)">EPdeath%</a>
		{if $links}
			{if $by == 'EpopulationDeathRate'}
				<img src="/images/circles/green.png">
			{else}
				<a href="/?by=EpopulationDeathRate"><img src="/images/arrowDown.png"></a>
			{/if}
		{elseif $by == 'EpopulationDeathRate'}
			<img src="/images/circles/fade/green.png">
		{/if}
	</td>
	<td>
		testRate
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
</tr>
