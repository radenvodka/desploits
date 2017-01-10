<?php
/**
 * @Author: Eka Syahwan
 * @Date:   2016-12-15 13:29:13
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2017-01-10 21:38:32
 */
 class Logsanalyzer extends DesploitsModules
 {	
 	public function checkLogs($locate_logs){
 		preg_match_all('/(.*?) - - (.*?) "(.*?) (.*?) (.*?)" (.*?) (.*?) "(.*?)" "(.*?)"/', file_get_contents($locate_logs) , $info);
		foreach ($info[4] as $key => $value) {
			$attacker[] = array(
					'date' 		=> $info[2][$key],
					'ip' 		=> $info[1][$key],
					'request' 	=> $info[3][$key],
					'files' 	=> $info[4][$key],
					'httpcode'  => $info[6][$key],
					'url'	 	=> $info[8][$key], 
					'uagent' 	=> $info[9][$key], 
			);
		}
		return array(
			'total' => count($attacker) , 
			'data' => $attacker
		);
 	}
 	public function detected($files){
 		$file  = file_get_contents($files); 
 		$regex = array(
 			'/eval\(str_rot13\(/' 		=> "eval & rot13 indication backdoors",
 			'/shell_exec/' 				=> "shell_exec indication backdoors",
 			'/\$_COOKIE\[\'b374k\']/' 	=> "b374k Backdoors",
 			'/WSO/' 					=> "wso Backdoors",
 			"/exif_read_data/" 			=> "Images Backdoors Shell",
 			"/tmp_name/" 				=> "Uploader Files",
 		);
 		foreach ($regex as $regexs => $message) {
 			preg_match_all($regexs, $file , $matches);
 			if($matches[0][0]){
 				$notice[] = $message;
 			}
 		}
 		if($notice === null){
 			return array(
				'message' => 'this safes',
				'status'  => false, 
 			);
 		}else{
			return array(
				'message' => $notice,
				'status'  => true, 
 			);
 		}
 	}
 	public function readlogs($array,$public_location){
 		foreach ($array as $key => $value) {
 			$locatefiles = $public_location.str_replace("/", '\\', $value[files]);
 			if(!is_dir($locatefiles)){
 				echo "[--------------------------------------]\r\n";
	 			echo "[ Date Time      | ".$value[date]."\r\n";
	 			echo "[ IP Visitor     | ".$value[ip]."\r\n";
	 			echo "[ Link Access    | ".$value[url]."\r\n";
	 			echo "[ Locate Files   | ".$public_location.str_replace("/", '\\', $value[files])."\r\n";
	 			echo "[ Request Status | ".$value[request]." (".$value[httpcode].")\r\n";
	 			$status = $this->detected($locatefiles);
	 			if($status === false){
	 			echo "[ Status Risk    | ".$status[message]."\r\n";
	 			}else{
	 				echo "[ Status Risk    | ";
		 			foreach ($status[message] as $key => $message) {
		 				if($key === 0){
		 					echo "- ".$message."\r\n";
		 					$is .= "- ".$message."\r\n";
		 				}else{
		 					echo "[                  - ".$message."\r\n";
		 				}
		 			}
		 				$revalue.="[--------------------------------------]\r\n";
			 			$revalue.="[ Date Time      | ".$value[date]."\r\n";
			 			$revalue.="[ IP Visitor     | ".$value[ip]."\r\n";
			 			$revalue.="[ Link Access    | ".$value[url]."\r\n";
			 			$revalue.="[ Locate Files   | ".$public_location.str_replace("/", '\\', $value[files])."\r\n";
			 			$revalue.="[ Request Status | ".$value[request]." (".$value[httpcode].")\r\n";
			 			$revalue.="[ Status Risk    :  \r\n";
			 			$revalue.= $is."\r\n\n";
			 			$reportsave =  $this->savehypertext($revalue,"report/Logsanalyzer-".date("Y-m-d"));
			 			$insave[]   = $reportsave; 
			 			echo "\n\n";
	 			}
 			}else{
 				echo "[--------------------------------------]\r\n";
	 			echo "[ Date Time      | ".$value[date]."\r\n";
	 			echo "[ IP Visitor     | ".$value[ip]."\r\n";
	 			echo "[ Link Access    | ".$value[url]."\r\n";
	 			echo "[ Locate Files   | ".$public_location.str_replace("/", '\\', $value[files])."\r\n";
	 			echo "[ Request Status | ".$value[request]." (".$value[httpcode].")\r\n";
	 			echo "[ Status Risk    | - is directory -\r\n";
 			}
 		}
 		if($insave != null){
 			echo "[Logsanalyzer] report has been saves 'report/Logsanalyzer-".date("Y-m-d").".txt'\r\n";
 		}
 	}
 	public function run(){
 		$locate_logs  		= $this->stuck("[Logsanalyzer] Locate Logs (/var/logs/access.log) : ");
		$locate_public_html = $this->stuck("[Logsanalyzer] Locate Public_HTML (/var/www/html) : ");
		/** execute **/
		if(file_exists($locate_logs)){
			echo "---------------------------------------------------\r\n";
			$log = $this->checkLogs($locate_logs);
			echo "[Logsanalyzer] Total Logs : ".$log[total]."\r\n";
			if(file_exists("report/Logsanalyzer-".date("Y-m-d").".txt") ){
				$ask = $this->stuck("[Logsanalyzer] Removes old report ? [y/n] : ");
				$ask = strtolower($ask);
				if($ask === "y"){
					unlink("report/Logsanalyzer-".date("Y-m-d"));
				}
				$this->readlogs($log[data],$locate_public_html);
			}else{
				$this->readlogs($log[data],$locate_public_html);
			}
		}else{
			echo "[Logsanalyzer] file no exists\r\n";
		}
		
 	}
 }