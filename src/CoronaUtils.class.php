<?php
/*------------------------------------------------------------*/
class CoronaUtils extends Mcontroller {
	/*------------------------------------------------------------*/
	/*------------------------------------------------------------*/
	public function prior($controller, $action) {
		$this->Mview->assign(array(
			'controller' => $controller,
			'action' => $action,
		));
		$this->registerFilters();
	}
	/*------------------------------*/
	private function registerFilters() {
		$this->Mview->register_modifier("numberFormat", array("Mutils", "numberFormat",));
		$this->Mview->register_modifier("terse", array("CoronaUtils", "terse",));
		$this->Mview->register_modifier("makeLinks", array("CoronaUtils", "makeLinks",));
	}
	/*------------------------------------------------------------*/
	public static function terse($str, $numWords = 7) {
		$words = explode(" ", $str);
		$cnt = count($words);
		if ( $cnt <= $numWords )
			return($str);
		$words = array_slice($words, 0, $numWords);
		$str = implode(" ", $words)." ...";
		return($str);
	}
	/*------------------------------------------------------------*/
	// from:
	// http://krasimirtsonev.com/blog/article/php--find-links-in-a-string-and-replace-them-with-actual-html-link-tags
	//
	// Sat Nov  3 07:03:32 IST 2018
	// if
	//		{$row.story|nl2br|makeLinks}
	// makeLinks sticks a br in the middle if the link title
	// so try
	// 		{$row.story|makeLinks|nl2br}
	public static function makeLinks($str) {
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		$urls = array();
		$urlsToReplace = array();
		if(preg_match_all($reg_exUrl, $str, $urls)) {
			$numOfMatches = count($urls[0]);
			$numOfUrlsToReplace = 0;
			for($i=0; $i<$numOfMatches; $i++) {
				$alreadyAdded = false;
				$numOfUrlsToReplace = count($urlsToReplace);
				for($j=0; $j<$numOfUrlsToReplace; $j++) {
					if($urlsToReplace[$j] == $urls[0][$i]) {
						$alreadyAdded = true;
					}
				}
				if(!$alreadyAdded) {
					array_push($urlsToReplace, $urls[0][$i]);
				}
			}
			$numOfUrlsToReplace = count($urlsToReplace);
			for($i=0; $i<$numOfUrlsToReplace; $i++) {
				$str = str_replace($urlsToReplace[$i], "<a target=\"_blank\" href=\"".$urlsToReplace[$i]."\">".$urlsToReplace[$i]."</a> ", $str);
			}
			return $str;
		} else {
			return $str;
		}
	}
	/*------------------------------------------------------------*/
}
/*------------------------------------------------------------*/
