<?php
class DesploitsUpdate
{
	public function loadURL($var){
		return $this->url = $var;
	}
	public function update(){
		/*************** Load class ***************/
		require_once("package/desploits.config.php");
		$DesploitsConfig = new DesploitsConfig; 
		//-------------------------------------------//
		$DesploitsConfig->load("version");

		



	}
}
$DesploitsUpdate = new DesploitsUpdate;
$DesploitsUpdate->loadURL("http://ekasyahwan.github.io/version/desploits-update.json");
$DesploitsUpdate->update();