<?php
/*------------------------------------------------------------*/
require_once("coronaConfig.php");
require_once(M_DIR."/mfiles.php");
require_once("coronaFiles.php");
require_once("Corona.class.php");
/*------------------------------------------------------------*/
global $Mview;
global $Mmodel;
$Mview = new Mview;
$Mmodel = new Mmodel;
$Mview->holdOutput();
/*------------------------------------------------------------*/
$corona = new Corona;
$corona->control();
$Mview->flushOutput();
/*------------------------------------------------------------*/
/*------------------------------------------------------------*/
