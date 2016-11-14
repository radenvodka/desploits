<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-13 23:31:16
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-11-14 00:07:09
 */
class Portscanner extends DesploitsModules
{
	function Portcheck($host,$port)
	{
		if(@fsockopen($host, $port , $errno, $errstr, 0.1)){
        	return true;
    	}else{
      		return false;
    	}
	}
	public function run(){
		$host  = $this->stuck("[Port Scanner] Host (ex:localhost or 127.0.0.1): ");
		$from  = $this->stuck("[Port Scanner] Start port : ");
		$to  = $this->stuck("[Port Scanner] End port   : ");
		if (empty($host) || empty($from) || empty($to)){
			echo "[Port Scanner][i] Incomplete Data \r\n";
		}elseif (!(filter_var($host, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4))){
			echo "[Port Scanner][i] Invalid IP address \r\n";
	    }elseif (!(is_numeric($from)) || !(is_numeric($to))){
	    	echo "[Port Scanner][i] Entered data is not valid port number\r\n";
	    }elseif ($from > $to || $from==$to){
	    	echo "[Port Scanner][i] Start Range can not be bigger than End Range\r\n";
	    }elseif($to > 65535){
	    	echo "[Port Scanner][i] Maximum Possible Port number is 65535\r\n";
		}else{
			for($port = $from; $port <= $to ; $port++){
				$check = $this->Portcheck($host,$port);
				if($check){
					echo "[Port Scanner] Scan : ".$host.":".$port." (Open Port)\r\n";
					$report[] = $host.":".$port."\r\n";
				}else{
					echo "[Port Scanner] Scan : ".$host.":".$port." (Close Port)\r\n";
				}
			}
			if($report){
			$name = $this->stuck("[Port Scanner] Scan done! save filename : ");
			foreach ($report as $key => $revalue) {
				$this->savehypertext($revalue,"report/".$name);
			}
				echo "[Port Scanner] fetched data logged to files under 'report/".$name."'\r\n";
			}else{
				echo "[Port Scanner] no found for open port\r\n";
			}
		}
	}
}