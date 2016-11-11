<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-10 19:58:10
 * @Last Modified by:   Logika Galau
 * @Last Modified time: 2016-11-10 20:59:04
 */
require_once("package/desploits.update.php");
require_once("package/desploits.config.php");
require_once("package/desploits.modules.php");


class DesploitsLoad
{
	public function DesploitsCovers()
	{
		echo "     _             _     _ _         		\r\n";
		echo "   _| |___ ___ ___| |___|_| |_ ___   ".DesploitsConfig::load("version")."	\r\n";
		echo "  | . | -_|_ -| . | | . | |  _|_ -|  		\r\n";
		echo "  |___|___|___|  _|_|___|_|_| |___|  		\r\n";
		echo "              |_|                    		\r\n";
		echo "  --------------------------------------  \r\n";
		echo "  Web Application Vulnerability Scanners  \r\n";
		echo "  --------------------------------------  \r\n\n";
	}
	public function arguments($argv) { 
		    $_ARG = array(); 
		    foreach ($argv as $arg) { 
		      if (ereg('--([^=]+)=(.*)',$arg,$reg)) { 
		        $_ARG[$reg[1]] = $reg[2]; 
		      } elseif(ereg('^-([a-zA-Z0-9])',$arg,$reg)) { 
		            $_ARG[$reg[1]] = 'true'; 
		      } else { 
		            $_ARG['input'][]=$arg; 
		      } 
		    } 
	  	return $_ARG; 
	}
}
$DesploitsLoad 		= new DesploitsLoad;
$DesploitsConfig 	= new DesploitsConfig;
$DesploitsModules 	= new DesploitsModules;
$Command 			= $DesploitsLoad->arguments($argv);
$DesploitsLoad->DesploitsCovers();



// Class test //--
//print_r($DesploitsModules->loadfile($Command[input][1])); // command load file

/*
$sdataCustom = array( // command example postdata with curl and custom data 
	'post' => array(
		'username' => 'test',
		'password' => 'test123',
	),
	'rto'  => 30,
	'uagent' => 'msnbot/1.0 (+http://search.msn.com/msnbot.htm)',
	'header' => array('asjsj','asjsj','asjsj','asjsj')
);
$DesploitsModules->sdata("http://google.com" , $sdataCustom );
*/