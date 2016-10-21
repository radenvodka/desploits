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
		$Desploit = array('ver' => '1.0.3');
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
		$this->msg("[Update] Pleas wait ... check for updates");
		$version = json_decode($this->ngecurl("http://ekasyahwan.github.io/version/desploits.json"),true);
		if($myVer < $version[release][version]){
			$this->msg("[Update] Old Version  : ".$myVer);
			$this->msg("[Update] Last Version : ".$version[release][version]." (Release : ".$version[release][date].")");
			$this->msg("[Update] Get New Version ... pleas wait");
			sleep(3);
			foreach ($version[required][dir] as $mdkirs) {
				if(is_dir($mdkirs)){
					$this->msg("[Update] [OK] Create directory ".$mdkirs);
				}else{
					if(mkdir($mdkirs, 0777)){
						$this->msg("[Update] [OK] Create directory ".$mdkirs);
					}else{
						$this->msg("[Update] [FAIL] Create directory ".$mdkirs);
					}
				}
			}
			foreach ($version[required][file] as $file) {
				foreach ($file as $key => $files) {
					$data = $this->ngecurl($version[repository][files].$version[release][version]."/".$files);
					if($data != ""){
						if(unlink($files)){
							$this->msg("[Update] [OK] Removes Files ".$files);
						}
						if( file_put_contents($files , $data) ){
							$this->msg("[Update] [OK] Create files ".$files);
							if($files == "desploits.php"){
								chmod($files,755);
							}
						}else{
							$this->msg("[Update] [FAIL] Create files ".$files);
						}
					}else{
						$this->msg("Pleas Download : http://ekasyahwan.github.io/tools/desploits.php / https://github.com/ekasyahwan/desploits for manual download");
						exit();
					}
				}
			}
			$this->msg("\r\n--------- thanks for updates Desploits ---------");
		}else{
			$this->msg("no update");
		}
	}
}
$desploit 	= new Desploit;
$fadmin 	= new Fadmin;
$wordpress	= new Wordpress;
$md5		= new Md5;
$engine 	= new Engine;
/** call class package **/
$desploit->Covers();
$desploit->requiredDes();
$command  = $desploit->arguments($argv);
?>