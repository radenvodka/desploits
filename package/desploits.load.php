<?php
/**
* 
*/
require_once("package/desploits.update.php");
require_once("package/desploits.command.php");
require_once("package/desploits.config.php");
require_once("package/desploits.style.php");
require_once("package/desploits.modules.php");


class DesploitsLoad
{
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

$DesploitsLoad->arguments($argv);
$DesploitsModules->asu();

