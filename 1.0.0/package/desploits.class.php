<?php
error_reporting(0);
require_once("package/modules.class.php");
require_once("package/fadmin.class.php");
require_once("package/wordpress.class.php");
class Desploit
{
	function Config(){
		$Desploit = array('ver' => '1.0.0');
		return $Desploit;
	}
	function ConfigWP(){
		$Desploit = array(
			'grabuser' => '1'
		);
		return $Desploit;
	}
	function Covers(){
		$v 	= $this->Config()['ver'];                                  
		echo "     _             _     _ _         		\r\n";
		echo "   _| |___ ___ ___| |___|_| |_ ___   {$v}	\r\n";
		echo "  | . | -_|_ -| . | | . | |  _|_ -|  		\r\n";
		echo "  |___|___|___|  _|_|___|_|_| |___|  		\r\n";
		echo "              |_|                    		\r\n";
		echo "  --------------------------------------  \r\n";
		echo "  Web Application Vulnerability Scanners  \r\n";
		echo "  --------------------------------------  \r\n\n";
    }
    function help(){
        $command = [
        	"[Set Target] --url={url} / --url-list={list}\r\n",
            "[Admin Page Finder] {set target} --fadmin=[asp|php|brf|cfm|cgi|js]",
            "[wpbrute-wordpress] {set target} --wpbrute --setuser={admin|auto} --passlist={optional}",
        ];
        foreach ($command as $key) {
        	echo "[!]".$key."\r\n";
        }	
        echo "\r\n[!][i] all result in directory 'result'\r\n";
    }
	function arguments($argv) { 
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
$desploit 	= new Desploit;
$fadmin 	= new Fadmin;
$wordpress	= new Wordpress;
/** call class package **/
$desploit->Covers();
$command  = $desploit->arguments($argv);
?>