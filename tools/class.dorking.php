<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-14 01:43:44
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-11-18 18:21:19
 */
class Dorking extends DesploitsModules
{
	function anti($data){
		if(preg_match("/blogspot|live|msn|bing|microsoft|/", $data)){
			return true;
		}else{
			return false;
		}
	}
	function repairURL($urls){
		$url = parse_url($urls);
		return (!isset($url["scheme"]) ? "http://".$urls : $url["scheme"]."://".$url["host"]);
	}
	function search($dork,$nameSave){
		/*
			::::::: YAHOO :::::::
		*/
		echo "[Dorking] Search ".$dork." in Yahoo\r\n";

		for ($i=1;$i<=1000;$i+=10) { 
			$search  = $this->sdata("http://search.yahoo.com/search?p=".$dork."&b=".$i ,  null , true);
			preg_match_all('/<a class=" ac-algo ac-21th lh-24" href="(.*?)"/m', $search[data] , $m);
			foreach (array_unique($m[1]) as $key => $linked) {
				$dumpURL[] = $this->repairURL($linked);
			}
			echo "[Dorking][".$i."]-- Woot ".count(array_unique($dumpURL))." in Yahoo\r\n";
		}
		print_r(array_unique($dumpURL));
	}
	function run(){
		$option = $this->stuck("[Dorking] Single Dork / File List Dork : ");
		$name 	= $this->stuck("[Dorking] Save filename : ");
		if(file_exists($option)){
			$dorkList = $this->loadfile($option);
			foreach ($dorkList as $key => $isDork) {
				$this->search($isDork,$name);
			}
		}else{
			$this->search($option,$name);
		}
	}
}

 
