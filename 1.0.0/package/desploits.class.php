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
	function update(){
		$desploits 	= new Modules;
		$version  	= json_decode($desploits->ngecurl("http://ekasyahwan.github.io/version/desploits.json"),true);
		$ver 		= $version[release][version];
		if( $this->Config()['ver'] < $ver ){
			$repofile   = $version[repository][files].$ver."/";
			$desploits->msg("[Update] updates are available");
			$desploits->msg("[Update] Last test   : ".$this->Config()['ver']);
			$desploits->msg("[Update] New version : ".$version[release][version]);
			$desploits->msg("[Update] + Create directory");
			foreach ($version[required][dir] as $key => $value) {
				if( mkdir($value) ){
					$desploits->msg("[Update] > {success} ".$value." Success");
				}else{
					$desploits->msg("[Update] > {failed}  ".$value." Failed");
				}
			}
			$desploits->msg("[Update] + Get & install new files");
			foreach ($version[required][file] as $key => $value) {
				$getFile = $desploits->ngecurl($repofile.$value['name']);
				$getName = $value['name'].".update";
				if($getFile != ""){
					if(file_put_contents($getName , $getFile)){
						$desploits->msg("[Update] >>> {Download} ".$value['name']." | Success");
						if( file_put_contents($value['name'], file_get_contents($getName))){
								$desploits->msg("[Update]   ^ {Installs}  ".$value['name']." | Success");
								unlink($getName);
							}else{
								$desploits->msg("[Update] MD5 File corrupt , pleas manual download https://github.com/ekasyahwan/desploits.");
								exit();
						}
					}
				}else{
					$desploits->msg("[Update] MD5 File corrupt , pleas manual download https://github.com/ekasyahwan/desploits.");
					exit();
				}
			}
			if(count($version[required][remove]) != ""){
			$desploits->msg("[Update] + Remove File");
				foreach ($version[required][remove] as $key => $value) {
					if(unlink($value)){
						$desploits->msg("[Update] > {success} ".$value." Success");
					}
				}
			}
			$desploits->msg("[Update] Done !!! please report it to us for the problems in these tools in our github page https://github.com/ekasyahwan/desploits");
		}else{
			$desploits->msg("[Update] no updates");
		}
	}
}
$desploit 	= new Desploit;
$fadmin 	= new Fadmin;
$wordpress	= new Wordpress;
/** call class package **/
$desploit->Covers();
$command  = $desploit->arguments($argv);
?>