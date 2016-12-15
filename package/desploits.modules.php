<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-10 20:01:02
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-12-15 08:35:16
 */
class DesploitsModules 
{
	public function checkOS(){
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			return true; // is Windows
		} else {
			return false; // is Linux
		}
	}
	public function checkFile($files){
		if(!file_exists($files) ){
			echo "[i]  File not Found\r\n";
			exit();
		}
	}
	public function delimiter($data){
                if( $this->checkOS() ){
                        $delimiter = "\r\n"; 
                }else{
                        $delimiter = "\n";
                }
                return explode($delimiter, $data);
        }
        public function customdelimiter($data,$delimiter){
                return explode($delimiter, $data);
        }
	public function loadfile($files){
		$this->checkFile($files);
		$file = file_get_contents($files);
		$data = $this->delimiter($file);
		return array(
			'total' => count($data),
			'data'  => $data
		);
	}
        public function customloadfile($files,$delimiter){
                $this->checkFile($files);
                $file = file_get_contents($files);
                $data = $this->customdelimiter($file,$delimiter);           
                return array(
                        'total' => count($data),
                        'data'  => $data
                );
        }
        public function stuck($msg){
                echo $msg;
                $answer =  rtrim( fgets( STDIN ));
                return $answer;
        }
	public function sdata($url , $custom , $delCookies = null){
                if($delCookies != null){
                        unlink("cookies.txt");
                }
        	$ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                if($custom[uagent]){
                	curl_setopt($ch, CURLOPT_USERAGENT, $custom[uagent]);
                }else{
        			curl_setopt($ch, CURLOPT_USERAGENT, "msnbot/1.0 (+http://search.msn.com/msnbot.htm)");
                }
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
                if($custom[rto]){
                	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                }else{
                	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                }
                if($custom[header]){
                	curl_setopt($chlogin, CURLOPT_HTTPHEADER, $custom[header]);
                }
                curl_setopt($ch, CURLOPT_COOKIEJAR,  getcwd()."/cookies.txt");
                curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd()."/cookies.txt");
                curl_setopt($ch, CURLOPT_VERBOSE, false);
                if($custom[post]){
                	if(is_array($custom[post])){
                		$query = http_build_query($custom[post]);
                        }else{
                		$query = $custom[post];
                	}
                	curl_setopt($ch, CURLOPT_POST, true);
                	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
                }
                $data           = curl_exec($ch);
                $httpcode       = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                return array(
                	'data' 		=> $data,
                	'httpcode' 	=> $httpcode, 
                );
	}
        public function debug($data){
                unlink("debug.html");
                $this->saves($data,"debug.html");
                exit();
        }
        //*** format saves ***//
        public function saves($data,$name){
                mkdir("report");
                mkdir("result");
                mkdir("result/phising");
                mkdir("result/phising/facebook");
                mkdir("result/phising/twitter");
                $fdo = fopen($name , "a+");
                if(!$fdo) die("Can't open files");
                fwrite($fdo, $data);
                fclose($fdo);
                return $name;
        }
        public function saveHTML($uRL,$name){
                $format = '<a href="'.$uRL.'" target="_blank">'.$uRL.'</a><br>';
                $this->saves($format,$name.".html");
        }
        public function savehypertext($uRL,$name){
                return $this->saves($uRL,$name.".txt");
        }
}