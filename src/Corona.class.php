<?php
/*------------------------------------------------------------*/
class Corona extends Mcontroller {
	/*------------------------------------------------------------*/
	protected $coronaUtils;
	protected $Mmemcache;
	/*------------------------------*/
	private $startTime;
	private $ttl;
	/*------------------------------------------------------------*/
	public function __construct() {
		parent::__construct();
		$this->coronaUtils = new CoronaUtils;
		$this->Mmemcache = new Mmemcache;
		$this->ttl = 60;
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	protected function before() {
		$this->startTime = microtime(true);
		ini_set('max_execution_time', 10);
		ini_set("memory_limit", "30M");

		$this->coronaUtils->prior($this->controller, $this->action);
		$this->Mview->showTpl("head.tpl");
		$this->Mview->showTpl("header.tpl");
	}
	/*------------------------------*/
	protected function after() {
		$this->Mview->runningTime($this->startTime);
		$this->Mview->showTpl("footer.tpl");
		$this->Mview->showTpl("foot.tpl");
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	public function index() {
		$this->showBy();
	}
	/*------------------------------------------------------------*/
	public function viewSource() {
		$src = highlight_file(__FILE__, true);
		$this->Mview->pushOutput($src);
	}
	/*------------------------------------------------------------*/
	public function showBy() {
		$by = @$_REQUEST['by'];
		if ( ! $by )
			$by = "cases";
		$rows = $this->getRows();
		if ( ! $rows ) {
			$this->Mview->msg("No Rows");
			return;
		}
		$ucfirst = ucfirst($by);
		usort($rows, array($this, "by$ucfirst"));
		$totals = array(
			'country' => "World",
			'cases' => Mutils::arraySum($rows, "cases"),
			'dbyCases' => Mutils::arraySum($rows, "dbyCases"),
			'yesterday' => Mutils::arraySum($rows, "yesterday"),
			'today' => Mutils::arraySum($rows, "today"),
			'deaths' => Mutils::arraySum($rows, "deaths"),
			'dbyDeaths' => Mutils::arraySum($rows, "dbyDeaths"),
			'deathsYesterday' => Mutils::arraySum($rows, "deathsYesterday"),
			'vaccinated' => Mutils::arraySum($rows, "vaccinated"),
			'vaccinatedToday' => Mutils::arraySum($rows, "vaccinatedToday"),
			'vaccinatedYesterday' => Mutils::arraySum($rows, "vaccinatedYesterday"),
			'deathsToday' => Mutils::arraySum($rows, "deathsToday"),
			'recovered' => Mutils::arraySum($rows, "recovered"),
		);
		$this->ammendRow($totals);
		$this->Mview->showTpl("corona.tpl", array(
			'rows' => $rows,
			'totals' => $totals,
			'by' => $by,
			'myCountry' => @$_COOKIE['myCountry'],
		));
	}
	/*------------------------------------------------------------*/
	public function legend() {
		$this->Mview->showTpl("legend.tpl");
	}
	/*------------------------------------------------------------*/
	public function myCountry() {
		$country = $_REQUEST['country'];
		$this->Mview->setCookie("myCountry", $country);
		$this->index();
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	private function ratesGraph($rows, $title) {
		$xAxis = array();
		$lines = array();
		foreach ( $rows as $row ) {
			$date = $row['date'];
			$time = strtotime($date);
			$wday = date('D', $time);
			$x = "$wday $date";
			$xAxis[] = $x;
			$lines[] = array(
				'cases' => $row['casesRate'],
				'deaths' => $row['populationDeathRate'],
				'active' => $row['activeRate'],
				'vaccinated' => $row['vaccinatedRate'],
			);
		}
		$ml = new MlineGraphs;
		$ml->lineGraphs($lines, $title, "crHistoryuGraph", $xAxis);
	}
	/*------------------------------------------------------------*/
	private function graph($rows, $metric, $title) {
		$xAxis = array();
		$lines = array();
		foreach ( $rows as $row ) {
			$date = $row['date'];
			$time = strtotime($date);
			$wday = date('D', $time);
			$x = "$wday $date";
			$xAxis[] = $x;
			$lines[] = array(
				$metric => $row[$metric],
			);
		}
		$ml = new MlineGraphs;
		$ml->lineGraphs($lines, $title, "crHistoryGraph", $xAxis);
	}
	/*------------------------------------------------------------*/
	public function worldGraph($metric, $since) {
		$notCountries = array(
			"Diamond Princess",
			"MS Zaandam",
		);
		if ( $since == 'allTime' ) {
			$sinceCond = true;
			$sinceTitle = "";
		} else {
			$sinceCond = "date >= '$since'";
			$sinceTitle = " since $since";
		}
		$notCountries = "'".implode("', '", $notCountries)."'";
		$notCountriesCond = "country not in ( $notCountries )";
		$conds = "$notCountriesCond and $sinceCond";
		$worldRows = array();
		$fields = array(
			"date",
			"sum(cases) as cases",
			"sum(deaths) as deaths",
			"sum(recovered) as recovered",
			"sum(vaccinated) as vaccinated",
		);
		$fields = implode(", ", $fields);
		$orderBy = "order by 1";
		$groupBy = "group by 1";
		$sql = "select $fields from covid19 where $conds $groupBy $orderBy";
		$baseRows = $this->Mmodel->getRows($sql, $this->ttl);

		$baseMetrics = array(
			'cases',
			'deaths',
			'recovered',
			'vaccinated',
		);
		if ( in_array($metric, $baseMetrics) ) {
			$rows = array();
			foreach ( $baseRows as $row )
				$rows[] = array(
					'date' => $row['date'],
					$metric => $row[$metric],
				);
			$title = "World cumulative $metric $sinceTitle";
			$this->graph($rows, $metric, $title);
			$this->Mview->showTpl("sinceLinks.tpl", array(
				'country' => 'World',
				'metric' => $metric,
				'since' => $since,
				'sinces' => $this->sinces(),
			));
			return;
		}
		switch ( $metric ) {
			case 'yesterday':
			case 'today':
				$rows = array();
				$title = "World daily cases $sinceTitle";
				$rows = array();
				foreach ( $baseRows as $key => $row ) {
					if ( $key == 0 )
						continue;
					$rows[] = array(
						'date' => $row['date'],
						'cases' => $row['cases'] - $baseRows[$key-1]['cases'],
					);
				}
				$this->graph($rows, 'cases', $title);
			break;
			case 'deathsYesterday':
			case 'deathsToday':
				$rows = array();
				$title = "World daily deaths $sinceTitle";
				$rows = array();
				foreach ( $baseRows as $key => $row ) {
					if ( $key == 0 )
						continue;
					$rows[] = array(
						'date' => $row['date'],
						'deaths' => $row['deaths'] - $baseRows[$key-1]['deaths'],
					);
				}
				$this->graph($rows, 'deaths', $title);
			break;
			case 'closed':
				$rows = array();
				$title = "World closed cases $sinceTitle";
				$rows = array();
				foreach ( $baseRows as $key => $row ) {
					if ( $key == 0 )
						continue;
					$rows[] = array(
						'date' => $row['date'],
						'closed' => $row['recovered'] + $row['deaths'],
					);
				}
				$this->graph($rows, 'closed', $title);
			break;
			case 'active':
				$rows = array();
				$title = "World active cases $sinceTitle";
				$rows = array();
				foreach ( $baseRows as $key => $row ) {
					$rows[] = array(
						'date' => $row['date'],
						'active' => $row['cases'] - $row['recovered'] - $row['deaths'],
					);
				}
				$this->graph($rows, 'active', $title);
			break;
			case 'vaccinatedToday':
			case 'vaccinatedYesterday':
				$rows = array();
				$title = "World daily vaccinations $sinceTitle";
				$rows = array();
				foreach ( $baseRows as $key => $row ) {
					if ( $key == 0 )
						continue;
					$rows[] = array(
						'date' => $row['date'],
						'vaccinated' => $row['vaccinated'] - $baseRows[$key-1]['vaccinated'],
					);
				}
				$this->graph($rows, 'vaccinated', $title);
			break;
			case 'R':
			case 'Rplus':
				$rows = array();
				$title = "World R $sinceTitle";
				$rows = array();
				foreach ( $baseRows as $key => $row ) {
					$rows[] = array(
						'date' => $row['date'],
						'R' => $this->R('World', $row['date']),
					);
				}
				$this->graph($rows, 'R', $title);
			break;
			default:
				Mview::print_r($_REQUEST, "_REQUEST", basename(__FILE__), __LINE__, null, false);
		}
		$this->Mview->showTpl("sinceLinks.tpl", array(
			'country' => 'World',
			'metric' => $metric,
			'since' => $since,
			'sinces' => $this->sinces(),
		));
	}
	/*------------------------------------------------------------*/
	public function historyGraph() {
		$country = @$_REQUEST['country'];
		$metric = @$_REQUEST['metric'];
		$since = @$_REQUEST['since'];
		if ( ! $since )
			$since = date("Y-m-01", time() - 91*24*3600);

		if ( ! $country || ! $metric )
			return;
		if ( $country == 'World' ) {
			$this->worldGraph($metric, $since);
			return;
		}

		$cumulative = array(
			'cases',
			'deaths',
			'recovered',
			'vaccinated',
		);
		$dailies = array(
			'today',
			'yesterday',
			'deathsToday',
			'deathsYesterday',
			'vaccinatedToday',
			'vaccinatedYesterday',
			'vaccinationLastWeekAverage',
		);
		$calced = array(
			'active',
			'population',
			'closed',
			'R',
			'Rplus',
		);

		$country = $this->Mmodel->str($country);
		$metric = $this->Mmodel->str($metric);

		if ( $since == 'allTime' ) {
			$sinceCond = true;
			$sinceTitle = "";
		} else {
			if ( in_array($metric, $dailies) )
				$sinceDate = date("Y-m-d", strtotime($since) - 24*3600);
			else
				$sinceDate = $since;
			$sinceDate = $this->Mmodel->str($sinceDate);
			$sinceCond = "date >= '$sinceDate'";
			$sinceTitle = " since $since";
		}

		$conds = "country = '$country' and $sinceCond";
		$orderBy = "order by date";

		if ( in_array($metric, $cumulative) ) {
			$title = "cumulative $metric in $country$sinceTitle";
			$sql = "select date, $metric from covid19 where $conds $orderBy";
			$rows = $this->Mmodel->getRows($sql, $this->ttl);
			$this->graph($rows, $metric, $title);
		} else if ( in_array($metric, $dailies) ) {
			$baseMetric = (
				$metric == 'vaccinatedToday'
				|| $metric == 'vaccinatedYesterday'
				|| $metric == 'vaccinationLastWeekAverage'
				) ?  "vaccinated" :
					 ( stristr($metric, 'deaths') ? 'deaths' : 'cases' );
			$title = "daily $baseMetric in $country$sinceTitle";
			$sql = "select date, $baseMetric from covid19 where $conds $orderBy";
			$baseMetricRows = $this->Mmodel->getRows($sql, $this->ttl);
			$rows = array();
			foreach ( $baseMetricRows as $key => $row ) {
				if ( $key > 0 )
					$rows[] = array(
						'date' => $row['date'],
						$baseMetric => $row[$baseMetric] - $baseMetricRows[$key-1][$baseMetric],
					);
			}
			$this->graph($rows, $baseMetric, $title);
		} else if ( in_array($metric, $calced) ) {
			$sql = "select * from covid19 where $conds $orderBy";
			$dataRows = $this->Mmodel->getRows($sql, $this->ttl);
			if ( $metric == 'population' ) {
				$title = "Rates/population in $country$sinceTitle";
				$this->ammendRows($dataRows);

				$this->ratesGraph($dataRows, $title);
			} else {
				$rows = $this->calcRows($dataRows, $metric);
				$metricName = $metric == 'Rplus' ? 'R' : $metric;
				$title = "$metricName in $country$sinceTitle";
				$this->graph($rows, $metric, $title);
			}
		} else {
			$this->Mview->error("historyGraph: $metric: Eh?");
			return;
		}
		$this->Mview->showTpl("sinceLinks.tpl", array(
			'country' => $country,
			'metric' => $metric,
			'since' => $since,
			'sinces' => $this->sinces(),
		));
	}
	/*------------------------------------------------------------*/
	private function calcRows($dataRows, $metric) {
		foreach ( $dataRows as $key => $dataRow ) {
			if ( $metric == 'active' ) {
				if ( $dataRow['recovered'] ) {
					$active = $dataRow['cases'] - ( $dataRow['deaths'] + $dataRow['recovered']);
					$dataRows[$key]['active'] = $active;
				}
			}
			if ( $metric == 'closed' ) {
				if ( $dataRow['recovered'] ) {
					$closed = $dataRow['deaths'] + $dataRow['recovered'];
					$dataRows[$key]['closed'] = $closed;
				}
			}
			if ( $metric == 'R' || $metric == 'Rplus') {
				$dataRows[$key][$metric] = $this->R($dataRow['country'], $dataRow['date']);
			}
		}
		$rows = array();
		foreach ( $dataRows as $dataRow )
			$rows[] = array(
				'date' => $dataRow['date'],
				$metric => $dataRow[$metric],
			);
		return($rows);
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	private function getRows() {
		$date = date("Y-m-d");
		$mkey = "getRows-$date";
		$rows = $this->Mmemcache->get($mkey);
		if ( $rows )
			return($rows);
		$todayCond = "date = '$date'";
		$obsoleteCountries = array(
			"Diamond Princess",
			"MS Zaandam",
		);
		$obsoleteCountryList = "'".implode("', '", $obsoleteCountries)."'";
		$obsoleteCond = "country not in ( $obsoleteCountryList )";
		$conds = "$todayCond and $obsoleteCond";

		$sql = "select * from covid19 where $conds";
		$rows = $this->Mmodel->getRows($sql, $this->ttl);
		if ( ! $rows ) {
			return(null);
		}
		$this->ammendRows($rows);
		$this->cleanRows($rows);
		$this->Mmemcache->set($mkey, $rows, $this->ttl);
		return($rows);
	}
	/*------------------------------------------------------------*/
	private function cleanRows(&$rows) {
		foreach ( $rows as $key => $row )
			$this->cleanRow($rows[$key]);
	}
	/*------------------------------*/
	private function cleanRow(&$row) {
		$row['country'] = str_replace("Cura&ccedil;ao", "Curacao", $row['country']);
	}
	/*------------------------------------------------------------*/
	private function ammendRows(&$rows) {
		foreach ( $rows as $key => $row )
			$this->ammendRow($rows[$key]);
	}
	/*------------------------------*/
	private function ammendRow(&$row) {
		$today = date("Y-m-d");
		$yesterday = date("Y-m-d", time() - 24*3600);
		$dby = date("Y-m-d", time() - 2*24*3600);
		$country = $row['country'];
		if ( $country != 'World' ) {
			$row['dbyCases'] = $this->metric($country, $dby, 'cases');
			$row['yCases'] = $this->metric($country, $yesterday, 'cases');
			$row['yRecovered'] = $this->metric($country, $yesterday, 'recovered');
			$row['dbyRecovered'] = $this->metric($country, $dby, 'recovered');
			$row['dbyDeaths'] = $this->metric($country, $dby, 'deaths');
			$row['yDeaths'] = $this->metric($country, $yesterday, 'deaths');
			$row['yClosed'] = $row['yRecovered'] + $row['yDeaths'];
			$row['dbyClosed'] = $row['dbyRecovered'] + $row['dbyDeaths'];
			$row['dbyVaccinated'] = $this->metric($country, $dby, 'vaccinated');
			$row['yVaccinated'] = $this->metric($country, $yesterday, 'vaccinated');

			$row['yesterday'] = $row['yCases'] - $row['dbyCases'];
			$row['today'] = $row['cases'] - $row['yCases'];
			if ( $row['recovered'] ) {
				$row['closed'] = $row['recovered'] + $row['deaths'];
				$row['active'] = $row['cases'] - $row['closed'];
			}
			$row['deathsYesterday'] = $row['yDeaths']- $row['dbyDeaths'];
			$row['vaccinatedToday'] = $row['vaccinated'] - $row['yVaccinated'];
			$row['vaccinatedYesterday'] = $row['yVaccinated'] - $row['dbyVaccinated'];
			$row['deathsToday'] = $row['deaths'] - $row['yDeaths'];
		}
		$row['R'] = $this->R($country);
		$row['Rplus'] = $this->Rplus($country);

		if ( $row['recovered'] ) {
			$row['closed'] = $row['recovered'] + $row['deaths'];
			$row['active'] = $row['cases'] - $row['closed'];
		}
		$row['casesDeathRate'] =
			$row['cases'] ?
				( $row['deaths'] / $row['cases'] ) * 100
				: 0;
		$row['closedDeathRate'] =
			@$row['closed'] ?
				( $row['deaths'] / $row['closed'] ) * 100
				: 0;
		$population = $this->population($country);
		if ( $population ) {
			$row['population'] = $population ;
			$row['casesRate'] = 
				( $row['cases'] / $population ) * 100 ;
			$row['EcasesRate'] = $row['casesRate'] * 10 ;
			$row['activeRate'] = 
				@$row['active'] ? ( $row['active'] / $population ) * 100 : 0 ;
			$row['populationDeathRate'] =
				( $row['deaths'] / $population ) * 100 ;
			$row['vaccinatedRate'] = 
				( $row['vaccinated'] / $population ) * 100 / 2 ; // rate shows 1/2, 2 doses per person
			$row['vaccinationLastWeekAverage'] = $this->weekAverage($country, false, 'vaccinated');
			if ( $row['vaccinationLastWeekAverage'] ) {
				$left2Vaccinate = $row['population'] * 2 - $row['vaccinated']; // 2 doses per person
				$row['vaccinationDaysLeft'] = round($left2Vaccinate / $row['vaccinationLastWeekAverage']);
			} else {
				$row['vaccinationDaysLeft'] = 0;
			}
		} else {
			$row['population'] = 0 ;
			$row['populationDeathRate'] = 0;
			$row['casesRate'] = 0;
			$row['EcasesRate'] = 0;
			$row['activeRate'] = 0;
			$row['vaccinatedRate'] = 0;
		}
		$row['flag'] = $this->flag($country);
	}
	/*------------------------------------------------------------*/
	private function flag($country) {
		$country = trim($country); // for 'Brunei '
		static $countries;
		if ( ! $countries ) {
			$sql = "select * from countries";
			$countries = $this->Mmodel->getRows($sql, 24*3600);
			$countries = Mutils::reIndexBy($countries, "name");
		}
		$exceptions = array(
			'World' => "world.png",
			'Channel Islands' => "gb.png", // not a separate country
		);
		if ( @$exceptions[$country] )
			return($exceptions[$country]);

		$matchCountries = array(
			'S. Korea' => "South Korea",
			'Caribbean Netherlands' => "Netherland Antilles",
			'Faeroe Islands' => "Faroe Islands",
			'Cura&ccedil;ao' => "Curacao",
			'Trinidad and Tobago' => "Trinidad &amp; Tobago",
			'Czechia' => "Czech Republic",
			'USA' => "United States",
			'UK' => "United Kingdom",
			'Serbia' => "Republic of Serbia",
			'Bosnia and Herzegovina' => "Bosnia &amp; Herzegovina",
			'Vatican City' => "Vatican City State",
			'Turks and Caicos' => "Turks &amp; Caicos Is",
			'Timor-Leste' => "East Timor",
			'Saint Lucia' => "St Lucia",
			'Saint Kitts and Nevis' => "St Kitts-Nevis",
			'St. Vincent Grenadines' => "St Vincent &amp; Grenadine",
			'St. Barth' => "St Barthelemy",
			'Cabo Verde' => "Cape Verde",
			'CAR' => "Central African Republic",
			'Saint Pierre Miquelon' => "St Pierre &amp; Miquelon",
			'Macao' => "Macau",
			'Eswatini' => "Swaziland",
			'Netherlands' => "Netherlands (Holland, Europe)",
			'UAE' => "United Arab Emirates",
			'Montenegro' => "Republic of Montenegro",
			'DRC' => "Democtratic Republic of the Congo",
			'North Macedonia' => "Macedonia",
			'R&eacute;union' => "Reunion",
			'Sao Tome and Principe' => "Sao Tome &amp; Principe",
			'St. Vincent Grenadines' => "St Vincent &amp; Grenadines",
		);
		if ( @$matchCountries[$country] )
			$country = $matchCountries[$country];

		$row = @$countries[$country];
		if ( ! $row ) {
			error_log("flag: no match: $country");
			return(null);
		}
		$code = strtolower($row['code']);
		$flag = "$code.png";
		$imgPath = "../images/flags/$flag";
		if ( ! file_exists($imgPath) ) {
			error_log("flag: no file $flag: $country");
			return(null);
		}
		return($flag);
	}
	/*------------------------------------------------------------*/
	// sort functions = /showBy?by=funcName
	/*------------------------------*/
	private function cmp($a, $b) {
		if ( ! $a )
			$a = 0;
		if ( ! $b )
			$b = 0;
		return($a > $b ? 1 : ( $a < $b ? -1 : 0 ) );
	}
	/*------------------------------*/
	/*------------------------------*/
	private function byCountry($a, $b) {
		return(strcmp($a['country'], $b['country']));
	}
	/*------------------------------*/
	private function byCases($b, $a) {
		return($this->cmp($a['cases'], $b['cases']));
	}
	/*------------------------------*/
	private function byYesterday($b, $a) {
		return($this->cmp($a['yesterday'], $b['yesterday']));
	}
	/*------------------------------*/
	private function byR($b, $a) {
		return($this->cmp($a['R'], $b['R']));
	}
	/*------------------------------*/
	private function byRplus($b, $a) {
		return($this->cmp($a['Rplus'], $b['Rplus']));
	}
	/*------------------------------*/
	private function byToday($b, $a) {
		return($this->cmp($a['today'], $b['today']));
	}
	/*------------------------------*/
	private function byDeaths($b, $a) {
		return($this->cmp($a['deaths'], $b['deaths']));
	}
	/*------------------------------*/
	private function byDeathsYesterday($b, $a) {
		return($this->cmp($a['deathsYesterday'], $b['deathsYesterday']));
	}
	/*------------------------------*/
	private function byVaccinated($b, $a) {
		return($this->cmp($a['vaccinated'], $b['vaccinated']));
	}
	/*------------------------------*/
	private function byVaccinatedToday($b, $a) {
		return($this->cmp($a['vaccinatedToday'], $b['vaccinatedToday']));
	}
	/*------------------------------*/
	private function byVaccinatedYesterday($b, $a) {
		return($this->cmp($a['vaccinatedYesterday'], $b['vaccinatedYesterday']));
	}
	/*------------------------------*/
	private function byVaccinatedRate($b, $a) {
		return($this->cmp($a['vaccinatedRate'], $b['vaccinatedRate']));
	}
	/*------------------------------*/
	private function byVaccinationLastWeekAverage($b, $a) {
		return($this->cmp($a['vaccinationLastWeekAverage'], $b['vaccinationLastWeekAverage']));
	}
	/*------------------------------*/
	private function byVaccinationDaysLeft($b, $a) {
		return($this->cmp($a['vaccinationDaysLeft'], $b['vaccinationDaysLeft']));
	}
	/*------------------------------*/
	private function byDeathsToday($b, $a) {
		return($this->cmp($a['deathsToday'], $b['deathsToday']));
	}
	/*------------------------------*/
	private function byRecovered($b, $a) {
		return($this->cmp($a['recovered'], $b['recovered']));
	}
	/*------------------------------*/
	private function byActive($b, $a) {
		return($this->cmp($a['active'], $b['active']));
	}
	/*------------------------------*/
	private function byCasesRate($b, $a) {
		return($this->cmp($a['casesRate'], $b['casesRate']));
	}
	/*------------------------------*/
	private function byEcasesRate($b, $a) {
		return($this->cmp($a['EcasesRate'], $b['EcasesRate']));
	}
	/*------------------------------*/
	private function byActiveRate($b, $a) {
		return($this->cmp($a['activeRate'], $b['activeRate']));
	}
	/*------------------------------*/
	private function byClosed($b, $a) {
		return($this->cmp($a['closed'], $b['closed']));
	}
	/*------------------------------*/
	private function byPopulation($b, $a) {
		return($this->cmp($a['population'], $b['population']));
	}
	/*------------------------------*/
	private function byCasesDeathRate($b, $a) {
		return($this->cmp($a['casesDeathRate'], $b['casesDeathRate']));
	}
	/*------------------------------*/
	private function byClosedDeathRate($b, $a) {
		return($this->cmp($a['closedDeathRate'], $b['closedDeathRate']));
	}
	/*------------------------------*/
	private function byPopulationDeathRate($b, $a) {
		return($this->cmp($a['populationDeathRate'], $b['populationDeathRate']));
	}
	/*------------------------------------------------------------*/
	private function population($country) {
		if ( $country == 'World' ) {
			$sql = "select sum(population) from populations";
			$worldPopulation = $this->Mmodel->getInt($sql, $this->ttl);
			return($worldPopulation);
		}
		$sql = "select population from populations where country = '$country'";
		$population = $this->Mmodel->getInt($sql, $this->ttl);
		if ( ! $population ) {
			error_log("population: missing: $country");
			return(null);
		}
		return($population);
	}
	/*------------------------------------------------------------*/
	private function metric($country, $date, $metric) {
		static $cache = array();
		if ( ! @$cache[$date] ) {
			$sql = "select * from covid19 where date = '$date'";
			$rows = $this->Mmodel->getRows($sql, $this->ttl);
			$indexed = Mutils::reindexBy($rows, 'country');
			$cache[$date] = $indexed;
		}
		$metric = @$cache[$date][$country][$metric];
		if ( ! $metric ) {
			/*	error_log("metric($country, $date, $metric) - missing");	*/
			return(0);
		}
		return($metric);
	}
	/*------------------------------------------------------------*/
	private function sinces() {

		$sinces = array(
			"2020-01-01",
			"2020-02-01",
			"2020-03-01",
			"2020-04-01",
			"2020-05-01",
			"2020-06-01",
			"2020-07-01",
			"2020-08-01",
			"2020-09-01",
			"2020-10-01",
			"2020-11-01",
			"2020-12-01",
		);
		$thisMonth = date("m");
		for ( $month = 1 ; $month <= $thisMonth ; $month++ )
			$sinces[] = sprintf("2021-%02d-01", $month);
		$sinces[] = "allTime";
		return($sinces);
	}
	/*------------------------------------------------------------*/
	private function weekAverage($country, $prev = false, $what = 'cases', $todayDate = null) {
		if ( ! $todayDate )
			$todayDate = date("Y-m-d");
		$daySecs = 24*3600;
		$numDays = 7;
		if ( $prev ) {
			$todayTime = strtotime($todayDate);
			$startDate = date("Y-m-d", $todayTime - 14*$daySecs);
			$endDate = date("Y-m-d", $todayTime - 8*$daySecs);
		} else {
			// for Rplus - todayDate == tomorrow - take the last 6 days, not incl today.
			$time = time();
			$tomorrow = date("Y-m-d", $time + 24*3600);
			if ( $todayDate == $tomorrow ) {
				$startDate = date("Y-m-d", $time - 6*$daySecs);
				$endDate = date("Y-m-d", $time - 1*$daySecs);
				$numDays = 6;
			} else {
				$todayTime = strtotime($todayDate);
				$startDate = date("Y-m-d", $todayTime - 7*$daySecs);
				$endDate = date("Y-m-d", $todayTime - 1*$daySecs);
			}
		}
		if ( $country == 'World' ) {
			$startSql = "select sum($what) from covid19 where date = '$startDate'";
			$endSql = "select sum($what) from covid19 where date = '$endDate'";
		} else {
			$countryCond = "country = '$country'";
			$startSql = "select $what from covid19 where date = '$startDate' and $countryCond";
			$endSql = "select $what from covid19 where date = '$endDate' and $countryCond";
		}
		$startTotal = $this->Mmodel->getInt($startSql, $this->ttl);
		$endTotal = $this->Mmodel->getInt($endSql, $this->ttl);
		$total = $endTotal - $startTotal ;
		$weekAverage = $total / $numDays ;
		if ( $country == 'Israel' ) {
			$prData = array(
				'country' => $country,
				'prev' => $prev,
				'what' => $what,
				'todayDate' => $todayDate,
				'startDate' => $startDate,
				'endDate' => $endDate,
				'numDays' => $numDays,
				'startSql' => $startSql,
				'endSql' => $endSql,
				'startTotal' => $startTotal,
				'endTotal' => $endTotal,
				'total' => $total,
				'weekAverage' => $weekAverage,
			);
			/*	Mview::print_r($prData, "prData", basename(__FILE__), __LINE__, null, false);	*/
		}
		return($weekAverage);
	}
	/*------------------------------------------------------------*/
	private function Rplus($country) {
		$tomorrow = date("Y-m-d", time() + 24*3600);
		$prevWeekAverage = $this->weekAverage($country, true, 'cases', $tomorrow);
		$thisWeekAverage = $this->weekAverage($country, false, 'cases', $tomorrow);
		if ( ! $prevWeekAverage )
			return(null);
		$Rplus = $thisWeekAverage / $prevWeekAverage ;
		$Rplus = pow($Rplus, 4/7.0);
		return($Rplus);
	}
	/*------------------------------------------------------------*/
	private function R($country, $todayDate = null) {
		$prevWeekAverage = $this->weekAverage($country, true, 'cases', $todayDate);
		$thisWeekAverage = $this->weekAverage($country, false, 'cases', $todayDate);
		if ( ! $prevWeekAverage )
			return(null);
		$R = $thisWeekAverage / $prevWeekAverage ;
		$R = pow($R, 4/7.0);
		return($R);
	}
	/*------------------------------------------------------------*/
}
