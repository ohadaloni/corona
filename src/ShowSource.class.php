<?php
/*------------------------------------------------------------*/
class ShowSource extends Corona {
	/*------------------------------------------------------------*/
	public function index() {
		$file = @$_REQUEST['file'];
		if ( $file )
			$source = highlight_file($file, true);
		$this->Mview->showTpl("showSource/showSource.tpl", array(
			'files' => $this->fileList(),
			'sourceFile' => $file,
			'source' => @$source,
		));
	}
	/*------------------------------------------------------------*/
	private function fileList() {
		$files = preg_split('/\s+/', `ls ../M/*.php *.php tpl/*.tpl tpl/*/*.tpl | egrep -v 'Old'`);
		array_pop($files);
		return($files);
	}
	/*------------------------------------------------------------*/
}
/*------------------------------------------------------------*/
