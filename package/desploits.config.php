<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-10 20:01:39
 * @Last Modified by:   Logika Galau
 * @Last Modified time: 2016-11-10 20:48:21
*/
error_reporting(0);
class DesploitsConfig
{
	public function load($load){
		$config = array(
			'version' => '1.0.3', 
		);
		return $config[$load];
	}
}
