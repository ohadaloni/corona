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
		$this->Mview->register_modifier("terse", array("Mutils", "terse",));
	}
	/*------------------------------------------------------------*/
}
/*------------------------------------------------------------*/
