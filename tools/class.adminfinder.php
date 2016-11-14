<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-10 21:35:35
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-11-13 23:02:14
 */
class AdminFinder extends DesploitsModules
{
	public function check($site,$list){
		foreach ($list as $key => $patch) {
			$patch 		= trim($patch);
			$uRL 		= $site.$patch;
			$httpCode 	= $this->sdata($uRL , null , true)[httpcode];
			echo "[AdminFinder][".$key."/".count($list)."] Site : ".$uRL." ( ".$httpCode." )\r\n";
			if($httpCode == "200"){
				$report[] = $uRL."\r\n";
			}
		}
		if($report){
			$name = $this->stuck("[AdminFinder] Scan done! save filename : ");
			foreach ($report as $key => $revalue) {
				$this->savehypertext($revalue,"report/".$name);
			}
			echo "[AdminFinder] fetched data logged to files under 'report/".$name."'\r\n";
		}
	} 
	public function run(){
		$uRL = $this->stuck("[AdminFinder] uRL Target (ex:http://localhost/): ");
		$wOrdlist = $this->stuck("[AdminFinder] Wordlist (php/asp/brf/ctm/js/cgi): ");
		switch ($wOrdlist) {
			case 'php':	$list = "php.txt"; 		break;
			case 'asp': $list = "asp.txt"; 		break;
			case 'brf': $list = "brf.txt"; 		break;
			case 'cfm': $list = "cfm.txt"; 		break;
			case 'cgi': $list = "cgi.txt"; 		break;
			case 'js':  $list = "js.txt"; 		break;
			default: echo "[i] no options\r\n"; break;
		}
		$load = $this->customloadfile("database/adminfinder/".$list,",");
		$this->check($uRL,$load[data]);
	}
}