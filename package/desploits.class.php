<?php
error_reporting(0);
require_once("package/modules.class.php");
require_once("package/fadmin.class.php");
require_once("package/wordpress.class.php");
require_once("package/md5.class.php");
require_once("package/engine.class.php");
class Desploit extends Modules
{
	function Config(){
		$Desploit = array('ver' => '1.0.3','repo' => 'http://ekasyahwan.github.io/version/desploits-update.json');
		return $Desploit;
	}
	function requiredDes(){
		$desploits 	= new Modules;
		if(!curl_version()[version] ){
		 	$desploits->msg("[required] PHP CLI , apt-get install curl\r\n");
		}
		$folder = array('db','package','result','temp');
		foreach ($folder as $key => $genDRI) {
			mkdir($genDRI);
		}
	}
	function ConfigWP(){
		$Desploit = array(
			'grabuser' => '50'
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
        $label = array(
        	'1' => 'Set Url : --url=<url> / --url-list=<list file> <tools> <argv> <argv> ...',
        	'2' => "Tools List    : \r\n"
        );
    	$tools = array(
    		'Fadmin' 	=> '<set url/list> --fadmin=[asp|php|brf|cfm|cgi|js]',
    		'wpbrute'	=> '<set url/list> --wpbrute --setuser={admin|auto} --passlist={optional}',
    		'md5dencry' => '--md5={key/hash} / --md5={hash.txt}',
    		'scraper' 	=> '--scraper --dork={dork/file.txt} --patch / --no-patch'
    	);
    	foreach ($label as $key => $value) {
    		echo $value."\r\n";
    	}
    	foreach ($tools as $key => $value) {
    		echo "<desploits> ".$value."\r\n";
    	}

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
	function update(){
		$myVer = $this->Config()[ver];
		$version = json_decode($this->ngecurl($this->Config()[repo]),true);
		if($myVer < $version[release][version]){
			$this->msg("[Update] Old Version  : ".$myVer);
			$this->msg("[Update] New Version  : ".$version[release][version]);
			$this->msg("[Update] Codename     : ".$version[release][codename]);
			if(isset($version[repository][zip])){
				$zip = "zip";
			}
			if(isset($version[repository][zip])){
				$tar = "tar";
			}
			$input = $this->readline("[desploits] [download] [".(isset($zip) ? $zip:"-")."/".(isset($tar) ? $tar:"-")."]  : ");
			$this->msg("[download] pleas wait... downloading files");
			if($input === "zip"){
				if(file_put_contents(pathinfo($version[repository][zip])[basename],$this->ngecurl($version[repository][zip]))){
					if(file_exists(pathinfo($version[repository][zip])[basename])){
						$this->msg("[download] Download file success , file name : ".pathinfo($version[repository][zip])[basename]);
					}else{
						$this->msg("[download] Download file failed , pleas manual dowload : ".$version[repository][github]);
					}
				}
			}else if($input === "tar"){
				if(file_put_contents(pathinfo($version[repository][tar])[basename],$this->ngecurl($version[repository][tar]))){
					if(file_exists(pathinfo($version[repository][tar])[basename])){
						$this->msg("[download] Download file success , file name : ".pathinfo($version[repository][tar])[basename]);
					}else{
						$this->msg("[download] Download file failed , pleas manual dowload : ".$version[repository][github]);
					}
				}
			}else{
				$this->msg("[Update] incorrect command , pleas manual dowload : ".$version[repository][github]);
				exit();
			}
		}else{
			$this->msg("[Update] no updates");
		}
	}
}
$desploit 	= new Desploit;
$modules 	= new Modules;
$fadmin 	= new Fadmin;
$wordpress	= new Wordpress;
$md5		= new Md5;
$engine 	= new Engine;
/** call class package **/
$desploit->Covers();
$desploit->requiredDes();
$command  = $desploit->arguments($argv);
?>

