<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-10 20:02:13
 * @Last Modified by:   Logika Galau
 * @Last Modified time: 2016-11-10 20:22:19
 */
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