<?php
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