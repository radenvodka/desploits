<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-10 19:58:10
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-11-14 01:47:56
 */

/** Package **/
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
		echo "              |_|                   --help\r\n";
		echo "  --------------------------------------  \r\n";
		echo "  Web Application Vulnerability Scanners  \r\n";
		echo "  --------------------------------------  \r\n\n";
	}
	public function DesploitsHelp()
	{
		$tools = array(
			'',
		);
 		echo " Example: php desploits.php {tools} --run\r\n";
 		echo " Usage  : {tools} --run\r\n\n";
        echo " Tools  : - adminfinder\r\n";
        echo "          - shellfinder\r\n";
        echo "          - portscanner\r\n";
        echo "          - md5cracker\r\n";
        echo "\n";
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

/** Command List **/
if($Command[input][1] == "--help"){
	$DesploitsLoad->DesploitsHelp();
}

if($Command[input][1] == "adminfinder" && $Command[input][2] == "--run"){
	require_once("tools/tools.load.php");
	$AdminFinder->run();
}
if($Command[input][1] == "portscanner" && $Command[input][2] == "--run"){
	require_once("tools/tools.load.php");
	$Portscanner->run();
}
if($Command[input][1] == "md5cracker" && $Command[input][2] == "--run"){
	require_once("tools/tools.load.php");
	$Md5Cracker->run();
}
if($Command[input][1] == "shellfinder" && $Command[input][2] == "--run"){
	require_once("tools/tools.load.php");
	$Shellfinder->run();
}

require_once("tools/tools.load.php");
$Dorking->run();