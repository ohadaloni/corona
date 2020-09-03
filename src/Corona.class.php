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
		$this->ttl = 300;
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
		$a = '<br /><br /><a name="viewSource"><h4>PHP Source Code</h4></a><br />';
		$this->Mview->pushOutput($a);
		$src = highlight_file(__FILE__, true);
		$this->Mview->pushOutput($src);
		$this->Mview->showTpl("footer.tpl");
		$this->Mview->showTpl("foot.tpl");
	}
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	public function index() {
		$this->showBy();
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
			'testsYesterday' => Mutils::arraySum($rows, "testsYesterday"),
			'deathsToday' => Mutils::arraySum($rows, "deathsToday"),
			'recovered' => Mutils::arraySum($rows, "recovered"),
			'tests' => Mutils::arraySum($rows, "tests"),
			'yActive' => Mutils::arraySum($rows, "yActive"),
			'activeDelta' => Mutils::arraySum($rows, "activeDelta"),
		);
		$this->ammendRow($totals);
		$totals['growth'] = ($totals['yesterday']/$totals['dbyCases']) * 100;
		$totals['doubles'] = $this->doubles($totals['growth']);
		$totals['deathsGrowth'] = ($totals['deathsYesterday']/$totals['dbyDeaths']) * 100;
		$totals['deathsDoubles'] = $this->doubles($totals['deathsGrowth']);
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
	private function getRows() {
		$date = date("Y-m-d");
		$mkey = "getRows-$date";
		$rows = $this->Mmemcache->get($mkey);
		if ( $rows )
			return($rows);
		$sql = "select * from covid19 where date = '$date'";
		$rows = $this->Mmodel->getRows($sql, $this->ttl);
		/*	$rows = $this->Mmodel->getRows($sql);	*/
		if ( ! $rows ) {
			return(null);
		}
		$this->ammendRows($rows);
		$this->Mmemcache->set($mkey, $rows, $this->ttl);
		return($rows);
	}
	/*------------------------------------------------------------*/
	private function ammendRows(&$rows) {
		foreach ( $rows as $key => $row )
			$this->ammendRow($rows[$key]);
	}
	/*------------------------------*/
	private function ammendRow(&$row) {
		$dby = date("Y-m-d", time() - 2*24*3600);
		$yesterday = date("Y-m-d", time() - 24*3600);
		$country = $row['country'];
		if ( $country != 'World' ) {
			$row['dbyCases'] = $this->metric($country, $dby, 'cases');
			$row['yCases'] = $this->metric($country, $yesterday, 'cases');
			$row['yRecovered'] = $this->metric($country, $yesterday, 'recovered');
			$row['dbyRecovered'] = $this->metric($country, $dby, 'recovered');
			$row['dbyDeaths'] = $this->metric($country, $dby, 'deaths');
			$row['yDeaths']  = $this->metric($country, $yesterday, 'deaths');
			$row['yClosed'] = $row['yRecovered'] + $row['yDeaths'];
			$row['dbyClosed'] = $row['dbyRecovered'] + $row['dbyDeaths'];
			$row['dbyTests'] = $this->metric($country, $dby, 'tests');
			$row['yTests'] = $this->metric($country, $yesterday, 'tests');

			$row['yesterday'] = $row['yCases'] - $row['dbyCases'];
			$row['growth'] = $row['dbyCases'] ? ($row['yesterday']/$row['dbyCases']) * 100 : 0;
			$row['doubles'] = $this->doubles($row['growth']);
			$row['today'] = $row['cases'] - $row['yCases'];
			$row['closed'] = $row['recovered'] + $row['deaths'];
			$row['active'] = $row['cases'] - $row['closed'];
			$row['dbyActive'] = $row['dbyCases'] - $row['dbyClosed'];
			$row['yActive'] = $row['yCases'] - $row['yClosed'];
			$row['activeDelta'] = $row['yActive'] - $row['dbyActive'];
			$row['deathsYesterday'] = $row['yDeaths']- $row['dbyDeaths'];
			$row['testsYesterday'] = $row['yTests'] - $row['dbyTests'];
			$row['deathsGrowth'] = $row['dbyDeaths'] ? ($row['deathsYesterday']/$row['dbyDeaths']) * 100 : 0;
			$row['deathsDoubles'] = $this->doubles($row['deathsGrowth']);
			$row['deathsToday'] = $row['deaths'] - $row['yDeaths'];
			/*	Mview::print_r($row, "row", basename(__FILE__), __LINE__, null, false);	*/
		}

		$row['closed'] = $row['recovered'] + $row['deaths'];
		$row['active'] = $row['cases'] - $row['closed'];
		$row['casesDeathRate'] =
			$row['cases'] ?
				( $row['deaths'] / $row['cases'] ) * 100
				: 0;
		$row['closedDeathRate'] =
			$row['closed'] ?
				( $row['deaths'] / $row['closed'] ) * 100
				: 0;
		$population = $this->population($row['country']);
		if ( $population ) {
			$row['population'] = $population ;
			$row['casesRate'] = 
				( $row['cases'] / $population ) * 100 ;
			$row['EcasesRate'] = $row['casesRate'] * 10 ;
			$row['activeRate'] = 
				( $row['active'] / $population ) * 100 ;
			$row['populationDeathRate'] =
				( $row['deaths'] / $population ) * 100 ;
			$row['EpopulationDeathRate'] = $row['populationDeathRate'] / 10 ;
			$row['testRate'] = 
				( $row['tests'] / $population ) * 100 ;
		} else {
			$row['population'] = 0 ;
			$row['populationDeathRate'] = 0;
			$row['EpopulationDeathRate'] = 0;
			$row['casesRate'] = 0;
			$row['EcasesRate'] = 0;
			$row['activeRate'] = 0;
			$row['testRate'] = 0;
		}
	}
	/*------------------------------------------------------------*/
	// sort functions = /showBy?by=funcName
	/*------------------------------*/
	private function cmp($a, $b) {
		return($a > $b ? 1 : ( $a < $b ? -1 : 0 ) );
	}
	/*------------------------------*/
	/*------------------------------*/
	private function byCountry($b, $a) {
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
	private function byGrowth($b, $a) {
		return($this->cmp($a['growth'], $b['growth']));
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
	private function byTestsYesterday($b, $a) {
		return($this->cmp($a['testsYesterday'], $b['testsYesterday']));
	}
	/*------------------------------*/
	private function byDeathsGrowth($b, $a) {
		return($this->cmp($a['deathsGrowth'], $b['deathsGrowth']));
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
	private function byActiveDelta($b, $a) {
		return($this->cmp($a['activeDelta'], $b['activeDelta']));
	}
	/*------------------------------*/
	private function byYactive($b, $a) {
		return($this->cmp($a['yActive'], $b['yActive']));
	}
	/*------------------------------*/
	private function byCasesRate($b, $a) {
		return($this->cmp($a['casesRate'], $b['casesRate']));
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
	private function byTestRate($b, $a) {
		return($this->cmp($a['testRate'], $b['testRate']));
	}
	/*------------------------------*/
	private function byTests($b, $a) {
		return($this->cmp($a['tests'], $b['tests']));
	}
	/*------------------------------*/
	private function byPopulationDeathRate($b, $a) {
		return($this->cmp($a['populationDeathRate'], $b['populationDeathRate']));
	}
	/*------------------------------------------------------------*/
	private function population($country) {
		if ( $country == 'World' )
			return($this->worldPopulation());
		$sql = "select population from populations where country = '$country'";
		$population = $this->Mmodel->getInt($sql, $this->ttl);
		if ( ! $population ) {
			error_log("population: missing: $country");
			return(null);
		}
		return($population);
	}
	/*------------------------------------------------------------*/
	private function qpsKeys() {
		return(array(
			array(
				'title' => 'this second',
				'key' => "qps-".date("Y-m-d H:i:s"),
				'ttl' => 3,
			),
			array(
				'title' => 'this minute',
				'key' => "qpm-".date("Y-m-d H:i"),
				'ttl' => 70,
			),
			array(
				'title' => 'this hour',
				'key' => "qph-".date("Y-m-d H"),
				'ttl' => 3700,
			),
			array(
				'title' => 'today',
				'key' => "qpd-".date("Y-m-d"),
				'ttl' => 25*3600,
			),
		));
	}
	/*------------------------------------------------------------*/
	private function worldPopulation() {
		$key = "worldPopulation";
		$worldPopulation = $this->Mmemcache->get($key);
		if ( $worldPopulation )
			return($worldPopulation);
		$worldPopulation = $this->scrapeWorldPopulation();
		$this->Mmemcache->set($key, $worldPopulation, 900);
		return($worldPopulation);
	}
	/*------------------------------------------------------------*/
	private function scrapeWorldPopulation() {
		return(7.8*1000*1000*1000);
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
	private function doubles($growth) {
		if ( $growth == 0 )
			return(0);
		if ( $growth > 100 )
			return(0);
		$base = 1 + $growth/100;
		if ( $base <= 1.0 )
			return(0);
		$numdays = 1;
		$double = $base;
		while ( $double < 2 ) {
			$double = $double * $base;
			$numdays++;
		}
		return($numdays);
	}
	/*------------------------------------------------------------*/
}
