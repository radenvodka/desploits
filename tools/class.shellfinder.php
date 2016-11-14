<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-14 01:04:30
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-11-14 01:13:09
 */
class Shellfinder extends DesploitsModules
{
	function check($site,$list){
		foreach ($list as $key => $patch) {
			$patch 		= trim($patch);
			$uRL 		= $site.$patch;
			$httpCode 	= $this->sdata($uRL , null , true)[httpcode];
			if($httpCode == "200"){
				echo "[Shell Finder][".$key."/".count($list)."] Site : ".$uRL." ( Found )\r\n";
				$report[] = $uRL."\r\n";
			}else{
				echo "[Shell Finder][".$key."/".count($list)."] Site : ".$uRL." ( Not Found )\r\n";
			}
		}
		if($report){
			$name = $this->stuck("[Shell Finder] Scan done! save filename : ");
			foreach ($report as $key => $revalue) {
				$this->savehypertext($revalue,"report/".$name);
			}
			echo "[Shell Finder] fetched data logged to files under 'report/".$name."'\r\n";
		}
	}
	function run()
	{
		$uRL  = $this->stuck("[Shell Finder] uRL Target (ex:http://localhost/): ");
		$load = $this->loadfile("database/shellfinder/dictionary.txt");
		$this->check($uRL,$load[data]);
	}
}