<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-14 01:43:44
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-12-11 05:57:05
 */
class Dorking extends DesploitsModules
{
	public function anti($data){
		if(preg_match("/blogspot|live|msn|bing|microsoft|/", $data)){
			return true;
		}else{
			return false;
		}
	}
	public function repairURL($urls){
		$url = parse_url($urls);
		return (!isset($url["scheme"]) ? "http://".$urls : $url["scheme"]."://".$url["host"]);
	}
	public function end($data){
		$count_before = count($data);
		$count_after  = count(array_unique($data));
		$data 		  = array_unique($data);
		return array('count_before' => $count_before, 'count_after' => $count_after, 'data' => $data);
	}
	public function search($dork,$nameSave){
		$dork = urlencode($dork);
		/*
			::::::: Yahoo :::::::
		*/
		echo "\r\n[Dorking] Search ".$dork." in Yahoo\r\n";
		for ($i=1;$i<=1000;$i+=10) { 
			$search  = $this->sdata("http://search.yahoo.com/search?p=".$dork."&b=".$i ,  null , true);
			preg_match_all('/<a class=" ac-algo ac-21th lh-24" href="(.*?)"/m', $search[data] , $m);
			foreach (array_unique($m[1]) as $key => $linked) {
				$dumpURL[] = $this->repairURL($linked);
			}
			echo "[Dorking][".$i."]-- Woot ".count(array_unique($dumpURL))." in Yahoo\r\n";
		}

		/*
			::::::: Bing :::::::
		*/
		echo "\r\n[Dorking] Search ".$dork." in Bing\r\n";
		for ($i=1;$i<=1000;$i+=10) { 
			$search  = $this->sdata("http://www.bing.com/search?q=".$dork."&go=Submit&qs=n&sc=8-6&sp=-1&sk=&cvid=5FBDA739A23C42ADAA081DC9606BF316&first=".$i."&FORM=PERE2" ,  null , true);
			preg_match_all('/<li class="b_algo"><h2><a href="(.*?)"/' , $search[data] , $m);
			foreach (array_unique($m[1]) as $key => $linked) {
				$dumpURL[] = $this->repairURL($linked);
			}
			echo "[Dorking][".$i."]-- Woot ".count(array_unique($dumpURL))." in Bing\r\n";
		}

		/*
			::::::: Dogpile :::::::
		*/
		echo "\r\n[Dorking] Search ".$dork." in Dogpile\r\n";
		for ($i=1;$i<=1000;$i+=10) { 
			$search  = $this->sdata("http://www.dogpile.com/info.dogpl/search/web?qsi=".$i."&q=".$dork ,  null , true);
			preg_match_all('/data-icl-cop="results-main" href="(.*?)"/', $search[data] , $m);
			foreach ($m[1] as $key => $dogpileURL) {
				preg_match_all('/&ru=(.*?)&/', urldecode(urldecode(urldecode($dogpileURL))) , $tempDogpile);
				$dumpURL[] = $this->repairURL($tempDogpile[1][0]);
			}	
			echo "[Dorking][".$i."]-- Woot ".count(array_unique($dumpURL))." in Dogpile\r\n";
		}
		/*
			::::::: Google APIs :::::::
		*/
		echo "\r\n[Dorking] Search ".$dork." in Google APIs\r\n";
		for ($i=1;$i<=1000;$i+=10) { 
			$search  = $this->sdata("https://www.googleapis.com/customsearch/v1element?key=AIzaSyCVAXiUzRYsML1Pv6RwSG1gunmMikTzQqY&rsz=large&num=8&hl=en&start=".$i."&cx=005531940451544459472:_wxzudlmale&q=".$dork ,  null , true);
			$search[data] = json_decode($search[data],true);
			foreach ($search[data][results] as $key => $value) {
				$dumpURL[] = $this->repairURL($value[unescapedUrl]);
			}
			echo "[Dorking][".$i."]-- Woot ".count(array_unique($dumpURL))." in APIs\r\n";
		}
		$endData = $this->end($dumpURL);
		echo "\r\n[Dorking]--: Total woot : ".$endData[count_before]."\r\n";
		echo "[Dorking]--: Total (RM duplicate) : ".$endData[count_after]."\r\n";
		foreach ($endData[data] as $key => $urlEND) {
			$this->savehypertext($urlEND."\r\n","result/".$nameSave); 
		}
		echo "Output file 'result/".$nameSave.".txt\r\n";
	}
	public function run(){
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

 
